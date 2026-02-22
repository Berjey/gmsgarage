<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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
        $data = $request->except(['_token', '_method', 'og_image']); // Resimleri exclude et (yukarıda işledik)
        
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
