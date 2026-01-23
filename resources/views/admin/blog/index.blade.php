@extends('admin.layouts.app')

@section('title', 'Blog Yönetimi - Admin Panel')
@section('page-title', 'Blog Yönetimi')

@push('styles')
<style>
    .hero-custom-dropdown-panel {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 50;
        background: white;
        margin-top: 0.5rem;
    }
    
    .hero-custom-dropdown-panel.open {
        display: block;
        animation: dropdownFade 0.2s ease-out;
    }
    
    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-custom-dropdown-option {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .hero-custom-dropdown-option:hover {
        background-color: #f9fafb;
        color: #e11d48;
    }

    .hero-custom-dropdown-option.selected {
        background-color: #fff1f2;
        color: #e11d48;
        font-weight: 700;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Blog Yönetimi</h1>
            <p class="mt-1 text-sm text-gray-500 font-medium tracking-wide uppercase">BLOG YAZILARININ YÖNETİMİ</p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button"
                    onclick="window.location.reload()"
                    class="inline-flex items-center justify-center w-11 h-11 bg-white text-gray-600 rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-primary-600 hover:border-primary-300 transition-all shadow-sm group"
                    title="Sayfayı Yenile">
                <svg class="w-5 h-5 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </button>
            <a href="{{ route('blog.index') }}" 
               target="_blank"
               class="inline-flex items-center px-5 py-2.5 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:text-primary-600 transition-all shadow-sm group">
                <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-primary-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Blog Sayfasını Görüntüle
            </a>
            <a href="{{ route('admin.blog.create') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25 group">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Yeni Yazı Ekle
            </a>
        </div>
    </div>

    <!-- Toolbar & Filters -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 bg-gray-50/30 border-b border-gray-50">
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

                    <!-- Category Filter Dropdown -->
                    <div class="relative hero-custom-dropdown" data-dropdown="filter-category">
                        <button type="button" 
                                class="hero-custom-dropdown-trigger w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-medium hover:border-primary-500 transition-all"
                                aria-expanded="false" aria-haspopup="listbox">
                            <span class="selected-text">
                                {{ request('category') ? request('category') : 'Tüm Kategoriler' }}
                            </span>
                            <svg class="arrow w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="hero-custom-dropdown-panel rounded-xl shadow-xl border border-gray-100 max-h-60 overflow-y-auto" role="listbox">
                            <div class="hero-custom-dropdown-option {{ !request('category') ? 'selected' : '' }}" data-value="" role="option">Tüm Kategoriler</div>
                            @foreach($categories as $cat)
                            <div class="hero-custom-dropdown-option {{ request('category') === $cat ? 'selected' : '' }}" data-value="{{ $cat }}" role="option">{{ $cat }}</div>
                            @endforeach
                        </div>
                        <select name="category" class="hero-custom-dropdown-native hidden">
                            <option value="">Tüm Kategoriler</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter Dropdown -->
                    <div class="relative hero-custom-dropdown" data-dropdown="filter-status">
                        <button type="button" 
                                class="hero-custom-dropdown-trigger w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-medium hover:border-primary-500 transition-all"
                                aria-expanded="false" aria-haspopup="listbox">
                            <span class="selected-text">
                                @if(request('status') === 'published') Yayında
                                @elseif(request('status') === 'draft') Taslak
                                @elseif(request('status') === 'featured') Öne Çıkan
                                @else Tüm Durumlar
                                @endif
                            </span>
                            <svg class="arrow w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="hero-custom-dropdown-panel rounded-xl shadow-xl border border-gray-100" role="listbox">
                            <div class="hero-custom-dropdown-option {{ !request('status') ? 'selected' : '' }}" data-value="" role="option">Tüm Durumlar</div>
                            <div class="hero-custom-dropdown-option {{ request('status') === 'published' ? 'selected' : '' }}" data-value="published" role="option">Yayında</div>
                            <div class="hero-custom-dropdown-option {{ request('status') === 'draft' ? 'selected' : '' }}" data-value="draft" role="option">Taslak</div>
                            <div class="hero-custom-dropdown-option {{ request('status') === 'featured' ? 'selected' : '' }}" data-value="featured" role="option">Öne Çıkan</div>
                        </div>
                        <select name="status" class="hero-custom-dropdown-native hidden">
                            <option value="">Tüm Durumlar</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Yayında</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Taslak</option>
                            <option value="featured" {{ request('status') === 'featured' ? 'selected' : '' }}>Öne Çıkan</option>
                        </select>
                    </div>

                    <!-- Sort Order Dropdown -->
                    <div class="relative hero-custom-dropdown" data-dropdown="sort-order">
                        <button type="button" 
                                class="hero-custom-dropdown-trigger w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-medium hover:border-primary-500 transition-all"
                                aria-expanded="false" aria-haspopup="listbox">
                            <span class="selected-text">
                                @if(request('sort') === 'oldest') Eskiden Yeniye
                                @elseif(request('sort') === 'views') En Çok Görüntülenen
                                @else Yeniden Eskiye
                                @endif
                            </span>
                            <svg class="arrow w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="hero-custom-dropdown-panel rounded-xl shadow-xl border border-gray-100" role="listbox">
                            <div class="hero-custom-dropdown-option {{ !request('sort') || request('sort') === 'newest' ? 'selected' : '' }}" data-value="" role="option">Yeniden Eskiye</div>
                            <div class="hero-custom-dropdown-option {{ request('sort') === 'oldest' ? 'selected' : '' }}" data-value="oldest" role="option">Eskiden Yeniye</div>
                            <div class="hero-custom-dropdown-option {{ request('sort') === 'views' ? 'selected' : '' }}" data-value="views" role="option">En Çok Görüntülenen</div>
                        </div>
                        <select name="sort" class="hero-custom-dropdown-native hidden">
                            <option value="">Yeniden Eskiye</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Eskiden Yeniye</option>
                            <option value="views" {{ request('sort') === 'views' ? 'selected' : '' }}>En Çok Görüntülenen</option>
                        </select>
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
                                    <a href="{{ route('blog.show', $post->slug) }}" 
                                       target="_blank"
                                       class="p-2 text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-600 hover:text-white transition-all shadow-sm"
                                       title="Görüntüle">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.blog.edit', $post->id) }}" 
                                       class="p-2 text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm"
                                       title="Düzenle">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <button type="button"
                                            onclick="openDeleteModal({{ $post->id }}, '{{ route('admin.blog.destroy', $post->id) }}')"
                                            class="p-2 text-red-600 bg-red-50 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm"
                                            title="Sil">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
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
        <div class="px-6 py-5 bg-gray-50/30 border-t border-gray-50 flex items-center justify-between">
            <div class="text-sm font-bold text-gray-500 uppercase tracking-widest">
                {{ $posts->firstItem() }}-{{ $posts->lastItem() }} / {{ $posts->total() }} YAZI
            </div>
            <div class="flex items-center gap-4 font-bold">
                <select onchange="window.location.href='{{ request()->fullUrlWithQuery(['per_page' => '__PER_PAGE__', 'page' => 1]) }}'.replace('__PER_PAGE__', this.value)"
                        class="bg-white border border-gray-200 rounded-xl px-3 py-1.5 focus:ring-primary-500/20 transition-all">
                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
                {{ $posts->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

@include('admin.components.confirm-modal', [
    'id' => 'delete-modal',
    'title' => 'Blog Yazısını Sil',
    'message' => 'Bu blog yazısını silmek istediğinize emin misiniz? Bu işlem geri alınamaz.',
    'confirmText' => 'Sil',
    'cancelText' => 'Vazgeç'
])

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Dropdown Handler
        const initDropdowns = () => {
            document.querySelectorAll('.hero-custom-dropdown:not([data-initialized])').forEach(dropdown => {
                const trigger = dropdown.querySelector('.hero-custom-dropdown-trigger');
                const panel = dropdown.querySelector('.hero-custom-dropdown-panel');
                const select = dropdown.querySelector('.hero-custom-dropdown-native');

                trigger.addEventListener('click', e => {
                    e.stopPropagation();
                    const isOpen = panel.classList.contains('open');
                    
                    // Close other dropdowns
                    document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(p => {
                        if (p !== panel) {
                            p.classList.remove('open');
                            p.closest('.hero-custom-dropdown').querySelector('.hero-custom-dropdown-trigger').setAttribute('aria-expanded', 'false');
                        }
                    });

                    // Toggle current
                    panel.classList.toggle('open');
                    trigger.setAttribute('aria-expanded', !isOpen);
                });

                dropdown.querySelectorAll('.hero-custom-dropdown-option').forEach(opt => {
                    opt.addEventListener('click', () => {
                        select.value = opt.dataset.value;
                        document.getElementById('filter-form').submit();
                    });
                });

                dropdown.setAttribute('data-initialized', '1');
            });
        };

        initDropdowns();

        // Close dropdowns on outside click
        document.addEventListener('click', () => {
            document.querySelectorAll('.hero-custom-dropdown-panel.open').forEach(p => {
                p.classList.remove('open');
                p.closest('.hero-custom-dropdown').querySelector('.hero-custom-dropdown-trigger').setAttribute('aria-expanded', 'false');
            });
        });

        // Search on Enter key
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

    // Clear search function
    function clearSearch() {
        const form = document.getElementById('filter-form');
        const searchInput = document.getElementById('search-input');
        searchInput.value = '';
        form.submit();
    }

    // Toggle featured status
    function toggleFeatured(postId, currentStatus) {
        fetch(`/admin/blog/${postId}/toggle-featured`, {
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

    function openDeleteModal(id, url) {
        document.getElementById('confirm-form-delete-modal').action = url;
        document.getElementById('delete-modal').classList.remove('hidden');
    }
</script>
@endpush
@endsection
