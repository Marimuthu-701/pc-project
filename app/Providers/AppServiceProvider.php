<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Setting\Setting;
use Illuminate\Support\Facades\Schema;

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
        // Get all the settings and set to cache
        if (Schema::hasTable('settings')) {
            Setting::getAllSettings();
        }
    }
}
