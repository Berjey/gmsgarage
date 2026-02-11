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
        height: 38px !important;
        padding: 4px 10px !important;
        border: 1px solid #d1d5db !important;
        border-radius: 0.5rem !important;
        font-size: 0.875rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px !important;
        font-size: 0.875rem !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.08) !important;
    }
    
    /* Tabs */
    .tab-item {
        position: relative;
        padding: 0.75rem 1.25rem;
        font-weight: 500;
        font-size: 0.875rem;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.2s;
        border-bottom: 2px solid transparent;
    }
    .tab-item:hover {
        color: #dc2626;
        background: #fef2f2;
    }
    .tab-item.active {
        color: #dc2626;
        border-bottom-color: #dc2626;
        background: white;
    }
    .tab-item .badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        width: 8px;
        height: 8px;
        background: #dc2626;
        border-radius: 50%;
    }
    
    /* Tab Content */
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Form Input */
    .form-input {
        font-size: 0.875rem;
    }
    .form-input:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.08);
        outline: none;
    }
    
    /* Accordion */
    .accordion-header {
        cursor: pointer;
        transition: background 0.2s;
    }
    .accordion-header:hover {
        background: #f9fafb;
    }
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    .accordion-content.active {
        max-height: 2000px;
    }
    
    /* Gallery Item */
    .gallery-item {
        position: relative;
        border-radius: 0.5rem;
        overflow: hidden;
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        transition: all 0.2s;
    }
    .gallery-item:hover {
        border-color: #dc2626;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
    }
    .gallery-item img {
        transition: transform 0.2s;
    }
    .gallery-item:hover img {
        transform: scale(1.05);
    }
    .gallery-item .delete-btn {
        position: absolute;
        top: 4px;
        right: 4px;
        background: rgba(220, 38, 38, 0.95);
        color: white;
        border-radius: 0.375rem;
        padding: 4px;
        cursor: pointer;
        opacity: 0;
        transition: all 0.2s;
    }
    .gallery-item:hover .delete-btn {
        opacity: 1;
    }
    .gallery-item .delete-btn:hover {
        background: #b91c1c;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')

<!-- Page Header - Compact -->
<div class="mb-4 bg-white border-b border-gray-200">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Yeni Araç Ekle</h1>
                <p class="text-xs text-gray-500">Detaylı araç bilgilerini girin</p>
            </div>
        </div>
        <a href="{{ route('admin.vehicles.index') }}" class="flex items-center space-x-2 px-4 py-2 text-gray-600 hover:text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Geri</span>
        </a>
    </div>
</div>

<!-- Error Messages -->
@if($errors->any())
    <div class="mb-4 mx-6 bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
        <div class="flex items-start">
            <svg class="w-4 h-4 text-red-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1">
                <h3 class="text-red-800 font-bold text-xs mb-1">Lütfen hataları düzeltin:</h3>
                <ul class="list-disc list-inside text-red-700 text-xs space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data" id="vehicleForm">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 px-6">
        <!-- Main Content (3 columns) -->
        <div class="lg:col-span-3">
            <!-- Tabs Navigation -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4">
                <div class="flex border-b border-gray-200 overflow-x-auto">
                    <div class="tab-item active" data-tab="genel">
                        <span>Araç Bilgileri</span>
                    </div>
                    <div class="tab-item" data-tab="donanim">
                        <span>Donanımlar</span>
                    </div>
                    <div class="tab-item" data-tab="hasar">
                        <span>Hasar & Geçmiş</span>
                    </div>
                    <div class="tab-item" data-tab="medya">
                        <span>Medya</span>
                    </div>
                    <div class="tab-item" data-tab="diger">
                        <span>Diğer</span>
                    </div>
                </div>
                
                <!-- Tab Contents -->
                <div class="p-6">
                    
                    <!-- GENEL TAB -->
                    <div class="tab-content active" id="tab-genel">
                        <div class="space-y-4">
                            <!-- İlan Başlığı -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    İlan Başlığı <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" value="{{ old('title') }}" required 
                                       placeholder="Örn: Volkswagen Passat 1.6 TDI BlueMotion Comfortline"
                                       class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                            </div>
                            
                            <!-- Marka & Yıl (Önce bunlar seçilmeli) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Marka <span class="text-red-500">*</span>
                                    </label>
                                    <select name="brand" id="brandSelect" required class="w-full">
                                        <option value="">Marka Seçiniz</option>
                                    </select>
                                    <label class="inline-flex items-center mt-1.5 text-xs text-gray-600 cursor-pointer">
                                        <input type="checkbox" id="manualBrandToggle" class="w-3 h-3 text-primary-600 border-gray-300 rounded mr-1.5">
                                        <span>Manuel Gir</span>
                                    </label>
                                    <input type="text" id="manualBrandInput" name="brand_manual" class="hidden form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all mt-1.5" placeholder="Marka adı yazınız">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Model Yılı <span class="text-red-500">*</span>
                                    </label>
                                    <select name="year" id="yearSelect" required class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all" disabled>
                                        <option value="">Önce marka seçiniz</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Model & Gövde Tipi (Cascade) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Model <span class="text-red-500">*</span>
                                    </label>
                                    <select name="model" id="modelSelect" required class="w-full" disabled>
                                        <option value="">Önce yıl seçiniz</option>
                                    </select>
                                    <label class="inline-flex items-center mt-1.5 text-xs text-gray-600 cursor-pointer">
                                        <input type="checkbox" id="manualModelToggle" class="w-3 h-3 text-primary-600 border-gray-300 rounded mr-1.5">
                                        <span>Manuel Gir</span>
                                    </label>
                                    <input type="text" id="manualModelInput" name="model_manual" class="hidden form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all mt-1.5" placeholder="Model adı yazınız">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Gövde Tipi (Kasa)
                                    </label>
                                    <select name="body_type" id="bodyTypeSelect" class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all" disabled>
                                        <option value="">Önce model seçiniz</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Yakıt & Vites (Cascade) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Yakıt Tipi
                                    </label>
                                    <select name="fuel_type" id="fuelTypeSelect" class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all" disabled>
                                        <option value="">Önce gövde tipi seçiniz</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Vites Tipi
                                    </label>
                                    <select name="transmission" id="transmissionSelect" class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all" disabled>
                                        <option value="">Önce yakıt tipi seçiniz</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Versiyon & Renk (Cascade) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Paket / Versiyon
                                    </label>
                                    <select name="package_version" id="versionSelect" class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all" disabled>
                                        <option value="">Önce vites tipi seçiniz</option>
                                    </select>
                                    <label class="inline-flex items-center mt-1.5 text-xs text-gray-600 cursor-pointer">
                                        <input type="checkbox" id="manualVersionToggle" class="w-3 h-3 text-primary-600 border-gray-300 rounded mr-1.5">
                                        <span>Manuel Gir</span>
                                    </label>
                                    <input type="text" id="manualVersionInput" name="package_version_manual" class="hidden form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all mt-1.5" placeholder="Versiyon yazınız">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Renk
                                    </label>
                                    <select name="color" id="colorSelect" class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all" disabled>
                                        <option value="">Önce versiyon seçiniz</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- KM & Fiyat -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Kilometre <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="kilometer" value="{{ old('kilometer', 0) }}" required 
                                           placeholder="0"
                                           class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">
                                        Fiyat (₺) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="price" value="{{ old('price') }}" required 
                                           placeholder="0"
                                           class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all font-bold text-primary-600">
                                </div>
                            </div>
                            
                            <!-- Motor & Teknik Özellikler -->
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Motor Özellikleri
                                </h3>
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Motor Hacmi (cc)</label>
                                        <input type="number" name="engine_size" value="{{ old('engine_size') }}" 
                                               placeholder="1600"
                                               class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Motor Gücü (HP)</label>
                                        <input type="number" name="horse_power" value="{{ old('horse_power') }}" 
                                               placeholder="120"
                                               class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tork (Nm)</label>
                                        <input type="number" name="torque" value="{{ old('torque') }}" 
                                               placeholder="250"
                                               class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Diğer Teknik Özellikler -->
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Ek Özellikler
                                </h3>
                                <div class="grid grid-cols-4 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Çekiş</label>
                                        <select name="drive_type" class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                            <option value="">Seçiniz</option>
                                            <option value="Önden Çekiş">Önden Çekiş</option>
                                            <option value="Arkadan İtiş">Arkadan İtiş</option>
                                            <option value="4x4">4x4 (AWD)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Kapı Sayısı</label>
                                        <select name="door_count" class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                            <option value="">Seçiniz</option>
                                            <option value="2">2 Kapı</option>
                                            <option value="3">3 Kapı</option>
                                            <option value="4">4 Kapı</option>
                                            <option value="5">5 Kapı</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Koltuk Sayısı</label>
                                        <select name="seat_count" class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                            <option value="">Seçiniz</option>
                                            <option value="2">2 Koltuk</option>
                                            <option value="4">4 Koltuk</option>
                                            <option value="5">5 Koltuk</option>
                                            <option value="7">7 Koltuk</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Renk Tipi</label>
                                        <select name="color_type" class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                            <option value="">Seçiniz</option>
                                            <option value="Metalik">Metalik</option>
                                            <option value="Mat">Mat</option>
                                            <option value="İnci">İnci</option>
                                            <option value="Normal">Normal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Açıklama -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Açıklama</label>
                                <textarea name="description" rows="5" 
                                          placeholder="Aracınız hakkında detaylı bilgi verin..."
                                          class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all resize-none">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- DONANIM TAB -->
                    <div class="tab-content" id="tab-donanim">
                        <!-- Arama -->
                        <div class="mb-4">
                            <input type="text" id="featureSearch" placeholder="Donanım ara..." 
                                   class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                        </div>
                        
                        @php
                            $allFeatures = \App\Data\VehicleFeatures::all();
                        @endphp
                        
                        <div class="space-y-2">
                            @foreach($allFeatures as $category => $features)
                                <div class="border border-gray-200 rounded-lg">
                                    <div class="accordion-header flex items-center justify-between p-3 bg-gray-50" onclick="toggleAccordion(this)">
                                        <span class="text-xs font-bold text-gray-700">{{ $category }}</span>
                                        <svg class="w-4 h-4 text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                    <div class="accordion-content p-3">
                                        <div class="grid grid-cols-2 gap-1.5">
                                            @foreach($features as $feature)
                                                <label class="feature-item flex items-center space-x-1.5 p-2 border border-gray-200 rounded hover:bg-gray-50 cursor-pointer transition-all text-xs">
                                                    <input type="checkbox" name="features[]" value="{{ $feature }}" 
                                                           class="w-3.5 h-3.5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                                    <span class="text-gray-700">{{ $feature }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- HASAR & GEÇMİŞ TAB -->
                    <div class="tab-content" id="tab-hasar">
                        <div class="space-y-4">
                            <!-- Tramer, Sahip, Muayene -->
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tramer</label>
                                    <select name="tramer_status" class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                        <option value="">Seçiniz</option>
                                        <option value="Yok">Yok (Temiz)</option>
                                        <option value="Var">Var</option>
                                        <option value="Bilinmiyor">Bilinmiyor</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Tramer Tutarı (₺)</label>
                                    <input type="number" name="tramer_amount" value="{{ old('tramer_amount') }}" 
                                           placeholder="0" step="0.01"
                                           class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Kaçıncı Sahip</label>
                                    <input type="number" name="owner_number" value="{{ old('owner_number') }}" 
                                           placeholder="1" min="1"
                                           class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                </div>
                            </div>
                            
                            <!-- Muayene & Garanti -->
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Muayene Tarihi</label>
                                    <input type="date" name="inspection_date" value="{{ old('inspection_date') }}" 
                                           class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Garanti Bitiş Tarihi</label>
                                    <input type="date" name="warranty_end_date" value="{{ old('warranty_end_date') }}" 
                                           class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                </div>
                            </div>
                            
                            <!-- Boyalı/Değişen Parçalar (Accordion) -->
                            @php
                                $parts = ['Kaput', 'Ön Tampon', 'Arka Tampon', 'Sağ Ön', 'Sol Ön', 'Sağ Arka', 'Sol Arka', 'Tavan'];
                            @endphp
                            
                            <div class="border border-gray-200 rounded-lg">
                                <div class="accordion-header flex items-center justify-between p-3 bg-gray-50" onclick="toggleAccordion(this)">
                                    <span class="text-xs font-bold text-gray-700">Boyalı Parçalar</span>
                                    <svg class="w-4 h-4 text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <div class="accordion-content p-3">
                                    <div class="grid grid-cols-4 gap-1.5">
                                        @foreach($parts as $part)
                                            <label class="flex items-center space-x-1.5 p-2 border border-gray-200 rounded hover:bg-gray-50 cursor-pointer transition-all text-xs">
                                                <input type="checkbox" name="painted_parts[]" value="{{ $part }}" 
                                                       class="w-3.5 h-3.5 text-primary-600 border-gray-300 rounded">
                                                <span class="text-gray-700">{{ $part }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border border-gray-200 rounded-lg">
                                <div class="accordion-header flex items-center justify-between p-3 bg-gray-50" onclick="toggleAccordion(this)">
                                    <span class="text-xs font-bold text-gray-700">Değişen Parçalar</span>
                                    <svg class="w-4 h-4 text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <div class="accordion-content p-3">
                                    <div class="grid grid-cols-4 gap-1.5">
                                        @foreach($parts as $part)
                                            <label class="flex items-center space-x-1.5 p-2 border border-gray-200 rounded hover:bg-gray-50 cursor-pointer transition-all text-xs">
                                                <input type="checkbox" name="replaced_parts[]" value="{{ $part }}" 
                                                       class="w-3.5 h-3.5 text-primary-600 border-gray-300 rounded">
                                                <span class="text-gray-700">{{ $part }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- MEDYA TAB -->
                    <div class="tab-content" id="tab-medya">
                        <div class="space-y-4">
                            <!-- Ana Görsel -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-2">
                                    Ana Görsel <span class="text-red-500">*</span>
                                </label>
                                <input type="file" name="main_image" id="mainImageInput" accept="image/*" required class="hidden">
                                <label for="mainImageInput" class="block border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-500 hover:bg-primary-50 transition-all cursor-pointer group">
                                    <svg class="w-10 h-10 mx-auto text-gray-400 group-hover:text-primary-500 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-xs font-medium text-gray-700 group-hover:text-primary-600 mb-0.5">Tıklayın veya sürükleyin</p>
                                    <p class="text-xs text-gray-500">PNG, JPG (Maks. 5MB)</p>
                                </label>
                                <div id="mainPreview" class="mt-3 hidden">
                                    <div class="relative rounded-lg overflow-hidden border-2 border-primary-500">
                                        <img id="mainPreviewImg" src="" alt="Ana Görsel" class="w-full h-40 object-cover">
                                        <button type="button" onclick="removeMainImage()" class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded p-1.5 shadow-lg transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Galeri -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label class="text-xs font-semibold text-gray-700">Galeri Görselleri</label>
                                    <span class="text-xs text-gray-500" id="galleryCount">0/15</span>
                                </div>
                                <input type="file" id="singleImageInput" accept="image/*" class="hidden">
                                <button type="button" onclick="document.getElementById('singleImageInput').click()" class="w-full border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-primary-500 hover:bg-primary-50 transition-all group">
                                    <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-primary-500 mb-1.5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <p class="text-xs font-medium text-gray-700 group-hover:text-primary-600">Görsel Ekle</p>
                                </button>
                                <div id="galleryPreview" class="grid grid-cols-3 gap-2 mt-3"></div>
                                <input type="file" name="images[]" id="galleryInput" multiple class="hidden">
                            </div>
                        </div>
                    </div>
                    
                    <!-- DİĞER TAB -->
                    <div class="tab-content" id="tab-diger">
                        <div class="space-y-4">
                            <!-- Sahibinden.com -->
                            <div class="border border-gray-200 rounded-lg">
                                <div class="accordion-header flex items-center justify-between p-3 bg-gray-50" onclick="toggleAccordion(this)">
                                    <span class="text-xs font-bold text-gray-700">Sahibinden.com Entegrasyonu</span>
                                    <svg class="w-4 h-4 text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <div class="accordion-content p-3">
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">İlan Linki</label>
                                            <input type="url" name="sahibinden_url" value="{{ old('sahibinden_url') }}" 
                                                   placeholder="https://www.sahibinden.com/..."
                                                   class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">İlan No</label>
                                            <input type="text" name="sahibinden_id" value="{{ old('sahibinden_id') }}" 
                                                   placeholder="123456789"
                                                   class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg transition-all">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <!-- Sidebar (1 column) - Sticky -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-4">
                <!-- Yayın Durumu -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-4 py-3">
                        <h3 class="text-sm font-bold text-gray-900">Yayın Durumu</h3>
                    </div>
                    <div class="p-4 space-y-2">
                        <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-primary-500 hover:bg-primary-50 cursor-pointer transition-all">
                            <input type="checkbox" name="is_active" value="1" checked 
                                   class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 text-xs">Aktif</p>
                                <p class="text-xs text-gray-500">Web sitesinde yayında</p>
                            </div>
                        </label>
                        
                        <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:border-primary-500 hover:bg-primary-50 cursor-pointer transition-all">
                            <input type="checkbox" name="is_featured" value="1" 
                                   class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 text-xs">Öne Çıkarılmış</p>
                                <p class="text-xs text-gray-500">Anasayfada gösterilsin</p>
                            </div>
                        </label>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 space-y-2">
                    <input type="hidden" name="action" id="formAction" value="publish">
                    
                    <button type="submit" data-action="publish" class="submit-btn w-full px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-lg shadow-md transition-all text-sm flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Kaydet ve Yayınla
                    </button>
                    
                    <button type="submit" data-action="draft" class="submit-btn w-full px-4 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all text-sm flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
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
$(document).ready(function() {
    // Tab Switching
    $('.tab-item').on('click', function() {
        const tabId = $(this).data('tab');
        
        $('.tab-item').removeClass('active');
        $(this).addClass('active');
        
        $('.tab-content').removeClass('active');
        $('#tab-' + tabId).addClass('active');
    });
    
    // Accordion Toggle
    window.toggleAccordion = function(header) {
        const content = $(header).next('.accordion-content');
        const icon = $(header).find('svg');
        
        content.toggleClass('active');
        icon.toggleClass('rotate-180');
    };
    
    // Select2 Init
    $('#brandSelect, #modelSelect').select2({
        placeholder: 'Seçiniz',
        allowClear: true,
        tags: true,
        width: '100%'
    });
    
    // ============================================================
    // CASCADE SYSTEM - Web sitesindeki gibi basamaklı yükleme
    // ============================================================
    
    let cascadeData = {
        brandId: null,
        year: null,
        modelId: null,
        bodyTypeId: null,
        fuelTypeId: null,
        transmissionId: null,
        versionId: null
    };
    
    // Load Brands (API + Fallback)
    loadBrands();
    
    function loadBrands() {
        const staticBrands = @json(\App\Data\CarBrands::all());
        
        $.ajax({
            url: '/api/arabam/brands',
            method: 'GET',
            timeout: 5000,
            success: function(response) {
                if (response.success && response.data && response.data.Items) {
                    $('#brandSelect').empty().append('<option value="">Marka Seçiniz</option>');
                    response.data.Items.forEach(function(brand) {
                        $('#brandSelect').append($('<option></option>').attr('value', brand.Name).attr('data-id', brand.Id).text(brand.Name));
                    });
                    console.log('✅ Markalar API\'den yüklendi:', response.data.Items.length);
                } else {
                    loadStaticBrands();
                }
            },
            error: function() {
                console.warn('⚠️ API başarısız, statik markalar yükleniyor');
                loadStaticBrands();
            }
        });
        
        function loadStaticBrands() {
            $('#brandSelect').empty().append('<option value="">Marka Seçiniz</option>');
            staticBrands.forEach(function(brand, index) {
                $('#brandSelect').append($('<option></option>').attr('value', brand).attr('data-id', index + 1).text(brand));
            });
        }
    }
    
    // Load Years (after brand selection)
    function loadYears(brandId) {
        const currentYear = new Date().getFullYear();
        const years = [];
        for (let y = currentYear + 1; y >= 1990; y--) {
            years.push(y);
        }
        
        $('#yearSelect').empty().append('<option value="">Yıl Seçiniz</option>');
        years.forEach(function(year) {
            $('#yearSelect').append($('<option></option>').attr('value', year).text(year));
        });
        
        $('#yearSelect').prop('disabled', false);
        console.log('✅ Yıllar yüklendi');
    }
    
    // ============================================================
    // CASCADE EVENT LISTENERS (Web sitesindeki gibi)
    // ============================================================
    
    // 1. MARKA SEÇİMİ → YIL DROPDOWN AKTİF
    $('#brandSelect').on('change', function() {
        cascadeData.brandId = $(this).find(':selected').data('id');
        const brandName = $(this).val();
        
        console.log('🔍 [1/7] Marka seçildi:', { brandId: cascadeData.brandId, brandName });
        
        // Reset sonraki alanlar
        resetCascadeFrom('year');
        
        if (cascadeData.brandId) {
            loadYears(cascadeData.brandId);
        }
    });
    
    // 2. YIL SEÇİMİ → MODEL YÜKLE
    $('#yearSelect').on('change', function() {
        cascadeData.year = $(this).val();
        
        console.log('🔍 [2/7] Yıl seçildi:', cascadeData.year);
        
        // Reset sonraki alanlar
        resetCascadeFrom('model');
        
        if (cascadeData.year && cascadeData.brandId) {
            loadModels(cascadeData.brandId, cascadeData.year);
        }
    });
    
    // 3. MODEL SEÇİMİ → GÖVDE TİPİ YÜKLE
    $('#modelSelect').on('change', function() {
        cascadeData.modelId = $(this).find(':selected').data('id');
        const modelName = $(this).val();
        
        console.log('🔍 [3/7] Model seçildi:', { modelId: cascadeData.modelId, modelName });
        
        // Reset sonraki alanlar
        resetCascadeFrom('bodyType');
        
        if (cascadeData.modelId) {
            loadBodyTypes(cascadeData.brandId, cascadeData.year, cascadeData.modelId);
        }
    });
    
    // 4. GÖVDE TİPİ SEÇİMİ → YAKIT TİPİ YÜKLE
    $('#bodyTypeSelect').on('change', function() {
        cascadeData.bodyTypeId = $(this).find(':selected').data('id');
        const bodyTypeName = $(this).val();
        
        console.log('🔍 [4/7] Gövde tipi seçildi:', { bodyTypeId: cascadeData.bodyTypeId, bodyTypeName });
        
        // Reset sonraki alanlar
        resetCascadeFrom('fuelType');
        
        if (cascadeData.bodyTypeId) {
            loadFuelTypes(cascadeData.brandId, cascadeData.year, cascadeData.modelId, cascadeData.bodyTypeId);
        }
    });
    
    // 5. YAKIT TİPİ SEÇİMİ → VİTES TİPİ YÜKLE
    $('#fuelTypeSelect').on('change', function() {
        cascadeData.fuelTypeId = $(this).find(':selected').data('id');
        const fuelTypeName = $(this).val();
        
        console.log('🔍 [5/7] Yakıt tipi seçildi:', { fuelTypeId: cascadeData.fuelTypeId, fuelTypeName });
        
        // Reset sonraki alanlar
        resetCascadeFrom('transmission');
        
        if (cascadeData.fuelTypeId) {
            loadTransmissions(cascadeData.brandId, cascadeData.year, cascadeData.modelId, cascadeData.bodyTypeId, cascadeData.fuelTypeId);
        }
    });
    
    // 6. VİTES TİPİ SEÇİMİ → VERSİYON YÜKLE
    $('#transmissionSelect').on('change', function() {
        cascadeData.transmissionId = $(this).find(':selected').data('id');
        const transmissionName = $(this).val();
        
        console.log('🔍 [6/7] Vites tipi seçildi:', { transmissionId: cascadeData.transmissionId, transmissionName });
        
        // Reset sonraki alanlar
        resetCascadeFrom('version');
        
        if (cascadeData.transmissionId) {
            loadVersions(cascadeData.brandId, cascadeData.year, cascadeData.modelId, cascadeData.bodyTypeId, cascadeData.fuelTypeId, cascadeData.transmissionId);
        }
    });
    
    // 7. VERSİYON SEÇİMİ → RENK YÜKLE (Opsiyonel)
    $('#versionSelect').on('change', function() {
        cascadeData.versionId = $(this).find(':selected').data('id');
        const versionName = $(this).val();
        
        console.log('🔍 [7/7] Versiyon seçildi:', { versionId: cascadeData.versionId, versionName });
        
        if (cascadeData.versionId) {
            loadColors(cascadeData.brandId, cascadeData.year, cascadeData.modelId, cascadeData.bodyTypeId, cascadeData.fuelTypeId, cascadeData.transmissionId, cascadeData.versionId);
        }
    });
    
    // Reset cascade from a specific point
    function resetCascadeFrom(step) {
        const steps = ['year', 'model', 'bodyType', 'fuelType', 'transmission', 'version', 'color'];
        const startIndex = steps.indexOf(step);
        
        for (let i = startIndex; i < steps.length; i++) {
            const stepName = steps[i];
            
            switch(stepName) {
                case 'year':
                    $('#yearSelect').prop('disabled', true).empty().append('<option value="">Önce marka seçiniz</option>');
                    cascadeData.year = null;
                    break;
                case 'model':
                    $('#modelSelect').prop('disabled', true).empty().append('<option value="">Önce yıl seçiniz</option>');
                    cascadeData.modelId = null;
                    break;
                case 'bodyType':
                    $('#bodyTypeSelect').prop('disabled', true).empty().append('<option value="">Önce model seçiniz</option>');
                    cascadeData.bodyTypeId = null;
                    break;
                case 'fuelType':
                    $('#fuelTypeSelect').prop('disabled', true).empty().append('<option value="">Önce gövde tipi seçiniz</option>');
                    cascadeData.fuelTypeId = null;
                    break;
                case 'transmission':
                    $('#transmissionSelect').prop('disabled', true).empty().append('<option value="">Önce yakıt tipi seçiniz</option>');
                    cascadeData.transmissionId = null;
                    break;
                case 'version':
                    $('#versionSelect').prop('disabled', true).empty().append('<option value="">Önce vites tipi seçiniz</option>');
                    cascadeData.versionId = null;
                    break;
                case 'color':
                    $('#colorSelect').prop('disabled', true).empty().append('<option value="">Önce versiyon seçiniz</option>');
                    break;
            }
        }
    }
    
    // ============================================================
    // CASCADE LOAD FUNCTIONS (Web sitesindeki gibi API çağrıları)
    // ============================================================
    
    // Load Models (step 20)
    function loadModels(brandId, year) {
        $('#modelSelect').prop('disabled', false).empty().append('<option value="">Yükleniyor...</option>');
        
        $.ajax({
            url: '/api/arabam/step',
            method: 'GET',
            data: { step: '20', brandId: brandId, modelYear: year },
            success: function(response) {
                if (response.success && response.data && response.data.Items) {
                    populateSelect('#modelSelect', response.data.Items, 'Model Seçiniz');
                    console.log(`✅ ${response.data.Items.length} model yüklendi`);
                    
                    // Auto-select if only 1 option
                    if (response.data.Items.length === 1) {
                        $('#modelSelect').val(response.data.Items[0].Name).trigger('change');
                    }
                } else {
                    $('#modelSelect').empty().append('<option value="">Model bulunamadı</option>');
                }
            },
            error: function() {
                $('#modelSelect').empty().append('<option value="">Hata oluştu</option>');
            }
        });
    }
    
    // Load Body Types (step 30)
    function loadBodyTypes(brandId, year, modelId) {
        $('#bodyTypeSelect').prop('disabled', false).empty().append('<option value="">Yükleniyor...</option>');
        
        $.ajax({
            url: '/api/arabam/step',
            method: 'GET',
            data: { step: '30', brandId: brandId, modelYear: year, modelGroupId: modelId },
            success: function(response) {
                if (response.success && response.data && response.data.Items) {
                    populateSelect('#bodyTypeSelect', response.data.Items, 'Gövde Tipi Seçiniz');
                    console.log(`✅ ${response.data.Items.length} gövde tipi yüklendi`);
                    
                    if (response.data.Items.length === 1) {
                        $('#bodyTypeSelect').val(response.data.Items[0].Name).trigger('change');
                    }
                } else {
                    $('#bodyTypeSelect').empty().append('<option value="">Gövde tipi bulunamadı</option>');
                }
            },
            error: function() {
                $('#bodyTypeSelect').empty().append('<option value="">Hata oluştu</option>');
            }
        });
    }
    
    // Load Fuel Types (step 40)
    function loadFuelTypes(brandId, year, modelId, bodyTypeId) {
        $('#fuelTypeSelect').prop('disabled', false).empty().append('<option value="">Yükleniyor...</option>');
        
        $.ajax({
            url: '/api/arabam/step',
            method: 'GET',
            data: { step: '40', brandId: brandId, modelYear: year, modelGroupId: modelId, bodyTypeId: bodyTypeId },
            success: function(response) {
                if (response.success && response.data && response.data.Items) {
                    populateSelect('#fuelTypeSelect', response.data.Items, 'Yakıt Tipi Seçiniz');
                    console.log(`✅ ${response.data.Items.length} yakıt tipi yüklendi`);
                    
                    if (response.data.Items.length === 1) {
                        $('#fuelTypeSelect').val(response.data.Items[0].Name).trigger('change');
                    }
                } else {
                    $('#fuelTypeSelect').empty().append('<option value="">Yakıt tipi bulunamadı</option>');
                }
            },
            error: function() {
                $('#fuelTypeSelect').empty().append('<option value="">Hata oluştu</option>');
            }
        });
    }
    
    // Load Transmissions (step 50)
    function loadTransmissions(brandId, year, modelId, bodyTypeId, fuelTypeId) {
        $('#transmissionSelect').prop('disabled', false).empty().append('<option value="">Yükleniyor...</option>');
        
        $.ajax({
            url: '/api/arabam/step',
            method: 'GET',
            data: { step: '50', brandId: brandId, modelYear: year, modelGroupId: modelId, bodyTypeId: bodyTypeId, fuelTypeId: fuelTypeId },
            success: function(response) {
                if (response.success && response.data && response.data.Items) {
                    populateSelect('#transmissionSelect', response.data.Items, 'Vites Tipi Seçiniz');
                    console.log(`✅ ${response.data.Items.length} vites tipi yüklendi`);
                    
                    if (response.data.Items.length === 1) {
                        $('#transmissionSelect').val(response.data.Items[0].Name).trigger('change');
                    }
                } else {
                    $('#transmissionSelect').empty().append('<option value="">Vites tipi bulunamadı</option>');
                }
            },
            error: function() {
                $('#transmissionSelect').empty().append('<option value="">Hata oluştu</option>');
            }
        });
    }
    
    // Load Versions (step 60)
    function loadVersions(brandId, year, modelId, bodyTypeId, fuelTypeId, transmissionId) {
        $('#versionSelect').prop('disabled', false).empty().append('<option value="">Yükleniyor...</option>');
        
        $.ajax({
            url: '/api/arabam/step',
            method: 'GET',
            data: { step: '60', brandId: brandId, modelYear: year, modelGroupId: modelId, bodyTypeId: bodyTypeId, fuelTypeId: fuelTypeId, transmissionTypeId: transmissionId },
            success: function(response) {
                if (response.success && response.data && response.data.Items) {
                    populateSelect('#versionSelect', response.data.Items, 'Versiyon Seçiniz');
                    console.log(`✅ ${response.data.Items.length} versiyon yüklendi`);
                    
                    if (response.data.Items.length === 1) {
                        $('#versionSelect').val(response.data.Items[0].Name).trigger('change');
                    }
                } else {
                    $('#versionSelect').empty().append('<option value="">Versiyon bulunamadı</option>');
                }
            },
            error: function() {
                $('#versionSelect').empty().append('<option value="">Hata oluştu</option>');
            }
        });
    }
    
    // Load Colors (step 70) - Opsiyonel
    function loadColors(brandId, year, modelId, bodyTypeId, fuelTypeId, transmissionId, versionId) {
        $('#colorSelect').prop('disabled', false).empty().append('<option value="">Yükleniyor...</option>');
        
        $.ajax({
            url: '/api/arabam/step',
            method: 'GET',
            data: { step: '70', brandId: brandId, modelYear: year, modelGroupId: modelId, bodyTypeId: bodyTypeId, fuelTypeId: fuelTypeId, transmissionTypeId: transmissionId, modelId: versionId },
            success: function(response) {
                if (response.success && response.data && response.data.Items) {
                    populateSelect('#colorSelect', response.data.Items, 'Renk Seçiniz');
                    console.log(`✅ ${response.data.Items.length} renk yüklendi`);
                    
                    if (response.data.Items.length === 1) {
                        $('#colorSelect').val(response.data.Items[0].Name);
                    }
                } else {
                    $('#colorSelect').empty().append('<option value="">Renk bulunamadı</option>');
                }
            },
            error: function() {
                $('#colorSelect').empty().append('<option value="">Hata oluştu</option>');
            }
        });
    }
    
    // Helper: Populate select with items
    function populateSelect(selector, items, placeholder) {
        $(selector).empty().append(`<option value="">${placeholder}</option>`);
        items.forEach(function(item) {
            $(selector).append(
                $('<option></option>')
                    .attr('value', item.Name)
                    .attr('data-id', item.Id)
                    .text(item.Name)
            );
        });
    }
    
    // ============================================================
    // MANUEL GİRİŞ TOGGLE (Checkbox)
    // ============================================================
    
    $('#manualBrandToggle').on('change', function() {
        if ($(this).is(':checked')) {
            $('#brandSelect').hide().prop('disabled', true);
            $('#manualBrandInput').show().removeClass('hidden').prop('disabled', false);
        } else {
            $('#brandSelect').show().prop('disabled', false);
            $('#manualBrandInput').hide().addClass('hidden').prop('disabled', true).val('');
        }
    });
    
    $('#manualModelToggle').on('change', function() {
        if ($(this).is(':checked')) {
            $('#modelSelect').hide().prop('disabled', true);
            $('#manualModelInput').show().removeClass('hidden').prop('disabled', false);
        } else {
            $('#modelSelect').show().prop('disabled', false);
            $('#manualModelInput').hide().addClass('hidden').prop('disabled', true).val('');
        }
    });
    
    $('#manualVersionToggle').on('change', function() {
        if ($(this).is(':checked')) {
            $('#versionSelect').hide().prop('disabled', true);
            $('#manualVersionInput').show().removeClass('hidden').prop('disabled', false);
        } else {
            $('#versionSelect').show().prop('disabled', false);
            $('#manualVersionInput').hide().addClass('hidden').prop('disabled', true).val('');
        }
    });
    
    // Feature Search
    $('#featureSearch').on('keyup', function() {
        const searchText = $(this).val().toLowerCase();
        $('.feature-item').each(function() {
            const text = $(this).text().toLowerCase();
            $(this).toggle(text.indexOf(searchText) > -1);
        });
    });
    
    // Main Image Preview
    $('#mainImageInput').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $('#mainPreviewImg').attr('src', event.target.result);
                $('#mainPreview').removeClass('hidden');
            }
            reader.readAsDataURL(file);
        }
    });
    
    window.removeMainImage = function() {
        $('#mainImageInput').val('');
        $('#mainPreview').addClass('hidden');
    }
    
    // Gallery Management
    let galleryFiles = [];
    const MAX_GALLERY_IMAGES = 15;
    
    $('#singleImageInput').on('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        if (galleryFiles.length >= MAX_GALLERY_IMAGES) {
            alert(`Maksimum ${MAX_GALLERY_IMAGES} görsel yükleyebilirsiniz.`);
            $(this).val('');
            return;
        }
        
        if (file.size > 5 * 1024 * 1024) {
            alert('Görsel boyutu 5MB\'dan küçük olmalıdır.');
            $(this).val('');
            return;
        }
        
        galleryFiles.push(file);
        $(this).val('');
        renderGallery();
    });
    
    function renderGallery() {
        $('#galleryPreview').empty();
        $('#galleryCount').text(`${galleryFiles.length}/${MAX_GALLERY_IMAGES}`);
        
        if (galleryFiles.length === 0) return;
        
        galleryFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const itemHtml = `
                    <div class="gallery-item" data-index="${index}">
                        <img src="${e.target.result}" class="w-full h-24 object-cover">
                        <button type="button" onclick="removeGalleryItem(${index})" class="delete-btn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <div class="absolute bottom-1 left-1 bg-black/70 text-white text-xs font-bold px-1.5 py-0.5 rounded">${index + 1}</div>
                    </div>
                `;
                $('#galleryPreview').append(itemHtml);
            };
            reader.readAsDataURL(file);
        });
        
        setTimeout(() => {
            if (galleryFiles.length > 1) {
                new Sortable(document.getElementById('galleryPreview'), {
                    animation: 200,
                    onEnd: function(evt) {
                        const movedItem = galleryFiles.splice(evt.oldIndex, 1)[0];
                        galleryFiles.splice(evt.newIndex, 0, movedItem);
                        renderGallery();
                    }
                });
            }
        }, 100);
    }
    
    window.removeGalleryItem = function(index) {
        if (confirm('Bu görseli silmek istediğinize emin misiniz?')) {
            galleryFiles.splice(index, 1);
            renderGallery();
        }
    }
    
    // Button Click Handler
    $('.submit-btn').on('click', function(e) {
        const action = $(this).data('action');
        $('#formAction').val(action);
        console.log('✅ Form action set:', action);
    });
    
    // Form Submit
    $('#vehicleForm').on('submit', function(e) {
        // Gallery images
        const dt = new DataTransfer();
        galleryFiles.forEach(file => dt.items.add(file));
        document.getElementById('galleryInput').files = dt.files;
        
        // Manuel girişleri handle et
        if ($('#manualBrandToggle').is(':checked')) {
            const manualBrand = $('#manualBrandInput').val();
            $('#brandSelect').append($('<option></option>').attr('value', manualBrand).attr('selected', true).text(manualBrand));
        }
        
        if ($('#manualModelToggle').is(':checked')) {
            const manualModel = $('#manualModelInput').val();
            $('#modelSelect').append($('<option></option>').attr('value', manualModel).attr('selected', true).text(manualModel));
        }
        
        if ($('#manualVersionToggle').is(':checked')) {
            const manualVersion = $('#manualVersionInput').val();
            $('#versionSelect').append($('<option></option>').attr('value', manualVersion).attr('selected', true).text(manualVersion));
        }
        
        const action = $('#formAction').val();
        console.log('📤 Form submit action:', action);
        
        if (action === 'publish') {
            const requiredFields = [
                { name: 'title', label: 'Başlık' },
                { selector: '#brandSelect, #manualBrandInput', label: 'Marka' },
                { selector: '#modelSelect, #manualModelInput', label: 'Model' },
                { name: 'year', label: 'Yıl' },
                { name: 'kilometer', label: 'Kilometre' },
                { name: 'price', label: 'Fiyat' },
            ];
            
            let missing = [];
            requiredFields.forEach(field => {
                let value = '';
                if (field.selector) {
                    value = $(field.selector).filter(':visible').val();
                } else {
                    value = $(`[name="${field.name}"]`).val();
                }
                
                if (!value || value.trim() === '') {
                    missing.push(field.label);
                }
            });
            
            if (!$('#mainImageInput')[0].files.length) {
                missing.push('Ana Görsel');
            }
            
            if (missing.length > 0) {
                e.preventDefault();
                alert('❌ Yayınlamak için şu alanları doldurun:\n\n• ' + missing.join('\n• '));
                return false;
            }
        }
        
        // Set is_active based on action
        if (action === 'draft') {
            $('[name="is_active"]').prop('checked', false);
        } else if (action === 'publish') {
            $('[name="is_active"]').prop('checked', true);
        }
    });
});
</script>
@endpush
@endsection
