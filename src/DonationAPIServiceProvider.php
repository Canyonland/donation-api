<?php

namespace OCEF\DonationAPI;

use Illuminate\Support\ServiceProvider;

class DonationAPIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('OCEF\DonationAPI\Controllers\APIController');
        $this->app->make('OCEF\DonationAPI\Controllers\AccountController');
        $this->app->make('OCEF\DonationAPI\Controllers\ActivityController');
        $this->app->make('OCEF\DonationAPI\Controllers\DonationController');
        $this->app->make('OCEF\DonationAPI\Controllers\MatchingGiftController');
        $this->app->make('OCEF\DonationAPI\Controllers\PaymentController');
        $this->app->make('OCEF\DonationAPI\Controllers\StakeholderController');
    }
}
