@extends('admin.layouts.app')

@section('title', 'Değerleme İsteği Detayı - Admin Panel')
@section('page-title', 'Değerleme İsteği Detayı')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.evaluation-requests.index') }}" class="hover:text-primary-600">Değerleme İstekleri</a>
    <span>/</span>
    <span>Detay</span>
@endsection

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.evaluation-requests.index') }}" 
           class="inline-flex items-center px-3 py-2 bg-white hover:bg-gray-50 text-gray-700 rounded-lg font-medium transition-colors border border-gray-300">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Geri Dön
        </a>
        <div class="flex items-center gap-2">
            @if(!$request->is_read)
            <form action="{{ route('admin.evaluation-requests.read', $request->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium transition-colors">Okundu Olarak İşaretle</button>
            </form>
            @endif
            <form action="{{ route('admin.evaluation-requests.destroy', $request->id) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 border border-red-300 text-red-600 hover:bg-red-50 rounded-lg font-medium transition-colors">İsteği Sil</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Araç Bilgileri -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <h2 class="text-xl font-bold text-gray-900 border-b pb-2">Değerlendirilecek Araç Bilgileri</h2>
            
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
                    <p class="text-sm text-gray-900 font-bold text-primary-600">{{ number_format($request->km, 0, ',', '.') }} KM</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Yakıt / Vites</label>
                    <p class="text-sm text-gray-900">{{ $request->fuel_type }} / {{ $request->transmission }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Boya / Hasar</label>
                    <p class="text-sm text-gray-900">{{ $request->has_damage }}</p>
                </div>
            </div>
        </div>

        <!-- İletişim Bilgileri -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 space-y-6">
            <h2 class="text-xl font-bold text-gray-900 border-b pb-2">Kullanıcı İletişim Bilgileri</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Ad Soyad</label>
                    <p class="text-lg font-bold text-gray-900">{{ $request->name }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">Telefon</label>
                    <p class="text-sm text-gray-900 font-bold">{{ $request->phone }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase">E-posta</label>
                    <p class="text-sm text-gray-900">{{ $request->email ?? 'Belirtilmemiş' }}</p>
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

            <div class="pt-6 border-t flex gap-2">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $request->phone) }}" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-green-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Ara
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $request->phone) }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-bold transition-all shadow-lg shadow-green-400/20">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
