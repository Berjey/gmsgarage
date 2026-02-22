<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Admin login sayfası
     */
    public function showLoginForm()
    {
        // Eğer kullanıcı zaten giriş yapmışsa ve yetkili bir role sahipse dashboard'a yönlendir
        if (Auth::check() && Auth::user()->role && in_array(Auth::user()->role, ['admin', 'manager', 'editor'])) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }

    /**
     * Admin giriş işlemi
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'password.required' => 'Şifre zorunludur.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Role kontrolü - Admin, Manager veya Editor olmalı
            $user = Auth::user();
            if (!$user->role || !in_array($user->role, ['admin', 'manager', 'editor'])) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Bu hesap admin paneline erişim yetkisine sahip değil.',
                ])->withInput();
            }

            // Son giriş zamanını ve IP'yi kaydet
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            // Aktivite logla
            \App\Models\ActivityLog::log(
                'login',
                'Admin paneline giriş yaptı'
            );

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Hoş geldiniz!');
        }

        throw ValidationException::withMessages([
            'email' => 'E-posta veya şifre hatalı.',
        ]);
    }

    /**
     * Admin çıkış işlemi
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Başarıyla çıkış yaptınız.');
    }
}
