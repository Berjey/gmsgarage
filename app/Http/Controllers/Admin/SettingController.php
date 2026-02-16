<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        // View'da $settings['key'] formatında kullanılıyor
        // Bu yüzden key-value array olarak gönd eriyoruz
        $settings = Setting::pluck('value', 'key')->toArray();
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        // Temel validasyon
        $request->validate([
            'site_title' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'site_keywords' => 'nullable|string|max:500',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'site_favicon' => 'nullable|image|mimes:ico,png,svg|max:1024',
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'contact_whatsapp' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:500',
            'contact_google_maps_embed' => 'nullable|string|max:5000',
            'social_instagram' => 'nullable|url|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'footer_about_text' => 'nullable|string|max:1000',
            'footer_copyright' => 'nullable|string|max:500',
            'footer_bottom_links' => 'nullable|array',
        ]);

        // Logo upload işlemi
        if ($request->hasFile('site_logo')) {
            // Eski logoyu sil
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            // Yeni logoyu kaydet
            $logoPath = $request->file('site_logo')->store('settings/logos', 'public');
            Setting::set('site_logo', $logoPath);
        }

        // Logo silme işlemi
        if ($request->input('remove_logo') == '1') {
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            Setting::set('site_logo', null);
        }

        // Favicon upload işlemi
        if ($request->hasFile('site_favicon')) {
            // Eski favicon'u sil
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
            
            // Yeni favicon'u kaydet
            $faviconPath = $request->file('site_favicon')->store('settings/favicons', 'public');
            Setting::set('site_favicon', $faviconPath);
        }

        // Favicon silme işlemi
        if ($request->input('remove_favicon') == '1') {
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
            Setting::set('site_favicon', null);
        }

        // Tüm request verilerini işle
        $data = $request->except(['_token', '_method', 'site_logo', 'site_favicon', 'remove_logo', 'remove_favicon']);
        
        foreach ($data as $key => $value) {
            // Array değerleri JSON olarak kaydet (footer_bottom_links gibi)
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }
            
            // Empty string'leri null yap
            if ($value === '') {
                $value = null;
            }
            
            // Ayarı kaydet veya güncelle
            Setting::set($key, $value);
        }
        
        // Cache'i temizle ki değişiklikler anında yansısın
        Cache::forget('app.settings');
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Ayarlar başarıyla güncellendi. Değişiklikler anında yansıtıldı.');
    }
}
