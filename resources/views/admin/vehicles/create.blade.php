@extends('admin.layouts.app')

@section('title', 'Yeni Araç Ekle - Admin Panel')
@section('page-title', 'Yeni Araç Ekle')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Anasayfa</a>
    <span>/</span>
    <a href="{{ route('admin.vehicles.index') }}" class="hover:text-primary-600">Araçlar</a>
    <span>/</span>
    <span>Yeni Ekle</span>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Select2 Compact */
    .select2-container--default .select2-selection--single {
        height: 38px !important; padding: 4px 10px !important;
        border: 1px solid #d1d5db !important; border-radius: 0.5rem !important;
        font-size: 0.875rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 30px !important; font-size: 0.875rem !important; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px !important; }
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #dc2626 !important; box-shadow: 0 0 0 3px rgba(220,38,38,0.15) !important;
    }
    /* Tab btn active */
    .vehicle-tab-btn.active { background-color:#dc2626!important; color:#fff!important; border-bottom-color:#dc2626!important; }
    /* Gallery */
    .gallery-item { position:relative; border-radius:0.5rem; overflow:hidden; background:#f9fafb; border:2px solid #e5e7eb; transition:all 0.2s; }
    .gallery-item:hover { border-color:#dc2626; }
    .gallery-item .delete-btn { position:absolute; top:4px; right:4px; background:rgba(220,38,38,0.9); color:#fff; border-radius:0.375rem; padding:4px; cursor:pointer; opacity:0; transition:all 0.2s; }
    .gallery-item:hover .delete-btn { opacity:1; }
    /* Disabled cascade */
    select:disabled { background:#f9fafb; color:#9ca3af; cursor:not-allowed; }
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                Yeni Araç Ekle
            </h2>
            <a href="{{ route('admin.vehicles.index') }}"
               class="flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-all text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Geri
            </a>
        </div>
        <p class="text-sm text-gray-500 mt-1 ml-[52px]">Tüm araç bilgilerini eksiksiz doldurun</p>
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

{{-- Sahibinden.com Import Card --}}
<div class="mb-6 bg-white rounded-xl border-2 border-blue-200 shadow-sm overflow-hidden" id="sahibindenImportCard">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-white">Sahibinden.com'dan İçe Aktar</h3>
                <p class="text-xs text-blue-100">İlan linkini yapıştır, veriler otomatik doldurulsun</p>
            </div>
        </div>
        <button type="button" onclick="toggleImportCard()" class="text-blue-200 hover:text-white transition-colors">
            <svg class="w-4 h-4" id="importCardChevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
    </div>
    <div id="importCardBody" class="p-5">
        <div class="flex gap-3">
            <input type="url" id="sahibindenImportUrl" placeholder="https://www.sahibinden.com/ilan/vasita-..."
                   class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all"
                   onkeydown="if(event.key==='Enter'){event.preventDefault();triggerSahibindenImport();}">
            <button type="button" onclick="triggerSahibindenImport()" id="importBtn"
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-sm transition-all flex items-center gap-2">
                <svg class="w-4 h-4" id="importBtnIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <span id="importBtnText">Veriyi Çek</span>
            </button>
        </div>
        <div id="importMessage" class="hidden mt-3 text-sm rounded-lg px-4 py-3"></div>
        <div id="importImagePreview" class="hidden mt-4">
            <p class="text-xs font-semibold text-gray-600 mb-2">İçe Aktarılan Görseller:</p>
            <div id="importImageGrid" class="flex gap-2 flex-wrap"></div>
        </div>
        <div id="importDuplicateWarning" class="hidden mt-3 bg-yellow-50 border border-yellow-300 rounded-lg px-4 py-3 text-sm text-yellow-800"></div>
        <div id="importResultSummary" class="hidden mt-3 bg-green-50 border border-green-200 rounded-lg px-4 py-3">
            <p class="text-xs font-bold text-green-700 mb-1">✓ Aşağıdaki alanlar dolduruldu:</p>
            <div id="importFilledFields" class="flex flex-wrap gap-1.5"></div>
        </div>
        <p class="mt-3 text-xs text-gray-400">Tüm alanlar içe aktarma sonrasında manuel olarak düzenlenebilir.</p>
    </div>
</div>

<form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data" id="vehicleForm">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        {{-- ════════════════════════════════════
             MAIN CONTENT — Settings-style Tabs
             ════════════════════════════════════ --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-20">

                {{-- Tab Navigation --}}
                <div class="flex border-b border-gray-200 overflow-x-auto" id="vehicleTabBtns">
                    @php
                        $tabs = [
                            ['id'=>'temel',    'icon'=>'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',       'label'=>'Temel Bilgiler'],
                            ['id'=>'teknik',   'icon'=>'M13 10V3L4 14h7v7l9-11h-7z',                                         'label'=>'Teknik Özellikler'],
                            ['id'=>'donanim',  'icon'=>'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'label'=>'Donanımlar'],
                            ['id'=>'hasar',    'icon'=>'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'label'=>'Hasar & Geçmiş'],
                            ['id'=>'gorseller','icon'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'label'=>'Görseller'],
                            ['id'=>'diger',    'icon'=>'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14', 'label'=>'Entegrasyon'],
                        ];
                    @endphp
                    @foreach($tabs as $i => $tab)
                    <button type="button"
                            data-tab="{{ $tab['id'] }}"
                            onclick="switchVehicleTab('{{ $tab['id'] }}')"
                            class="vehicle-tab-btn {{ $i===0 ? 'active' : '' }} flex-1 min-w-[120px] px-4 py-4 text-sm font-semibold transition-colors {{ $i>0 ? 'border-l border-gray-200' : '' }} bg-white text-gray-700 hover:bg-gray-50">
                        <svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"/>
                        </svg>
                        {{ $tab['label'] }}
                    </button>
                    @endforeach
                </div>

                {{-- ─── Tab 1: TEMEL BİLGİLER ──────────────────────────────── --}}
                <div id="vtab-temel" class="vehicle-tab-content p-6 space-y-6">

                    <h3 class="text-lg font-bold text-gray-900">İlan Bilgileri</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">İlan Başlığı <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                               placeholder="Örn: Volkswagen Passat 1.6 TDI BlueMotion Comfortline"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                        <p class="mt-1 text-xs text-gray-500">Marka, model ve özelliklerini içeren açıklayıcı başlık yazın</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            SEO Slug
                            <span class="ml-1 text-xs font-normal text-gray-400">(opsiyonel — boş bırakılırsa başlıktan üretilir)</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-400 whitespace-nowrap">/araclar/</span>
                            <input type="text" name="slug" id="slug-input" value="{{ old('slug') }}" placeholder="ornek-arac-adi"
                                   class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-mono text-sm">
                        </div>
                        @error('slug')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        <p class="mt-1 text-xs text-gray-500">Yalnızca küçük harf, rakam ve tire kullanın</p>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Marka & Model (Basamaklı Seçim)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Marka <span class="text-red-500">*</span></label>
                                <select name="brand" id="brandSelect" required class="w-full">
                                    <option value="">Marka Seçiniz</option>
                                </select>
                                <label class="inline-flex items-center mt-2 text-xs text-gray-600 cursor-pointer">
                                    <input type="checkbox" id="manualBrandToggle" class="w-3 h-3 text-red-600 border-gray-300 rounded mr-1.5">
                                    <span>Manuel Gir</span>
                                </label>
                                <input type="text" id="manualBrandInput" name="brand_manual" disabled class="hidden w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors mt-1.5" placeholder="Marka adı yazınız">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Model Yılı <span class="text-red-500">*</span></label>
                                <select name="year" id="yearSelect" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm" disabled>
                                    <option value="">Önce marka seçiniz</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Model <span class="text-red-500">*</span></label>
                                <select name="model" id="modelSelect" required class="w-full" disabled>
                                    <option value="">Önce yıl seçiniz</option>
                                </select>
                                <label class="inline-flex items-center mt-2 text-xs text-gray-600 cursor-pointer">
                                    <input type="checkbox" id="manualModelToggle" class="w-3 h-3 text-red-600 border-gray-300 rounded mr-1.5">
                                    <span>Manuel Gir</span>
                                </label>
                                <input type="text" id="manualModelInput" name="model_manual" disabled class="hidden w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors mt-1.5" placeholder="Model adı yazınız">
                            </div>
                            <div></div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Fiyat & Kilometre</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kilometre <span class="text-red-500">*</span></label>
                                <input type="number" name="kilometer" value="{{ old('kilometer', 0) }}" required placeholder="0"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                <p class="mt-1 text-xs text-gray-500">Araç toplam kilometre değeri</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fiyat (₺) <span class="text-red-500">*</span></label>
                                <input type="number" name="price" value="{{ old('price') }}" required placeholder="0"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-bold text-lg">
                                <p class="mt-1 text-xs text-gray-500">Satış fiyatı (KDV dahil)</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ─── Tab 2: TEKNİK ÖZELLİKLER ────────────────────────────── --}}
                <div id="vtab-teknik" class="vehicle-tab-content p-6 space-y-6 hidden">

                    <h3 class="text-lg font-bold text-gray-900">Kasa & Yakıt (Basamaklı)</h3>
                    <p class="text-xs text-gray-500 -mt-4">Temel Bilgiler sekmesinde marka/model/yıl seçildikten sonra bu değerler otomatik dolar.</p>

                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gövde / Kasa Tipi</label>
                                <select name="body_type" id="bodyTypeSelect" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm" disabled>
                                    <option value="">Önce model seçiniz</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Yakıt Tipi</label>
                                <select name="fuel_type" id="fuelTypeSelect" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm" disabled>
                                    <option value="">Önce gövde tipi seçiniz</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Vites Tipi</label>
                                <select name="transmission" id="transmissionSelect" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm" disabled>
                                    <option value="">Önce yakıt tipi seçiniz</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Paket / Versiyon</label>
                                <select name="package_version" id="versionSelect" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm" disabled>
                                    <option value="">Önce vites tipi seçiniz</option>
                                </select>
                                <label class="inline-flex items-center mt-2 text-xs text-gray-600 cursor-pointer">
                                    <input type="checkbox" id="manualVersionToggle" class="w-3 h-3 text-red-600 border-gray-300 rounded mr-1.5">
                                    <span>Manuel Gir</span>
                                </label>
                                <input type="text" id="manualVersionInput" name="package_version_manual" disabled class="hidden w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors mt-1.5 text-sm" placeholder="Versiyon yazınız">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Renk</label>
                                <select name="color" id="colorSelect" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm" disabled>
                                    <option value="">Önce versiyon seçiniz</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Araç Detayları</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Çekiş</label>
                                <select name="drive_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                                    <option value="">Seçiniz</option>
                                    @foreach(['Önden Çekiş','Arkadan İtiş','4x4'] as $dr)
                                        <option value="{{ $dr }}" {{ old('drive_type')===$dr?'selected':'' }}>{{ $dr }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Renk Tipi</label>
                                <select name="color_type" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                                    <option value="">Seçiniz</option>
                                    @foreach(['Metalik','Mat','İnci','Normal'] as $ct)
                                        <option value="{{ $ct }}" {{ old('color_type')===$ct?'selected':'' }}>{{ $ct }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kapı Sayısı</label>
                                <select name="door_count" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                                    <option value="">Seçiniz</option>
                                    @foreach([2,3,4,5,6,7,8] as $d)
                                        <option value="{{ $d }}" {{ (int)old('door_count')===$d?'selected':'' }}>{{ $d }} Kapı</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Koltuk Sayısı</label>
                                <select name="seat_count" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                                    <option value="">Seçiniz</option>
                                    @foreach([2,4,5,6,7,8,9,10,12,15] as $s)
                                        <option value="{{ $s }}" {{ (int)old('seat_count')===$s?'selected':'' }}>{{ $s }} Koltuk</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Motor Özellikleri</h3>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Motor Hacmi (cc)</label>
                                    <input type="number" name="engine_size" value="{{ old('engine_size') }}" placeholder="1600" min="0"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Motor Gücü (HP)</label>
                                    <input type="number" name="horse_power" value="{{ old('horse_power') }}" placeholder="120" min="0"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tork (Nm)</label>
                                    <input type="number" name="torque" value="{{ old('torque') }}" placeholder="250" min="0"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Açıklama</label>
                        <textarea name="description" rows="6" placeholder="Aracınız hakkında detaylı bilgi verin..."
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors resize-none">{{ old('description') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Araç özellikleri, bakım geçmişi, ekstralar hakkında bilgi verin</p>
                    </div>

                </div>

                {{-- ─── Tab 3: DONANIMLAR ────────────────────────────────────── --}}
                <div id="vtab-donanim" class="vehicle-tab-content p-6 space-y-4 hidden">

                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Donanım & Özellikler</h3>
                        <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full" id="selectedCount">0 özellik seçili</span>
                    </div>

                    <input type="text" id="featureSearch" placeholder="Donanım ara..."
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">

                    <div class="space-y-2" id="featuresContainer">
                        @foreach($featureCategories as $category => $features)
                        <div class="border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-t-lg cursor-pointer select-none"
                                 onclick="this.nextElementSibling.classList.toggle('hidden')">
                                <span class="text-sm font-semibold text-gray-700">{{ $category }}</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                            <div class="p-3">
                                <div class="grid grid-cols-2 gap-1.5">
                                    @foreach($features as $feature)
                                    <label class="feature-item flex items-center space-x-2 p-2 border border-gray-200 rounded hover:bg-gray-50 cursor-pointer transition-all text-sm">
                                        <input type="checkbox" name="features[]" value="{{ $feature }}"
                                               class="w-3.5 h-3.5 text-red-600 border-gray-300 rounded focus:ring-red-500"
                                               onchange="updateFeatureCount()"
                                               {{ in_array($feature, old('features', [])) ? 'checked' : '' }}>
                                        <span class="text-gray-700">{{ $feature }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>

                {{-- ─── Tab 4: HASAR & GEÇMİŞ ──────────────────────────────── --}}
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
                                        <option value="{{ $v }}" {{ old('tramer_status')===$v?'selected':'' }}>{{ $l }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tramer Tutarı (₺)</label>
                                <input type="number" name="tramer_amount" value="{{ old('tramer_amount') }}" placeholder="0" step="0.01" min="0"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kaçıncı Sahip</label>
                                <input type="number" name="owner_number" value="{{ old('owner_number') }}" placeholder="1" min="1"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                            </div>
                            <div class="flex items-end pb-1">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="has_warranty" value="1" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500" {{ old('has_warranty')?'checked':'' }}>
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
                                <input type="date" name="inspection_date" value="{{ old('inspection_date') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Garanti Bitiş Tarihi</label>
                                <input type="date" name="warranty_end_date" value="{{ old('warranty_end_date') }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                            </div>
                        </div>
                    </div>

                    @php $parts = ['Kaput','Ön Tampon','Arka Tampon','Sağ Ön','Sol Ön','Sağ Arka','Sol Arka','Tavan']; @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="border border-gray-200 rounded-lg">
                            <div class="bg-yellow-50 px-4 py-3 rounded-t-lg">
                                <h4 class="font-semibold text-yellow-800 text-sm">Boyalı Parçalar</h4>
                                <p class="text-xs text-yellow-600 mt-0.5">Boyalı olan parçaları işaretleyin</p>
                            </div>
                            <div class="p-3 grid grid-cols-2 gap-1.5">
                                @foreach($parts as $part)
                                <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded hover:bg-yellow-50 cursor-pointer text-sm">
                                    <input type="checkbox" name="painted_parts[]" value="{{ $part }}" class="w-3.5 h-3.5 text-yellow-600 border-gray-300 rounded" {{ in_array($part, old('painted_parts',[])) ? 'checked' : '' }}>
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
                                @foreach($parts as $part)
                                <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded hover:bg-red-50 cursor-pointer text-sm">
                                    <input type="checkbox" name="replaced_parts[]" value="{{ $part }}" class="w-3.5 h-3.5 text-red-600 border-gray-300 rounded" {{ in_array($part, old('replaced_parts',[])) ? 'checked' : '' }}>
                                    <span class="text-gray-700">{{ $part }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

                {{-- ─── Tab 5: GÖRSELLER ─────────────────────────────────────── --}}
                <div id="vtab-gorseller" class="vehicle-tab-content p-6 space-y-6 hidden">

                    <h3 class="text-lg font-bold text-gray-900">Araç Görselleri</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ana Görsel <span class="text-xs font-normal text-gray-400 ml-1">(yayınlamak için gerekli)</span></label>
                        <input type="file" name="main_image" id="mainImageInput" accept="image/*" class="hidden">
                        <label for="mainImageInput"
                               class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-red-400 hover:bg-red-50 transition-all cursor-pointer group">
                            <svg class="w-12 h-12 text-gray-400 group-hover:text-red-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-700 group-hover:text-red-600">Tıklayın veya görseli sürükleyin</p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG — Maks. 5MB</p>
                        </label>
                        <div id="mainPreview" class="mt-3 hidden">
                            <div class="relative inline-block rounded-lg overflow-hidden border-2 border-red-500">
                                <img id="mainPreviewImg" src="" alt="Ana Görsel" class="h-48 w-auto object-cover max-w-full">
                                <button type="button" onclick="removeMainImage()" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-lg p-1.5 shadow-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                        <div class="mt-2 flex items-start gap-2 px-3 py-2 bg-amber-50 border border-amber-200 rounded-lg">
                            <svg class="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-xs text-amber-700"><span class="font-bold">Önerilen:</span> 1200 × 800 piksel (3:2 oran)</p>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <div class="flex items-center justify-between mb-3">
                            <label class="text-sm font-medium text-gray-700">Galeri Görselleri <span class="ml-1 text-xs font-normal text-gray-400">(sürükleyerek sıralayabilirsiniz)</span></label>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full" id="galleryCount">0/15</span>
                        </div>
                        <input type="file" id="singleImageInput" accept="image/*" class="hidden">
                        <button type="button" onclick="document.getElementById('singleImageInput').click()"
                                class="w-full border-2 border-dashed border-gray-300 rounded-lg p-5 text-center hover:border-red-400 hover:bg-red-50 transition-all group">
                            <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-red-500 mb-1.5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <p class="text-xs font-medium text-gray-700 group-hover:text-red-600">Görsel Ekle</p>
                        </button>
                        <div id="galleryPreview" class="grid grid-cols-3 sm:grid-cols-5 gap-2 mt-3"></div>
                        <input type="file" name="images[]" id="galleryInput" multiple class="hidden">
                    </div>

                </div>

                {{-- ─── Tab 6: ENTEGRASYON ──────────────────────────────────── --}}
                <div id="vtab-diger" class="vehicle-tab-content p-6 space-y-6 hidden">

                    <h3 class="text-lg font-bold text-gray-900">Entegrasyon</h3>
                    <p class="text-sm text-gray-500 -mt-4">Sahibinden.com üzerinden aktarılan ilanlar için bağlantı bilgilerini girin.</p>

                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-5 space-y-4">
                        <h4 class="font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            Sahibinden.com
                        </h4>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">İlan Linki</label>
                            <input type="url" name="sahibinden_url" value="{{ old('sahibinden_url') }}" placeholder="https://www.sahibinden.com/..."
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">İlan No</label>
                            <input type="text" name="sahibinden_id" value="{{ old('sahibinden_id') }}" placeholder="123456789"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-mono">
                        </div>
                    </div>

                </div>

            </div>
        </div>

        {{-- ════════════════════════════════
             SIDEBAR — Yayın & Araç Durumu
             ════════════════════════════════ --}}
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-4">

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-sm font-bold text-gray-900">Yayın & Araç Durumu</h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-red-400 hover:bg-red-50 cursor-pointer transition-all">
                            <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 text-xs">Aktif (Yayında)</p>
                                <p class="text-xs text-gray-500">Web sitesinde görünür</p>
                            </div>
                        </label>
                        <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-yellow-400 hover:bg-yellow-50 cursor-pointer transition-all">
                            <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 text-yellow-500 border-gray-300 rounded focus:ring-yellow-400">
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 text-xs">Öne Çıkarılmış</p>
                                <p class="text-xs text-gray-500">Anasayfada gösterilsin</p>
                            </div>
                        </label>
                        <div class="pt-1">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Araç Durumu</label>
                            <select name="vehicle_status" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                @foreach(\App\Models\Vehicle::STATUSES as $val => $label)
                                    <option value="{{ $val }}" {{ old('vehicle_status','available')===$val?'selected':'' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 space-y-2">
                    <input type="hidden" name="action" id="formAction" value="publish">
                    <button type="submit" data-action="publish"
                            class="submit-btn w-full px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-all text-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Kaydet ve Yayınla
                    </button>
                    <button type="submit" data-action="draft"
                            class="submit-btn w-full px-4 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all text-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        Taslak Kaydet
                    </button>
                </div>

            </div>
        </div>

    </div>
</form>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
// ─── Tab Switching ────────────────────────────────────────────────────────────
function switchVehicleTab(tabId) {
    document.querySelectorAll('.vehicle-tab-btn').forEach(btn => {
        const isActive = btn.dataset.tab === tabId;
        btn.classList.toggle('active', isActive);
        btn.classList.toggle('bg-white', !isActive);
        btn.classList.toggle('text-gray-700', !isActive);
    });
    document.querySelectorAll('.vehicle-tab-content').forEach(c => {
        c.classList.toggle('hidden', c.id !== 'vtab-' + tabId);
    });
}

// ─── Sahibinden Import ────────────────────────────────────────────────────────
const IMPORT_URL  = '{{ route('admin.vehicles.import.sahibinden') }}';
const IMPORT_CSRF = '{{ csrf_token() }}';
const FIELD_LABELS = {
    title:'Başlık', brand:'Marka', model:'Model', package_version:'Paket',
    year:'Yıl', price:'Fiyat', kilometer:'KM', fuel_type:'Yakıt',
    transmission:'Vites', body_type:'Kasa', color:'Renk',
    engine_size:'Motor', horse_power:'Beygir', description:'Açıklama',
    sahibinden_url:'İlan Linki', sahibinden_id:'İlan No',
};

function toggleImportCard() {
    const body=document.getElementById('importCardBody');
    const chevron=document.getElementById('importCardChevron');
    body.classList.toggle('hidden');
    chevron.style.transform=body.classList.contains('hidden')?'rotate(-90deg)':'';
}

function triggerSahibindenImport() {
    const url=document.getElementById('sahibindenImportUrl').value.trim();
    if(!url){showImportMessage('Lütfen bir Sahibinden.com linki girin.','warning');return;}
    const btn=document.getElementById('importBtn');
    btn.disabled=true; btn.classList.replace('bg-blue-600','bg-blue-400');
    document.getElementById('importBtnIcon').innerHTML='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>';
    document.getElementById('importBtnText').textContent='Yükleniyor...';
    clearImportUI();
    fetch(IMPORT_URL,{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':IMPORT_CSRF,'Accept':'application/json'},body:JSON.stringify({url})})
    .then(r=>r.json()).then(json=>{
        resetImportBtn();
        if(!json.success){showImportMessage('⚠ '+(json.message||'İlan çekilemedi.'),'error');return;}
        const data=json.data||{};
        if(json.duplicate){const d=json.duplicate;document.getElementById('importDuplicateWarning').innerHTML=`⚠ Bu ilan daha önce "<strong>${d.title}</strong>" olarak eklenmiş. <a href="${d.url}" target="_blank" class="underline font-bold">Mevcut kaydı görüntüle →</a>`;document.getElementById('importDuplicateWarning').classList.remove('hidden');}
        const warnings=json.warnings||[];
        warnings.length>0?showImportMessage('⚠ '+warnings.join(' | '),'warning'):showImportMessage('✓ İlan başarıyla çekildi.','success');
        const catalogMatch=json.catalog_match||{};
        if(catalogMatch.brand_match){$('#manualBrandToggle').prop('checked',true).trigger('change');$('#manualBrandInput').val(catalogMatch.brand_match);}
        else if(data.brand){$('#manualBrandToggle').prop('checked',true).trigger('change');$('#manualBrandInput').val(data.brand);}
        if(catalogMatch.model_match){$('#manualModelToggle').prop('checked',true).trigger('change');$('#manualModelInput').val(catalogMatch.model_match);}
        else if(data.model){$('#manualModelToggle').prop('checked',true).trigger('change');$('#manualModelInput').val(data.model);}
        const filled=populateForm(data,['brand','model']);
        if(filled.length>0){
            const allFilled=filled.slice();
            if(catalogMatch.brand_match)allFilled.unshift('Marka ✓');
            if(catalogMatch.model_match)allFilled.unshift('Model ✓');
            else if(data.brand)allFilled.unshift('Marka (ham)');
            document.getElementById('importFilledFields').innerHTML=allFilled.map(f=>`<span class="text-xs bg-green-100 text-green-700 border border-green-200 px-2 py-0.5 rounded-full">${f}</span>`).join('');
            document.getElementById('importResultSummary').classList.remove('hidden');
        }
        const imgs=json.resolved_images||[];
        if(imgs.length>0){
            document.getElementById('importImageGrid').innerHTML=imgs.map(u=>`<img src="${u}" class="h-20 w-28 object-cover rounded-lg border-2 border-green-300" onerror="this.style.display='none'">`).join('');
            document.getElementById('importImagePreview').classList.remove('hidden');
        }
    }).catch(()=>{resetImportBtn();showImportMessage('Bağlantı hatası oluştu.','error');});
}

function populateForm(data, extraSkip) {
    const filled=[];
    const skip=['images','images_meta','image','_warnings','source'].concat(extraSkip||[]);
    Object.entries(data).forEach(([key,val])=>{
        if(skip.includes(key)||val===null||val===undefined||val==='')return;
        const el=document.querySelector(`[name="${key}"]`);
        if(!el)return;
        if(el.tagName==='SELECT'){el.value=val;$(el).trigger('change');}
        else if(el.type==='checkbox'){el.checked=!!val;}
        else{el.value=val;$(el).trigger('input').trigger('change');}
        if(FIELD_LABELS[key])filled.push(FIELD_LABELS[key]);
    });
    return filled;
}

function showImportMessage(msg,type){
    const el=document.getElementById('importMessage');
    el.textContent=msg;
    el.className='mt-3 text-sm rounded-lg px-4 py-3 '+(type==='success'?'bg-green-50 text-green-700 border border-green-200':type==='warning'?'bg-yellow-50 text-yellow-700 border border-yellow-200':'bg-red-50 text-red-700 border border-red-200');
    el.classList.remove('hidden');
}
function clearImportUI(){
    ['importMessage','importImagePreview','importDuplicateWarning','importResultSummary'].forEach(id=>document.getElementById(id)?.classList.add('hidden'));
    document.getElementById('importImageGrid').innerHTML='';
    document.getElementById('importFilledFields').innerHTML='';
}
function resetImportBtn(){
    const btn=document.getElementById('importBtn');
    btn.disabled=false;btn.classList.replace('bg-blue-400','bg-blue-600');
    document.getElementById('importBtnIcon').innerHTML='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>';
    document.getElementById('importBtnText').textContent='Veriyi Çek';
}

// ─── Document Ready ───────────────────────────────────────────────────────────
$(document).ready(function(){

    // Select2
    $('#brandSelect,#modelSelect').select2({placeholder:'Seçiniz',allowClear:true,tags:true,width:'100%'});

    // ── CASCADE ──────────────────────────────────────────────────────────────
    let cascadeData={brandId:null,year:null,modelId:null,bodyTypeId:null,fuelTypeId:null,transmissionId:null,versionId:null};
    loadBrands();

    function loadBrands(){
        $.ajax({url:'{{ route("admin.vehicles.api.brands") }}',method:'GET',timeout:5000,
            success:function(r){
                if(r.success&&r.data&&r.data.Items){
                    $('#brandSelect').empty().append('<option value="">Marka Seçiniz</option>');
                    r.data.Items.forEach(b=>$('#brandSelect').append($('<option>').attr('value',b.Id).attr('data-name',b.Name).attr('data-arabam-id',b.ArabamId||'').text(b.Name)));
                }else $('#brandSelect').empty().append('<option value="">Marka yüklenemedi</option>');
            },
            error:function(){$('#brandSelect').empty().append('<option value="">Hata oluştu</option>');}
        });
    }

    function loadYears(){
        const y=new Date().getFullYear();
        $('#yearSelect').empty().append('<option value="">Yıl Seçiniz</option>');
        for(let i=y+1;i>=1990;i--)$('#yearSelect').append($('<option>').val(i).text(i));
        $('#yearSelect').prop('disabled',false);
    }

    $('#brandSelect').on('change',function(){cascadeData.brandId=$(this).val();resetCascadeFrom('year');if(cascadeData.brandId)loadYears();});
    $('#yearSelect').on('change',function(){cascadeData.year=$(this).val();resetCascadeFrom('model');if(cascadeData.year&&cascadeData.brandId)loadModels(cascadeData.brandId,cascadeData.year);});
    $('#modelSelect').on('change',function(){cascadeData.modelId=$(this).val();const arabamId=$('#brandSelect option:selected').data('arabam-id');resetCascadeFrom('bodyType');if(cascadeData.modelId&&arabamId)loadBodyTypes(arabamId,cascadeData.year,cascadeData.modelId);});
    $('#bodyTypeSelect').on('change',function(){cascadeData.bodyTypeId=$(this).val();resetCascadeFrom('fuelType');if(cascadeData.bodyTypeId)loadFuelTypes(cascadeData.brandId,cascadeData.year,cascadeData.modelId,cascadeData.bodyTypeId);});
    $('#fuelTypeSelect').on('change',function(){cascadeData.fuelTypeId=$(this).val();resetCascadeFrom('transmission');if(cascadeData.fuelTypeId)loadTransmissions(cascadeData.brandId,cascadeData.year,cascadeData.modelId,cascadeData.bodyTypeId,cascadeData.fuelTypeId);});
    $('#transmissionSelect').on('change',function(){cascadeData.transmissionId=$(this).val();resetCascadeFrom('version');if(cascadeData.transmissionId)loadVersions(cascadeData.brandId,cascadeData.year,cascadeData.modelId,cascadeData.bodyTypeId,cascadeData.fuelTypeId,cascadeData.transmissionId);});
    $('#versionSelect').on('change',function(){cascadeData.versionId=$(this).val();if(cascadeData.versionId)loadColors(cascadeData.brandId,cascadeData.year,cascadeData.modelId,cascadeData.bodyTypeId,cascadeData.fuelTypeId,cascadeData.transmissionId,cascadeData.versionId);});

    function resetCascadeFrom(step){
        const steps=['year','model','bodyType','fuelType','transmission','version','color'];
        for(let i=steps.indexOf(step);i<steps.length;i++){
            switch(steps[i]){
                case 'year':$('#yearSelect').prop('disabled',true).empty().append('<option>Önce marka seçiniz</option>');cascadeData.year=null;break;
                case 'model':$('#modelSelect').prop('disabled',true).empty().append('<option>Önce yıl seçiniz</option>');cascadeData.modelId=null;break;
                case 'bodyType':$('#bodyTypeSelect').prop('disabled',true).empty().append('<option>Önce model seçiniz</option>');cascadeData.bodyTypeId=null;break;
                case 'fuelType':$('#fuelTypeSelect').prop('disabled',true).empty().append('<option>Önce gövde tipi seçiniz</option>');cascadeData.fuelTypeId=null;break;
                case 'transmission':$('#transmissionSelect').prop('disabled',true).empty().append('<option>Önce yakıt tipi seçiniz</option>');cascadeData.transmissionId=null;break;
                case 'version':$('#versionSelect').prop('disabled',true).empty().append('<option>Önce vites tipi seçiniz</option>');cascadeData.versionId=null;break;
                case 'color':$('#colorSelect').prop('disabled',true).empty().append('<option>Önce versiyon seçiniz</option>');break;
            }
        }
    }

    function apiStep(step,data,selector,placeholder){
        $(selector).prop('disabled',false).empty().append(`<option>${placeholder}</option>`);
        $.ajax({url:'/api/arabam/step',method:'GET',data:Object.assign({step},data),
            success:function(r){
                if(r.success&&r.data&&r.data.Items){
                    populateSelect(selector,r.data.Items,placeholder);
                    if(r.data.Items.length===1)$(selector).val(r.data.Items[0].Id||r.data.Items[0].Name).trigger('change');
                }else $(selector).empty().append(`<option>Bulunamadı</option>`);
            },
            error:function(){$(selector).empty().append(`<option>Hata</option>`);}
        });
    }

    function loadModels(brandId,year){
        $('#modelSelect').prop('disabled',false).empty().append('<option>Yükleniyor...</option>');
        $.ajax({url:'{{ route("admin.vehicles.api.models") }}',method:'GET',data:{brandId},
            success:function(r){
                if(r.success&&r.data&&r.data.Items){populateSelect('#modelSelect',r.data.Items,'Model Seçiniz');if(r.data.Items.length===1)$('#modelSelect').val(r.data.Items[0].Id).trigger('change');}
                else $('#modelSelect').empty().append('<option>Model bulunamadı</option>');
            },
            error:function(){$('#modelSelect').empty().append('<option>Hata</option>');}
        });
    }
    function loadBodyTypes(arabamId,year,modelId){apiStep('30',{brandId:arabamId,modelYear:year,modelGroupId:$('#modelSelect option:selected').data('arabam-id')||modelId},'#bodyTypeSelect','Gövde Tipi Seçiniz');}
    function loadFuelTypes(bId,y,mId,btId){apiStep('40',{brandId:bId,modelYear:y,modelGroupId:mId,bodyTypeId:btId},'#fuelTypeSelect','Yakıt Tipi Seçiniz');}
    function loadTransmissions(bId,y,mId,btId,ftId){apiStep('50',{brandId:bId,modelYear:y,modelGroupId:mId,bodyTypeId:btId,fuelTypeId:ftId},'#transmissionSelect','Vites Tipi Seçiniz');}
    function loadVersions(bId,y,mId,btId,ftId,trId){apiStep('60',{brandId:bId,modelYear:y,modelGroupId:mId,bodyTypeId:btId,fuelTypeId:ftId,transmissionTypeId:trId},'#versionSelect','Versiyon Seçiniz');}
    function loadColors(bId,y,mId,btId,ftId,trId,vId){apiStep('70',{brandId:bId,modelYear:y,modelGroupId:mId,bodyTypeId:btId,fuelTypeId:ftId,transmissionTypeId:trId,modelId:vId},'#colorSelect','Renk Seçiniz');}

    function populateSelect(selector,items,placeholder){
        $(selector).empty().append(`<option value="">${placeholder}</option>`);
        items.forEach(item=>{const o=$('<option>').attr('value',item.Id).attr('data-name',item.Name).text(item.Name);if(item.ArabamId)o.attr('data-arabam-id',item.ArabamId);$(selector).append(o);});
    }

    // ── MANUEL GİRİŞ ─────────────────────────────────────────────────────────
    $('#manualBrandToggle').on('change',function(){
        if($(this).is(':checked')){$('#brandSelect').hide().prop('disabled',true);$('#manualBrandInput').show().removeClass('hidden').prop('disabled',false);}
        else{$('#brandSelect').show().prop('disabled',false);$('#manualBrandInput').hide().addClass('hidden').prop('disabled',true).val('');}
    });
    $('#manualModelToggle').on('change',function(){
        if($(this).is(':checked')){$('#modelSelect').hide().prop('disabled',true);$('#manualModelInput').show().removeClass('hidden').prop('disabled',false);}
        else{$('#modelSelect').show().prop('disabled',false);$('#manualModelInput').hide().addClass('hidden').prop('disabled',true).val('');}
    });
    $('#manualVersionToggle').on('change',function(){
        if($(this).is(':checked')){$('#versionSelect').hide().prop('disabled',true);$('#manualVersionInput').show().removeClass('hidden').prop('disabled',false);}
        else{$('#versionSelect').show().prop('disabled',false);$('#manualVersionInput').hide().addClass('hidden').prop('disabled',true).val('');}
    });

    // ── DONANIM SAYACI & ARAMA ─────────────────────────────────────────────
    window.updateFeatureCount=function(){
        document.getElementById('selectedCount').textContent=document.querySelectorAll('#featuresContainer input[type="checkbox"]:checked').length+' özellik seçili';
    };
    $('#featureSearch').on('keyup',function(){
        const q=$(this).val().toLowerCase();
        $('.feature-item').each(function(){$(this).toggle($(this).text().toLowerCase().indexOf(q)>-1);});
    });

    // ── ANA GÖRSEL ────────────────────────────────────────────────────────────
    $('#mainImageInput').on('change',function(e){
        const file=e.target.files[0];
        if(!file)return;
        const reader=new FileReader();
        reader.onload=function(ev){$('#mainPreviewImg').attr('src',ev.target.result);$('#mainPreview').removeClass('hidden');};
        reader.readAsDataURL(file);
    });
    window.removeMainImage=function(){$('#mainImageInput').val('');$('#mainPreview').addClass('hidden');};

    // ── GALERİ ────────────────────────────────────────────────────────────────
    let galleryFiles=[]; const MAX_G=15;
    $('#singleImageInput').on('change',function(e){
        const file=e.target.files[0]; if(!file)return;
        if(galleryFiles.length>=MAX_G){Swal.fire({title:'Limit Aşıldı',text:`Maks. ${MAX_G} görsel.`,icon:'warning',confirmButtonColor:'#dc2626'});$(this).val('');return;}
        if(file.size>5*1024*1024){Swal.fire({title:'Görsel Çok Büyük',text:"5MB'dan küçük olmalı.",icon:'warning',confirmButtonColor:'#dc2626'});$(this).val('');return;}
        galleryFiles.push(file);$(this).val('');renderGallery();
    });
    function renderGallery(){
        $('#galleryPreview').empty(); $('#galleryCount').text(galleryFiles.length+'/'+MAX_G);
        if(!galleryFiles.length)return;
        galleryFiles.forEach((file,i)=>{
            const reader=new FileReader();
            reader.onload=function(e){
                $('#galleryPreview').append(`<div class="gallery-item" data-index="${i}"><img src="${e.target.result}" class="w-full h-24 object-cover"><button type="button" onclick="removeGalleryItem(${i})" class="delete-btn"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button><div class="absolute bottom-1 left-1 bg-black/70 text-white text-xs font-bold px-1.5 py-0.5 rounded">${i+1}</div></div>`);
            };
            reader.readAsDataURL(file);
        });
        setTimeout(()=>{if(galleryFiles.length>1)new Sortable(document.getElementById('galleryPreview'),{animation:200,onEnd:function(evt){const m=galleryFiles.splice(evt.oldIndex,1)[0];galleryFiles.splice(evt.newIndex,0,m);renderGallery();}});},100);
    }
    window.removeGalleryItem=function(i){
        Swal.fire({title:'Görseli Kaldır?',text:'Bu görseli galeriden kaldırmak istediğinize emin misiniz?',icon:'question',showCancelButton:true,confirmButtonColor:'#dc2626',cancelButtonColor:'#6b7280',confirmButtonText:'Evet, Kaldır',cancelButtonText:'İptal'})
        .then(r=>{if(r.isConfirmed){galleryFiles.splice(i,1);renderGallery();}});
    };

    // ── FORM SUBMIT ───────────────────────────────────────────────────────────
    $('.submit-btn').on('click',function(){$('#formAction').val($(this).data('action'));});

    $('#vehicleForm').on('submit',function(e){
        const dt=new DataTransfer();galleryFiles.forEach(f=>dt.items.add(f));document.getElementById('galleryInput').files=dt.files;

        if($('#manualBrandToggle').is(':checked')){const v=$('#manualBrandInput').val().trim();if(v)$('<input type="hidden" name="brand">').val(v).appendTo('#vehicleForm');}
        else{const s=$('#brandSelect option:selected');if(s.val()){$('#brandSelect').after('<input type="hidden" name="brand" value="'+(s.data('name')||s.text())+'">');$('#brandSelect').prop('disabled',true);}}

        if($('#manualModelToggle').is(':checked')){const v=$('#manualModelInput').val().trim();if(v)$('<input type="hidden" name="model">').val(v).appendTo('#vehicleForm');}
        else{const s=$('#modelSelect option:selected');if(s.val()){$('#modelSelect').after('<input type="hidden" name="model" value="'+(s.data('name')||s.text())+'">');$('#modelSelect').prop('disabled',true);}}

        if($('#manualVersionToggle').is(':checked')){const v=$('#manualVersionInput').val().trim();if(v)$('<input type="hidden" name="package_version">').val(v).appendTo('#vehicleForm');}
        else{const s=$('#versionSelect option:selected');if(s.val()){$('#versionSelect').after('<input type="hidden" name="package_version" value="'+(s.data('name')||s.text())+'">');$('#versionSelect').prop('disabled',true);}}

        [['body_type','#bodyTypeSelect'],['fuel_type','#fuelTypeSelect'],['transmission','#transmissionSelect'],['color','#colorSelect']].forEach(([fn,si])=>{
            const s=$(si+' option:selected');if(s.val()){$(si).after('<input type="hidden" name="'+fn+'" value="'+(s.data('name')||s.text())+'">');$(si).prop('disabled',true);}
        });

        const action=$('#formAction').val();
        if(action==='publish'){
            const required=[{name:'title',label:'Başlık'},{selector:'#brandSelect,#manualBrandInput',label:'Marka'},{selector:'#modelSelect,#manualModelInput',label:'Model'},{name:'year',label:'Yıl'},{name:'kilometer',label:'Kilometre'},{name:'price',label:'Fiyat'}];
            let missing=[];
            required.forEach(f=>{
                let val=f.selector?$(f.selector).filter(':visible').val():$(`[name="${f.name}"]`).val();
                if(!val||val.trim()==='')missing.push(f.label);
            });
            const hasImported=document.querySelectorAll('#importImageGrid img').length>0;
            if(!$('#mainImageInput')[0].files.length&&!hasImported)missing.push('Ana Görsel');
            if(missing.length>0){
                e.preventDefault();
                Swal.fire({title:'Eksik Alanlar',html:'<p class="text-sm text-gray-600 mb-2">Yayınlamak için şu alanları doldurun:</p><ul class="text-left text-sm list-disc pl-5">'+missing.map(f=>`<li class="text-red-600">${f}</li>`).join('')+'</ul>',icon:'error',confirmButtonColor:'#dc2626',confirmButtonText:'Tamam'});
                return false;
            }
        }
        if(action==='draft')$('[name="is_active"]').prop('checked',false);
        else if(action==='publish')$('[name="is_active"]').prop('checked',true);
    });
});
</script>
@endpush
@endsection
