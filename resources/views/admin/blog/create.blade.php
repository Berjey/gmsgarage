@extends('admin.layouts.app')

@section('title', 'Yeni Blog Yazısı Ekle - Admin Panel')
@section('page-title', 'Yeni Blog Yazısı')

@push('styles')
<!-- Quill Editor CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    /* Quill Editor Özelleştirme */
    .ql-container {
        font-size: 16px;
        font-family: inherit;
        border-bottom-left-radius: 0.75rem;
        border-bottom-right-radius: 0.75rem;
        border-color: #e5e7eb;
    }

    .ql-toolbar {
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
        border-color: #e5e7eb;
        background: #f9fafb;
    }

    .ql-editor {
        min-height: 300px;
        max-height: 600px;
        overflow-y: auto;
    }

    .ql-editor.ql-blank::before {
        color: #9ca3af;
        font-style: normal;
    }

    .ql-snow .ql-picker {
        color: #374151;
    }

    .ql-snow .ql-stroke {
        stroke: #374151;
    }

    .ql-snow .ql-fill {
        fill: #374151;
    }

    .ql-snow.ql-toolbar button:hover,
    .ql-snow .ql-toolbar button:hover,
    .ql-snow.ql-toolbar button.ql-active,
    .ql-snow .ql-toolbar button.ql-active {
        color: #e11d48;
    }

    .ql-snow.ql-toolbar button:hover .ql-stroke,
    .ql-snow .ql-toolbar button:hover .ql-stroke,
    .ql-snow.ql-toolbar button.ql-active .ql-stroke,
    .ql-snow .ql-toolbar button.ql-active .ql-stroke {
        stroke: #e11d48;
    }

    .ql-snow.ql-toolbar button:hover .ql-fill,
    .ql-snow .ql-toolbar button:hover .ql-fill,
    .ql-snow.ql-toolbar button.ql-active .ql-fill,
    .ql-snow .ql-toolbar button.ql-active .ql-fill {
        fill: #e11d48;
    }

    .collapse-trigger.active .arrow {
        transform: rotate(180deg);
    }

    .hero-custom-dropdown-panel {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 50;
        background: white;
        margin-top: 0.5rem;
        max-height: 300px;
        overflow-y: auto;
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
    
    #new-category-input {
        border-top: 2px solid #e5e7eb;
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Yeni Blog Yazısı Ekle</h1>
            <p class="mt-1 text-sm text-gray-500 font-medium tracking-wide uppercase">YENİ İÇERİK OLUŞTUR</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.blog.index') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Geri Dön
            </a>
        </div>
    </div>

    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Temel Bilgiler -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">Temel Bilgiler</h2>
                <p class="text-sm text-gray-500 mt-0.5">Yazının temel bilgilerini girin</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Başlık ve Kategori -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Başlık <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title-input"
                               value="{{ old('title') }}" 
                               required 
                               placeholder="Blog yazısının başlığını girin..."
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <!-- Slug Preview -->
                        <div class="mt-2 text-sm text-gray-500">
                            <span class="font-medium">URL Önizleme:</span>
                            <span class="text-primary-600" id="slug-preview">{{ config('app.url') }}/blog/</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <div class="relative hero-custom-dropdown" data-dropdown="category">
                            <button type="button" 
                                    class="hero-custom-dropdown-trigger w-full flex items-center justify-between px-4 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 font-medium hover:border-primary-500 transition-all"
                                    aria-expanded="false" aria-haspopup="listbox">
                                <span class="selected-text text-gray-500">Kategori Seçin</span>
                                <svg class="arrow w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="hero-custom-dropdown-panel rounded-xl shadow-xl border border-gray-100" role="listbox">
                                @foreach($categories as $cat)
                                <div class="hero-custom-dropdown-option {{ old('category') === $cat ? 'selected' : '' }}" data-value="{{ $cat }}" role="option">{{ $cat }}</div>
                                @endforeach
                                <div class="p-3 border-t-2 border-gray-200 bg-gray-50" id="new-category-input">
                                    <label class="block text-xs font-bold text-gray-600 mb-2">YENİ KATEGORİ EKLE</label>
                                    <div class="flex gap-2">
                                        <input type="text" 
                                               id="new-category-field"
                                               placeholder="Yeni kategori adı..."
                                               class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500">
                                        <button type="button" 
                                                onclick="addNewCategory()"
                                                class="px-4 py-2 bg-primary-600 text-white text-sm font-bold rounded-lg hover:bg-primary-700 transition-all">
                                            Ekle
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="category" id="category-input" value="{{ old('category') }}" required class="hero-custom-dropdown-native">
                        </div>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Kısa Özet -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Kısa Özet <span class="text-red-500">*</span>
                    </label>
                    <textarea name="excerpt" 
                              rows="3" 
                              required 
                              placeholder="Yazınızın kısa bir özetini girin (160 karakter önerilir)..."
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all resize-none">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- İçerik -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        İçerik <span class="text-red-500">*</span>
                    </label>
                    <div id="quill-editor" class="bg-white">{!! old('content') !!}</div>
                    <input type="hidden" name="content" id="content-input">
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Görsel -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">Öne Çıkan Görsel</h2>
                <p class="text-sm text-gray-500 mt-0.5">Blog yazısının kapak görselini ekleyin</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Dosya Yükleme -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Dosya Yükle</label>
                        <div class="relative">
                            <input type="file" 
                                   name="featured_image" 
                                   id="image-upload"
                                   accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 transition-all border border-gray-200 rounded-xl">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">PNG, JPG, GIF - Maksimum 5MB</p>
                    </div>

                    <!-- URL ile Görsel -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Veya Görsel URL'i</label>
                        <input type="url" 
                               name="featured_image_url" 
                               id="image-url"
                               placeholder="https://example.com/image.jpg"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                        <p class="mt-2 text-xs text-gray-500">Harici bir görsel URL'i girebilirsiniz</p>
                    </div>
                </div>

                <!-- Görsel Önizleme -->
                <div id="image-preview" class="hidden mt-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Önizleme</label>
                    <div class="relative inline-block">
                        <img id="preview-img" src="" alt="Önizleme" class="max-w-sm w-full h-auto rounded-xl border border-gray-200 shadow-sm">
                        <button type="button" 
                                onclick="clearImagePreview()"
                                class="absolute top-2 right-2 p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO & Meta Bilgiler (Collapsible) -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <button type="button" 
                    class="collapse-trigger w-full px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between hover:bg-gray-100/50 transition-colors"
                    onclick="toggleCollapse('seo-section')">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 text-left">SEO & Meta Bilgiler</h2>
                    <p class="text-sm text-gray-500 mt-0.5 text-left">Arama motoru optimizasyonu ayarları (İsteğe Bağlı)</p>
                </div>
                <svg class="arrow w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div id="seo-section" class="hidden">
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Meta Başlık</label>
                        <input type="text" 
                               name="meta_title" 
                               value="{{ old('meta_title') }}"
                               placeholder="SEO için optimize edilmiş başlık (boş bırakılırsa otomatik oluşturulur)"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                        <p class="mt-1 text-xs text-gray-500">Optimal uzunluk: 50-60 karakter</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Meta Açıklama</label>
                        <textarea name="meta_description" 
                                  rows="3"
                                  placeholder="Arama motorlarında görünecek açıklama (boş bırakılırsa otomatik oluşturulur)"
                                  class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all resize-none">{{ old('meta_description') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Optimal uzunluk: 150-160 karakter</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Meta Anahtar Kelimeler</label>
                        <input type="text" 
                               name="meta_keywords_string" 
                               value="{{ old('meta_keywords_string') }}"
                               placeholder="anahtar kelime, blog, yazı (virgülle ayırın)"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                        <p class="mt-1 text-xs text-gray-500">Virgülle ayrılmış anahtar kelimeler</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Yayın Ayarları -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-900">Yayın Ayarları</h2>
                <p class="text-sm text-gray-500 mt-0.5">Yazının yayın durumunu ve tarihini ayarlayın</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Durum Checkboxları -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Durum</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="inline-flex items-center px-4 py-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition-colors">
                                <input type="checkbox" 
                                       name="is_published" 
                                       value="1" 
                                       checked 
                                       class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                <span class="ml-3 text-sm font-bold text-gray-900">Yayında</span>
                            </label>
                            <label class="inline-flex items-center px-4 py-3 bg-gray-50 rounded-xl cursor-pointer hover:bg-gray-100 transition-colors">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       value="1" 
                                       class="w-5 h-5 text-amber-500 border-gray-300 rounded focus:ring-amber-500">
                                <span class="ml-3 text-sm font-bold text-gray-900">Öne Çıkar</span>
                            </label>
                        </div>
                    </div>

                    <!-- Yayın Tarihi -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Yayın Tarihi</label>
                        <input type="datetime-local" 
                               name="published_at" 
                               value="{{ old('published_at') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all">
                        <p class="mt-1 text-xs text-gray-500">Boş bırakılırsa şimdi yayınlanır</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-4 pb-8">
            <a href="{{ route('admin.blog.index') }}" 
               class="px-8 py-3 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all shadow-sm">
                İptal
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/25">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Yayınla
            </button>
        </div>
    </form>
</div>

@push('scripts')
<!-- Quill Editor JS -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Quill Editor Başlatma
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Blog yazınızı buraya yazın...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'font': [] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Form submit edildiğinde içeriği hidden input'a aktar
        const form = document.querySelector('form');
        const contentInput = document.getElementById('content-input');

        // Her değişiklikte içeriği kaydet
        quill.on('text-change', function() {
            contentInput.value = quill.root.innerHTML;
        });

        form.addEventListener('submit', function(e) {
            const content = quill.root.innerHTML;
            contentInput.value = content; // İçeriği tekrar set et
            
            // Boş içerik kontrolü
            if (quill.getText().trim().length === 0) {
                e.preventDefault();
                alert('Lütfen içerik girin!');
                return false;
            }
        });

        // Category Dropdown Handler
        const categoryDropdown = document.querySelector('[data-dropdown="category"]');
        if (categoryDropdown) {
            const trigger = categoryDropdown.querySelector('.hero-custom-dropdown-trigger');
            const panel = categoryDropdown.querySelector('.hero-custom-dropdown-panel');
            const hiddenInput = document.getElementById('category-input');
            const selectedText = trigger.querySelector('.selected-text');

            trigger.addEventListener('click', e => {
                e.stopPropagation();
                const isOpen = panel.classList.contains('open');
                panel.classList.toggle('open');
                trigger.setAttribute('aria-expanded', !isOpen);
            });

            categoryDropdown.querySelectorAll('.hero-custom-dropdown-option').forEach(opt => {
                opt.addEventListener('click', () => {
                    const value = opt.dataset.value;
                    hiddenInput.value = value;
                    selectedText.textContent = value;
                    selectedText.classList.remove('text-gray-500');
                    selectedText.classList.add('text-gray-900');
                    
                    // Remove selected class from all options
                    categoryDropdown.querySelectorAll('.hero-custom-dropdown-option').forEach(o => {
                        o.classList.remove('selected');
                    });
                    opt.classList.add('selected');
                    
                    panel.classList.remove('open');
                    trigger.setAttribute('aria-expanded', 'false');
                });
            });

            // Close dropdown on outside click
            document.addEventListener('click', () => {
                if (panel.classList.contains('open')) {
                    panel.classList.remove('open');
                    trigger.setAttribute('aria-expanded', 'false');
                }
            });

            // Prevent closing when clicking inside the new category input
            document.getElementById('new-category-input').addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }
    });

    // Add New Category Function
    function addNewCategory() {
        const input = document.getElementById('new-category-field');
        const newCategory = input.value.trim();
        
        if (!newCategory) {
            alert('Lütfen kategori adı girin!');
            return;
        }
        
        const categoryDropdown = document.querySelector('[data-dropdown="category"]');
        const panel = categoryDropdown.querySelector('.hero-custom-dropdown-panel');
        const hiddenInput = document.getElementById('category-input');
        const selectedText = categoryDropdown.querySelector('.selected-text');
        const newCategoryInput = document.getElementById('new-category-input');
        
        // Create new option
        const newOption = document.createElement('div');
        newOption.className = 'hero-custom-dropdown-option selected';
        newOption.setAttribute('data-value', newCategory);
        newOption.setAttribute('role', 'option');
        newOption.textContent = newCategory;
        
        // Remove selected class from all existing options
        categoryDropdown.querySelectorAll('.hero-custom-dropdown-option').forEach(o => {
            o.classList.remove('selected');
        });
        
        // Add click handler to new option
        newOption.addEventListener('click', () => {
            hiddenInput.value = newCategory;
            selectedText.textContent = newCategory;
            selectedText.classList.remove('text-gray-500');
            selectedText.classList.add('text-gray-900');
            
            categoryDropdown.querySelectorAll('.hero-custom-dropdown-option').forEach(o => {
                o.classList.remove('selected');
            });
            newOption.classList.add('selected');
            
            panel.classList.remove('open');
        });
        
        // Insert before the new category input section
        panel.insertBefore(newOption, newCategoryInput);
        
        // Set as selected
        hiddenInput.value = newCategory;
        selectedText.textContent = newCategory;
        selectedText.classList.remove('text-gray-500');
        selectedText.classList.add('text-gray-900');
        
        // Clear input and close dropdown
        input.value = '';
        panel.classList.remove('open');
    }

    // Allow Enter key to add category
    document.getElementById('new-category-field')?.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            addNewCategory();
        }
    });

    // Slug Preview
    const titleInput = document.getElementById('title-input');
    const slugPreview = document.getElementById('slug-preview');
    const baseUrl = '{{ config("app.url") }}/blog/';
    
    if (titleInput) {
        titleInput.addEventListener('input', function() {
            const slug = this.value
                .toLowerCase()
                .replace(/ğ/g, 'g')
                .replace(/ü/g, 'u')
                .replace(/ş/g, 's')
                .replace(/ı/g, 'i')
                .replace(/ö/g, 'o')
                .replace(/ç/g, 'c')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            
            slugPreview.textContent = baseUrl + (slug || 'ornek-baslik');
        });
    }

    // Image Preview
    const imageUpload = document.getElementById('image-upload');
    const imageUrl = document.getElementById('image-url');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    if (imageUpload) {
        imageUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
                imageUrl.value = '';
            }
        });
    }

    if (imageUrl) {
        imageUrl.addEventListener('input', function() {
            if (this.value) {
                previewImg.src = this.value;
                imagePreview.classList.remove('hidden');
                imageUpload.value = '';
            }
        });
    }

    function clearImagePreview() {
        imagePreview.classList.add('hidden');
        previewImg.src = '';
        imageUpload.value = '';
        imageUrl.value = '';
    }

    // Collapsible Sections
    function toggleCollapse(sectionId) {
        const section = document.getElementById(sectionId);
        const trigger = event.currentTarget;
        
        if (section.classList.contains('hidden')) {
            section.classList.remove('hidden');
            trigger.classList.add('active');
        } else {
            section.classList.add('hidden');
            trigger.classList.remove('active');
        }
    }
</script>
@endpush
@endsection
