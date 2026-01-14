@extends('layouts.app')

@section('title', 'Değerleme Sonucu - GMSGARAGE')

@push('styles')
<style>
    .result-card {
        @apply bg-gradient-to-br from-primary-50 to-white rounded-2xl shadow-2xl p-8 border-2 border-primary-200;
    }
    .price-display {
        @apply text-6xl font-bold text-primary-600 mb-4;
    }
</style>
@endpush

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-12">
        <div class="container-custom">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Değerleme Sonucu</h1>
            <p class="text-primary-100">Aracınızın tahmini değeri</p>
        </div>
    </section>

    <!-- Result Section -->
    <section class="py-12 bg-gray-50">
        <div class="container-custom max-w-4xl">
            <div class="result-card text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Aracınızı satın alabileceğimiz tahmini fiyat</h2>
                <div class="price-display">
                    {{ number_format($estimatedPrice, 0, ',', '.') }} ₺
                </div>
                <p class="text-gray-600 text-sm mb-6">
                    * Fiyatlar öngörü niteliğindedir ve referans değerlerdir.<br>
                    * Bu fiyat aracınızı satın almaya yönelik bir taahhüt, teklif veya kabul anlamına gelmemektedir.
                </p>
            </div>
            
            <!-- Vehicle Info Summary -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Araç Bilgileri</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Araç Tipi</div>
                        <div class="font-semibold text-gray-900">{{ $data['tip'] ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Model Yılı</div>
                        <div class="font-semibold text-gray-900">{{ $data['yil'] ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Marka</div>
                        <div class="font-semibold text-gray-900">{{ $data['marka'] ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Model</div>
                        <div class="font-semibold text-gray-900">{{ $data['model'] ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Kilometre</div>
                        <div class="font-semibold text-gray-900">{{ number_format($data['kilometre'] ?? 0, 0, ',', '.') }} km</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Renk</div>
                        <div class="font-semibold text-gray-900">{{ $data['renk'] ?? '-' }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="tel:+905551234567" class="flex items-center justify-center space-x-3 bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <span>GMSGARAGE'ı Ara</span>
                </a>
                <a href="{{ route('contact') }}" class="flex items-center justify-center space-x-3 border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white font-bold py-4 px-6 rounded-xl transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Randevu Al</span>
                </a>
            </div>
            
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
                <p class="text-blue-800 text-sm">
                    <strong>Müşteri temsilcilerimiz</strong> sizinle en kısa zamanda irtibata geçip, exper ve randevu detayları sizinle paylaşılacaktır.
                </p>
                <p class="text-blue-800 text-sm mt-2">
                    <strong>GMSGARAGE'ı</strong> tercih ettiğiniz için teşekkür ederiz.
                </p>
            </div>
            
            <div class="text-center mt-8">
                <a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-700 font-semibold inline-flex items-center space-x-2">
                    <span>Ana Sayfaya Dön</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endsection
