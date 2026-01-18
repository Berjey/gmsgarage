@extends('admin.layouts.app')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@push('styles')
<style>
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
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }
    .stat-card:nth-child(5) { animation-delay: 0.5s; }
    .stat-card:nth-child(6) { animation-delay: 0.6s; }
    
    .stat-card:hover {
        transform: translateY(-4px);
        transition: transform 0.3s ease;
    }
</style>
@endpush

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Total Vehicles -->
    <div class="stat-card bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Toplam Araç</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['total_vehicles'] }}</p>
            </div>
            <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Active Vehicles -->
    <div class="stat-card bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Aktif Araçlar</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['active_vehicles'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Featured Vehicles -->
    <div class="stat-card bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Öne Çıkan Araçlar</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['featured_vehicles'] }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Blog Posts -->
    <div class="stat-card bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Toplam Blog Yazısı</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['total_blog_posts'] }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Published Blog Posts -->
    <div class="stat-card bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Yayınlanan Yazılar</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['published_blog_posts'] }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Views -->
    <div class="stat-card bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Toplam Görüntülenme</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ number_format($stats['total_views']) }}</p>
            </div>
            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Unread Messages -->
    <div class="stat-card bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Okunmamış Mesajlar</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['unread_messages'] }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Toplam: {{ $stats['total_messages'] }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Unread Vehicle Requests -->
    <div class="stat-card bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Okunmamış Araç İstekleri</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['unread_vehicle_requests'] }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Toplam: {{ $stats['total_vehicle_requests'] }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Unread Evaluation Requests -->
    <div class="stat-card bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Okunmamış Değerleme</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['unread_evaluation_requests'] }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Toplam: {{ $stats['total_evaluation_requests'] }}</p>
            </div>
            <div class="w-12 h-12 bg-teal-100 dark:bg-teal-900/30 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Recent Items -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Vehicles -->
    <div class="bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Son Eklenen Araçlar</h3>
            <a href="{{ route('admin.vehicles.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                Tümünü Gör
            </a>
        </div>
        <div class="space-y-3">
            @forelse($stats['recent_vehicles'] as $vehicle)
                <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-[#2a2a2a] transition-colors">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $vehicle->title }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->year }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-primary-600 dark:text-primary-400">{{ number_format($vehicle->price, 0, ',', '.') }} ₺</p>
                        <span class="inline-block px-2 py-1 text-xs rounded-full {{ $vehicle->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }}">
                            {{ $vehicle->is_active ? 'Aktif' : 'Pasif' }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Henüz araç eklenmemiş.</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Blog Posts -->
    <div class="bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Son Blog Yazıları</h3>
            <a href="{{ route('admin.blog.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                Tümünü Gör
            </a>
        </div>
        <div class="space-y-3">
            @forelse($stats['recent_blog_posts'] as $post)
                <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-[#2a2a2a] transition-colors">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 line-clamp-1">{{ $post->title }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $post->category }} - {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $post->views }} görüntülenme</p>
                        <span class="inline-block px-2 py-1 text-xs rounded-full {{ $post->is_published ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }}">
                            {{ $post->is_published ? 'Yayında' : 'Taslak' }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Henüz blog yazısı eklenmemiş.</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Son Mesajlar</h3>
            <a href="{{ route('admin.contact-messages.index') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">
                Tümünü Gör
            </a>
        </div>
        <div class="space-y-3">
            @forelse($stats['recent_messages'] as $message)
                <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-[#2a2a2a] transition-colors {{ !$message->is_read ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $message->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($message->message, 50) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $message->created_at->format('d M') }}</p>
                        @if(!$message->is_read)
                        <span class="inline-block w-2 h-2 bg-red-500 rounded-full mt-1"></span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Henüz mesaj yok.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
