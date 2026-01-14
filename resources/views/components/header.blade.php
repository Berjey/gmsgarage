<header class="bg-white/95 backdrop-blur-modern shadow-lg sticky top-0 z-50 border-b border-gray-100 transition-all duration-300">
    <nav class="container-custom">
        <div class="flex items-center justify-between h-28">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="GMSGARAGE Logo" class="h-20 md:h-28 w-auto transition-transform duration-300 group-hover:scale-105" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <div class="text-4xl md:text-5xl font-bold text-primary-600" style="display:none;">GMSGARAGE</div>
            </a>
            
            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="{{ route('home') }}" 
                   class="px-4 py-2 text-gray-700 hover:text-primary-600 hover:bg-gray-50 font-medium transition-all duration-200 rounded-lg {{ request()->routeIs('home') ? 'text-primary-600 bg-gray-50' : '' }}">
                    Anasayfa
                </a>
                <a href="{{ route('vehicles.index') }}" 
                   class="px-4 py-2 text-gray-700 hover:text-primary-600 hover:bg-gray-50 font-medium transition-all duration-200 rounded-lg {{ request()->routeIs('vehicles.*') ? 'text-primary-600 bg-gray-50' : '' }}">
                    Araçlar
                </a>
                <a href="{{ route('about') }}" 
                   class="px-4 py-2 text-gray-700 hover:text-primary-600 hover:bg-gray-50 font-medium transition-all duration-200 rounded-lg {{ request()->routeIs('about') ? 'text-primary-600 bg-gray-50' : '' }}">
                    Hakkımızda
                </a>
                <a href="{{ route('contact') }}" 
                   class="px-4 py-2 text-gray-700 hover:text-primary-600 hover:bg-gray-50 font-medium transition-all duration-200 rounded-lg {{ request()->routeIs('contact') ? 'text-primary-600 bg-gray-50' : '' }}">
                    İletişim
                </a>
                <a href="tel:+905551234567" class="ml-4 btn btn-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Hemen Ara
                </a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="lg:hidden text-gray-700 hover:text-primary-600 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        
        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden lg:hidden pb-4 border-t border-gray-100 mt-2">
            <div class="flex flex-col space-y-3">
                <a href="{{ route('home') }}" 
                   class="text-gray-700 hover:text-primary-600 font-medium transition-colors {{ request()->routeIs('home') ? 'text-primary-600' : '' }}">
                    Anasayfa
                </a>
                <a href="{{ route('vehicles.index') }}" 
                   class="text-gray-700 hover:text-primary-600 font-medium transition-colors {{ request()->routeIs('vehicles.*') ? 'text-primary-600' : '' }}">
                    Araçlar
                </a>
                <a href="{{ route('about') }}" 
                   class="text-gray-700 hover:text-primary-600 font-medium transition-colors {{ request()->routeIs('about') ? 'text-primary-600' : '' }}">
                    Hakkımızda
                </a>
                <a href="{{ route('contact') }}" 
                   class="text-gray-700 hover:text-primary-600 font-medium transition-colors {{ request()->routeIs('contact') ? 'text-primary-600' : '' }}">
                    İletişim
                </a>
                <a href="{{ route('contact') }}" class="btn btn-primary w-full text-center">
                    Hemen Ara
                </a>
            </div>
        </div>
    </nav>
</header>

<script>
    document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
