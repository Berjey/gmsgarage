@extends('admin.layouts.app')

@section('title', 'Araç Yönetimi - Admin Panel')
@section('page-title', 'Araç Yönetimi')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Araçlar</span>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Araç Listesi</h2>
            <p class="text-sm text-gray-600 mt-1">Toplam {{ $vehicles->total() }} araç kayıtlı</p>
        </div>
        <a href="{{ route('admin.vehicles.create') }}" 
           class="px-6 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Yeni Araç Ekle
        </a>
    </div>

    <!-- Filters -->
    <div class="p-6 border-b border-gray-200 bg-gray-50/30">
        <form id="vehicles-filter-form" action="{{ route('admin.vehicles.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Marka, model veya başlık ara..." 
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all shadow-sm">
            </div>
            <div class="adm-dd" data-adm-dd data-submit="vehicles-filter-form" style="width:200px;flex-shrink:0;">
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
                    <li data-value=""        class="{{ !request('status') ? 'selected' : '' }}">Tüm Durumlar</li>
                    <li data-value="active"  class="{{ request('status') == 'active'  ? 'selected' : '' }}">Aktif</li>
                    <li data-value="passive" class="{{ request('status') == 'passive' ? 'selected' : '' }}">Pasif</li>
                </ul>
            </div>
            <button type="submit" class="px-8 py-3 bg-gray-800 text-white font-bold rounded-xl hover:bg-gray-900 transition-all shadow-lg shadow-gray-500/25">
                Filtrele
            </button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.vehicles.index') }}" class="px-6 py-3 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all shadow-sm text-center">
                    Temizle
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Görsel</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Araç Bilgisi</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fiyat</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Durum</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($vehicles as $vehicle)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->title }}" class="w-20 h-14 object-cover rounded-lg border border-gray-200">
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-900">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                        <div class="text-xs text-gray-500">{{ $vehicle->year }} - {{ number_format($vehicle->km, 0, ',', '.') }} KM</div>
                        <div class="mt-1">
                            @if($vehicle->is_featured)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Öne Çıkan</span>
                            @endif
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $vehicle->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $vehicle->is_active ? 'Aktif' : 'Pasif' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-primary-600">{{ number_format($vehicle->price, 0, ',', '.') }} ₺</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $vehicle->created_at->format('d.m.Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('vehicles.show', $vehicle->slug) }}" target="_blank" class="p-2.5 text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm" title="Görüntüle">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="p-2.5 text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm" title="Düzenle">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 text-red-600 bg-red-50 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Sil">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                        Henüz araç eklenmemiş.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($vehicles->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50 flex items-center justify-between">
        <div class="text-sm font-medium text-gray-500">
            {{ $vehicles->firstItem() }}-{{ $vehicles->lastItem() }} / {{ $vehicles->total() }} araç
        </div>
        {{ $vehicles->links() }}
    </div>
    @endif
</div>
@endsection
