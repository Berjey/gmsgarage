@extends('admin.layouts.app')

@section('title', $page->title . ' - Düzenle')
@section('page-title', 'Yasal Sayfa Düzenle')

@push('styles')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Page Header -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $page->title }} - Düzenle</h1>
            <p class="text-gray-600 mt-1">Bu sayfadaki değişiklikler websitesinin her yerinde (footer, formlar) otomatik güncellenir</p>
        </div>
        <a href="{{ route('admin.legal-pages.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Geri Dön
        </a>
    </div>

    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Warning Card -->
    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <div class="flex-1">
                <h3 class="font-semibold text-yellow-900 mb-1">Dikkat!</h3>
                <p class="text-sm text-yellow-800">Bu sözleşme şu anda <strong>{{ $page->is_active ? 'aktif' : 'pasif' }}</strong> durumda ve web sitesinde <strong>{{ $page->is_required ? 'zorunlu' : 'isteğe bağlı' }}</strong> olarak işaretlenmiş. Yaptığınız değişiklikler anında yayına girecektir.</p>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('admin.legal-pages.update', $page->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">
                
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Başlık
                    </label>
                    <input type="text" 
                           name="title" 
                           value="{{ old('title', $page->title) }}" 
                           required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    <p class="mt-1 text-xs text-gray-500">Bu başlık footer ve formlarda görünecek</p>
                </div>

                <!-- Slug (Read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        URL Slug (Değiştirilemez)
                    </label>
                    <input type="text" 
                           value="{{ $page->slug }}" 
                           readonly
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
                    <p class="mt-1 text-xs text-gray-500">URL: {{ url('/sayfa/' . $page->slug) }}</p>
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        İçerik
                    </label>
                    <textarea id="contentEditor" name="content" class="w-full">{{ old('content', $page->content) }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">Bu içerik hem sayfa hem de modal'larda gösterilir</p>
                </div>

                <!-- Status Toggles - SADE VE KESİN -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Aktif/Pasif: Aktifse otomatik Footer'da görünür -->
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-800 rounded-lg border-2 border-green-200 dark:border-green-700">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Durum (Aktif/Pasif)
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><strong>Aktifse otomatik Footer'da görünür.</strong></p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ $page->is_active ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </div>

                    <!-- Formlarda Onay Checkbox Olarak Göster -->
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-800 rounded-lg border-2 border-blue-200 dark:border-blue-700">
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Formlarda Onay Zorunluluğu
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Bu sözleşme formlarda onay kutusu olarak görünsün.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_required_in_forms" value="1" {{ $page->is_required_in_forms ?? false ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>

                <!-- Version Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <strong>Mevcut Versiyon:</strong> v{{ $page->version }} | 
                            <strong>Son Güncelleme:</strong> {{ $page->updated_at->format('d.m.Y H:i') }}
                        </div>
                    </div>
                </div>

            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                <a href="{{ route('legal.show', $page->slug) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Canlı Önizleme
                </a>
                <div class="flex gap-3">
                    <a href="{{ route('admin.legal-pages.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                        İptal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Değişiklikleri Kaydet
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // CKEditor Başlatma
    CKEDITOR.replace('contentEditor', {
        height: 600,
        language: 'tr',
        toolbar: [
            { name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print'] },
            { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
            { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll'] },
            '/',
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
            '/',
            { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
            { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
        ],
        allowedContent: true,
        extraAllowedContent: 'div(*){*}[*];table(*){*}[*];tr(*){*}[*];td(*){*}[*];th(*){*}[*];tbody(*){*}[*];thead(*){*}[*];ul(*){*}[*];ol(*){*}[*];li(*){*}[*];p(*){*}[*];h1(*){*}[*];h2(*){*}[*];h3(*){*}[*];h4(*){*}[*];span(*){*}[*];strong(*){*}[*];em(*){*}[*];a(*){*}[*];img(*){*}[*]',
        removePlugins: 'elementspath',
        resize_enabled: false
    });
});
</script>
@endsection
