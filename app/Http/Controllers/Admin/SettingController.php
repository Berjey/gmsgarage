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
            // Genel Ayarlar
            'site_title' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'site_keywords' => 'nullable|string|max:500',
            'maintenance_mode' => 'nullable|in:1',
            'maintenance_message' => 'nullable|string|max:1000',
            
            // SEO & Kod Yönetimi
            'google_analytics_id' => 'nullable|string|max:50',
            'og_title' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'robots_index' => 'nullable|string',
            
            // İletişim
            'contact_phone' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'contact_whatsapp' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:500',
            'contact_google_maps_embed' => 'nullable|string|max:5000',
            
            // Sosyal Medya (İletişim'e taşındı - sadece kullanıcı adı)
            'social_instagram' => 'nullable|string|max:100',
            'social_facebook' => 'nullable|string|max:100',
            'social_youtube' => 'nullable|string|max:100',
            
            // Footer
            'footer_about_text' => 'nullable|string|max:1000',
            'footer_copyright' => 'nullable|string|max:500',
            'footer_bottom_links' => 'nullable|array',
        ]);

        // Bakım modu checkbox'ı işle (checkbox gönderilmezse 0 yap)
        if (!$request->has('maintenance_mode')) {
            Setting::set('maintenance_mode', '0');
        }

        // OG Image Upload (Eğer yeni resim yüklendiyse)
        if ($request->hasFile('og_image')) {
            // Eski resmi sil (eğer varsa)
            $oldImage = Setting::get('og_image');
            if ($oldImage && \Storage::exists('public/' . $oldImage)) {
                \Storage::delete('public/' . $oldImage);
            }
            
            // Yeni resmi kaydet
            $imagePath = $request->file('og_image')->store('settings/og-images', 'public');
            Setting::set('og_image', $imagePath);
        }

        // Tüm request verilerini işle
        $data = $request->except(['_token', '_method', 'og_image']); // og_image'i exclude et (yukarıda işledik)
        
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
        
        // Cache'i tamamen temizle ki değişiklikler anında yansısın
        Cache::forget('app.settings');
        Cache::forget('maintenance_mode');
        Cache::forget('maintenance_message');
        
        // Tüm cache'leri temizle (özellikle bakım modu için kritik)
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Ayarlar başarıyla güncellendi. Cache temizlendi, değişiklikler anında aktif.');
    }
}
