@extends('admin.layouts.app')

@section('title', 'Blog Düzenle - Admin Panel')
@section('page-title', 'Blog Düzenle')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.blog.index') }}" class="hover:text-primary-600">Blog</a>
    <span>/</span>
    <span>Düzenle</span>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6">
        <form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Başlık</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        <option value="Haber" {{ old('category', $post->category) == 'Haber' ? 'selected' : '' }}>Haber</option>
                        <option value="Duyuru" {{ old('category', $post->category) == 'Duyuru' ? 'selected' : '' }}>Duyuru</option>
                        <option value="Teknoloji" {{ old('category', $post->category) == 'Teknoloji' ? 'selected' : '' }}>Teknoloji</option>
                        <option value="Rehber" {{ old('category', $post->category) == 'Rehber' ? 'selected' : '' }}>Rehber</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kısa Özet</label>
                <textarea name="excerpt" rows="3" required 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">İçerik (HTML)</label>
                <textarea name="content" rows="15" required 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 font-mono text-sm">{{ old('content', $post->content) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Öne Çıkan Görsel</label>
                    <div class="flex items-start space-x-4">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Mevcut" class="w-32 h-24 object-cover rounded-lg border border-gray-200">
                        <div class="flex-1">
                            <input type="file" name="image" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Durum</label>
                    <div class="flex items-center space-x-4 mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }} 
                                   class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <span class="ml-2 text-sm text-gray-900">Yayında</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }} 
                                   class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <span class="ml-2 text-sm text-gray-900">Öne Çıkar</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('admin.blog.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    İptal
                </a>
                <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-bold transition-colors shadow-lg shadow-primary-500/20">
                    Güncelle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
