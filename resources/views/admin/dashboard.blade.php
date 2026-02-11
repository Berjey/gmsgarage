@extends('admin.layouts.app')

@section('title', 'Anasayfa - Admin Panel')
@section('page-title', 'Anasayfa')

@push('styles')
<style>
    /* Minimal & Clean Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .stat-card {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
        transition: all 0.3s ease;
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.1s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.2s; }
    .stat-card:nth-child(5) { animation-delay: 0.25s; }
    .stat-card:nth-child(6) { animation-delay: 0.3s; }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(220, 38, 38, 0.2);
    }
</style>
@endpush

@section('content')
<!-- Page Header - Corporate Style -->
<div class="mb-8 bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl p-6 shadow-lg text-white">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-3 mb-2">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">Anasayfa</h1>
                    <p class="text-primary-100 text-sm mt-0.5">Hoş Geldiniz, {{ auth()->user()->name }}</p>
                </div>
            </div>
        </div>
        <div class="hidden lg:block text-right">
            <div class="bg-white/10 backdrop-blur-sm rounded-lg px-4 py-2">
                <p class="text-sm font-semibold">{{ now()->translatedFormat('d F Y') }}</p>
                <p class="text-xs text-primary-100">{{ now()->translatedFormat('l') }}</p>
            </div>
        </div>
    </div>
</div>
<!-- Stats Grid - Clean & Minimal -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Total Vehicles -->
    <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-600 mb-2">Toplam Araç</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_vehicles'] }}</p>
            </div>
            <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Vehicles -->
    <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-600 mb-2">Aktif Araçlar</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['active_vehicles'] }}</p>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Featured Vehicles -->
    <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-600 mb-2">Öne Çıkan Araçlar</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['featured_vehicles'] }}</p>
            </div>
            <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Blog Posts -->
    <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-600 mb-2">Blog Yazıları</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['published_blog_posts'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Toplam: {{ $stats['total_blog_posts'] }}</p>
            </div>
            <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Views -->
    <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-600 mb-2">Blog Görüntülenme</p>
                <p class="text-3xl font-bold text-primary-600">{{ number_format($stats['total_views']) }}</p>
                <p class="text-xs text-gray-500 mt-1">Toplam trafik</p>
            </div>
            <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-600 mb-2">Kullanıcılar</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Admin: {{ $stats['total_admins'] }}</p>
            </div>
            <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Messages -->
    <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-600 mb-2">Okunmamış Mesajlar</p>
                <p class="text-3xl font-bold text-primary-600">{{ $stats['unread_messages'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Bugün: {{ $stats['today_messages'] }} | Toplam: {{ $stats['total_messages'] }}</p>
            </div>
            <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Vehicle Requests -->
    <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-600 mb-2">Araç İstekleri</p>
                <p class="text-3xl font-bold text-primary-600">{{ $stats['unread_vehicle_requests'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Bugün: {{ $stats['today_vehicle_requests'] }} | Toplam: {{ $stats['total_vehicle_requests'] }}</p>
            </div>
            <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Evaluation Requests -->
    <div class="stat-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-600 mb-2">Değerleme Talepleri</p>
                <p class="text-3xl font-bold text-primary-600">{{ $stats['unread_evaluation_requests'] }}</p>
                <p class="text-xs text-gray-500 mt-1">Bugün: {{ $stats['today_evaluation_requests'] }} | Toplam: {{ $stats['total_evaluation_requests'] }}</p>
            </div>
            <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
    </div>

</div>

<!-- Recent Activities - Clean & Simple -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Recent Vehicles -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Son Araçlar</h3>
            <a href="{{ route('admin.vehicles.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-semibold">
                Tümünü Gör →
            </a>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @forelse($stats['recent_vehicles'] as $vehicle)
                    <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $vehicle->title }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->year }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-bold text-primary-600">{{ number_format($vehicle->price, 0, ',', '.') }} ₺</p>
                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded {{ $vehicle->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $vehicle->is_active ? 'Aktif' : 'Pasif' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-sm text-gray-500">Henüz araç eklenmemiş</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Blog Posts -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Son Blog Yazıları</h3>
            <a href="{{ route('admin.blog.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-semibold">
                Tümünü Gör →
            </a>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @forelse($stats['recent_blog_posts'] as $post)
                    <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $post->title }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $post->category }} - {{ $post->views }} görüntülenme</p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="inline-block px-2 py-0.5 text-xs font-medium rounded {{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $post->is_published ? 'Yayında' : 'Taslak' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm text-gray-500">Henüz blog yazısı yok</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-900">Son Mesajlar</h3>
            <a href="{{ route('admin.contact-messages.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-semibold">
                Tümünü Gör →
            </a>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @forelse($stats['recent_messages'] as $message)
                    <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors {{ !$message->is_read ? 'bg-primary-50 border border-primary-200' : '' }}">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900">{{ $message->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5 truncate">{{ \Illuminate\Support\Str::limit($message->message, 50) }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-xs text-gray-500 mb-1">{{ $message->created_at->format('d M') }}</p>
                            @if(!$message->is_read)
                                <span class="inline-block px-2 py-0.5 text-xs font-bold rounded bg-primary-600 text-white">
                                    Yeni
                                </span>
                            @else
                                <span class="inline-block px-2 py-0.5 text-xs font-medium rounded bg-gray-100 text-gray-600">
                                    Okundu
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-500">Henüz mesaj yok</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
