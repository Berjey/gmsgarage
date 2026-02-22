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
                    <div class="relative">
                        <input type="password" name="password" id="password" 
                               class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        <button type="button" 
                                onclick="togglePassword('password', 'password-icon')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors p-1.5 hover:bg-gray-100 rounded-lg">
                            <svg id="password-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Şifre Tekrar</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        <button type="button" 
                                onclick="togglePassword('password_confirmation', 'password-confirmation-icon')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors p-1.5 hover:bg-gray-100 rounded-lg">
                            <svg id="password-confirmation-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
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

<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        // Göz kapalı ikonu
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        `;
    } else {
        input.type = 'password';
        // Göz açık ikonu
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}
</script>
@endsection
