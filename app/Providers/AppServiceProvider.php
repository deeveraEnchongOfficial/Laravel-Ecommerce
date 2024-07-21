<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
        resolve(\Illuminate\Routing\UrlGenerator::class)->forceScheme('http');
        Schema::defaultStringLength(191);

        if (config('app.env') !== 'local') {
            URL::forceScheme('http');
        }
    }
}
