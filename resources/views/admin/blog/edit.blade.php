@extends('admin.layouts.app')

@section('title', 'Blog Yazısı Düzenle - Admin Panel')
@section('page-title', 'Blog Yazısı Düzenle')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.blog.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Blog</a>
    <span>/</span>
    <span>Düzenle</span>
@endsection

@push('styles')
<style>
    .editor-toolbar {
        display: flex;
        gap: 0.5rem;
        padding: 0.5rem;
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .dark .editor-toolbar {
        background: #2a2a2a;
        border-color: #404040;
    }
    .editor-content {
        min-height: 400px;
    }
</style>
@endpush

@section('content')
<div class="bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
    <div class="p-6">
        <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Info -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Temel Bilgiler</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Başlık *</label>
                        <input type="text" name="title" value="{{ old('title', $post->title) }}" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori *</label>
                        <select name="category" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Kategori Seçin</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $post->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kısa Özet</label>
                        <textarea name="excerpt" rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('excerpt', $post->excerpt) }}</textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">SEO için kısa bir özet yazın (160 karakter önerilir)</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">İçerik *</label>
                <textarea name="content" id="content" rows="20" required
                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 font-mono text-sm">{{ old('content', $post->content) }}</textarea>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">HTML etiketleri kullanabilirsiniz (h2, h3, p, ul, li, strong, em, blockquote, vb.)</p>
            </div>

            <!-- SEO -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">SEO Ayarları</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Başlık</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Boş bırakılırsa başlık kullanılır</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meta Açıklama</label>
                        <textarea name="meta_description" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('meta_description', $post->meta_description) }}</textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Boş bırakılırsa özet kullanılır</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Öne Çıkan Görsel</label>
                        <div class="space-y-2">
                            @if($post->featured_image)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mevcut Görsel</label>
                                <img src="{{ $post->featured_image }}" alt="Mevcut görsel" class="w-48 h-48 object-cover rounded-lg border border-gray-300 dark:border-gray-700">
                            </div>
                            @endif
                            <div class="flex items-center space-x-4">
                                <input type="file" name="featured_image" id="featured_image" accept="image/*" 
                                       class="hidden" onchange="previewImage(this, 'featured_preview')">
                                <label for="featured_image" 
                                       class="cursor-pointer px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#1e1e1e] transition-colors">
                                    {{ $post->featured_image ? 'Görsel Değiştir' : 'Görsel Seç' }}
                                </label>
                                <div id="featured_preview" class="hidden">
                                    <img id="featured_preview_img" src="" alt="Önizleme" class="w-32 h-32 object-cover rounded-lg border border-gray-300 dark:border-gray-700">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Veya URL ile ekleyin:</p>
                            <input type="url" name="featured_image_url" value="{{ old('featured_image_url', $post->featured_image) }}" placeholder="https://..."
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Seçenekler</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yazar</label>
                        <input type="text" name="author" value="{{ old('author', $post->author) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yayın Tarihi</label>
                        <input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 border-gray-300 dark:border-gray-700 rounded focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Öne Çıkan Yazı</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 border-gray-300 dark:border-gray-700 rounded focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Yayınla</span>
                    </label>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-800">
                <a href="{{ route('admin.blog.index') }}" 
                   class="px-6 py-2 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-[#2a2a2a] transition-colors">
                    İptal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold transition-colors">
                    Güncelle
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            const img = document.getElementById(previewId + '_img');
            img.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
