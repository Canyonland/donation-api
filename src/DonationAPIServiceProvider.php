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
        $this->app->make('OCEF\DonationAPI\APIController');
    }
}
