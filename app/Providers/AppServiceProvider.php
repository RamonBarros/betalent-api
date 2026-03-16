<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Gateways\Adapters\GatewayOneAdapter;
use App\Gateways\Adapters\GatewayTwoAdapter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->tag([
            GatewayOneAdapter::class,
            GatewayTwoAdapter::class,
        ], 'payment-gateways');

        $this->app->bind(\App\Gateways\GatewayManager::class, function ($app) {
        return new \App\Gateways\GatewayManager($app->tagged('payment-gateways'));
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
