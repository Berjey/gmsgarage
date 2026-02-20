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
    
    <!-- WhatsApp Sabit Butonu -->
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

    <!-- ===== KAMPANYA POP-UP ===== -->
    @php
        $popupActive = !empty($settings['popup_status']) && ($settings['popup_status'] == '1' || $settings['popup_status'] === 1);
    @endphp
    @if($popupActive)

    <style>
        @keyframes gmsPopupIn {
            from { opacity: 0; transform: translateY(16px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes gmsBdIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        #campaignPopup {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        #campaignPopup.is-open {
            display: flex;
        }
        #campaignPopup .gms-bd {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.72);
            animation: gmsBdIn 0.25s ease both;
        }
        #campaignPopup .gms-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            border-radius: 22px;
            overflow: hidden;
            background: #0f1117;
            border: 1px solid rgba(220,38,38,0.22);
            box-shadow: 0 28px 70px rgba(0,0,0,0.75);
            animation: gmsPopupIn 0.38s cubic-bezier(0.22,1,0.36,1) both;
        }
        .gms-x {
            position: absolute;
            top: 12px; right: 12px;
            z-index: 10;
            width: 32px; height: 32px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            border: none;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }
        .gms-x:hover { background: rgba(255,255,255,0.2); transform: scale(1.1) rotate(90deg); }
        .gms-header {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #dc2626 0%, #7f1d1d 100%);
            padding: 36px 28px 30px;
            text-align: center;
        }
        .gms-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(-45deg,transparent,transparent 9px,rgba(0,0,0,0.12) 9px,rgba(0,0,0,0.12) 10px);
        }
        .gms-header-inner { position: relative; z-index: 1; }
        .gms-logo-wrap {
            display: inline-flex; align-items: center; justify-content: center;
            width: 52px; height: 52px;
            border-radius: 14px;
            background: rgba(255,255,255,0.15);
            margin-bottom: 10px;
        }
        .gms-brand {
            font-size: 14px; font-weight: 900;
            letter-spacing: 0.18em;
            color: #fff;
            margin-bottom: 10px;
        }
        .gms-badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 10px; font-weight: 700;
            letter-spacing: 0.12em; text-transform: uppercase;
            color: rgba(255,255,255,0.9);
            background: rgba(255,255,255,0.13);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 5px 12px; border-radius: 20px;
        }
        .gms-img-wrap {
            position: relative;
            width: 100%; height: 220px;
            overflow: hidden;
        }
        .gms-img-wrap img { width:100%; height:100%; object-fit:cover; }
        .gms-img-wrap::after {
            content:'';
            position:absolute; inset:0;
            background: linear-gradient(to bottom, transparent 40%, rgba(15,17,23,0.9) 100%);
        }
        .gms-body {
            padding: 28px 34px 32px;
            text-align: center;
        }
        .gms-divider {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 16px;
        }
        .gms-divider::before, .gms-divider::after {
            content: '';
            flex: 1; height: 1px;
            background: linear-gradient(to right, transparent, rgba(220,38,38,0.45));
        }
        .gms-divider::after { background: linear-gradient(to left, transparent, rgba(220,38,38,0.45)); }
        .gms-divider span {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: #dc2626;
            flex-shrink: 0;
        }
        .gms-title {
            font-size: 24px; font-weight: 900;
            color: #f0f2f5;
            line-height: 1.25;
            margin: 0 0 12px;
        }
        .gms-text {
            font-size: 14px; line-height: 1.7;
            color: #7a8290;
            margin: 0 0 26px;
        }
        .gms-btn {
            display: flex; align-items: center; justify-content: center; gap: 7px;
            width: 100%; padding: 14px;
            border-radius: 13px;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            box-shadow: 0 4px 18px rgba(220,38,38,0.35);
            color: #fff; font-size: 15px; font-weight: 700;
            border: none; cursor: pointer; text-decoration: none;
            transition: all 0.22s ease;
        }
        .gms-btn:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);
            box-shadow: 0 6px 24px rgba(220,38,38,0.5);
            transform: translateY(-1px);
            color: #fff;
        }
    </style>

    <div id="campaignPopup"
         aria-labelledby="gms-popup-title"
         role="dialog"
         aria-modal="true"
         data-popup="1">

        <div class="gms-bd" onclick="closeCampaignPopup()"></div>

        <div class="gms-card">

            <button class="gms-x" onclick="closeCampaignPopup()" aria-label="Kapat">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            @if(!empty($settings['popup_image']))
            <div class="gms-img-wrap">
                <img src="{{ asset('storage/' . $settings['popup_image']) }}"
                     alt="{{ $settings['popup_title'] ?? 'Kampanya' }}">
            </div>
            @else
            <div class="gms-header">
                <div class="gms-header-inner">
                    <div class="gms-logo-wrap">
                        <svg width="24" height="24" fill="white" viewBox="0 0 24 24">
                            <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.85 7h10.29l1.04 3H5.81l1.04-3zM19 17H5v-5h14v5z"/>
                            <circle cx="7.5" cy="14.5" r="1.5"/>
                            <circle cx="16.5" cy="14.5" r="1.5"/>
                        </svg>
                    </div>
                    <div class="gms-brand">GMS<span style="opacity:.6">GARAGE</span></div>
                </div>
            </div>
            @endif

            <div class="gms-body">
                <div class="gms-divider"><span></span></div>

                <h3 id="gms-popup-title" class="gms-title">
                    {{ !empty($settings['popup_title']) ? $settings['popup_title'] : 'Özel Fırsatlar' }}
                </h3>

                <p class="gms-text">
                    {{ !empty($settings['popup_text']) ? $settings['popup_text'] : 'Premium araçlarımızda sınırlı süreli özel kampanyalar sizi bekliyor.' }}
                </p>

                @if(!empty($settings['popup_link']))
                <a href="{{ $settings['popup_link'] }}" class="gms-btn">
                    {{ $settings['popup_button_text'] ?? 'Kampanyayı İncele' }}
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                @else
                <button onclick="closeCampaignPopup()" class="gms-btn">
                    {{ !empty($settings['popup_button_text']) ? $settings['popup_button_text'] : 'Tamam, Anladım' }}
                </button>
                @endif
            </div>

        </div>
    </div>

    <script>
        function setCookie(name, value, days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
        }

        function getCookie(name) {
            const nameEQ = name + '=';
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i].trim();
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length);
            }
            return null;
        }

        function closeCampaignPopup() {
            const popup = document.getElementById('campaignPopup');
            if (!popup) return;
            popup.classList.remove('is-open');
            const frequency = '{{ $settings["popup_display_frequency"] ?? "daily" }}';
            if (frequency === 'daily') {
                setCookie('gms_campaign_popup_seen', '1', 1);
            } else if (frequency === 'once') {
                setCookie('gms_campaign_popup_seen', '1', 365);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const forceShow = urlParams.get('show_campaign') === '1';
            const frequency = '{{ $settings["popup_display_frequency"] ?? "daily" }}';
            const hasSeenPopup = getCookie('gms_campaign_popup_seen');
            const showPopup = forceShow || frequency === 'always' || !hasSeenPopup;

            if (showPopup) {
                setTimeout(function () {
                    const popup = document.getElementById('campaignPopup');
                    if (popup) popup.classList.add('is-open');
                }, forceShow ? 0 : 700);
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeCampaignPopup();
        });
    </script>
    @endif

    @stack('scripts')
</body>
</html>
