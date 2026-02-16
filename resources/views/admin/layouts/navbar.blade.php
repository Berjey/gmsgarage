<!-- Top Navbar -->
<nav class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-40 shadow-sm">
    <!-- Sol Taraf - Breadcrumb -->
    <div class="flex items-center space-x-4">
        @if(View::hasSection('breadcrumb'))
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                @yield('breadcrumb')
            </nav>
        @else
            <div class="text-lg font-bold text-gray-900">
                @yield('page-title', 'Admin Panel')
            </div>
        @endif
    </div>

    <!-- Sağ Taraf - Bildirimler, Profil, Çıkış -->
    <div class="flex items-center space-x-3">
        
        <!-- Bildirim İkonu -->
        @php
            $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();
            $unreadVehicleRequests = \App\Models\VehicleRequest::where('is_read', false)->count();
            $unreadEvaluations = \App\Models\EvaluationRequest::where('is_read', false)->count();
            $totalUnread = $unreadMessages + $unreadVehicleRequests + $unreadEvaluations;
        @endphp
        
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="relative p-2.5 rounded-xl hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                @if($totalUnread > 0)
                <span class="absolute top-1 right-1 flex h-5 w-5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-5 w-5 bg-red-600 text-white text-xs font-bold items-center justify-center">{{ $totalUnread > 9 ? '9+' : $totalUnread }}</span>
                </span>
                @endif
            </button>

            <!-- Bildirim Dropdown -->
            <div x-show="open" @click.away="open = false" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden"
                 style="display: none;">
                
                <div class="p-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white">
                    <h3 class="text-lg font-bold">Bildirimler</h3>
                    <p class="text-xs text-primary-100">{{ $totalUnread }} okunmamış bildirim</p>
                </div>

                <div class="max-h-96 overflow-y-auto">
                    @if($totalUnread > 0)
                        <!-- İletişim Mesajları -->
                        @if($unreadMessages > 0)
                        <a href="{{ route('admin.contact-messages.index') }}" class="flex items-start gap-3 p-4 hover:bg-gray-50 border-b border-gray-100 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900">Yeni İletişim Mesajı</p>
                                <p class="text-xs text-gray-500">{{ $unreadMessages }} okunmamış mesaj</p>
                            </div>
                            <span class="px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded-full">{{ $unreadMessages }}</span>
                        </a>
                        @endif

                        <!-- Araç İstekleri -->
                        @if($unreadVehicleRequests > 0)
                        <a href="{{ route('admin.vehicle-requests.index') }}" class="flex items-start gap-3 p-4 hover:bg-gray-50 border-b border-gray-100 transition-colors">
                            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900">Araç İsteği</p>
                                <p class="text-xs text-gray-500">{{ $unreadVehicleRequests }} yeni istek</p>
                            </div>
                            <span class="px-2 py-1 bg-amber-600 text-white text-xs font-bold rounded-full">{{ $unreadVehicleRequests }}</span>
                        </a>
                        @endif

                        <!-- Değerleme İstekleri -->
                        @if($unreadEvaluations > 0)
                        <a href="{{ route('admin.evaluation-requests.index') }}" class="flex items-start gap-3 p-4 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900">Değerleme Talebi</p>
                                <p class="text-xs text-gray-500">{{ $unreadEvaluations }} yeni talep</p>
                            </div>
                            <span class="px-2 py-1 bg-green-600 text-white text-xs font-bold rounded-full">{{ $unreadEvaluations }}</span>
                        </a>
                        @endif
                    @else
                        <div class="p-8 text-center">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-sm text-gray-500">Yeni bildirim yok</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Profil Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center space-x-3 p-2 pr-3 rounded-xl hover:bg-gray-100 transition-colors">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-600 to-primary-700 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="text-left hidden lg:block">
                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                    @php
                        $roleColors = [
                            'admin' => 'bg-red-100 text-red-700',
                            'manager' => 'bg-blue-100 text-blue-700',
                            'editor' => 'bg-green-100 text-green-700',
                        ];
                        $roleColor = $roleColors[Auth::user()->role] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded {{ $roleColor }}">
                        {{ Auth::user()->role_name }}
                    </span>
                </div>
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Profil Dropdown Menu -->
            <div x-show="open" @click.away="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden"
                 style="display: none;">
                
                <div class="p-3 bg-gray-50 border-b border-gray-200">
                    <p class="text-xs text-gray-500">Oturum açan</p>
                    <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                </div>

                <div class="py-2">
                    <a href="{{ route('admin.profile.index') }}" class="flex items-center gap-3 px-4 py-2.5 hover:bg-primary-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Profilim</span>
                    </a>
                    
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700">Siteyi Görüntüle</span>
                    </a>
                </div>

                <div class="p-2 border-t border-gray-200">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 transition-colors rounded-lg">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="text-sm font-bold text-red-600">Çıkış Yap</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Alpine.js için script (eğer yoksa) -->
@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
