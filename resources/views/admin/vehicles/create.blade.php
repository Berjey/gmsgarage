@extends('admin.layouts.app')

@section('title', 'Yeni Araç Ekle - Admin Panel')
@section('page-title', 'Yeni Araç Ekle')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.vehicles.index') }}" class="hover:text-primary-600">Araçlar</a>
    <span>/</span>
    <span>Yeni Ekle</span>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6">
        <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Temel Bilgiler -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Temel Bilgiler</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">İlan Başlığı</label>
                        <input type="text" name="title" value="{{ old('title') }}" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Marka</label>
                            <input type="text" name="brand" value="{{ old('brand') }}" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                            <input type="text" name="model" value="{{ old('model') }}" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Yıl</label>
                            <input type="number" name="year" value="{{ old('year', date('Y')) }}" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kilometre</label>
                            <input type="number" name="km" value="{{ old('km', 0) }}" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fiyat (₺)</label>
                            <input type="number" name="price" value="{{ old('price') }}" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 font-bold text-primary-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Şehir</label>
                            <input type="text" name="city" value="{{ old('city', 'İstanbul') }}" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                </div>

                <!-- Teknik Özellikler -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Teknik Özellikler</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Yakıt Tipi</label>
                            <select name="fuel_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                                <option value="Benzin">Benzin</option>
                                <option value="Dizel">Dizel</option>
                                <option value="Hibrit">Hibrit</option>
                                <option value="Elektrik">Elektrik</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vites Tipi</label>
                            <select name="transmission" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                                <option value="Manuel">Manuel</option>
                                <option value="Otomatik">Otomatik</option>
                                <option value="Yarı Otomatik">Yarı Otomatik</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kasa Tipi</label>
                            <input type="text" name="body_type" value="{{ old('body_type') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Renk</label>
                            <input type="text" name="color" value="{{ old('color') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Motor Gücü (HP)</label>
                            <input type="number" name="engine_power" value="{{ old('engine_power') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Motor Hacmi (cc)</label>
                            <input type="number" name="engine_size" value="{{ old('engine_size') }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Açıklama -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">İlan Açıklaması</label>
                <textarea name="description" rows="6" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">{{ old('description') }}</textarea>
            </div>

            <!-- Görsel Yükleme -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ana Görsel</label>
                    <label class="block">
                        <span class="sr-only">Dosya seç</span>
                        <input type="file" name="image" required onchange="previewMainImage(this)"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    </label>
                    <img id="main_preview_img" src="" alt="Önizleme" class="mt-4 w-48 h-48 object-cover rounded-lg border border-gray-300 hidden">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Görselleri</label>
                    <input type="file" name="images[]" multiple onchange="previewGalleryImages(this)"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    <div id="gallery_preview" class="grid grid-cols-3 gap-2 mt-4"></div>
                </div>
            </div>

            <!-- Durum -->
            <div class="flex items-center space-x-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked 
                           class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <span class="ml-2 text-sm font-medium text-gray-900">İlan Aktif</span>
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" 
                           class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <span class="ml-2 text-sm font-medium text-gray-900">Öne Çıkarılmış İlan</span>
                </label>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('admin.vehicles.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    İptal
                </a>
                <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-bold transition-colors shadow-lg shadow-primary-500/20">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewMainImage(input) {
        const preview = document.getElementById('main_preview_img');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewGalleryImages(input) {
        const preview = document.getElementById('gallery_preview');
        preview.innerHTML = '';
        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.innerHTML = `<img src="${e.target.result}" alt="Önizleme ${index + 1}" class="w-full h-24 object-cover rounded-lg border border-gray-300">`;
                    preview.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endsection
