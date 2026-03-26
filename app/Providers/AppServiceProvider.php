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
        // Sadece layout view'larına $settings enjekte et.
        // Tüm sayfalarda (* wildcard) değil yalnızca layout'larda tetiklenir;
        // her alt view ayrıca sorgu/cache hit tetiklemez.
        View::composer(['layouts.app', 'admin.app', 'admin.auth'], function ($view) {
            $settings = Cache::remember('app.settings', 60, function () {
                return Setting::pluck('value', 'key')->toArray();
            });
            $view->with('settings', $settings);
        });

        // Tüm sayfalamada özel pagination view'ını kullan
        Paginator::defaultView('vendor.pagination.default');
    }
}
