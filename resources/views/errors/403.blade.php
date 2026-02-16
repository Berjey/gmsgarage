<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Yetkisiz Erişim</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 text-center">
            <!-- Icon -->
            <div class="mb-8">
                <div class="w-32 h-32 mx-auto bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>

            <!-- Error Code -->
            <h1 class="text-8xl font-black text-gray-200 mb-4">403</h1>

            <!-- Title -->
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Yetkisiz Erişim</h2>

            <!-- Message -->
            <p class="text-lg text-gray-600 mb-2">
                {{ $exception->getMessage() ?: 'Bu sayfaya erişim yetkiniz bulunmamaktadır.' }}
            </p>
            <p class="text-sm text-gray-500 mb-8">
                Lütfen yöneticinizle iletişime geçin veya ana sayfaya dönün.
            </p>

            <!-- User Role Info -->
            @auth
            <div class="bg-gray-50 rounded-xl p-4 mb-8 inline-block">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">Mevcut Rolünüz:</span>
                    <span class="ml-2 px-3 py-1 rounded-full text-xs font-bold
                        {{ auth()->user()->role === 'admin' ? 'bg-red-100 text-red-800' : '' }}
                        {{ auth()->user()->role === 'manager' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ auth()->user()->role === 'editor' ? 'bg-green-100 text-green-800' : '' }}">
                        {{ auth()->user()->role_name }}
                    </span>
                </p>
            </div>
            @endauth

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Ana Sayfaya Dön
                </a>
                <button onclick="window.history.back()" 
                        class="inline-flex items-center justify-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-bold transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Geri Dön
                </button>
            </div>

            <!-- Help Text -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Yardıma mı ihtiyacınız var? 
                    <a href="mailto:info@gmsgarage.com" class="text-primary-600 hover:text-primary-700 font-semibold">
                        Bize ulaşın
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500">
                © {{ date('Y') }} GMSGARAGE. Tüm hakları saklıdır.
            </p>
        </div>
    </div>
</body>
</html>
