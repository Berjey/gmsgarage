@extends('admin.layouts.app')

@section('title', 'Araç İsteği Detayı - Admin Panel')
@section('page-title', 'Araç İsteği Detayı')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.vehicle-requests.index') }}" class="hover:text-primary-600">Araç İstekleri</a>
    <span>/</span>
    <span>Detay</span>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.vehicle-requests.index') }}" 
           class="inline-flex items-center px-3 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg font-medium transition-colors border border-gray-300">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Geri Dön
        </a>
        <div class="flex items-center gap-2">
            @if(!$request->is_read)
            <form action="{{ route('admin.vehicle-requests.read', $request->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors">Okundu Olarak İşaretle</button>
            </form>
            @endif
            <form action="{{ route('admin.vehicle-requests.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 border border-red-300 text-red-600 hover:bg-red-50 rounded-lg font-medium transition-colors">İsteği Sil</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- İstek Bilgileri -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <h2 class="text-xl font-bold text-gray-900 border-b pb-2">İstenen Araç Bilgileri</h2>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Marka / Model</label>
                    <p class="text-sm font-bold text-gray-900">{{ $request->brand }} {{ $request->model }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Yıl</label>
                    <p class="text-sm text-gray-900">{{ $request->year }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Kilometre</label>
                    <p class="text-sm text-gray-900">{{ number_format($request->kilometre, 0, ',', '.') }} KM</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Yakıt / Vites</label>
                    <p class="text-sm text-gray-900">{{ $request->fuel_type }} / {{ $request->transmission }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Şehir</label>
                    <p class="text-sm text-gray-900">{{ $request->city }}</p>
                </div>
            </div>

            @if($request->note)
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kullanıcı Notu</label>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-sm text-gray-700 leading-relaxed italic">
                    "{{ $request->note }}"
                </div>
            </div>
            @endif
        </div>

        <!-- İletişim Bilgileri -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <h2 class="text-xl font-bold text-gray-900 border-b pb-2">Kullanıcı İletişim Bilgileri</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">İletişim Bilgisi</label>
                    <p class="text-lg font-bold text-gray-900">{{ $request->contact }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Tercih Edilen Yöntem</label>
                    <p class="text-sm text-gray-900">{{ $request->contact_method }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Talep Tarihi</label>
                    <p class="text-sm text-gray-900">{{ $request->created_at->format('d.m.Y H:i') }}</p>
                </div>
            </div>

            <div class="pt-6 border-t">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $request->contact) }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-green-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Hemen Ara
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
