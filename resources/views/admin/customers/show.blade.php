@extends('admin.layouts.app')

@section('title', 'Müşteri Detayı - Admin Panel')
@section('page-title', 'Müşteri Detayı')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.customers.index') }}" class="hover:text-primary-600">Müşteriler</a>
    <span>/</span>
    <span>{{ $customer->name }}</span>
@endsection

@section('content')
@php
$badge = $sourceBadges[$customer->source] ?? ['label' => 'Bilinmiyor', 'class' => 'bg-gray-100 text-gray-800'];
@endphp

<div class="max-w-4xl mx-auto space-y-6">

    <!-- Müşteri Profili -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl font-bold text-primary-700">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $customer->name }}</h2>
                        <div class="flex flex-wrap items-center gap-2 mt-1">
                            <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                            @if($customer->kvkk_consent)
                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">KVKK Onaylı</span>
                            @endif
                            @if($customer->is_new)
                                <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Yeni</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.customers.edit', $customer->id) }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Düzenle
                    </a>
                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="inline"
                          onsubmit="return confirmDelete(this, '{{ addslashes($customer->name) }} müşterisini')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-semibold flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Sil
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- İletişim Bilgileri -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">İletişim Bilgileri</h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-primary-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400">E-posta</div>
                            <a href="mailto:{{ $customer->email }}" class="text-sm font-medium text-primary-600 hover:underline">{{ $customer->email }}</a>
                        </div>
                    </div>
                    @if($customer->phone)
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-green-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-400">Telefon (WhatsApp)</div>
                            <a href="{{ $customer->whatsapp_link }}" target="_blank" class="text-sm font-medium text-green-600 hover:underline">{{ $customer->phone }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Sistem Bilgileri</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Kayıt Tarihi</span>
                        <span class="font-medium text-gray-900">{{ $customer->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Son Güncelleme</span>
                        <span class="font-medium text-gray-900">{{ $customer->updated_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">IP Adresi</span>
                        <span class="font-mono text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-700">{{ $customer->ip_address ?? '-' }}</span>
                    </div>
                    @if($customer->consent_given_at)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Onay Tarihi</span>
                        <span class="font-medium text-gray-900">{{ $customer->consent_given_at->format('d.m.Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($customer->notes)
        <div class="px-6 pb-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Admin Notu</h3>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-sm text-gray-700">
                {{ $customer->notes }}
            </div>
        </div>
        @endif
    </div>

    <!-- KVKK & Sözleşme Onayları -->
    @if($customer->legal_consents)
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                Sözleşme Onayları
            </h2>
            <p class="text-sm text-gray-500 mt-1">Müşterinin onayladığı yasal belgeler ve versiyonları</p>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($customer->legal_consents as $slug => $consent)
            <div class="px-6 py-4 flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold text-gray-900">{{ $consent['title'] ?? $slug }}</div>
                    @if(isset($consent['version']))
                    <div class="text-xs text-gray-400">Versiyon: {{ $consent['version'] }}</div>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    @if(isset($consent['accepted_at']))
                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($consent['accepted_at'])->format('d.m.Y H:i') }}</span>
                    @endif
                    @if($consent['accepted'] ?? false)
                        <span class="flex items-center gap-1 text-green-600 text-sm font-medium">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Onaylandı
                        </span>
                    @else
                        <span class="flex items-center gap-1 text-red-500 text-sm font-medium">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Onaylanmadı
                        </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
