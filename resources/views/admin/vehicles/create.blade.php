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
<style>
    /* Tab btn active */
    .vehicle-tab-btn.active { background-color:#dc2626!important; color:#fff!important; border-bottom-color:#dc2626!important; }
    /* Gallery */
    .gallery-item { position:relative; border-radius:0.5rem; overflow:hidden; background:#f9fafb; border:2px solid #e5e7eb; transition:all 0.2s; }
    .gallery-item:hover { border-color:#dc2626; }
    .gallery-item .delete-btn { position:absolute; top:4px; right:4px; background:rgba(220,38,38,0.9); color:#fff; border-radius:0.375rem; padding:4px; cursor:pointer; opacity:0; transition:all 0.2s; }
    .gallery-item:hover .delete-btn { opacity:1; }
    /* Cascade DD disabled state */
    .adm-dd-btn:disabled { background:#f9fafb!important; cursor:not-allowed!important; border-color:#e5e7eb!important; box-shadow:none!important; }
    .adm-dd-btn:disabled span { color:#9ca3af!important; }
    .adm-dd-btn:disabled svg { opacity:0.3; }
    /* Scrollable cascade list */
    .cascade-list { max-height:220px; overflow-y:auto; }
    /* Fix: tab content can overflow (cascade dropdowns mustn't be clipped) */
    .vehicle-form-card { overflow: visible !important; }
    .vehicle-tab-nav { overflow: hidden; border-radius: 0.75rem 0.75rem 0 0; }
    /* Ensure cascade dropdown lists float above everything */
    .adm-dd-list { z-index: 9999 !important; }
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
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-20 vehicle-form-card">

                {{-- Tab Navigation --}}
                <div class="vehicle-tab-nav">
                <div class="flex border-b border-gray-200 overflow-x-auto" id="vehicleTabBtns">
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
                            class="vehicle-tab-btn {{ $i===0 ? 'active' : '' }} flex-1 min-w-[120px] px-4 py-4 text-sm font-semibold transition-colors {{ $i>0 ? 'border-l border-gray-200' : '' }} bg-white text-gray-700 hover:bg-gray-50">
                        <svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"/>
                        </svg>
                        {{ $tab['label'] }}
                    </button>
                    @endforeach
                </div>
                </div>{{-- /vehicle-tab-nav --}}

                {{-- ─── Tab 1: ARAÇ KİMLİĞİ ────────────────────────────────── --}}
                <div id="vtab-kimlik" class="vehicle-tab-content p-6 space-y-5">

                    {{-- Başlık + Manuel Giriş Butonu --}}
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Araç Kimliği</h3>
                            <p id="kimlikHint" class="text-xs text-gray-500 mt-1">Marka ve yılı seçtikten sonra model, ardından kasa / yakıt / vites / paket bilgileri otomatik dolar.</p>
                        </div>
                        <button type="button" id="manualModeBtn" onclick="toggleManualMode()"
                                class="shrink-0 flex items-center gap-1.5 px-3 py-2 text-xs font-medium rounded-lg border border-gray-300 text-gray-600 hover:border-red-400 hover:text-red-600 transition-colors whitespace-nowrap">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <span id="manualModeBtnText">Manuel Giriş</span>
                        </button>
                    </div>

                    {{-- ══════════ CASCADE MODU (varsayılan) ══════════ --}}
                    <div id="cascadeSection" class="space-y-4">

                        {{-- Satır 1: Marka (2/3) + Model Yılı (1/3) --}}
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Marka <span class="text-red-500">*</span></label>
                                <div class="adm-dd" id="ddWrap-brand">
                                    <input type="hidden" id="ddVal-brand">
                                    <button type="button" class="adm-dd-btn" id="ddBtn-brand" onclick="toggleCascadeDD('brand')" disabled>
                                        <span id="ddLabel-brand">Yükleniyor...</span>
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                    <ul class="adm-dd-list cascade-list" id="ddList-brand"></ul>
                                </div>
                            </div>
                            <div class="col-span-1">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Model Yılı <span class="text-red-500">*</span></label>
                                <div class="adm-dd" id="ddWrap-year">
                                    <input type="hidden" name="year" id="ddVal-year" value="{{ old('year') }}">
                                    <button type="button" class="adm-dd-btn" id="ddBtn-year" onclick="toggleCascadeDD('year')">
                                        <span id="ddLabel-year">{{ old('year') ?: 'Yıl Seçiniz' }}</span>
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                    <ul class="adm-dd-list cascade-list" id="ddList-year"></ul>
                                </div>
                            </div>
                        </div>

                        {{-- Satır 2: Model / Seri (2/3) --}}
                        <div class="grid grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Model / Seri <span class="text-red-500">*</span></label>
                                <div class="adm-dd" id="ddWrap-model">
                                    <input type="hidden" id="ddVal-model">
                                    <button type="button" class="adm-dd-btn" id="ddBtn-model" onclick="toggleCascadeDD('model')" disabled>
                                        <span id="ddLabel-model">Önce marka ve yıl seçiniz</span>
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                    <ul class="adm-dd-list cascade-list" id="ddList-model"></ul>
                                </div>
                            </div>
                            <div class="col-span-1"></div>
                        </div>

                        {{-- Satır 3: Kasa (1/3) + Yakıt (1/3) + Vites (1/3) + Paket (1/3) --}}
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 space-y-4">
                            <p class="text-xs text-gray-500 font-medium">↓ Model seçildikten sonra aşağıdaki alanlar sırasıyla aktif olur</p>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Kasa Tipi</label>
                                    <div class="adm-dd" id="ddWrap-bodyType">
                                        <input type="hidden" id="ddVal-bodyType">
                                        <button type="button" class="adm-dd-btn" id="ddBtn-bodyType" onclick="toggleCascadeDD('bodyType')" disabled>
                                            <span id="ddLabel-bodyType">Önce model seçiniz</span>
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                        <ul class="adm-dd-list cascade-list" id="ddList-bodyType"></ul>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Yakıt Tipi</label>
                                    <div class="adm-dd" id="ddWrap-fuelType">
                                        <input type="hidden" id="ddVal-fuelType">
                                        <button type="button" class="adm-dd-btn" id="ddBtn-fuelType" onclick="toggleCascadeDD('fuelType')" disabled>
                                            <span id="ddLabel-fuelType">Önce kasa tipi seçiniz</span>
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                        <ul class="adm-dd-list cascade-list" id="ddList-fuelType"></ul>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Vites Tipi</label>
                                    <div class="adm-dd" id="ddWrap-transmission">
                                        <input type="hidden" id="ddVal-transmission">
                                        <button type="button" class="adm-dd-btn" id="ddBtn-transmission" onclick="toggleCascadeDD('transmission')" disabled>
                                            <span id="ddLabel-transmission">Önce yakıt tipi seçiniz</span>
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                        <ul class="adm-dd-list cascade-list" id="ddList-transmission"></ul>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Paket / Versiyon</label>
                                    <div class="adm-dd" id="ddWrap-version">
                                        <input type="hidden" id="ddVal-version">
                                        <button type="button" class="adm-dd-btn" id="ddBtn-version" onclick="toggleCascadeDD('version')" disabled>
                                            <span id="ddLabel-version">Önce vites tipi seçiniz</span>
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                        <ul class="adm-dd-list cascade-list" id="ddList-version"></ul>
                                    </div>
                                </div>
                                <div class="col-span-2"></div>
                            </div>
                        </div>

                    </div>{{-- /cascadeSection --}}

                    {{-- ══════════ MANUEL GİRİŞ MODU (gizli, butona tıklayınca açılır) ══════════ --}}
                    <div id="manualSection" class="hidden space-y-4">
                        <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-lg px-4 py-3">
                            <svg class="w-4 h-4 text-amber-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-amber-800">Manuel giriş modundasınız. Araç bilgilerini aşağıya yazabilirsiniz. Otomatik seçim için "Cascade'e Dön"e tıklayın.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Marka <span class="text-red-500">*</span></label>
                                <input type="text" id="manualInput-brand" name="brand_manual"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm"
                                       placeholder="Örn: Renault, Dacia, Hyundai">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Model / Seri <span class="text-red-500">*</span></label>
                                <input type="text" id="manualInput-model" name="model_manual"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm"
                                       placeholder="Örn: Clio, Sandero, i20">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kasa Tipi</label>
                                <input type="text" id="manualInput-bodyType" name="body_type_manual"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm"
                                       placeholder="Sedan, Hatchback, SUV, Pick-up…">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Yakıt Tipi</label>
                                <input type="text" id="manualInput-fuelType" name="fuel_type_manual"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm"
                                       placeholder="Benzin, Dizel, LPG, Hibrit, Elektrik…">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Vites Tipi</label>
                                <input type="text" id="manualInput-transmission" name="transmission_manual"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm"
                                       placeholder="Otomatik, Manuel, Yarı Otomatik…">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Paket / Versiyon</label>
                                <input type="text" id="manualInput-version" name="package_version_manual"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm"
                                       placeholder="Örn: 1.5 dCi Executive, 1.6i Comfort">
                            </div>
                        </div>
                    </div>{{-- /manualSection --}}

                </div>

                {{-- ─── Tab 2: İLAN BİLGİLERİ ──────────────────────────────── --}}
                <div id="vtab-ilan" class="vehicle-tab-content p-6 space-y-6 hidden">

                    <h3 class="text-lg font-bold text-gray-900">İlan Bilgileri</h3>

                    {{-- İlan Başlığı --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">İlan Başlığı <span class="text-red-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                               placeholder="Örn: Volkswagen Passat 1.6 TDI BlueMotion Comfortline"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                        <p class="mt-1 text-xs text-gray-500">Marka, model ve özelliklerini içeren açıklayıcı başlık yazın</p>
                    </div>

                    {{-- SEO Slug --}}
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
                    </div>

                    {{-- Fiyat + Kilometre --}}
                    <div class="border-t pt-6">
                        <h4 class="text-sm font-bold text-gray-700 mb-4">Fiyat & Kilometre</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Fiyat (₺) <span class="text-red-500">*</span></label>
                                <input type="number" name="price" value="{{ old('price') }}" required placeholder="0"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors font-bold text-lg">
                                <p class="mt-1 text-xs text-gray-500">Satış fiyatı (KDV dahil)</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kilometre <span class="text-red-500">*</span></label>
                                <input type="number" name="kilometer" value="{{ old('kilometer', 0) }}" required placeholder="0"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors">
                                <p class="mt-1 text-xs text-gray-500">Araç toplam kilometre değeri</p>
                            </div>
                        </div>
                    </div>

                    {{-- Şehir + Takas + Pazarlık --}}
                    <div class="border-t pt-6">
                        <h4 class="text-sm font-bold text-gray-700 mb-4">Konum & Tercihler</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline-block mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    Şehir / Konum
                                </label>
                                @php $createCityInList = in_array(old('city'), \App\Models\Vehicle::CITIES); @endphp
                                <select name="city" id="createCitySelect"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm {{ (old('city') && !$createCityInList) ? 'hidden' : '' }}"
                                        {{ (old('city') && !$createCityInList) ? 'disabled' : '' }}>
                                    <option value="">Seçiniz</option>
                                    @foreach(\App\Models\Vehicle::CITIES as $c)
                                        <option value="{{ $c }}" {{ old('city') === $c ? 'selected' : '' }}>{{ $c }}</option>
                                    @endforeach
                                </select>
                                <label class="inline-flex items-center mt-2 text-xs text-gray-600 cursor-pointer">
                                    <input type="checkbox" id="createManualCityToggle" class="w-3 h-3 text-red-600 border-gray-300 rounded mr-1.5"
                                           {{ (old('city') && !$createCityInList) ? 'checked' : '' }}>
                                    <span>Manuel Gir</span>
                                </label>
                                <input type="text" name="city" id="createManualCityInput"
                                       value="{{ (old('city') && !$createCityInList) ? old('city') : '' }}"
                                       placeholder="Şehir adı yazın"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm mt-1.5 {{ (old('city') && !$createCityInList) ? '' : 'hidden' }}"
                                       {{ (old('city') && !$createCityInList) ? '' : 'disabled' }}>
                            </div>
                            <div class="flex items-end pb-1">
                                <label class="flex items-start gap-3 p-4 border-2 rounded-lg cursor-pointer transition-all w-full
                                    {{ old('swap') ? 'border-green-400 bg-green-50' : 'border-gray-200 hover:border-green-300 hover:bg-green-50/50' }}">
                                    <input type="checkbox" name="swap" value="1"
                                           class="w-4 h-4 mt-0.5 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                           {{ old('swap') ? 'checked' : '' }}>
                                    <div>
                                        <p class="font-bold text-gray-900 text-sm">Takasa Uygun</p>
                                        <p class="text-xs text-gray-500 mt-0.5">Araç için takas kabul edilir</p>
                                    </div>
                                </label>
                            </div>
                            <div class="flex items-end pb-1">
                                <label class="flex items-start gap-3 p-4 border-2 rounded-lg cursor-pointer transition-all w-full
                                    {{ old('price_negotiable') ? 'border-amber-400 bg-amber-50' : 'border-gray-200 hover:border-amber-300 hover:bg-amber-50/50' }}">
                                    <input type="checkbox" name="price_negotiable" value="1"
                                           class="w-4 h-4 mt-0.5 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                                           {{ old('price_negotiable') ? 'checked' : '' }}>
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
                        <label class="block text-sm font-medium text-gray-700 mb-3">Araç Durumu <span class="text-xs font-normal text-gray-400">(Sıfır / İkinci El)</span></label>
                        <div class="flex gap-3">
                            @foreach(\App\Models\Vehicle::CONDITIONS as $val => $label)
                            <label class="flex-1 flex items-center gap-3 p-3 border-2 rounded-lg cursor-pointer transition-all
                                {{ old('condition') === $val ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-300 hover:bg-red-50/50' }}">
                                <input type="radio" name="condition" value="{{ $val }}"
                                       class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500"
                                       {{ old('condition') === $val ? 'checked' : '' }}>
                                <span class="font-semibold text-sm text-gray-800">{{ $label }}</span>
                            </label>
                            @endforeach
                            <label class="flex-1 flex items-center gap-3 p-3 border-2 rounded-lg cursor-pointer transition-all
                                {{ !old('condition') ? 'border-gray-300 bg-gray-50' : 'border-gray-200 hover:border-gray-300' }}">
                                <input type="radio" name="condition" value=""
                                       class="w-4 h-4 text-gray-400 border-gray-300 focus:ring-gray-300"
                                       {{ !old('condition') ? 'checked' : '' }}>
                                <span class="font-medium text-sm text-gray-500">Belirtme</span>
                            </label>
                        </div>
                    </div>

                    {{-- Açıklama --}}
                    <div class="border-t pt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Açıklama</label>
                        <textarea name="description" rows="6" placeholder="Aracınız hakkında detaylı bilgi verin..."
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors resize-none">{{ old('description') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Araç özellikleri, bakım geçmişi, ekstralar hakkında bilgi verin</p>
                    </div>

                </div>

                {{-- ─── Tab 3: TEKNİK DETAYLAR ─────────────────────────────── --}}
                <div id="vtab-teknik" class="vehicle-tab-content p-6 space-y-6 hidden">

                    <h3 class="text-lg font-bold text-gray-900">Teknik Detaylar</h3>

                    {{-- Renk + Renk Tipi --}}
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 mb-4">Renk</h4>
                        @php
                            $colorOptions = ['Beyaz','Siyah','Gri','Gümüş Gri','Kırmızı','Mavi','Lacivert','Yeşil','Bej','Kahverengi','Sarı','Turuncu','Bordo','Mor','Altın','Bronz','Diğer'];
                        @endphp
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Renk</label>
                                <select name="color" id="colorSelect" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors text-sm">
                                    <option value="">Seçiniz</option>
                                    @foreach($colorOptions as $c)
                                        <option value="{{ $c }}" {{ old('color')===$c?'selected':'' }}>{{ $c }}</option>
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
                                        <option value="{{ $dr }}" {{ old('drive_type')===$dr?'selected':'' }}>{{ $dr }}</option>
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

                    {{-- Motor Hacmi + Güç + Tork --}}
                    <div class="border-t pt-6">
                        <h4 class="text-sm font-bold text-gray-700 mb-4">Motor Özellikleri</h4>
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

    // ── CASCADE DD SİSTEMİ ────────────────────────────────────────────────────
    let cascadeData = {
        brandId: null, brandName: null, brandArabamId: null,
        year: null,
        modelId: null, modelName: null, modelArabamId: null,
        bodyTypeId: null, bodyTypeName: null,
        fuelTypeId: null, fuelTypeName: null,
        transmissionId: null, transmissionName: null,
        versionId: null, versionName: null
    };

    // Dropdown aç/kapat
    window.toggleCascadeDD = function(id) {
        const btn  = document.getElementById('ddBtn-' + id);
        const list = document.getElementById('ddList-' + id);
        if (!btn || btn.disabled) return;
        const isOpen = list.classList.contains('open');
        // Tüm açık cascade & adm-dd listelerini kapat
        document.querySelectorAll('.adm-dd-list.open').forEach(function(l) {
            l.classList.remove('open');
            const wrap = l.closest('.adm-dd');
            if (wrap) { const b = wrap.querySelector('.adm-dd-btn'); if (b) b.classList.remove('open'); }
        });
        if (!isOpen) { list.classList.add('open'); btn.classList.add('open'); }
    };

    // Dropdown durumunu sıfırla (disabled / loading)
    function setCascadeState(id, placeholder) {
        const btn   = document.getElementById('ddBtn-' + id);
        const label = document.getElementById('ddLabel-' + id);
        const list  = document.getElementById('ddList-' + id);
        const val   = document.getElementById('ddVal-' + id);
        if (val)   { val.value = ''; }
        if (label) { label.textContent = placeholder; label.style.color = '#9ca3af'; }
        if (list)  { list.innerHTML = ''; list.classList.remove('open'); }
        if (btn)   { btn.classList.remove('open'); btn.disabled = true; }
    }

    // Dropdown'ı doldur ve aktif et
    function fillCascadeDD(id, items, placeholder, onSelect) {
        const btn   = document.getElementById('ddBtn-' + id);
        const label = document.getElementById('ddLabel-' + id);
        const list  = document.getElementById('ddList-' + id);
        const val   = document.getElementById('ddVal-' + id);
        list.innerHTML = '';
        if (val) val.value = '';
        if (!items || items.length === 0) {
            const li = document.createElement('li');
            li.textContent = 'Sonuç bulunamadı';
            li.style.color = '#9ca3af'; li.style.cursor = 'default';
            list.appendChild(li);
            if (btn)   btn.disabled = true;
            if (label) { label.textContent = 'Bulunamadı'; label.style.color = '#9ca3af'; }
            return;
        }
        items.forEach(function(item) {
            const li = document.createElement('li');
            li.dataset.value   = (item.Id !== undefined && item.Id !== null) ? item.Id : (item.value || '');
            li.dataset.name    = item.Name || item.name || '';
            li.dataset.arabamId = item.ArabamId || '';
            li.textContent = item.Name || item.name || '';
            li.addEventListener('click', function() {
                if (val)   val.value = this.dataset.value;
                if (label) { label.textContent = this.textContent; label.style.color = '#111827'; }
                list.querySelectorAll('li').forEach(function(l) { l.classList.remove('selected'); });
                this.classList.add('selected');
                list.classList.remove('open');
                if (btn) btn.classList.remove('open');
                if (onSelect) onSelect({ value: this.dataset.value, name: this.dataset.name, arabamId: this.dataset.arabamId });
            });
            list.appendChild(li);
        });
        if (label) { label.textContent = placeholder; label.style.color = '#9ca3af'; }
        if (btn)   btn.disabled = false;
        if (items.length === 1) list.querySelector('li').click();
    }

    // Cascade zincirini belirtilen adımdan sıfırla
    function resetCascadeFrom(step) {
        const chain = [
            { key: 'model',        placeholder: 'Önce marka ve yıl seçiniz' },
            { key: 'bodyType',     placeholder: 'Önce model seçiniz' },
            { key: 'fuelType',     placeholder: 'Önce kasa tipi seçiniz' },
            { key: 'transmission', placeholder: 'Önce yakıt tipi seçiniz' },
            { key: 'version',      placeholder: 'Önce vites tipi seçiniz' },
        ];
        let found = false;
        chain.forEach(function(s) {
            if (s.key === step) found = true;
            if (!found) return;
            setCascadeState(s.key, s.placeholder);
            cascadeData[s.key + 'Id']   = null;
            cascadeData[s.key + 'Name'] = null;
            if (s.key === 'model') cascadeData.modelArabamId = null;
        });
    }

    // ── YÜKLEME FONKSİYONLARI ────────────────────────────────────────────────
    function loadYears() {
        const y = new Date().getFullYear();
        const items = [];
        for (let i = y + 1; i >= 1990; i--) items.push({ Id: i, Name: String(i) });
        fillCascadeDD('year', items, 'Yıl Seçiniz', function(sel) {
            cascadeData.year = sel.value;
            resetCascadeFrom('model');
            if (cascadeData.year && cascadeData.brandId) loadModels();
        });
        // old() değerini geri yükle
        const oldYear = '{{ old("year") }}';
        if (oldYear) {
            document.getElementById('ddVal-year').value = oldYear;
            const lbl = document.getElementById('ddLabel-year');
            lbl.textContent  = oldYear;
            lbl.style.color  = '#111827';
            cascadeData.year = oldYear;
            document.querySelectorAll('#ddList-year li').forEach(function(li) {
                if (String(li.dataset.value) === String(oldYear)) li.classList.add('selected');
            });
        }
    }

    function loadBrands() {
        setCascadeState('brand', 'Yükleniyor...');
        $.ajax({
            url: '{{ route("admin.vehicles.api.brands") }}',
            method: 'GET', timeout: 8000,
            success: function(r) {
                if (r.success && r.data && r.data.Items) {
                    fillCascadeDD('brand', r.data.Items, 'Marka Seçiniz', function(sel) {
                        cascadeData.brandId      = sel.value;
                        cascadeData.brandName    = sel.name;
                        cascadeData.brandArabamId = sel.arabamId;
                        resetCascadeFrom('model');
                        if (cascadeData.brandId && cascadeData.year) loadModels();
                    });
                } else {
                    const btn = document.getElementById('ddBtn-brand');
                    const lbl = document.getElementById('ddLabel-brand');
                    if (btn) btn.disabled = true;
                    if (lbl) { lbl.textContent = 'Marka yüklenemedi'; lbl.style.color = '#ef4444'; }
                }
            },
            error: function() {
                const btn = document.getElementById('ddBtn-brand');
                const lbl = document.getElementById('ddLabel-brand');
                if (btn) btn.disabled = true;
                if (lbl) { lbl.textContent = 'Bağlantı hatası'; lbl.style.color = '#ef4444'; }
            }
        });
    }

    function loadModels() {
        // Arabam API step=20: BrandId(arabam) + ModelYear → gerçek model/seri listesi
        apiStepFill('model', '20',
            { brandId: cascadeData.brandArabamId, modelYear: cascadeData.year },
            'Model Seçiniz',
            function(sel) {
                cascadeData.modelId       = sel.value;
                cascadeData.modelName     = sel.name;
                cascadeData.modelArabamId = sel.value; // step 20 ID = modelGroupId olarak kullanılır
                resetCascadeFrom('bodyType');
                if (cascadeData.modelId && cascadeData.brandArabamId) loadBodyTypes();
            }
        );
    }

    function apiStepFill(ddId, step, data, placeholder, onSelect) {
        setCascadeState(ddId, 'Yükleniyor...');
        $.ajax({
            url: '/api/arabam/step', method: 'GET',
            data: Object.assign({ step: step }, data),
            success: function(r) {
                if (r.success && r.data && r.data.Items) {
                    fillCascadeDD(ddId, r.data.Items, placeholder, onSelect);
                } else {
                    setCascadeState(ddId, 'Bulunamadı');
                }
            },
            error: function() { setCascadeState(ddId, 'Hata oluştu'); }
        });
    }

    function loadBodyTypes() {
        apiStepFill('bodyType', '30',
            { brandId: cascadeData.brandArabamId, modelYear: cascadeData.year, modelGroupId: cascadeData.modelArabamId },
            'Kasa Tipi Seçiniz',
            function(sel) {
                cascadeData.bodyTypeId   = sel.value;
                cascadeData.bodyTypeName = sel.name;
                resetCascadeFrom('fuelType');
                loadFuelTypes();
            }
        );
    }
    function loadFuelTypes() {
        apiStepFill('fuelType', '40',
            { brandId: cascadeData.brandArabamId, modelYear: cascadeData.year, modelGroupId: cascadeData.modelArabamId, bodyTypeId: cascadeData.bodyTypeId },
            'Yakıt Tipi Seçiniz',
            function(sel) {
                cascadeData.fuelTypeId   = sel.value;
                cascadeData.fuelTypeName = sel.name;
                resetCascadeFrom('transmission');
                loadTransmissions();
            }
        );
    }
    function loadTransmissions() {
        apiStepFill('transmission', '50',
            { brandId: cascadeData.brandArabamId, modelYear: cascadeData.year, modelGroupId: cascadeData.modelArabamId, bodyTypeId: cascadeData.bodyTypeId, fuelTypeId: cascadeData.fuelTypeId },
            'Vites Tipi Seçiniz',
            function(sel) {
                cascadeData.transmissionId   = sel.value;
                cascadeData.transmissionName = sel.name;
                resetCascadeFrom('version');
                loadVersions();
            }
        );
    }
    function loadVersions() {
        apiStepFill('version', '60',
            { brandId: cascadeData.brandArabamId, modelYear: cascadeData.year, modelGroupId: cascadeData.modelArabamId, bodyTypeId: cascadeData.bodyTypeId, fuelTypeId: cascadeData.fuelTypeId, transmissionTypeId: cascadeData.transmissionId },
            'Versiyon Seçiniz',
            function(sel) {
                cascadeData.versionId   = sel.value;
                cascadeData.versionName = sel.name;
            }
        );
    }

    // Init
    loadYears();
    loadBrands();

    // ── MANUEL GİRİŞ MODU (tek buton ile toggle) ─────────────────────────────
    let isManualMode = false;

    window.toggleManualMode = function() {
        isManualMode = !isManualMode;
        const btn     = document.getElementById('manualModeBtn');
        const btnText = document.getElementById('manualModeBtnText');
        const hint    = document.getElementById('kimlikHint');

        if (isManualMode) {
            document.getElementById('cascadeSection').classList.add('hidden');
            document.getElementById('manualSection').classList.remove('hidden');
            btn.classList.add('bg-red-50', 'border-red-400', 'text-red-600');
            btnText.textContent = 'Cascade\'e Dön';
            if (hint) hint.textContent = 'Manuel giriş modu — araç bilgilerini aşağıya yazınız.';
            // Cascade datasını sıfırla
            cascadeData.brandId = null; cascadeData.brandName = null; cascadeData.brandArabamId = null;
            cascadeData.modelId = null; cascadeData.modelName = null; cascadeData.modelArabamId = null;
            cascadeData.bodyTypeId = null; cascadeData.fuelTypeId = null;
            cascadeData.transmissionId = null; cascadeData.versionId = null;
        } else {
            document.getElementById('cascadeSection').classList.remove('hidden');
            document.getElementById('manualSection').classList.add('hidden');
            btn.classList.remove('bg-red-50', 'border-red-400', 'text-red-600');
            btnText.textContent = 'Manuel Giriş';
            if (hint) hint.textContent = 'Marka ve yılı seçtikten sonra model, ardından kasa / yakıt / vites / paket bilgileri otomatik dolar.';
            // Manuel inputları temizle
            ['brand', 'model', 'bodyType', 'fuelType', 'transmission', 'version'].forEach(function(k) {
                const el = document.getElementById('manualInput-' + k);
                if (el) el.value = '';
            });
        }
    };

    // Şehir manuel toggle
    $('#createManualCityToggle').on('change', function() {
        if ($(this).is(':checked')) {
            $('#createCitySelect').hide().prop('disabled', true);
            $('#createManualCityInput').show().removeClass('hidden').prop('disabled', false).focus();
        } else {
            $('#createCitySelect').show().prop('disabled', false);
            $('#createManualCityInput').hide().addClass('hidden').prop('disabled', true).val('');
        }
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
    $('.submit-btn').on('click', function() { $('#formAction').val($(this).data('action')); });

    $('#vehicleForm').on('submit', function(e) {
        const dt = new DataTransfer();
        galleryFiles.forEach(f => dt.items.add(f));
        document.getElementById('galleryInput').files = dt.files;

        const action = $('#formAction').val();

        // ── Validasyon (yalnızca yayınlama için) ──────────────────────────────
        if (action === 'publish') {
            const brandVal = isManualMode
                ? document.getElementById('manualInput-brand').value.trim()
                : (cascadeData.brandId || document.getElementById('ddVal-brand').value);
            const modelVal = isManualMode
                ? document.getElementById('manualInput-model').value.trim()
                : (cascadeData.modelId || document.getElementById('ddVal-model').value);
            const yearVal  = document.getElementById('ddVal-year').value;

            const missing = [];
            if (!$('[name="title"]').val().trim()) missing.push('Başlık');
            if (!brandVal)                        missing.push('Marka');
            if (!modelVal)                        missing.push('Model');
            if (!yearVal)                         missing.push('Yıl');
            if (!$('[name="kilometer"]').val())   missing.push('Kilometre');
            if (!$('[name="price"]').val())       missing.push('Fiyat');
            const hasImported = document.querySelectorAll('#importImageGrid img').length > 0;
            if (!$('#mainImageInput')[0].files.length && !hasImported) missing.push('Ana Görsel');

            if (missing.length > 0) {
                e.preventDefault();
                Swal.fire({
                    title: 'Eksik Alanlar',
                    html: '<p class="text-sm text-gray-600 mb-2">Yayınlamak için şu alanları doldurun:</p><ul class="text-left text-sm list-disc pl-5">' + missing.map(f => `<li class="text-red-600">${f}</li>`).join('') + '</ul>',
                    icon: 'error', confirmButtonColor: '#dc2626', confirmButtonText: 'Tamam'
                });
                return false;
            }
        }

        // ── Önceki denemelerden kalan geçici inputları temizle ────────────────
        $('#vehicleForm .js-dyn').remove();

        if (isManualMode) {
            // Manuel mod: doğrudan input değerlerini kullan
            const manualFields = {
                brand:          'manualInput-brand',
                model:          'manualInput-model',
                body_type:      'manualInput-bodyType',
                fuel_type:      'manualInput-fuelType',
                transmission:   'manualInput-transmission',
                package_version:'manualInput-version',
            };
            Object.entries(manualFields).forEach(function([fieldName, inputId]) {
                const v = (document.getElementById(inputId) || {}).value;
                if (v && v.trim()) $('<input type="hidden" class="js-dyn">').attr('name', fieldName).val(v.trim()).appendTo('#vehicleForm');
            });
        } else {
            // Cascade mod: hidden input değerlerinden form field'larını oluştur
            const cascadeFields = [
                { name: 'brand',           valId: 'ddVal-brand',        nameKey: 'brandName' },
                { name: 'model',           valId: 'ddVal-model',        nameKey: 'modelName' },
                { name: 'package_version', valId: 'ddVal-version',      nameKey: 'versionName' },
                { name: 'body_type',       valId: 'ddVal-bodyType',     nameKey: 'bodyTypeName' },
                { name: 'fuel_type',       valId: 'ddVal-fuelType',     nameKey: 'fuelTypeName' },
                { name: 'transmission',    valId: 'ddVal-transmission', nameKey: 'transmissionName' },
            ];
            cascadeFields.forEach(function(f) {
                const val  = document.getElementById(f.valId).value;
                const name = cascadeData[f.nameKey] || document.getElementById(f.valId.replace('ddVal-', 'ddLabel-')).textContent;
                if (val) $('<input type="hidden" class="js-dyn">').attr('name', f.name).val(name || val).appendTo('#vehicleForm');
            });
        }

        if (action === 'draft')   $('[name="is_active"]').prop('checked', false);
        else if (action === 'publish') $('[name="is_active"]').prop('checked', true);
    });
});
</script>
@endpush
@endsection
