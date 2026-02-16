<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Admin paneli veya login route'larını atla
        if ($request->is('admin/*') || $request->is('login')) {
            return $next($request);
        }

        // Bakım modu kontrolü (cache ile optimize)
        $maintenanceMode = Cache::remember('maintenance_mode', 60, function () {
            return Setting::get('maintenance_mode', '0');
        });

        // Bakım modu aktif mi?
        if ($maintenanceMode == '1') {
            // Kullanıcı admin mi kontrol et
            if (!Auth::check() || !Auth::user()->isAdmin()) {
                // Bakım mesajını al
                $maintenanceMessage = Cache::remember('maintenance_message', 60, function () {
                    return Setting::get('maintenance_message', 'Site bakım çalışmaları nedeniyle geçici olarak hizmet dışıdır. En kısa sürede tekrar hizmetinizdeyiz.');
                });

                return response()->view('maintenance', [
                    'message' => $maintenanceMessage,
                    'settings' => Cache::remember('app.settings', 3600, function () {
                        return Setting::pluck('value', 'key')->toArray();
                    })
                ], 503);
            }
        }

        return $next($request);
    }
}
