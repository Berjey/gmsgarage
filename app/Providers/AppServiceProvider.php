<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

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
        // Tüm view'larda $settings değişkenini kullanılabilir yap
        View::composer('*', function ($view) {
            // Cache ile performans optimize et (1 saat)
            $settings = Cache::remember('app.settings', 3600, function () {
                return Setting::pluck('value', 'key')->toArray();
            });
            
            $view->with('settings', $settings);
        });
    }
}
