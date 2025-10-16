<?php
namespace App\Services;

use App\Repositories\SubscriptionRepository;
use Carbon\Carbon;
use Exception;

class SubscriptionService
{
    protected $repo;

    public function __construct(SubscriptionRepository $repo)
    {
        $this->repo = $repo;
    }

    public function subscribe($userId, $planId, $billingCycle)
    {
        $plan = $this->repo->getPlanById($planId);
        $active = $this->repo->getActiveSubscription($userId);

        if ($active) {
            return [
                'already_subscribed' => true,
                'subscription' => $active
            ];
        }

        $startDate = now();
        $endDate = $billingCycle === 'yearly'
            ? $startDate->copy()->addYear()
            : $startDate->copy()->addMonth();

        $subscription = $this->repo->createSubscription([
            'user_id' => $userId,
            'plan_id' => $plan->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'billing_cycle' => $billingCycle,
            'status' => 'active',
            'payment_status' => 'paid',
            'auto_renew' => true,
        ]);


        $this->repo->createUsage($subscription->id);

        return [
            'already_subscribed' => false,
            'subscription' => $subscription
        ];
    }

    public function getSubscription($userId)
    {
        return $this->repo->getActiveSubscription($userId);
    }

    public function cancelSubscription($userId)
    {
        $subscription = $this->repo->getActiveSubscription($userId);
        if ($subscription) {
            $this->repo->updateSubscriptionStatus($subscription->id, 'canceled');
            return $subscription;
        }
        throw new Exception("لا يوجد اشتراك نشط لهذا المستخدم");
    }
}

