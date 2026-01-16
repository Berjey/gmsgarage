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
            <!-- Üst: Fotoğraflar ve Sağda Bilgiler -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mb-12">
                <!-- Sol: Images Gallery -->
                <div>
                    @php
                        // Test için göstermelik fotoğraflar
                        $demoImages = [
                            'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=800&h=600&fit=crop',
                            'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=800&h=600&fit=crop',
                            'https://images.unsplash.com/photo-1552519507-88aa2dfa9fdb?w=800&h=600&fit=crop',
                            'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=800&h=600&fit=crop',
                        ];
                        $vehicleImages = is_array($vehicle->images) && count($vehicle->images) > 0 
                            ? $vehicle->images 
                            : $demoImages;
                    @endphp
                    
                    @if(count($vehicleImages) > 0)
                        <!-- Büyük Ana Fotoğraf -->
                        <div class="mb-4 rounded-2xl overflow-hidden shadow-2xl relative">
                            <img src="{{ $vehicleImages[0] }}" 
                                 alt="{{ $vehicle->title }}"
                                 id="main-image"
                                 class="w-full h-[500px] object-cover transition-all duration-300"
                                 loading="eager"
                                 onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=800&h=600&fit=crop'">
                            
                            <!-- Foto Sayacı -->
                            @if(count($vehicleImages) > 1)
                                <div class="absolute top-4 right-4 bg-black bg-opacity-70 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                    <span id="current-image-index">1</span> / <span id="total-images">{{ count($vehicleImages) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Thumbnail Galeri -->
                        @if(count($vehicleImages) > 1)
                            <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                                @foreach($vehicleImages as $index => $image)
                                    <img src="{{ $image }}" 
                                         alt="{{ $vehicle->title }} - Görsel {{ $index + 1 }}"
                                         onclick="changeMainImage('{{ $image }}', {{ $index }})"
                                         class="w-24 h-24 object-cover rounded-xl cursor-pointer hover:opacity-75 transition-all duration-300 border-2 {{ $index === 0 ? 'border-primary-600' : 'border-transparent' }} flex-shrink-0 hover:border-primary-600"
                                         loading="lazy"
                                         onerror="this.src='https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=800&h=600&fit=crop'"
                                         id="thumb-{{ $index }}">
                                @endforeach
                            </div>
                        @endif
                    @else
                        <!-- Placeholder -->
                        <div class="w-full h-[500px] bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl flex items-center justify-center shadow-2xl">
                            <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Sağ: Başlık, Fiyat, Bilgi Kartları, Butonlar (İlk Ekran Görüntüsü) -->
                <div>
                    <!-- Başlık ve Fiyat -->
                    <div class="mb-6">
                        @if($vehicle->is_featured)
                            <span class="inline-block bg-accent-600 text-white px-4 py-1.5 rounded-full text-sm font-bold mb-4">
                                ⭐ Öne Çıkan Araç
                            </span>
                        @endif
                        
                        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                            {{ $vehicle->title }}
                        </h1>
                        
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="text-4xl md:text-5xl font-bold text-primary-600">
                                {{ $vehicle->formatted_price }}
                            </div>
                        </div>
                        
                        <!-- İlan Tarihi -->
                        @if($vehicle->created_at)
                            <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>İlan Tarihi: {{ $vehicle->created_at->format('d.m.Y') }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Quick Info Cards (Orijinal Gradient Tasarım) -->
                    <div class="grid grid-cols-2 gap-4 mb-8">
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
                    <div class="flex flex-col sm:flex-row gap-4">
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
                </div>
            </div>
            
            <!-- Alt: Teknik Özellikler Kartı (İkinci Ekran Görüntüsü) -->
            <div class="mb-12">
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Teknik Özellikler</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Temel Bilgiler -->
                        <div>
                            <h3 class="text-lg font-bold text-primary-600 mb-4">Temel Bilgiler</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-gray-600 font-medium">Marka</span>
                                    <span class="font-bold text-gray-900">{{ $vehicle->brand }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-gray-600 font-medium">Model</span>
                                    <span class="font-bold text-gray-900">{{ $vehicle->model }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-gray-600 font-medium">Yıl</span>
                                    <span class="font-bold text-gray-900">{{ $vehicle->year }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-gray-600 font-medium">Kilometre</span>
                                    <span class="font-bold text-gray-900">{{ number_format($vehicle->kilometer ?? 0, 0, ',', '.') }} km</span>
                                </div>
                                @if($vehicle->fuel_type)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <span class="text-gray-600 font-medium">Yakıt Tipi</span>
                                        <span class="font-bold text-gray-900">{{ $vehicle->fuel_type }}</span>
                                    </div>
                                @endif
                                @if($vehicle->transmission)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <span class="text-gray-600 font-medium">Vites</span>
                                        <span class="font-bold text-gray-900">{{ $vehicle->transmission }}</span>
                                    </div>
                                @endif
                                @if($vehicle->body_type)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <span class="text-gray-600 font-medium">Kasa Tipi</span>
                                        <span class="font-bold text-gray-900">{{ $vehicle->body_type }}</span>
                                    </div>
                                @endif
                                @if($vehicle->color)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200 last:border-0">
                                        <span class="text-gray-600 font-medium">Renk</span>
                                        <span class="font-bold text-gray-900">{{ $vehicle->color }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Motor & Performans -->
                        <div>
                            <h3 class="text-lg font-bold text-primary-600 mb-4">Motor & Performans</h3>
                            <div class="space-y-3">
                                @if($vehicle->engine_size)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <span class="text-gray-600 font-medium">Motor Hacmi</span>
                                        <span class="font-bold text-gray-900">{{ number_format($vehicle->engine_size, 0, ',', '.') }} cc</span>
                                    </div>
                                @endif
                                @if($vehicle->horse_power)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                        <span class="text-gray-600 font-medium">Motor Gücü</span>
                                        <span class="font-bold text-gray-900">{{ number_format($vehicle->horse_power, 0, ',', '.') }} HP</span>
                                    </div>
                                @endif
                                @if($vehicle->traction)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-200 last:border-0">
                                        <span class="text-gray-600 font-medium">Çekiş</span>
                                        <span class="font-bold text-gray-900">{{ $vehicle->traction }}</span>
                                    </div>
                                @endif
                                
                                <!-- Hasar & Ekspertiz (Eğer varsa) -->
                                @if($vehicle->heavy_damage !== null || $vehicle->tramer_amount || $vehicle->paint_parts)
                                    <div class="mt-6 pt-6 border-t border-gray-200">
                                        <h3 class="text-lg font-bold text-primary-600 mb-4">Hasar & Ekspertiz</h3>
                                        <div class="space-y-3">
                                            @if($vehicle->heavy_damage !== null)
                                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                                    <span class="text-gray-600 font-medium">Ağır Hasar Kayıtlı</span>
                                                    <span class="font-bold text-gray-900">{{ $vehicle->heavy_damage ? 'Evet' : 'Hayır' }}</span>
                                                </div>
                                            @endif
                                            @if($vehicle->tramer_amount)
                                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                                    <span class="text-gray-600 font-medium">Tramer Tutarı</span>
                                                    <span class="font-bold text-gray-900">{{ number_format($vehicle->tramer_amount, 0, ',', '.') }} ₺</span>
                                                </div>
                                            @endif
                                            @if($vehicle->paint_parts)
                                                <div class="py-2 border-b border-gray-200 last:border-0">
                                                    <div class="text-gray-600 font-medium mb-1">Boya / Değişen Parça</div>
                                                    <div class="text-gray-900 text-sm">{{ $vehicle->paint_parts }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Açıklama -->
            @if($vehicle->description)
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Açıklama</h2>
                    <div class="text-gray-700 leading-relaxed text-lg whitespace-pre-line">
                        {{ $vehicle->description }}
                    </div>
                </div>
            @endif
            
            <!-- Özellikler -->
            @if(is_array($vehicle->features) && count($vehicle->features) > 0)
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 mb-8">
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
        function changeMainImage(src, index) {
            const mainImage = document.getElementById('main-image');
            if (mainImage) {
                mainImage.src = src;
            }
            
            // Update active thumbnail
            document.querySelectorAll('[id^="thumb-"]').forEach(thumb => {
                thumb.classList.remove('border-primary-600');
                thumb.classList.add('border-transparent');
            });
            
            const clickedThumb = document.getElementById('thumb-' + index);
            if (clickedThumb) {
                clickedThumb.classList.add('border-primary-600');
                clickedThumb.classList.remove('border-transparent');
            }
            
            // Update photo counter
            const currentIndex = document.getElementById('current-image-index');
            if (currentIndex) {
                currentIndex.textContent = index + 1;
            }
        }
        
        // İlk thumbnail'ı aktif yap
        document.addEventListener('DOMContentLoaded', function() {
            const firstThumb = document.getElementById('thumb-0');
            if (firstThumb) {
                firstThumb.classList.add('border-primary-600');
                firstThumb.classList.remove('border-transparent');
            }
        });
    </script>
@endsection
