<?php

namespace App\Providers;

use App\Services\Impl\PanelHostingServiceImpl;
use App\Services\PanelHostingInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PanelHostingProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        PanelHostingInterface::class => PanelHostingServiceImpl::class
    ];

    public function provides(): array
    {
        return [PanelHostingInterface::class];
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
