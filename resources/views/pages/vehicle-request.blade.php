@extends('layouts.app')

@section('title', 'Aracınızı Bize İletin - GMSGARAGE')
@section('description', 'Listede bulamadığınız aracı bize iletin. En kısa sürede size dönüş yapacağız.')

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800 text-white py-16 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>
        <div class="container-custom relative z-10">
            <nav class="flex items-center space-x-2 text-sm mb-4">
                <a href="{{ route('home') }}" class="text-primary-200 hover:text-white transition-colors">Anasayfa</a>
                <span class="text-primary-300">/</span>
                <span class="text-white font-semibold">Aracınızı Bize İletin</span>
            </nav>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Aracınızı listede bulamadınız mı?</h1>
            <p class="text-xl text-primary-100 max-w-3xl">Marka/model listenizde yoksa 30 saniyede bize iletin. En kısa sürede size dönüş yapacağız ve aracınızı listemize ekleyeceğiz.</p>
        </div>
    </section>

    <!-- Form Section -->
    <section class="section-padding bg-gray-50 dark:bg-[#1e1e1e] transition-colors duration-200">
        <div class="container-custom">
            <div class="max-w-3xl mx-auto">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 dark:border-green-400 p-6 mb-8 rounded-lg transition-colors duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-bold text-green-800 dark:text-green-300">Teşekkürler!</h3>
                                <p class="text-green-700 dark:text-green-400 mt-1">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form Card -->
                <div class="bg-white dark:bg-[#252525] rounded-2xl shadow-xl dark:shadow-2xl p-8 border border-gray-100 dark:border-gray-800 transition-colors duration-200">
                    <!-- Error Summary Banner -->
                    <div id="error-summary" class="hidden bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-400 p-4 mb-6 rounded-lg transition-colors duration-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-red-800 dark:text-red-300">Lütfen zorunlu alanları kontrol edin.</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('vehicle-request.submit') }}" id="vehicle-request-form" class="space-y-6">
                        @csrf

                        <!-- Araç Tipi -->
                        <div class="form-field">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">ARAÇ TİPİ <span class="text-primary-600 dark:text-primary-400">*</span></label>
                            <div class="hero-custom-dropdown" data-dropdown="vehicle-type-request">
                                <button type="button" class="hero-custom-dropdown-trigger border-2 border-gray-300 dark:border-gray-700" data-value="{{ old('vehicle_type', '') }}">
                                    <span class="selected-text {{ old('vehicle_type') ? '' : 'placeholder' }}">
                                        @if(old('vehicle_type') && isset($vehicleTypes[old('vehicle_type')]))
                                            {{ $vehicleTypes[old('vehicle_type')] }}
                                        @else
                                            Araç Tipi Seçin
                                        @endif
                                    </span>
                                    <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="hero-custom-dropdown-panel">
                                    <div class="hero-custom-dropdown-option" data-value="">Araç Tipi Seçin</div>
                                    @foreach($vehicleTypes ?? [] as $key => $label)
                                        <div class="hero-custom-dropdown-option {{ old('vehicle_type') == $key ? 'selected' : '' }}" data-value="{{ $key }}">{{ $label }}</div>
                                    @endforeach
                                </div>
                                <select name="vehicle_type" required class="hero-custom-dropdown-native">
                                    <option value="">Araç Tipi Seçin</option>
                                    @foreach($vehicleTypes ?? [] as $key => $label)
                                        <option value="{{ $key }}" {{ old('vehicle_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="text-red-600 text-xs mt-2 hidden" id="vehicle-type-error"></p>
                            @error('vehicle_type')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Marka -->
                        <div class="form-field">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">MARKA <span class="text-primary-600 dark:text-primary-400">*</span></label>
                            <input type="text" name="brand" required 
                                   value="{{ old('brand') }}"
                                   placeholder="Örn: Tesla, Rivian, Lucid"
                                   class="w-full border-2 border-gray-300 dark:border-gray-700 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 dark:text-gray-100 font-semibold transition-all duration-200 bg-white dark:bg-[#2a2a2a] hover:border-primary-400 dark:hover:border-primary-500"
                                   id="brand-input">
                            <p class="text-red-600 text-xs mt-2 hidden" id="brand-error"></p>
                            @error('brand')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Model -->
                        <div class="form-field">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">MODEL</label>
                            <input type="text" name="model" 
                                   value="{{ old('model') }}"
                                   placeholder="Örn: Model 3, R1T, Air"
                                   class="w-full border-2 border-gray-300 dark:border-gray-700 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 dark:text-gray-100 font-semibold transition-all duration-200 bg-white dark:bg-[#2a2a2a] hover:border-primary-400 dark:hover:border-primary-500">
                            @error('model')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Model Yılı -->
                        <div class="form-field">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">MODEL YILI</label>
                            <div class="hero-custom-dropdown" data-dropdown="year-request">
                                <button type="button" class="hero-custom-dropdown-trigger" data-value="{{ old('year', '') }}">
                                    <span class="selected-text {{ old('year') ? '' : 'placeholder' }}">
                                        {{ old('year') ? old('year') : 'Yıl Seçin' }}
                                    </span>
                                    <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="hero-custom-dropdown-panel">
                                    <div class="hero-custom-dropdown-option" data-value="">Yıl Seçin</div>
                                    @foreach($years ?? [] as $year)
                                        <div class="hero-custom-dropdown-option {{ old('year') == $year ? 'selected' : '' }}" data-value="{{ $year }}">{{ $year }}</div>
                                    @endforeach
                                </div>
                                <select name="year" class="hero-custom-dropdown-native">
                                    <option value="">Yıl Seçin</option>
                                    @foreach($years ?? [] as $year)
                                        <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('year')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kilometre -->
                        <div class="form-field">
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wider">KİLOMETRE</label>
                            <input type="number" name="kilometre" 
                                   value="{{ old('kilometre') }}"
                                   placeholder="Örn: 85.000"
                                   min="0"
                                   max="9999999"
                                   class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold transition-all duration-200 bg-white hover:border-primary-400">
                            @error('kilometre')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Yakıt Tipi -->
                        <div class="form-field">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">YAKIT TİPİ</label>
                            <div class="hero-custom-dropdown" data-dropdown="fuel-type-request">
                                <button type="button" class="hero-custom-dropdown-trigger" data-value="{{ old('fuel_type', '') }}">
                                    <span class="selected-text {{ old('fuel_type') ? '' : 'placeholder' }}">
                                        @if(old('fuel_type') && isset($fuelTypes[old('fuel_type')]))
                                            {{ $fuelTypes[old('fuel_type')] }}
                                        @else
                                            Yakıt Tipi Seçin
                                        @endif
                                    </span>
                                    <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="hero-custom-dropdown-panel">
                                    <div class="hero-custom-dropdown-option" data-value="">Yakıt Tipi Seçin</div>
                                    @foreach($fuelTypes ?? [] as $key => $label)
                                        <div class="hero-custom-dropdown-option {{ old('fuel_type') == $key ? 'selected' : '' }}" data-value="{{ $key }}">{{ $label }}</div>
                                    @endforeach
                                </div>
                                <select name="fuel_type" class="hero-custom-dropdown-native">
                                    <option value="">Yakıt Tipi Seçin</option>
                                    @foreach($fuelTypes ?? [] as $key => $label)
                                        <option value="{{ $key }}" {{ old('fuel_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('fuel_type')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Şehir -->
                        <div class="form-field">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">ŞEHİR</label>
                            <input type="text" name="city" 
                                   value="{{ old('city') }}"
                                   placeholder="Araç hangi şehirde?"
                                   class="w-full border-2 border-gray-300 dark:border-gray-700 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 dark:text-gray-100 font-semibold transition-all duration-200 bg-white dark:bg-[#2a2a2a] hover:border-primary-400 dark:hover:border-primary-500">
                            @error('city')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- İletişim -->
                        <div class="form-field">
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wider">İLETİŞİM <span class="text-primary-600">*</span></label>
                            <input type="text" name="contact" required 
                                   value="{{ old('contact') }}"
                                   placeholder="Telefon veya E-posta adresiniz"
                                   class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold transition-all duration-200 bg-white hover:border-primary-400"
                                   id="contact-input">
                            <p class="text-xs text-gray-500 mt-2">Size ulaşabilmemiz için telefon veya e-posta adresinizi girin</p>
                            <p class="text-red-600 text-xs mt-2 hidden" id="contact-error"></p>
                            @error('contact')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tercih Edilen İletişim Yöntemi -->
                        <div class="form-field">
                            <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-3 uppercase tracking-wider">TERCİH EDİLEN İLETİŞİM YÖNTEMİ</label>
                            <div class="hero-custom-dropdown" data-dropdown="contact-method-request">
                                <button type="button" class="hero-custom-dropdown-trigger" data-value="{{ old('contact_method', '') }}">
                                    <span class="selected-text {{ old('contact_method') ? '' : 'placeholder' }}">
                                        @if(old('contact_method') && isset($contactMethods[old('contact_method')]))
                                            {{ $contactMethods[old('contact_method')] }}
                                        @else
                                            İletişim Yöntemi Seçin
                                        @endif
                                    </span>
                                    <svg class="arrow w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div class="hero-custom-dropdown-panel">
                                    <div class="hero-custom-dropdown-option" data-value="">İletişim Yöntemi Seçin</div>
                                    @foreach($contactMethods ?? [] as $key => $label)
                                        <div class="hero-custom-dropdown-option {{ old('contact_method') == $key ? 'selected' : '' }}" data-value="{{ $key }}">{{ $label }}</div>
                                    @endforeach
                                </div>
                                <select name="contact_method" class="hero-custom-dropdown-native">
                                    <option value="">İletişim Yöntemi Seçin</option>
                                    @foreach($contactMethods ?? [] as $key => $label)
                                        <option value="{{ $key }}" {{ old('contact_method') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('contact_method')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Not -->
                        <div class="form-field">
                            <label class="block text-xs font-bold text-gray-700 mb-3 uppercase tracking-wider">AÇIKLAMA / NOT (Opsiyonel)</label>
                            <textarea name="note" rows="4" 
                                      placeholder="Eklemek istediğiniz başka bilgiler varsa buraya yazabilirsiniz..."
                                      class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold transition-all duration-200 bg-white hover:border-primary-400 resize-none">{{ old('note') }}</textarea>
                            @error('note')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" id="submit-btn" class="btn btn-primary w-full py-4 text-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                <span id="submit-text">Bize İlet</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Back Link -->
                <div class="text-center mt-8">
                    <a href="{{ route('home') }}" class="text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-semibold transition-colors duration-200 inline-flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Anasayfaya Dön</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Custom Dropdown Implementation (reuse from Hero)
    document.addEventListener('DOMContentLoaded', function() {
        initHeroCustomDropdowns();
        initFormValidation();
    });
    
    function initHeroCustomDropdowns() {
        const dropdowns = document.querySelectorAll('.hero-custom-dropdown');
        const formCard = document.querySelector('.bg-white.rounded-2xl');
        
        dropdowns.forEach(dropdown => {
            const trigger = dropdown.querySelector('.hero-custom-dropdown-trigger');
            const panel = dropdown.querySelector('.hero-custom-dropdown-panel');
            const options = panel.querySelectorAll('.hero-custom-dropdown-option');
            const nativeSelect = dropdown.querySelector('.hero-custom-dropdown-native');
            const selectedText = trigger.querySelector('.selected-text');
            
            if (!trigger || !panel || !nativeSelect) return;
            
            // Function to disable other form fields
            function disableOtherFields() {
                if (formCard) {
                    formCard.classList.add('dropdown-open');
                    const parentField = dropdown.closest('.form-field');
                    
                    formCard.querySelectorAll('.form-field').forEach(field => {
                        if (field !== parentField && !field.contains(panel)) {
                            field.style.pointerEvents = 'none';
                            field.style.opacity = '0.6';
                        } else if (field === parentField) {
                            field.style.opacity = '1';
                            field.style.pointerEvents = 'auto';
                        }
                    });
                }
            }
            
            function enableAllFields() {
                if (formCard) {
                    formCard.classList.remove('dropdown-open');
                    formCard.querySelectorAll('.form-field').forEach(field => {
                        field.style.pointerEvents = '';
                        field.style.opacity = '';
                    });
                }
            }
            
            // Toggle dropdown
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                
                document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(openPanel => {
                    if (openPanel !== panel) {
                        openPanel.classList.remove('open');
                        openPanel.closest('.hero-custom-dropdown').querySelector('.hero-custom-dropdown-trigger').classList.remove('open');
                    }
                });
                
                const isOpen = panel.classList.contains('open');
                if (!isOpen) {
                    panel.classList.add('open');
                    trigger.classList.add('open');
                    dropdown.classList.add('dropdown-open');
                    disableOtherFields();
                    const firstOption = panel.querySelector('.hero-custom-dropdown-option');
                    if (firstOption) {
                        firstOption.focus();
                    }
                } else {
                    panel.classList.remove('open');
                    trigger.classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                    enableAllFields();
                }
            });
            
            // Select option
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
                    
                    // Clear error if vehicle type dropdown
                    if (dropdown.getAttribute('data-dropdown') === 'vehicle-type-request') {
                        trigger.classList.remove('border-red-500');
                        trigger.classList.add('border-gray-300');
                        const errorElement = document.getElementById('vehicle-type-error');
                        if (errorElement) {
                            errorElement.classList.add('hidden');
                            errorElement.textContent = '';
                        }
                    }
                    
                    panel.classList.remove('open');
                    trigger.classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                    enableAllFields();
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
        
        // Close dropdowns on outside click
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.hero-custom-dropdown')) {
                document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(openPanel => {
                    openPanel.classList.remove('open');
                    const dropdown = openPanel.closest('.hero-custom-dropdown');
                    dropdown.querySelector('.hero-custom-dropdown-trigger').classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                });
                if (formCard) {
                    formCard.classList.remove('dropdown-open');
                    formCard.querySelectorAll('.form-field').forEach(field => {
                        field.style.pointerEvents = '';
                        field.style.opacity = '';
                    });
                }
            }
        });
        
        // Close dropdowns on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(openPanel => {
                    openPanel.classList.remove('open');
                    const dropdown = openPanel.closest('.hero-custom-dropdown');
                    dropdown.querySelector('.hero-custom-dropdown-trigger').classList.remove('open');
                    dropdown.classList.remove('dropdown-open');
                });
                if (formCard) {
                    formCard.classList.remove('dropdown-open');
                    formCard.querySelectorAll('.form-field').forEach(field => {
                        field.style.pointerEvents = '';
                        field.style.opacity = '';
                    });
                }
            }
        });
    }
    
    // Validation Functions
    function validateContact(value) {
        if (!value || value.trim() === '') {
            return { valid: false, message: 'İletişim bilgisi zorunludur.' };
        }
        
        // Check if it's an email
        if (value.includes('@')) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                return { valid: false, message: 'Geçerli bir telefon numarası veya e-posta adresi girin.' };
            }
            return { valid: true };
        } else {
            // Phone validation (remove spaces, +90, leading 0)
            let phone = value.replace(/[\s\+\-\(\)]/g, '');
            phone = phone.replace(/^90/, '');
            phone = phone.replace(/^0/, '');
            
            if (!/^[0-9]{10}$/.test(phone)) {
                return { valid: false, message: 'Geçerli bir telefon numarası veya e-posta adresi girin.' };
            }
            return { valid: true };
        }
    }
    
    function validateBrand(value) {
        if (!value || value.trim() === '') {
            return { valid: false, message: 'Marka alanı zorunludur.' };
        }
        if (value.trim().length < 2) {
            return { valid: false, message: 'Marka en az 2 karakter olmalıdır.' };
        }
        return { valid: true };
    }
    
    function validateModel(value) {
        if (value && value.trim().length > 0 && value.trim().length < 2) {
            return { valid: false, message: 'Model en az 2 karakter olmalıdır.' };
        }
        return { valid: true };
    }
    
    function validateCity(value) {
        if (value && value.trim().length > 0 && value.trim().length < 2) {
            return { valid: false, message: 'Şehir en az 2 karakter olmalıdır.' };
        }
        return { valid: true };
    }
    
    function validateKilometre(value) {
        if (!value || value.trim() === '') {
            return { valid: true }; // Optional
        }
        const km = parseInt(value);
        if (isNaN(km) || km < 0) {
            return { valid: false, message: 'Kilometre geçerli bir sayı olmalıdır (0 veya pozitif).' };
        }
        if (km > 9999999) {
            return { valid: false, message: 'Kilometre çok yüksek bir değer.' };
        }
        return { valid: true };
    }
    
    function showError(input, errorElement, message) {
        input.classList.add('border-red-500');
        input.classList.remove('border-gray-300');
        errorElement.textContent = message;
        errorElement.classList.remove('hidden');
    }
    
    function clearError(input, errorElement) {
        input.classList.remove('border-red-500');
        input.classList.add('border-gray-300');
        errorElement.classList.add('hidden');
        errorElement.textContent = '';
    }
    
    function showToast(message, type = 'success') {
        const existingToast = document.getElementById('toast-notification');
        if (existingToast) {
            existingToast.remove();
        }
        
        const toast = document.createElement('div');
        toast.id = 'toast-notification';
        toast.className = `fixed top-4 right-4 z-[999999] px-6 py-4 rounded-xl shadow-2xl transform transition-all duration-300 translate-x-full opacity-0 ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                ${type === 'success' ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' : ''}
                ${type === 'error' ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>' : ''}
                <span class="font-semibold">${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');
        }, 10);
        
        setTimeout(() => {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
    }
    
    function initFormValidation() {
        // Real-time validation
        const brandInput = document.getElementById('brand-input');
        const brandError = document.getElementById('brand-error');
        const contactInput = document.getElementById('contact-input');
        const contactError = document.getElementById('contact-error');
        
        if (brandInput && brandError) {
            brandInput.addEventListener('blur', function() {
                const validation = validateBrand(this.value);
                if (!validation.valid) {
                    showError(this, brandError, validation.message);
                } else {
                    clearError(this, brandError);
                }
            });
            
            brandInput.addEventListener('input', function() {
                if (this.value.trim().length >= 2) {
                    clearError(this, brandError);
                }
            });
        }
        
        if (contactInput && contactError) {
            contactInput.addEventListener('blur', function() {
                const validation = validateContact(this.value);
                if (!validation.valid) {
                    showError(this, contactError, validation.message);
                } else {
                    clearError(this, contactError);
                }
            });
            
            contactInput.addEventListener('input', function() {
                // Clear error on input if it looks valid
                if (this.value.trim().length > 0) {
                    const validation = validateContact(this.value);
                    if (validation.valid) {
                        clearError(this, contactError);
                    }
                }
            });
        }
        
        // Form validation
        const form = document.getElementById('vehicle-request-form');
        if (!form) return;
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const errorSummary = document.getElementById('error-summary');
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            
            // Clear previous errors
            if (errorSummary) errorSummary.classList.add('hidden');
            form.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
                el.classList.add('border-gray-300');
            });
            form.querySelectorAll('[id$="-error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
            // Remove dynamically created error messages
            form.querySelectorAll('.form-field p.text-red-600').forEach(el => {
                if (el.id === '' || !el.id.includes('-error')) {
                    el.remove();
                }
            });
            
            // Get form values - use native select for dropdowns
            const vehicleTypeSelect = form.querySelector('[name="vehicle_type"]');
            const vehicleType = vehicleTypeSelect ? vehicleTypeSelect.value : '';
            const brand = brandInput ? brandInput.value : '';
            const model = form.querySelector('[name="model"]')?.value || '';
            const contact = contactInput ? contactInput.value : '';
            const kilometre = form.querySelector('[name="kilometre"]')?.value || '';
            const city = form.querySelector('[name="city"]')?.value || '';
            
            let hasErrors = false;
            let firstErrorElement = null;
            const errors = {};
            
            // Validate vehicle type
            if (!vehicleType || vehicleType.trim() === '') {
                hasErrors = true;
                errors.vehicle_type = 'Araç tipi seçiniz.';
                const vehicleTypeDropdown = form.querySelector('[data-dropdown="vehicle-type-request"]');
                if (vehicleTypeDropdown) {
                    const trigger = vehicleTypeDropdown.querySelector('.hero-custom-dropdown-trigger');
                    const errorElement = document.getElementById('vehicle-type-error');
                    if (trigger) {
                        trigger.classList.add('border-red-500');
                        trigger.classList.remove('border-gray-300');
                        if (errorElement) {
                            errorElement.textContent = 'Araç tipi seçiniz.';
                            errorElement.classList.remove('hidden');
                        }
                        if (!firstErrorElement) {
                            firstErrorElement = trigger;
                        }
                    }
                }
            } else {
                // Clear vehicle type error if valid
                const vehicleTypeDropdown = form.querySelector('[data-dropdown="vehicle-type-request"]');
                if (vehicleTypeDropdown) {
                    const trigger = vehicleTypeDropdown.querySelector('.hero-custom-dropdown-trigger');
                    const errorElement = document.getElementById('vehicle-type-error');
                    if (trigger) {
                        trigger.classList.remove('border-red-500');
                        trigger.classList.add('border-gray-300');
                    }
                    if (errorElement) {
                        errorElement.classList.add('hidden');
                        errorElement.textContent = '';
                    }
                }
            }
            
            // Validate brand
            const brandValidation = validateBrand(brand);
            if (!brandValidation.valid) {
                hasErrors = true;
                errors.brand = brandValidation.message;
                if (brandInput && brandError) {
                    showError(brandInput, brandError, brandValidation.message);
                }
                if (!firstErrorElement && brandInput) {
                    firstErrorElement = brandInput;
                }
            }
            
            // Validate contact
            const contactValidation = validateContact(contact);
            if (!contactValidation.valid) {
                hasErrors = true;
                errors.contact = contactValidation.message;
                if (contactInput && contactError) {
                    showError(contactInput, contactError, contactValidation.message);
                }
                if (!firstErrorElement && contactInput) {
                    firstErrorElement = contactInput;
                }
            }
            
            // Validate model (optional)
            if (model && model.trim().length > 0) {
                const modelValidation = validateModel(model);
                if (!modelValidation.valid) {
                    hasErrors = true;
                    errors.model = modelValidation.message;
                    const modelInput = form.querySelector('[name="model"]');
                    if (modelInput) {
                        modelInput.classList.add('border-red-500');
                        modelInput.classList.remove('border-gray-300');
                        const modelError = document.createElement('p');
                        modelError.className = 'text-red-600 text-xs mt-2';
                        modelError.textContent = modelValidation.message;
                        modelInput.parentElement.appendChild(modelError);
                        if (!firstErrorElement) {
                            firstErrorElement = modelInput;
                        }
                    }
                }
            }
            
            // Validate city (optional)
            if (city && city.trim().length > 0) {
                const cityValidation = validateCity(city);
                if (!cityValidation.valid) {
                    hasErrors = true;
                    errors.city = cityValidation.message;
                    const cityInput = form.querySelector('[name="city"]');
                    if (cityInput) {
                        cityInput.classList.add('border-red-500');
                        cityInput.classList.remove('border-gray-300');
                        const cityError = document.createElement('p');
                        cityError.className = 'text-red-600 text-xs mt-2';
                        cityError.textContent = cityValidation.message;
                        cityInput.parentElement.appendChild(cityError);
                        if (!firstErrorElement) {
                            firstErrorElement = cityInput;
                        }
                    }
                }
            }
            
            // Validate kilometre (optional)
            if (kilometre && kilometre.trim().length > 0) {
                const kmValidation = validateKilometre(kilometre);
                if (!kmValidation.valid) {
                    hasErrors = true;
                    errors.kilometre = kmValidation.message;
                    const kmInput = form.querySelector('[name="kilometre"]');
                    if (kmInput) {
                        kmInput.classList.add('border-red-500');
                        kmInput.classList.remove('border-gray-300');
                        const kmError = document.createElement('p');
                        kmError.className = 'text-red-600 text-xs mt-2';
                        kmError.textContent = kmValidation.message;
                        kmInput.parentElement.appendChild(kmError);
                        if (!firstErrorElement) {
                            firstErrorElement = kmInput;
                        }
                    }
                }
            }
            
            if (hasErrors) {
                if (errorSummary) {
                    errorSummary.classList.remove('hidden');
                }
                if (firstErrorElement) {
                    firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        firstErrorElement.focus();
                    }, 100);
                }
                return false;
            }
            
            // Show loading state
            if (submitBtn) {
                submitBtn.disabled = true;
            }
            if (submitText) {
                submitText.textContent = 'Gönderiliyor...';
            }
            
            // Submit to backend (normal form submit, Laravel will handle it)
            // Remove preventDefault to allow normal form submission
            // But first ensure native selects are synced
            form.querySelectorAll('.hero-custom-dropdown-native').forEach(nativeSelect => {
                const dropdown = nativeSelect.closest('.hero-custom-dropdown');
                const trigger = dropdown.querySelector('.hero-custom-dropdown-trigger');
                if (trigger) {
                    const value = trigger.getAttribute('data-value');
                    if (value) {
                        nativeSelect.value = value;
                    }
                }
            });
            
            // Submit form normally (Laravel will handle validation and redirect)
            form.submit();
        });
    }
</script>
@endpush
