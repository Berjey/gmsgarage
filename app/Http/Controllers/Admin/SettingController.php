<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
            'footer_copyright' => 'nullable|string|max:500',
            'footer_bottom_links' => 'nullable|array',
        ]);

        // Tüm request verilerini işle
        $data = $request->except(['_token', '_method']);
        
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
