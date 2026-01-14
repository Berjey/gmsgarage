@extends('layouts.app')

@section('title', 'Araçlar - GMSGARAGE')
@section('description', 'Premium ikinci el araçlarımızı inceleyin. Geniş araç yelpazesi, garantili ve bakımlı araçlar.')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-br from-primary-800 via-primary-700 to-primary-900 text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="container-custom relative z-10">
            <nav class="flex items-center space-x-2 text-sm mb-4">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Anasayfa</a>
                <span class="text-gray-400">/</span>
                <span class="text-white font-semibold">Araçlar</span>
            </nav>
            <h1 class="text-4xl md:text-5xl font-bold mb-3">Araçlarımız</h1>
            <p class="text-xl text-gray-200">Geniş araç yelpazemizden size uygun olanı seçin</p>
        </div>
    </section>

    <!-- Filters & Vehicles -->
    <section class="section-padding bg-gray-50">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Filters Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-28 border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Filtreler</h2>
                            <button type="button" onclick="resetFilters()" class="text-sm text-primary-600 hover:text-primary-700 font-semibold">
                                Temizle
                            </button>
                        </div>
                        
                        <form method="GET" action="{{ route('vehicles.index') }}" id="filter-form" class="space-y-6">
                            <!-- Marka -->
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Marka</label>
                                <select name="brand" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-medium transition-all">
                                    <option value="">Tüm Markalar</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                            {{ $brand }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Yakıt Tipi -->
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Yakıt Tipi</label>
                                <div class="space-y-2">
                                    <label class="flex items-center space-x-3 cursor-pointer p-2 rounded-lg hover:bg-gray-50">
                                        <input type="radio" name="fuel_type" value="" {{ !request('fuel_type') ? 'checked' : '' }} class="w-4 h-4 text-primary-600 focus:ring-primary-600">
                                        <span class="text-gray-700 font-medium">Tümü</span>
                                    </label>
                                    <label class="flex items-center space-x-3 cursor-pointer p-2 rounded-lg hover:bg-gray-50">
                                        <input type="radio" name="fuel_type" value="Benzin" {{ request('fuel_type') == 'Benzin' ? 'checked' : '' }} class="w-4 h-4 text-primary-600 focus:ring-primary-600">
                                        <span class="text-gray-700 font-medium">Benzin</span>
                                    </label>
                                    <label class="flex items-center space-x-3 cursor-pointer p-2 rounded-lg hover:bg-gray-50">
                                        <input type="radio" name="fuel_type" value="Dizel" {{ request('fuel_type') == 'Dizel' ? 'checked' : '' }} class="w-4 h-4 text-primary-600 focus:ring-primary-600">
                                        <span class="text-gray-700 font-medium">Dizel</span>
                                    </label>
                                    <label class="flex items-center space-x-3 cursor-pointer p-2 rounded-lg hover:bg-gray-50">
                                        <input type="radio" name="fuel_type" value="Hybrid" {{ request('fuel_type') == 'Hybrid' ? 'checked' : '' }} class="w-4 h-4 text-primary-600 focus:ring-primary-600">
                                        <span class="text-gray-700 font-medium">Hybrid</span>
                                    </label>
                                    <label class="flex items-center space-x-3 cursor-pointer p-2 rounded-lg hover:bg-gray-50">
                                        <input type="radio" name="fuel_type" value="Elektrik" {{ request('fuel_type') == 'Elektrik' ? 'checked' : '' }} class="w-4 h-4 text-primary-600 focus:ring-primary-600">
                                        <span class="text-gray-700 font-medium">Elektrik</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Fiyat Aralığı -->
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Fiyat Aralığı</label>
                                <div class="space-y-3">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                           placeholder="Min Fiyat (₺)"
                                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-medium">
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                           placeholder="Max Fiyat (₺)"
                                           class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-medium">
                                </div>
                            </div>
                            
                            <!-- Kasa Tipi -->
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Kasa Tipi</label>
                                <select name="body_type" class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-medium">
                                    <option value="">Tümü</option>
                                    <option value="Sedan" {{ request('body_type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                    <option value="SUV" {{ request('body_type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                                    <option value="Hatchback" {{ request('body_type') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                    <option value="Coupe" {{ request('body_type') == 'Coupe' ? 'selected' : '' }}>Coupe</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="w-full btn btn-primary text-lg">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Filtrele
                            </button>
                        </form>
                    </div>
                </aside>
                
                <!-- Vehicles Grid -->
                <div class="lg:col-span-3">
                    @if($vehicles->count() > 0)
                        <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <p class="text-gray-600 text-lg">
                                    <span class="font-bold text-gray-900 text-2xl">{{ $vehicles->total() }}</span> araç bulundu
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600 font-medium">Sırala:</span>
                                <select class="border-2 border-gray-200 rounded-lg px-3 py-2 text-sm font-medium focus:ring-2 focus:ring-primary-600 focus:border-primary-600">
                                    <option>En Yeni</option>
                                    <option>Fiyat: Düşükten Yükseğe</option>
                                    <option>Fiyat: Yüksekten Düşüğe</option>
                                    <option>Kilometre: Düşükten Yükseğe</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($vehicles as $vehicle)
                                <x-vehicle-card :vehicle="$vehicle" />
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-12">
                            {{ $vehicles->links() }}
                        </div>
                    @else
                        <div class="bg-white rounded-2xl shadow-xl p-16 text-center border border-gray-100">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Araç Bulunamadı</h3>
                            <p class="text-gray-600 mb-8 text-lg">Seçtiğiniz kriterlere uygun araç bulunmamaktadır.</p>
                            <a href="{{ route('vehicles.index') }}" class="btn btn-primary text-lg px-8">
                                Filtreleri Temizle
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
        function resetFilters() {
            window.location.href = '{{ route("vehicles.index") }}';
        }
    </script>
@endsection
