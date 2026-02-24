@extends('admin.layouts.app')

@section('title', 'Değerleme İsteği Detayı - Admin Panel')
@section('page-title', 'Değerleme İsteği Detayı')
@section('content')
@php
    $extra = json_decode($request->message, true) ?? [];
    $ekspertiz = $extra['ekspertiz'] ?? [];
    $tramerLabels = ['YOK'=>'Yok','VAR'=>'Var','BILMIYORUM'=>'Bilinmiyor','AGIR_HASAR'=>'Ağır Hasar Kayıtlı'];
    $tramerVal    = $extra['tramer'] ?? 'YOK';
    $colorMap = [
        'ORIJINAL'     => ['fill' => '#FFFFFF', 'bg' => 'bg-green-100',  'text' => 'text-green-800',  'label' => 'Orijinal'],
        'BOYALI'       => ['fill' => '#3b82f6', 'bg' => 'bg-blue-100',   'text' => 'text-blue-800',   'label' => 'Boyalı'],
        'LOKAL_BOYALI' => ['fill' => '#fbbf24', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Lokal Boyalı'],
        'DEGISMIS'     => ['fill' => '#dc2626', 'bg' => 'bg-red-100',    'text' => 'text-red-800',    'label' => 'Değişmiş'],
    ];
    $partToSvg = [
        'sag_arka_camurluk' => 'svg-sag_arka_camurluk',
        'arka_kaput'        => 'svg-arka_kaput',
        'sol_arka_camurluk' => 'svg-sol_arka_camurluk',
        'sag_arka_kapi'     => 'svg-sag_arka_kapi',
        'sag_on_kapi'       => 'svg-sag_on_kapi',
        'tavan'             => 'svg-tavan',
        'sol_arka_kapi'     => 'svg-sol_arka_kapi',
        'sol_on_kapi'       => 'svg-sol_on_kapi',
        'sag_on_camurluk'   => 'svg-sag_on_camurluk',
        'motor_kaputu'      => 'svg-motor_kaputu',
        'sol_on_camurluk'   => 'svg-sol_on_camurluk',
        'on_tampon'         => 'svg-on_tampon',
        'arka_tampon'       => 'svg-arka_tampon',
    ];
    $partLabels = [
        'sag_arka_camurluk' => 'Sağ Arka Çamurluk',
        'arka_kaput'        => 'Arka Kaput',
        'sol_arka_camurluk' => 'Sol Arka Çamurluk',
        'sag_arka_kapi'     => 'Sağ Arka Kapı',
        'sag_on_kapi'       => 'Sağ Ön Kapı',
        'tavan'             => 'Tavan',
        'sol_arka_kapi'     => 'Sol Arka Kapı',
        'sol_on_kapi'       => 'Sol Ön Kapı',
        'sag_on_camurluk'   => 'Sağ Ön Çamurluk',
        'motor_kaputu'      => 'Motor Kaputu',
        'sol_on_camurluk'   => 'Sol Ön Çamurluk',
        'on_tampon'         => 'Ön Tampon',
        'arka_tampon'       => 'Arka Tampon',
    ];
@endphp

<div class="max-w-7xl mx-auto space-y-6">

    {{-- Breadcrumb & Navigation --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
        <nav class="flex items-center space-x-2 text-sm text-gray-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600 transition-colors flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Panel
            </a>
            <span>/</span>
            <a href="{{ route('admin.evaluation-requests.index') }}" class="hover:text-primary-600 transition-colors">Değerleme İstekleri</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">İstek Detayı</span>
        </nav>
        <div class="flex items-center gap-2">
            @if(!$request->is_read)
            <form action="{{ route('admin.evaluation-requests.read', $request->id) }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Okundu İşaretle
                </button>
            </form>
            @else
            <form action="{{ route('admin.evaluation-requests.read', $request->id) }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-primary-600 transition-all shadow-sm text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/></svg>
                    Okunmamış İşaretle
                </button>
            </form>
            @endif
            <form action="{{ route('admin.evaluation-requests.destroy', $request->id) }}" method="POST"
                  onsubmit="return confirm('Bu isteği silmek istediğinize emin misiniz?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 font-bold rounded-xl border border-red-100 hover:bg-red-600 hover:text-white transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Sil
                </button>
            </form>
        </div>
    </div>

    {{-- İstatistik Satırı --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Araç --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Araç</p>
                    <p class="text-sm font-bold text-gray-900 truncate leading-tight mt-0.5">{{ $request->brand }} {{ $request->model }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $request->year }}</p>
                </div>
            </div>
        </div>
        {{-- Kilometre --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Kilometre</p>
                    <p class="text-base font-bold text-blue-600 leading-tight mt-0.5">{{ number_format($request->mileage, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">km</p>
                </div>
            </div>
        </div>
        {{-- Tramer --}}
        @php
            $hasHasar = in_array($tramerVal, ['VAR','AGIR_HASAR']);
            $tramerIconBg  = $hasHasar ? 'bg-red-50'    : 'bg-green-50';
            $tramerIconClr = $hasHasar ? 'text-red-500' : 'text-green-600';
            $tramerTextClr = $hasHasar ? 'text-red-600' : 'text-green-700';
        @endphp
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 {{ $tramerIconBg }} rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 {{ $tramerIconClr }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Tramer / Hasar</p>
                    <p class="text-sm font-bold {{ $tramerTextClr }} leading-tight mt-0.5">{{ $tramerLabels[$tramerVal] ?? '-' }}</p>
                    @if(!empty($extra['tramer_tutari']))<p class="text-xs text-gray-400 mt-0.5">{{ number_format($extra['tramer_tutari'],0,',','.') }} TL</p>@endif
                </div>
            </div>
        </div>
        {{-- Tarih --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Talep Tarihi</p>
                    <p class="text-sm font-bold text-gray-900 leading-tight mt-0.5">{{ $request->created_at->format('d.m.Y') }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $request->created_at->format('H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Ana İçerik: 3 kolon grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- SOL KOLON (col-span-2): Araç Bilgileri + Ekspertiz --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Araç Bilgileri --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3 bg-gray-50/30">
                    <div class="p-2 bg-primary-50 text-primary-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">Araç Bilgileri</h2>
                </div>
                <div class="p-8 space-y-6">
                    <dl class="grid grid-cols-2 sm:grid-cols-3 gap-x-8 gap-y-6">
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">MARKA / MODEL</dt>
                            <dd class="text-base font-bold text-gray-900">{{ $request->brand }} {{ $request->model }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">YIL</dt>
                            <dd class="text-base font-bold text-gray-900">{{ $request->year }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">KİLOMETRE</dt>
                            <dd class="text-base font-bold text-primary-600">{{ number_format($request->mileage, 0, ',', '.') }} KM</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">YAKIT / VİTES</dt>
                            <dd class="text-sm font-bold text-gray-900">{{ $request->fuel_type }} / {{ $request->transmission }}</dd>
                        </div>
                        @if(!empty($extra['govde_tipi']))
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">GÖVDE TİPİ</dt>
                            <dd class="text-sm font-bold text-gray-900">{{ $extra['govde_tipi'] }}</dd>
                        </div>
                        @endif
                        @if(!empty($extra['renk']))
                        <div>
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">RENK</dt>
                            <dd class="text-sm font-bold text-gray-900">{{ $extra['renk'] }}</dd>
                        </div>
                        @endif
                        @if($request->version)
                        <div class="col-span-2 sm:col-span-3">
                            <dt class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">VERSİYON</dt>
                            <dd class="text-sm font-bold text-gray-900">{{ $request->version }}</dd>
                        </div>
                        @endif
                    </dl>

                    @if(!empty($extra['not']))
                    <div class="relative pl-6 border-l-2 border-primary-500">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">KULLANICI NOTU</label>
                        <p class="text-gray-700 leading-relaxed">{{ $extra['not'] }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-6 pt-6 border-t border-gray-50">
                        @php
                            $hasHasar = in_array($tramerVal, ['VAR','AGIR_HASAR']);
                            $tramerBadgeCls = $hasHasar ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700';
                        @endphp
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">TRAMER / HASAR</p>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $tramerBadgeCls }}">{{ $tramerLabels[$tramerVal] ?? '-' }}</span>
                            @if(!empty($extra['tramer_tutari']))<p class="text-xs text-gray-400 mt-1">{{ number_format($extra['tramer_tutari'],0,',','.') }} TL</p>@endif
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">TALEP TARİHİ</p>
                            <p class="text-sm font-bold text-gray-900">{{ $request->created_at->format('d.m.Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $request->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ekspertiz Durumu --}}
            @if(!empty($ekspertiz))
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3 bg-gray-50/30">
                    <div class="p-2 bg-primary-50 text-primary-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">Ekspertiz Durumu</h2>
                </div>
                <div class="p-6">
                    <div class="flex gap-6 items-start">

                    {{-- Sol: SVG + Renk Açıklaması --}}
                    <div class="flex-shrink-0 w-36">
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-2">
                        <svg id="admin-car-diagram" width="100%" viewBox="0 0 227 303" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Nakit-Sat" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="DD-Nakitsat-03.1" transform="translate(-1002.000000, -232.000000)"><g transform="translate(1003.000000, 233.000000)"><path d="M94.6557611,63.8442042 C92.939813,65.0732963 91.7141357,66.9764066 91.5098562,69.1967019 L91.0195853,74.5491997 C90.7744499,77.3245689 92.8581012,79.7431049 95.7180147,79.9809937 C98.5779282,80.2188824 101.070139,78.1968277 101.315274,75.4214586 L102.05068,67.3332398 C105.482577,68.6416281 109.118752,69.3156463 112.83664,69.3156463 L127.340487,69.3156463 C130.322968,69.3156463 132.815179,67.0160547 132.978602,64.1217411 C133.632297,50.6017284 134,36.4869936 134,21.8171851 C134,21.6982407 134,21.6189444 134,21.5 C134,6.71124703 133.632297,-7.52243211 132.978602,-21.1217411 C132.856035,-24.0160547 130.363824,-26.3156463 127.340487,-26.3156463 L112.877496,-26.3156463 C109.159608,-26.3156463 105.523432,-25.6416281 102.091536,-24.3332398 L101.35613,-32.4214586 C101.110994,-35.1968277 98.5779282,-37.2188824 95.7588706,-36.9809937 C92.8989571,-36.7431049 90.8153058,-34.2849207 91.0604412,-31.5491997 L91.5507121,-26.1967019 C91.7549917,-23.9764066 92.939813,-22.0732963 94.696617,-20.8442042 L94.696617,63.8442042 L94.6557611,63.8442042 Z" stroke="#D3D2D2" fill="#F0F0F0" transform="translate(112.500000, 21.500000) rotate(-90.000000) translate(-112.500000, -21.500000) "></path> <path d="M98,60.0833333 C101.017241,61.3211806 104.195402,62 107.454023,62 L120.166667,62 C122.781609,62 124.954023,59.8038194 125.074713,57.0086806 C125.637931,43.9913194 126,30.4149306 126,16.3194444 C126,16.2395833 126,16.1197917 126,16 C126,1.78472222 125.678161,-11.9114583 125.074713,-25.0086806 C124.954023,-27.8038194 122.781609,-30 120.166667,-30 L107.454023,-30 C104.195402,-30 101.017241,-29.3611111 98,-28.0833333 L98,60.0833333 Z" id="svg-on_tampon" fill="#FFFFFF" fill-rule="nonzero" title="Ön tampon" transform="translate(112.000000, 16.000000) rotate(-90.000000) translate(-112.000000, -16.000000) " class="car-part"><title>Ön tampon</title></path> <path d="M209.370189,124.39232 C207.52386,121.065414 204.674093,118.460007 201.182124,116.936845 C199.014696,115.974848 196.646579,115.49385 194.278462,115.49385 L151.010162,115.49385 C150.970024,115.293434 150.929887,115.173184 150.889749,115.093018 C150.408098,113.529773 148.762458,108.359041 144.668426,106.555297 C143.183336,105.873883 142.059484,105.994132 141.818658,106.034216 C141.658108,106.034216 140.694806,106.154465 140.213156,106.555297 C138.48724,107.958209 142.139759,112.968609 144.146637,115.49385 L89.0778914,115.49385 C87.3519759,115.49385 85.5859228,115.293434 83.9001449,114.852519 C82.2143669,114.411604 80.4483139,114.211188 78.7223983,114.211188 L37.501114,114.211188 C35.1329973,114.211188 32.8050183,114.652103 30.5974519,115.49385 C22.7304882,118.540173 15.0240748,123.310073 13.4587095,131.607295 C11.8532067,139.9446 11.5722437,148.72282 11.5722437,156.979958 C11.5722437,163.914351 11.7729316,171.16941 12.7763708,178.264136 L9.36467738,178.264136 C8.88302654,178.264136 8.04013757,178.264136 8,180.94971 C8,183.595201 9.04357682,183.635284 10.6892172,183.635284 L13.6995349,183.635284 C15.7866886,191.170925 23.0917263,195.62016 30.5573143,198.50615 C32.7648807,199.347897 35.0928598,199.788812 37.4609764,199.788812 L78.6822608,199.788812 C80.4483139,199.788812 82.1742294,199.588396 83.8600073,199.147481 C85.5457852,198.706566 87.3118383,198.50615 89.0377538,198.50615 L144.1065,198.50615 C142.099621,201.031391 138.447103,206.041791 140.173018,207.444703 C140.654669,207.845535 141.617971,207.965784 141.778521,207.965784 C142.019346,208.005868 143.143198,208.126117 144.628288,207.444703 C148.682183,205.640959 150.327823,200.470227 150.849612,198.906982 C150.889749,198.826816 150.929887,198.666483 150.970024,198.50615 L194.238325,198.50615 C196.606441,198.50615 198.974558,198.025152 201.141987,197.063155 C204.593818,195.539993 207.483723,192.934586 209.330051,189.60768 C212.862157,183.154286 217.999766,171.369826 217.999766,156.979958 C218.039904,142.630174 212.902295,130.845714 209.370189,124.39232 Z" id="Shape" stroke="#D3D2D2" fill="#F0F0F0" fill-rule="nonzero" transform="translate(113.000000, 157.000000) rotate(-90.000000) translate(-113.000000, -157.000000) "></path> <path d="M40.1953541,165.054383 L121.473933,165.054383 C121.995722,165.054383 122.116134,165.77588 121.594346,165.936213 L100.441847,172.068942 C98.6757936,172.590024 96.8294654,172.830523 94.9831372,172.830523 L59.5015253,172.830523 C56.6918954,172.830523 53.9224031,172.229275 51.3937362,171.066862 L39.9946663,165.89613 C39.553153,165.695714 39.7137033,165.054383 40.1953541,165.054383 Z" id="Path" stroke="#D3D2D2" fill="#D3D2D2" fill-rule="nonzero" transform="translate(80.833235, 168.942453) rotate(-90.000000) translate(-80.833235, -168.942453) "></path> <path d="M185.83574,172.858799 L104.55716,172.858799 C104.07551,172.858799 103.914959,172.217468 104.356473,171.976969 L115.755542,166.806236 C118.284209,165.643823 121.053702,165.042575 123.863332,165.042575 L159.344943,165.042575 C161.191272,165.042575 163.0376,165.323158 164.803653,165.804156 L185.956152,171.936885 C186.437803,172.097218 186.357528,172.858799 185.83574,172.858799 Z" id="Path" stroke="#D3D2D2" fill="#D3D2D2" fill-rule="nonzero" transform="translate(145.186807, 168.950687) rotate(-90.000000) translate(-145.186807, -168.950687) "></path> <path d="M106.499636,243.096992 C105.014546,234.559271 104.171657,225.01947 104.171657,214.998671 C104.171657,204.977872 105.014546,195.438071 106.499636,186.90035 C106.740462,185.537522 108.185414,184.816024 109.429679,185.377189 L120.668199,190.78842 C121.47095,191.189252 121.952601,192.031 121.832188,192.91283 C120.949162,199.286058 120.427373,206.861782 120.427373,214.958588 C120.427373,223.055394 120.949162,230.631118 121.832188,237.004346 C121.952601,237.886176 121.47095,238.768007 120.668199,239.128756 L109.429679,244.539987 C108.185414,245.221401 106.740462,244.459821 106.499636,243.096992 Z" id="Path" stroke="#D3D2D2" fill="#D3D2D2" fill-rule="nonzero" transform="translate(113.011099, 214.989729) rotate(-90.000000) translate(-113.011099, -214.989729) "></path> <g id="Group-4" transform="translate(162.000000, 52.000000)" stroke="#D3D2D2"><path d="M129.900636,106.906489 C125.403559,103.580153 120.22389,101.375954 114.682849,100.454198 L79.5494364,94.5629771 L62.1634161,84.6641221 C47.6282213,76.3683206 31.1657078,72 14.4221271,72 L-2.16084382,72 C-6.81853055,72.1603053 -12.3194192,72.6412214 -18.3824424,73.9236641 C-18.8642721,74.0438931 -19.3461018,74.1240458 -19.8279314,74.2442748 C-28.7016277,76.2480916 -37.1336468,79.8549618 -44.8830739,84.7041985 C-46.9710024,85.9866412 -49.0187785,87.3091603 -51.106707,88.5916031 C-51.5483842,88.8320611 -52.0703663,88.9522901 -52.552196,88.9522901 L-61.7872645,88.9522901 C-64.3971752,88.9522901 -66.9267809,89.7538168 -69.0548619,91.1965649 C-69.6973015,91.6374046 -69.9382163,92.398855 -69.7374539,93.120229 C-68.4525748,98.0896947 -71.704925,102.898855 -71.5041627,107.868321 C-71.4238577,110.753817 -72.7890418,113.479008 -71.3034003,115.923664 C-70.6609608,116.604962 -69.9783688,117.326336 -69.3359292,118.007634 C-67.8502878,119.570611 -66.6055611,121.293893 -65.6419018,123.217557 C-65.0797672,124.259542 -64.2767178,125.501908 -63.0319911,126.624046 C-60.1811656,129.188931 -56.9689679,129.549618 -55.9250036,129.629771 L-53.5560078,130.110687 C-52.3915861,130.351145 -51.3074694,129.389313 -51.3877743,128.227099 C-51.4279268,127.706107 -51.4680792,127.185115 -51.4680792,126.624046 C-51.4680792,116.604962 -43.276975,108.469466 -33.1987045,108.549618 C-23.1605866,108.629771 -15.0899397,117.246183 -15.2103972,127.265267 C-15.2505496,129.269084 -15.3308546,131.112595 -15.6119219,132.916031 C-15.7725318,133.998092 -14.9293299,135 -13.8050606,135 L74.6106823,135 C75.6546466,135 76.4978485,134.118321 76.4175436,133.076336 C76.2569337,130.992366 76.2167812,128.98855 76.2167812,126.664122 C76.2167812,116.725191 84.2472756,108.669847 94.1649361,108.589695 C104.564426,108.509542 112.755531,117.326336 112.434311,127.666031 C112.394158,129.509542 112.193396,131.232824 112.032786,132.916031 C111.912329,134.038168 112.835836,134.959924 113.960105,134.879771 L129.900636,133.998092 C131.667345,133.917939 132.912071,132.314885 132.631004,130.591603 L132.309784,128.708015 L134.598475,120.171756 C134.879543,119.169847 135,118.208015 135,117.206107 C135,109.551527 129.900636,106.906489 129.900636,106.906489 Z" id="Shape" fill="#F0F0F0" transform="translate(31.500000, 103.500000) rotate(-90.000000) translate(-31.500000, -103.500000) "></path> <path d="M13.0500284,141.698113 L13.0875754,141.773585 C14.8898297,144.792453 17.1801946,147.471698 19.8835762,149.698113 C21.2728139,150.830189 22.4743168,152.113208 23.4505379,153.471698 C24.426759,154.792453 24.9524165,155.886792 25.515621,157.018868 C26.0037316,157.962264 26.4918421,158.981132 27.2803284,160.226415 C28.0688147,161.433962 28.9323949,162.603774 29.8710691,163.698113 C31.072572,165.09434 32.6119976,165.924528 34.0763292,165.962264 C36.0287715,166 38.732153,166 42.1489269,166 C46.5794688,166 51.0851047,165.962264 53,165.962264 L53,146.113208 C53,140.45283 52.4743425,134.792453 51.4230274,129.245283 L48.9449277,116 L38.2815894,116 C29.7208812,116 21.19772,118.113208 13.6132329,122.075472 L9.93363022,124 C8.13137587,124.943396 6.81723206,126.490566 6.14138668,128.415094 C5.87855792,129.169811 5.99119881,130 6.40421544,130.716981 L13.0500284,141.698113 Z" id="svg-sol_arka_kapi" fill="#FFFFFF" fill-rule="nonzero" title="Sol arka kapı" transform="translate(29.500000, 141.000000) rotate(-90.000000) translate(-29.500000, -141.000000) " class="car-part"><title>Sol arka kapı</title></path> <path d="M6.98512508,98.1209373 L6.98512508,118 L52.6260859,118 C53.3028053,118 53.9043336,117.508692 54.0171202,116.82842 L54.2426933,115.505669 C55.671323,106.435374 55.0697947,97.0249433 52.5132994,88.2191988 C51.6110069,85.1579743 49.6184444,82.5502646 46.9115669,80.8873772 C34.3170679,73.2532124 19.9555794,68.8692366 5.33092222,68.1133787 L3,68 L5.40611326,80.8495843 C6.45878781,86.5185185 6.98512508,92.3386243 6.98512508,98.1209373 Z" id="svg-sol_on_kapi" fill="#FFFFFF" fill-rule="nonzero" title="Sol ön kapı" transform="translate(29.000000, 93.000000) rotate(-90.000000) translate(-29.000000, -93.000000) " class="car-part"><title>Sol ön kapı</title></path> <path d="M-5.55787695,144.094347 C-4.80693763,142.622649 -3.64298169,141.415102 -2.21619699,140.584913 L0.261902751,139.150951 C6.75752784,135.377366 14.0791862,133.33963 21.5885793,133.188687 L29.62363,133.037743 C30.8251329,133.000008 31.876448,133.905668 32.0266358,135.075479 L33.9415311,147.679253 C34.054172,148.320762 33.5660614,148.8868 32.890216,148.8868 L0.787560273,148.8868 C-1.35261678,148.8868 -3.38015293,148.132083 -5.03221943,146.773592 C-5.78315874,146.132083 -6.00844054,145.000008 -5.55787695,144.094347 Z" id="Path" fill="#D3D2D2" fill-rule="nonzero" transform="translate(14.084337, 140.961703) rotate(-90.000000) translate(-14.084337, -140.961703) "></path> <path d="M-4.12304309,84.2625682 L1.47868934,85.0184261 C14.185975,86.7191064 26.3293278,91.3298396 36.9688599,98.4726967 L37.269624,98.6616612 C37.194433,98.6616612 37.119242,98.6616612 37.0816464,98.6616612 L31.2919364,98.6616612 C29.524947,98.6616612 28.0963172,100.097791 28.0963172,101.874057 L28.0963172,101.91185 C28.0963172,103.499152 29.3745649,104.78411 30.9535767,104.78411 L36.7432868,104.78411 C37.119242,104.78411 37.4951972,104.708524 37.8335568,104.557353 C38.0215344,104.481767 38.2471075,104.557353 38.3222986,104.746317 C38.3974896,104.935282 38.3222986,105.162039 38.134321,105.237625 C37.6831748,105.426589 37.2320285,105.502175 36.7432868,105.502175 L30.9535767,105.502175 C28.9986097,105.502175 27.3820024,103.914874 27.3820024,101.91185 L27.3820024,101.874057 L0.426014786,100.400134 C-0.927423921,100.324549 -2.05528951,99.3797262 -2.39364919,98.0569749 L-5.43888628,85.774284 C-5.70205492,84.9428404 -4.98774004,84.1491896 -4.12304309,84.2625682 Z" id="Path" fill="#D3D2D2" fill-rule="nonzero" transform="translate(16.428437, 94.876946) rotate(-90.000000) translate(-16.428437, -94.876946) "></path> <path d="M13.9131056,168.010844 C13.9131056,168.010844 19.0519095,166.400737 26.9577617,167.205791 L31.4640974,166.964275 C31.4640974,166.964275 39.2118326,160.765362 41.5835882,161.006878 C43.9553439,161.288647 48.066387,167.970592 48.066387,167.970592 L57,184.071663 C56.8814122,183.8704 44.2320487,181.253976 38.3817181,185.238991 C33.3219727,188.700721 29.4085759,194.175086 28.7365784,199.971471 L28.064581,203.996739 C28.064581,203.996739 20.2377873,204.318761 17.7079146,198.562628 C15.1780419,192.806494 12.2133473,190.753608 12.2133473,190.753608 C12.2133473,190.753608 11.4227621,181.978524 12.8853448,179.804879 C14.3083982,177.671487 13.9131056,168.010844 13.9131056,168.010844 Z" id="svg-sol_arka_camurluk" fill="#FFFFFF" fill-rule="nonzero" title="Sol arka çamurluk" transform="translate(34.500000, 182.500000) rotate(-90.000000) translate(-34.500000, -182.500000) " class="car-part"><title>Sol arka çamurluk</title></path> <path d="M14.5326799,52 L57.1956592,45.0528587 C57.1956592,45.0528587 69.2385483,41.6170442 70.4922245,38.3700108 C71.7459006,35.1229773 72.3917338,32.9708738 71.7459006,30.592233 C71.1000675,28.2135922 69.4664894,22.5124056 69.4664894,22.5124056 C69.4664894,22.5124056 72.1258025,17.7551241 68.972617,17.7551241 C65.8194316,17.7551241 56.1727324,17 56.1727324,17 C56.1727324,17 58.0345528,41.9848751 35.6936697,42.3173455 C15.1854438,42.6225429 15.7176067,20.2847896 15.7176067,20.2847896 L11,20.2847896 C11,20.2847896 15.5968126,38.1434736 11,52 L14.5326799,52 Z" id="svg-sol_on_camurluk" fill="#FFFFFF" fill-rule="nonzero" title="Sol ön çamurluk" transform="translate(41.500000, 34.500000) scale(-1, 1) rotate(-90.000000) translate(-41.500000, -34.500000) " class="car-part"><title>Sol ön çamurluk</title></path></g> <g id="Group-4-Copy" transform="translate(31.525480, 155.500000) scale(-1, 1) translate(-31.525480, -155.500000) translate(0.025480, 52.000000)" stroke="#D3D2D2"><path d="M129.900636,106.906489 C125.403559,103.580153 120.22389,101.375954 114.682849,100.454198 L79.5494364,94.5629771 L62.1634161,84.6641221 C47.6282213,76.3683206 31.1657078,72 14.4221271,72 L-2.16084382,72 C-6.81853055,72.1603053 -12.3194192,72.6412214 -18.3824424,73.9236641 C-18.8642721,74.0438931 -19.3461018,74.1240458 -19.8279314,74.2442748 C-28.7016277,76.2480916 -37.1336468,79.8549618 -44.8830739,84.7041985 C-46.9710024,85.9866412 -49.0187785,87.3091603 -51.106707,88.5916031 C-51.5483842,88.8320611 -52.0703663,88.9522901 -52.552196,88.9522901 L-61.7872645,88.9522901 C-64.3971752,88.9522901 -66.9267809,89.7538168 -69.0548619,91.1965649 C-69.6973015,91.6374046 -69.9382163,92.398855 -69.7374539,93.120229 C-68.4525748,98.0896947 -71.704925,102.898855 -71.5041627,107.868321 C-71.4238577,110.753817 -72.7890418,113.479008 -71.3034003,115.923664 C-70.6609608,116.604962 -69.9783688,117.326336 -69.3359292,118.007634 C-67.8502878,119.570611 -66.6055611,121.293893 -65.6419018,123.217557 C-65.0797672,124.259542 -64.2767178,125.501908 -63.0319911,126.624046 C-60.1811656,129.188931 -56.9689679,129.549618 -55.9250036,129.629771 L-53.5560078,130.110687 C-52.3915861,130.351145 -51.3074694,129.389313 -51.3877743,128.227099 C-51.4279268,127.706107 -51.4680792,127.185115 -51.4680792,126.624046 C-51.4680792,116.604962 -43.276975,108.469466 -33.1987045,108.549618 C-23.1605866,108.629771 -15.0899397,117.246183 -15.2103972,127.265267 C-15.2505496,129.269084 -15.3308546,131.112595 -15.6119219,132.916031 C-15.7725318,133.998092 -14.9293299,135 -13.8050606,135 L74.6106823,135 C75.6546466,135 76.4978485,134.118321 76.4175436,133.076336 C76.2569337,130.992366 76.2167812,128.98855 76.2167812,126.664122 C76.2167812,116.725191 84.2472756,108.669847 94.1649361,108.589695 C104.564426,108.509542 112.755531,117.326336 112.434311,127.666031 C112.394158,129.509542 112.193396,131.232824 112.032786,132.916031 C111.912329,134.038168 112.835836,134.959924 113.960105,134.879771 L129.900636,133.998092 C131.667345,133.917939 132.912071,132.314885 132.631004,130.591603 L132.309784,128.708015 L134.598475,120.171756 C134.879543,119.169847 135,118.208015 135,117.206107 C135,109.551527 129.900636,106.906489 129.900636,106.906489 Z" id="Shape" fill="#F0F0F0" transform="translate(31.500000, 103.500000) rotate(-90.000000) translate(-31.500000, -103.500000) "></path> <path d="M13.0500284,141.698113 L13.0875754,141.773585 C14.8898297,144.792453 17.1801946,147.471698 19.8835762,149.698113 C21.2728139,150.830189 22.4743168,152.113208 23.4505379,153.471698 C24.426759,154.792453 24.9524165,155.886792 25.515621,157.018868 C26.0037316,157.962264 26.4918421,158.981132 27.2803284,160.226415 C28.0688147,161.433962 28.9323949,162.603774 29.8710691,163.698113 C31.072572,165.09434 32.6119976,165.924528 34.0763292,165.962264 C36.0287715,166 38.732153,166 42.1489269,166 C46.5794688,166 51.0851047,165.962264 53,165.962264 L53,146.113208 C53,140.45283 52.4743425,134.792453 51.4230274,129.245283 L48.9449277,116 L38.2815894,116 C29.7208812,116 21.19772,118.113208 13.6132329,122.075472 L9.93363022,124 C8.13137587,124.943396 6.81723206,126.490566 6.14138668,128.415094 C5.87855792,129.169811 5.99119881,130 6.40421544,130.716981 L13.0500284,141.698113 Z" id="svg-sag_arka_kapi" fill="#FFFFFF" fill-rule="nonzero" title="Sağ arka kapı" transform="translate(29.500000, 141.000000) rotate(-90.000000) translate(-29.500000, -141.000000) " class="car-part"><title>Sağ arka kapı</title></path> <path d="M6.98512508,98.1209373 L6.98512508,118 L52.6260859,118 C53.3028053,118 53.9043336,117.508692 54.0171202,116.82842 L54.2426933,115.505669 C55.671323,106.435374 55.0697947,97.0249433 52.5132994,88.2191988 C51.6110069,85.1579743 49.6184444,82.5502646 46.9115669,80.8873772 C34.3170679,73.2532124 19.9555794,68.8692366 5.33092222,68.1133787 L3,68 L5.40611326,80.8495843 C6.45878781,86.5185185 6.98512508,92.3386243 6.98512508,98.1209373 Z" id="svg-sag_on_kapi" fill="#FFFFFF" fill-rule="nonzero" title="Sağ ön kapı" transform="translate(29.000000, 93.000000) rotate(-90.000000) translate(-29.000000, -93.000000) " class="car-part"><title>Sağ ön kapı</title></path> <path d="M-5.55787695,144.094347 C-4.80693763,142.622649 -3.64298169,141.415102 -2.21619699,140.584913 L0.261902751,139.150951 C6.75752784,135.377366 14.0791862,133.33963 21.5885793,133.188687 L29.62363,133.037743 C30.8251329,133.000008 31.876448,133.905668 32.0266358,135.075479 L33.9415311,147.679253 C34.054172,148.320762 33.5660614,148.8868 32.890216,148.8868 L0.787560273,148.8868 C-1.35261678,148.8868 -3.38015293,148.132083 -5.03221943,146.773592 C-5.78315874,146.132083 -6.00844054,145.000008 -5.55787695,144.094347 Z" id="Path" fill="#D3D2D2" fill-rule="nonzero" transform="translate(14.084337, 140.961703) rotate(-90.000000) translate(-14.084337, -140.961703) "></path> <path d="M-4.12304309,84.2625682 L1.47868934,85.0184261 C14.185975,86.7191064 26.3293278,91.3298396 36.9688599,98.4726967 L37.269624,98.6616612 C37.194433,98.6616612 37.119242,98.6616612 37.0816464,98.6616612 L31.2919364,98.6616612 C29.524947,98.6616612 28.0963172,100.097791 28.0963172,101.874057 L28.0963172,101.91185 C28.0963172,103.499152 29.3745649,104.78411 30.9535767,104.78411 L36.7432868,104.78411 C37.119242,104.78411 37.4951972,104.708524 37.8335568,104.557353 C38.0215344,104.481767 38.2471075,104.557353 38.3222986,104.746317 C38.3974896,104.935282 38.3222986,105.162039 38.134321,105.237625 C37.6831748,105.426589 37.2320285,105.502175 36.7432868,105.502175 L30.9535767,105.502175 C28.9986097,105.502175 27.3820024,103.914874 27.3820024,101.91185 L27.3820024,101.874057 L0.426014786,100.400134 C-0.927423921,100.324549 -2.05528951,99.3797262 -2.39364919,98.0569749 L-5.43888628,85.774284 C-5.70205492,84.9428404 -4.98774004,84.1491896 -4.12304309,84.2625682 Z" id="Path" fill="#D3D2D2" fill-rule="nonzero" transform="translate(16.428437, 94.876946) rotate(-90.000000) translate(-16.428437, -94.876946) "></path> <path d="M13.9131056,168.010844 C13.9131056,168.010844 19.0519095,166.400737 26.9577617,167.205791 L31.4640974,166.964275 C31.4640974,166.964275 39.2118326,160.765362 41.5835882,161.006878 C43.9553439,161.288647 48.066387,167.970592 48.066387,167.970592 L57,184.071663 C56.8814122,183.8704 44.2320487,181.253976 38.3817181,185.238991 C33.3219727,188.700721 29.4085759,194.175086 28.7365784,199.971471 L28.064581,203.996739 C28.064581,203.996739 20.2377873,204.318761 17.7079146,198.562628 C15.1780419,192.806494 12.2133473,190.753608 12.2133473,190.753608 C12.2133473,190.753608 11.4227621,181.978524 12.8853448,179.804879 C14.3083982,177.671487 13.9131056,168.010844 13.9131056,168.010844 Z" id="svg-sag_arka_camurluk" fill="#FFFFFF" fill-rule="nonzero" title="Sağ arka çamurluk" transform="translate(34.500000, 182.500000) rotate(-90.000000) translate(-34.500000, -182.500000) " class="car-part"><title>Sağ arka çamurluk</title></path> <path d="M14.5326799,52 L57.1956592,45.0528587 C57.1956592,45.0528587 69.2385483,41.6170442 70.4922245,38.3700108 C71.7459006,35.1229773 72.3917338,32.9708738 71.7459006,30.592233 C71.1000675,28.2135922 69.4664894,22.5124056 69.4664894,22.5124056 C69.4664894,22.5124056 72.1258025,17.7551241 68.972617,17.7551241 C65.8194316,17.7551241 56.1727324,17 56.1727324,17 C56.1727324,17 58.0345528,41.9848751 35.6936697,42.3173455 C15.1854438,42.6225429 15.7176067,20.2847896 15.7176067,20.2847896 L11,20.2847896 C11,20.2847896 15.5968126,38.1434736 11,52 L14.5326799,52 Z" id="svg-sag_on_camurluk" fill="#FFFFFF" fill-rule="nonzero" title="Sağ ön çamurluk" transform="translate(41.500000, 34.500000) scale(-1, 1) rotate(-90.000000) translate(-41.500000, -34.500000) " class="car-part"><title>Sağ ön çamurluk</title></path></g> <path d="M125.268608,160.858908 C124.706682,162.863068 122.619528,164.02548 120.61265,163.464316 L99.2594625,157.451836 C97.3328592,156.890671 96.1688696,154.966678 96.6103829,153.002601 C98.0553354,146.388874 98.8580868,138.732983 98.8580868,130.556011 C98.8580868,122.379039 98.0553354,114.723149 96.6103829,108.109421 C96.2090072,106.145345 97.3328592,104.221351 99.2594625,103.660186 L120.61265,97.6477069 C122.619528,97.0865422 124.706682,98.2489549 125.268608,100.253115 C127.957825,109.512333 129.442915,119.733548 129.442915,130.556011 C129.442915,141.378474 127.957825,151.639773 125.268608,160.858908 Z" id="Path" stroke="#D3D2D2" fill="#D3D2D2" fill-rule="nonzero" transform="translate(112.979958, 130.556011) rotate(-90.000000) translate(-112.979958, -130.556011) "></path> <g><path d="M83,55 C83,55 94.8944481,86.4 83,122 L125.907825,122 C125.907825,122 142.312584,115.72 140.915585,88.88 C139.518586,62.04 125.907825,55 125.907825,55 L83,55 Z" id="svg-motor_kaputu" stroke="#D3D2D2" fill="#FFFFFF" fill-rule="nonzero" title="Motor kaputu" transform="translate(112.000000, 88.500000) rotate(-90.000000) translate(-112.000000, -88.500000) " class="car-part"><title>Motor kaputu</title></path></g> <g><path d="M126,205.023942 L106.684058,205.023942 C106.684058,205.023942 98,204.012393 98,215.139427 C98,226.26646 98,266.161932 98,266.161932 C98,266.161932 99.3797101,273 104.857971,273 C110.336232,273 126,273 126,273 C126,273 119.101449,243.665094 126,205.023942 Z" id="svg-arka_kaput" stroke="#D3D2D2" fill="#FFFFFF" fill-rule="nonzero" title="Arka kaput" transform="translate(112.000000, 239.000000) rotate(-90.000000) translate(-112.000000, -239.000000) " class="car-part"><title>Arka kaput</title></path></g> <g><path d="M87.1085905,151 C87.1085905,151 78.5117927,172.53629 86.188933,200 L136.890047,200 C136.890047,200 143.887441,175.104839 136.890047,151 L87.1085905,151 Z" id="svg-tavan" stroke="#D3D2D2" fill="#FFFFFF" fill-rule="nonzero" title="Tavan" transform="translate(111.500000, 175.500000) rotate(-90.000000) translate(-111.500000, -175.500000) " class="car-part"><title>Tavan</title></path></g> <path d="M90.9813007,21.7212413 C90.9813007,21.7212413 91.0226055,16.000759 88.7921464,13.000506 C86.5616874,10.000253 78.3420328,7 78.3420328,7 C78.3420328,7 75.9463545,24.2814572 83.8355708,28.9218485 C91.724787,33.5622398 90.9813007,21.7212413 90.9813007,21.7212413 Z" id="Shape" fill="#D3D2D2" fill-rule="nonzero" transform="translate(84.500000, 18.500000) rotate(-90.000000) translate(-84.500000, -18.500000) "></path> <path d="M149.981301,15.2787587 C149.981301,15.2787587 150.022605,20.999241 147.792146,23.999494 C145.561687,26.999747 137.342033,30 137.342033,30 C137.342033,30 134.946355,12.7185428 142.835571,8.0781515 C150.724787,3.43776021 149.981301,15.2787587 149.981301,15.2787587 Z" id="Shape" fill="#D3D2D2" fill-rule="nonzero" transform="translate(143.500000, 18.500000) rotate(-90.000000) translate(-143.500000, -18.500000) "></path> <path d="M127.5,239.49005 C124.170077,238.176617 120.641944,237.5 117.034527,237.5 L102.961637,237.5 C100.067775,237.5 97.6496164,239.808458 97.4910486,242.71393 C96.8567775,256.28607 96.5,270.455224 96.5,285.181592 C96.5,285.300995 96.5,285.380597 96.5,285.5 C96.5,300.345771 96.8567775,314.634328 97.4910486,328.28607 C97.6099744,331.191542 100.028133,333.5 102.961637,333.5 L117.034527,333.5 C120.641944,333.5 124.170077,332.823383 127.5,331.50995 L127.5,239.49005 Z" id="Shape" stroke="#D3D2D2" fill="#D8D8D8" title="Arka tampon" transform="translate(112.000000, 285.500000) rotate(-90.000000) translate(-112.000000, -285.500000) "></path> <path d="M126,241.916667 C122.982759,240.678819 119.804598,240 116.545977,240 L103.833333,240 C101.218391,240 99.045977,242.196181 98.9252874,244.991319 C98.362069,258.008681 98,271.585069 98,285.680556 C98,285.760417 98,285.880208 98,286 C98,300.215278 98.3218391,313.911458 98.9252874,327.008681 C99.045977,329.803819 101.218391,332 103.833333,332 L116.545977,332 C119.804598,332 122.982759,331.361111 126,330.083333 L126,241.916667 Z" id="svg-arka_tampon" fill="#FFFFFF" fill-rule="nonzero" title="Arka tampon" transform="translate(112.000000, 286.000000) rotate(-90.000000) translate(-112.000000, -286.000000) " class="car-part"><title>Arka tampon</title></path> <path d="M90.4887892,298 L87.5112108,298 C86.1479821,298 85,296.735391 85,295.144432 L85,263.855568 C85,262.264609 86.1479821,261 87.5112108,261 L90.4887892,261 C91.8520179,261 93,262.264609 93,263.855568 L93,295.144432 C93,296.735391 91.8520179,298 90.4887892,298 Z" id="Shape" fill="#D3D2D2" fill-rule="nonzero" transform="translate(89.000000, 279.500000) rotate(-90.000000) translate(-89.000000, -279.500000) "></path> <path d="M138.488789,298 L135.511211,298 C134.147982,298 133,296.735391 133,295.144432 L133,263.855568 C133,262.264609 134.147982,261 135.511211,261 L138.488789,261 C139.852018,261 141,262.264609 141,263.855568 L141,295.144432 C141,296.735391 139.852018,298 138.488789,298 Z" id="Shape" fill="#D3D2D2" fill-rule="nonzero" transform="translate(137.000000, 279.500000) rotate(-90.000000) translate(-137.000000, -279.500000) "></path></g></g></g></svg>
                        </div>
                        {{-- Legend --}}
                        <div class="mt-3 space-y-1.5">
                            <div class="flex items-center gap-2 text-xs text-gray-400"><span class="w-3 h-3 rounded-sm bg-white border border-gray-300 flex-shrink-0"></span>Orijinal</div>
                            <div class="flex items-center gap-2 text-xs text-gray-400"><span class="w-3 h-3 rounded-sm bg-blue-400 flex-shrink-0"></span>Boyalı</div>
                            <div class="flex items-center gap-2 text-xs text-gray-400"><span class="w-3 h-3 rounded-sm bg-yellow-400 flex-shrink-0"></span>Lokal Boyalı</div>
                            <div class="flex items-center gap-2 text-xs text-gray-400"><span class="w-3 h-3 rounded-sm bg-red-500 flex-shrink-0"></span>Değişmiş</div>
                        </div>
                    </div>

                    {{-- Sağ: Parça Listesi --}}
                    <div class="flex-1 grid grid-cols-2 gap-x-4 gap-y-0">
                        @foreach($ekspertiz as $partKey => $partVal)
                        @php $c = $colorMap[$partVal] ?? ['bg'=>'bg-gray-100','text'=>'text-gray-600','fill'=>'#FFFFFF','label'=>$partVal]; @endphp
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50 gap-2">
                            <span class="text-xs text-gray-500 truncate">{{ $partLabels[$partKey] ?? $partKey }}</span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full flex-shrink-0 {{ $c['bg'] }} {{ $c['text'] }}">{{ $c['label'] }}</span>
                        </div>
                        @endforeach
                    </div>

                    </div>{{-- /flex --}}
                </div>
            </div>
            @endif

        </div>{{-- /Sol Kolon --}}

        {{-- SAĞ SIDEBAR: Hızlı İşlemler + İletişim Bilgileri --}}
        <div class="space-y-6">

            {{-- Hızlı İşlemler --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/30">
                    <h2 class="text-lg font-bold text-gray-900">Hızlı İşlemler</h2>
                </div>
                <div class="p-6 space-y-3">
                    @if($request->is_read)
                    <form method="POST" action="{{ route('admin.evaluation-requests.read', $request->id) }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-primary-600 transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
                            Okunmamış İşaretle
                        </button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.evaluation-requests.read', $request->id) }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Okundu İşaretle
                        </button>
                    </form>
                    @endif

                    <form method="POST" action="{{ route('admin.evaluation-requests.destroy', $request->id) }}"
                          onsubmit="return confirm('Bu isteği silmek istediğinize emin misiniz?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-600 font-bold rounded-xl border border-red-100 hover:bg-red-600 hover:text-white transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            İsteği Sil
                        </button>
                    </form>
                </div>
            </div>

            {{-- İletişim Bilgileri --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/30">
                    <h2 class="text-lg font-bold text-gray-900">Müşteri Bilgileri</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary-50 text-primary-600 rounded-full flex items-center justify-center text-xl font-bold flex-shrink-0">
                            {{ strtoupper(substr($request->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">AD SOYAD</p>
                            <p class="text-base font-bold text-gray-900">{{ $request->name }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">TELEFON</p>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $request->phone) }}" class="text-sm font-bold text-primary-600 hover:underline">{{ $request->phone }}</a>
                            </div>
                        </div>

                        @if($request->email)
                        <div class="flex items-start gap-3">
                            <div class="mt-1 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">E-POSTA</p>
                                <a href="mailto:{{ $request->email }}" class="text-sm font-bold text-primary-600 hover:underline break-all">{{ $request->email }}</a>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-start gap-3">
                            <div class="mt-1 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">TALEP TARİHİ</p>
                                <p class="text-sm font-bold text-gray-900">{{ $request->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-4 border-t border-gray-50">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $request->phone) }}"
                           class="flex items-center justify-center gap-2 px-4 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            Ara
                        </a>
                        <a href="https://wa.me/90{{ preg_replace('/[^0-9]/', '', ltrim($request->phone, '0')) }}" target="_blank"
                           class="flex items-center justify-center gap-2 px-4 py-3 text-white font-bold rounded-xl transition-all" style="background:#25D366;">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>

        </div>{{-- /Sidebar --}}

    </div>{{-- /Ana Grid --}}

</div>

@push('scripts')
<script>
// Araç SVG parçalarını ekspertiz verisine göre renklendir
(function() {
    const ekspertiz = @json($ekspertiz);
    const colorMap = {
        'ORIJINAL':     '#FFFFFF',
        'BOYALI':       '#3b82f6',
        'LOKAL_BOYALI': '#fbbf24',
        'DEGISMIS':     '#dc2626',
    };
    const partToSvg = {
        'sag_arka_camurluk': 'svg-sag_arka_camurluk',
        'arka_kaput':        'svg-arka_kaput',
        'sol_arka_camurluk': 'svg-sol_arka_camurluk',
        'sag_arka_kapi':     'svg-sag_arka_kapi',
        'sag_on_kapi':       'svg-sag_on_kapi',
        'tavan':             'svg-tavan',
        'sol_arka_kapi':     'svg-sol_arka_kapi',
        'sol_on_kapi':       'svg-sol_on_kapi',
        'sag_on_camurluk':   'svg-sag_on_camurluk',
        'motor_kaputu':      'svg-motor_kaputu',
        'sol_on_camurluk':   'svg-sol_on_camurluk',
        'on_tampon':         'svg-on_tampon',
        'arka_tampon':       'svg-arka_tampon',
    };
    Object.entries(ekspertiz).forEach(([partKey, val]) => {
        const svgId = partToSvg[partKey];
        if (!svgId) return;
        const el = document.getElementById(svgId);
        if (!el) return;
        el.style.fill = colorMap[val] || '#FFFFFF';
    });
})();
</script>
@endpush
@endsection
