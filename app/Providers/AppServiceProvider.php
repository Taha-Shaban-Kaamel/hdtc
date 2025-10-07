<?php

namespace App\Providers;

use App\Repositories\SubscriptionRepository;
use App\Services\SubscriptionService;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
