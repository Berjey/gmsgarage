<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bakım Çalışması - {{ $settings['site_title'] ?? 'GMSGARAGE' }}</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes pulse-ring {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 50px rgba(239, 68, 68, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }
        
        .pulse-ring {
            animation: pulse-ring 2s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-red-900 min-h-screen flex items-center justify-center p-4">
    
    <div class="max-w-2xl w-full">
        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <!-- Header with animated icon -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 p-8 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                
                <div class="relative z-10">
                    <!-- Animated Maintenance Icon -->
                    <div class="inline-block mb-4 pulse-ring">
                        <div class="bg-white rounded-full p-6 float-animation">
                            <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <h1 class="text-4xl font-bold text-white mb-2">Bakım Çalışması</h1>
                    <p class="text-red-100 text-lg">Şu anda sistemimizi geliştiriyoruz</p>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-8">
                <!-- Message -->
                <div class="bg-gray-50 border-l-4 border-red-600 p-6 mb-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Bilgilendirme</h3>
                            <p class="text-gray-700 leading-relaxed">
                                {{ $message }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <svg class="w-8 h-8 text-blue-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-700">Kısa Sürecek</p>
                        <p class="text-xs text-gray-500 mt-1">En kısa sürede döneceğiz</p>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-700">Güvenli</p>
                        <p class="text-xs text-gray-500 mt-1">Verileriniz güvende</p>
                    </div>
                    
                    <div class="bg-purple-50 rounded-lg p-4 text-center">
                        <svg class="w-8 h-8 text-purple-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-700">Geliştirme</p>
                        <p class="text-xs text-gray-500 mt-1">Daha iyi hizmet için</p>
                    </div>
                </div>
                
                <!-- Contact Info -->
                @if(!empty($settings['contact_email']) || !empty($settings['contact_phone']))
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-6">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Acil Durumlarda İletişim
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if(!empty($settings['contact_phone']))
                        <div class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:{{ preg_replace('/[^0-9]/', '', $settings['contact_phone']) }}" class="hover:text-red-600 transition-colors">
                                {{ $settings['contact_phone'] }}
                            </a>
                        </div>
                        @endif
                        
                        @if(!empty($settings['contact_email']))
                        <div class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:{{ $settings['contact_email'] }}" class="hover:text-red-600 transition-colors">
                                {{ $settings['contact_email'] }}
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                <p class="text-center text-sm text-gray-600">
                    © {{ date('Y') }} {{ $settings['site_title'] ?? 'GMSGARAGE' }}. Tüm hakları saklıdır.
                </p>
            </div>
        </div>
        
        <!-- Back to Admin Link (if authenticated) -->
        @auth
            @if(Auth::user()->isAdmin())
            <div class="text-center mt-6">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-6 py-3 bg-white text-gray-700 rounded-lg hover:bg-gray-100 transition-colors shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Admin Paneline Dön
                </a>
            </div>
            @endif
        @endauth
    </div>
    
</body>
</html>
