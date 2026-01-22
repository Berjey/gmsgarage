@extends('layouts.app')

@section('title', 'GMSGARAGE - Premium Oto Galeri')
@section('description', 'Premium ikinci el araçlar, garantili ve bakımlı araçlar. En iyi fiyat garantisi ile hizmetinizdeyiz.')

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
    
    .slogan-animate {
        animation: sloganSlide 0.8s ease-out forwards;
    }
    
    .slogan-animate-delay {
        animation: sloganSlide 0.8s ease-out 0.3s forwards;
    }
    
    .trigger-animation {
        animation: none !important;
        opacity: 0;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
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
        transform: translateY(10px);
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    }
    
    .tab-content.active {
        display: block;
        opacity: 1;
        transform: translateY(0);
        animation: fadeInUp 0.4s ease-out;
    }
    
    .form-field {
        transition: all 0.3s ease;
    }
    
    .form-field:focus-within {
        transform: translateY(-2px);
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
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Left Side - Modern Search Form -->
                <div class="order-2 lg:order-1 animate-slide-in-left">
                    <div class="bg-white dark:bg-[#252525] rounded-2xl shadow-2xl border-b-4 border-primary-600 dark:border-primary-500 overflow-visible transform hover:shadow-3xl transition-shadow duration-300 hero-form-card">
                        <!-- Tabs -->
                        <div class="flex border-b-2 border-gray-100 dark:border-gray-800 relative">
                            <button id="tab-sell" 
                                    onclick="switchTab('sell')"
                                    class="hero-tab active">
                                <span class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>ARAÇ SAT</span>
                                </span>
                            </button>
                            <button id="tab-buy" 
                                    onclick="switchTab('buy')"
                                    class="hero-tab">
                                <span class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <span>ARAÇ AL</span>
                                </span>
                            </button>
                        </div>
                        
                        <!-- Araç Sat Form -->
                        <div id="form-sell" class="tab-content active">
                            <form method="GET" action="{{ route('evaluation.index') }}" id="sell-form" class="p-8 space-y-6">
                                <!-- Araç Tipi -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">ARAÇ TİPİ</label>
                                    <div class="hero-custom-dropdown" data-dropdown="vehicle-type-sell">
                                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300 dark:border-gray-700 dark:bg-[#2a2a2a] dark:text-gray-100" data-value="">
                                            <span class="selected-text placeholder dark:text-gray-400">Araç Tipi Seçin</span>
                                            <svg class="arrow w-6 h-6 text-gray-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div class="hero-custom-dropdown-panel">
                                            <div class="hero-custom-dropdown-option" data-value="">Araç Tipi Seçin</div>
                                            @foreach($vehicleTypes ?? [] as $key => $label)
                                                <div class="hero-custom-dropdown-option" data-value="{{ $key }}">{{ $label }}</div>
                                            @endforeach
                                        </div>
                                        <select name="tip" required class="hero-custom-dropdown-native">
                                            <option value="">Araç Tipi Seçin</option>
                                            @foreach($vehicleTypes ?? [] as $key => $label)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Model Yılı -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">MODEL YILI</label>
                                    <div class="hero-custom-dropdown" data-dropdown="year-sell">
                                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300 dark:border-gray-700 dark:bg-[#2a2a2a] dark:text-gray-100" data-value="{{ date('Y') }}">
                                            <span class="selected-text">{{ date('Y') }}</span>
                                            <svg class="arrow w-6 h-6 text-gray-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div class="hero-custom-dropdown-panel">
                                            <div class="hero-custom-dropdown-option" data-value="">Yıl Seçin</div>
                                            @foreach($years ?? [] as $year)
                                                <div class="hero-custom-dropdown-option {{ $year == date('Y') ? 'selected' : '' }}" data-value="{{ $year }}">{{ $year }}</div>
                                            @endforeach
                                        </div>
                                        <select name="yil" required class="hero-custom-dropdown-native">
                                            <option value="">Yıl Seçin</option>
                                            @foreach($years ?? [] as $year)
                                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Marka -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">MARKA</label>
                                    <div class="hero-custom-dropdown" data-dropdown="brand-sell">
                                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300 dark:border-gray-700 dark:bg-[#2a2a2a] dark:text-gray-100" data-value="">
                                            <span class="selected-text placeholder dark:text-gray-400">Marka Seçin</span>
                                            <svg class="arrow w-6 h-6 text-gray-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div class="hero-custom-dropdown-panel">
                                            <div class="hero-custom-dropdown-option" data-value="">Marka Seçin</div>
                                            @foreach($brands ?? [] as $brand)
                                                <div class="hero-custom-dropdown-option" data-value="{{ $brand }}">{{ $brand }}</div>
                                            @endforeach
                                        </div>
                                        <select name="marka" required class="hero-custom-dropdown-native">
                                            <option value="">Marka Seçin</option>
                                            @foreach($brands ?? [] as $brand)
                                                <option value="{{ $brand }}">{{ $brand }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Button -->                                
                                <button type="submit" class="btn btn-primary w-full py-5 px-6 text-lg">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <span>ARABAMI DEĞERLE</span>
                                </button>
                                
                                <!-- Link -->
                                <div class="text-center pt-2">
                                    <a href="{{ route('vehicle-request.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-semibold transition-colors duration-200 inline-flex items-center space-x-1">
                                        <span>Aracınızı listede bulamıyorsanız buraya tıklayın</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Araç Al Form - Sadeleştirilmiş -->
                        <div id="form-buy" class="tab-content">
                            <form method="GET" action="{{ route('vehicles.index') }}" id="buy-form" class="p-8 space-y-6">
                                <!-- Marka -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">MARKA</label>
                                    <div class="hero-custom-dropdown" data-dropdown="brand-buy">
                                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300 dark:border-gray-700 dark:bg-[#2a2a2a] dark:text-gray-100" data-value="">
                                            <span class="selected-text placeholder">Tüm Markalar</span>
                                            <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div class="hero-custom-dropdown-panel">
                                            <div class="hero-custom-dropdown-option" data-value="">Tüm Markalar</div>
                                            @foreach($brands ?? [] as $brand)
                                                <div class="hero-custom-dropdown-option" data-value="{{ $brand }}">{{ $brand }}</div>
                                            @endforeach
                                        </div>
                                        <select name="brand" class="hero-custom-dropdown-native">
                                            <option value="">Tüm Markalar</option>
                                            @foreach($brands ?? [] as $brand)
                                                <option value="{{ $brand }}">{{ $brand }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Model Yılı -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">MODEL YILI</label>
                                    <div class="hero-custom-dropdown" data-dropdown="year-buy">
                                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300 dark:border-gray-700 dark:bg-[#2a2a2a] dark:text-gray-100" data-value="">
                                            <span class="selected-text placeholder">Model Yılı Seçin</span>
                                            <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div class="hero-custom-dropdown-panel">
                                            <div class="hero-custom-dropdown-option" data-value="">Model Yılı Seçin</div>
                                            @foreach($years ?? [] as $year)
                                                <div class="hero-custom-dropdown-option" data-value="{{ $year }}">{{ $year }}</div>
                                            @endforeach
                                        </div>
                                        <select name="min_year" class="hero-custom-dropdown-native">
                                            <option value="">Model Yılı Seçin</option>
                                            @foreach($years ?? [] as $year)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Fiyat Aralığı -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">BÜTÇE ARALIĞI (₺)</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <input type="number" name="min_price" placeholder="Min" 
                                               class="w-full border-2 border-gray-300 dark:border-gray-700 rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 dark:text-gray-100 font-semibold transition-all duration-200 bg-white dark:bg-[#2a2a2a] hover:border-primary-400 dark:hover:border-primary-500">
                                        <input type="number" name="max_price" placeholder="Max" 
                                               class="w-full border-2 border-gray-300 dark:border-gray-700 rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 dark:text-gray-100 font-semibold transition-all duration-200 bg-white dark:bg-[#2a2a2a] hover:border-primary-400 dark:hover:border-primary-500">
                                    </div>
                                </div>
                                
                                <!-- Yardımcı Metin -->
                                <div class="text-center pt-2 pb-2">
                                    <p class="text-xs text-gray-500 leading-relaxed">
                                        Detaylı seçim için 
                                        <a href="{{ route('vehicles.index') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold underline">
                                            Araçlar sayfasına
                                        </a> 
                                        göz atabilirsiniz.
                                    </p>
                                </div>
                                
                                <!-- Button -->
                                <button type="submit" class="btn btn-primary w-full py-5 px-6 text-lg">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <span>ARAÇLARI ARA</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Dynamic Headline & Image -->
                <div class="order-1 lg:order-2">
                    <h1 id="slogan-title" class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 dark:text-white mb-6 leading-tight slogan-animate">
                        Aracını <span class="text-primary-600 dark:text-primary-500">Güvenle</span> Sat!
                    </h1>
                    <p id="slogan-description" class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 mb-8 max-w-lg leading-relaxed slogan-animate-delay">
                        Hızlı teklif alın, güvenli süreçten geçin. Aracınızın gerçek değerini öğrenin ve en iyi fiyatı garantileyin.
                    </p>
                    
                    <!-- Featured Vehicle Image -->
                    @if($featuredVehicles->count() > 0 && isset($featuredVehicles[0]->images) && is_array($featuredVehicles[0]->images) && count($featuredVehicles[0]->images) > 0)
                        <div class="relative animate-fade-in-up">
                            <img src="{{ asset($featuredVehicles[0]->images[0]) }}" 
                                 alt="{{ $featuredVehicles[0]->title }}"
                                 class="w-full h-auto rounded-2xl shadow-2xl transform hover:scale-105 transition-transform duration-500"
                                 onerror="this.src='/images/vehicles/default.jpg'">
                            <!-- Decorative red shapes behind image -->
                            <div class="absolute -bottom-6 -right-6 w-40 h-40 bg-primary-600 rounded-2xl opacity-20 -z-10 transform rotate-12 blur-xl"></div>
                            <div class="absolute -top-6 -left-6 w-32 h-32 bg-primary-600 rounded-2xl opacity-20 -z-10 transform -rotate-12 blur-xl"></div>
                        </div>
                    @else
                        <div class="w-full h-80 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center shadow-2xl">
                            <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                    @endif
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

    <!-- Öne Çıkan Araçlar -->
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
                        <span class="text-gradient">Öne Çıkan Araçlar</span>
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 text-lg">En popüler ve öne çıkan araçlarımızı keşfedin</p>
                </div>
                <a href="{{ route('vehicles.index') }}" class="hidden md:flex items-center text-primary-600 dark:text-primary-400 font-semibold hover:text-primary-700 dark:hover:text-primary-300 group transition-all duration-300">
                    <span>Tümünü Gör</span>
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
                        Tüm Araçları Görüntüle
                    </a>
                </div>
            @else
                <div class="text-center py-12 reveal">
                    <p class="text-gray-600">Şu an öne çıkan araç bulunmamaktadır.</p>
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
                <p class="text-gray-600 dark:text-gray-300 text-lg max-w-2xl mx-auto">Size sunduğumuz avantajlar ile fark yaratıyoruz</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group reveal hover-lift bg-white dark:bg-[#252525] rounded-2xl p-6 shadow-md dark:shadow-xl dark:border dark:border-gray-800 transition-all duration-200">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Garantili Araçlar</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">Tüm araçlarımız garantili ve bakımlıdır. Güvenle alışveriş yapın.</p>
                </div>
                
                <div class="text-center group reveal hover-lift bg-white dark:bg-[#252525] rounded-2xl p-6 shadow-md dark:shadow-xl dark:border dark:border-gray-800 transition-all duration-200" style="animation-delay: 0.1s">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">En İyi Fiyat</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">Piyasanın en uygun fiyatları ile hizmetinizdeyiz. Fiyat garantisi veriyoruz.</p>
                </div>
                
                <div class="text-center group reveal hover-lift bg-white dark:bg-[#252525] rounded-2xl p-6 shadow-md dark:shadow-xl dark:border dark:border-gray-800 transition-all duration-200" style="animation-delay: 0.2s">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Ekspertiz Hizmeti</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">Tüm araçlarımız ekspertiz raporlu ve detaylı kontrol edilmiştir.</p>
                </div>
                
                <div class="text-center group reveal hover-lift bg-white dark:bg-[#252525] rounded-2xl p-6 shadow-md dark:shadow-xl dark:border dark:border-gray-800 transition-all duration-200" style="animation-delay: 0.3s">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">7/24 Destek</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">Müşteri hizmetlerimiz her zaman yanınızda. Sorularınız için bize ulaşın.</p>
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
                    <span class="bg-gradient-to-r from-white via-white to-white/90 bg-clip-text text-transparent">Hayalinizdeki Aracı</span>
                    <br>
                    <span class="bg-gradient-to-r from-white via-white to-white/90 bg-clip-text text-transparent">Bulun</span>
                </h2>
                <p class="text-xl md:text-2xl text-white/95 mb-10 max-w-3xl mx-auto leading-relaxed font-medium">
                    <span class="font-semibold">AI destekli</span> araç arama ve değerleme teknolojisi ile hayalinizdeki aracı kolayca bulun. 
                    <span class="font-semibold">Güvenli</span> ve <span class="font-semibold">şeffaf</span> alışveriş deneyimi.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center mb-8">
                    <a href="{{ route('vehicles.index') }}" class="btn bg-white text-primary-600 hover:bg-gray-100 text-lg px-10 py-4 shadow-2xl hover:shadow-3xl transform hover:scale-105 transition-all duration-300 font-semibold group">
                        <span>Araçları İncele</span>
                        <svg class="w-5 h-5 ml-2 inline-block group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="btn border-2 border-white text-white hover:bg-white hover:text-primary-600 text-lg px-10 py-4 backdrop-blur-sm bg-white/10 hover:bg-white transition-all duration-300 font-semibold group">
                        <span>İletişime Geç</span>
                        <svg class="w-5 h-5 ml-2 inline-block group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </a>
                </div>
                
                <!-- Güven İkonlu Bilgi Satırı -->
                <div class="flex items-center justify-center gap-3 text-white/80 text-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span>Güvenli ödeme • Garantili araçlar • 7/24 destek</span>
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
    // Tab Switch Function with Dynamic Slogan and Animation
    function switchTab(tab) {
        const sellTab = document.getElementById('tab-sell');
        const buyTab = document.getElementById('tab-buy');
        const sellForm = document.getElementById('form-sell');
        const buyForm = document.getElementById('form-buy');
        const sloganTitle = document.getElementById('slogan-title');
        const sloganDesc = document.getElementById('slogan-description');
        
        // Stop current animation
        sloganTitle.style.animation = 'none';
        sloganDesc.style.animation = 'none';
        sloganTitle.style.opacity = '0';
        sloganDesc.style.opacity = '0';
        
        if (tab === 'sell') {
            // Activate Sell Tab
            sellTab.classList.add('active');
            buyTab.classList.remove('active');
            sellForm.classList.add('active');
            buyForm.classList.remove('active');
            
            // Update Slogan - Keep red color
            sloganTitle.innerHTML = 'Aracını <span class="text-primary-600 dark:text-primary-500">Güvenle</span> Sat!';
            sloganDesc.innerHTML = 'Hızlı teklif alın, güvenli süreçten geçin. Aracınızın gerçek değerini öğrenin ve en iyi fiyatı garantileyin.';
        } else {
            // Activate Buy Tab
            buyTab.classList.add('active');
            sellTab.classList.remove('active');
            buyForm.classList.add('active');
            sellForm.classList.remove('active');
            
            // Update Slogan - Keep red color
            sloganTitle.innerHTML = '<span class="text-primary-600 dark:text-primary-500">Güvenle</span> Araç Al!';
            sloganDesc.innerHTML = 'Binlerce araç arasından size en uygun olanı bulun. Garantili, ekspertizli ve güvenilir araçlar.';
        }
        
        // Restart animation after a small delay
        setTimeout(() => {
            sloganTitle.style.animation = '';
            sloganDesc.style.animation = '';
            sloganTitle.classList.remove('slogan-animate');
            sloganDesc.classList.remove('slogan-animate-delay');
            
            // Force reflow
            void sloganTitle.offsetWidth;
            
            sloganTitle.classList.add('slogan-animate');
            sloganDesc.classList.add('slogan-animate-delay');
        }, 50);
    }

    // Custom Dropdown Implementation for Hero Section
    document.addEventListener('DOMContentLoaded', function() {
        initHeroCustomDropdowns();
    });
    
    function initHeroCustomDropdowns() {
        const dropdowns = document.querySelectorAll('.hero-custom-dropdown');
        const formCard = document.querySelector('.hero-form-card');
        
        dropdowns.forEach(dropdown => {
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
    
    // Form validation for Hero "ARABAMI DEĞERLE" button
    // Native form submit - JS only for validation
    document.addEventListener('DOMContentLoaded', function() {
        const sellForm = document.getElementById('sell-form');
        if (!sellForm) {
            // Form bulunamadı, sessizce devam et
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
