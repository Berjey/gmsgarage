@extends('admin.layouts.app')

@section('title', 'Blog Yönetimi - Admin Panel')
@section('page-title', 'Blog Yönetimi')

@push('styles')
<style>
    /* Admin Panel - Light Mode Dropdown (Tüm global stilleri override eder) */
    /* Dark mode ve light mode stillerini devre dışı bırak */
    .admin-body .admin-dropdown .hero-custom-dropdown-trigger,
    .admin-body .admin-dropdown-trigger,
    .admin-body .hero-custom-dropdown-trigger,
    .admin-body.dark .hero-custom-dropdown-trigger {
        /* Arka plan - sadece beyaz, gradient yok */
        background: #ffffff !important;
        background-color: #ffffff !important;
        background-image: none !important;
        /* Border - açık gri */
        border: 1px solid #e5e7eb !important;
        border-color: #e5e7eb !important;
        border-width: 1px !important;
        /* Metin rengi */
        color: #1f2937 !important;
        /* Basit gölge */
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        /* Ring efektini kaldır */
        ring: none !important;
        ring-width: 0 !important;
        ring-color: transparent !important;
    }
    
    /* Before pseudo element'i kaldır */
    .admin-body .admin-dropdown .hero-custom-dropdown-trigger::before,
    .admin-body .admin-dropdown-trigger::before,
    .admin-body .hero-custom-dropdown-trigger::before,
    .admin-body.dark .hero-custom-dropdown-trigger::before {
        display: none !important;
        background: none !important;
        content: none !important;
    }
    
    /* Hover durumu */
    .admin-body .admin-dropdown .hero-custom-dropdown-trigger:hover,
    .admin-body .admin-dropdown-trigger:hover,
    .admin-body .hero-custom-dropdown-trigger:hover,
    .admin-body.dark .hero-custom-dropdown-trigger:hover {
        background: #f9fafb !important;
        background-color: #f9fafb !important;
        background-image: none !important;
        border-color: #dc2626 !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important;
    }
    
    /* Hover before efektini kaldır */
    .admin-body .admin-dropdown .hero-custom-dropdown-trigger:hover::before,
    .admin-body .admin-dropdown-trigger:hover::before,
    .admin-body .hero-custom-dropdown-trigger:hover::before,
    .admin-body.dark .hero-custom-dropdown-trigger:hover::before {
        display: none !important;
    }
    
    /* Açık durumu */
    .admin-body .admin-dropdown .hero-custom-dropdown-trigger.open,
    .admin-body .admin-dropdown-trigger.open,
    .admin-body .hero-custom-dropdown-trigger.open,
    .admin-body.dark .hero-custom-dropdown-trigger.open {
        background: #ffffff !important;
        background-color: #ffffff !important;
        background-image: none !important;
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        ring: none !important;
        ring-width: 0 !important;
    }
    
    /* Metin stilleri */
    .admin-body .admin-dropdown .hero-custom-dropdown-trigger .selected-text,
    .admin-body .admin-dropdown-trigger .selected-text,
    .admin-body .hero-custom-dropdown-trigger .selected-text,
    .admin-body.dark .hero-custom-dropdown-trigger .selected-text {
        color: #1f2937 !important;
        text-shadow: none !important;
    }
    
    .admin-body .admin-dropdown .hero-custom-dropdown-trigger .selected-text.placeholder,
    .admin-body .admin-dropdown-trigger .selected-text.placeholder,
    .admin-body .hero-custom-dropdown-trigger .selected-text.placeholder,
    .admin-body.dark .hero-custom-dropdown-trigger .selected-text.placeholder {
        color: #6b7280 !important;
    }
    
    /* Ok ikonu */
    .admin-body .admin-dropdown .hero-custom-dropdown-trigger .arrow,
    .admin-body .admin-dropdown-trigger .arrow,
    .admin-body .hero-custom-dropdown-trigger .arrow,
    .admin-body.dark .hero-custom-dropdown-trigger .arrow {
        color: #6b7280 !important;
        filter: none !important;
        transform: none !important;
    }
    
    .admin-body .admin-dropdown .hero-custom-dropdown-trigger.open .arrow,
    .admin-body .admin-dropdown-trigger.open .arrow,
    .admin-body .hero-custom-dropdown-trigger.open .arrow,
    .admin-body.dark .hero-custom-dropdown-trigger.open .arrow {
        color: #6b7280 !important;
        filter: none !important;
        transform: rotate(180deg) !important;
    }
    
    /* Dropdown Panel */
    .admin-body .hero-custom-dropdown-panel {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 50;
        background: #ffffff !important;
        margin-top: 0.5rem;
        border: 1px solid #e5e7eb !important;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04) !important;
    }
    
    .admin-body .hero-custom-dropdown-panel.open {
        display: block;
        animation: dropdownFade 0.2s ease-out;
    }
    
    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .admin-body .hero-custom-dropdown-option {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: all 0.2s;
        color: #374151 !important;
        font-weight: 500;
        background: transparent !important;
    }

    .admin-body .hero-custom-dropdown-option:hover {
        background-color: #f9fafb !important;
        color: #dc2626 !important;
    }

    .admin-body .hero-custom-dropdown-option.selected {
        background-color: #fef2f2 !important;
        color: #dc2626 !important;
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

    <!-- Kategori Yönetimi (Collapsible) -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <button type="button" 
                onclick="toggleCategoryManager()"
                class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center group-hover:bg-primary-200 transition-colors">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
                <div class="text-left">
                    <h3 class="font-bold text-gray-900">Kategori Yönetimi</h3>
                    <p class="text-xs text-gray-500">{{ $categoryStats->count() }} kategori</p>
                </div>
            </div>
            <svg id="category-manager-arrow" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div id="category-manager-content" class="hidden border-t border-gray-100">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm font-semibold text-gray-700">Kategoriler</p>
                    <button type="button"
                            onclick="openAddCategoryModal()"
                            class="px-4 py-2 bg-primary-600 text-white text-sm font-bold rounded-lg hover:bg-primary-700 transition-all shadow-sm">
                        + Yeni Ekle
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($categoryStats as $cat)
                    @php
                        $categoryImage = \App\Helpers\CategoryHelper::getCategoryImage($cat['name']);
                    @endphp
                    <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                        @if($categoryImage)
                        <div class="w-12 h-12 rounded-lg overflow-hidden flex-shrink-0">
                            <img src="{{ $categoryImage }}" alt="{{ $cat['name'] }}" class="w-full h-full object-cover">
                        </div>
                        @else
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $cat['name'] }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $cat['post_count'] }} yazı</p>
                        </div>
                        <div class="flex items-center gap-1.5 ml-3">
                            <button type="button"
                                    onclick="openEditCategoryModal({{ json_encode($cat['name']) }})"
                                    class="p-1.5 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors"
                                    title="Düzenle">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button type="button"
                                    onclick="openDeleteCategoryModal({{ json_encode($cat['name']) }}, {{ $cat['post_count'] }})"
                                    class="p-1.5 text-red-600 hover:bg-red-100 rounded-lg transition-colors"
                                    title="Sil">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    @if($categoryStats->count() === 0)
                    <div class="col-span-full text-center py-8 text-gray-500">
                        <p class="text-sm">Henüz kategori yok</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="add-category-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
            <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between bg-gradient-to-r from-primary-50 to-red-50">
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
            <form id="add-category-form" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Adı <span class="text-red-500">*</span></label>
                    <input type="text" 
                           id="add-category-name"
                           required 
                           maxlength="255"
                           placeholder="Kategori adını girin..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                    <p class="mt-1 text-xs text-gray-500">Maksimum 255 karakter</p>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-primary-500/25">
                        Ekle
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
            <form id="edit-category-form" enctype="multipart/form-data" class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Adı <span class="text-red-500">*</span></label>
                    <input type="text" 
                           id="edit-category-name"
                           name="name"
                           required 
                           maxlength="255"
                           placeholder="Kategori adını girin..."
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all">
                    <p class="mt-1 text-xs text-gray-500">Maksimum 255 karakter</p>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kategori Görseli</label>
                    <div class="space-y-3">
                        <div class="relative">
                            <input type="file" 
                                   id="edit-category-image"
                                   name="image"
                                   accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-white file:text-gray-700 hover:file:bg-gray-50 file:border file:border-gray-300 transition-all border border-gray-200 rounded-xl bg-white">
                        </div>
                        <div id="edit-category-image-preview" class="hidden mt-3">
                            <img id="edit-category-preview-img" src="" alt="Önizleme" class="w-full h-32 object-cover rounded-xl border border-gray-200">
                        </div>
                        <p class="text-xs text-gray-500">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Önerilen boyut: 800x450px (16:9 oran). Görsel otomatik olarak bu boyuta getirilir.
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 px-4 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-primary-500/25">
                        Güncelle
                    </button>
                    <button type="button" onclick="closeEditCategoryModal()" class="px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition-all">
                        İptal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div id="delete-category-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full">
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
            <form id="delete-category-form" class="p-6 space-y-4">
                <div id="delete-category-message" class="text-gray-700"></div>
                <div id="category-migration-section" class="hidden space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Yazıları Taşı (Zorunlu) *</label>
                        <select id="delete-new-category" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Kategori Seçin</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Bu kategorideki yazılar seçilen kategoriye taşınacak</p>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-red-500/25">
                        Sil
                    </button>
                    <button type="button" onclick="closeDeleteCategoryModal()" class="px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl transition-all">
                        İptal
                    </button>
                </div>
            </form>
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
                    <div class="relative hero-custom-dropdown admin-dropdown" data-dropdown="filter-category">
                        <button type="button" 
                                class="hero-custom-dropdown-trigger admin-dropdown-trigger w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-medium hover:border-primary-500 transition-all"
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
                    <div class="relative hero-custom-dropdown admin-dropdown" data-dropdown="filter-status">
                        <button type="button" 
                                class="hero-custom-dropdown-trigger admin-dropdown-trigger w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-medium hover:border-primary-500 transition-all"
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
                    <div class="relative hero-custom-dropdown admin-dropdown" data-dropdown="sort-order">
                        <button type="button" 
                                class="hero-custom-dropdown-trigger admin-dropdown-trigger w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-700 font-medium hover:border-primary-500 transition-all"
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
        <div class="px-6 py-5 bg-gray-50/30 border-t border-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm font-bold text-gray-500 uppercase tracking-widest">
                {{ $posts->firstItem() }}-{{ $posts->lastItem() }} / {{ $posts->total() }} YAZI
            </div>
            <div class="flex items-center gap-4">
                <select onchange="window.location.href='{{ request()->fullUrlWithQuery(['per_page' => '__PER_PAGE__', 'page' => 1]) }}'.replace('__PER_PAGE__', this.value)"
                        class="bg-white border border-gray-200 rounded-xl px-3 py-1.5 text-sm font-semibold text-gray-700 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
                {{ $posts->links('vendor.pagination.default') }}
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

    // Kategori Yönetimi
    function toggleCategoryManager() {
        const content = document.getElementById('category-manager-content');
        const arrow = document.getElementById('category-manager-arrow');
        content.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    function openAddCategoryModal() {
        document.getElementById('add-category-modal').classList.remove('hidden');
        document.getElementById('add-category-name').focus();
    }

    function closeAddCategoryModal() {
        document.getElementById('add-category-modal').classList.add('hidden');
        document.getElementById('add-category-form').reset();
    }

    document.getElementById('add-category-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('add-category-name').value.trim();
        if (name) {
            window.location.href = `{{ route('admin.blog.create') }}?category=${encodeURIComponent(name)}`;
        }
    });

    function openEditCategoryModal(categoryName) {
        const input = document.getElementById('edit-category-name');
        input.value = categoryName;
        input.dataset.originalName = categoryName;
        document.getElementById('edit-category-modal').classList.remove('hidden');
        input.focus();
    }

    function closeEditCategoryModal() {
        document.getElementById('edit-category-modal').classList.add('hidden');
    }

    document.getElementById('edit-category-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const categoryName = document.getElementById('edit-category-name').dataset.originalName;
        const newName = document.getElementById('edit-category-name').value.trim();
        const imageInput = document.getElementById('edit-category-image');
        
        if (!newName) {
            return;
        }

        const formData = new FormData();
        formData.append('name', newName);
        if (imageInput.files[0]) {
            formData.append('image', imageInput.files[0]);
        }

        const encodedName = encodeURIComponent(categoryName);
        fetch(`/admin/blog/category/${encodedName}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Bir hata oluştu.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Bir hata oluştu.');
        });
    });

    // Kategori görseli önizleme
    document.getElementById('edit-category-image')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('edit-category-image-preview');
                const img = document.getElementById('edit-category-preview-img');
                img.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    function openDeleteCategoryModal(categoryName, postCount) {
        const allCategories = @json($categoryStats->pluck('name'));
        const categories = allCategories.filter(cat => cat !== categoryName);
        const form = document.getElementById('delete-category-form');
        const message = document.getElementById('delete-category-message');
        const migrationSection = document.getElementById('category-migration-section');
        const select = document.getElementById('delete-new-category');
        
        const encodedName = encodeURIComponent(categoryName);
        form.dataset.categoryName = categoryName;
        
        select.innerHTML = '<option value="">Kategori Seçin</option>';
        categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat;
            option.textContent = cat;
            select.appendChild(option);
        });
        
        if (postCount > 0) {
            if (categories.length === 0) {
                message.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                        <p class="text-sm text-red-700 font-semibold">Bu kategoriyi silemezsiniz.</p>
                        <p class="text-xs text-red-600 mt-1">Önce yazıları başka bir kategoriye taşımalısınız.</p>
                    </div>
                `;
                migrationSection.classList.add('hidden');
                select.required = false;
            } else {
                message.innerHTML = `
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                        <p class="text-sm font-semibold text-amber-900 mb-1">Dikkat!</p>
                        <p class="text-sm text-amber-700 mb-2"><strong>"${categoryName}"</strong> kategorisinde <strong>${postCount}</strong> yazı bulunmaktadır.</p>
                        <p class="text-xs text-amber-600">Bu kategoriyi silmek için yazıların taşınacağı yeni bir kategori seçmelisiniz.</p>
                    </div>
                `;
                migrationSection.classList.remove('hidden');
                select.required = true;
            }
        } else {
            message.innerHTML = `
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <p class="text-sm font-semibold text-yellow-900 mb-1">Onay</p>
                    <p class="text-sm text-yellow-700"><strong>"${categoryName}"</strong> kategorisini silmek istediğinize emin misiniz?</p>
                    <p class="text-xs text-yellow-600 mt-1">Bu işlem geri alınamaz.</p>
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
    }

    document.getElementById('delete-category-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const categoryName = this.dataset.categoryName;
        const select = document.getElementById('delete-new-category');
        const newCategory = select.value;
        
        if (select.required && !newCategory) {
            alert('Lütfen yazıların taşınacağı kategoriyi seçin.');
            return;
        }
        
        deleteCategory(categoryName, newCategory || null);
    });

    function deleteCategory(categoryName, newCategory = null) {
        const encodedName = encodeURIComponent(categoryName);
        const url = `/admin/blog/category/${encodedName}`;
        const body = newCategory ? { new_category: newCategory } : {};
        
        fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(body)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Bir hata oluştu.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Bir hata oluştu.');
        });
    }
</script>
@endpush
@endsection
