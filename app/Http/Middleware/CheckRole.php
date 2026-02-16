<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  İzin verilen roller
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Kullanıcı giriş yapmamışsa login'e yönlendir
        if (!auth()->check()) {
            return redirect()->route('admin.login');
        }

        $user = auth()->user();

        // Kullanıcının rolü izin verilen roller arasında mı?
        if (!in_array($user->role, $roles)) {
            // Yetkisiz erişim - 403 hatası
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        return $next($request);
    }
}
