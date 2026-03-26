<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        // View'da $settings['key'] formatında kullanılıyor
        $settings = Setting::pluck('value', 'key')->toArray();
        
        // Footer sekmesi için legal pages'leri de gönder
        $legalPages = LegalPage::orderBy('title')->get();
        
        return view('admin.settings.index', compact('settings', 'legalPages'));
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
            'google_analytics_id' => ['nullable', 'string', 'max:50', 'regex:/^(G-[A-Z0-9]+|UA-\d+-\d+)$/'],
            'og_title' => 'nullable|string|max:255',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'robots_index' => ['nullable', Rule::in(['index,follow', 'noindex,nofollow'])],
            
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
        ]);

        // Bakım modu checkbox'ı işle (checkbox gönderilmezse 0 yap)
        if (!$request->has('maintenance_mode')) {
            Setting::set('maintenance_mode', '0');
        }

        // OG Image: sil veya güncelle
        if ($request->hasFile('og_image')) {
            $oldImage = Setting::get('og_image');
            if ($oldImage && \Storage::exists('public/' . $oldImage)) {
                \Storage::delete('public/' . $oldImage);
            }
            $imagePath = $request->file('og_image')->store('settings/og-images', 'public');
            Setting::set('og_image', $imagePath);
        } elseif ($request->input('og_image_delete') == '1') {
            $oldImage = Setting::get('og_image');
            if ($oldImage && \Storage::exists('public/' . $oldImage)) {
                \Storage::delete('public/' . $oldImage);
            }
            Setting::set('og_image', null);
        }

        // Sadece izin verilen ayar anahtarları kaydedilir (güvenlik: whitelist)
        $allowedKeys = [
            'site_name', 'site_description', 'site_keywords', 'site_email', 'site_phone',
            'site_address', 'site_city', 'site_country',
            'og_title', 'og_description',
            'facebook_url', 'instagram_url', 'twitter_url', 'youtube_url', 'linkedin_url', 'whatsapp_number',
            'google_maps_embed', 'google_analytics_id', 'google_tag_manager_id',
            'footer_description', 'footer_bottom_links', 'footer_show_social', 'footer_show_map',
            'maintenance_message', 'contact_email', 'contact_phone_secondary',
            'meta_robots', 'favicon', 'logo', 'logo_dark',
            'seo_home_title', 'seo_home_description',
            'smtp_host', 'smtp_port', 'smtp_username', 'smtp_encryption',
            'notification_email', 'send_evaluation_email', 'send_contact_email',
        ];

        $data = $request->only($allowedKeys);

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
        
        // Tüm cache'leri temizle ki değişiklikler anında yansısın
        \Artisan::call('cache:clear');
        
        $activeTab = $request->input('_active_tab', 'general');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Ayarlar başarıyla güncellendi. Cache temizlendi, değişiklikler anında aktif.')
            ->with('active_tab', $activeTab);
    }
    
    /**
     * Yeni yasal sayfa ekle (Footer sekmesinden)
     */
    public function addLegalPage(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
            ]);
            
            // Slug oluştur
            $slug = Str::slug($request->title);
            
            // Aynı slug varsa sayı ekle
            $originalSlug = $slug;
            $count = 1;
            while (LegalPage::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            
            // Yeni sayfa oluştur
            $page = LegalPage::create([
                'title' => $request->title,
                'slug' => $slug,
                'content' => '<p>İçerik henüz eklenmedi. Lütfen düzenleyin.</p>',
                'is_active' => true,
                'is_required_in_forms' => false,
                'version' => 1,
            ]);
            
            // Cache temizle
            Cache::forget('app.settings');
            \Artisan::call('cache:clear');
            
            // AJAX isteği ise JSON döndür
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "'{$page->title}' sayfası başarıyla eklendi. İçeriği düzenlemek için 'İçeriği Düzenle' butonuna tıklayın.",
                    'page' => $page
                ], 200);
            }
            
            // Normal form submit için redirect
            return redirect()->route('admin.settings.index', ['tab' => 'footer'])
                ->with('success', "'{$page->title}' sayfası başarıyla eklendi. İçeriği düzenlemek için 'İçeriği Düzenle' butonuna tıklayın.")
                ->with('active_tab', 'footer');
                
        } catch (\Exception $e) {
            // AJAX isteği ise JSON hata döndür
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bir hata oluştu: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    /**
     * Yasal sayfayı sil (Hard Delete - Kalıcı)
     */
    public function deleteLegalPage(Request $request, $id)
    {
        try {
            $page = LegalPage::findOrFail($id);
            $pageTitle = $page->title;
            
            // Hard delete (veritabanından tamamen sil)
            $page->delete();
            
            // Cache temizle
            Cache::forget('app.settings');
            \Artisan::call('cache:clear');
            
            // AJAX isteği ise JSON döndür
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "'{$pageTitle}' sayfası kalıcı olarak silindi."
                ], 200);
            }
            
            // Normal form submit için redirect
            return redirect()->route('admin.settings.index', ['tab' => 'footer'])
                ->with('success', "'{$pageTitle}' sayfası kalıcı olarak silindi. Bu işlem geri alınamaz.")
                ->with('active_tab', 'footer');
                
        } catch (\Exception $e) {
            // AJAX isteği ise JSON hata döndür
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bir hata oluştu: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
