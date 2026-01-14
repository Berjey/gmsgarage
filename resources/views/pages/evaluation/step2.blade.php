@extends('layouts.app')

@section('title', 'Araç Değerleme - Adım 2 - GMSGARAGE')

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
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Araç Detayları</h1>
            <p class="text-primary-100">Aracınız hakkında daha fazla bilgi verin</p>
        </div>
    </section>

    <!-- Step Indicator -->
    <section class="py-8 bg-white border-b border-gray-200">
        <div class="container-custom">
            <div class="step-indicator">
                <div class="step completed">✓</div>
                <div class="step-line active"></div>
                <div class="step active">2</div>
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
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Donanım ve Detaylar</h2>
                
                <form method="POST" action="{{ route('evaluation.step3') }}" class="space-y-6">
                    @csrf
                    @foreach($data as $key => $value)
                        @if(!in_array($key, ['donanım_paketi', 'kilometre', 'renk', 'tramer']))
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    
                    <!-- Donanım Paketi -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Donanım Paketi</label>
                        <select name="donanım_paketi" class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold">
                            <option value="">Seçiniz</option>
                            <option value="Standart" {{ old('donanım_paketi') == 'Standart' ? 'selected' : '' }}>Standart</option>
                            <option value="Confort" {{ old('donanım_paketi') == 'Confort' ? 'selected' : '' }}>Confort</option>
                            <option value="Premium" {{ old('donanım_paketi') == 'Premium' ? 'selected' : '' }}>Premium</option>
                            <option value="Luxury" {{ old('donanım_paketi') == 'Luxury' ? 'selected' : '' }}>Luxury</option>
                        </select>
                    </div>
                    
                    <!-- Kilometre -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Kilometre * <span class="text-gray-500 text-xs">(Minimum 1 Km olmalıdır.)</span></label>
                        <input type="number" name="kilometre" value="{{ old('kilometre') }}" 
                               placeholder="Örn: 50000"
                               min="1"
                               required
                               class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold">
                    </div>
                    
                    <!-- Renk -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Araç Rengi</label>
                        <select name="renk" class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold">
                            <option value="">Renk Seçin</option>
                            @php
                                $colors = ['Beyaz', 'Siyah', 'Gri', 'Gümüş', 'Mavi', 'Kırmızı', 'Yeşil', 'Kahverengi', 'Bej', 'Lacivert', 'Bordo', 'Turuncu', 'Sarı', 'Mor', 'Pembe', 'DİĞER'];
                            @endphp
                            @foreach($colors as $color)
                                <option value="{{ $color }}" {{ old('renk') == $color ? 'selected' : '' }}>{{ $color }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Tramer -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Tramer Hasar Kaydı (TL)</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="tramer" value="Yok" class="peer hidden" {{ old('tramer', 'Yok') == 'Yok' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-300 rounded-xl p-4 text-center font-semibold transition-all duration-200 peer-checked:border-primary-600 peer-checked:bg-primary-50 peer-checked:text-primary-700 hover:border-primary-400">
                                    Yok
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="tramer" value="Var" class="peer hidden" {{ old('tramer') == 'Var' ? 'checked' : '' }}>
                                <div class="border-2 border-gray-300 rounded-xl p-4 text-center font-semibold transition-all duration-200 peer-checked:border-primary-600 peer-checked:bg-primary-50 peer-checked:text-primary-700 hover:border-primary-400">
                                    Var
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex justify-between space-x-4 pt-6">
                        <a href="{{ route('evaluation.index') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200">
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
