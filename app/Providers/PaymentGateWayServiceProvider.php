<?php

namespace App\Providers;

use App\Services\Impl\PayDiSiniServiceImpl;
use App\Services\Impl\TriPayServiceImpl;
use App\Services\PayDiSiniServiceInterface;
use App\Services\TriPayServiceInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PaymentGateWayServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        TriPayServiceInterface::class => TriPayServiceImpl::class,
        PayDiSiniServiceInterface::class => PayDiSiniServiceImpl::class
    ];
    public function provides(): array
    {
        return [
            TriPayServiceInterface::class,
            PayDiSiniServiceInterface::class
        ];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
