@extends('admin.layouts.app')

@section('title', 'Site Ayarları')

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
                İletişim
            </button>
            <button type="button" 
                    data-tab="social"
                    onclick="switchTab('social')"
                    class="tab-button flex-1 min-w-[180px] px-5 py-4 text-sm font-semibold transition-colors border-l border-gray-200 bg-white text-gray-700 hover:bg-gray-50">
                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Sosyal Medya
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
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tab Content: Genel Ayarlar -->
            <div id="tab-general" class="tab-content p-6 space-y-6">
                
                <h3 class="text-lg font-bold text-gray-900 mb-4">Genel Site Bilgileri</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Site Başlığı</label>
                        <input type="text" 
                               name="site_title" 
                               value="{{ $settings['site_title'] ?? 'GMSGARAGE' }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="Örn: GMSGARAGE">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Anahtar Kelimeler (SEO)</label>
                        <input type="text" 
                               name="site_keywords" 
                               value="{{ $settings['site_keywords'] ?? '' }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="Örn: araba, satılık araç, oto galeri">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Site Açıklaması (SEO)</label>
                    <textarea name="site_description" 
                              rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                              placeholder="Site açıklaması (Google'da görünecek)">{{ $settings['site_description'] ?? '' }}</textarea>
                </div>

                <!-- Bakım Modu -->
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Bakım Modu Yönetimi
                    </h3>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                        <div class="flex items-start gap-4">
                            <!-- Switch -->
                            <div class="flex-shrink-0">
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" 
                                               name="maintenance_mode" 
                                               value="1"
                                               {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}
                                               class="sr-only peer"
                                               onchange="toggleMaintenanceInfo(this.checked)">
                                        <div class="w-14 h-8 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-red-600"></div>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-900">
                                        Bakım Modu <span id="maintenanceStatus" class="text-xs {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'text-red-600' : 'text-gray-500' }}">({{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'Aktif' : 'Kapalı' }})</span>
                                    </span>
                                </label>
                            </div>

                            <!-- Info -->
                            <div class="flex-1">
                                <p class="text-sm text-yellow-800 mb-3">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Bakım modu aktif olduğunda, sadece admin kullanıcıları siteye erişebilir. Diğer ziyaretçiler bakım mesajını görür.
                                </p>

                                <!-- Bakım Mesajı -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bakım Mesajı</label>
                                    <textarea name="maintenance_message" 
                                              rows="4"
                                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                              placeholder="Site bakım çalışmaları nedeniyle geçici olarak hizmet dışıdır. En kısa sürede tekrar hizmetinizdeyiz.">{{ $settings['maintenance_message'] ?? 'Site bakım çalışmaları nedeniyle geçici olarak hizmet dışıdır. En kısa sürede tekrar hizmetinizdeyiz.' }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">
                                        Ziyaretçilerin göreceği bakım sayfası mesajı
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content: SEO & Kod Yönetimi -->
            <div id="tab-seo" class="tab-content p-6 space-y-6 hidden">
                
                <h3 class="text-lg font-bold text-gray-900 mb-4">SEO ve Analitik Yönetimi</h3>
                
                <!-- Google Analytics & GTM -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 inline-block mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Google Analytics & Tag Manager
                    </h4>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Google Analytics ID</label>
                            <input type="text" 
                                   name="google_analytics_id" 
                                   value="{{ $settings['google_analytics_id'] ?? '' }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-mono text-sm"
                                   placeholder="G-XXXXXXXXXX veya UA-XXXXXXXXX-X">
                            <p class="mt-1 text-xs text-gray-500">
                                Google Analytics 4 veya Universal Analytics ID'nizi girin
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Google Tag Manager ID</label>
                            <input type="text" 
                                   name="google_tag_manager_id" 
                                   value="{{ $settings['google_tag_manager_id'] ?? '' }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-mono text-sm"
                                   placeholder="GTM-XXXXXXX">
                            <p class="mt-1 text-xs text-gray-500">
                                Google Tag Manager Container ID'nizi girin
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Header Özel Kod -->
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 inline-block mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        Header Özel Kod Alanı
                    </h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <code class="text-xs bg-gray-100 px-2 py-1 rounded">&lt;head&gt;</code> etiketleri arasına eklenecek kodlar
                        </label>
                        <textarea name="custom_head_code" 
                                  rows="8"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-mono text-sm"
                                  placeholder="<!-- Facebook Pixel, Meta Tags, Verification Codes vb. -->">{{ $settings['custom_head_code'] ?? '' }}</textarea>
                        <div class="mt-2 p-3 bg-white border border-purple-100 rounded text-xs text-gray-600">
                            <strong>Kullanım Alanları:</strong>
                            <ul class="list-disc list-inside mt-1 space-y-1">
                                <li>Facebook Pixel, LinkedIn Insight Tag</li>
                                <li>Google/Bing Site Verification</li>
                                <li>Custom CSS veya Meta Tags</li>
                                <li>Heatmap/Analytics araçları (Hotjar, Clarity vb.)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Footer Özel Kod -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 inline-block mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        Footer Özel Kod Alanı
                    </h4>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <code class="text-xs bg-gray-100 px-2 py-1 rounded">&lt;/body&gt;</code> etiketi öncesine eklenecek kodlar
                        </label>
                        <textarea name="custom_footer_code" 
                                  rows="8"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-mono text-sm"
                                  placeholder="<!-- Chatbot, Analytics, Custom JavaScript vb. -->">{{ $settings['custom_footer_code'] ?? '' }}</textarea>
                        <div class="mt-2 p-3 bg-white border border-green-100 rounded text-xs text-gray-600">
                            <strong>Kullanım Alanları:</strong>
                            <ul class="list-disc list-inside mt-1 space-y-1">
                                <li>Chatbot scriptleri (Tawk.to, Intercom, Tidio vb.)</li>
                                <li>Performance Tracking kodları</li>
                                <li>Custom JavaScript kodları</li>
                                <li>A/B Testing araçları (Google Optimize vb.)</li>
                            </ul>
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

                    <!-- Map Preview -->
                    <div x-show="$el.closest('form').querySelector('[name=contact_google_maps_embed]').value.trim() !== ''" 
                         class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Önizleme</label>
                        <div class="w-full h-64 border border-gray-300 rounded-lg overflow-hidden bg-gray-50" 
                             x-html="$el.closest('form').querySelector('[name=contact_google_maps_embed]').value">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Sosyal Medya -->
            <div id="tab-social" class="tab-content p-6 space-y-6 hidden">
                
                <h3 class="text-lg font-bold text-gray-900 mb-4">Sosyal Medya Hesapları</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                            Instagram
                        </label>
                        <input type="url" 
                               name="social_instagram" 
                               value="{{ $settings['social_instagram'] ?? '' }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="https://instagram.com/gmsgarage">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </label>
                        <input type="url" 
                               name="social_facebook" 
                               value="{{ $settings['social_facebook'] ?? '' }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="https://facebook.com/gmsgarage">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Twitter (X)
                        </label>
                        <input type="url" 
                               name="social_twitter" 
                               value="{{ $settings['social_twitter'] ?? '' }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="https://twitter.com/gmsgarage">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                            YouTube
                        </label>
                        <input type="url" 
                               name="social_youtube" 
                               value="{{ $settings['social_youtube'] ?? '' }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="https://youtube.com/@gmsgarage">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </label>
                        <input type="url" 
                               name="social_linkedin" 
                               value="{{ $settings['social_linkedin'] ?? '' }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                               placeholder="https://linkedin.com/company/gmsgarage">
                    </div>
                </div>

                <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <p class="text-sm text-gray-700">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <strong>Not:</strong> Sosyal medya hesaplarınızın tam URL'lerini girin. Boş bırakılan alanlar web sitesinde görünmeyecektir.
                    </p>
                </div>
            </div>

            <!-- Tab Content: Footer Yönetimi -->
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
                                  rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                                  placeholder="© 2026 GMSGARAGE. Tüm hakları saklıdır.">{{ $settings['footer_copyright'] ?? '© 2026 GMSGARAGE. Tüm hakları saklıdır.' }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">
                            Footer'ın en altında görünecek telif hakkı metni.
                        </p>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Yasal Linkler ve Sayfa İçerikleri</h3>
                        <button type="button" 
                                onclick="addFooterLink()"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Yeni Link Ekle
                        </button>
                    </div>

                    <div id="footerLinksContainer" class="space-y-3">
                        <!-- Footer links buraya dinamik olarak eklenecek -->
                    </div>

                    <p id="emptyLinksMessage" class="text-center text-gray-500 py-8 hidden">
                        Henüz link eklenmedi. "Yeni Link Ekle" butonuna tıklayarak başlayın.
                    </p>
                </div>
            </div>

            <!-- Sticky Save Button -->
            <div id="stickySaveButton" class="fixed bottom-0 left-0 right-0 bg-white border-t-2 border-red-600 shadow-2xl z-40 px-6 py-4 transform transition-all duration-300 translate-y-full">
                <div class="container mx-auto flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-2 text-gray-700">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium">Değişikliklerinizi kaydetmeyi unutmayın</span>
                        </div>
                    </div>
                    <button type="submit" 
                            class="px-8 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-all transform hover:scale-105 flex items-center gap-2 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Ayarları Kaydet
                    </button>
                </div>
            </div>

            <!-- Regular Save Button (Visible when sticky is hidden) -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end">
                <button type="submit" 
                        class="px-8 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                    </svg>
                    Ayarları Kaydet
                </button>
            </div>
        </form>
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
<!-- CKEditor 4 (Standard-All) -->
<script src="https://cdn.ckeditor.com/4.22.1/standard-all/ckeditor.js"></script>

<script>
// Global değişkenler
let footerLinks = {!! json_encode(json_decode($settings['footer_bottom_links'] ?? '[]', true)) !!};
let editorInstance = null;
let currentLinkIndex = null;
let currentSlug = '';
let modalTitle = '';

// Sayfa yüklendiğinde
document.addEventListener('DOMContentLoaded', function() {
    // CKEditor'ü başlat
    CKEDITOR.replace('contentEditor', {
        height: 400,
        language: 'tr',
        removePlugins: 'exportpdf'
    });
    editorInstance = CKEDITOR.instances.contentEditor;
    
    // Footer linklerini render et
    renderFooterLinks();
    
    // Sticky save button için scroll event
    window.addEventListener('scroll', handleStickyButton);
    
    // Modal kapatma (backdrop click)
    document.getElementById('contentModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeContentModal();
        }
    });
});

// Bakım modu toggle
function toggleMaintenanceInfo(isActive) {
    const statusEl = document.getElementById('maintenanceStatus');
    if (statusEl) {
        if (isActive) {
            statusEl.textContent = '(Aktif)';
            statusEl.classList.remove('text-gray-500');
            statusEl.classList.add('text-red-600');
        } else {
            statusEl.textContent = '(Kapalı)';
            statusEl.classList.remove('text-red-600');
            statusEl.classList.add('text-gray-500');
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
}

// Sticky save button handler
function handleStickyButton() {
    const stickyButton = document.getElementById('stickySaveButton');
    if (window.scrollY > 200) {
        stickyButton.classList.remove('translate-y-full');
        stickyButton.classList.add('translate-y-0');
    } else {
        stickyButton.classList.remove('translate-y-0');
        stickyButton.classList.add('translate-y-full');
    }
}

// Footer link ekleme
function addFooterLink() {
    footerLinks.push({ label: '', url: '' });
    renderFooterLinks();
}

// Footer link silme
function removeFooterLink(index) {
    Swal.fire({
        title: 'Emin misiniz?',
        text: 'Bu link silinecek!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#E32222',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Evet, Sil',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            footerLinks.splice(index, 1);
            renderFooterLinks();
            Swal.fire('Silindi!', 'Link kaldırıldı.', 'success');
        }
    });
}

// URL slug oluşturma
function updateUrl(index, label) {
    if (!label) return;
    const slug = label.toLowerCase()
        .replace(/ğ/g, 'g').replace(/ü/g, 'u').replace(/ş/g, 's')
        .replace(/ı/g, 'i').replace(/ö/g, 'o').replace(/ç/g, 'c')
        .replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    footerLinks[index].url = slug;
    renderFooterLinks();
}

// Modal açma
function openContentModal(index) {
    const link = footerLinks[index];
    if (!link.label || !link.url) {
        Swal.fire({
            icon: 'warning',
            title: 'Geçersiz Link',
            text: 'Lütfen önce başlığı girin ve URL oluşsun.'
        });
        return;
    }
    
    currentLinkIndex = index;
    currentSlug = link.url;
    modalTitle = link.label;
    
    document.getElementById('modalTitle').textContent = modalTitle + ' - İçerik Düzenleme';
    document.getElementById('contentModal').classList.remove('hidden');
    
    // Mevcut içeriği yükle
    fetch('/admin/api/pages/get-by-slug?slug=' + encodeURIComponent(currentSlug))
        .then(res => res.json())
        .then(data => {
            if (editorInstance && data.content) {
                editorInstance.setData(data.content);
            }
        })
        .catch(() => {
            if (editorInstance) {
                editorInstance.setData('');
            }
        });
}

// Modal kapatma
function closeContentModal() {
    document.getElementById('contentModal').classList.add('hidden');
    if (editorInstance) {
        editorInstance.setData('');
    }
}

// Modal içerik kaydetme
function saveModalContent() {
    if (!editorInstance) return;
    
    const content = editorInstance.getData();
    const csrf = document.querySelector('meta[name=csrf-token]').content;
    
    fetch('/admin/api/pages/store-or-update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({
            slug: currentSlug,
            title: modalTitle,
            content: content
        })
    })
    .then(res => res.json())
    .then(data => {
        closeContentModal();
        Swal.fire({
            icon: 'success',
            title: 'Başarılı!',
            text: 'Sayfa içeriği kaydedildi.',
            timer: 2000
        });
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Hata!',
            text: 'İçerik kaydedilemedi.'
        });
    });
}

// Footer linklerini render etme
function renderFooterLinks() {
    const container = document.getElementById('footerLinksContainer');
    const emptyMessage = document.getElementById('emptyLinksMessage');
    
    if (footerLinks.length === 0) {
        container.innerHTML = '';
        emptyMessage.classList.remove('hidden');
        return;
    }
    
    emptyMessage.classList.add('hidden');
    
    container.innerHTML = footerLinks.map((link, index) => `
        <div class="flex gap-3 items-center bg-gray-50 p-4 rounded-lg border border-gray-200">
            <div class="flex-1">
                <input type="text" 
                       value="${link.label || ''}"
                       name="footer_bottom_links[${index}][label]"
                       oninput="footerLinks[${index}].label = this.value; updateUrl(${index}, this.value)"
                       placeholder="Başlık (Örn: KVKK)"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
            </div>
            
            <div class="flex-1">
                <input type="text" 
                       value="${link.url || ''}"
                       name="footer_bottom_links[${index}][url]"
                       readonly
                       placeholder="URL (otomatik oluşur)"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 text-sm cursor-not-allowed">
            </div>
            
            <button type="button" 
                    onclick="openContentModal(${index})"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 whitespace-nowrap text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                İçeriği Düzenle
            </button>
            
            <button type="button" 
                    onclick="removeFooterLink(${index})"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Sil
            </button>
        </div>
    `).join('');
}
</script>
@endpush
