@extends('admin.layouts.app')

@section('title', 'Blog Yönetimi - Admin Panel')
@section('page-title', 'Blog Yönetimi')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span>Blog</span>
@endsection

@section('content')

<!-- İstatistik Kartları -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <a href="{{ route('admin.blog.index') }}" class="bg-white rounded-xl p-6 border-2 border-primary-100 shadow-sm hover:shadow-lg hover:border-primary-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Toplam Yazı</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $stats['total'] }}</p>
            </div>
            <div class="w-14 h-14 bg-primary-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.blog.index', ['status' => 'published']) }}" class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm hover:shadow-lg hover:border-green-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Yayında</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">{{ $stats['published'] }}</p>
            </div>
            <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.blog.index', ['status' => 'featured']) }}" class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm hover:shadow-lg hover:border-yellow-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Öne Çıkan</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">{{ $stats['featured'] }}</p>
            </div>
            <div class="w-14 h-14 bg-yellow-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.blog.index', ['status' => 'draft']) }}" class="bg-white rounded-xl p-6 border-2 border-gray-100 shadow-sm hover:shadow-lg hover:border-gray-300 transition-all cursor-pointer group">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 text-sm font-medium mb-1">Taslak</p>
                <p class="text-3xl font-bold text-gray-900 group-hover:text-gray-600 transition-colors">{{ $stats['draft'] }}</p>
            </div>
            <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
        </div>
    </a>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    Blog Yazıları
                </h2>
                <p class="text-sm text-gray-600 mt-2">Toplam <span class="font-bold text-primary-600">{{ $posts->total() }}</span> yazı kayıtlı</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('blog.index') }}"
                   target="_blank"
                   class="inline-flex items-center px-4 py-2.5 bg-white text-gray-700 font-semibold rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-primary-600 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Blog'u Görüntüle
                </a>
                <a href="{{ route('admin.blog.create') }}"
                   class="px-6 py-2.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Yeni Yazı Ekle
                </a>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="p-6 bg-gray-50 border-b border-gray-200">
            <form id="filter-form" method="GET" action="{{ route('admin.blog.index') }}">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                    <!-- Search Input with Clear Button -->
                    <div class="relative">
                        <div class="admin-search-wrapper group">
                            <div class="admin-search-icon">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" 
                                   id="search-input"
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Başlık, içerik veya kategori ara..." 
                                   class="admin-search-input pr-10">
                            @if(request('search'))
                            <button type="button" 
                                    onclick="clearSearch()"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                                    title="Aramayı Temizle">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Kategori Filtresi -->
                    <div class="adm-dd" data-adm-dd data-submit="filter-form">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <button type="button" class="adm-dd-btn" data-adm-trigger>
                            <span data-adm-label>{{ request('category') ?: 'Tüm Kategoriler' }}</span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <ul class="adm-dd-list" data-adm-list style="max-height:220px;overflow-y:auto;">
                            <li data-value="" class="{{ !request('category') ? 'selected' : '' }}">Tüm Kategoriler</li>
                            @foreach($categories as $cat)
                            <li data-value="{{ $cat }}" class="{{ request('category') === $cat ? 'selected' : '' }}">{{ $cat }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Durum Filtresi -->
                    <div class="adm-dd" data-adm-dd data-submit="filter-form">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <button type="button" class="adm-dd-btn" data-adm-trigger>
                            <span data-adm-label>
                                @if(request('status') === 'published') Yayında
                                @elseif(request('status') === 'draft') Taslak
                                @elseif(request('status') === 'featured') Öne Çıkan
                                @else Tüm Durumlar
                                @endif
                            </span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <ul class="adm-dd-list" data-adm-list>
                            <li data-value=""          class="{{ !request('status') ? 'selected' : '' }}">Tüm Durumlar</li>
                            <li data-value="published" class="{{ request('status') === 'published' ? 'selected' : '' }}">Yayında</li>
                            <li data-value="draft"     class="{{ request('status') === 'draft'     ? 'selected' : '' }}">Taslak</li>
                            <li data-value="featured"  class="{{ request('status') === 'featured'  ? 'selected' : '' }}">Öne Çıkan</li>
                        </ul>
                    </div>

                    <!-- Sıralama -->
                    <div class="adm-dd" data-adm-dd data-submit="filter-form">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <button type="button" class="adm-dd-btn" data-adm-trigger>
                            <span data-adm-label>
                                @if(request('sort') === 'oldest') Eskiden Yeniye
                                @elseif(request('sort') === 'views') En Çok Görüntülenen
                                @else Yeniden Eskiye
                                @endif
                            </span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <ul class="adm-dd-list" data-adm-list>
                            <li data-value=""       class="{{ !request('sort') || request('sort') === 'newest' ? 'selected' : '' }}">Yeniden Eskiye</li>
                            <li data-value="oldest" class="{{ request('sort') === 'oldest' ? 'selected' : '' }}">Eskiden Yeniye</li>
                            <li data-value="views"  class="{{ request('sort') === 'views'  ? 'selected' : '' }}">En Çok Görüntülenen</li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Area -->
        <div class="overflow-x-auto">
            @if($posts->count() > 0)
                <table class="w-full table-fixed">
                    <colgroup>
                        <col class="w-[38%]"> <!-- Başlık -->
                        <col class="w-[13%]"> <!-- Kategori -->
                        <col class="w-[13%]"> <!-- İstatistik -->
                        <col class="w-[11%]"> <!-- Durum -->
                        <col class="w-[10%]"> <!-- Tarih -->
                        <col class="w-[15%]"> <!-- İşlemler -->
                    </colgroup>
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-5 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">BAŞLIK / AÇIKLAMA</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">KATEGORİ</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">İSTATİSTİK</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">DURUM</th>
                            <th class="px-4 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">TARİH</th>
                            <th class="px-4 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">İŞLEMLER</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($posts as $post)
                        <tr class="group hover:bg-gray-50 transition-all cursor-pointer"
                            onclick="window.location.href='{{ route('admin.blog.edit', $post->id) }}'">
                            <td class="px-5 py-5">
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-gray-900 group-hover:text-primary-600 transition-colors line-clamp-1">{{ $post->title }}</div>
                                    <div class="text-sm text-gray-400 font-medium line-clamp-1 italic mt-1">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 80) }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $post->slug }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-5 text-center">
                                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 max-w-[120px] truncate" title="{{ $post->category }}">
                                    {{ $post->category }}
                                </span>
                            </td>
                            <td class="px-4 py-5">
                                <div class="flex flex-col gap-1.5">
                                    <div class="inline-flex items-center justify-center gap-1 px-2 py-1 bg-purple-50 rounded-lg">
                                        <svg class="w-3.5 h-3.5 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        <span class="text-xs font-bold text-purple-900">{{ number_format($post->views) }}</span>
                                    </div>
                                    <div class="inline-flex items-center justify-center gap-1 px-2 py-1 bg-indigo-50 rounded-lg">
                                        <svg class="w-3.5 h-3.5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-xs font-bold text-indigo-900">{{ $post->reading_time ?? 1 }} dk</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-5 text-center" onclick="event.stopPropagation()">
                                @if($post->is_published)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                        Yayında
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span>
                                        Taslak
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-5 text-center">
                                <div class="text-sm font-semibold text-gray-700">{{ $post->created_at->format('d.m.Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $post->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-4 py-5 text-right" onclick="event.stopPropagation()">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button type="button"
                                            onclick="toggleFeatured({{ $post->id }}, {{ $post->is_featured ? 'true' : 'false' }})"
                                            class="p-2 rounded-xl transition-all shadow-sm {{ $post->is_featured ? 'text-amber-500 bg-amber-50 hover:bg-amber-100' : 'text-gray-400 bg-gray-50 hover:bg-amber-50 hover:text-amber-500' }}"
                                            title="{{ $post->is_featured ? 'Öne Çıkandan Kaldır' : 'Öne Çıkar' }}">
                                        <svg class="w-4 h-4" fill="{{ $post->is_featured ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                    </button>
                                    @if($post->is_published)
                                    <a href="{{ route('blog.show', $post->slug) }}" 
                                       target="_blank"
                                       class="p-2 text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm"
                                       title="Görüntüle">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    @endif
                                    <a href="{{ route('admin.blog.edit', $post->id) }}" 
                                       class="p-2 text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm"
                                       title="Düzenle">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" class="inline-block"
                                          onsubmit="return confirmDelete(this, '{{ addslashes($post->title) }} yazısını')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 text-red-600 bg-red-50 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm"
                                                title="Sil">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
            <div class="text-center py-20 bg-gray-50/20">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Henüz Blog Yazısı Yok</h3>
                <p class="text-gray-500 font-medium mb-6">İlk blog yazınızı oluşturmak için yeni yazı ekleyin.</p>
                <a href="{{ route('admin.blog.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Yeni Yazı Ekle
                </a>
            </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="px-6 py-5 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm font-semibold text-gray-500">
                {{ $posts->firstItem() }}–{{ $posts->lastItem() }} / <span class="text-gray-900">{{ $posts->total() }}</span> yazı
            </div>
            <div class="flex items-center gap-3">
                <div class="adm-dd" data-adm-dd style="width:80px;">
                    <button type="button" class="adm-dd-btn" data-adm-trigger style="height:38px;padding:0 10px;">
                        <span data-adm-label>{{ request('per_page', 15) }}</span>
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <ul class="adm-dd-list" data-adm-list>
                        <li data-value="15"  data-href="{{ request()->fullUrlWithQuery(['per_page' => 15,  'page' => 1]) }}" class="{{ request('per_page', 15) == 15  ? 'selected' : '' }}">15</li>
                        <li data-value="25"  data-href="{{ request()->fullUrlWithQuery(['per_page' => 25,  'page' => 1]) }}" class="{{ request('per_page') == 25    ? 'selected' : '' }}">25</li>
                        <li data-value="50"  data-href="{{ request()->fullUrlWithQuery(['per_page' => 50,  'page' => 1]) }}" class="{{ request('per_page') == 50    ? 'selected' : '' }}">50</li>
                    </ul>
                </div>
                {{ $posts->links() }}
            </div>
        </div>
        @endif
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-input');
        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('filter-form').submit();
                }
            });
        }
    });

    function clearSearch() {
        document.getElementById('search-input').value = '';
        document.getElementById('filter-form').submit();
    }

    const toggleFeaturedBaseUrl = '{{ route('admin.blog.index') }}';

    function toggleFeatured(postId, currentStatus) {
        fetch(`${toggleFeaturedBaseUrl}/${postId}/toggle-featured`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ is_featured: !currentStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endpush
@endsection
