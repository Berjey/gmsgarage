<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Profil sayfasını göster
     */
    public function index()
    {
        $user = auth()->user();
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Profil bilgilerini güncelle
     */
    public function updateInfo(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->name = $request->name;
        $user->save();

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }

    /**
     * Şifre değiştir
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Mevcut şifre kontrolü
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mevcut şifreniz yanlış.']);
        }

        // Yeni şifre eski şifre ile aynı olmamalı
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Yeni şifreniz eski şifrenizle aynı olamaz.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.profile.index')
            ->with('success', 'Şifreniz başarıyla değiştirildi.');
    }
}
