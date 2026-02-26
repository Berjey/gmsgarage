@extends('layouts.app')

@section('title', $sellerData['name'] . ' - Satıcı Profili - ' . ($settings['site_title'] ?? 'GMSGARAGE'))
@section('description', $sellerData['name'] . ' satıcı profil sayfası. Aktif ve kaldırılan ilanlar.')

@section('content')
    <!-- Breadcrumb -->
    <section class="bg-gray-50 dark:bg-[#1e1e1e] py-4 border-b border-gray-200 dark:border-gray-800 transition-colors duration-200">
        <div class="container-custom">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">Anasayfa</a>
                <span class="text-gray-400 dark:text-gray-600">/</span>
                <a href="{{ route('vehicles.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 font-medium transition-colors">Araçlar</a>
                <span class="text-gray-400 dark:text-gray-600">/</span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold">{{ $sellerData['name'] }}</span>
            </nav>
        </div>
    </section>

    <!-- Seller Profile Header -->
    <section class="section-padding bg-white dark:bg-[#1e1e1e] transition-colors duration-200">
        <div class="container-custom">
            <!-- Seller Info Card -->
            <div class="bg-white dark:bg-[#252525] rounded-2xl border border-gray-200 dark:border-gray-800 shadow-lg dark:shadow-xl mb-8 overflow-hidden transition-colors duration-200">
                <div class="bg-gradient-to-r from-primary-600 to-primary-700 p-8">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        <!-- Avatar -->
                        <div class="relative flex-shrink-0">
                            <div class="w-24 h-24 rounded-2xl bg-white flex items-center justify-center shadow-xl ring-4 ring-white/20">
                                <span class="text-primary-600 font-bold text-3xl">
                                    @php
                                        $nameParts = explode(' ', $sellerData['name']);
                                        $initials = strtoupper(substr($sellerData['name'], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
                                    @endphp
                                    {{ $initials }}
                                </span>
                            </div>
                            @if($sellerData['is_verified'])
                                <div class="absolute -bottom-2 -right-2 bg-green-500 rounded-full p-2 shadow-lg ring-4 ring-white">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Info -->
                        <div class="flex-1 text-white">
                            <div class="flex items-center gap-3 mb-2 flex-wrap">
                                <h1 class="text-3xl md:text-4xl font-bold">{{ $sellerData['name'] }}</h1>
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                    GMSGARAGE
                                </span>
                            </div>
                            <p class="text-xl text-white/90 mb-4">{{ $sellerData['position'] }}</p>
                            
                            <!-- Location -->
                            <div class="flex items-center gap-2 text-white/90">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $sellerData['location'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Info -->
                <div class="p-6 bg-gray-50 dark:bg-[#2a2a2a] border-t border-gray-200 dark:border-gray-800 transition-colors duration-200">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $sellerData['total_listings'] }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Toplam İlan</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $activeVehicles->count() }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Aktif İlan</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $sellerData['response_time'] }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Ortalama Yanıt</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ date('Y', strtotime($sellerData['joined_date'])) }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Üyelik Yılı</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="mb-8">
                <div class="border-b border-gray-200 dark:border-gray-800 transition-colors duration-200">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <button onclick="showTab('active')" id="tab-active" class="tab-button border-b-2 border-primary-600 dark:border-primary-500 py-4 px-1 text-sm font-semibold text-primary-600 dark:text-primary-400">
                            Aktif İlanlar ({{ $activeVehicles->count() }})
                        </button>
                        <button onclick="showTab('inactive')" id="tab-inactive" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600">
                            Kaldırılan İlanlar ({{ $inactiveVehicles->count() }})
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Active Vehicles -->
            <div id="tab-content-active" class="tab-content">
                @if($activeVehicles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($activeVehicles as $vehicle)
                            <x-vehicle-card :vehicle="$vehicle" />
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 dark:bg-[#252525] rounded-2xl p-12 text-center border border-gray-200 dark:border-gray-800 transition-colors duration-200">
                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Henüz aktif ilan bulunmuyor</h3>
                        <p class="text-gray-600 dark:text-gray-400">Bu satıcının aktif ilanı bulunmamaktadır.</p>
                    </div>
                @endif
            </div>

            <!-- Inactive Vehicles -->
            <div id="tab-content-inactive" class="tab-content hidden">
                @if($inactiveVehicles->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($inactiveVehicles as $vehicle)
                            <div class="relative opacity-75">
                                <x-vehicle-card :vehicle="$vehicle" />
                                <div class="absolute top-4 right-4 bg-gray-800 dark:bg-gray-700 text-white px-3 py-1 rounded-lg text-xs font-semibold">
                                    Kaldırıldı
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 dark:bg-[#252525] rounded-2xl p-12 text-center border border-gray-200 dark:border-gray-800 transition-colors duration-200">
                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Kaldırılan ilan bulunmuyor</h3>
                        <p class="text-gray-600 dark:text-gray-400">Bu satıcının kaldırılan ilanı bulunmamaktadır.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <style>
        .tab-button.active {
            border-color: rgb(220 38 38);
            color: rgb(220 38 38);
        }
        .dark .tab-button.active {
            border-color: rgb(239 68 68);
            color: rgb(248 113 113);
        }
    </style>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-primary-600', 'dark:border-primary-500', 'text-primary-600', 'dark:text-primary-400');
                button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });
            
            // Show selected tab content
            document.getElementById('tab-content-' + tabName).classList.remove('hidden');
            
            // Add active class to selected button
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.add('active', 'border-primary-600', 'dark:border-primary-500', 'text-primary-600', 'dark:text-primary-400');
            activeButton.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        }
    </script>
@endsection
