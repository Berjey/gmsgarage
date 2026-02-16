<!DOCTYPE html>
<html lang="tr" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', ($settings['site_title'] ?? 'GMSGARAGE') . ' - Premium Oto Galeri')</title>
    <meta name="description" content="@yield('description', $settings['site_description'] ?? 'GMSGARAGE - Premium ikinci el araçlar, garantili ve bakımlı araçlar. En iyi fiyat garantisi.')">
    <meta name="keywords" content="@yield('keywords', $settings['site_keywords'] ?? 'ikinci el araç, oto galeri, garantili araç, premium araç, GMSGARAGE')">
    <meta name="author" content="{{ $settings['site_title'] ?? 'GMSGARAGE' }}">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    
    <!-- Robots Meta Tag (Arama Motoru İndeksleme) -->
    <meta name="robots" content="{{ $settings['robots_index'] ?? 'index,follow' }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:title" content="@yield('og_title', ($settings['og_title'] ?? $settings['site_title'] ?? 'GMSGARAGE') . ' - Premium Oto Galeri')">
    <meta property="og:description" content="@yield('og_description', $settings['site_description'] ?? 'GMSGARAGE - Premium ikinci el araçlar, garantili ve bakımlı araçlar. En iyi fiyat garantisi.')">
    @php
        $defaultOgImage = !empty($settings['og_image']) 
            ? asset('storage/' . $settings['og_image']) 
            : asset('images/light-mode-logo.png');
    @endphp
    <meta property="og:image" content="@yield('og_image', $defaultOgImage)">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="tr_TR">
    <meta property="og:site_name" content="{{ $settings['site_title'] ?? 'GMSGARAGE' }}">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="@yield('og_url', url()->current())">
    <meta name="twitter:title" content="@yield('og_title', ($settings['og_title'] ?? $settings['site_title'] ?? 'GMSGARAGE') . ' - Premium Oto Galeri')">
    <meta name="twitter:description" content="@yield('og_description', $settings['site_description'] ?? 'GMSGARAGE - Premium ikinci el araçlar, garantili ve bakımlı araçlar. En iyi fiyat garantisi.')">
    <meta name="twitter:image" content="@yield('og_image', $defaultOgImage)">
    
    @stack('meta')
    
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/legal-modal.js'])
    
    @stack('styles')
    
    <!-- Google Analytics (GA4) -->
    @if(!empty($settings['google_analytics_id']))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings['google_analytics_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $settings['google_analytics_id'] }}');
    </script>
    @endif
</head>
<body class="bg-gray-50 dark:bg-[#1e1e1e] transition-colors duration-200">
    @include('components.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('components.footer')
    
    <!-- WhatsApp Sabit Butonu - Modern Design -->
    @if(!empty($settings['contact_whatsapp']))
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['contact_whatsapp']) }}?text=Merhaba, araçlarınız hakkında bilgi almak istiyorum." 
       target="_blank" 
       class="fixed bottom-6 right-6 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-4 rounded-full shadow-2xl z-50 transition-all duration-500 hover:scale-110 hover:rotate-12 group">
        <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
        <span class="absolute -top-2 -right-2 w-4 h-4 bg-red-500 rounded-full animate-pulse"></span>
    </a>
    @endif
    
    <!-- Kampanya Pop-up Modal -->
    @if(!empty($settings['popup_status']) && $settings['popup_status'] == '1')
    <div id="campaignPopup" class="hidden fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop - Blur Effect -->
        <div class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-opacity" onclick="closeCampaignPopup()"></div>
        
        <!-- Modal Container -->
        <div class="flex min-h-full items-center justify-center p-4">
            <!-- Modal Content -->
            <div class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all w-full max-w-lg">
                
                <!-- Close Button -->
                <button type="button" 
                        onclick="closeCampaignPopup()"
                        class="absolute top-4 right-4 z-10 bg-white hover:bg-gray-100 text-gray-600 hover:text-gray-900 rounded-full p-2 shadow-lg transition-all duration-200 hover:scale-110">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <!-- Image (if exists) -->
                @if(!empty($settings['popup_image']))
                <div class="w-full">
                    <img src="{{ asset('storage/' . $settings['popup_image']) }}" 
                         alt="{{ $settings['popup_title'] ?? 'Kampanya' }}"
                         class="w-full h-auto object-cover">
                </div>
                @endif
                
                <!-- Text Content -->
                <div class="p-8 text-center">
                    @if(!empty($settings['popup_title']))
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
                        {{ $settings['popup_title'] }}
                    </h3>
                    @endif
                    
                    @if(!empty($settings['popup_text']))
                    <p class="text-base text-gray-600 mb-6 leading-relaxed">
                        {{ $settings['popup_text'] }}
                    </p>
                    @endif
                    
                    <!-- Action Button -->
                    @if(!empty($settings['popup_link']))
                    <a href="{{ $settings['popup_link'] }}" 
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-bold text-lg rounded-xl transition-all duration-200 hover:scale-105 shadow-lg hover:shadow-xl">
                        {{ $settings['popup_button_text'] ?? 'Detayları İncele' }}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    @endif
                </div>
                
            </div>
        </div>
    </div>

    <!-- Pop-up Cookie Control Script -->
    <script>
        // Cookie helper functions
        function setCookie(name, value, days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
        }

        function getCookie(name) {
            const nameEQ = name + "=";
            const ca = document.cookie.split(';');
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        // Pop-up control
        function closeCampaignPopup() {
            const popup = document.getElementById('campaignPopup');
            if (popup) {
                popup.classList.add('hidden');
                
                // Set cookie based on frequency
                const frequency = '{{ $settings["popup_display_frequency"] ?? "daily" }}';
                
                if (frequency === 'always') {
                    // Don't set cookie, will show every time
                } else if (frequency === 'daily') {
                    setCookie('gms_campaign_popup_seen', '1', 1); // 1 day
                } else if (frequency === 'once') {
                    setCookie('gms_campaign_popup_seen', '1', 365); // 1 year (permanent)
                }
            }
        }

        // Show popup on page load if not seen
        document.addEventListener('DOMContentLoaded', function() {
            const frequency = '{{ $settings["popup_display_frequency"] ?? "daily" }}';
            const hasSeenPopup = getCookie('gms_campaign_popup_seen');
            
            // Show popup if:
            // - frequency is 'always' (test mode), OR
            // - user hasn't seen it yet (no cookie)
            if (frequency === 'always' || !hasSeenPopup) {
                setTimeout(function() {
                    const popup = document.getElementById('campaignPopup');
                    if (popup) {
                        popup.classList.remove('hidden');
                    }
                }, 1000); // Show after 1 second delay
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeCampaignPopup();
            }
        });
    </script>
    @endif
    
    @stack('scripts')
</body>
</html>
