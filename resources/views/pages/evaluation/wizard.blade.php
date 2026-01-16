@extends('layouts.app')

@section('title', 'Aracımı Değerle - GMSGARAGE')
@section('description', 'Aracınızın değerini öğrenin. Hızlı ve güvenilir araç değerleme hizmeti.')

@push('styles')
<style>
    .wizard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    
    .wizard-step {
        display: none;
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .wizard-step.active {
        display: block;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    
    .form-group select,
    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="email"],
    .form-group input[type="tel"] {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
    }
    
    .form-group select:focus,
    .form-group input:focus {
        outline: none;
        border-color: #dc2626;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .wizard-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }
    
    .btn-wizard {
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }
    
    .btn-wizard-primary {
        background: #dc2626;
        color: white;
    }
    
    .btn-wizard-primary:hover {
        background: #b91c1c;
    }
    
    .btn-wizard-secondary {
        background: #f3f4f6;
        color: #374151;
    }
    
    .btn-wizard-secondary:hover {
        background: #e5e7eb;
    }
    
    .btn-wizard:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .inspection-table-container {
        overflow-x: auto;
        margin-bottom: 2rem;
    }
    
    .inspection-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
        font-size: 0.875rem;
    }
    
    .inspection-table th,
    .inspection-table td {
        padding: 0.5rem;
        border: 1px solid #e5e7eb;
        text-align: center;
    }
    
    .inspection-table th {
        background: #f9fafb;
        font-weight: 600;
    }
    
    .inspection-table tbody tr:hover {
        background: #f9fafb;
    }
    
    .inspection-table tbody tr.highlight {
        background: #fef3c7;
        transition: background 0.2s;
    }
    
    
    .btn-reset-all {
        padding: 0.5rem 1rem;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .btn-reset-all:hover {
        background: #e5e7eb;
    }
    
    .radio-group {
        display: flex;
        gap: 1rem;
    }
    
    .radio-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: normal;
        cursor: pointer;
    }
    
    .form-group.has-error input,
    .form-group.has-error select,
    .form-group.has-error .hero-custom-dropdown-trigger {
        border-color: #dc2626 !important;
    }
    
    .field-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }
    
    .step-error-summary {
        background: #fee2e2;
        border: 2px solid #dc2626;
        color: #991b1b;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<section class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 text-white py-12">
    <div class="container-custom">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Aracınızı Değerleyin</h1>
        <p class="text-lg text-primary-100">Birkaç basit adımda aracınızın değerini öğrenin</p>
    </div>
</section>

<div class="wizard-container">
    <form id="evaluation-form" method="POST" action="{{ route('evaluation.submit') }}">
        @csrf
        
        <!-- Step 1: Temel Bilgiler -->
        <div class="wizard-step active" id="step-1">
            <h2 class="text-2xl font-bold mb-6">Araç Temel Bilgiler</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Araç Tipi *</label>
                    <div class="hero-custom-dropdown" data-dropdown="vehicle-type-wizard">
                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300" data-value="{{ $selectedTip ?? '' }}">
                            <span class="selected-text {{ $selectedTip ? '' : 'placeholder' }}">
                                @if($selectedTip && isset($vehicleTypes[$selectedTip]))
                                    {{ $vehicleTypes[$selectedTip] }}
                                @else
                                    Seçiniz
                                @endif
                            </span>
                            <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hero-custom-dropdown-panel">
                            <div class="hero-custom-dropdown-option" data-value="">Seçiniz</div>
                            @foreach($vehicleTypes as $key => $label)
                                <div class="hero-custom-dropdown-option {{ ($selectedTip ?? '') === $key ? 'selected' : '' }}" data-value="{{ $key }}">{{ $label }}</div>
                            @endforeach
                        </div>
                        <select name="tip" required class="hero-custom-dropdown-native">
                            <option value="">Seçiniz</option>
                            @foreach($vehicleTypes as $key => $label)
                                <option value="{{ $key }}" {{ ($selectedTip ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Model Yılı *</label>
                    <div class="hero-custom-dropdown" data-dropdown="year-wizard">
                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300" data-value="{{ $selectedYil ?? '' }}">
                            <span class="selected-text {{ $selectedYil ? '' : 'placeholder' }}">{{ $selectedYil ?? 'Yıl seçin' }}</span>
                            <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hero-custom-dropdown-panel">
                            <div class="hero-custom-dropdown-option" data-value="">Yıl seçin</div>
                            @for($year = date('Y') + 1; $year >= 1990; $year--)
                                <div class="hero-custom-dropdown-option {{ ($selectedYil ?? '') == $year ? 'selected' : '' }}" data-value="{{ $year }}">{{ $year }}</div>
                            @endfor
                        </div>
                        <select name="yil" required class="hero-custom-dropdown-native">
                            <option value="">Yıl seçin</option>
                            @for($year = date('Y') + 1; $year >= 1990; $year--)
                                <option value="{{ $year }}" {{ ($selectedYil ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Marka *</label>
                    <div class="hero-custom-dropdown" data-dropdown="brand-wizard">
                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300" data-value="{{ $selectedMarka ?? '' }}">
                            <span class="selected-text {{ $selectedMarka ? '' : 'placeholder' }}">{{ $selectedMarka ?? 'Seçiniz' }}</span>
                            <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hero-custom-dropdown-panel">
                            <div class="hero-custom-dropdown-option" data-value="">Seçiniz</div>
                            @foreach(\App\Data\CarBrands::all() as $brand)
                                <div class="hero-custom-dropdown-option {{ ($selectedMarka ?? '') === $brand ? 'selected' : '' }}" data-value="{{ $brand }}">{{ $brand }}</div>
                            @endforeach
                        </div>
                        <select name="marka" required class="hero-custom-dropdown-native">
                            <option value="">Seçiniz</option>
                            @foreach(\App\Data\CarBrands::all() as $brand)
                                <option value="{{ $brand }}" {{ ($selectedMarka ?? '') === $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Model *</label>
                    <input type="text" name="model" required placeholder="Model giriniz">
                </div>
                
                <div class="form-group">
                    <label>Gövde Tipi *</label>
                    <div class="hero-custom-dropdown" data-dropdown="body-type-wizard">
                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300" data-value="">
                            <span class="selected-text placeholder">Seçiniz</span>
                            <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hero-custom-dropdown-panel">
                            <div class="hero-custom-dropdown-option" data-value="">Seçiniz</div>
                            <div class="hero-custom-dropdown-option" data-value="SEDAN">Sedan</div>
                            <div class="hero-custom-dropdown-option" data-value="HATCHBACK">Hatchback</div>
                            <div class="hero-custom-dropdown-option" data-value="STATION_WAGON">Station Wagon</div>
                            <div class="hero-custom-dropdown-option" data-value="COUPE">Coupe</div>
                            <div class="hero-custom-dropdown-option" data-value="CABRIO">Cabrio</div>
                            <div class="hero-custom-dropdown-option" data-value="SUV">SUV</div>
                            <div class="hero-custom-dropdown-option" data-value="PICKUP">Pickup</div>
                            <div class="hero-custom-dropdown-option" data-value="MPV">MPV</div>
                        </div>
                        <select name="gövde_tipi" required class="hero-custom-dropdown-native">
                            <option value="">Seçiniz</option>
                            <option value="SEDAN">Sedan</option>
                            <option value="HATCHBACK">Hatchback</option>
                            <option value="STATION_WAGON">Station Wagon</option>
                            <option value="COUPE">Coupe</option>
                            <option value="CABRIO">Cabrio</option>
                            <option value="SUV">SUV</option>
                            <option value="PICKUP">Pickup</option>
                            <option value="MPV">MPV</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Yakıt Tipi *</label>
                    <div class="hero-custom-dropdown" data-dropdown="fuel-type-wizard">
                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300" data-value="">
                            <span class="selected-text placeholder">Seçiniz</span>
                            <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hero-custom-dropdown-panel">
                            <div class="hero-custom-dropdown-option" data-value="">Seçiniz</div>
                            @foreach($fuelTypes as $key => $label)
                                <div class="hero-custom-dropdown-option" data-value="{{ $key }}">{{ $label }}</div>
                            @endforeach
                        </div>
                        <select name="yakıt_tipi" required class="hero-custom-dropdown-native">
                            <option value="">Seçiniz</option>
                            @foreach($fuelTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Vites Tipi *</label>
                    <div class="hero-custom-dropdown" data-dropdown="transmission-wizard">
                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300" data-value="">
                            <span class="selected-text placeholder">Seçiniz</span>
                            <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hero-custom-dropdown-panel">
                            <div class="hero-custom-dropdown-option" data-value="">Seçiniz</div>
                            @foreach($transmissionTypes as $key => $label)
                                <div class="hero-custom-dropdown-option" data-value="{{ $key }}">{{ $label }}</div>
                            @endforeach
                        </div>
                        <select name="vites_tipi" required class="hero-custom-dropdown-native">
                            <option value="">Seçiniz</option>
                            @foreach($transmissionTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Model Tipi</label>
                    <input type="text" name="model_tipi" placeholder="Örn: TFSI, TDI">
                </div>
            </div>
            
            <div class="wizard-buttons">
                <div></div>
                <button type="button" class="btn-wizard btn-wizard-primary" onclick="nextStep()">DEVAM</button>
            </div>
        </div>
        
        <!-- Step 2: Detaylar -->
        <div class="wizard-step" id="step-2">
            <h2 class="text-2xl font-bold mb-6">Detaylar</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Donanım Paketi</label>
                    <input type="text" name="donanım_paketi" placeholder="Örn: Comfort, Premium">
                </div>
                
                <div class="form-group">
                    <label>Kilometre *</label>
                    <input type="number" name="kilometre" required min="1" placeholder="Kilometre giriniz">
                </div>
                
                <div class="form-group">
                    <label>Araç Rengi *</label>
                    <div class="hero-custom-dropdown" data-dropdown="color-wizard">
                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300" data-value="">
                            <span class="selected-text placeholder">Seçiniz</span>
                            <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hero-custom-dropdown-panel">
                            <div class="hero-custom-dropdown-option" data-value="">Seçiniz</div>
                            <div class="hero-custom-dropdown-option" data-value="Siyah">Siyah</div>
                            <div class="hero-custom-dropdown-option" data-value="Beyaz">Beyaz</div>
                            <div class="hero-custom-dropdown-option" data-value="Gri">Gri</div>
                            <div class="hero-custom-dropdown-option" data-value="Kırmızı">Kırmızı</div>
                            <div class="hero-custom-dropdown-option" data-value="Mavi">Mavi</div>
                            <div class="hero-custom-dropdown-option" data-value="Lacivert">Lacivert</div>
                            <div class="hero-custom-dropdown-option" data-value="Yeşil">Yeşil</div>
                            <div class="hero-custom-dropdown-option" data-value="Sarı">Sarı</div>
                            <div class="hero-custom-dropdown-option" data-value="Turuncu">Turuncu</div>
                            <div class="hero-custom-dropdown-option" data-value="Kahverengi">Kahverengi</div>
                            <div class="hero-custom-dropdown-option" data-value="Bej">Bej</div>
                            <div class="hero-custom-dropdown-option" data-value="Bordo">Bordo</div>
                            <div class="hero-custom-dropdown-option" data-value="DİĞER">DİĞER</div>
                        </div>
                        <select name="renk" required class="hero-custom-dropdown-native">
                            <option value="">Seçiniz</option>
                            <option value="Siyah">Siyah</option>
                            <option value="Beyaz">Beyaz</option>
                            <option value="Gri">Gri</option>
                            <option value="Kırmızı">Kırmızı</option>
                            <option value="Mavi">Mavi</option>
                            <option value="Lacivert">Lacivert</option>
                            <option value="Yeşil">Yeşil</option>
                            <option value="Sarı">Sarı</option>
                            <option value="Turuncu">Turuncu</option>
                            <option value="Kahverengi">Kahverengi</option>
                            <option value="Bej">Bej</option>
                            <option value="Bordo">Bordo</option>
                            <option value="DİĞER">DİĞER</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Tramer Hasar Kaydı *</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="tramer" value="YOK" checked required>
                        <span>Yok</span>
                    </label>
                    <label>
                        <input type="radio" name="tramer" value="VAR" required>
                        <span>Var</span>
                    </label>
                </div>
                <div id="tramer-amount" style="display: none; margin-top: 1rem;">
                    <input type="number" name="tramer_tutarı" placeholder="Tutar (TL)" min="0">
                </div>
            </div>
            
            <div class="wizard-buttons">
                <button type="button" class="btn-wizard btn-wizard-secondary" onclick="prevStep()">GERİ DÖN</button>
                <button type="button" class="btn-wizard btn-wizard-primary" onclick="nextStep()">DEVAM</button>
            </div>
        </div>
        
        <!-- Step 3: Ekspertiz -->
        <div class="wizard-step" id="step-3">
            <h2 class="text-2xl font-bold mb-6">Ekspertiz Tanımları</h2>
            
            <div class="inspection-table-container">
                <table class="inspection-table">
                    <thead>
                        <tr>
                            <th>Parça</th>
                            <th>Orijinal</th>
                            <th>Lokal Boyalı</th>
                            <th>Boyalı</th>
                            <th>Onarım</th>
                            <th>Değişen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $parts = [
                                'Sol Ön Çamurluk' => 'sol_on_camurluk',
                                'Sol Ön Kapı' => 'sol_on_kapi',
                                'Sol Arka Çamurluk' => 'sol_arka_camurluk',
                                'Sol Arka Kapı' => 'sol_arka_kapi',
                                'Sağ Ön Çamurluk' => 'sag_on_camurluk',
                                'Sağ Ön Kapı' => 'sag_on_kapi',
                                'Sağ Arka Çamurluk' => 'sag_arka_camurluk',
                                'Sağ Arka Kapı' => 'sag_arka_kapi',
                                'Ön Tampon' => 'on_tampon',
                                'Kaput' => 'kaput',
                                'Tavan' => 'tavan',
                                'Bagaj Havuzu' => 'bagaj_havuzu',
                                'Bagaj' => 'bagaj',
                                'Arka Tampon' => 'arka_tampon',
                                'Ön Panel' => 'on_panel',
                                'Sağ Şasi' => 'sag_sasi',
                                'Sol Şasi' => 'sol_sasi'
                            ];
                            $statuses = ['ORIJINAL', 'LOKAL_BOYALI', 'BOYALI', 'ONARIM', 'DEGISEN'];
                        @endphp
                        @foreach($parts as $partName => $partKey)
                            <tr data-part="{{ $partKey }}">
                                <td style="text-align: left; font-weight: 600;">{{ $partName }}</td>
                                @foreach($statuses as $status)
                                    <td>
                                        <input type="radio" 
                                               name="ekspertiz[{{ $partKey }}]" 
                                               value="{{ $status }}" 
                                               data-part="{{ $partKey }}"
                                               data-status="{{ $status }}"
                                               {{ $status === 'ORIJINAL' ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div style="margin-top: 1rem;">
                    <button type="button" class="btn-reset-all" onclick="resetAllToOriginal()">
                        Hepsi Orijinal Yap
                    </button>
                </div>
            </div>
            
            <div class="wizard-buttons">
                <button type="button" class="btn-wizard btn-wizard-secondary" onclick="prevStep()">GERİ DÖN</button>
                <button type="button" class="btn-wizard btn-wizard-primary" onclick="nextStep()">DEVAM</button>
            </div>
        </div>
        
        <!-- Step 4: Kişisel Bilgiler -->
        <div class="wizard-step" id="step-4">
            <h2 class="text-2xl font-bold mb-6">Kişisel Bilgiler</h2>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Adınız *</label>
                    <input type="text" name="ad" required>
                </div>
                
                <div class="form-group">
                    <label>Soyadınız *</label>
                    <input type="text" name="soyad" required>
                </div>
                
                <div class="form-group">
                    <label>Mobil Telefon *</label>
                    <input type="tel" name="telefon" required placeholder="5XX XXX XX XX">
                </div>
                
                <div class="form-group">
                    <label>E-Posta *</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Bulunduğunuz Şehir *</label>
                    <div class="hero-custom-dropdown" data-dropdown="city-wizard">
                        <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300" data-value="">
                            <span class="selected-text placeholder">Seçiniz</span>
                            <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="hero-custom-dropdown-panel">
                            <div class="hero-custom-dropdown-option" data-value="">Seçiniz</div>
                            @php
                                $cities = ['İstanbul', 'Ankara', 'İzmir', 'Bursa', 'Antalya', 'Adana', 'Konya', 'Gaziantep', 'Kayseri', 'Mersin', 'Diyarbakır', 'Eskişehir', 'Urfa', 'Malatya', 'Manisa', 'Samsun', 'Kahramanmaraş', 'Van', 'Denizli', 'Batman'];
                            @endphp
                            @foreach($cities as $city)
                                <div class="hero-custom-dropdown-option" data-value="{{ $city }}">{{ $city }}</div>
                            @endforeach
                        </div>
                        <select name="şehir" required class="hero-custom-dropdown-native">
                            <option value="">Seçiniz</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}">{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="kvkk_onay" value="1" required>
                    <span>6698 Sayılı Kanun düzenlenmesi uyarınca kişisel verilerimin nasıl korunacağına ve işleneceğine dair aydınlatma metni ile GMSGARAGE tarafından aydınlatıldım. *</span>
                </label>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="kampanya_izin" value="1">
                    <span>Paylaşmış olduğum iletişim bilgilerime tercih ettiğim kanallardan özel kampanyalar için ileti göndermesini kabul ediyorum.</span>
                </label>
            </div>
            
            <div class="wizard-buttons">
                <button type="button" class="btn-wizard btn-wizard-secondary" onclick="prevStep()">GERİ DÖN</button>
                <button type="submit" class="btn-wizard btn-wizard-primary">GÖNDER</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    let currentStep = 1;
    const totalSteps = 4;
    
    function showStep(step) {
        document.querySelectorAll('.wizard-step').forEach((s, index) => {
            if (index + 1 === step) {
                s.classList.add('active');
            } else {
                s.classList.remove('active');
            }
        });
        currentStep = step;
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Reinitialize dropdowns for active step
        setTimeout(() => {
            initWizardDropdowns();
            
            // Reinitialize inspection if step 3
            if (step === 3) {
                initInspectionState();
                initInspectionListeners();
            }
            
            // Reinitialize tramer toggle if step 2
            if (step === 2) {
                initTramerToggle();
            }
        }, 100);
    }
    
    function nextStep() {
        // Validate current step before proceeding
        if (!validateCurrentStep()) {
            return false;
        }
        
        if (currentStep < totalSteps) {
            showStep(currentStep + 1);
        }
    }
    
    function validateCurrentStep() {
        const activeStep = document.querySelector('.wizard-step.active');
        if (!activeStep) return false;
        
        let isValid = true;
        
        // Remove previous error messages
        activeStep.querySelectorAll('.field-error').forEach(err => err.remove());
        activeStep.querySelectorAll('.form-group').forEach(group => {
            group.classList.remove('has-error');
        });
        
        // Step 1 Validation
        if (currentStep === 1) {
            const tip = activeStep.querySelector('[name="tip"]');
            const yil = activeStep.querySelector('[name="yil"]');
            const marka = activeStep.querySelector('[name="marka"]');
            const model = activeStep.querySelector('[name="model"]');
            const gövde = activeStep.querySelector('[name="gövde_tipi"]');
            const yakıt = activeStep.querySelector('[name="yakıt_tipi"]');
            const vites = activeStep.querySelector('[name="vites_tipi"]');
            
            if (!tip || !tip.value || tip.value.trim() === '') {
                isValid = false;
                const tipGroup = tip ? tip.closest('.form-group') : null;
                if (tipGroup) showFieldError(tipGroup, 'Araç Tipi seçiniz');
            }
            if (!yil || !yil.value || yil.value.trim() === '') {
                isValid = false;
                const yilGroup = yil ? yil.closest('.form-group') : null;
                if (yilGroup) showFieldError(yilGroup, 'Model Yılı seçiniz');
            }
            if (!marka || !marka.value || marka.value.trim() === '') {
                isValid = false;
                const markaGroup = marka ? marka.closest('.form-group') : null;
                if (markaGroup) showFieldError(markaGroup, 'Marka seçiniz');
            }
            if (!model || !model.value || model.value.trim() === '') {
                isValid = false;
                const modelGroup = model ? model.closest('.form-group') : null;
                if (modelGroup) showFieldError(modelGroup, 'Model giriniz');
            }
            if (!gövde || !gövde.value || gövde.value.trim() === '') {
                isValid = false;
                const gövdeGroup = gövde ? gövde.closest('.form-group') : null;
                if (gövdeGroup) showFieldError(gövdeGroup, 'Gövde Tipi seçiniz');
            }
            if (!yakıt || !yakıt.value || yakıt.value.trim() === '') {
                isValid = false;
                const yakıtGroup = yakıt ? yakıt.closest('.form-group') : null;
                if (yakıtGroup) showFieldError(yakıtGroup, 'Yakıt Tipi seçiniz');
            }
            if (!vites || !vites.value || vites.value.trim() === '') {
                isValid = false;
                const vitesGroup = vites ? vites.closest('.form-group') : null;
                if (vitesGroup) showFieldError(vitesGroup, 'Vites Tipi seçiniz');
            }
        }
        
        // Step 2 Validation
        if (currentStep === 2) {
            const kilometre = activeStep.querySelector('[name="kilometre"]');
            const renk = activeStep.querySelector('[name="renk"]');
            const tramer = activeStep.querySelector('[name="tramer"]:checked');
            const tramerTutar = activeStep.querySelector('[name="tramer_tutarı"]');
            
            if (!kilometre || !kilometre.value || kilometre.value.trim() === '' || parseInt(kilometre.value) < 1) {
                isValid = false;
                const kmGroup = kilometre ? kilometre.closest('.form-group') : null;
                if (kmGroup) showFieldError(kmGroup, 'Kilometre giriniz (minimum 1 km)');
            }
            if (!renk || !renk.value || renk.value.trim() === '') {
                isValid = false;
                const renkGroup = renk ? renk.closest('.form-group') : null;
                if (renkGroup) showFieldError(renkGroup, 'Araç Rengi seçiniz');
            }
            if (!tramer) {
                isValid = false;
                const tramerInput = activeStep.querySelector('[name="tramer"]');
                const tramerGroup = tramerInput ? tramerInput.closest('.form-group') : null;
                if (tramerGroup) showFieldError(tramerGroup, 'Tramer Hasar Kaydı seçiniz');
            } else if (tramer.value === 'VAR') {
                if (!tramerTutar || !tramerTutar.value || tramerTutar.value.trim() === '' || parseFloat(tramerTutar.value) < 0) {
                    isValid = false;
                    const tutarGroup = tramerTutar ? tramerTutar.closest('.form-group') : null;
                    if (tutarGroup) showFieldError(tutarGroup, 'Tramer tutarı giriniz');
                }
            }
        }
        
        // Step 3 Validation (Ekspertiz - optional, no validation needed)
        
        // Step 4 Validation
        if (currentStep === 4) {
            const ad = activeStep.querySelector('[name="ad"]');
            const soyad = activeStep.querySelector('[name="soyad"]');
            const telefon = activeStep.querySelector('[name="telefon"]');
            const email = activeStep.querySelector('[name="email"]');
            const şehir = activeStep.querySelector('[name="şehir"]');
            const kvkk = activeStep.querySelector('[name="kvkk_onay"]');
            
            if (!ad || !ad.value || ad.value.trim() === '') {
                isValid = false;
                const adGroup = ad ? ad.closest('.form-group') : null;
                if (adGroup) showFieldError(adGroup, 'Adınızı giriniz');
            }
            if (!soyad || !soyad.value || soyad.value.trim() === '') {
                isValid = false;
                const soyadGroup = soyad ? soyad.closest('.form-group') : null;
                if (soyadGroup) showFieldError(soyadGroup, 'Soyadınızı giriniz');
            }
            if (!telefon || !telefon.value || telefon.value.trim() === '') {
                isValid = false;
                const telefonGroup = telefon ? telefon.closest('.form-group') : null;
                if (telefonGroup) showFieldError(telefonGroup, 'Mobil telefon giriniz');
            }
            if (!email || !email.value || email.value.trim() === '' || !email.value.includes('@')) {
                isValid = false;
                const emailGroup = email ? email.closest('.form-group') : null;
                if (emailGroup) showFieldError(emailGroup, 'Geçerli bir e-posta adresi giriniz');
            }
            if (!şehir || !şehir.value || şehir.value.trim() === '') {
                isValid = false;
                const şehirGroup = şehir ? şehir.closest('.form-group') : null;
                if (şehirGroup) showFieldError(şehirGroup, 'Şehir seçiniz');
            }
            if (!kvkk || !kvkk.checked) {
                isValid = false;
                const kvkkInput = activeStep.querySelector('[name="kvkk_onay"]');
                const kvkkGroup = kvkkInput ? kvkkInput.closest('.form-group') : null;
                if (kvkkGroup) showFieldError(kvkkGroup, 'KVKK aydınlatma metnini onaylamanız gerekmektedir');
            }
        }
        
        if (!isValid) {
            // Show general error message
            let errorSummary = activeStep.querySelector('.step-error-summary');
            if (!errorSummary) {
                errorSummary = document.createElement('div');
                errorSummary.className = 'step-error-summary';
                errorSummary.style.cssText = 'background: #fee2e2; border: 2px solid #dc2626; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600;';
                activeStep.insertBefore(errorSummary, activeStep.querySelector('h2').nextSibling);
            }
            errorSummary.innerHTML = '<div style="display: flex; align-items: center; gap: 0.5rem;"><svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg><span>Lütfen zorunlu alanları doldurun</span></div>';
            
            // Scroll to first error
            const firstError = activeStep.querySelector('.has-error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        } else {
            // Remove error summary if exists
            const errorSummary = activeStep.querySelector('.step-error-summary');
            if (errorSummary) {
                errorSummary.remove();
            }
        }
        
        return isValid;
    }
    
    function showFieldError(fieldGroup, message) {
        if (!fieldGroup) return;
        
        fieldGroup.classList.add('has-error');
        
        // Remove existing error
        const existingError = fieldGroup.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Add error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.style.cssText = 'color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; font-weight: 500;';
        errorDiv.textContent = message;
        fieldGroup.appendChild(errorDiv);
        
        // Add red border to input/select
        const input = fieldGroup.querySelector('input, select');
        if (input) {
            input.style.borderColor = '#dc2626';
        }
        
        // Add red border to dropdown trigger if exists
        const trigger = fieldGroup.querySelector('.hero-custom-dropdown-trigger');
        if (trigger) {
            trigger.classList.add('border-red-500');
            trigger.classList.remove('border-gray-300');
        }
    }
    
    function prevStep() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    }
    
    // Initialize custom dropdowns (same as Hero)
    function initWizardDropdowns() {
        const activeStep = document.querySelector('.wizard-step.active');
        if (!activeStep) return;
        
        const dropdowns = activeStep.querySelectorAll('.hero-custom-dropdown');
        
        dropdowns.forEach(dropdown => {
            if (dropdown.dataset.initialized === 'true') return;
            dropdown.dataset.initialized = 'true';
            
            const trigger = dropdown.querySelector('.hero-custom-dropdown-trigger');
            const panel = dropdown.querySelector('.hero-custom-dropdown-panel');
            const options = panel ? panel.querySelectorAll('.hero-custom-dropdown-option') : [];
            const nativeSelect = dropdown.querySelector('.hero-custom-dropdown-native');
            const selectedText = trigger ? trigger.querySelector('.selected-text') : null;
            
            if (!trigger || !panel || !nativeSelect || !selectedText) return;
            
            // Toggle dropdown
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                
                // Close other dropdowns
                activeStep.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(openPanel => {
                    if (openPanel !== panel) {
                        openPanel.classList.remove('open');
                        const otherDropdown = openPanel.closest('.hero-custom-dropdown');
                        if (otherDropdown) {
                            otherDropdown.querySelector('.hero-custom-dropdown-trigger').classList.remove('open');
                            otherDropdown.classList.remove('dropdown-open');
                        }
                    }
                });
                
                // Toggle current
                const isOpen = panel.classList.contains('open');
                if (!isOpen) {
                    panel.classList.add('open');
                    trigger.classList.add('open');
                    dropdown.classList.add('dropdown-open');
                } else {
                    panel.classList.remove('open');
                    trigger.classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                }
            });
            
            // Option click
            options.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const value = this.getAttribute('data-value');
                    const text = this.textContent.trim();
                    
                    selectedText.textContent = text;
                    selectedText.classList.remove('placeholder');
                    trigger.setAttribute('data-value', value);
                    nativeSelect.value = value;
                    nativeSelect.dispatchEvent(new Event('change', { bubbles: true }));
                    
                    options.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    
                    panel.classList.remove('open');
                    trigger.classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                    
                    // Clear error when value is selected
                    const fieldGroup = dropdown.closest('.form-group');
                    if (fieldGroup) {
                        fieldGroup.classList.remove('has-error');
                        const errorMsg = fieldGroup.querySelector('.field-error');
                        if (errorMsg) errorMsg.remove();
                        trigger.classList.remove('border-red-500');
                        trigger.classList.add('border-gray-300');
                    }
                });
            });
            
            // Initialize selected value
            if (nativeSelect.value) {
                const selectedOption = Array.from(options).find(opt => opt.getAttribute('data-value') === nativeSelect.value);
                if (selectedOption) {
                    selectedText.textContent = selectedOption.textContent.trim();
                    selectedText.classList.remove('placeholder');
                    trigger.setAttribute('data-value', nativeSelect.value);
                    selectedOption.classList.add('selected');
                }
            }
        });
    }
    
    // Close dropdowns on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.hero-custom-dropdown')) {
            document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(panel => {
                panel.classList.remove('open');
                const dropdown = panel.closest('.hero-custom-dropdown');
                if (dropdown) {
                    dropdown.querySelector('.hero-custom-dropdown-trigger').classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                }
            });
        }
    });
    
    // Close on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(panel => {
                panel.classList.remove('open');
                const dropdown = panel.closest('.hero-custom-dropdown');
                if (dropdown) {
                    dropdown.querySelector('.hero-custom-dropdown-trigger').classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                }
            });
        }
    });
    
    // Inspection State Management
    let inspectionState = {};
    
    // Initialize inspection state from form
    function initInspectionState() {
        const step3 = document.getElementById('step-3');
        if (!step3) return;
        
        const radios = step3.querySelectorAll('input[type="radio"][name^="ekspertiz"]');
        radios.forEach(radio => {
            if (radio.checked) {
                const part = radio.getAttribute('data-part');
                const status = radio.getAttribute('data-status');
                if (part && status) {
                    inspectionState[part] = status;
                }
            }
        });
        
        // Update visual on init
        updateVehicleVisual();
    }
    
    // Handle radio change
    function handleInspectionChange(part, status) {
        inspectionState[part] = status;
        
        // Highlight table row
        const row = document.querySelector(`tr[data-part="${part}"]`);
        if (row) {
            row.classList.add('highlight');
            setTimeout(() => {
                row.classList.remove('highlight');
            }, 500);
        }
    }
    
    // Reset all to original
    function resetAllToOriginal() {
        const step3 = document.getElementById('step-3');
        if (!step3) return;
        
        const radios = step3.querySelectorAll('input[type="radio"][name^="ekspertiz"]');
        radios.forEach(radio => {
            if (radio.value === 'ORIJINAL') {
                radio.checked = true;
                const part = radio.getAttribute('data-part');
                if (part) {
                    inspectionState[part] = 'ORIJINAL';
                }
            }
        });
        
        updateVehicleVisual();
    }
    
    // Initialize inspection listeners
    function initInspectionListeners() {
        const step3 = document.getElementById('step-3');
        if (!step3) return;
        
        const radios = step3.querySelectorAll('input[type="radio"][name^="ekspertiz"]');
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                const part = this.getAttribute('data-part');
                const status = this.getAttribute('data-status');
                if (part && status) {
                    handleInspectionChange(part, status);
                }
            });
        });
    }
    
    
    // Tramer toggle handler
    function initTramerToggle() {
        const step2 = document.getElementById('step-2');
        if (!step2) return;
        
        const radios = step2.querySelectorAll('input[name="tramer"]');
        radios.forEach(radio => {
            // Remove existing listeners to prevent duplicates
            const newRadio = radio.cloneNode(true);
            radio.parentNode.replaceChild(newRadio, radio);
            
            newRadio.addEventListener('change', function() {
                const amountDiv = document.getElementById('tramer-amount');
                if (!amountDiv) return;
                
                if (this.value === 'VAR') {
                    amountDiv.style.display = 'block';
                    const input = amountDiv.querySelector('input');
                    if (input) input.required = true;
                } else {
                    amountDiv.style.display = 'none';
                    const input = amountDiv.querySelector('input');
                    if (input) {
                        input.required = false;
                        input.value = '';
                    }
                }
            });
        });
    }
    
    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
        initWizardDropdowns();
        
        // Initialize inspection
        initInspectionState();
        initInspectionListeners();
        
        // Initialize tramer toggle
        initTramerToggle();
        
        // Form submit validation
        const form = document.getElementById('evaluation-form');
        if (form) {
            const submitHandler = function(e) {
                e.preventDefault();
                
                // Validate all steps before submit
                function validateAllSteps() {
                    // Validate Step 1
                    currentStep = 1;
                    showStep(1);
                    const step1Valid = validateCurrentStep();
                    
                    if (!step1Valid) {
                        showStep(4);
                        return false;
                    }
                    
                    // Validate Step 2
                    currentStep = 2;
                    showStep(2);
                    const step2Valid = validateCurrentStep();
                    
                    if (!step2Valid) {
                        showStep(4);
                        return false;
                    }
                    
                    // Validate Step 4 (Step 3 is optional)
                    currentStep = 4;
                    showStep(4);
                    const step4Valid = validateCurrentStep();
                    
                    if (!step4Valid) {
                        return false;
                    }
                    
                    // All validations passed
                    return true;
                }
                
                // Use setTimeout to ensure DOM is ready after step changes
                setTimeout(() => {
                    if (validateAllSteps()) {
                        // Remove event listener to prevent loop, then submit
                        form.removeEventListener('submit', submitHandler);
                        form.submit();
                    }
                }, 100);
            };
            
            form.addEventListener('submit', submitHandler);
        }
    });
    
    // Clear errors on input/select change
    document.addEventListener('input', function(e) {
        if (e.target.matches('input, select')) {
            const fieldGroup = e.target.closest('.form-group');
            if (fieldGroup && fieldGroup.classList.contains('has-error')) {
                fieldGroup.classList.remove('has-error');
                const errorMsg = fieldGroup.querySelector('.field-error');
                if (errorMsg) errorMsg.remove();
                e.target.style.borderColor = '';
            }
        }
    });
    
    document.addEventListener('change', function(e) {
        if (e.target.matches('input, select')) {
            const fieldGroup = e.target.closest('.form-group');
            if (fieldGroup && fieldGroup.classList.contains('has-error')) {
                fieldGroup.classList.remove('has-error');
                const errorMsg = fieldGroup.querySelector('.field-error');
                if (errorMsg) errorMsg.remove();
                e.target.style.borderColor = '';
                
                // Also clear dropdown trigger error
                const trigger = fieldGroup.querySelector('.hero-custom-dropdown-trigger');
                if (trigger) {
                    trigger.classList.remove('border-red-500');
                    trigger.classList.add('border-gray-300');
                }
            }
        }
    });
</script>
@endpush
