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
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
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
    }
    
    .tab-content.active {
        display: block;
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
    <!-- Hero Section - Modern OTOCARS Style -->
    <section class="relative bg-white min-h-[650px] lg:min-h-[750px] overflow-hidden">
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
        
        <div class="container-custom relative z-10 pt-16 pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Left Side - Modern Search Form -->
                <div class="order-2 lg:order-1 animate-slide-in-left">
                    <div class="bg-white rounded-2xl shadow-2xl border-b-4 border-primary-600 overflow-hidden transform hover:shadow-3xl transition-shadow duration-300">
                        <!-- Tabs -->
                        <div class="flex border-b-2 border-gray-100">
                            <button id="tab-sell" 
                                    onclick="switchTab('sell')"
                                    class="flex-1 px-6 py-5 bg-gray-900 text-white font-bold text-sm uppercase tracking-wider transition-all duration-300 hover:bg-gray-800 active-tab">
                                <span class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>ARAÇ SAT</span>
                                </span>
                            </button>
                            <button id="tab-buy" 
                                    onclick="switchTab('buy')"
                                    class="flex-1 px-6 py-5 bg-white text-gray-600 font-bold text-sm uppercase tracking-wider transition-all duration-300 hover:bg-gray-50">
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
                            <form method="GET" action="{{ route('evaluation.index') }}" class="p-8 space-y-6">
                                <!-- Araç Tipi -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wider">ARAÇ TİPİ</label>
                                    <div class="relative">
                                        <select name="tip" class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 pr-12 appearance-none focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold transition-all duration-200 bg-white hover:border-primary-400">
                                            <option value="AUTO">OTOMOBİL</option>
                                            <option value="SUV">SUV</option>
                                            <option value="TICARI">TİCARİ</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Model Yılı -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wider">MODEL YILI</label>
                                    <div class="relative">
                                        <input type="number" 
                                               name="yil" 
                                               placeholder="Örn: 2024" 
                                               min="1990" 
                                               max="{{ date('Y') + 1 }}" 
                                               value="{{ date('Y') }}"
                                               class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 pr-12 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold transition-all duration-200 bg-white hover:border-primary-400">
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Marka -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wider">MARKA</label>
                                    <div class="relative">
                                        <select name="marka" class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 pr-12 appearance-none focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold transition-all duration-200 bg-white hover:border-primary-400">
                                            <option value="">Marka Seçin</option>
                                            @foreach($brands ?? [] as $brand)
                                                <option value="{{ $brand }}">{{ $brand }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Button -->
                                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-5 px-6 rounded-xl transition-all duration-300 flex items-center justify-center space-x-3 shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <span class="text-lg">ARABAMI DEĞERLE</span>
                                </button>
                                
                                <!-- Link -->
                                <div class="text-center pt-2">
                                    <a href="{{ route('vehicles.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-semibold transition-colors duration-200 inline-flex items-center space-x-1">
                                        <span>Aracınızı listede bulamıyorsanız buraya tıklayın</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Araç Al Form -->
                        <div id="form-buy" class="tab-content">
                            <form method="GET" action="{{ route('vehicles.index') }}" class="p-8 space-y-6">
                                <!-- Araç Tipi -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wider">KASA TİPİ</label>
                                    <div class="relative">
                                        <select name="body_type" class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 pr-12 appearance-none focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold transition-all duration-200 bg-white hover:border-primary-400">
                                            <option value="">Tümü</option>
                                            @foreach($bodyTypes ?? [] as $bodyType)
                                                <option value="{{ $bodyType }}">{{ $bodyType }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Marka -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wider">MARKA</label>
                                    <div class="relative">
                                        <select name="brand" class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 pr-12 appearance-none focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold transition-all duration-200 bg-white hover:border-primary-400">
                                            <option value="">Tüm Markalar</option>
                                            @foreach($brands ?? [] as $brand)
                                                <option value="{{ $brand }}">{{ $brand }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Fiyat Aralığı -->
                                <div class="form-field">
                                    <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wider">FİYAT ARALIĞI</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <input type="number" name="min_price" placeholder="Min" 
                                               class="w-full border-2 border-gray-300 rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold transition-all duration-200 bg-white hover:border-primary-400">
                                        <input type="number" name="max_price" placeholder="Max" 
                                               class="w-full border-2 border-gray-300 rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold transition-all duration-200 bg-white hover:border-primary-400">
                                    </div>
                                </div>
                                
                                <!-- Button -->
                                <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-5 px-6 rounded-xl transition-all duration-300 flex items-center justify-center space-x-3 shadow-lg hover:shadow-xl transform hover:scale-[1.02] active:scale-[0.98]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <span class="text-lg">ARAÇLARI ARA</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Headline & Image -->
                <div class="order-1 lg:order-2 animate-slide-in-right">
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                        Aracını<br>
                        <span class="text-primary-600 relative inline-block">
                            değerinde sat
                            <span class="absolute -bottom-2 left-0 w-full h-3 bg-primary-100 opacity-50 -z-10 transform -skew-x-12"></span>
                        </span>
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-lg leading-relaxed">
                        Premium ikinci el araçlar için güvenilir adresiniz. Garantili, bakımlı ve en iyi fiyat garantisi.
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
    <section class="section-padding bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
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
                    <p class="text-gray-600 text-lg">En popüler ve öne çıkan araçlarımızı keşfedin</p>
                </div>
                <a href="{{ route('vehicles.index') }}" class="hidden md:flex items-center text-primary-600 font-semibold hover:text-primary-700 group transition-all duration-300">
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
    <section class="section-padding bg-white relative overflow-hidden">
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
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Size sunduğumuz avantajlar ile fark yaratıyoruz</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group reveal hover-lift">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors duration-300">Garantili Araçlar</h3>
                    <p class="text-gray-600 leading-relaxed">Tüm araçlarımız garantili ve bakımlıdır. Güvenle alışveriş yapın.</p>
                </div>
                
                <div class="text-center group reveal hover-lift" style="animation-delay: 0.1s">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors duration-300">En İyi Fiyat</h3>
                    <p class="text-gray-600 leading-relaxed">Piyasanın en uygun fiyatları ile hizmetinizdeyiz. Fiyat garantisi veriyoruz.</p>
                </div>
                
                <div class="text-center group reveal hover-lift" style="animation-delay: 0.2s">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors duration-300">Ekspertiz Hizmeti</h3>
                    <p class="text-gray-600 leading-relaxed">Tüm araçlarımız ekspertiz raporlu ve detaylı kontrol edilmiştir.</p>
                </div>
                
                <div class="text-center group reveal hover-lift" style="animation-delay: 0.3s">
                    <div class="bg-gradient-to-br from-primary-500 to-primary-600 w-24 h-24 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors duration-300">7/24 Destek</h3>
                    <p class="text-gray-600 leading-relaxed">Müşteri hizmetlerimiz her zaman yanınızda. Sorularınız için bize ulaşın.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 text-white relative overflow-hidden">
        <!-- Animated Background -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0 animated-bg"></div>
        </div>
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        
        <!-- Decorative Shapes -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="container-custom text-center relative z-10">
            <div class="reveal">
                <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    Hayalinizdeki Aracı Bulun
                </h2>
                <p class="text-xl md:text-2xl text-white/90 mb-10 max-w-3xl mx-auto leading-relaxed">
                    Geniş araç yelpazemizden size uygun olanı seçin veya bizimle iletişime geçin.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ route('vehicles.index') }}" class="btn bg-white text-primary-600 hover:bg-gray-100 text-lg px-10 py-4 shadow-2xl hover:shadow-3xl transform hover:scale-105">
                        <span>Araçları İncele</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    <a href="{{ route('contact') }}" class="btn border-2 border-white text-white hover:bg-white hover:text-primary-600 text-lg px-10 py-4 backdrop-blur-sm bg-white/10">
                        <span>İletişime Geç</span>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function switchTab(tab) {
        // Tab buttons
        const sellTab = document.getElementById('tab-sell');
        const buyTab = document.getElementById('tab-buy');
        
        // Tab contents
        const sellForm = document.getElementById('form-sell');
        const buyForm = document.getElementById('form-buy');
        
        if (tab === 'sell') {
            // Activate sell tab
            sellTab.classList.add('bg-gray-900', 'text-white', 'active-tab');
            sellTab.classList.remove('bg-white', 'text-gray-600');
            buyTab.classList.add('bg-white', 'text-gray-600');
            buyTab.classList.remove('bg-gray-900', 'text-white', 'active-tab');
            
            // Show sell form
            sellForm.classList.add('active');
            buyForm.classList.remove('active');
        } else {
            // Activate buy tab
            buyTab.classList.add('bg-gray-900', 'text-white', 'active-tab');
            buyTab.classList.remove('bg-white', 'text-gray-600');
            sellTab.classList.add('bg-white', 'text-gray-600');
            sellTab.classList.remove('bg-gray-900', 'text-white', 'active-tab');
            
            // Show buy form
            buyForm.classList.add('active');
            sellForm.classList.remove('active');
        }
    }
</script>
@endpush
