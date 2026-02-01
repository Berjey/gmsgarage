@extends('admin.layouts.app')

@section('title', 'Blog Kategorileri - Admin Panel')
@section('page-title', 'Blog Kategorileri')

@push('styles')
<style>
    .category-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #dc2626, #ef4444, #f87171);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }
    
    .category-card:hover::before {
        transform: scaleX(1);
    }
    
    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }
    
    .stat-card {
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    
    .post-item {
        transition: all 0.2s;
    }
    
    .post-item:hover {
        background-color: #f9fafb;
        padding-left: 0.75rem;
    }
    
    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        transition: all 0.2s;
    }
    
    .category-badge:hover {
        transform: scale(1.05);
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .category-card {
        animation: slideIn 0.3s ease-out;
        animation-fill-mode: both;
    }
    
    .category-card:nth-child(1) { animation-delay: 0.05s; }
    .category-card:nth-child(2) { animation-delay: 0.1s; }
    .category-card:nth-child(3) { animation-delay: 0.15s; }
    .category-card:nth-child(4) { animation-delay: 0.2s; }
    .category-card:nth-child(5) { animation-delay: 0.25s; }
    .category-card:nth-child(6) { animation-delay: 0.3s; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Blog Kategorileri</h1>
            <p class="mt-1 text-sm text-gray-500 font-medium tracking-wide uppercase">KATEGORİ YÖNETİMİ</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.blog.index') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-primary-600 transition-all shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Blog Yazıları
            </a>
            <button type="button"
                    onclick="openAddCategoryModal()"
                    class="inline-flex items-center px-5 py-2.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Yeni Kategori
            </button>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="stat-card bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl border border-blue-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-1">Toplam Kategori</p>
                    <p class="text-3xl font-bold text-blue-900">{{ $stats['total_categories'] }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
            </div>
        </div>
        
        <div class="stat-card bg-gradient-to-br from-green-50 to-green-100 rounded-2xl border border-green-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-green-600 uppercase tracking-wider mb-1">Toplam Yazı</p>
                    <p class="text-3xl font-bold text-green-900">{{ number_format($stats['total_posts']) }}</p>
                </div>
                <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
        </div>
        
        <div class="stat-card bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl border border-purple-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-bold text-purple-600 uppercase tracking-wider mb-1">Toplam Görüntülenme</p>
                    <p class="text-3xl font-bold text-purple-900">{{ number_format($stats['total_views']) }}</p>
                </div>
                <div class="w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
            </div>
        </div>
        
        <div class="stat-card bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl border border-amber-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-amber-600 uppercase tracking-wider mb-1">En Popüler</p>
                    <p class="text-lg font-bold text-amber-900 truncate" title="{{ $stats['most_popular']['name'] ?? 'Yok' }}">
                        {{ $stats['most_popular']['name'] ?? 'Yok' }}
                    </p>
                    @if($stats['most_popular'])
                    <p class="text-xs text-amber-700 mt-1">{{ $stats['most_popular']['post_count'] }} yazı</p>
                    @endif
                </div>
                <div class="w-14 h-14 bg-amber-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar & Filters -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 bg-gray-50/30 border-b border-gray-50">
            <form method="GET" action="{{ route('admin.blog.categories.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- Search Input -->
                    <div class="lg:col-span-2">
                        <div class="admin-search-wrapper group">
                            <div class="admin-search-icon">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search }}"
                                   placeholder="Kategori adı ara..." 
                                   class="admin-search-input">
                        </div>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="relative hero-custom-dropdown admin-dropdown" data-dropdown="sort-order">
                        <button type="button" 
                                class="hero-custom-dropdown-trigger admin-dropdown-trigger w-full flex items-center justify-between px-4 py-3 border border-gray-200 rounded-xl text-gray-800 font-semibold hover:bg-gray-50 hover:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all shadow-sm"
                                aria-expanded="false" aria-haspopup="listbox">
                            <span class="selected-text">
                                @if($sort === 'name_desc') Alfabetik (Z-A)
                                @elseif($sort === 'posts_asc') Yazı Sayısı (Az-Çok)
                                @elseif($sort === 'posts_desc') Yazı Sayısı (Çok-Az)
                                @else Alfabetik (A-Z)
                                @endif
                            </span>
                            <svg class="arrow w-5 h-5 text-gray-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="hero-custom-dropdown-panel rounded-xl" role="listbox">
                            <div class="hero-custom-dropdown-option {{ $sort === 'name_asc' ? 'selected' : '' }}" data-value="name_asc" role="option">Alfabetik (A-Z)</div>
                            <div class="hero-custom-dropdown-option {{ $sort === 'name_desc' ? 'selected' : '' }}" data-value="name_desc" role="option">Alfabetik (Z-A)</div>
                            <div class="hero-custom-dropdown-option {{ $sort === 'posts_asc' ? 'selected' : '' }}" data-value="posts_asc" role="option">Yazı Sayısı (Az-Çok)</div>
                            <div class="hero-custom-dropdown-option {{ $sort === 'posts_desc' ? 'selected' : '' }}" data-value="posts_desc" role="option">Yazı Sayısı (Çok-Az)</div>
                        </div>
                        <select name="sort" class="hero-custom-dropdown-native hidden">
                            <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Alfabetik (A-Z)</option>
                            <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Alfabetik (Z-A)</option>
                            <option value="posts_asc" {{ $sort === 'posts_asc' ? 'selected' : '' }}>Yazı Sayısı (Az-Çok)</option>
                            <option value="posts_desc" {{ $sort === 'posts_desc' ? 'selected' : '' }}>Yazı Sayısı (Çok-Az)</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    @if($search)
                    <a href="{{ route('admin.blog.categories.index') }}" 
                       class="px-6 py-2.5 bg-white text-gray-600 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all shadow-sm">
                        Sıfırla
                    </a>
                    @endif
                    <button type="submit" 
                            class="px-8 py-2.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
                        Filtrele
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Grid -->
    @if($categories->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
        <div class="category-card bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Category Header -->
            <div class="p-6 bg-gradient-to-br from-gray-50 to-white border-b border-gray-100">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 truncate" title="{{ $category['name'] }}">
                            {{ $category['name'] }}
                        </h3>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="category-badge bg-primary-100 text-primary-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                {{ $category['post_count'] }} {{ $category['post_count'] == 1 ? 'Yazı' : 'Yazı' }}
                            </span>
                            @if($category['published_count'] > 0)
                            <span class="category-badge bg-green-100 text-green-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $category['published_count'] }} Yayında
                            </span>
                            @endif
                            @if($category['draft_count'] > 0)
                            <span class="category-badge bg-yellow-100 text-yellow-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $category['draft_count'] }} Taslak
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-2 ml-3">
                        <button type="button"
                                onclick="openCategoryDetailsModal({{ json_encode($category['name']) }})"
                                class="p-2 text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm"
                                title="Detaylar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                        <button type="button"
                                onclick="openEditCategoryModal({{ json_encode($category['name']) }})"
                                class="p-2 text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm"
                                title="Düzenle">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button type="button"
                                onclick="openDeleteCategoryModal({{ json_encode($category['name']) }}, {{ $category['post_count'] }})"
                                class="p-2 text-red-600 bg-red-50 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm"
                                title="Sil">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
                
                <!-- İstatistikler -->
                <div class="grid grid-cols-2 gap-3 mt-4 pt-4 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Görüntülenme</p>
                        <p class="text-lg font-bold text-gray-900">{{ number_format($category['total_views']) }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Ortalama</p>
                        <p class="text-lg font-bold text-gray-900">
                            {{ $category['post_count'] > 0 ? number_format($category['total_views'] / $category['post_count'], 0) : 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Son Yazılar -->
            @if($category['latest_posts']->count() > 0)
            <div class="p-6 bg-gray-50/30">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Son Yazılar</p>
                <div class="space-y-2">
                    @foreach($category['latest_posts'] as $post)
                    <a href="{{ route('admin.blog.edit', $post->id) }}" 
                       class="post-item block p-3 bg-white rounded-xl border border-gray-100 hover:border-primary-200 transition-all group">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-primary-600 transition-colors line-clamp-1">
                                    {{ $post->title }}
                                </p>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs text-gray-500">{{ $post->created_at->format('d.m.Y') }}</span>
                                    @if($post->is_published)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800">
                                        Yayında
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-yellow-100 text-yellow-800">
                                        Taslak
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-primary-600 transition-colors flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="p-6 bg-white border-t border-gray-100">
                <a href="{{ route('admin.blog.index', ['category' => $category['name']]) }}" 
                   class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-primary-50 text-primary-700 font-bold rounded-xl hover:bg-primary-100 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    Tüm Yazıları Görüntüle
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Kategori Bulunamadı</h3>
        <p class="text-gray-500 font-medium mb-6">
            @if($search)
                "{{ $search }}" için sonuç bulunamadı.
            @else
                Henüz kategori oluşturulmamış.
            @endif
        </p>
        @if($search)
        <a href="{{ route('admin.blog.categories.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all shadow-sm mr-3">
            Filtreyi Temizle
        </a>
        @endif
        <button type="button"
                onclick="openAddCategoryModal()"
                class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Yeni Kategori Ekle
        </button>
    </div>
    @endif
</div>

<!-- Add Category Modal -->
<div id="add-category-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between bg-gradient-to-r from-primary-50 to-purple-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Yeni Kategori Ekle</h3>
            </div>
            <button onclick="closeAddCategoryModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('admin.blog.categories.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Kategori Adı <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="add-category-name"
                       required 
                       maxlength="255"
                       placeholder="Örn: Teknoloji, Otomobil, Rehber..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all"
                       autofocus>
                <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Maksimum 255 karakter. Kategori adı benzersiz olmalıdır.
                </p>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="text-sm font-semibold text-blue-900 mb-1">Bilgi</p>
                        <p class="text-xs text-blue-700">Kategori eklendikten sonra, bu kategori ile yeni bir blog yazısı oluşturma sayfasına yönlendirileceksiniz.</p>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-primary-500/25">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Ekle ve Devam Et
                </button>
                <button type="button" onclick="closeAddCategoryModal()" class="px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition-all">
                    İptal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Category Modal -->
<div id="edit-category-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between bg-gradient-to-r from-amber-50 to-orange-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Kategori Düzenle</h3>
            </div>
            <button onclick="closeEditCategoryModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="edit-category-form" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Kategori Adı <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="edit-category-name"
                       required 
                       maxlength="255"
                       placeholder="Kategori adını girin..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                <p class="mt-2 text-xs text-gray-500">Maksimum 255 karakter</p>
            </div>
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-900 mb-1">Uyarı</p>
                        <p class="text-xs text-amber-700">Kategori adı değiştirildiğinde, bu kategoriye ait tüm blog yazıları otomatik olarak güncellenecektir.</p>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-primary-500/25">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Güncelle
                </button>
                <button type="button" onclick="closeEditCategoryModal()" class="px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition-all">
                    İptal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Category Details Modal -->
<div id="category-details-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900" id="details-category-name">Kategori Detayları</h3>
            </div>
            <button onclick="closeCategoryDetailsModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div id="category-details-content" class="p-6">
            <div class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
                <p class="mt-4 text-gray-500">Yükleniyor...</p>
            </div>
        </div>
    </div>
</div>

<!-- Delete Category Modal -->
<div id="delete-category-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between bg-gradient-to-r from-red-50 to-pink-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Kategori Sil</h3>
            </div>
            <button onclick="closeDeleteCategoryModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="delete-category-form" method="POST" class="p-6 space-y-4">
            @csrf
            @method('DELETE')
            <div id="delete-category-message" class="text-gray-700"></div>
            
            <div id="category-migration-section" class="hidden space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Yazıları Taşı (Zorunlu) *</label>
                    <select name="new_category" 
                            id="delete-new-category"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Kategori Seçin</option>
                        <!-- Kategoriler JavaScript ile dinamik olarak eklenecek -->
                    </select>
                    <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Bu kategorideki yazılar seçilen kategoriye taşınacak
                    </p>
                </div>
            </div>
            
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-red-500/25">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Sil
                </button>
                <button type="button" onclick="closeDeleteCategoryModal()" class="px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition-all">
                    İptal
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Kategorileri JavaScript'e aktar
    const allCategories = @json($categories);
    
    function openAddCategoryModal() {
        document.getElementById('add-category-modal').classList.remove('hidden');
        document.getElementById('add-category-name').focus();
    }

    function closeAddCategoryModal() {
        document.getElementById('add-category-modal').classList.add('hidden');
        document.getElementById('add-category-name').value = '';
    }

    function openEditCategoryModal(categoryName) {
        document.getElementById('edit-category-name').value = categoryName;
        const encodedName = encodeURIComponent(categoryName);
        document.getElementById('edit-category-form').action = '{{ route('admin.blog.categories.update', ':name') }}'.replace(':name', encodedName);
        document.getElementById('edit-category-modal').classList.remove('hidden');
        document.getElementById('edit-category-name').focus();
    }

    function closeEditCategoryModal() {
        document.getElementById('edit-category-modal').classList.add('hidden');
    }

    function openCategoryDetailsModal(categoryName) {
        const modal = document.getElementById('category-details-modal');
        const content = document.getElementById('category-details-content');
        const title = document.getElementById('details-category-name');
        
        title.textContent = categoryName + ' - Detaylar';
        content.innerHTML = '<div class="text-center py-8"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div><p class="mt-4 text-gray-500">Yükleniyor...</p></div>';
        modal.classList.remove('hidden');
        
        // AJAX ile kategori detaylarını yükle
        const encodedName = encodeURIComponent(categoryName);
        fetch(`{{ route('admin.blog.categories.show', ':name') }}`.replace(':name', encodedName))
            .then(response => response.json())
            .then(data => {
                let html = `
                    <div class="space-y-6">
                        <!-- İstatistikler -->
                        <div class="grid grid-cols-3 gap-4">
                            <div class="bg-blue-50 rounded-xl p-4 text-center border border-blue-200">
                                <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Toplam Yazı</p>
                                <p class="text-2xl font-bold text-blue-900">${data.post_count}</p>
                            </div>
                            <div class="bg-green-50 rounded-xl p-4 text-center border border-green-200">
                                <p class="text-xs font-bold text-green-600 uppercase tracking-wider mb-1">Yayında</p>
                                <p class="text-2xl font-bold text-green-900">${data.posts.filter(p => p.is_published).length}</p>
                            </div>
                            <div class="bg-yellow-50 rounded-xl p-4 text-center border border-yellow-200">
                                <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider mb-1">Taslak</p>
                                <p class="text-2xl font-bold text-yellow-900">${data.posts.filter(p => !p.is_published).length}</p>
                            </div>
                        </div>
                        
                        <!-- Son Yazılar -->
                        <div>
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Son Yazılar</h4>
                            <div class="space-y-2">
                `;
                
                if (data.posts.length > 0) {
                    data.posts.forEach(post => {
                        const date = new Date(post.created_at).toLocaleDateString('tr-TR');
                        const status = post.is_published ? 
                            '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-green-100 text-green-800">Yayında</span>' :
                            '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-yellow-100 text-yellow-800">Taslak</span>';
                        
                        html += `
                            <a href="/admin/blog/${post.id}/edit" class="block p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all border border-gray-200">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 line-clamp-1">${post.title}</p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-gray-500">${date}</span>
                                            ${status}
                                        </div>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </a>
                        `;
                    });
                } else {
                    html += '<p class="text-sm text-gray-500 text-center py-4">Henüz yazı bulunmuyor.</p>';
                }
                
                html += `
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex gap-3 pt-4 border-t">
                            <button onclick="openEditCategoryModal(${JSON.stringify(categoryName)}); closeCategoryDetailsModal();" 
                                    class="flex-1 px-4 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl transition-all">
                                Düzenle
                            </button>
                            <a href="/admin/blog?category=${encodeURIComponent(categoryName)}" 
                               class="flex-1 px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all text-center">
                                Tüm Yazıları Gör
                            </a>
                        </div>
                    </div>
                `;
                
                content.innerHTML = html;
            })
            .catch(error => {
                content.innerHTML = '<div class="text-center py-8"><p class="text-red-600">Detaylar yüklenirken bir hata oluştu.</p></div>';
            });
    }

    function closeCategoryDetailsModal() {
        document.getElementById('category-details-modal').classList.add('hidden');
    }

    function openDeleteCategoryModal(categoryName, postCount) {
        const form = document.getElementById('delete-category-form');
        const message = document.getElementById('delete-category-message');
        const migrationSection = document.getElementById('category-migration-section');
        const select = document.getElementById('delete-new-category');
        
        const encodedName = encodeURIComponent(categoryName);
        form.action = '{{ route('admin.blog.categories.destroy', ':name') }}'.replace(':name', encodedName);
        
        select.innerHTML = '<option value="">Kategori Seçin</option>';
        
        if (postCount > 0) {
            message.innerHTML = `
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            <p class="font-semibold text-red-900 mb-1">Dikkat!</p>
                            <p class="text-sm text-red-700 mb-2"><strong>"${categoryName}"</strong> kategorisinde <strong>${postCount}</strong> yazı bulunmaktadır.</p>
                            <p class="text-xs text-red-600">Bu kategoriyi silmek için yazıların taşınacağı yeni bir kategori seçmelisiniz.</p>
                        </div>
                    </div>
                </div>
            `;
            migrationSection.classList.remove('hidden');
            select.required = true;
            
            allCategories.forEach(cat => {
                if (cat.name !== categoryName) {
                    const option = document.createElement('option');
                    option.value = cat.name;
                    option.textContent = `${cat.name} (${cat.post_count} yazı)`;
                    select.appendChild(option);
                }
            });
        } else {
            message.innerHTML = `
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            <p class="font-semibold text-yellow-900 mb-1">Onay</p>
                            <p class="text-sm text-yellow-700"><strong>"${categoryName}"</strong> kategorisini silmek istediğinize emin misiniz?</p>
                            <p class="text-xs text-yellow-600 mt-1">Bu işlem geri alınamaz.</p>
                        </div>
                    </div>
                </div>
            `;
            migrationSection.classList.add('hidden');
            select.required = false;
        }
        
        document.getElementById('delete-category-modal').classList.remove('hidden');
    }

    function closeDeleteCategoryModal() {
        document.getElementById('delete-category-modal').classList.add('hidden');
        document.getElementById('delete-category-form').reset();
        const select = document.getElementById('delete-new-category');
        select.innerHTML = '<option value="">Kategori Seçin</option>';
    }

    // Dropdown handler
    document.addEventListener('DOMContentLoaded', () => {
        const initDropdowns = () => {
            document.querySelectorAll('.hero-custom-dropdown:not([data-initialized])').forEach(dropdown => {
                const trigger = dropdown.querySelector('.hero-custom-dropdown-trigger');
                const panel = dropdown.querySelector('.hero-custom-dropdown-panel');
                const select = dropdown.querySelector('.hero-custom-dropdown-native');

                trigger.addEventListener('click', e => {
                    e.stopPropagation();
                    const isOpen = panel.classList.contains('open');
                    
                    document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(p => {
                        if (p !== panel) {
                            p.classList.remove('open');
                            p.closest('.hero-custom-dropdown').querySelector('.hero-custom-dropdown-trigger').setAttribute('aria-expanded', 'false');
                        }
                    });

                    panel.classList.toggle('open');
                    trigger.setAttribute('aria-expanded', !isOpen);
                });

                dropdown.querySelectorAll('.hero-custom-dropdown-option').forEach(opt => {
                    opt.addEventListener('click', () => {
                        select.value = opt.dataset.value;
                        const selectedText = trigger.querySelector('.selected-text');
                        selectedText.textContent = opt.textContent.trim();
                        panel.classList.remove('open');
                        trigger.setAttribute('aria-expanded', 'false');
                        // Formu otomatik submit et
                        trigger.closest('form').submit();
                    });
                });

                dropdown.setAttribute('data-initialized', '1');
            });
        };

        initDropdowns();

        document.addEventListener('click', () => {
            document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(p => {
                p.classList.remove('open');
                p.closest('.hero-custom-dropdown').querySelector('.hero-custom-dropdown-trigger').setAttribute('aria-expanded', 'false');
            });
        });
    });
</script>
@endpush
@endsection
