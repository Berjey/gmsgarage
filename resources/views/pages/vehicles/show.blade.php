@extends('layouts.app')

@section('title', $vehicle->title . ' - GMSGARAGE')
@section('description', $vehicle->description ?? $vehicle->title)

@section('content')
    <!-- Breadcrumb -->
    <section class="bg-gray-50 py-4 border-b border-gray-200">
        <div class="container-custom">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-primary-600 font-medium transition-colors">Anasayfa</a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('vehicles.index') }}" class="text-gray-600 hover:text-primary-600 font-medium transition-colors">Araçlar</a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-semibold">{{ $vehicle->title }}</span>
            </nav>
        </div>
    </section>

    <!-- Vehicle Details -->
    <section class="section-padding bg-white">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mb-12">
                <!-- Images Gallery -->
                <div>
                    @if(is_array($vehicle->images) && count($vehicle->images) > 0)
                        <div class="mb-4 rounded-2xl overflow-hidden shadow-2xl">
                            <img src="{{ $vehicle->images[0] }}" 
                                 alt="{{ $vehicle->title }}"
                                 id="main-image"
                                 class="w-full h-[500px] object-cover transition-all duration-300"
                                 onerror="this.src='/images/vehicles/default.jpg'">
                        </div>
                        
                        @if(count($vehicle->images) > 1)
                            <div class="grid grid-cols-5 gap-3">
                                @foreach($vehicle->images as $index => $image)
                                    <img src="{{ $image }}" 
                                         alt="{{ $vehicle->title }} - Görsel {{ $index + 1 }}"
                                         onclick="changeMainImage('{{ $image }}')"
                                         class="w-full h-24 object-cover rounded-xl cursor-pointer hover:opacity-75 transition-all duration-300 border-2 border-transparent hover:border-primary-600"
                                         onerror="this.src='/images/vehicles/default.jpg'"
                                         id="thumb-{{ $index }}">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="w-full h-[500px] bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl flex items-center justify-center shadow-2xl">
                            <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Details -->
                <div>
                    <div class="mb-4">
                        @if($vehicle->is_featured)
                            <span class="inline-block bg-accent-600 text-white px-4 py-1.5 rounded-full text-sm font-bold mb-3">
                                ⭐ Öne Çıkan Araç
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                        {{ $vehicle->title }}
                    </h1>
                    
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="text-4xl md:text-5xl font-bold text-primary-600">
                            {{ $vehicle->formatted_price }}
                        </div>
                    </div>
                    
                    <!-- Quick Info Cards -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-4 border border-primary-200">
                            <div class="text-sm text-gray-600 mb-1 font-medium">Marka</div>
                            <div class="text-lg font-bold text-gray-900">{{ $vehicle->brand }}</div>
                        </div>
                        <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-4 border border-primary-200">
                            <div class="text-sm text-gray-600 mb-1 font-medium">Model</div>
                            <div class="text-lg font-bold text-gray-900">{{ $vehicle->model }}</div>
                        </div>
                        <div class="bg-gradient-to-br from-accent-50 to-accent-100 rounded-xl p-4 border border-accent-200">
                            <div class="text-sm text-gray-600 mb-1 font-medium">Yıl</div>
                            <div class="text-lg font-bold text-gray-900">{{ $vehicle->year }}</div>
                        </div>
                        <div class="bg-gradient-to-br from-accent-50 to-accent-100 rounded-xl p-4 border border-accent-200">
                            <div class="text-sm text-gray-600 mb-1 font-medium">Kilometre</div>
                            <div class="text-lg font-bold text-gray-900">{{ number_format($vehicle->kilometer ?? 0, 0, ',', '.') }} km</div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-8">
                        <a href="https://wa.me/905551234567?text=Merhaba, {{ urlencode($vehicle->title) }} hakkında bilgi almak istiyorum." 
                           target="_blank"
                           class="flex-1 btn bg-green-500 hover:bg-green-600 text-white text-lg shadow-lg">
                            <svg class="w-6 h-6 inline-block mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                            WhatsApp ile İletişim
                        </a>
                        @if($vehicle->sahibinden_url)
                            <a href="{{ $vehicle->sahibinden_url }}" 
                               target="_blank"
                               class="flex-1 btn border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white text-lg">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Sahibinden'de Gör
                            </a>
                        @endif
                    </div>
                    
                    <!-- Key Features -->
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Temel Bilgiler</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <div class="text-xs text-gray-600">Yakıt</div>
                                    <div class="font-bold text-gray-900">{{ $vehicle->fuel_type ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <div class="text-xs text-gray-600">Vites</div>
                                    <div class="font-bold text-gray-900">{{ $vehicle->transmission ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <div class="text-xs text-gray-600">Kasa</div>
                                    <div class="font-bold text-gray-900">{{ $vehicle->body_type ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                                <div>
                                    <div class="text-xs text-gray-600">Renk</div>
                                    <div class="font-bold text-gray-900">{{ $vehicle->color ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Description & Features -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border border-gray-100">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Açıklama</h2>
                        <div class="text-gray-700 leading-relaxed text-lg">
                            {{ $vehicle->description ?? 'Açıklama bulunmamaktadır.' }}
                        </div>
                    </div>
                    
                    @if(is_array($vehicle->features) && count($vehicle->features) > 0)
                        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Özellikler</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($vehicle->features as $feature)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                        <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-gray-900 font-medium">{{ $feature }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Technical Details Sidebar -->
                <div>
                    <div class="bg-white rounded-2xl shadow-xl p-8 sticky top-28 border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Teknik Özellikler</h2>
                        <div class="space-y-4">
                            @if($vehicle->engine_size)
                                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                    <span class="text-gray-600 font-medium">Motor Hacmi</span>
                                    <span class="font-bold text-gray-900">{{ $vehicle->engine_size }} L</span>
                                </div>
                            @endif
                            @if($vehicle->horse_power)
                                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                    <span class="text-gray-600 font-medium">Beygir Gücü</span>
                                    <span class="font-bold text-gray-900">{{ $vehicle->horse_power }} HP</span>
                                </div>
                            @endif
                            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Yakıt Tipi</span>
                                <span class="font-bold text-gray-900">{{ $vehicle->fuel_type ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Vites Tipi</span>
                                <span class="font-bold text-gray-900">{{ $vehicle->transmission ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Kasa Tipi</span>
                                <span class="font-bold text-gray-900">{{ $vehicle->body_type ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Renk</span>
                                <span class="font-bold text-gray-900">{{ $vehicle->color ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Yıl</span>
                                <span class="font-bold text-gray-900">{{ $vehicle->year }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3">
                                <span class="text-gray-600 font-medium">Kilometre</span>
                                <span class="font-bold text-gray-900">{{ number_format($vehicle->kilometer ?? 0, 0, ',', '.') }} km</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Vehicles -->
            @if($relatedVehicles->count() > 0)
                <div class="mt-16">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">Benzer Araçlar</h2>
                        <a href="{{ route('vehicles.index', ['brand' => $vehicle->brand]) }}" class="text-primary-600 font-semibold hover:text-primary-700 flex items-center">
                            Tümünü Gör
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedVehicles as $relatedVehicle)
                            <x-vehicle-card :vehicle="$relatedVehicle" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <script>
        function changeMainImage(src) {
            document.getElementById('main-image').src = src;
            // Update active thumbnail
            document.querySelectorAll('[id^="thumb-"]').forEach(thumb => {
                thumb.classList.remove('border-primary-600');
                thumb.classList.add('border-transparent');
            });
            event.target.classList.add('border-primary-600');
            event.target.classList.remove('border-transparent');
        }
    </script>
@endsection
