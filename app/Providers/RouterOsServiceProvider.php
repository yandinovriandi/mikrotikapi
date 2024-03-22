<?php

namespace App\Providers;

use App\Services\Impl\RouterOsServiceImpl;
use App\Services\RouterOsServiceInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RouterOsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        RouterOsServiceInterface::class => RouterOsServiceImpl::class
    ];
    public function provides(): array
    {
        return [RouterOsServiceInterface::class];
    }

    public function register()
    {
    }

    public function boot()
    {
    }
}
