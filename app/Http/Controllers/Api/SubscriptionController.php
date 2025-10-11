<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Http\Resources\SubscriptionResource;

class SubscriptionController extends Controller
{
    protected $service;

    public function __construct(SubscriptionService $service)
    {
        $this->service = $service;
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'user_id' => 'nullable|exists:users,id',
            'billing_cycle' => 'required|in:monthly,yearly',
        ]);

        try {
            $userId = $request->user_id ?? Auth::id();
            if (!$userId) {
                throw new \Exception("User ID is required when not authenticated");
            }
            $subscription = $this->service->subscribe(
                $userId,
                $request->plan_id,
                $request->billing_cycle
            );

            return new SubscriptionResource($subscription);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getSubscription(Request $request)
    {
        $subscription = $this->service->getSubscription(Auth::id());

        if ($subscription) {
            return new SubscriptionResource($subscription);
        }

        return response()->json(['message' => 'لا يوجد اشتراك نشط'], 404);
    }

    public function cancelSubscription(Request $request)
    {
        try {
            $subscription = $this->service->cancelSubscription(Auth::id());
            return new SubscriptionResource($subscription);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
