<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Helper dosyasını yükle
        if (file_exists($file = __DIR__ . '/../Helpers/CategoryHelper.php')) {
            require_once $file;
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::defaultView('vendor.pagination.default');
        \Illuminate\Pagination\Paginator::defaultSimpleView('vendor.pagination.default');
    }
}
