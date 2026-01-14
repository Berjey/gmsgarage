@extends('layouts.app')

@section('title', 'İletişim - GMSGARAGE')
@section('description', 'GMSGARAGE ile iletişime geçin. Sorularınız ve önerileriniz için bize ulaşın.')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
        <div class="container-custom">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">İletişim</h1>
            <p class="text-primary-200">Bizimle iletişime geçin</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-16">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Bize Ulaşın</h2>
                    <form method="POST" action="#" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Ad Soyad</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">E-posta</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Telefon</label>
                            <input type="tel" id="phone" name="phone"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Mesaj</label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-full">
                            Gönder
                        </button>
                    </form>
                </div>
                
                <!-- Contact Info -->
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">İletişim Bilgileri</h2>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-4">
                                <div class="bg-primary-100 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Telefon</h3>
                                    <a href="tel:+905551234567" class="text-primary-600 hover:text-primary-700">0555 123 45 67</a>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="bg-primary-100 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">E-posta</h3>
                                    <a href="mailto:info@gmsgarage.com" class="text-primary-600 hover:text-primary-700">info@gmsgarage.com</a>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="bg-primary-100 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">Adres</h3>
                                    <p class="text-gray-700">İstanbul, Türkiye</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="bg-primary-100 p-3 rounded-lg">
                                    <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">WhatsApp</h3>
                                    <a href="https://wa.me/905551234567" target="_blank" class="text-primary-600 hover:text-primary-700">0555 123 45 67</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Google Maps -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3009.1454!2d28.9784!3d41.0082!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDAwJzI5LjUiTiAyOMKwNTgnNDIuMiJF!5e0!3m2!1str!2str!4v1234567890"
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
