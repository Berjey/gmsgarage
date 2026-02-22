@extends('admin.layouts.app')

@section('title', 'Site Ayarları')
@section('page-title', 'Site Ayarları')

@push('styles')
<style>
    /* iOS Style Toggle Switch - Modern Design */
    .toggle-switch input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 32px;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #d1d5db; /* gray-300 */
        transition: all 0.3s ease;
        border-radius: 34px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 24px;
        width: 24px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: all 0.3s ease;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    
    .toggle-switch input:checked + .toggle-slider {
        background-color: #dc2626; /* red-600 */
    }
    
    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(28px);
    }
    
    .toggle-switch:hover .toggle-slider {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
    
    .toggle-switch input:focus + .toggle-slider {
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.2);
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6" id="settingsPage">

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Site Ayarları</h1>
        <p class="text-gray-600 mt-1">Site genelindeki ayarları buradan yönetebilirsiniz</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-20">
        <div class="flex border-b border-gray-200 overflow-x-auto" id="tabButtons">
            <button type="button" 
                    data-tab="general"
                    onclick="switchTab('general')"
                    class="tab-button active flex-1 min-w-[180px] px-5 py-4 text-sm font-semibold transition-colors bg-red-600 text-white border-b-2 border-red-600">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Genel
            </button>
            <button type="button" 
                    data-tab="seo"
                    onclick="switchTab('seo')"
                    class="tab-button flex-1 min-w-[180px] px-5 py-4 text-sm font-semibold transition-colors border-l border-gray-200 bg-white text-gray-700 hover:bg-gray-50">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                SEO & Kod
            </button>
            <button type="button" 
                    data-tab="contact"
                    onclick="switchTab('contact')"
                    class="tab-button flex-1 min-w-[180px] px-5 py-4 text-sm font-semibold transition-colors border-l border-gray-200 bg-white text-gray-700 hover:bg-gray-50">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                İletişim & Sosyal Medya
            </button>
            <button type="button" 
                    data-tab="footer"
                    onclick="switchTab('footer')"
                    class="tab-button flex-1 min-w-[180px] px-5 py-4 text-sm font-semibold transition-colors border-l border-gray-200 bg-white text-gray-700 hover:bg-gray-50">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
                Footer
            </button>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
            @csrf
            @method('PUT')

            <!-- Tab Content: Genel Ayarlar -->
            <div id="tab-general" class="tab-content p-6 space-y-6">
                
                <h3 class="text-lg font-bold text-gray-900 mb-4">Genel Site Bilgileri</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        Site Başlığı
                    </label>
                    <input type="text" 
                           name="site_title" 
                           value="{{ $settings['site_title'] ?? 'GMSGARAGE' }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                           placeholder="Örn: GMSGARAGE">
                    <p class="mt-1 text-xs text-gray-500">
                        Bu başlık tarayıcı sekmesinde ve SEO için kullanılır
                    </p>
                </div>

                <!-- Bakım Modu -->
                <div class="border-t pt-6 mt-6">
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                        <!-- Header -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-3 shadow-lg mr-4">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">Bakım Modu</h4>
                                    <p class="text-sm text-gray-500">Site erişim kontrolü ve yönetimi</p>
                                </div>
                            </div>
                            
                            <!-- Modern iOS Toggle Switch -->
                            <div class="flex items-center space-x-4">
                                <label class="toggle-switch">
                                    <input type="checkbox" 
                                           id="maintenanceToggle"
                                           name="maintenance_mode" 
                                           value="1"
                                           {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}
                                           onchange="toggleMaintenanceStatus(this.checked)">
                                    <span class="toggle-slider"></span>
                                </label>
                                <div class="text-left">
                                    <span id="maintenanceStatusText" class="block text-base font-bold transition-colors duration-300 {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'text-red-600' : 'text-gray-700' }}">
                                        {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'AKTİF - Site Erişime Kapalı' : 'PASİF - Site Erişime Açık' }}
                                    </span>
                                    <span id="maintenanceSubtext" class="block text-xs font-medium transition-colors duration-300 {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'text-red-500' : 'text-gray-500' }}">
                                        {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'Sadece admin erişebilir' : 'Herkes erişebilir' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Alert Box -->
                        <div id="maintenanceAlert" class="{{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'bg-red-50 border-red-300' : 'bg-blue-50 border-blue-300' }} border-2 rounded-xl p-4 mb-5 transition-all duration-300">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg id="maintenanceAlertIcon" class="{{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'text-red-600' : 'text-blue-600' }} w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z' : 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h5 id="maintenanceAlertTitle" class="{{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'text-red-900' : 'text-blue-900' }} text-sm font-bold mb-1">
                                        {{ ($settings['maintenance_mode'] ?? '0') == '1' ? '⚠️ Uyarı: Bakım Modu Aktif' : 'ℹ️ Bilgi' }}
                                    </h5>
                                    <p id="maintenanceAlertText" class="{{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'text-red-800' : 'text-blue-800' }} text-sm">
                                        {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'Site şu anda ziyaretçilere KAPALI. Sadece admin kullanıcıları erişebilir. Test etmek için gizli sekme kullanın.' : 'Bakım modu kapalı. Tüm ziyaretçiler siteye normal şekilde erişebilir.' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Maintenance Message -->
                        <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm">
                            <label class="block text-sm font-bold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                Ziyaretçilere Gösterilecek Mesaj
                            </label>
                            <textarea name="maintenance_message" 
                                      rows="4"
                                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all resize-none hover:border-gray-400"
                                      placeholder="Örn: Sistemimiz şu anda bakımdadır. En kısa sürede hizmetinizdeyiz.">{{ $settings['maintenance_message'] ?? 'Site bakım çalışmaları nedeniyle geçici olarak hizmet dışıdır. En kısa sürede tekrar hizmetinizdeyiz.' }}</textarea>
                            <div class="mt-2 flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Bu mesaj bakım sayfasında ziyaretçilere gösterilecektir
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content: SEO & Kod Yönetimi -->
            <div id="tab-seo" class="tab-content p-6 space-y-6 hidden">
                
                <h3 class="text-lg font-bold text-gray-900 mb-4">SEO ve Analitik Yönetimi</h3>
                
                <!-- SEO Meta Tags -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 inline-block mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        SEO Meta Tagları
                    </h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Site Açıklaması (Meta Description)</label>
                            <textarea name="site_description" 
                                      rows="3"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                      placeholder="Site açıklaması (Google'da görünecek)">{{ $settings['site_description'] ?? '' }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">
                                Arama motorlarında site açıklamanız olarak görünür. Önerilen: 150-160 karakter
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Anahtar Kelimeler (Meta Keywords)</label>
                            <input type="text" 
                                   name="site_keywords" 
                                   value="{{ $settings['site_keywords'] ?? '' }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                   placeholder="Örn: araba, satılık araç, oto galeri, ikinci el araç">
                            <p class="mt-1 text-xs text-gray-500">
                                Virgülle ayırarak anahtar kelimelerinizi girin
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Google Analytics -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 inline-block mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Google Analytics (GA4)
                    </h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Google Analytics ID</label>
                        <input type="text" 
                               name="google_analytics_id" 
                               value="{{ $settings['google_analytics_id'] ?? '' }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-mono text-sm"
                               placeholder="G-XXXXXXXXXX">
                        <p class="mt-1 text-xs text-gray-500">
                            <svg class="w-4 h-4 inline-block mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Google Analytics 4 ID'nizi girin (Örn: G-XXXXXXXXXX). Boş bırakırsanız Analytics devre dışı kalır.
                        </p>
                    </div>
                </div>

                <!-- Sosyal Medya Paylaşım Ayarları (Open Graph) -->
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 inline-block mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                        Sosyal Medya Paylaşım Ayarları (Open Graph)
                    </h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Paylaşım Başlığı (OG Title)</label>
                            <input type="text" 
                                   name="og_title" 
                                   value="{{ $settings['og_title'] ?? '' }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                   placeholder="Boş bırakılırsa Site Başlığı kullanılır">
                            <p class="mt-1 text-xs text-gray-500">
                                WhatsApp, Facebook, Twitter'da paylaşıldığında görünecek başlık
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Varsayılan Paylaşım Resmi (OG Image)</label>
                            @if(!empty($settings['og_image']))
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $settings['og_image']) }}" 
                                     alt="OG Image" 
                                     class="w-full max-w-md h-48 object-cover rounded-lg border border-gray-300">
                            </div>
                            @endif
                            <input type="file" 
                                   name="og_image" 
                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                            <p class="mt-1 text-xs text-gray-500">
                                <svg class="w-4 h-4 inline-block mr-1 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                WhatsApp/sosyal medyada paylaşıldığında görünecek görsel. Önerilen: 1200x630px (JPG/PNG)
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Arama Motoru ve Sitemap -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 inline-block mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Arama Motoru ve Sitemap Durumu
                    </h4>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Arama Motoru İndeksleme</label>
                            <select name="robots_index" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                <option value="index,follow" {{ ($settings['robots_index'] ?? 'index,follow') == 'index,follow' ? 'selected' : '' }}>
                                    ✅ İzin Ver (index, follow) - Google'da görünsün
                                </option>
                                <option value="noindex,nofollow" {{ ($settings['robots_index'] ?? '') == 'noindex,nofollow' ? 'selected' : '' }}>
                                    🚫 Engelle (noindex, nofollow) - Google'da görünmesin
                                </option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">
                                <svg class="w-4 h-4 inline-block mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Site yayında değilse "Engelle" seçin. Yayına alınca "İzin Ver" yapın.
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sitemap URL (Bilgi Amaçlı)</label>
                            <div class="flex gap-2">
                                <input type="text" 
                                       value="{{ url('sitemap.xml') }}"
                                       readonly
                                       class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg text-gray-600 font-mono text-sm cursor-not-allowed">
                                <button type="button"
                                        onclick="navigator.clipboard.writeText('{{ url('sitemap.xml') }}'); Swal.fire({title: '<span style=\"color: #111827; font-weight: 500; font-size: 1.125rem;\">Kopyalandı!</span>', html: '<p style=\"color: #6B7280; font-size: 0.875rem; margin-top: 0.5rem;\">Sitemap URL kopyalandı.</p>', icon: 'success', confirmButtonColor: '#059669', confirmButtonText: 'Tamam', customClass: {popup: 'swal-custom-popup', confirmButton: 'swal-custom-confirm'}, buttonsStyling: false, timer: 2000, showConfirmButton: false});"
                                        class="px-4 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Kopyala
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                Bu linki Google Search Console'a ekleyerek sitenizin Google'da daha iyi indekslenmesini sağlayabilirsiniz.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Tab Content: İletişim Bilgileri -->
            <div id="tab-contact" class="tab-content p-6 space-y-6 hidden">
                
                <h3 class="text-lg font-bold text-gray-900 mb-4">İletişim Bilgileri</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Telefon Numarası
                        </label>
                        <input type="text" 
                               name="contact_phone" 
                               value="{{ $settings['contact_phone'] ?? '' }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="0555 123 45 67">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            E-posta Adresi
                        </label>
                        <input type="email" 
                               name="contact_email" 
                               value="{{ $settings['contact_email'] ?? '' }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="info@gmsgarage.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            WhatsApp Numarası
                        </label>
                        <input type="text" 
                               name="contact_whatsapp" 
                               value="{{ $settings['contact_whatsapp'] ?? '' }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="905551234567">
                        <p class="mt-1 text-xs text-gray-500">Ülke kodu dahil, + işareti olmadan (Örn: 905551234567)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Adres
                        </label>
                        <textarea name="contact_address" 
                                  rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                  placeholder="Şirket adresi">{{ $settings['contact_address'] ?? '' }}</textarea>
                    </div>
                </div>

                <!-- Google Maps Embed -->
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        Harita Konumu
                    </h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Google Maps Embed Kodu</label>
                        <textarea name="contact_google_maps_embed" 
                                  rows="4"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 font-mono text-sm transition-colors"
                                  placeholder='<iframe src="https://www.google.com/maps/embed?pb=..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'>{{ $settings['contact_google_maps_embed'] ?? '' }}</textarea>
                        <div class="mt-2 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm text-blue-800 font-medium mb-2">📍 Nasıl Alınır?</p>
                            <ol class="text-xs text-blue-700 space-y-1 list-decimal list-inside">
                                <li>Google Maps'te konumunuzu bulun</li>
                                <li>"Paylaş" butonuna tıklayın</li>
                                <li>"Harita yerleştir" sekmesini seçin</li>
                                <li>HTML kodunu kopyalayıp buraya yapıştırın</li>
                            </ol>
                        </div>
                    </div>

                </div>

                <!-- Sosyal Medya Hesapları -->
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Sosyal Medya Hesapları
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                Instagram Kullanıcı Adı
                            </label>
                            <input type="text" 
                                   name="social_instagram" 
                                   value="{{ $settings['social_instagram'] ?? '' }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                   placeholder="gmsgarage.official">
                            <p class="mt-1 text-xs text-gray-500">Sadece kullanıcı adını yazın (@ olmadan)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                                Facebook Kullanıcı Adı
                            </label>
                            <input type="text" 
                                   name="social_facebook" 
                                   value="{{ $settings['social_facebook'] ?? '' }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                   placeholder="gmsgarage.official">
                            <p class="mt-1 text-xs text-gray-500">Sadece kullanıcı adını yazın</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                                YouTube Kullanıcı Adı
                            </label>
                            <input type="text" 
                                   name="social_youtube" 
                                   value="{{ $settings['social_youtube'] ?? '' }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                   placeholder="@gmsgarage">
                            <p class="mt-1 text-xs text-gray-500">@ ile birlikte veya sadece kullanıcı adını yazın</p>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Tab Content: Footer Yönetimi (form içinde; kaydet ile birlikte gönderilir) -->
            <div id="tab-footer" class="tab-content p-6 space-y-6 hidden">
                
                <h3 class="text-lg font-bold text-gray-900 mb-4">Footer İçeriği</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Footer Hakkında Metni -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Footer Hakkında Metni
                        </label>
                        <textarea name="footer_about_text" 
                                  id="textarea_footer_about_text"
                                  rows="5"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                  placeholder="Footer'da logo altında görünecek kısa açıklama metni...">{{ $settings['footer_about_text'] ?? '' }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">
                            Bu metin web sitesi footer'ında logonun altında görünecektir. Şirketiniz hakkında kısa bir açıklama yazabilirsiniz.
                        </p>
                    </div>

                    <!-- Copyright Metni -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Copyright Metni
                        </label>
                        <textarea name="footer_copyright" 
                                  id="textarea_footer_copyright"
                                  rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                  placeholder="© 2026 GMSGARAGE. Tüm hakları saklıdır.">{{ $settings['footer_copyright'] ?? '© 2026 GMSGARAGE. Tüm hakları saklıdır.' }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">
                            Footer'ın en altında görünecek telif hakkı metni.
                        </p>
                    </div>
                </div>

                <!-- YASAL SAYFALAR YÖNETİMİ (CRUD) - Direkt pages tablosundan -->
                <div class="border-t pt-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <h3 class="font-semibold text-blue-900 mb-1">Yasal Sayfalar Yönetim Merkezi</h3>
                                <p class="text-sm text-blue-800">Bu bölüm Footer'daki yasal sayfaların <strong>merkezi yönetim noktasıdır</strong>. Yeni sayfa ekleyin, listede görünecektir. İçeriği düzenlemek için "İçeriği Düzenle" butonuna tıklayın. Aktif olan tüm sayfalar otomatik olarak footer'da görünür.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Yeni Sayfa Ekleme Formu -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6">
                        <h4 class="text-md font-bold text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Yeni Yasal Sayfa Ekle
                        </h4>
                        <div id="add-legal-page-form">
                            <div class="flex gap-3">
                                <div class="flex-1">
                                    <input type="text" 
                                           id="new-page-title"
                                           required
                                           placeholder="Sayfa başlığı girin (Örn: KVKK, Gizlilik Politikası)"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                           onkeypress="if(event.key === 'Enter') { event.preventDefault(); addNewLegalPage(); }">
                                </div>
                                <button type="button" onclick="addNewLegalPage()" class="px-6 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                                    Ekle
                        </button>
                            </div>
                            <p class="mt-2 text-xs text-gray-500">Sayfa başlığını girin. URL otomatik oluşturulacak. İçeriği düzenlemek için listeden "İçeriği Düzenle" butonuna tıklayın.</p>
                        </div>
                    </div>

                    <!-- Mevcut Yasal Sayfalar Listesi -->
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                            <h4 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Mevcut Yasal Sayfalar ({{ $legalPages->count() }})
                            </h4>
                    </div>

                        @if($legalPages->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($legalPages as $page)
                            <div class="p-4 hover:bg-gray-50 transition-colors flex items-center justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h5 class="text-sm font-semibold text-gray-900 truncate">{{ $page->title }}</h5>
                                        @if($page->is_active)
                                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        @else
                                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Pasif</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        <span class="font-mono">/sayfa/{{ $page->slug }}</span>
                                        <span class="mx-2">•</span>
                                        Son Güncelleme: {{ $page->updated_at->format('d.m.Y H:i') }}
                                        @if($page->is_required_in_forms)
                                        <span class="mx-2">•</span>
                                        <span class="text-red-600 font-semibold">Formlarda Zorunlu</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <!-- İçeriği Düzenle -->
                                    <a href="{{ route('admin.legal-pages.edit', $page->id) }}" 
                                       class="px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        İçeriği Düzenle
                                    </a>
                                    <!-- Sil (Hard Delete) -->
                                    <button type="button" onclick="deleteLegalPage({{ $page->id }}, '{{ $page->title }}')" class="px-3 py-1.5 bg-red-600 text-white text-xs font-semibold rounded-lg hover:bg-red-700 transition-colors flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Sil
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="p-8 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="font-semibold mb-1">Henüz yasal sayfa eklenmemiş</p>
                            <p class="text-sm">Yukarıdaki formu kullanarak yeni sayfa ekleyin</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>


        </form>

            <!-- Kaydet Butonu (Diğer sekmelerle aynı konum: sayfanın sağ alt köşesi - tüm sekme içeriklerinin altında) -->
            <div id="save-button-container" class="mt-8 flex justify-end border-t pt-6">
                <button type="button" onclick="document.getElementById('settingsForm').submit();" class="px-8 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-bold shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Ayarları Kaydet
                </button>
            </div>

        </div>
    </div>

    <!-- Modal: İçerik Düzenleme -->
    <div id="contentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 hidden">
        
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 id="modalTitle" class="text-xl font-bold text-gray-900"></h3>
                <button type="button" 
                        onclick="closeContentModal()"
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="flex-1 overflow-auto p-6">
                <textarea id="contentEditor" name="content"></textarea>
            </div>
            
            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 bg-gray-50">
                <button type="button" 
                        onclick="closeContentModal()"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                    İptal
                </button>
                <button type="button" 
                        onclick="saveModalContent()"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    İçeriği Kaydet
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Sayfa yüklendiğinde varsayılan aktif sekme (Genel veya session'dan gelen)
document.addEventListener('DOMContentLoaded', function() {
    @if(session('active_tab'))
        switchTab('{{ session('active_tab') }}');
        window.currentSettingsTab = '{{ session('active_tab') }}';
    @elseif(request('tab'))
        switchTab('{{ request('tab') }}');
        window.currentSettingsTab = '{{ request('tab') }}';
    @else
        window.currentSettingsTab = 'general';
    @endif
});

// Bakım modu toggle - Modern iOS Style
function toggleMaintenanceStatus(isActive) {
    // Status Text
    const statusTextEl = document.getElementById('maintenanceStatusText');
    const subtextEl = document.getElementById('maintenanceSubtext');
    
    // Alert Box
    const alertBox = document.getElementById('maintenanceAlert');
    const alertIcon = document.getElementById('maintenanceAlertIcon');
    const alertTitle = document.getElementById('maintenanceAlertTitle');
    const alertText = document.getElementById('maintenanceAlertText');
    
    if (isActive) {
        // Status güncelle - AKTİF
        statusTextEl.textContent = 'AKTİF - Site Erişime Kapalı';
        statusTextEl.classList.remove('text-gray-700');
        statusTextEl.classList.add('text-red-600');
        
        subtextEl.textContent = 'Sadece admin erişebilir';
        subtextEl.classList.remove('text-gray-500');
        subtextEl.classList.add('text-red-500');
        
        // Alert box'ı kırmızıya çevir
        alertBox.classList.remove('bg-blue-50', 'border-blue-300');
        alertBox.classList.add('bg-red-50', 'border-red-300');
        
        alertIcon.classList.remove('text-blue-600');
        alertIcon.classList.add('text-red-600');
        alertIcon.querySelector('path').setAttribute('d', 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z');
        
        alertTitle.textContent = '⚠️ Uyarı: Bakım Modu Aktif';
        alertTitle.classList.remove('text-blue-900');
        alertTitle.classList.add('text-red-900');
        
        alertText.textContent = 'Site şu anda ziyaretçilere KAPALI. Sadece admin kullanıcıları erişebilir. Test etmek için gizli sekme kullanın.';
        alertText.classList.remove('text-blue-800');
        alertText.classList.add('text-red-800');
    } else {
        // Status güncelle - PASİF
        statusTextEl.textContent = 'PASİF - Site Erişime Açık';
        statusTextEl.classList.remove('text-red-600');
        statusTextEl.classList.add('text-gray-700');
        
        subtextEl.textContent = 'Herkes erişebilir';
        subtextEl.classList.remove('text-red-500');
        subtextEl.classList.add('text-gray-500');
        
        // Alert box'ı maviye çevir
        alertBox.classList.remove('bg-red-50', 'border-red-300');
        alertBox.classList.add('bg-blue-50', 'border-blue-300');
        
        alertIcon.classList.remove('text-red-600');
        alertIcon.classList.add('text-blue-600');
        alertIcon.querySelector('path').setAttribute('d', 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z');
        
        alertTitle.textContent = 'ℹ️ Bilgi';
        alertTitle.classList.remove('text-red-900');
        alertTitle.classList.add('text-blue-900');
        
        alertText.textContent = 'Bakım modu kapalı. Tüm ziyaretçiler siteye normal şekilde erişebilir.';
        alertText.classList.remove('text-blue-800');
        alertText.classList.add('text-blue-800');
    }
}

// Form gönderilirken: Footer ve Pop-up (form dışındaki tab) alanlarını gizli alanlara kopyala
function syncFooterFieldsIfActive(form) {
    if (window.currentSettingsTab === 'footer') {
        var aboutEl = document.getElementById('textarea_footer_about_text');
        var copyrightEl = document.getElementById('textarea_footer_copyright');
        var hiddenAbout = document.getElementById('form_hidden_footer_about_text');
        var hiddenCopyright = document.getElementById('form_hidden_footer_copyright');
        if (aboutEl && hiddenAbout) hiddenAbout.value = aboutEl.value;
        if (copyrightEl && hiddenCopyright) hiddenCopyright.value = copyrightEl.value;
    }
    // Pop-up alanları form dışında; her gönderimde güncel değerleri gizli alanlara yaz ki API'ye gitsin
    var popupCheckbox = document.getElementById('popup_status');
    var hiddenPopupStatus = document.getElementById('form_hidden_popup_status');
    if (popupCheckbox && hiddenPopupStatus) hiddenPopupStatus.value = popupCheckbox.checked ? '1' : '0';
    var popupTitle = document.getElementById('popup_title');
    var popupText = document.getElementById('popup_text');
    var popupLink = document.getElementById('popup_link');
    var popupButtonText = document.getElementById('popup_button_text');
    var popupFreq = document.getElementById('popup_display_frequency');
    var hTitle = document.getElementById('form_hidden_popup_title');
    var hText = document.getElementById('form_hidden_popup_text');
    var hLink = document.getElementById('form_hidden_popup_link');
    var hBtn = document.getElementById('form_hidden_popup_button_text');
    var hFreq = document.getElementById('form_hidden_popup_display_frequency');
    if (popupTitle && hTitle) hTitle.value = popupTitle.value || '';
    if (popupText && hText) hText.value = popupText.value || '';
    if (popupLink && hLink) hLink.value = popupLink.value || '';
    if (popupButtonText && hBtn) hBtn.value = popupButtonText.value || '';
    if (popupFreq && hFreq) hFreq.value = popupFreq.value || 'daily';
    return true;
}

// Yeni yasal sayfa ekleme fonksiyonu (AJAX)
async function addNewLegalPage() {
    const titleInput = document.getElementById('new-page-title');
    const title = titleInput.value.trim();
    
    if (!title) {
        Swal.fire({
            icon: 'error',
            title: 'Hata!',
            text: 'Lütfen sayfa başlığını girin.',
            confirmButtonColor: '#dc2626',
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'rounded-lg px-6 py-2.5 font-semibold'
            }
        });
        return;
    }
    
    try {
        const response = await fetch('{{ route('admin.settings.add-legal-page') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ title: title })
        });
        
        const data = await response.json();
        
        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Başarılı!',
                text: data.message || 'Sayfa başarıyla eklendi!',
                confirmButtonColor: '#059669',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg px-6 py-2.5 font-semibold'
                }
            }).then(() => {
                // Sayfayı yenile ve footer tabında kal
                window.location.href = '{{ route('admin.settings.index') }}?tab=footer';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                text: data.message || 'Sayfa eklenirken bir hata oluştu.',
                confirmButtonColor: '#dc2626',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg px-6 py-2.5 font-semibold'
                }
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Hata!',
            text: 'Bir sorun oluştu. Lütfen tekrar deneyin.',
            confirmButtonColor: '#dc2626',
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'rounded-lg px-6 py-2.5 font-semibold'
            }
        });
    }
}

// Legal page silme fonksiyonu (AJAX ile SweetAlert2)
async function deleteLegalPage(pageId, pageTitle) {
    const result = await Swal.fire({
        title: 'Sayfayı Sil?',
        html: '<strong>' + pageTitle + '</strong> sayfasını ve tüm içeriğini silmek istediğinize emin misiniz?<br><span class="text-red-600 font-semibold">Bu işlem geri alınamaz.</span>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Evet, Sil!',
        cancelButtonText: 'İptal',
        customClass: {
            popup: 'rounded-xl',
            confirmButton: 'rounded-lg px-6 py-2.5 font-semibold',
            cancelButton: 'rounded-lg px-6 py-2.5 font-semibold'
        }
    });
    
    if (result.isConfirmed) {
        try {
            const response = await fetch('/admin/settings/delete-legal-page/' + pageId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Silindi!',
                    text: data.message || 'Sayfa başarıyla silindi.',
                    confirmButtonColor: '#059669',
                    customClass: {
                        popup: 'rounded-xl',
                        confirmButton: 'rounded-lg px-6 py-2.5 font-semibold'
                    }
                }).then(() => {
                    // Sayfayı yenile ve footer tabında kal
                    window.location.href = '{{ route('admin.settings.index') }}?tab=footer';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Hata!',
                    text: data.message || 'Sayfa silinirken bir hata oluştu.',
                    confirmButtonColor: '#dc2626',
                    customClass: {
                        popup: 'rounded-xl',
                        confirmButton: 'rounded-lg px-6 py-2.5 font-semibold'
                    }
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Hata!',
                text: 'Bir sorun oluştu. Lütfen tekrar deneyin.',
                confirmButtonColor: '#dc2626',
                customClass: {
                    popup: 'rounded-xl',
                    confirmButton: 'rounded-lg px-6 py-2.5 font-semibold'
                }
            });
        }
    }
}

// Tab switching fonksiyonu
function switchTab(tabName) {
    // Tüm tab buttonları üzerinde dön
    const buttons = document.querySelectorAll('.tab-button');
    buttons.forEach(btn => {
        if (btn.dataset.tab === tabName) {
            btn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-50');
            btn.classList.add('bg-red-600', 'text-white', 'border-b-2', 'border-red-600');
        } else {
            btn.classList.remove('bg-red-600', 'text-white', 'border-b-2', 'border-red-600');
            btn.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-50');
        }
    });
    
    // Tüm tab içeriklerini gizle
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => {
        content.classList.add('hidden');
    });
    
    // Seçili tab içeriğini göster
    const activeContent = document.getElementById('tab-' + tabName);
    if (activeContent) {
        activeContent.classList.remove('hidden');
    }
    
    // Aktif sekmeyi takip et (form gönderiminde Footer alanları için kullanılır)
    window.currentSettingsTab = tabName;
    
    // Ayarları Kaydet butonu tüm sekmelerde (Footer dahil) görünsün
    const saveButton = document.getElementById('save-button-container');
    if (saveButton) {
        saveButton.style.display = 'flex';
    }
}
</script>

<style>
/* SweetAlert Özel Stiller - İletişim Mesajları Modalıyla Tutarlı */
.swal-custom-popup {
    border: 1px solid #E5E7EB !important;
    border-radius: 0.5rem !important;
    padding: 0 !important;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
}

.swal2-popup.swal-custom-popup .swal2-icon {
    margin: 1.5rem auto 1rem auto !important;
    border-width: 3px !important;
}

.swal2-popup.swal-custom-popup .swal2-icon.swal2-warning {
    border-color: #FEE2E2 !important;
    color: #DC2626 !important;
    background-color: #FEE2E2 !important;
}

.swal2-popup.swal-custom-popup .swal2-icon.swal2-success {
    border-color: #D1FAE5 !important;
    color: #059669 !important;
}

.swal-custom-title {
    padding: 0 1.5rem !important;
    margin: 0 !important;
}

.swal-custom-html {
    padding: 0 1.5rem 1.5rem 1.5rem !important;
    margin: 0 !important;
}

.swal-custom-actions {
    background-color: #F9FAFB !important;
    padding: 0.75rem 1.5rem !important;
    margin: 0 !important;
    border-top: 1px solid #E5E7EB !important;
    flex-direction: row-reverse !important;
    gap: 0.75rem !important;
}

.swal-custom-confirm {
    background-color: #DC2626 !important;
    color: white !important;
    padding: 0.5rem 1rem !important;
    border-radius: 0.375rem !important;
    font-size: 0.875rem !important;
    font-weight: 500 !important;
    border: none !important;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    transition: background-color 0.2s !important;
    margin: 0 !important;
}

.swal-custom-confirm:hover {
    background-color: #B91C1C !important;
}

.swal-custom-cancel {
    background-color: white !important;
    color: #374151 !important;
    padding: 0.5rem 1rem !important;
    border-radius: 0.375rem !important;
    font-size: 0.875rem !important;
    font-weight: 500 !important;
    border: 1px solid #D1D5DB !important;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    transition: background-color 0.2s !important;
    margin: 0 !important;
}

.swal-custom-cancel:hover {
    background-color: #F9FAFB !important;
}

/* Success popup için yeşil buton */
.swal2-popup.swal-custom-popup .swal2-confirm.swal-custom-confirm[style*="059669"] {
    background-color: #059669 !important;
}

.swal2-popup.swal-custom-popup .swal2-confirm.swal-custom-confirm[style*="059669"]:hover {
    background-color: #047857 !important;
}
</style>
@endpush
