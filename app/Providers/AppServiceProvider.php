<?php

namespace App\Providers;

use App\Interfaces\PaymentGatewayInterface;
use App\Repositories\SubscriptionRepository;
use App\Services\Payment\PaymobService;
use App\Services\SubscriptionService;
use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Policies\RolePolicy;

class AppServiceProvider extends ServiceProvider 
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SubscriptionService::class, function ($app) {
            return new SubscriptionService(
                $app->make(SubscriptionRepository::class)
            );
        });
        $this->app->bind(Messaging::class, function ($app) {
            $firebase = (new Factory)
                ->withServiceAccount(storage_path(env('FIREBASE_CREDENTIALS')));
            return $firebase->createMessaging();
        });
 

        $this->app->bind(PaymentGatewayInterface::class, PaymobService::class);


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super admin') ? true : null;
        });

        Gate::policy(Role::class, RolePolicy::class);

    }
}
