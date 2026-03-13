@extends('admin.layouts.app')

@section('title', 'Araç Düzenle - Admin Panel')
@section('page-title', 'Araç Düzenle')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Anasayfa</a>
    <span>/</span>
    <a href="{{ route('admin.vehicles.index') }}" class="hover:text-primary-600">Araçlar</a>
    <span>/</span>
    <span>Düzenle</span>
@endsection

@push('styles')
<style>
    .vehicle-tab-btn.active { background-color:#dc2626!important; color:#fff!important; border-bottom: 2px solid #dc2626; }
    .vehicle-tab-btn:not(.active) { background:#fff; color:#374151; }
    .vehicle-tab-btn:not(.active):hover { background:#f9fafb; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                Araç Düzenle
            </h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('vehicles.show', $vehicle->slug ?: $vehicle->id) }}" target="_blank"
                   class="flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-all text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Sitede Görüntüle
                </a>
                <a href="{{ route('admin.vehicles.index') }}"
                   class="flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-all text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Geri
                </a>
            </div>
        </div>
        <p class="text-sm text-gray-500 mt-1 ml-[52px]">{{ $vehicle->title }}</p>
    </div>
</div>

{{-- Error Messages --}}
@if($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <h3 class="text-red-800 font-bold text-sm mb-1">Lütfen hataları düzeltin:</h3>
        <ul class="list-disc list-inside text-red-700 text-sm space-y-0.5">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data" id="vehicleForm">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

    {{-- ═══════════════ MAIN TABS ═══════════════ --}}
    <div class="lg:col-span-3">
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">

        {{-- Tab Navigation --}}
        <div class="flex border-b border-gray-200 overflow-x-auto">
            @php
                $tabs = [
                    ['id'=>'kimlik',   'icon'=>'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'label'=>'Araç Kimliği'],
                    ['id'=>'ilan',     'icon'=>'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label'=>'İlan Bilgileri'],
                    ['id'=>'teknik',   'icon'=>'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4', 'label'=>'Teknik Detaylar'],
                    ['id'=>'gorseller','icon'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'label'=>'Görseller'],
                    ['id'=>'donanim',  'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'label'=>'Donanımlar'],
                    ['id'=>'hasar',    'icon'=>'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'label'=>'Hasar & Geçmiş'],
                    ['id'=>'diger',    'icon'=>'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14', 'label'=>'Entegrasyon'],
                ];
            @endphp
            @foreach($tabs as $i => $tab)
            <button type="button"
                    data-tab="{{ $tab['id'] }}"
                    onclick="switchVehicleTab('{{ $tab['id'] }}')"
                    class="vehicle-tab-btn {{ $i===0?'active':'' }} flex-1 min-w-[120px] px-4 py-4 text-sm font-semibold transition-colors {{ $i>0?'border-l border-gray-200':'' }}">
                <svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"/>
                </svg>
                {{ $tab['label'] }}
            </button>
            @endforeach
        </div>

        {{-- ─── Tab 1: ARAÇ KİMLİĞİ ──────────────────────────────────────── --}}
        <div id="vtab-kimlik" class="vehicle-tab-content p-6 space-y-6">

            <div>
                <h3 class="text-lg font-bold text-gray-900">Araç Kimliği</h3>
                <p class="text-xs text-gray-500 mt-1">Araç tanımlama bilgileri. Kasa / Yakıt / Vites için katalogda olmayan değerler için Manuel Gir'i kullanın.</p>
            </div>

            {{-- Yıl + Marka + Model --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Model Yılı <span class="text-red-500">*</span></label>
                    <input type="number" name="year" value="{{ old('year', $vehicle->year) }}" required
                           min="1900" max="{{ date('Y')+1 }}" placeholder="{{ date('Y') }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Marka <span class="text-red-500">*</span></label>
                    <input type="text" name="brand" value="{{ old('brand', $vehicle->brand) }}" required placeholder="Volkswagen"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Model / Seri <span class="text-red-500">*</span></label>
                    <input type="text" name="model" value="{{ old('model', $vehicle->model) }}" required placeholder="Passat"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                </div>
            </div>

            {{-- Kasa + Yakıt + Vites --}}
            @php
                $bodyTypeOptions    = ['Sedan','SUV','Hatchback','Station Wagon','Coupe','Cabrio','Van','Minibüs','Pikap','Kamyonet','Diğer'];
                $fuelTypeOptions    = ['Benzin','Dizel','LPG/Benzin','Hibrit','Elektrikli'];
                $transmissionOptions= ['Manuel','Otomatik','Yarı Otomatik'];
                $colorOptions       = ['Beyaz','Siyah','Gri','Gümüş Gri','Kırmızı','Mavi','Lacivert','Yeşil','Bej','Kahverengi','Sarı','Turuncu','Bordo','Mor','Altın','Bronz','Diğer'];

                $curBodyType    = old('body_type',    $vehicle->body_type    ?? '');
                $curFuelType    = old('fuel_type',    $vehicle->fuel_type    ?? '');
                $curTransmission= old('transmission', $vehicle->transmission ?? '');
                $curColor       = old('color',        $vehicle->color        ?? '');

                $bodyTypeManual    = $curBodyType     !== '' && !in_array($curBodyType,     $bodyTypeOptions);
                $fuelTypeManual    = $curFuelType     !== '' && !in_array($curFuelType,     $fuelTypeOptions);
                $transmissionManual= $curTransmission !== '' && !in_array($curTransmission, $transmissionOptions);
                $colorManual       = $curColor        !== '' && !in_array($curColor,        $colorOptions);
            @endphp

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 space-y-4">
                <p class="text-xs text-gray-500 font-medium">Kasa, Yakıt ve Vites Bilgileri</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- Kasa Tipi --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kasa Tipi</label>
                        <select name="body_type" id="editBodyTypeSelect"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm {{ $bodyTypeManual ? 'hidden' : '' }}"
                                {{ $bodyTypeManual ? 'disabled' : '' }}>
                            <option value="">Seçiniz</option>
                            @foreach($bodyTypeOptions as $bt)
                                <option value="{{ $bt }}" {{ $curBodyType === $bt ? 'selected' : '' }}>{{ $bt }}</option>
                            @endforeach
                        </select>
                        <label class="inline-flex items-center mt-2 text-xs text-gray-600 cursor-pointer">
                            <input type="checkbox" id="editManualBodyTypeToggle" class="w-3 h-3 text-red-600 border-gray-300 rounded mr-1.5" {{ $bodyTypeManual ? 'checked' : '' }}>
                            <span>Manuel Gir</span>
                        </label>
                        <input type="text" name="body_type" id="editManualBodyTypeInput"
                               value="{{ $bodyTypeManual ? $curBodyType : '' }}"
                               placeholder="Örn: Sedan, SUV"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm mt-1.5 {{ $bodyTypeManual ? '' : 'hidden' }}"
                               {{ $bodyTypeManual ? '' : 'disabled' }}>
                        @if($bodyTypeManual)<p class="mt-1 text-xs text-amber-600">⚠ "<strong>{{ $curBodyType }}</strong>" listede yok.</p>@endif
                    </div>

                    {{-- Yakıt Tipi --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Yakıt Tipi</label>
                        <select name="fuel_type" id="editFuelTypeSelect"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm {{ $fuelTypeManual ? 'hidden' : '' }}"
                                {{ $fuelTypeManual ? 'disabled' : '' }}>
                            <option value="">Seçiniz</option>
                            @foreach($fuelTypeOptions as $ft)
                                <option value="{{ $ft }}" {{ $curFuelType === $ft ? 'selected' : '' }}>{{ $ft }}</option>
                            @endforeach
                        </select>
                        <label class="inline-flex items-center mt-2 text-xs text-gray-600 cursor-pointer">
                            <input type="checkbox" id="editManualFuelTypeToggle" class="w-3 h-3 text-red-600 border-gray-300 rounded mr-1.5" {{ $fuelTypeManual ? 'checked' : '' }}>
                            <span>Manuel Gir</span>
                        </label>
                        <input type="text" name="fuel_type" id="editManualFuelTypeInput"
                               value="{{ $fuelTypeManual ? $curFuelType : '' }}"
                               placeholder="Örn: Benzin, Dizel"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm mt-1.5 {{ $fuelTypeManual ? '' : 'hidden' }}"
                               {{ $fuelTypeManual ? '' : 'disabled' }}>
                        @if($fuelTypeManual)<p class="mt-1 text-xs text-amber-600">⚠ "<strong>{{ $curFuelType }}</strong>" listede yok.</p>@endif
                    </div>

                    {{-- Vites Tipi --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vites Tipi</label>
                        <select name="transmission" id="editTransmissionSelect"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm {{ $transmissionManual ? 'hidden' : '' }}"
                                {{ $transmissionManual ? 'disabled' : '' }}>
                            <option value="">Seçiniz</option>
                            @foreach($transmissionOptions as $tr)
                                <option value="{{ $tr }}" {{ $curTransmission === $tr ? 'selected' : '' }}>{{ $tr }}</option>
                            @endforeach
                        </select>
                        <label class="inline-flex items-center mt-2 text-xs text-gray-600 cursor-pointer">
                            <input type="checkbox" id="editManualTransmissionToggle" class="w-3 h-3 text-red-600 border-gray-300 rounded mr-1.5" {{ $transmissionManual ? 'checked' : '' }}>
                            <span>Manuel Gir</span>
                        </label>
                        <input type="text" name="transmission" id="editManualTransmissionInput"
                               value="{{ $transmissionManual ? $curTransmission : '' }}"
                               placeholder="Örn: Otomatik, Manuel"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm mt-1.5 {{ $transmissionManual ? '' : 'hidden' }}"
                               {{ $transmissionManual ? '' : 'disabled' }}>
                        @if($transmissionManual)<p class="mt-1 text-xs text-amber-600">⚠ "<strong>{{ $curTransmission }}</strong>" listede yok.</p>@endif
                    </div>
                </div>

                {{-- Paket / Versiyon --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Paket / Versiyon</label>
                        <input type="text" name="package_version" value="{{ old('package_version', $vehicle->package_version) }}"
                               placeholder="1.6 TDI Comfortline"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                    </div>
                </div>
            </div>

        </div>

        {{-- ─── Tab 2: İLAN BİLGİLERİ ──────────────────────────────────────── --}}
        <div id="vtab-ilan" class="vehicle-tab-content p-6 space-y-6 hidden">

            <h3 class="text-lg font-bold text-gray-900">İlan Bilgileri</h3>

            {{-- Başlık --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">İlan Başlığı <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $vehicle->title) }}" required
                       placeholder="Örn: Volkswagen Passat 1.6 TDI BlueMotion"
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                <p class="mt-1 text-xs text-gray-500">Marka, model ve özelliklerini içeren açıklayıcı başlık yazın</p>
            </div>

            {{-- Slug --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    SEO Slug <span class="ml-1 text-xs font-normal text-gray-400">(boş bırakılırsa mevcut slug korunur)</span>
                </label>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-400 whitespace-nowrap">/araclar/</span>
                    <input type="text" name="slug" value="{{ old('slug', $vehicle->slug) }}" placeholder="ornek-arac-adi"
                           class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-mono text-sm">
                </div>
                @error('slug')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                <p class="mt-1 text-xs text-gray-500">
                    <a href="{{ route('vehicles.show', $vehicle->slug ?: $vehicle->id) }}" target="_blank" class="text-red-600 hover:underline">Mevcut URL →</a>
                </p>
            </div>

            {{-- Fiyat + Km --}}
            <div class="border-t pt-6">
                <h4 class="text-sm font-bold text-gray-700 mb-4">Fiyat & Kilometre</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fiyat (₺) <span class="text-red-500">*</span></label>
                        <input type="number" name="price" value="{{ old('price', $vehicle->price) }}" required placeholder="0"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-bold text-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kilometre <span class="text-red-500">*</span></label>
                        <input type="number" name="kilometer" value="{{ old('kilometer', $vehicle->kilometer) }}" required placeholder="0"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                    </div>
                </div>
            </div>

            {{-- Şehir + Takas + Pazarlık --}}
            <div class="border-t pt-6">
                <h4 class="text-sm font-bold text-gray-700 mb-4">Konum & Tercihler</h4>
                @php
                    $curCity    = old('city', $vehicle->city ?? '');
                    $cityInList = $curCity !== '' && in_array($curCity, \App\Models\Vehicle::CITIES);
                    $cityManual = $curCity !== '' && !$cityInList;
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline-block mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Şehir / Konum
                        </label>
                        <select name="city" id="editCitySelect"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm {{ $cityManual ? 'hidden' : '' }}"
                                {{ $cityManual ? 'disabled' : '' }}>
                            <option value="">Seçiniz</option>
                            @foreach(\App\Models\Vehicle::CITIES as $c)
                                <option value="{{ $c }}" {{ $curCity === $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                        <label class="inline-flex items-center mt-2 text-xs text-gray-600 cursor-pointer">
                            <input type="checkbox" id="editManualCityToggle" class="w-3 h-3 text-red-600 border-gray-300 rounded mr-1.5"
                                   {{ $cityManual ? 'checked' : '' }}>
                            <span>Manuel Gir</span>
                        </label>
                        <input type="text" name="city" id="editManualCityInput"
                               value="{{ $cityManual ? $curCity : '' }}"
                               placeholder="Şehir adı yazın"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm mt-1.5 {{ $cityManual ? '' : 'hidden' }}"
                               {{ $cityManual ? '' : 'disabled' }}>
                        @if($cityManual)<p class="mt-1 text-xs text-amber-600">⚠ "<strong>{{ $curCity }}</strong>" listede yok.</p>@endif
                    </div>
                    <div class="flex items-end pb-1">
                        <label class="flex items-start gap-3 p-4 border-2 rounded-lg cursor-pointer transition-all w-full
                            {{ old('swap', $vehicle->swap) ? 'border-green-400 bg-green-50' : 'border-gray-200 hover:border-green-300 hover:bg-green-50/50' }}">
                            <input type="checkbox" name="swap" value="1"
                                   class="w-4 h-4 mt-0.5 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                   {{ old('swap', $vehicle->swap) ? 'checked' : '' }}>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">Takasa Uygun</p>
                                <p class="text-xs text-gray-500 mt-0.5">Araç için takas kabul edilir</p>
                            </div>
                        </label>
                    </div>
                    <div class="flex items-end pb-1">
                        <label class="flex items-start gap-3 p-4 border-2 rounded-lg cursor-pointer transition-all w-full
                            {{ old('price_negotiable', $vehicle->price_negotiable) ? 'border-amber-400 bg-amber-50' : 'border-gray-200 hover:border-amber-300 hover:bg-amber-50/50' }}">
                            <input type="checkbox" name="price_negotiable" value="1"
                                   class="w-4 h-4 mt-0.5 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                                   {{ old('price_negotiable', $vehicle->price_negotiable) ? 'checked' : '' }}>
                            <div>
                                <p class="font-bold text-gray-900 text-sm">Pazarlık Payı Var</p>
                                <p class="text-xs text-gray-500 mt-0.5">Fiyat pazarlığa açıktır</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Araç Durumu (Sıfır / İkinci El) --}}
            <div class="border-t pt-6">
                @php $curCondition = old('condition', $vehicle->condition ?? ''); @endphp
                <label class="block text-sm font-medium text-gray-700 mb-3">Araç Durumu <span class="text-xs font-normal text-gray-400">(Sıfır / İkinci El)</span></label>
                <div class="flex gap-3">
                    @foreach(\App\Models\Vehicle::CONDITIONS as $val => $label)
                    <label class="flex-1 flex items-center gap-3 p-3 border-2 rounded-lg cursor-pointer transition-all
                        {{ $curCondition === $val ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-300 hover:bg-red-50/50' }}">
                        <input type="radio" name="condition" value="{{ $val }}"
                               class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500"
                               {{ $curCondition === $val ? 'checked' : '' }}>
                        <span class="font-semibold text-sm text-gray-800">{{ $label }}</span>
                    </label>
                    @endforeach
                    <label class="flex-1 flex items-center gap-3 p-3 border-2 rounded-lg cursor-pointer transition-all
                        {{ !$curCondition ? 'border-gray-300 bg-gray-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" name="condition" value=""
                               class="w-4 h-4 text-gray-400 border-gray-300 focus:ring-gray-300"
                               {{ !$curCondition ? 'checked' : '' }}>
                        <span class="font-medium text-sm text-gray-500">Belirtme</span>
                    </label>
                </div>
            </div>

            {{-- Açıklama --}}
            <div class="border-t pt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Açıklama</label>
                <textarea name="description" rows="6" placeholder="Aracınız hakkında detaylı bilgi verin..."
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors resize-none">{{ old('description', $vehicle->description) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Araç özellikleri, bakım geçmişi, ekstralar hakkında bilgi verin</p>
            </div>

        </div>

        {{-- ─── Tab 3: TEKNİK DETAYLAR ──────────────────────────────────────── --}}
        <div id="vtab-teknik" class="vehicle-tab-content p-6 space-y-6 hidden">

            <h3 class="text-lg font-bold text-gray-900">Teknik Detaylar</h3>

            {{-- Renk + Renk Tipi --}}
            <div>
                <h4 class="text-sm font-bold text-gray-700 mb-4">Renk</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Renk</label>
                        <select name="color" id="editColorSelect"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm {{ $colorManual ? 'hidden' : '' }}"
                                {{ $colorManual ? 'disabled' : '' }}>
                            <option value="">Seçiniz</option>
                            @foreach($colorOptions as $c)
                                <option value="{{ $c }}" {{ $curColor === $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                        <label class="inline-flex items-center mt-2 text-xs text-gray-600 cursor-pointer">
                            <input type="checkbox" id="editManualColorToggle" class="w-3 h-3 text-red-600 border-gray-300 rounded mr-1.5" {{ $colorManual ? 'checked' : '' }}>
                            <span>Manuel Gir</span>
                        </label>
                        <input type="text" name="color" id="editManualColorInput"
                               value="{{ $colorManual ? $curColor : '' }}"
                               placeholder="Beyaz, Siyah..."
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm mt-1.5 {{ $colorManual ? '' : 'hidden' }}"
                               {{ $colorManual ? '' : 'disabled' }}>
                        @if($colorManual)<p class="mt-1 text-xs text-amber-600">⚠ "<strong>{{ $curColor }}</strong>" listede yok.</p>@endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Renk Tipi</label>
                        <select name="color_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                            <option value="">Seçiniz</option>
                            @foreach(['Metalik','Mat','İnci','Normal'] as $ct)
                                <option value="{{ $ct }}" {{ old('color_type',$vehicle->color_type)===$ct?'selected':'' }}>{{ $ct }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Çekiş + Kapı + Koltuk --}}
            <div class="border-t pt-6">
                <h4 class="text-sm font-bold text-gray-700 mb-4">Şasi & Kapasite</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Çekiş</label>
                        <select name="drive_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                            <option value="">Seçiniz</option>
                            @foreach(['Önden Çekiş','Arkadan İtiş','4x4'] as $dr)
                                <option value="{{ $dr }}" {{ old('drive_type',$vehicle->drive_type)===$dr?'selected':'' }}>{{ $dr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kapı Sayısı</label>
                        <select name="door_count" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                            <option value="">Seçiniz</option>
                            @foreach([2,3,4,5,6,7,8] as $d)
                                <option value="{{ $d }}" {{ (int)old('door_count',$vehicle->door_count)===$d?'selected':'' }}>{{ $d }} Kapı</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Koltuk Sayısı</label>
                        <select name="seat_count" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                            <option value="">Seçiniz</option>
                            @foreach([2,4,5,6,7,8,9,10,12,15] as $s)
                                <option value="{{ $s }}" {{ (int)old('seat_count',$vehicle->seat_count)===$s?'selected':'' }}>{{ $s }} Koltuk</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Motor --}}
            <div class="border-t pt-6">
                <h4 class="text-sm font-bold text-gray-700 mb-4">Motor Özellikleri</h4>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Motor Hacmi (cc)</label>
                            <input type="number" name="engine_size" value="{{ old('engine_size',$vehicle->engine_size) }}" placeholder="1600" min="0"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Motor Gücü (HP)</label>
                            <input type="number" name="horse_power" value="{{ old('horse_power',$vehicle->horse_power) }}" placeholder="120" min="0"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tork (Nm)</label>
                            <input type="number" name="torque" value="{{ old('torque',$vehicle->torque) }}" placeholder="250" min="0"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ─── Tab 5: DONANIMLAR ───────────────────────────────────────────── --}}
        <div id="vtab-donanim" class="vehicle-tab-content p-6 space-y-4 hidden">

            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Donanım & Özellikler</h3>
                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full" id="editSelectedCount">
                    @php $currentFeatures = old('features', $vehicle->features ?? []); @endphp
                    {{ count($currentFeatures) }} özellik seçili
                </span>
            </div>

            <input type="text" id="editFeatureSearch" placeholder="Donanım ara..."
                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm"
                   oninput="filterEditFeatures(this.value)">

            <div class="space-y-2" id="editFeaturesContainer">
                @foreach($featureCategories as $category => $features)
                <div class="border border-gray-200 rounded-lg">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-t-lg cursor-pointer select-none"
                         onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <span class="text-sm font-semibold text-gray-700">{{ $category }}</span>
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div class="p-3">
                        <div class="grid grid-cols-2 gap-1.5">
                            @foreach($features as $feature)
                            <label class="edit-feature-item flex items-center space-x-2 p-2 border border-gray-200 rounded hover:bg-gray-50 cursor-pointer transition-all text-sm">
                                <input type="checkbox" name="features[]" value="{{ $feature }}"
                                       class="w-3.5 h-3.5 text-red-600 border-gray-300 rounded focus:ring-red-500"
                                       onchange="updateEditFeatureCount()"
                                       {{ in_array($feature,$currentFeatures)?'checked':'' }}>
                                <span class="text-gray-700">{{ $feature }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Orphan features --}}
                @php
                    $allCatalogFeatures = collect($featureCategories)->flatten()->toArray();
                    $orphanFeatures = array_filter($currentFeatures, fn($f) => !in_array($f, $allCatalogFeatures));
                @endphp
                @if(count($orphanFeatures) > 0)
                <div class="border border-amber-200 rounded-lg">
                    <div class="flex items-center justify-between p-3 bg-amber-50 rounded-t-lg cursor-pointer select-none"
                         onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <span class="text-sm font-semibold text-amber-700">Diğer (Katalog Dışı)</span>
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                    <div class="p-3">
                        <p class="text-xs text-amber-600 mb-2">Katalogda yer almayan eski özellikler. Korumak istiyorsanız işaretli bırakın.</p>
                        <div class="grid grid-cols-2 gap-1.5">
                            @foreach($orphanFeatures as $feature)
                            <label class="edit-feature-item flex items-center space-x-2 p-2 border border-amber-200 rounded bg-amber-50 cursor-pointer text-sm">
                                <input type="checkbox" name="features[]" value="{{ $feature }}"
                                       class="w-3.5 h-3.5 text-amber-600 border-amber-300 rounded"
                                       onchange="updateEditFeatureCount()" checked>
                                <span class="text-amber-800">{{ $feature }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>

        {{-- ─── Tab 6: HASAR & GEÇMİŞ ─────────────────────────────────────── --}}
        <div id="vtab-hasar" class="vehicle-tab-content p-6 space-y-6 hidden">

            <h3 class="text-lg font-bold text-gray-900">Hasar & Geçmiş Bilgileri</h3>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                <h4 class="font-semibold text-gray-900 mb-4">Tramer & Sahip Bilgisi</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tramer Kaydı</label>
                        <select name="tramer_status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                            <option value="">Seçiniz</option>
                            @foreach(['Yok'=>'Yok (Temiz)','Var'=>'Var','Bilinmiyor'=>'Bilinmiyor'] as $v=>$l)
                                <option value="{{ $v }}" {{ old('tramer_status',$vehicle->tramer_status)===$v?'selected':'' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tramer Tutarı (₺)</label>
                        <input type="number" name="tramer_amount" value="{{ old('tramer_amount',$vehicle->tramer_amount) }}" placeholder="0" step="0.01" min="0"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kaçıncı Sahip</label>
                        <input type="number" name="owner_number" value="{{ old('owner_number',$vehicle->owner_number) }}" placeholder="1" min="1"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                    </div>
                    <div class="flex items-end pb-1">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="has_warranty" value="1" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                                   {{ old('has_warranty',$vehicle->has_warranty)?'checked':'' }}>
                            <span class="text-sm font-medium text-gray-700">Garantisi Var</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                <h4 class="font-semibold text-gray-900 mb-4">Muayene & Garanti Tarihleri</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Muayene Tarihi</label>
                        <input type="date" name="inspection_date"
                               value="{{ old('inspection_date', $vehicle->inspection_date ? $vehicle->inspection_date->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Garanti Bitiş Tarihi</label>
                        <input type="date" name="warranty_end_date"
                               value="{{ old('warranty_end_date', $vehicle->warranty_end_date ? $vehicle->warranty_end_date->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                    </div>
                </div>
            </div>

            @php
                $editParts     = ['Kaput','Ön Tampon','Arka Tampon','Sağ Ön','Sol Ön','Sağ Arka','Sol Arka','Tavan'];
                $paintedParts  = old('painted_parts', $vehicle->painted_parts ?? []);
                $replacedParts = old('replaced_parts', $vehicle->replaced_parts ?? []);
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border border-gray-200 rounded-lg">
                    <div class="bg-yellow-50 px-4 py-3 rounded-t-lg">
                        <h4 class="font-semibold text-yellow-800 text-sm">Boyalı Parçalar</h4>
                        <p class="text-xs text-yellow-600 mt-0.5">Boyalı olan parçaları işaretleyin</p>
                    </div>
                    <div class="p-3 grid grid-cols-2 gap-1.5">
                        @foreach($editParts as $part)
                        <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded hover:bg-yellow-50 cursor-pointer text-sm">
                            <input type="checkbox" name="painted_parts[]" value="{{ $part }}" class="w-3.5 h-3.5 text-yellow-600 border-gray-300 rounded" {{ in_array($part,$paintedParts)?'checked':'' }}>
                            <span class="text-gray-700">{{ $part }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="border border-gray-200 rounded-lg">
                    <div class="bg-red-50 px-4 py-3 rounded-t-lg">
                        <h4 class="font-semibold text-red-800 text-sm">Değişen Parçalar</h4>
                        <p class="text-xs text-red-600 mt-0.5">Değişmiş olan parçaları işaretleyin</p>
                    </div>
                    <div class="p-3 grid grid-cols-2 gap-1.5">
                        @foreach($editParts as $part)
                        <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded hover:bg-red-50 cursor-pointer text-sm">
                            <input type="checkbox" name="replaced_parts[]" value="{{ $part }}" class="w-3.5 h-3.5 text-red-600 border-gray-300 rounded" {{ in_array($part,$replacedParts)?'checked':'' }}>
                            <span class="text-gray-700">{{ $part }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        {{-- ─── Tab 4: GÖRSELLER ───────────────────────────────────────────── --}}
        <div id="vtab-gorseller" class="vehicle-tab-content p-6 space-y-6 hidden">

            <h3 class="text-lg font-bold text-gray-900">Araç Görselleri</h3>

            {{-- Mevcut Görseller --}}
            @php
                $existingImages = is_array($vehicle->images) ? $vehicle->images : ($vehicle->image ? [$vehicle->image] : []);
            @endphp
            @if(count($existingImages) > 0)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Mevcut Görseller
                    <span class="ml-1 text-xs font-normal text-gray-400">— Silmek istediklerinize tıklayın, ana görsel için seçin</span>
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3" id="existingImagesGrid">
                    @foreach($existingImages as $imgPath)
                    @php $displayUrl=\App\Models\Vehicle::resolveImageUrl($imgPath); $isMain=($imgPath===$vehicle->image); @endphp
                    <div class="existing-image-item relative group rounded-lg overflow-hidden border-2 {{ $isMain ? 'border-red-500' : 'border-gray-200' }} transition-all"
                         data-path="{{ $imgPath }}" id="imgItem_{{ $loop->index }}">
                        <img src="{{ $displayUrl }}" alt="Araç görseli" class="w-full h-28 object-cover"
                             onerror="this.src='{{ asset('images/vehicles/default.jpg') }}'">
                        @if($isMain)
                        <span class="absolute top-1 left-1 bg-red-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">Ana</span>
                        @endif
                        <label class="absolute top-1 right-1 cursor-pointer">
                            <input type="checkbox" name="remove_images[]" value="{{ $imgPath }}" class="remove-image-cb sr-only" onchange="toggleRemoveImage(this,{{ $loop->index }})">
                            <span class="flex items-center justify-center w-6 h-6 bg-red-500 text-white rounded-full text-xs font-bold shadow opacity-0 group-hover:opacity-100 transition-opacity" id="removeBtn_{{ $loop->index }}">×</span>
                        </label>
                        <label class="absolute bottom-0 inset-x-0 text-center text-[10px] font-semibold py-1 bg-black/50 text-white cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity">
                            <input type="radio" name="set_main_image" value="{{ $imgPath }}" class="sr-only" {{ $isMain?'checked':'' }}>
                            {{ $isMain?'✓ Ana Görsel':'Ana Görsel Yap' }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <p class="mt-2 text-xs text-gray-500">Üzerine gelip <strong>×</strong> ile silebilir, <strong>Ana Görsel Yap</strong>'a tıklayarak kapak görselini değiştirebilirsiniz.</p>
            </div>
            @endif

            {{-- Yeni Ana Görsel --}}
            <div class="border-t pt-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Yeni Ana Görsel Yükle
                    <span class="ml-1 text-xs font-normal text-gray-400">(mevcut ana görselin yerini alır)</span>
                </label>
                <input type="file" name="main_image" id="editMainImageInput" accept="image/*" class="hidden">
                <label for="editMainImageInput"
                       class="flex items-center gap-3 px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-red-400 hover:bg-red-50 transition-all">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <span class="text-sm text-gray-500" id="editMainLabel">PNG, JPG — Maks. 5MB</span>
                </label>
                <div id="editMainPreview" class="mt-3 hidden">
                    <div class="relative inline-block rounded-lg overflow-hidden border-2 border-red-500">
                        <img id="editMainPreviewImg" src="" alt="Yeni Ana Görsel" class="h-40 w-auto object-cover">
                        <button type="button" onclick="clearEditMain()" class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full text-xs font-bold hover:bg-red-600">×</button>
                    </div>
                </div>
                <div class="mt-2 flex items-start gap-2 px-3 py-2 bg-amber-50 border border-amber-200 rounded-lg">
                    <svg class="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs text-amber-700"><span class="font-bold">Önerilen:</span> 1200 × 800 piksel (3:2 oran)</p>
                </div>
            </div>

            {{-- Ek Galeri --}}
            <div class="border-t pt-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Ek Galeri Görselleri
                    <span class="ml-1 text-xs font-normal text-gray-400">(mevcut görsellerin üstüne eklenir)</span>
                </label>
                <input type="file" name="images[]" id="editGalleryInput" accept="image/*" multiple class="hidden">
                <label for="editGalleryInput"
                       class="flex items-center gap-3 px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-red-400 hover:bg-red-50 transition-all">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span class="text-sm text-gray-500" id="editGalleryLabel">Birden fazla görsel seçebilirsiniz — Maks. 5MB/adet</span>
                </label>
                <div id="editGalleryPreview" class="grid grid-cols-4 sm:grid-cols-6 gap-2 mt-3"></div>
            </div>

        </div>

        {{-- ─── Tab 7: ENTEGRASYON ──────────────────────────────────────────── --}}
        <div id="vtab-diger" class="vehicle-tab-content p-6 space-y-6 hidden">

            <h3 class="text-lg font-bold text-gray-900">Entegrasyon</h3>
            <p class="text-sm text-gray-500 -mt-4">Sahibinden.com üzerinden aktarılan ilanlar için bağlantı bilgileri.</p>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 space-y-4">
                <h4 class="font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Sahibinden.com
                </h4>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">İlan Linki</label>
                    <input type="url" name="sahibinden_url" value="{{ old('sahibinden_url',$vehicle->sahibinden_url) }}" placeholder="https://www.sahibinden.com/ilan/..."
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">İlan No</label>
                    <input type="text" name="sahibinden_id" value="{{ old('sahibinden_id',$vehicle->sahibinden_id) }}" placeholder="1234567890"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-mono">
                </div>
            </div>

        </div>

    </div>{{-- /tabs card --}}
    </div>{{-- /lg:col-span-3 --}}

    {{-- ═══════════════ SIDEBAR ═══════════════ --}}
    <div class="lg:col-span-1">
        <div class="sticky top-6 space-y-4">

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-sm font-bold text-gray-900">Yayın & Araç Durumu</h3>
                </div>
                <div class="p-4 space-y-3">
                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-red-400 hover:bg-red-50 cursor-pointer transition-all">
                        <input type="checkbox" name="is_active" value="1"
                               class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500"
                               {{ old('is_active',$vehicle->is_active)?'checked':'' }}>
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-xs">Aktif (Yayında)</p>
                            <p class="text-xs text-gray-500">Web sitesinde görünür</p>
                        </div>
                    </label>
                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-yellow-400 hover:bg-yellow-50 cursor-pointer transition-all">
                        <input type="checkbox" name="is_featured" value="1"
                               class="w-4 h-4 text-yellow-500 border-gray-300 rounded focus:ring-yellow-400"
                               {{ old('is_featured',$vehicle->is_featured)?'checked':'' }}>
                        <div class="flex-1">
                            <p class="font-bold text-gray-900 text-xs">Öne Çıkarılmış</p>
                            <p class="text-xs text-gray-500">Anasayfada gösterilsin</p>
                        </div>
                    </label>
                    <div class="pt-1">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Araç Durumu</label>
                        <select name="vehicle_status" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                            @foreach(\App\Models\Vehicle::STATUSES as $val => $label)
                                <option value="{{ $val }}" {{ old('vehicle_status',$vehicle->vehicle_status??'available')===$val?'selected':'' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 space-y-2">
                <button type="submit"
                        class="w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-all text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Değişiklikleri Kaydet
                </button>
                <a href="{{ route('admin.vehicles.index') }}"
                   class="w-full px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    İptal
                </a>
            </div>

        </div>
    </div>{{-- /sidebar --}}

    </div>{{-- /grid --}}

</form>

@push('scripts')
<script>
// ─── Tab Switching ─────────────────────────────────────────────────────────────
function switchVehicleTab(tabId) {
    document.querySelectorAll('.vehicle-tab-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.tab === tabId);
    });
    document.querySelectorAll('.vehicle-tab-content').forEach(c => {
        c.classList.toggle('hidden', c.id !== 'vtab-' + tabId);
    });
}

// ─── Ana Görsel Önizleme ────────────────────────────────────────────────────────
document.getElementById('editMainImageInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    document.getElementById('editMainLabel').textContent = file.name;
    const reader = new FileReader();
    reader.onload = e => { document.getElementById('editMainPreviewImg').src = e.target.result; document.getElementById('editMainPreview').classList.remove('hidden'); };
    reader.readAsDataURL(file);
});

function clearEditMain() {
    document.getElementById('editMainImageInput').value = '';
    document.getElementById('editMainLabel').textContent = 'PNG, JPG — Maks. 5MB';
    document.getElementById('editMainPreview').classList.add('hidden');
}

// ─── Galeri Önizleme ────────────────────────────────────────────────────────────
document.getElementById('editGalleryInput').addEventListener('change', function () {
    const preview = document.getElementById('editGalleryPreview');
    preview.innerHTML = '';
    document.getElementById('editGalleryLabel').textContent = this.files.length + ' görsel seçildi';
    Array.from(this.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'relative rounded overflow-hidden border border-gray-200';
            div.innerHTML = `<img src="${e.target.result}" class="w-full h-20 object-cover">`;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
});

// ─── Görsel Silme Toggle ────────────────────────────────────────────────────────
function toggleRemoveImage(cb, index) {
    const item = document.getElementById('imgItem_' + index);
    const btn  = document.getElementById('removeBtn_' + index);
    if (cb.checked) {
        item.classList.add('opacity-40', 'ring-2', 'ring-red-400');
        btn.textContent = '↺'; btn.classList.replace('bg-red-500', 'bg-gray-500'); btn.classList.remove('opacity-0');
    } else {
        item.classList.remove('opacity-40', 'ring-2', 'ring-red-400');
        btn.textContent = '×'; btn.classList.replace('bg-gray-500', 'bg-red-500'); btn.classList.add('opacity-0');
    }
}

// ─── Donanım Arama & Sayaç ──────────────────────────────────────────────────────
function filterEditFeatures(query) {
    query = query.toLowerCase().trim();
    document.querySelectorAll('.edit-feature-item').forEach(label => {
        label.style.display = (!query || label.textContent.trim().toLowerCase().includes(query)) ? '' : 'none';
    });
}
function updateEditFeatureCount() {
    const count = document.querySelectorAll('input[name="features[]"]:checked').length;
    const el = document.getElementById('editSelectedCount');
    if (el) el.textContent = count + ' özellik seçili';
}

// ─── Manuel Gir Toggle'ları ─────────────────────────────────────────────────────
(function () {
    const pairs = [
        { toggle: 'editManualBodyTypeToggle',     select: 'editBodyTypeSelect',     input: 'editManualBodyTypeInput' },
        { toggle: 'editManualFuelTypeToggle',     select: 'editFuelTypeSelect',     input: 'editManualFuelTypeInput' },
        { toggle: 'editManualTransmissionToggle', select: 'editTransmissionSelect', input: 'editManualTransmissionInput' },
        { toggle: 'editManualColorToggle',        select: 'editColorSelect',        input: 'editManualColorInput' },
        { toggle: 'editManualCityToggle',         select: 'editCitySelect',          input: 'editManualCityInput' },
    ];
    pairs.forEach(({ toggle, select, input }) => {
        const toggleEl = document.getElementById(toggle);
        const selectEl = document.getElementById(select);
        const inputEl  = document.getElementById(input);
        if (!toggleEl || !selectEl || !inputEl) return;
        toggleEl.addEventListener('change', function () {
            const isManual = this.checked;
            selectEl.disabled = isManual;
            selectEl.classList.toggle('hidden', isManual);
            inputEl.disabled = !isManual;
            inputEl.classList.toggle('hidden', !isManual);
            if (isManual) {
                inputEl.focus();
            } else {
                inputEl.value = '';
            }
        });
    });
})();

// ─── Form Validasyon ────────────────────────────────────────────────────────────
document.getElementById('vehicleForm').addEventListener('submit', function (e) {
    const required = ['title', 'brand', 'model', 'year', 'kilometer', 'price'];
    let missing = [];
    required.forEach(field => {
        const input = document.querySelector(`[name="${field}"]`);
        if (!input || !String(input.value).trim()) missing.push(field);
    });
    if (missing.length > 0) {
        e.preventDefault();
        Swal.fire({ icon: 'warning', title: 'Eksik Alanlar', text: 'Lütfen zorunlu alanları doldurun.', confirmButtonColor: '#dc2626' });
        return false;
    }
});
</script>
@endpush
@endsection
