@extends('layouts.app')

@section('title', 'Araç Değerleme - Adım 3 - GMSGARAGE')

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
    .expertise-table {
        @apply w-full border-collapse;
    }
    .expertise-table th,
    .expertise-table td {
        @apply border border-gray-300 p-3 text-center;
    }
    .expertise-table th {
        @apply bg-gray-100 font-bold text-sm;
    }
    .expertise-radio {
        @apply w-4 h-4 text-primary-600 focus:ring-primary-600;
    }
</style>
@endpush

@section('content')
    <!-- Page Header -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-700 text-white py-12">
        <div class="container-custom">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Ekspertiz Durumu</h1>
            <p class="text-primary-100">Aracınızın ekspertiz durumunu belirtin</p>
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
                <div class="step active">3</div>
                <div class="step-line"></div>
                <div class="step inactive">4</div>
            </div>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-12 bg-gray-50">
        <div class="container-custom max-w-5xl">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Ekspertiz Tanımları</h2>
                <p class="text-gray-600 mb-6">Araçta yapılan işlem türünü seçin.</p>
                
                <form method="POST" action="{{ route('evaluation.step4') }}" class="space-y-6">
                    @csrf
                    @foreach($data as $key => $value)
                        @if($key != 'ekspertiz')
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    
                    <!-- Expertise Table -->
                    <div class="overflow-x-auto">
                        <table class="expertise-table">
                            <thead>
                                <tr>
                                    <th>Bölge</th>
                                    <th>Orijinal</th>
                                    <th>Lokal Boyalı</th>
                                    <th>Boyalı</th>
                                    <th>Onarım</th>
                                    <th>Değişen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $regions = [
                                        'Sol Ön Çamurluk', 'Sol Ön Kapı', 'Sol Arka Çamurluk', 'Sol Arka Kapı',
                                        'Sağ Ön Çamurluk', 'Sağ Ön Kapı', 'Sağ Arka Çamurluk', 'Sağ Arka Kapı',
                                        'Ön Tampon', 'Kaput', 'Tavan', 'Bagaj Havuzu',
                                        'Bagaj', 'Arka Tampon', 'Ön Panel', 'Sağ Şasi', 'Sol Şasi'
                                    ];
                                    $conditions = ['Orijinal', 'Lokal Boyalı', 'Boyalı', 'Onarım', 'Değişen'];
                                @endphp
                                @foreach($regions as $region)
                                    <tr>
                                        <td class="font-semibold text-left">{{ $region }}</td>
                                        @foreach($conditions as $condition)
                                            <td>
                                                <input type="radio" 
                                                       name="ekspertiz[{{ str_replace(' ', '_', $region) }}]" 
                                                       value="{{ $condition }}"
                                                       class="expertise-radio"
                                                       {{ old("ekspertiz.{$region}", '') == $condition ? 'checked' : '' }}>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex justify-between space-x-4 pt-6">
                        <button type="button" onclick="window.history.back()" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all duration-200">
                            GERİ DÖN
                        </button>
                        <button type="submit" class="px-8 py-3 bg-primary-600 text-white rounded-xl font-bold hover:bg-primary-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            DEVAM
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
