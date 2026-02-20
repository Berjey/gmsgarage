@extends('admin.layouts.app')

@section('title', 'Kullanıcı Düzenle - Admin Panel')
@section('page-title', 'Kullanıcı Düzenle')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.users.index') }}" class="hover:text-primary-600">Kullanıcılar</a>
    <span>/</span>
    <span>Düzenle</span>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ad Soyad</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">E-posta</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Yeni Şifre (Değiştirmek istemiyorsanız boş bırakın)</label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Şifre Tekrar</label>
                    <input type="password" name="password_confirmation" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Kullanıcı Rolü
                    <span class="text-red-500">*</span>
                </label>
                @php $currentRole = old('role', $user->role); @endphp
                <div class="adm-dd" data-adm-dd>
                    <input type="hidden" name="role" value="{{ $currentRole }}" id="role-input">
                    <button type="button" class="adm-dd-btn" data-adm-trigger>
                        <span data-adm-label>
                            @if($currentRole == 'admin') 🔴 Süper Yönetici
                            @elseif($currentRole == 'manager') 🔵 Galeri Yöneticisi
                            @elseif($currentRole == 'editor') 🟢 İçerik Editörü
                            @else Rol seçiniz...
                            @endif
                        </span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <ul class="adm-dd-list" data-adm-list>
                        <li data-value="admin"   class="{{ $currentRole == 'admin'   ? 'selected' : '' }}">🔴 Süper Yönetici</li>
                        <li data-value="manager" class="{{ $currentRole == 'manager' ? 'selected' : '' }}">🔵 Galeri Yöneticisi</li>
                        <li data-value="editor"  class="{{ $currentRole == 'editor'  ? 'selected' : '' }}">🟢 İçerik Editörü</li>
                    </ul>
                </div>
                @error('role')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                
                <!-- Rol Açıklamaları -->
                <div class="mt-3 space-y-2">
                    <div class="flex items-start gap-2 p-3 bg-red-50 rounded-lg border border-red-100">
                        <span class="text-lg">🔴</span>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-red-900">Süper Yönetici</p>
                            <p class="text-xs text-red-700">Tüm bölümlere erişim (Ayarlar, Kullanıcılar, Araçlar, Blog, vb.)</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2 p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <span class="text-lg">🔵</span>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-blue-900">Galeri Yöneticisi</p>
                            <p class="text-xs text-blue-700">Araçlar, Mesajlar, Blog yönetimi</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-2 p-3 bg-green-50 rounded-lg border border-green-100">
                        <span class="text-lg">🟢</span>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-green-900">İçerik Editörü</p>
                            <p class="text-xs text-green-700">Sadece Blog içeriklerini yönetebilir</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    İptal
                </a>
                <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-bold transition-colors">
                    Güncelle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
