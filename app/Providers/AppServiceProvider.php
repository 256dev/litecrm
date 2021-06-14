<?php

namespace App\Providers;

use Date;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(config('app.redirect_https'))
        {
            \URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);
        setlocale(LC_TIME, config('app.setlocale'));
        Carbon::setLocale(config('app.locale'));
        Date::setLocale(config('app.locale'));
    }
}
