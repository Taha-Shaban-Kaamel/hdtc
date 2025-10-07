<?php
namespace App\Repositories;

use App\Models\Subscription;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;

class SubscriptionRepository
{
    public function getPlanById($planId)
    {
        return Plan::findOrFail($planId);
    }

    public function getActiveSubscription($userId)
    {
        return Subscription::where('user_id', $userId)
            ->where('status', 'active')
            ->first();
    }

    public function createSubscription(array $data)
    {
        return DB::transaction(function () use ($data) {
            return Subscription::create($data);
        });
    }

    public function createUsage($subscriptionId)
    {
        return \App\Models\SubscriptionUsage::create([
            'subscription_id' => $subscriptionId,
        ]);
    }

    public function updateSubscriptionStatus($subscriptionId, $status)
    {
        return Subscription::where('id', $subscriptionId)
            ->update(['status' => $status]);
    }
}

