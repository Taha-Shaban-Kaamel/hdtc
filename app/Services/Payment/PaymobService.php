<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymobService
{
    protected $apiKey;
    protected $iframeId;
    protected $integrationId;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey =  env('PAYMOB_API_KEY');
        $this->iframeId = env('PAYMOB_IFRAME_ID');
        $this->integrationId =  env('PAYMOB_INTEGRATION_ID');
        $this->baseUrl = rtrim( env('PAYMOB_BASE_URL'), '/');
    }

    /**
     * @throws \Exception
     */
    public function authenticate()
    {
        $url = "https://accept.paymob.com/api/auth/tokens";

        $response = Http::post($url, [
            'api_key' => $this->apiKey
        ]);
        if (!$response->successful()) {
            throw new \Exception('Paymob Authentication Failed: ' . $response->body());
        }
        return $response->json('token');
    }

    public function registerOrder($authToken, $merchantOrderId, $amountCents)
    {
        $url = "{$this->baseUrl}/ecommerce/orders";
        $response = Http::withToken($authToken)->post($url, [
            "merchant_order_id" => $merchantOrderId,
            "amount_cents" => $amountCents,
            "currency" => "EGP",
            "items" => []
        ]);
        if (!$response->successful()) {
            throw new \Exception('Paymob Order Failed: ' . $response->body());
        }
        return $response->json('id');
    }

    public function generatePaymentKey($authToken, $orderId, $amountCents, $billingData)
    {
        $url = "{$this->baseUrl}/acceptance/payment_keys";
        $response = Http::withToken($authToken)->post($url, [
            "amount_cents" => $amountCents,
            "expiration" => 3600,
            "order_id" => $orderId,
            "billing_data" => $billingData,
            "currency" => "EGP",
            "integration_id" => $this->integrationId
        ]);
        if (!$response->successful()) {
            throw new \Exception('Paymob Payment Key Failed: ' . $response->body());
        }
        return $response->json('token');
    }

    public function buildIframeUrl($paymentToken): string
    {
        return "https://accept.paymob.com/api/acceptance/iframes/{$this->iframeId}?payment_token={$paymentToken}";
    }
}
