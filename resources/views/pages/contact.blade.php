@extends('layouts.app')

@section('title', 'İletişim - GMSGARAGE')
@section('description', 'GMSGARAGE ile iletişime geçin. Sorularınız ve önerileriniz için bize ulaşın.')

@section('content')
    <!-- Page Header (Hakkımızda sayfasındaki gibi) -->
    <section class="bg-gradient-to-br from-primary-800 via-primary-700 to-primary-900 dark:from-primary-900 dark:via-primary-800 dark:to-primary-900 text-white py-16 relative overflow-hidden">
        <!-- Animated Pattern Background -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px; animation: patternMove 20s linear infinite;"></div>
        </div>
        <!-- Floating Gradient Orbs -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-96 h-96 bg-white/5 rounded-full mix-blend-overlay filter blur-3xl animate-float"></div>
            <div class="absolute top-40 right-10 w-96 h-96 bg-white/5 rounded-full mix-blend-overlay filter blur-3xl animate-float delay-300"></div>
            <div class="absolute -bottom-8 left-1/2 w-96 h-96 bg-white/5 rounded-full mix-blend-overlay filter blur-3xl animate-float delay-500"></div>
        </div>
        
        <div class="container-custom relative z-10">
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center space-x-2 text-sm mb-4">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors">Anasayfa</a>
                <span class="text-gray-400">/</span>
                <span class="text-white font-semibold">İletişim</span>
            </nav>
            <!-- Main Title -->
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-3">İletişim</h1>
            <p class="text-xl md:text-2xl text-gray-200">Bizimle iletişime geçin</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="section-padding bg-white dark:bg-[#1e1e1e] transition-colors duration-200">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-white dark:bg-[#252525] rounded-xl shadow-lg dark:shadow-xl dark:border dark:border-gray-800 p-8 transition-colors duration-200">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Bize Ulaşın</h2>
                    
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Ad Soyad</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">E-posta</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Telefon</label>
                            <input type="tel" id="phone" name="phone"
                                   class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Mesaj</label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full border border-gray-300 dark:border-gray-700 rounded-lg px-4 py-2 bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-full">
                            Gönder
                        </button>
                    </form>
                </div>
                
                <!-- Contact Info -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-[#252525] rounded-xl shadow-lg dark:shadow-xl dark:border dark:border-gray-800 p-8 transition-colors duration-200">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">İletişim Bilgileri</h2>
                        <div class="space-y-4">
                            <!-- Telefon -->
                            <a href="tel:+905551234567" class="flex items-center space-x-4 p-4 bg-white dark:bg-[#2a2a2a] border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-primary-600 dark:hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-300 group cursor-pointer">
                                <div class="bg-primary-100 dark:bg-primary-900/30 p-3 rounded-lg group-hover:bg-primary-200 dark:group-hover:bg-primary-900/50 transition-colors">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-1 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">Telefon</h3>
                                    <p class="text-primary-600 dark:text-white font-medium group-hover:text-primary-700 dark:group-hover:text-gray-200 transition-colors">0555 123 45 67</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            
                            <!-- E-posta -->
                            <a href="mailto:info@gmsgarage.com" class="flex items-center space-x-4 p-4 bg-white dark:bg-[#2a2a2a] border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-primary-600 dark:hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all duration-300 group cursor-pointer">
                                <div class="bg-primary-100 dark:bg-primary-900/30 p-3 rounded-lg group-hover:bg-primary-200 dark:group-hover:bg-primary-900/50 transition-colors">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-1 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">E-posta</h3>
                                    <p class="text-primary-600 dark:text-white font-medium group-hover:text-primary-700 dark:group-hover:text-gray-200 transition-colors">info@gmsgarage.com</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            
                            <!-- WhatsApp -->
                            <a href="https://wa.me/905551234567" target="_blank" class="flex items-center space-x-4 p-4 bg-white dark:bg-[#2a2a2a] border-2 border-gray-200 dark:border-gray-700 rounded-xl hover:border-green-500 dark:hover:border-green-500 hover:bg-green-50 dark:hover:bg-green-900/20 transition-all duration-300 group cursor-pointer">
                                <div class="bg-green-100 dark:bg-green-900/30 p-3 rounded-lg group-hover:bg-green-200 dark:group-hover:bg-green-900/50 transition-colors">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-1 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">WhatsApp</h3>
                                    <p class="text-green-600 dark:text-green-400 font-medium group-hover:text-green-700 dark:group-hover:text-green-300 transition-colors">0555 123 45 67</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            
                            <!-- Adres -->
                            <div class="flex items-center space-x-4 p-4 bg-white dark:bg-[#2a2a2a] border-2 border-gray-200 dark:border-gray-700 rounded-xl">
                                <div class="bg-primary-100 dark:bg-primary-900/30 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Adres</h3>
                                    <p class="text-gray-700 dark:text-gray-300">Görsel Mah. Kağıthane Cad. No: 26 /1A KAĞITHANE/İSTANBUL</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Google Maps -->
                    <div class="bg-white dark:bg-[#252525] rounded-xl shadow-lg dark:shadow-xl dark:border dark:border-gray-800 overflow-hidden transition-colors duration-200">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3009.1454!2d28.9784!3d41.0082!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDAwJzI5LjUiTiAyOMKwNTgnNDIuMiJF!5e0!3m2!1str!2str!4v1234567890&q=Görsel+Mahallesi+Kağıthane+Caddesi+No+26+1A+Kağıthane+İstanbul"
                            width="100%" 
                            height="300" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
