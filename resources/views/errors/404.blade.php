@extends('layouts.app')

@section('title', '404 - Sayfa Bulunamadı')
@section('description', 'Aradığınız sayfa bulunamadı.')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-[#1a1a1a] dark:to-[#222] flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white dark:bg-[#1e1e1e] rounded-2xl shadow-2xl p-8 md:p-12 text-center">
            <!-- Icon -->
            <div class="mb-8">
                <div class="w-32 h-32 mx-auto bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Error Code -->
            <h1 class="text-8xl font-black text-gray-200 dark:text-gray-700 mb-4">404</h1>

            <!-- Title -->
            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Sayfa Bulunamadı</h2>

            <!-- Message -->
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-2">
                Aradığınız sayfa mevcut değil veya taşınmış olabilir.
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-500 mb-8">
                URL'yi kontrol edin veya aşağıdaki bağlantıları kullanın.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Ana Sayfaya Dön
                </a>
                <a href="{{ url('/araclar') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl font-bold transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Araçları İncele
                </a>
                <button onclick="window.history.back()"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 rounded-xl font-bold transition-all duration-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Geri Dön
                </button>
            </div>

            <!-- Help Text -->
            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Yardıma mı ihtiyacınız var?
                    <a href="{{ url('/iletisim') }}" class="text-red-600 hover:text-red-700 dark:text-red-400 font-semibold">
                        Bize ulaşın
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
