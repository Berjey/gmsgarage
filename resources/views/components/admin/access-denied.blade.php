@props([
    'message' => 'Bu sayfaya erişim yetkiniz yok.',
    'backUrl' => null,
])

<div class="flex flex-col items-center justify-center min-h-[60vh] px-4">
    <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-10 max-w-lg w-full text-center">

        <!-- İkon -->
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
        </div>

        <!-- Hata Kodu -->
        <p class="text-6xl font-black text-red-200 mb-2 leading-none">403</p>

        <!-- Başlık -->
        <h2 class="text-xl font-bold text-gray-900 mb-3">Erişim Reddedildi</h2>

        <!-- Mesaj -->
        <p class="text-sm text-gray-500 mb-8 leading-relaxed">{{ $message }}</p>

        <!-- Aksiyon Butonları -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            @if($backUrl)
                <a href="{{ $backUrl }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-semibold rounded-xl hover:bg-primary-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Geri Dön
                </a>
            @else
                <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('admin.dashboard') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-semibold rounded-xl hover:bg-primary-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Geri Dön
                </a>
            @endif

            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard'a Git
            </a>
        </div>

        <!-- Bilgi Notu -->
        <p class="mt-8 text-xs text-gray-400">
            Yetki gerektiriyorsa
            <span class="font-semibold text-gray-500">Süper Yönetici</span>
            ile iletişime geçin.
        </p>
    </div>
</div>
