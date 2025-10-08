<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SchoolSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share the school settings globally for layouts and components
        View::composer('*', function ($view) {
            static $cachedSetting = null;
            if ($cachedSetting === null) {
                $cachedSetting = SchoolSetting::first();
            }
            $view->with('schoolSetting', $cachedSetting);
        });
    }
}
