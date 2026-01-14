@props(['vehicle'])

<div class="card-vehicle group">
    <a href="{{ route('vehicles.show', $vehicle->slug) }}" class="block">
        <!-- Görsel -->
        <div class="relative h-56 bg-gray-100 overflow-hidden">
            @if(is_array($vehicle->images) && count($vehicle->images) > 0)
                <img src="{{ $vehicle->images[0] }}" 
                     alt="{{ $vehicle->title }}"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                     onerror="this.src='/images/vehicles/default.jpg'">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            @endif
            
            @if($vehicle->is_featured)
                <span class="absolute top-3 left-3 bg-accent-600 text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg">
                    ⭐ Öne Çıkan
                </span>
            @endif
            
            <!-- Hover Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
        </div>
        
        <!-- İçerik -->
        <div class="p-6">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-1 line-clamp-2 group-hover:text-primary-600 transition-colors">
                        {{ $vehicle->title }}
                    </h3>
                    <p class="text-sm text-gray-500">{{ $vehicle->brand }} • {{ $vehicle->model }}</p>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="text-3xl font-bold text-primary-600 mb-1">
                    {{ $vehicle->formatted_price }}
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-3 mb-4 pb-4 border-b border-gray-100">
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="font-medium">{{ $vehicle->year }}</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="font-medium">{{ number_format($vehicle->kilometer ?? 0, 0, ',', '.') }} km</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">{{ $vehicle->fuel_type ?? '-' }}</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="font-medium">{{ $vehicle->transmission ?? '-' }}</span>
                </div>
            </div>
            
            <div class="flex space-x-2">
                <a href="{{ route('vehicles.show', $vehicle->slug) }}" 
                   class="flex-1 btn btn-primary text-sm">
                    Detayları Gör
                </a>
                @if($vehicle->sahibinden_url)
                    <a href="{{ $vehicle->sahibinden_url }}" 
                       target="_blank"
                       class="px-4 py-2 border-2 border-gray-300 text-gray-700 hover:border-primary-600 hover:text-primary-600 rounded-lg font-semibold transition-all duration-200 text-sm">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Sahibinden
                    </a>
                @endif
            </div>
        </div>
    </a>
</div>
