<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\HomeServiceInterface;
use App\Services\Public\HomeService;
use App\Services\Interfaces\PageServiceInterface;
use App\Services\Public\PageService;

use App\Services\Interfaces\CustomerAuthServiceInterface;
use App\Services\Interfaces\CustomerDashboardServiceInterface;
use App\Services\Customer\CustomerAuthService;
use App\Services\Customer\CustomerDashboardService;
use App\Services\Interfaces\CustomerProfileServiceInterface;
use App\Services\Customer\CustomerProfileService;
use App\Services\Interfaces\CustomerBookingServiceInterface;
use App\Services\Customer\CustomerBookingService;
use App\Services\Interfaces\CustomerAddressServiceInterface;
use App\Services\Customer\CustomerAddressService;
use App\Services\Interfaces\CustomerWalletServiceInterface;
use App\Services\Customer\CustomerWalletService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            HomeServiceInterface::class,
            HomeService::class
        );
        $this->app->bind(
            PageServiceInterface::class,
            PageService::class
        );
        $this->app->bind(
            CustomerDashboardServiceInterface::class,
            CustomerDashboardService::class
        );
        $this->app->bind(
            CustomerAuthServiceInterface::class,
            CustomerAuthService::class
        );
        $this->app->bind(
            CustomerProfileServiceInterface::class,
            CustomerProfileService::class
        );
        $this->app->bind(
            CustomerBookingServiceInterface::class,
            CustomerBookingService::class
        );
        $this->app->bind(
            CustomerAddressServiceInterface::class,
            CustomerAddressService::class
        );
        $this->app->bind(
            CustomerWalletServiceInterface::class,
            CustomerWalletService::class
        );
    }

    public function boot(): void
    {
        //
    }
}