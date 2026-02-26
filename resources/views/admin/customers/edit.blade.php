@extends('admin.layouts.app')

@section('title', 'Müşteri Düzenle - Admin Panel')
@section('page-title', 'Müşteri Düzenle')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.customers.index') }}" class="hover:text-primary-600">Müşteriler</a>
    <span>/</span>
    <span>Düzenle</span>
@endsection

@section('content')
@php
$badge = $sourceBadges[$customer->source] ?? ['label' => 'Bilinmiyor', 'class' => 'bg-gray-100 text-gray-800'];
@endphp

<div class="max-w-4xl mx-auto space-y-6">

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                <span class="text-xl font-bold text-primary-700">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $customer->name }}</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                    <span class="text-xs text-gray-400">{{ $customer->created_at->format('d.m.Y H:i') }} tarihinde eklendi</span>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Ad Soyad <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $customer->name) }}" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-400 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Telefon</label>
                    <input type="tel" name="phone" id="phone"
                           value="{{ old('phone', $customer->phone) }}"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-400 @enderror">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    E-posta <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email"
                       value="{{ old('email', $customer->email) }}" required
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Admin Notu</label>
                <textarea name="notes" id="notes" rows="3"
                          class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                          placeholder="Bu müşteri hakkında dahili not ekleyin...">{{ old('notes', $customer->notes) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Bu not sadece admin panelinde görünür.</p>
            </div>

            <!-- Salt okunur bilgiler -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-2 border-t border-gray-100">
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="text-xs text-gray-500 mb-1">Kaynak</div>
                    <div class="font-semibold text-gray-900 text-sm">{{ $badge['label'] }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="text-xs text-gray-500 mb-1">KVKK Onayı</div>
                    <div class="font-semibold text-sm {{ $customer->kvkk_consent ? 'text-green-600' : 'text-red-500' }}">
                        {{ $customer->kvkk_consent ? '✓ Onaylı' : '✗ Onaysız' }}
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="text-xs text-gray-500 mb-1">IP Adresi</div>
                    <div class="font-semibold text-gray-900 text-sm">{{ $customer->ip_address ?? '-' }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="text-xs text-gray-500 mb-1">Kayıt Tarihi</div>
                    <div class="font-semibold text-gray-900 text-sm">{{ $customer->created_at->format('d.m.Y H:i') }}</div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <a href="{{ route('admin.customers.show', $customer->id) }}"
                   class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Detayları Görüntüle
                </a>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.customers.index') }}"
                       class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        İptal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-semibold">
                        Kaydet
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
