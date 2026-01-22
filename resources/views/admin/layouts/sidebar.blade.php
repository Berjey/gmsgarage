<aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
    <!-- Logo -->
    <div class="p-6 border-b border-gray-200">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/light-mode-logo.png') }}" alt="GMSGARAGE Logo" class="h-10 w-auto">
            <span class="text-xl font-bold text-gray-900">Admin</span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>Dashboard</span>
        </a>

        <div class="pt-2">
            <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">İçerik Yönetimi</p>
        </div>

        <a href="{{ route('admin.vehicles.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.vehicles.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>Araçlar</span>
        </a>

        <a href="{{ route('admin.blog.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.blog.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>Blog</span>
        </a>

        <a href="{{ route('admin.pages.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.pages.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>Sayfalar</span>
        </a>

        <a href="{{ route('admin.media.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.media.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>Medya</span>
        </a>
        
        <div class="pt-4 border-t border-gray-200">
            <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Mesajlar</p>
        </div>

        <a href="{{ route('admin.contact-messages.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.contact-messages.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <span>İletişim</span>
            @php
                $unreadCount = \App\Models\ContactMessage::where('is_read', false)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="ml-auto bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">{{ $unreadCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.vehicle-requests.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.vehicle-requests.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span>Araç İstekleri</span>
            @php
                $unreadCount = \App\Models\VehicleRequest::where('is_read', false)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="ml-auto bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">{{ $unreadCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.evaluation-requests.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.evaluation-requests.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span>Değerleme İstekleri</span>
            @php
                $unreadCount = \App\Models\EvaluationRequest::where('is_read', false)->count();
            @endphp
            @if($unreadCount > 0)
                <span class="ml-auto bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">{{ $unreadCount }}</span>
            @endif
        </a>

        <div class="pt-4 border-t border-gray-200">
            <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sistem</p>
        </div>

        <!-- Ayarlar Ana Menü -->
        <div class="space-y-1">
            <a href="{{ route('admin.settings.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.settings.*') && !request()->routeIs('admin.contact-settings.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Ayarlar</span>
            </a>
            
            <!-- İletişim Ayarları Alt Menü -->
            <a href="{{ route('admin.contact-settings.index') }}" 
               class="flex items-center space-x-3 px-4 py-3 ml-4 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.contact-settings.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span>İletişim Ayarları</span>
            </a>
        </div>

        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-600 font-semibold' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span>Kullanıcılar</span>
        </a>

        <div class="pt-4 border-t border-gray-200">
            <a href="{{ route('home') }}" 
               target="_blank"
               class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                <span>Siteyi Görüntüle</span>
            </a>
        </div>
    </nav>

    <!-- User Info -->
    <div class="p-4 border-t border-gray-200">
        @auth
        <div class="flex items-center space-x-3 mb-3">
            <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email ?? '' }}</p>
            </div>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>Çıkış Yap</span>
            </button>
        </form>
        @endauth
    </div>
</aside>
