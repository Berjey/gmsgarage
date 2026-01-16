@extends('layouts.app')

@section('title', 'Aracımı Değerle - GMSGARAGE')
@section('description', 'Aracınızın değerini öğrenin. Hızlı ve güvenilir araç değerleme hizmeti.')

@push('styles')
<style>
    .step-indicator {
        @apply flex items-center justify-center space-x-2 mb-8;
    }
    .step {
        @apply w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300;
    }
    .step.active {
        @apply bg-primary-600 text-white shadow-lg scale-110;
    }
    .step.completed {
        @apply bg-green-500 text-white;
    }
    .step.inactive {
        @apply bg-gray-200 text-gray-500;
    }
    .step-line {
        @apply w-16 h-1 bg-gray-200;
    }
    .step-line.active {
        @apply bg-primary-600;
    }
</style>
@endpush

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-12">
        <div class="container-custom">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Aracımı Değerle</h1>
            <p class="text-primary-100">Aracınızın değerini öğrenmek için birkaç basit adımı tamamlayın</p>
        </div>
    </section>

    <!-- Step Indicator -->
    <section class="py-8 bg-white border-b border-gray-200">
        <div class="container-custom">
            <div class="step-indicator">
                <div class="step active">1</div>
                <div class="step-line"></div>
                <div class="step inactive">2</div>
                <div class="step-line"></div>
                <div class="step inactive">3</div>
                <div class="step-line"></div>
                <div class="step inactive">4</div>
            </div>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-12 bg-gray-50">
        <div class="container-custom max-w-3xl">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Araç Bilgileri</h2>
                
                <form method="POST" action="{{ route('evaluation.step2') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Araç Tipi -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Araç Tipi *</label>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="tip" value="AUTO" class="peer hidden" {{ old('tip', $selectedTip ?? 'AUTO') == 'AUTO' ? 'checked' : '' }} required>
                                <div class="border-2 border-gray-300 rounded-xl p-4 text-center font-semibold transition-all duration-200 peer-checked:border-primary-600 peer-checked:bg-primary-50 peer-checked:text-primary-700 hover:border-primary-400">
                                    OTOMOBİL
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="tip" value="SUV" class="peer hidden" {{ old('tip', $selectedTip ?? '') == 'SUV' ? 'checked' : '' }} required>
                                <div class="border-2 border-gray-300 rounded-xl p-4 text-center font-semibold transition-all duration-200 peer-checked:border-primary-600 peer-checked:bg-primary-50 peer-checked:text-primary-700 hover:border-primary-400">
                                    SUV
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="tip" value="TICARI" class="peer hidden" {{ old('tip', $selectedTip ?? '') == 'TICARI' ? 'checked' : '' }} required>
                                <div class="border-2 border-gray-300 rounded-xl p-4 text-center font-semibold transition-all duration-200 peer-checked:border-primary-600 peer-checked:bg-primary-50 peer-checked:text-primary-700 hover:border-primary-400">
                                    TİCARİ
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Model Yılı -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Model Yılı *</label>
                        <select name="yil" class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold" required>
                            <option value="">Seçiniz</option>
                            @for($year = date('Y') + 1; $year >= 1990; $year--)
                                <option value="{{ $year }}" {{ old('yil', $selectedYil ?? '') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <!-- Marka -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Marka *</label>
                        <select name="marka" id="marka" class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold" required>
                            <option value="">Marka Seçin</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ old('marka', $selectedMarka ?? '') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Model -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Model</label>
                        <input type="text" name="model" value="{{ old('model') }}" 
                               placeholder="Model adı (opsiyonel)"
                               class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold">
                    </div>
                    
                    <!-- Gövde Tipi -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Gövde Tipi</label>
                        <select name="gövde_tipi" class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold">
                            <option value="">Seçiniz</option>
                            @foreach($bodyTypes as $bodyType)
                                <option value="{{ $bodyType }}" {{ old('gövde_tipi') == $bodyType ? 'selected' : '' }}>{{ $bodyType }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Yakıt Tipi -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Yakıt Tipi</label>
                        <select name="yakıt_tipi" class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold">
                            <option value="">Seçiniz</option>
                            <option value="Benzin" {{ old('yakıt_tipi') == 'Benzin' ? 'selected' : '' }}>Benzin</option>
                            <option value="Dizel" {{ old('yakıt_tipi') == 'Dizel' ? 'selected' : '' }}>Dizel</option>
                            <option value="Hybrid" {{ old('yakıt_tipi') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                            <option value="Elektrik" {{ old('yakıt_tipi') == 'Elektrik' ? 'selected' : '' }}>Elektrik</option>
                        </select>
                    </div>
                    
                    <!-- Vites Tipi -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Vites Tipi</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="vites_tipi" value="Manuel" class="peer hidden" {{ old('vites_tipi') == 'Manuel' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-300 rounded-xl p-4 text-center font-semibold transition-all duration-200 peer-checked:border-primary-600 peer-checked:bg-primary-50 peer-checked:text-primary-700 hover:border-primary-400">
                                    Manuel
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="vites_tipi" value="Otomatik" class="peer hidden" {{ old('vites_tipi') == 'Otomatik' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-300 rounded-xl p-4 text-center font-semibold transition-all duration-200 peer-checked:border-primary-600 peer-checked:bg-primary-50 peer-checked:text-primary-700 hover:border-primary-400">
                                    Otomatik
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('home') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200">
                            GERİ DÖN
                        </a>
                        <button type="submit" class="px-8 py-3 bg-primary-600 text-white rounded-xl font-bold hover:bg-primary-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            DEVAM
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
