<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\Paginator;
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
        // Cache ile performans optimize et (1 dakika - bakım modu için hızlı güncelleme)
        $settings = Cache::remember('app.settings', 60, function () {
            return Setting::pluck('value', 'key')->toArray();
        });
        
        View::share('settings', $settings);

        // Tüm sayfalamada özel pagination view'ını kullan
        Paginator::defaultView('vendor.pagination.default');
    }
}
