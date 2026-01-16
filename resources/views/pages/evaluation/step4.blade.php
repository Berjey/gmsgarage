@extends('layouts.app')

@section('title', 'Araç Değerleme - Adım 4 - GMSGARAGE')

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
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Kişisel Bilgiler</h1>
            <p class="text-primary-100">Değerleme sonucunu almak için iletişim bilgilerinizi girin</p>
        </div>
    </section>

    <!-- Step Indicator -->
    <section class="py-8 bg-white border-b border-gray-200">
        <div class="container-custom">
            <div class="step-indicator">
                <div class="step completed">✓</div>
                <div class="step-line active"></div>
                <div class="step completed">✓</div>
                <div class="step-line active"></div>
                <div class="step completed">✓</div>
                <div class="step-line active"></div>
                <div class="step active">4</div>
            </div>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-12 bg-gray-50">
        <div class="container-custom max-w-3xl">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">KİŞİSEL BİLGİLER</h2>
                
                <form method="POST" action="{{ route('evaluation.result') }}" class="space-y-6">
                    @csrf
                    @foreach($data as $key => $value)
                        @if(!in_array($key, ['ad', 'soyad', 'telefon', 'email', 'şehir']))
                            @if(is_array($value))
                                @foreach($value as $subKey => $subValue)
                                    <input type="hidden" name="{{ $key }}[{{ $subKey }}]" value="{{ $subValue }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endif
                    @endforeach
                    
                    <!-- Ad -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Adınız *</label>
                        <input type="text" name="ad" value="{{ old('ad') }}" 
                               required
                               class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold">
                    </div>
                    
                    <!-- Soyad -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Soyadınız *</label>
                        <input type="text" name="soyad" value="{{ old('soyad') }}" 
                               required
                               class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold">
                    </div>
                    
                    <!-- Telefon -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Mobil Telefon * <span class="text-gray-500 text-xs">(0 olmadan giriniz)</span></label>
                        <input type="tel" name="telefon" value="{{ old('telefon') }}" 
                               placeholder="5XX XXX XX XX"
                               pattern="[0-9]{10}"
                               required
                               class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold">
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">E-Posta *</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               required
                               class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold">
                    </div>
                    
                    <!-- Şehir -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Bulunduğunuz Şehir *</label>
                        <select name="şehir" class="w-full border-2 border-gray-300 rounded-xl px-5 py-4 focus:ring-2 focus:ring-primary-600 focus:border-primary-600 text-gray-900 font-semibold" required>
                            <option value="">Şehir Seçiniz</option>
                            @php
                                $cities = ['İstanbul', 'Ankara', 'İzmir', 'Bursa', 'Antalya', 'Adana', 'Gaziantep', 'Konya', 'Kayseri', 'Eskişehir', 'Diyarbakır', 'Samsun', 'Denizli', 'Şanlıurfa', 'Malatya', 'Kahramanmaraş', 'Erzurum', 'Van', 'Batman', 'Elazığ', 'Trabzon', 'Sivas', 'Mersin', 'Gebze', 'Balıkesir', 'Tarsus', 'Manisa', 'Kocaeli', 'Kütahya', 'Sakarya', 'Çorum', 'Aydın', 'Tekirdağ', 'Osmaniye', 'Muğla', 'Afyonkarahisar', 'Isparta', 'Edirne', 'Çanakkale', 'Ordu', 'Aksaray', 'Niğde', 'Nevşehir', 'Kırıkkale', 'Kırşehir', 'Kastamonu', 'Karaman', 'Karabük', 'Iğdır', 'Hakkari', 'Gümüşhane', 'Giresun', 'Hatay', 'Düzce', 'Çankırı', 'Burdur', 'Bolu', 'Bitlis', 'Bingöl', 'Bilecik', 'Bayburt', 'Bartın', 'Artvin', 'Ardahan', 'Amasya', 'Ağrı', 'Adıyaman'];
                            @endphp
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ old('şehir') == $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- KVKK Checkbox -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <input type="checkbox" name="kvkk" value="1" required class="mt-1 w-5 h-5 text-primary-600 focus:ring-primary-600 rounded">
                            <span class="text-sm text-gray-700">
                                * 6698 Sayılı Kanun düzenlenmesi uyarınca kişisel verilerimin nasıl korunacağına ve işleneceğine dair aydınlatma metni ile GMSGARAGE tarafından aydınlatıldım.
                                <br><br>
                                Lütfen Aydınlatma Metni'ni okuyup onaylayınız.
                            </span>
                        </label>
                    </div>
                    
                    <!-- Marketing Checkbox -->
                    <div>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" name="marketing" value="1" class="w-5 h-5 text-primary-600 focus:ring-primary-600 rounded">
                            <span class="text-sm text-gray-700">
                                Paylaşmış olduğum iletişim bilgilerime tercih ettiğim kanallardan özel kampanyalar için ileti göndermesini kabul ediyorum.
                            </span>
                        </label>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex justify-between space-x-4 pt-6">
                        <button type="button" onclick="window.history.back()" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200">
                            GERİ DÖN
                        </button>
                        <button type="submit" class="px-8 py-3 bg-primary-600 text-white rounded-xl font-bold hover:bg-primary-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            DEĞERLEMEYİ TAMAMLA
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
