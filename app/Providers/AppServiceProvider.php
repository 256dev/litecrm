<?php

namespace App\Providers;

use Date;
use Illuminate\Support\Carbon;
use Illuminate\Routing\UrlGenerator;
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
    public function boot(UrlGenerator $url)
    {
        if(env('REDIRECT_HTTPS'))
        {
          $url->forceScheme('https');
        }

        Schema::defaultStringLength(191);
        setlocale(LC_TIME, config('app.setlocale'));
        Carbon::setLocale(config('app.locale'));
        Date::setLocale(config('app.locale'));
    }
}
