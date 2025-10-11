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
                'message' => 'ℹ️ أنت مشترك بالفعل في هذه الخطة ولا يمكنك الاشتراك مجددًا الآن',
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
            //Auth Token
            $authToken = $this->paymob->authenticate();

            //  Register Order
            $merchantOrderId = uniqid('order_'); // رقم فريد محلي
            $orderId = $this->paymob->registerOrder($authToken, $merchantOrderId, $amountCents);

            // 3⃣ Payment Key
            $billingData = [
                "first_name" => $user->first_name ?? "User",
                "last_name" => $user->last_name ?? "Name",
                "email" => $user->email ?? "example@test.com",
                "phone_number" => "01000000000",
                "apartment" => "NA",
                "floor" => "NA",
                "street" => "NA",
                "building" => "NA",
                "shipping_method" => "NA",
                "postal_code" => "NA",
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

            \App\Models\Payment::create([
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
                'message' => '⚠️ فشل في تهيئة عملية الدفع',
                'details' => $e->getMessage()
            ], 500);
        }
    }


    public function callback(Request $request)
    {
        Log::info('📩 Paymob Callback Received', $request->all());
        $data = $request->all();

        if (!$this->isValidHmac($data)) {
            Log::warning('⚠️ Invalid HMAC from Paymob');
            return response()->json([
                'status' => 'error',
                'message' => '🚨 Invalid callback signature',
                'data' => $data
            ], 400);
        }

        $orderId = $data['order'] ?? null;
        $payment = Payment::where('provider_order_id', $orderId)->first();

        if (!$payment) {
            Log::error('⚠️ Payment not found for order', ['order' => $orderId]);
            return response()->json([
                'status' => 'error',
                'message' => '⚠️ لم يتم العثور على سجل الدفع في قاعدة البيانات',
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

            if (is_array($result) && isset($result['already_subscribed']) && $result['already_subscribed']) {
                return response()->json([
                    'status' => 'info',
                    'message' => 'ℹ️ أنت مشترك بالفعل في هذه الخطة',
                    'subscription_id' => $result['subscription']->id,
                    'order_id' => $payment->provider_order_id,
                    'amount' => $payment->amount,
                    'transaction_id' => $payment->transaction_id,
                ], 200);
            }

            $subscription = is_array($result) ? $result['subscription'] : $result;

            return response()->json([
                'status' => 'success',
                'message' => '✅ تم الدفع بنجاح وتم تفعيل الاشتراك',
                'order_id' => $payment->provider_order_id,
                'amount' => $payment->amount,
                'transaction_id' => $payment->transaction_id,
                'subscription_id' => $subscription->id,
            ], 200);
        }

        $payment->update([
            'status' => 'failed',
            'provider_response' => json_encode($data),
        ]);

        return response()->json([
            'status' => 'failed',
            'message' => '❌ فشل الدفع أو تم إلغاؤه من المستخدم',
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
                'message' => '⚠️ لم يتم العثور على الدفع بهذا الرقم',
            ], 404);
        }

        return response()->json([
            'status' => $payment->status,
            'message' => $payment->status === 'paid'
                ? '✅ تم الدفع بنجاح'
                : '❌ لم يتم الدفع بعد',
            'order_id' => $payment->provider_order_id,
            'amount' => $payment->amount,
            'transaction_id' => $payment->transaction_id,
            'updated_at' => $payment->updated_at,
        ]);
    }


}
