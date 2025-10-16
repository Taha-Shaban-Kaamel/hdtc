<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Payment\PaymobService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paymob;
    protected $subscription;

    public function __construct(PaymobService $paymob, SubscriptionService $subscription)
    {
        $this->paymob = $paymob;
        $this->subscription = $subscription;
    }


    public function createPayment(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        $user = $request->user();

        $activeSubscription = app(\App\Repositories\SubscriptionRepository::class)
            ->getActiveSubscription($user->id);

        if ($activeSubscription) {
            return response()->json([
                'status' => 'info',
                'message' => 'You already have an active subscription for this plan.',
                'subscription_id' => $activeSubscription->id,
                'plan_id' => $activeSubscription->plan_id,
                'end_date' => $activeSubscription->end_date,
            ], 200);
        }

        $plan = \App\Models\Plan::findOrFail($request->plan_id);
        $amount = $request->billing_cycle === 'yearly'
            ? $plan->price_yearly
            : $plan->price_monthly;

        $amountCents = $amount * 100;

        try {
            $authToken = $this->paymob->authenticate();
            $merchantOrderId = uniqid('order_');
            $orderId = $this->paymob->registerOrder($authToken, $merchantOrderId, $amountCents);

            $billingData = [
                "first_name" => $user->first_name ?? "User",
                "last_name" => $user->last_name ?? "Name",
                "email" => $user->email ?? "example@test.com",
                "phone_number" => "01000000000",
                "apartment" => "N/A",
                "floor" => "N/A",
                "street" => "N/A",
                "building" => "N/A",
                "shipping_method" => "N/A",
                "postal_code" => "N/A",
                "city" => "Cairo",
                "country" => "EG",
                "state" => "Cairo"
            ];

            $paymentToken = $this->paymob->generatePaymentKey(
                $authToken,
                $orderId,
                $amountCents,
                $billingData
            );

            $iframeUrl = $this->paymob->buildIframeUrl($paymentToken);

            Payment::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount' => $amount,
                'currency' => 'EGP',
                'status' => 'pending',
                'provider_order_id' => $orderId,
            ]);

            return response()->json([
                'status' => 'pending',
                'payment_url' => $iframeUrl,
                'order_id' => $orderId,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to initialize payment.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        Log::info('Paymob Callback Received', $request->all());
        $data = $request->all();

        if (!$this->isValidHmac($data)) {
            Log::warning('Invalid HMAC from Paymob');
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid callback signature.',
                'data' => $data
            ], 400);
        }

        $orderId = $data['order'] ?? null;
        $payment = Payment::where('provider_order_id', $orderId)->first();

        if (!$payment) {
            Log::error('Payment not found for order', ['order' => $orderId]);
            return response()->json([
                'status' => 'error',
                'message' => 'Payment record not found.',
                'order_id' => $orderId,
            ], 404);
        }

        if ($data['success'] === 'true' || $data['success'] === true) {
            $payment->update([
                'status' => 'paid',
                'transaction_id' => $data['id'],
                'provider_response' => json_encode($data),
            ]);

            $result = app(\App\Services\SubscriptionService::class)->subscribe(
                $payment->user_id,
                $payment->plan_id,
                $payment->billing_cycle ?? 'monthly'
            );

            $subscription = is_array($result) ? $result['subscription'] : $result;

            if ($subscription) {
                $subscription->update([
                    'payment_status' => 'paid',
                    'status' => 'active',
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Payment successful and subscription activated.',
                'order_id' => $payment->provider_order_id,
                'amount' => $payment->amount,
                'transaction_id' => $payment->transaction_id,
                'subscription_id' => $subscription->id ?? null,
            ], 200);
        }

        $payment->update([
            'status' => 'failed',
            'provider_response' => json_encode($data),
        ]);

        return response()->json([
            'status' => 'failed',
            'message' => 'Payment failed or canceled by user.',
            'order_id' => $payment->provider_order_id,
            'amount' => $payment->amount,
        ], 200);
    }
    private function isValidHmac(array $data): bool
    {
        if (!isset($data['hmac'])) {
            return false;
        }

        $secret = env('PAYMOB_HMAC_SECRET');

        $fields = [
            'amount_cents', 'created_at', 'currency', 'error_occured',
            'has_parent_transaction', 'id', 'integration_id', 'is_3d_secure',
            'is_auth', 'is_capture', 'is_refunded', 'is_standalone_payment',
            'is_voided', 'order', 'owner', 'pending',
            'source_data_pan', 'source_data_sub_type', 'source_data_type',
            'success'
        ];

        $concatenated = '';
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $value = is_bool($data[$field])
                    ? ($data[$field] ? 'true' : 'false')
                    : (string)$data[$field];
                $concatenated .= $value;
            }
        }

        $calculated = hash_hmac('sha512', $concatenated, $secret);

        return strtolower($calculated) === strtolower($data['hmac']);
    }

    public function getStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required'
        ]);

        $payment = Payment::where('provider_order_id', $request->order_id)->first();

        if (!$payment) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Payment not found.',
            ], 404);
        }

        return response()->json([
            'status' => $payment->status,
            'message' => $payment->status === 'paid'
                ? 'Payment completed successfully.'
                : 'Payment not completed yet.',
            'order_id' => $payment->provider_order_id,
            'amount' => $payment->amount,
            'transaction_id' => $payment->transaction_id,
            'updated_at' => $payment->updated_at,
        ]);
    }
}
