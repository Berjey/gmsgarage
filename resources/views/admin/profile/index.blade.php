@extends('admin.layouts.app')

@section('title', 'Profilim - Admin Panel')
@section('page-title', 'Profilim')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Profilim</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Sol Taraf - Profil Kartı -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 p-6 text-center">
                <div class="w-24 h-24 mx-auto bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white font-bold text-4xl shadow-xl">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h3 class="text-xl font-bold text-white mt-4">{{ $user->name }}</h3>
                <p class="text-primary-100 text-sm mt-1">{{ $user->email }}</p>
                
                @php
                    $roleColors = [
                        'admin' => 'bg-red-100 text-red-700',
                        'manager' => 'bg-blue-100 text-blue-700',
                        'editor' => 'bg-green-100 text-green-700',
                    ];
                    $roleColor = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-700';
                @endphp
                <span class="inline-block mt-3 px-4 py-1.5 text-sm font-bold rounded-full {{ $roleColor }}">
                    {{ $user->role_name }}
                </span>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Üyelik Tarihi</span>
                    <span class="text-sm font-bold text-gray-900">{{ $user->created_at->format('d.m.Y') }}</span>
                </div>
                <div class="flex items-center justify-between py-3 border-b border-gray-100">
                    <span class="text-sm text-gray-600">Son Güncelleme</span>
                    <span class="text-sm font-bold text-gray-900">{{ $user->updated_at->format('d.m.Y H:i') }}</span>
                </div>
                <div class="flex items-center justify-between py-3">
                    <span class="text-sm text-gray-600">Hesap Durumu</span>
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">
                        Aktif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sağ Taraf - Bilgi Güncelleme Formları -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Kişisel Bilgiler -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Kişisel Bilgiler</h3>
                        <p class="text-sm text-gray-500">Ad ve e-posta bilgilerinizi güncelleyin</p>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('admin.profile.update-info') }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ad Soyad</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">E-posta Adresi</label>
                    <input type="email" value="{{ $user->email }}" readonly 
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                    <p class="mt-1 text-xs text-gray-500">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        E-posta adresiniz değiştirilemez
                    </p>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-bold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Bilgileri Güncelle
                    </button>
                </div>
            </form>
        </div>

        <!-- Şifre Değiştirme -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Şifre Değiştirme</h3>
                        <p class="text-sm text-gray-500">Hesabınızın güvenliği için güçlü bir şifre kullanın</p>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('admin.profile.update-password') }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mevcut Şifre</label>
                    <div class="relative">
                        <input type="password" id="current_password" name="current_password" required 
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                        <button type="button" onclick="togglePassword('current_password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" id="current_password_eye_open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg class="w-5 h-5 hidden" id="current_password_eye_closed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Yeni Şifre</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required 
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" id="password_eye_open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg class="w-5 h-5 hidden" id="password_eye_closed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    <p class="mt-1 text-xs text-gray-500">Minimum 8 karakter</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Yeni Şifre (Tekrar)</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                               class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors">
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" id="password_confirmation_eye_open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg class="w-5 h-5 hidden" id="password_confirmation_eye_closed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-bold transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Şifreyi Değiştir
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const eyeOpen = document.getElementById(inputId + '_eye_open');
    const eyeClosed = document.getElementById(inputId + '_eye_closed');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    } else {
        input.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    }
}
</script>
@endpush
