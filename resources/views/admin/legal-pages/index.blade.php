@extends('admin.layouts.app')

@section('title', 'Yasal Sayfalar - Admin Panel')
@section('page-title', 'Yasal Sayfalar')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Yasal Sayfalar</span>
@endsection

@section('content')
@php
    $totalPages   = \App\Models\LegalPage::count();
    $activePages  = \App\Models\LegalPage::where('is_active', true)->count();
    $formPages    = \App\Models\LegalPage::where('is_required_in_forms', true)->count();
    $requiredPages = \App\Models\LegalPage::where('is_required', true)->count();
@endphp

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-xl flex items-center gap-3 shadow-sm">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

<!-- İstatistik Kartları -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl p-6 border-2 border-primary-100 shadow-sm group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Toplam Sayfa</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalPages }}</p>
            </div>
            <div class="w-14 h-14 bg-primary-50 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Footer'da Aktif</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">{{ $activePages }}</p>
            </div>
            <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Formlarda Gösterilen</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $formPages }}</p>
            </div>
            <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Zorunlu Sayfa</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-red-600 transition-colors">{{ $requiredPages }}</p>
            </div>
            <div class="w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Ana İçerik -->
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    Yasal Sayfalar
                </h2>
                <p class="text-sm text-gray-600 mt-2">Değişiklikler footer, formlar ve tüm sayfalarda <span class="font-semibold text-primary-600">otomatik güncellenir</span></p>
            </div>
            <a href="{{ route('admin.settings.index') }}"
               class="inline-flex items-center px-4 py-2.5 bg-white text-gray-700 font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-primary-600 transition-all shadow-sm">
                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Ayarlar > Footer
            </a>
        </div>
    </div>

    <!-- Bilgi Notu -->
    <div class="px-6 py-4 bg-blue-50 border-b border-blue-100">
        <div class="flex items-center gap-3 text-sm text-blue-800">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Bu sayfa yalnızca <strong>mevcut sayfaların içeriklerini düzenlemek</strong> içindir. Yeni sayfa eklemek veya silmek için <a href="{{ route('admin.settings.index') }}" class="font-bold underline hover:text-blue-900">Ayarlar &rsaquo; Footer</a> bölümünü kullanın.</span>
        </div>
    </div>

    <!-- Tablo -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Sözleşme Adı</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">URL</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Footer</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Formlarda</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Versiyon</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Son Güncelleme</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">İşlemler</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pages as $page)
                <tr class="group hover:bg-gray-50 transition-all cursor-pointer"
                    onclick="window.location.href='{{ route('admin.legal-pages.edit', $page->id) }}'">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-primary-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $page->title }}</div>
                                @if($page->is_required)
                                <span class="text-xs font-bold text-red-500">Zorunlu</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5" onclick="event.stopPropagation()">
                        <a href="{{ route('legal.show', $page->slug) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 text-sm text-blue-600 hover:text-blue-800 hover:underline">
                            <span>/sayfa/{{ $page->slug }}</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @if($page->is_active)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                            Pasif
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        @if($page->is_required_in_forms)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                            Evet
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                            Hayır
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        <span class="text-sm font-semibold text-gray-600">v{{ $page->version }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="text-sm font-semibold text-gray-700">{{ $page->updated_at->format('d.m.Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $page->updated_at->format('H:i') }}</div>
                    </td>
                    <td class="px-6 py-5 text-right" onclick="event.stopPropagation()">
                        <a href="{{ route('admin.legal-pages.edit', $page->id) }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm font-semibold text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Düzenle
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-20 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Henüz Yasal Sayfa Yok</h3>
                        <p class="text-gray-500">Ayarlar &rsaquo; Footer bölümünden yasal sayfa ekleyebilirsiniz.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Kullanım Alanları -->
<div class="mt-6 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-3">
            <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            Bu Sözleşmeler Nerede Kullanılıyor?
        </h3>
    </div>
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
            <div class="w-9 h-9 bg-white rounded-lg border border-gray-200 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm">Footer</h4>
                <p class="text-sm text-gray-500 mt-0.5">Tüm yasal sayfalar footer'da otomatik listelenir</p>
            </div>
        </div>
        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
            <div class="w-9 h-9 bg-white rounded-lg border border-gray-200 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm">İletişim Formu</h4>
                <p class="text-sm text-gray-500 mt-0.5">KVKK Aydınlatma Metni modal ile gösterilir</p>
            </div>
        </div>
        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
            <div class="w-9 h-9 bg-white rounded-lg border border-gray-200 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm">Araç İsteği Formu</h4>
                <p class="text-sm text-gray-500 mt-0.5">KVKK ve Gizlilik Politikası modal ile gösterilir</p>
            </div>
        </div>
        <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
            <div class="w-9 h-9 bg-white rounded-lg border border-gray-200 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-sm">Araç Değerleme Formu</h4>
                <p class="text-sm text-gray-500 mt-0.5">KVKK ve Gizlilik Politikası modal ile gösterilir</p>
            </div>
        </div>
    </div>
</div>

@endsection
