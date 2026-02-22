@extends('admin.layouts.app')

@section('title', 'Araç Yönetimi - Admin Panel')
@section('page-title', 'Araç Yönetimi')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Araçlar</span>
@endsection

@section('content')
<!-- İstatistik Kartları -->
@php
    $activeCount = \App\Models\Vehicle::where('is_active', true)->count();
    $passiveCount = \App\Models\Vehicle::where('is_active', false)->count();
    $featuredCount = \App\Models\Vehicle::where('is_featured', true)->count();
@endphp

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <a href="{{ route('admin.vehicles.index') }}" class="bg-white rounded-xl p-6 border-2 border-primary-100 shadow-sm hover:shadow-lg hover:border-primary-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Toplam Araç</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">{{ \App\Models\Vehicle::count() }}</p>
            </div>
            <div class="w-14 h-14 bg-primary-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.vehicles.index', ['status' => 'active']) }}" class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm hover:shadow-lg hover:border-green-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Aktif İlanlar</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">{{ $activeCount }}</p>
            </div>
            <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.vehicles.index', ['status' => 'featured']) }}" class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm hover:shadow-lg hover:border-yellow-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Öne Çıkan</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">{{ $featuredCount }}</p>
            </div>
            <div class="w-14 h-14 bg-yellow-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.vehicles.index', ['status' => 'passive']) }}" class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm hover:shadow-lg hover:border-gray-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Pasif İlanlar</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-gray-600 transition-colors">{{ $passiveCount }}</p>
            </div>
            <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
        </div>
    </a>
</div>

<!-- Ana İçerik -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    Araç Listesi
                </h2>
                <p class="text-sm text-gray-600 mt-2">Toplam <span class="font-bold text-primary-600">{{ $vehicles->total() }}</span> araç kayıtlı</p>
            </div>
            <a href="{{ route('admin.vehicles.create') }}" 
               class="px-6 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Araç Ekle
            </a>
        </div>
    </div>

    <!-- Gelişmiş Filtreleme -->
    <div class="p-6 bg-gray-50 border-b border-gray-200">
        <form id="vehicles-filter-form" action="{{ route('admin.vehicles.index') }}" method="GET">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Arama -->
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Marka, model veya başlık ara..." 
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                </div>

                <!-- Durum Filtresi -->
                <div class="w-full md:w-48">
                    <div class="adm-dd" data-adm-dd data-submit="vehicles-filter-form">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <button type="button" class="adm-dd-btn" data-adm-trigger>
                            <span data-adm-label>
                                @if(request('status') == 'active') Aktif
                                @elseif(request('status') == 'passive') Pasif
                                @else Tüm Durumlar
                                @endif
                            </span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <ul class="adm-dd-list" data-adm-list>
                            <li data-value="" class="{{ !request('status') ? 'selected' : '' }}">Tüm Durumlar</li>
                            <li data-value="active" class="{{ request('status') == 'active' ? 'selected' : '' }}">Aktif</li>
                            <li data-value="passive" class="{{ request('status') == 'passive' ? 'selected' : '' }}">Pasif</li>
                        </ul>
                    </div>
                </div>

                <!-- Butonlar -->
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-3 bg-gray-800 text-white font-bold rounded-xl hover:bg-gray-900 transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Ara
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.vehicles.index') }}" class="px-6 py-3 bg-white text-gray-700 font-bold rounded-xl border border-gray-300 hover:bg-gray-50 transition-all shadow-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Araç Listesi (Table) -->
    <div class="overflow-x-auto">
        @if($vehicles->count() > 0)
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Araç Bilgisi
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Özellikler
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Fiyat
                            </div>
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Ayarlar
                            </div>
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                            <div class="flex items-center justify-end gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                </svg>
                                İşlemler
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($vehicles as $vehicle)
                    <tr class="hover:bg-blue-50/30 transition-all duration-200 border-l-4 border-transparent hover:border-primary-500 hover:shadow-sm">
                        <!-- Araç Bilgisi -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ $vehicle->created_at->format('d.m.Y') }} tarihinde eklendi</div>
                        </td>

                        <!-- Özellikler -->
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 text-sm text-gray-700">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $vehicle->year }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-700">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    <span>{{ number_format($vehicle->km, 0, ',', '.') }} km</span>
                                </div>
                            </div>
                        </td>

                        <!-- Fiyat -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-lg font-bold text-primary-600">
                                {{ number_format($vehicle->price, 0, ',', '.') }} ₺
                            </div>
                        </td>

                        <!-- Durum & Ayarlar -->
                        <td class="px-6 py-4">
                            <div class="flex flex-col items-start gap-3 min-w-[180px]">
                                <!-- Yayın Durumu -->
                                <div class="flex items-center gap-3 w-full">
                                    <span class="text-xs font-semibold text-gray-700 w-20">Yayın:</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               class="sr-only peer"
                                               {{ $vehicle->is_active ? 'checked' : '' }}
                                               onchange="toggleVehicleStatus({{ $vehicle->id }}, 'active', this.checked, event)">
                                        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                                    </label>
                                    <span class="text-xs font-bold px-2 py-1 rounded {{ $vehicle->is_active ? 'text-green-700 bg-green-50' : 'text-gray-600 bg-gray-100' }}">
                                        {{ $vehicle->is_active ? 'Yayında' : 'Yayında Değil' }}
                                    </span>
                                </div>

                                <!-- Öne Çıkan -->
                                <div class="flex items-center gap-3 w-full">
                                    <span class="text-xs font-semibold text-gray-700 w-20">Öne Çıkan:</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               class="sr-only peer"
                                               {{ $vehicle->is_featured ? 'checked' : '' }}
                                               onchange="toggleVehicleStatus({{ $vehicle->id }}, 'featured', this.checked, event)">
                                        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
                                    </label>
                                    <span class="text-xs font-bold px-2 py-1 rounded {{ $vehicle->is_featured ? 'text-yellow-700 bg-yellow-50' : 'text-gray-600 bg-gray-100' }}">
                                        @if($vehicle->is_featured)
                                            <svg class="w-3.5 h-3.5 inline-block mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                            </svg>
                                            Evet
                                        @else
                                            Hayır
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </td>

                        <!-- İşlemler -->
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('vehicles.show', $vehicle->slug) }}" 
                                   target="_blank"
                                   class="p-2.5 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-600 hover:text-white transition-all border border-blue-200 shadow-sm hover:shadow-md" 
                                   title="Ön İzleme">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" 
                                   class="p-2.5 text-amber-600 bg-amber-50 rounded-lg hover:bg-amber-600 hover:text-white transition-all border border-amber-200 shadow-sm hover:shadow-md" 
                                   title="Düzenle">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" 
                                      method="POST" 
                                      class="inline-block delete-form" 
                                      data-vehicle-name="{{ $vehicle->brand }} {{ $vehicle->model }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete(this)"
                                            class="p-2.5 text-red-600 bg-red-50 rounded-lg hover:bg-red-600 hover:text-white transition-all border border-red-200 shadow-sm hover:shadow-md" 
                                            title="Sil">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <!-- Boş Durum -->
            <div class="text-center py-16 px-6">
                <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Henüz araç eklenmemiş</h3>
                <p class="text-gray-600 mb-6">İlk aracınızı ekleyerek başlayın</p>
                <a href="{{ route('admin.vehicles.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Yeni Araç Ekle
                </a>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($vehicles->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-600">
                <span class="font-semibold text-gray-900">{{ $vehicles->firstItem() }}-{{ $vehicles->lastItem() }}</span> 
                / 
                <span class="font-semibold text-gray-900">{{ $vehicles->total() }}</span> araç
            </div>
            <div>
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function toggleVehicleStatus(vehicleId, type, value, event) {
    const checkbox = event.target;
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PATCH');
    
    let url = '';
    let statusText = '';
    
    if (type === 'active') {
        url = `/admin/vehicles/${vehicleId}/toggle-active`;
        statusText = value ? 'Araç yayına alındı' : 'Araç yayından kaldırıldı';
    } else if (type === 'featured') {
        url = `/admin/vehicles/${vehicleId}/toggle-featured`;
        statusText = value ? 'Araç öne çıkarıldı' : 'Araç öne çıkandan kaldırıldı';
    }
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Success notification
            showNotification(statusText, 'success');
            // Sayfa yenilenmeden etiketleri güncelle
            updateLabels(checkbox, type, value);
        } else {
            // Error - revert checkbox
            checkbox.checked = !value;
            showNotification('Bir hata oluştu', 'error');
        }
    })
    .catch(error => {
        // Error - revert checkbox
        checkbox.checked = !value;
        showNotification('Bir hata oluştu', 'error');
    });
}

function updateLabels(checkbox, type, value) {
    const label = checkbox.closest('.flex').querySelector('span:last-child');
    if (type === 'active') {
        if (value) {
            label.className = 'text-xs font-bold px-2 py-1 rounded text-green-700 bg-green-50';
            label.textContent = 'Yayında';
        } else {
            label.className = 'text-xs font-bold px-2 py-1 rounded text-gray-600 bg-gray-100';
            label.textContent = 'Yayında Değil';
        }
    } else if (type === 'featured') {
        if (value) {
            label.className = 'text-xs font-bold px-2 py-1 rounded text-yellow-700 bg-yellow-50';
            label.innerHTML = '<svg class="w-3.5 h-3.5 inline-block mr-0.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg> Evet';
        } else {
            label.className = 'text-xs font-bold px-2 py-1 rounded text-gray-600 bg-gray-100';
            label.textContent = 'Hayır';
        }
    }
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-6 py-4 rounded-xl shadow-2xl text-white font-semibold z-50 transition-all transform flex items-center gap-3 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    
    const icon = type === 'success' 
        ? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>'
        : '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
    
    notification.innerHTML = icon + '<span>' + message + '</span>';
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

function confirmDelete(button) {
    const form = button.closest('form');
    const vehicleName = form.dataset.vehicleName;
    
    Swal.fire({
        title: 'Emin misiniz?',
        html: `<strong>${vehicleName}</strong> aracını silmek istediğinize emin misiniz?<br><small class="text-gray-500">Bu işlem geri alınamaz.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Evet, Sil',
        cancelButtonText: 'İptal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-xl',
            title: 'text-xl font-bold',
            confirmButton: 'rounded-lg px-6 py-2.5 font-semibold shadow-lg',
            cancelButton: 'rounded-lg px-6 py-2.5 font-semibold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>
@endsection
