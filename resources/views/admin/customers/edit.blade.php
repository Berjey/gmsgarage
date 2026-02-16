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
<div class="container mx-auto max-w-3xl">
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Müşteri Bilgilerini Düzenle</h2>
        
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Ad Soyad -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Ad Soyad <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name"
                       value="{{ old('name', $customer->name) }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- E-posta -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    E-posta <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       name="email" 
                       id="email"
                       value="{{ old('email', $customer->email) }}"
                       required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Telefon -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                    Telefon
                </label>
                <input type="tel" 
                       name="phone" 
                       id="phone"
                       value="{{ old('phone', $customer->phone) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600 mb-1">Kaynak</div>
                    <div class="font-semibold text-gray-900">{{ $customer->source_name }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600 mb-1">Kayıt Tarihi</div>
                    <div class="font-semibold text-gray-900">{{ $customer->created_at->format('d.m.Y H:i') }}</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600 mb-1">KVKK Onayı</div>
                    <div class="font-semibold {{ $customer->kvkk_consent ? 'text-green-600' : 'text-red-600' }}">
                        {{ $customer->kvkk_consent ? '✓ Onaylı' : '✗ Onaysız' }}
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600 mb-1">IP Adresi</div>
                    <div class="font-semibold text-gray-900">{{ $customer->ip_address ?? 'Bilinmiyor' }}</div>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.customers.index') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    İptal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    Kaydet
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
