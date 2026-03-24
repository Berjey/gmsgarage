@extends('layouts.app')

@section('title', $settings['site_title'] ?? 'GMSGARAGE')
@section('description', $settings['site_description'] ?? 'Premium ikinci el araÃ§lar, garantili ve bakÄ±mlÄ± araÃ§lar. En iyi fiyat garantisi ile hizmetinizdeyiz.')
@section('keywords', $settings['site_keywords'] ?? 'ikinci el araÃ§, oto galeri, garantili araÃ§, premium araÃ§, araÃ§ al, araÃ§ sat')
@section('og_title', ($settings['site_title'] ?? 'GMSGARAGE') . ' - Premium Ä°kinci El AraÃ§lar')
@section('og_description', $settings['site_description'] ?? 'Premium ikinci el araÃ§lar, garantili ve bakÄ±mlÄ± araÃ§lar. En iyi fiyat garantisi ile hizmetinizdeyiz.')
@section('og_url', route('home'))

@push('styles')
<style>
    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes sloganSlide {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .trigger-animation {
        animation: none !important;
        opacity: 0;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    .animate-slide-in-left {
        animation: slideInLeft 0.6s ease-out;
    }
    
    .animate-slide-in-right {
        animation: slideInRight 0.6s ease-out;
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }
    
    .tab-content {
        display: none;
        opacity: 0;
        /* Removed transform to prevent stacking context issues */
        transition: opacity 0.3s ease-in-out;
    }
    
    .tab-content.active {
        display: block;
        opacity: 1;
        /* Removed transform to prevent stacking context issues */
        animation: fadeInUp 0.4s ease-out;
    }
    
    .form-field {
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .form-field:focus-within {
        /* Removed transform to prevent stacking context issues */
    }

    /* ===== DROPDOWN WRAPPER - RELATIVE POSITIONING ===== */
    .hero-custom-dropdown {
        position: relative;
        z-index: 1;
    }
    
    /* CRITICAL: When dropdown is open, bring it to absolute front */
    .hero-custom-dropdown.dropdown-open {
        z-index: 999999 !important;
    }
    
    /* CRITICAL: Suppress z-index of sibling form-fields when any dropdown is open */
    .tab-content.active:has(.hero-custom-dropdown.dropdown-open) .form-field:not(:has(.dropdown-open)) {
        z-index: 0 !important;
    }

    /* ===== DROPDOWN PANEL BASE STYLES - CRITICAL FOR VISIBILITY ===== */
    .hero-custom-dropdown-panel {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        margin-top: 8px;
        
        /* CRITICAL: Solid background - no transparency */
        background-color: #ffffff;
        
        /* CRITICAL: Full opacity */
        opacity: 0;
        visibility: hidden;
        
        /* CRITICAL: Maximum z-index - above everything including other form fields */
        z-index: 999999;
        
        /* Styling */
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        
        /* Animation */
        transform: translateY(-10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        
        /* Remove any blur effects */
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
    }

    .hero-custom-dropdown-panel.open {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Dark Mode Dropdown Panel */
    .dark .hero-custom-dropdown-panel {
        /* CRITICAL: Solid dark background */
        background: linear-gradient(180deg, #242424 0%, #1a1a1a 100%);
        border-color: rgba(220, 38, 38, 0.3);
        
        /* Enhanced shadow for dark mode */
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7),
                    0 0 0 1px rgba(220, 38, 38, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.08),
                    0 0 40px rgba(220, 38, 38, 0.15);
    }

    /* ===== SHARED DROPDOWN OPTION STYLES - BÃœTÃœN DROPDOWN'LAR Ä°Ã‡Ä°N ORTAK ===== */
    
    /* Base option style - AraÃ§ Al & AraÃ§ Sat */
    .hero-custom-dropdown-option {
        display: flex;
        align-items: center;
        justify-content: flex-start; /* SOLDAN SAÄA HÄ°ZALAMA */
        padding: 14px 16px; /* STANDART: 14px dikey, 16px yatay */
        border-radius: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
        font-weight: 500; /* STANDART: 500 */
        font-size: 15px;   /* STANDART: 15px */
        color: #1f2937;
    }

    /* First option (genellikle "TÃ¼mÃ¼" veya placeholder) */
    .hero-custom-dropdown-option:first-child {
        background: #f3f4f6;
        margin-bottom: 4px;
    }

    /* HOVER - LIGHT MODE */
    .hero-custom-dropdown-option:hover {
        background-color: #fef2f2;
    }

    /* SELECTED - LIGHT MODE */
    .hero-custom-dropdown-option.selected {
        background-color: #fee2e2;
        border: 1px solid #fca5a5;
    }

    /* DARK MODE - Base */
    .dark .hero-custom-dropdown-option {
        color: #f3f4f6;
    }

    /* DARK MODE - First option */
    .dark .hero-custom-dropdown-option:first-child {
        background: linear-gradient(90deg, 
                    rgba(239, 68, 68, 0.15) 0%, 
                    rgba(239, 68, 68, 0.08) 50%,
                    transparent 100%);
    }

    /* DARK MODE - Hover */
    .dark .hero-custom-dropdown-option:hover {
        background: linear-gradient(90deg, 
                    rgba(239, 68, 68, 0.2) 0%, 
                    rgba(239, 68, 68, 0.08) 50%,
                    transparent 100%);
        box-shadow: inset 0 0 30px rgba(220, 38, 38, 0.15);
    }

    /* DARK MODE - Selected */
    .dark .hero-custom-dropdown-option.selected {
        background-color: #7f1d1d;
        border: 1px solid #991b1b;
    }

    /* Brand Dropdown - Ã–zel dÃ¼zenlemeler */
    .hero-brand-panel {
        max-height: 400px;
        overflow-y: auto;
    }

    .hero-brand-panel .brand-list {
        display: flex;
        flex-direction: column;
        padding: 4px;
    }

    /* Brand iÃ§in sola hizalama */
    .hero-brand-panel .hero-custom-dropdown-option {
        justify-content: flex-start;
    }

    /* Year Dropdown - Sadece container */
    .hero-year-panel {
        max-height: 350px;
        overflow-y: auto;
    }

    .hero-year-panel .year-list {
        display: flex;
        flex-direction: column;
        padding: 4px;
    }
    /* Ortak .hero-custom-dropdown-option stilini kullanÄ±r */

    /* Model Dropdown - Sadece container */
    .hero-model-panel {
        max-height: 350px;
        overflow-y: auto;
    }

    .hero-model-panel .model-list {
        display: flex;
        flex-direction: column;
        padding: 4px;
    }
    /* Ortak .hero-custom-dropdown-option stilini kullanÄ±r */

    /* Body Type Dropdown Styles */
    .hero-bodytype-panel {
        max-height: 350px;
        overflow-y: auto;
    }

    .hero-bodytype-panel .bodytype-list {
        display: flex;
        flex-direction: column;
        padding: 4px;
    }

    .hero-bodytype-panel .hero-custom-dropdown-option {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 14px 16px;
        border-radius: 8px;
        transition: all 0.2s;
        cursor: pointer;
        font-weight: 600;
        font-size: 16px;
        color: #1f2937;
    }

    .hero-bodytype-panel .hero-custom-dropdown-option:first-child {
        background: #f3f4f6;
        margin-bottom: 4px;
        font-weight: 500;
        font-size: 14px;
    }

    .hero-bodytype-panel .hero-custom-dropdown-option:hover {
        background-color: #fef2f2;
    }

    .hero-bodytype-panel .hero-custom-dropdown-option.selected {
        background-color: #fee2e2;
        border: 1px solid #fca5a5;
    }

    .dark .hero-bodytype-panel .hero-custom-dropdown-option {
        color: #f3f4f6;
    }

    .dark .hero-bodytype-panel .hero-custom-dropdown-option:first-child {
        background: linear-gradient(90deg, 
                    rgba(239, 68, 68, 0.15) 0%, 
                    rgba(239, 68, 68, 0.08) 50%,
                    transparent 100%);
    }

    .dark .hero-bodytype-panel .hero-custom-dropdown-option:hover {
        background: linear-gradient(90deg, 
                    rgba(239, 68, 68, 0.2) 0%, 
                    rgba(239, 68, 68, 0.08) 50%,
                    transparent 100%);
        box-shadow: inset 0 0 30px rgba(220, 38, 38, 0.15);
    }

    .dark .hero-bodytype-panel .hero-custom-dropdown-option.selected {
        background-color: #7f1d1d;
        border-color: #b91c1c;
    }

    /* Fuel Type Dropdown - Sadece container */
    .hero-fueltype-panel {
        max-height: 350px;
        overflow-y: auto;
    }

    .hero-fueltype-panel .fueltype-list {
        display: flex;
        flex-direction: column;
        padding: 4px;
    }
    /* Ortak .hero-custom-dropdown-option stilini kullanÄ±r */

    /* Transmission Dropdown - Sadece container */
    .hero-transmission-panel {
        max-height: 350px;
        overflow-y: auto;
    }

    .hero-transmission-panel .transmission-list {
        display: flex;
        flex-direction: column;
        padding: 4px;
    }
    /* Ortak .hero-custom-dropdown-option stilini kullanÄ±r */

    /* Version Dropdown - Container ve Ã¶zel stiller */
    .hero-version-panel {
        max-height: 350px;
        overflow-y: auto;
    }

    .hero-version-panel .version-list {
        display: flex;
        flex-direction: column;
        padding: 4px;
    }

    /* Version iÃ§in Ã¶zel dÃ¼zenlemeler (iki satÄ±rlÄ± gÃ¶rÃ¼nÃ¼m) */
    .hero-version-panel .hero-custom-dropdown-option {
        flex-direction: column;
        align-items: flex-start;
    }

    .hero-version-panel .hero-custom-dropdown-option .version-props {
        font-size: 11px;
        font-weight: 400;
        color: #6b7280;
        margin-top: 4px;
    }

    .hero-version-panel .hero-custom-dropdown-option:first-child {
        align-items: center; /* Ä°lk seÃ§enek ortalÄ± */
    }

    .dark .hero-version-panel .hero-custom-dropdown-option .version-props {
        color: #9ca3af;
    }

    /* Color Dropdown - Sadece container */
    .hero-color-panel {
        max-height: 350px;
        overflow-y: auto;
    }

    .hero-color-panel .color-list {
        display: flex;
        flex-direction: column;
        padding: 4px;
    }
    /* Ortak .hero-custom-dropdown-option stilini kullanÄ±r */

    /* Form field animation */
    .form-field.slide-in {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Dropdown trigger compact styles */
    .hero-custom-dropdown-trigger {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        border-radius: 8px;
        background: white;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .hero-custom-dropdown-trigger:hover {
        border-color: #3b82f6;
    }

    .hero-custom-dropdown-trigger .selected-text {
        flex: 1;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 600;
        color: #111827; /* SeÃ§ili deÄŸer - Ã§ok koyu */
    }

    /* PLACEHOLDER - Daha okunabilir, ama seÃ§ili deÄŸerden aÃ§Ä±kÃ§a farklÄ± */
    .hero-custom-dropdown-trigger .selected-text.placeholder {
        color: #6b7280; /* Placeholder - orta ton gri, okunabilir */
        font-weight: 500; /* Placeholder daha ince */
    }

    .dark .hero-custom-dropdown-trigger {
        background: #2a2a2a;
    }

    .dark .hero-custom-dropdown-trigger .selected-text {
        color: #f9fafb; /* Dark mode - seÃ§ili deÄŸer Ã§ok aÃ§Ä±k */
    }

    /* DARK MODE PLACEHOLDER - Daha okunabilir */
    .dark .hero-custom-dropdown-trigger .selected-text.placeholder {
        color: #9ca3af; /* Dark mode placeholder - daha aÃ§Ä±k gri */
        font-weight: 500;
    }

    /* Disabled dropdown styles */
    .hero-custom-dropdown.disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    .hero-custom-dropdown.disabled .hero-custom-dropdown-trigger {
        cursor: not-allowed;
        background-color: #f3f4f6;
    }

    .dark .hero-custom-dropdown.disabled .hero-custom-dropdown-trigger {
        background-color: #1f2937;
    }
</style>
@endpush

@section('content')
    <!-- Hero Section - Modern Design -->
    <section class="relative bg-white dark:bg-[#1e1e1e] overflow-hidden transition-colors duration-200">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute top-20 right-10 w-96 h-96 opacity-5">
                <svg viewBox="0 0 400 400" fill="none" class="w-full h-full">
                    <path d="M0,200 Q200,0 400,200 T800,200" stroke="currentColor" stroke-width="2" class="text-primary-600"/>
                    <path d="M0,250 Q200,50 400,250 T800,250" stroke="currentColor" stroke-width="2" class="text-primary-600"/>
                </svg>
            </div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary-100 rounded-full blur-3xl opacity-20"></div>
        </div>
        
        <div class="container-custom relative z-10 py-12 lg:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                <!-- Left Side - Modern Search Form -->
                <div class="order-2 lg:order-1 animate-slide-in-left">
                    <div class="bg-white dark:bg-[#252525] rounded-2xl shadow-2xl border-b-4 border-primary-600 dark:border-primary-500 overflow-visible hover:shadow-3xl transition-shadow duration-300 hero-form-card">
                        <!-- Tabs -->
                        <div class="flex border-b-2 border-gray-100 dark:border-gray-800 relative">
                            <button id="tab-sell" 
                                    class="hero-tab active">
                                <span class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>ARAÃ‡ SAT</span>
                                </span>
                            </button>
                            <button id="tab-buy" 
                                    class="hero-tab">
                                <span class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <span>ARAÃ‡ AL</span>
                                </span>
                            </button>
                        </div>
                        
                        <!-- AraÃ§ Sat Form -->
                        <div id="form-sell" class="tab-content active">
                            <form method="GET" action="{{ route('evaluation.index') }}" id="sell-form" class="p-6 space-y-5">
                                <!-- Marka -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">MARKA</label>
                                    <div class="hero-custom-dropdown hero-brand-dropdown" data-dropdown="brand-sell" id="brand-dropdown-sell">
                                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300 dark:border-gray-700 dark:bg-[#2a2a2a] dark:text-gray-100" data-value="" data-brand-id="">
                                            <span class="selected-text placeholder dark:text-gray-400">Marka SeÃ§in</span>
                                            <svg class="arrow w-6 h-6 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div class="hero-custom-dropdown-panel hero-brand-panel">
                                            <div class="brand-loading hidden p-4 text-center">
                                                <svg class="animate-spin h-6 w-6 mx-auto text-primary-600" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                <p class="mt-2 text-sm text-gray-500">Markalar yÃ¼kleniyor...</p>
                                            </div>
                                            <div class="brand-list">
                                                <div class="hero-custom-dropdown-option" data-value="" data-brand-id="">Marka SeÃ§in</div>
                                            </div>
                                        </div>
                                        <select name="marka" required class="hero-custom-dropdown-native">
                                            <option value="">Marka SeÃ§in</option>
                                        </select>
                                        <input type="hidden" name="marka_id" id="marka-id-input" value="">
                                    </div>
                                </div>

                                <!-- Button -->
                                <button type="submit" class="btn btn-primary w-full py-5 px-6 text-lg">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    <span>DEVAM ET</span>
                                </button>
                            </form>
                        </div>
                        
                        <!-- AraÃ§ Al Form - SadeleÅŸtirilmiÅŸ -->
                        <div id="form-buy" class="tab-content">
                            <form method="GET" action="{{ route('vehicles.index') }}" id="buy-form" class="p-6 space-y-5">
                                <!-- Marka -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">MARKA</label>
                                    <div class="hero-custom-dropdown" data-dropdown="brand-buy">
                                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300 dark:border-gray-700 dark:bg-[#2a2a2a] dark:text-gray-100" data-value="">
                                            <span class="selected-text placeholder">TÃ¼m Markalar</span>
                                            <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div class="hero-custom-dropdown-panel">
                                            <div class="hero-custom-dropdown-option" data-value="">TÃ¼m Markalar</div>
                                            @foreach($brands ?? [] as $brand)
                                                <div class="hero-custom-dropdown-option" data-value="{{ $brand->name }}">{{ $brand->name }}</div>
                                            @endforeach
                                        </div>
                                        <select name="brand" class="hero-custom-dropdown-native">
                                            <option value="">TÃ¼m Markalar</option>
                                            @foreach($brands ?? [] as $brand)
                                                <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- YardÄ±mcÄ± Metin -->
                                <div class="text-center py-2">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                                        DetaylÄ± seÃ§im iÃ§in 
                                        <a href="{{ route('vehicles.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold underline">
                                            AraÃ§lar sayfasÄ±na
                                        </a> 
                                        gÃ¶z atabilirsiniz.
                                    </p>
                                </div>
                                
                                <!-- Button -->
                                <button type="submit" class="btn btn-primary w-full py-5 px-6 text-lg">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <span>ARAÃ‡LARI ARA</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Dynamic Headline & Image -->
                <div class="order-1 lg:order-2 mt-0 lg:mt-6">
                    <h1 id="slogan-title" class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                        <span class="slogan-content">AracÄ±nÄ± <span class="slogan-highlight-red text-primary-600 dark:text-primary-500">GÃ¼venle</span> Sat</span>
                    </h1>
                    <p id="slogan-description" class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-8 max-w-lg leading-relaxed">
                        <span class="slogan-content">HÄ±zlÄ± teklif alÄ±n, gÃ¼venli sÃ¼reÃ§ten geÃ§in. AracÄ±nÄ±zÄ±n gerÃ§ek deÄŸerini Ã¶ÄŸrenin ve en iyi fiyatÄ± garantileyin.</span>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Red Bottom Section -->
        <div class="bg-primary-600 h-32 lg:h-40 relative overflow-hidden">
            <!-- Diagonal lines pattern -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute inset-0" style="background: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(255,255,255,0.1) 20px, rgba(255,255,255,0.1) 40px);"></div>
            </div>
        </div>
    </section>

    <!-- Ã–ne Ã‡Ä±kan AraÃ§lar -->
    <section class="section-padding bg-gradient-to-b from-gray-50 to-white dark:from-[#1e1e1e] dark:to-[#252525] relative overflow-hidden transition-colors duration-200">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-20 left-10 w-72 h-72 bg-primary-600 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-primary-400 rounded-full blur-3xl"></div>
        </div>
        
        <div class="container-custom relative z-10">
            <div class="flex items-center justify-between mb-12 reveal">
                <div>
                    <h2 class="heading-primary mb-2">
                        <span class="text-gradient">Ã–ne Ã‡Ä±kan AraÃ§lar</span>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 text-lg">En popÃ¼ler ve Ã¶ne Ã§Ä±kan araÃ§larÄ±mÄ±zÄ± keÅŸfedin</p>
                </div>
                <a href="{{ route('vehicles.index') }}" class="hidden md:flex items-center text-primary-600 dark:text-primary-400 font-semibold hover:text-primary-700 dark:hover:text-primary-300 group transition-all duration-300">
                    <span>TÃ¼mÃ¼nÃ¼ GÃ¶r</span>
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            
            @if($featuredVehicles->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @foreach($featuredVehicles as $index => $vehicle)
                        <div class="reveal" style="animation-delay: {{ $index * 0.1 }}s">
                            <x-vehicle-card :vehicle="$vehicle" />
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-12 reveal">
                    <a href="{{ route('vehicles.index') }}" class="btn btn-primary text-lg px-8">
                        TÃ¼m AraÃ§larÄ± GÃ¶rÃ¼ntÃ¼le
                    </a>
                </div>
            @else
                <div class="text-center py-12 reveal">
                    <p class="text-gray-600 dark:text-gray-400">Åu an Ã¶ne Ã§Ä±kan araÃ§ bulunmamaktadÄ±r.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="section-padding bg-white dark:bg-[#1e1e1e] relative overflow-hidden transition-colors duration-200">
        <!-- Decorative Background -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-0 right-0 w-96 h-96 bg-primary-400 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-primary-600 rounded-full blur-3xl"></div>
        </div>
        
        <div class="container-custom relative z-10">
            <div class="text-center mb-16 reveal">
                <h2 class="heading-primary mb-4">
                    <span class="text-gradient">Neden GMSGARAGE?</span>
                </h2>
                <p class="text-gray-600 dark:text-gray-300 text-lg max-w-2xl mx-auto">Size sunduÄŸumuz avantajlar ile fark yaratÄ±yoruz</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group reveal hover-lift bg-white dark:bg-[#252525] rounded-2xl p-6 shadow-md dark:shadow-xl dark:border dark:border-gray-800 transition-all duration-200">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Garantili AraÃ§lar</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">TÃ¼m araÃ§larÄ±mÄ±z garantili ve bakÄ±mlÄ±dÄ±r. GÃ¼venle alÄ±ÅŸveriÅŸ yapÄ±n.</p>
                </div>
                
                <div class="text-center group reveal hover-lift bg-white dark:bg-[#252525] rounded-2xl p-6 shadow-md dark:shadow-xl dark:border dark:border-gray-800 transition-all duration-200" style="animation-delay: 0.1s">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">En Ä°yi Fiyat</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">PiyasanÄ±n en uygun fiyatlarÄ± ile hizmetinizdeyiz. Fiyat garantisi veriyoruz.</p>
                </div>
                
                <div class="text-center group reveal hover-lift bg-white dark:bg-[#252525] rounded-2xl p-6 shadow-md dark:shadow-xl dark:border dark:border-gray-800 transition-all duration-200" style="animation-delay: 0.2s">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Ekspertiz Hizmeti</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">TÃ¼m araÃ§larÄ±mÄ±z ekspertiz raporlu ve detaylÄ± kontrol edilmiÅŸtir.</p>
                </div>
                
                <div class="text-center group reveal hover-lift bg-white dark:bg-[#252525] rounded-2xl p-6 shadow-md dark:shadow-xl dark:border dark:border-gray-800 transition-all duration-200" style="animation-delay: 0.3s">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">7/24 Destek</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">MÃ¼ÅŸteri hizmetlerimiz her zaman yanÄ±nÄ±zda. SorularÄ±nÄ±z iÃ§in bize ulaÅŸÄ±n.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding text-white relative overflow-hidden cta-section-modern">
        <!-- Animated Gradient Background (very slow) -->
        <div class="absolute inset-0 cta-gradient-animation"></div>
        
        <!-- Subtle Pattern Overlay -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <!-- Decorative Shapes -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;"></div>
        
        <div class="container-custom text-center relative z-10">
            <div class="reveal">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 tracking-tight text-gray-900 dark:text-white">
                    <span class="bg-gradient-to-r from-white via-white to-white/90 bg-clip-text text-transparent">Hayalinizdeki AracÄ±</span>
                    <br>
                    <span class="bg-gradient-to-r from-white via-white to-white/90 bg-clip-text text-transparent">Bulun</span>
                </h2>
                <p class="text-xl md:text-2xl text-white/95 mb-10 max-w-3xl mx-auto leading-relaxed font-medium">
                    <span class="font-semibold">AI destekli</span> araÃ§ arama ve deÄŸerleme teknolojisi ile hayalinizdeki aracÄ± kolayca bulun. 
                    <span class="font-semibold">GÃ¼venli</span> ve <span class="font-semibold">ÅŸeffaf</span> alÄ±ÅŸveriÅŸ deneyimi.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center mb-8">
                    <a href="{{ route('vehicles.index') }}" class="btn bg-white text-primary-600 hover:bg-gray-100 text-lg px-10 py-4 shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 font-semibold group">
                        <span>AraÃ§larÄ± Ä°ncele</span>
                        <svg class="w-5 h-5 ml-2 inline-block group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="btn border-2 border-white text-white hover:bg-white hover:text-primary-600 text-lg px-10 py-4 backdrop-blur-sm bg-white/10 hover:bg-white transition-all duration-300 font-semibold group">
                        <span>Ä°letiÅŸime GeÃ§</span>
                        <svg class="w-5 h-5 ml-2 inline-block group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </a>
                </div>
                
                <!-- GÃ¼ven Ä°konlu Bilgi SatÄ±rÄ± -->
                <div class="flex items-center justify-center gap-3 text-white/80 text-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span>GÃ¼venli Ã¶deme â€¢ Garantili araÃ§lar â€¢ 7/24 destek</span>
                </div>
            </div>
        </div>
    </section>
    
    <style>
        @keyframes ctaGradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .cta-gradient-animation {
            background: linear-gradient(-45deg, #dc2626, #991b1b, #7f1d1d, #b91c1c, #dc2626);
            background-size: 400% 400%;
            animation: ctaGradient 20s ease infinite;
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.5; }
        }
        .animate-pulse-slow {
            animation: pulse-slow 4s ease-in-out infinite;
        }
    </style>
@endsection

@push('scripts')
<script>
    // Tab switching handled by app.js (initHeroTabs)

    // Brand & Year Dropdown API Integration
    let brandsLoaded = false;
    let brandsData = [];
    let selectedBrandId = null;
    let selectedYear = null;

    async function loadBrandsFromAPI() {
        if (brandsLoaded) return brandsData;

        const brandDropdown = document.getElementById('brand-dropdown-sell');
        if (!brandDropdown) return [];

        const loading = brandDropdown.querySelector('.brand-loading');
        const brandList = brandDropdown.querySelector('.brand-list');

        loading.classList.remove('hidden');

        try {
            const response = await fetch('/api/arabam/brands');
            const result = await response.json();

            if (result.success && result.data && result.data.Items) {
                brandsData = result.data.Items;
                brandsLoaded = true;

                // Clear existing options except first
                const firstOption = brandList.querySelector('.hero-custom-dropdown-option');
                brandList.innerHTML = '';
                brandList.appendChild(firstOption);

                // Add brand options
                brandsData.forEach(brand => {
                    const option = document.createElement('div');
                    option.className = 'hero-custom-dropdown-option';
                    option.setAttribute('data-value', brand.Name);
                    option.setAttribute('data-brand-id', brand.Id);
                    option.textContent = brand.Name;
                    brandList.appendChild(option);
                });

                // Update native select
                const nativeSelect = brandDropdown.querySelector('.hero-custom-dropdown-native');
                nativeSelect.innerHTML = '<option value="">Marka SeÃ§in</option>';
                brandsData.forEach(brand => {
                    const opt = document.createElement('option');
                    opt.value = brand.Name;
                    opt.textContent = brand.Name;
                    opt.setAttribute('data-brand-id', brand.Id);
                    nativeSelect.appendChild(opt);
                });

                // Re-init dropdown event listeners for new options
                initBrandDropdownOptions(brandDropdown);
            }
        } catch (error) {
            console.error('Error loading brands:', error);
        } finally {
            loading.classList.add('hidden');
        }

        return brandsData;
    }

    function initBrandDropdownOptions(dropdown) {
        const panel = dropdown.querySelector('.hero-custom-dropdown-panel');
        const options = panel.querySelectorAll('.hero-custom-dropdown-option');
        const trigger = dropdown.querySelector('.hero-custom-dropdown-trigger');
        const nativeSelect = dropdown.querySelector('.hero-custom-dropdown-native');
        const selectedText = trigger.querySelector('.selected-text');
        const brandIdInput = document.getElementById('marka-id-input');
        const formCard = document.querySelector('.hero-form-card');

        options.forEach(option => {
            option.addEventListener('click', function(e) {
                e.stopPropagation();
                const value = this.getAttribute('data-value');
                const brandId = this.getAttribute('data-brand-id');

                // Update trigger display
                selectedText.textContent = value || 'Marka SeÃ§in';
                if (value) {
                    selectedText.classList.remove('placeholder');
                } else {
                    selectedText.classList.add('placeholder');
                }

                // Update values
                trigger.setAttribute('data-value', value);
                trigger.setAttribute('data-brand-id', brandId || '');
                nativeSelect.value = value;
                if (brandIdInput) brandIdInput.value = brandId || '';
                selectedBrandId = brandId;
                selectedYear = null;

                // Update selected state
                options.forEach(opt => opt.classList.remove('selected'));
                if (value) this.classList.add('selected');

                // Close dropdown
                panel.classList.remove('open');
                trigger.classList.remove('open');
                dropdown.classList.remove('dropdown-open');

                // Enable all fields
                if (formCard) {
                    formCard.classList.remove('dropdown-open');
                    formCard.querySelectorAll('.form-field').forEach(field => {
                        field.style.pointerEvents = '';
                        field.style.opacity = '';
                    });
                    formCard.querySelectorAll('button[type="submit"]').forEach(btn => {
                        btn.style.pointerEvents = '';
                        btn.style.opacity = '';
                    });
                }

                // Brand selection is complete - form will submit to wizard page
            });
        });
    }

    // Custom Dropdown Implementation for Hero Section
    // MOVED TO END OF SCRIPT - see DOMContentLoaded at bottom

    function initBrandDropdown() {
        const brandDropdown = document.getElementById('brand-dropdown-sell');
        if (!brandDropdown) return;

        const trigger = brandDropdown.querySelector('.hero-custom-dropdown-trigger');
        const panel = brandDropdown.querySelector('.hero-custom-dropdown-panel');
        const formCard = document.querySelector('.hero-form-card');

        // Toggle dropdown
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();

            // Close other dropdowns
            document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(openPanel => {
                if (openPanel !== panel) {
                    openPanel.classList.remove('open');
                    const otherDropdown = openPanel.closest('.hero-custom-dropdown');
                    otherDropdown.querySelector('.hero-custom-dropdown-trigger').classList.remove('open');
                    otherDropdown.classList.remove('dropdown-open');
                }
            });

            // Toggle current dropdown
            const isOpen = panel.classList.contains('open');
            if (!isOpen) {
                panel.classList.add('open');
                trigger.classList.add('open');
                brandDropdown.classList.add('dropdown-open');

                // Load brands if not loaded
                if (!brandsLoaded) {
                    loadBrandsFromAPI();
                }

                // Disable other fields
                if (formCard) {
                    formCard.classList.add('dropdown-open');
                    const parentField = brandDropdown.closest('.form-field');
                    formCard.querySelectorAll('.form-field').forEach(field => {
                        if (field !== parentField) {
                            field.style.pointerEvents = 'none';
                            field.style.opacity = '0.6';
                        }
                    });
                    formCard.querySelectorAll('button[type="submit"]').forEach(btn => {
                        btn.style.pointerEvents = 'none';
                        btn.style.opacity = '0.6';
                    });
                }
            } else {
                panel.classList.remove('open');
                trigger.classList.remove('open');
                brandDropdown.classList.remove('dropdown-open');

                // Enable all fields
                if (formCard) {
                    formCard.classList.remove('dropdown-open');
                    formCard.querySelectorAll('.form-field').forEach(field => {
                        field.style.pointerEvents = '';
                        field.style.opacity = '';
                    });
                    formCard.querySelectorAll('button[type="submit"]').forEach(btn => {
                        btn.style.pointerEvents = '';
                        btn.style.opacity = '';
                    });
                }
            }
        });

        // Initialize default option click handler
        initBrandDropdownOptions(brandDropdown);
    }

    function initHeroCustomDropdowns() {
        const dropdowns = document.querySelectorAll('.hero-custom-dropdown');
        const formCard = document.querySelector('.hero-form-card');

        dropdowns.forEach(dropdown => {
            // Ã–zel handler'Ä± olan dropdown'larÄ± atla
            if (dropdown.classList.contains('hero-brand-dropdown')) return;
            if (dropdown.classList.contains('hero-year-dropdown')) return;
            if (dropdown.classList.contains('hero-model-dropdown')) return;
            if (dropdown.classList.contains('hero-bodytype-dropdown')) return;
            if (dropdown.classList.contains('hero-fueltype-dropdown')) return;
            if (dropdown.classList.contains('hero-transmission-dropdown')) return;
            if (dropdown.classList.contains('hero-version-dropdown')) return;
            if (dropdown.classList.contains('hero-color-dropdown')) return;

            const trigger = dropdown.querySelector('.hero-custom-dropdown-trigger');
            const panel = dropdown.querySelector('.hero-custom-dropdown-panel');
            const options = panel.querySelectorAll('.hero-custom-dropdown-option');
            const nativeSelect = dropdown.querySelector('.hero-custom-dropdown-native');
            const selectedText = trigger.querySelector('.selected-text');

            if (!trigger || !panel || !nativeSelect) return;
            
            // Function to disable other form fields
            function disableOtherFields() {
                if (formCard) {
                    formCard.classList.add('dropdown-open');
                    // Find the form-field that contains this dropdown
                    const parentField = dropdown.closest('.form-field');
                    
                    // Disable all form fields except the one containing the open dropdown
                    formCard.querySelectorAll('.form-field').forEach(field => {
                        if (field !== parentField && !field.contains(panel)) {
                            field.style.pointerEvents = 'none';
                            field.style.opacity = '0.6';
                        } else if (field === parentField) {
                            // Ensure parent field of open dropdown is fully opaque
                            field.style.opacity = '1';
                            field.style.pointerEvents = 'auto';
                        }
                    });
                    // Disable submit buttons
                    formCard.querySelectorAll('button[type="submit"]').forEach(btn => {
                        if (!btn.closest('.hero-custom-dropdown')) {
                            btn.style.pointerEvents = 'none';
                            btn.style.opacity = '0.6';
                        }
                    });
                }
            }
            
            // Function to enable all form fields
            function enableAllFields() {
                if (formCard) {
                    formCard.classList.remove('dropdown-open');
                    formCard.querySelectorAll('.form-field').forEach(field => {
                        field.style.pointerEvents = '';
                        field.style.opacity = '';
                    });
                    formCard.querySelectorAll('button[type="submit"]').forEach(btn => {
                        btn.style.pointerEvents = '';
                        btn.style.opacity = '';
                    });
                }
            }
            
            // Toggle dropdown
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                
                // Close other dropdowns
                document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(openPanel => {
                    if (openPanel !== panel) {
                        openPanel.classList.remove('open');
                        const otherDropdown = openPanel.closest('.hero-custom-dropdown');
                        otherDropdown.querySelector('.hero-custom-dropdown-trigger').classList.remove('open');
                        otherDropdown.classList.remove('dropdown-open');
                    }
                });
                
                // Toggle current dropdown
                const isOpen = panel.classList.contains('open');
                if (!isOpen) {
                    panel.classList.add('open');
                    trigger.classList.add('open');
                    dropdown.classList.add('dropdown-open');
                    disableOtherFields();
                    // Focus first option
                    const firstOption = panel.querySelector('.hero-custom-dropdown-option');
                    if (firstOption) {
                        firstOption.focus();
                    }
                } else {
                    panel.classList.remove('open');
                    trigger.classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                    enableAllFields();
                }
            });
            
            // Keyboard navigation
            let focusedIndex = -1;
            
            trigger.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    trigger.click();
                } else if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (!panel.classList.contains('open')) {
                        panel.classList.add('open');
                        trigger.classList.add('open');
                    }
                    focusedIndex = Math.min(focusedIndex + 1, options.length - 1);
                    options[focusedIndex]?.focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (panel.classList.contains('open')) {
                        focusedIndex = Math.max(focusedIndex - 1, 0);
                        options[focusedIndex]?.focus();
                    }
                }
            });
            
            options.forEach((option, index) => {
                option.setAttribute('tabindex', '0');
                
                option.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        option.click();
                    } else if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        focusedIndex = Math.min(index + 1, options.length - 1);
                        options[focusedIndex]?.focus();
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        focusedIndex = Math.max(index - 1, 0);
                        options[focusedIndex]?.focus();
                    } else if (e.key === 'Escape') {
                        e.preventDefault();
                        panel.classList.remove('open');
                        trigger.classList.remove('open');
                        trigger.focus();
                    }
                });
                
                option.addEventListener('focus', function() {
                    focusedIndex = index;
                    this.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                });
            });
            
            // Select option
            options.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const value = this.getAttribute('data-value');
                    const text = this.textContent.trim();
                    
                    // Update trigger
                    selectedText.textContent = text;
                    selectedText.classList.remove('placeholder');
                    trigger.setAttribute('data-value', value);
                    
                    // Update native select
                    nativeSelect.value = value;
                    nativeSelect.dispatchEvent(new Event('change', { bubbles: true }));
                    
                    // Update selected state
                    options.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    
                    // Close dropdown
                    panel.classList.remove('open');
                    trigger.classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                    enableAllFields();
                });
            });
            
            // Initialize selected value from native select
            if (nativeSelect.value) {
                const selectedOption = Array.from(options).find(opt => opt.getAttribute('data-value') === nativeSelect.value);
                if (selectedOption) {
                    selectedText.textContent = selectedOption.textContent.trim();
                    selectedText.classList.remove('placeholder');
                    trigger.setAttribute('data-value', nativeSelect.value);
                    selectedOption.classList.add('selected');
                }
            }
        });
        
        // Close dropdowns on outside click
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.hero-custom-dropdown')) {
                document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(openPanel => {
                    openPanel.classList.remove('open');
                    const dropdown = openPanel.closest('.hero-custom-dropdown');
                    dropdown.querySelector('.hero-custom-dropdown-trigger').classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                });
                // Enable all fields when closing
                if (formCard) {
                    formCard.classList.remove('dropdown-open');
                    formCard.querySelectorAll('.form-field').forEach(field => {
                        field.style.pointerEvents = '';
                        field.style.opacity = '';
                    });
                    formCard.querySelectorAll('button[type="submit"]').forEach(btn => {
                        btn.style.pointerEvents = '';
                        btn.style.opacity = '';
                    });
                }
            }
        });
        
        // Close dropdowns on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(openPanel => {
                    openPanel.classList.remove('open');
                    const dropdown = openPanel.closest('.hero-custom-dropdown');
                    dropdown.querySelector('.hero-custom-dropdown-trigger').classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                });
                // Enable all fields when closing
                if (formCard) {
                    formCard.classList.remove('dropdown-open');
                    formCard.querySelectorAll('.form-field').forEach(field => {
                        field.style.pointerEvents = '';
                        field.style.opacity = '';
                    });
                    formCard.querySelectorAll('button[type="submit"]').forEach(btn => {
                        btn.style.pointerEvents = '';
                        btn.style.opacity = '';
                    });
                }
            }
        });
    }
    
    // Form validation for Hero "ARABAMI DEÄERLE" button
    // Native form submit - JS only for validation
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switchers handled by app.js (initHeroTabs)
        
        // Initialize custom dropdowns FIRST
        initHeroCustomDropdowns();
        
        // Initialize brand dropdown
        initBrandDropdown();
        
        const sellForm = document.getElementById('sell-form');
        if (!sellForm) {
            // Form bulunamadÄ±, sessizce devam et
            return;
        }
        
        // Check if already bound
        if (sellForm.dataset.submitHandlerBound === 'true') {
            return;
        }
        sellForm.dataset.submitHandlerBound = 'true';
        
        // No validation - allow native form submit always
        // Form will submit to action="{{ route('evaluation.index') }}" with whatever values are filled
    });
</script>
@endpush
