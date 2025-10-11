<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Services\Payment\PaymobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paymob;

    public function __construct(PaymobService $paymob)
    {
        $this->paymob = $paymob;
    }

    /**
     * @throws \Exception
     */
    public function initiatePayment(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        $subscription = Subscription::with('plan', 'user')->findOrFail($request->subscription_id);

        $amount = ($subscription->billing_cycle === 'monthly')
            ? $subscription->plan->price_monthly
            : $subscription->plan->price_yearly;
        $uniqueOrderId = $subscription->id . '-' . time();

        $amountCents = (int) ($amount * 100);
        $authToken = $this->paymob->authenticate();
        $orderId = $this->paymob->registerOrder($authToken, $uniqueOrderId, $amountCents);

        $billingData = [
            "first_name" => $nameParts[0] ?? "Customer",
            "last_name"  => $nameParts[1] ?? "User",
            "email" => $subscription->user->email ?? "customer@example.com",
            "phone_number" => $subscription->user->phone ?? "0100000000",
            "apartment" => "NA",
            "floor" => "NA",
            "street" => "NA",
            "building" => "NA",
            "city" => "Cairo",
            "country" => "EG",
            "state" => "Cairo"
        ];

        $paymentToken = $this->paymob->generatePaymentKey($authToken, $orderId, $amountCents, $billingData);
        $iframeUrl = $this->paymob->buildIframeUrl($paymentToken);

        $subscription->update(['payment_status' => 'pending']);

        return response()->json(['iframe_url' => $iframeUrl]);
    }

    public function callback(Request $request)
    {
        Log::info('Paymob callback:', $request->all());

        $merchantOrderId = $request->input('merchant_order_id');
        $success = $request->boolean('success');

        if ($subscription = Subscription::find($merchantOrderId)) {
            $subscription->update([
                'payment_status' => $success ? 'paid' : 'failed',
                'status' => $success ? 'active' : 'canceled',
            ]);
        }

        return response()->json(['status' => 'processed']);
    }
}
