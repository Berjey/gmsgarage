@extends('admin.layouts.app')

@section('title', 'Araç Düzenle - Admin Panel')
@section('page-title', 'Araç Düzenle')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.vehicles.index') }}" class="hover:text-primary-600">Araçlar</a>
    <span>/</span>
    <span>Düzenle</span>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="p-6">
        <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Temel Bilgiler -->
                <div class="space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 border-b pb-2">Temel Bilgiler</h3>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">İlan Başlığı</label>
                        <input type="text" name="title" value="{{ old('title', $vehicle->title) }}" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Marka</label>
                            <input type="text" name="brand" value="{{ old('brand', $vehicle->brand) }}" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                            <input type="text" name="model" value="{{ old('model', $vehicle->model) }}" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Yıl</label>
                            <input type="number" name="year" value="{{ old('year', $vehicle->year) }}" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kilometre</label>
                            <input type="number" name="km" value="{{ old('km', $vehicle->km) }}" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fiyat (₺)</label>
                            <input type="number" name="price" value="{{ old('price', $vehicle->price) }}" required 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 font-bold text-primary-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Şehir</label>
                            <input type="text" name="city" value="{{ old('city', $vehicle->city) }}" required 
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
                                <option value="Benzin" {{ old('fuel_type', $vehicle->fuel_type) === 'Benzin' ? 'selected' : '' }}>Benzin</option>
                                <option value="Dizel" {{ old('fuel_type', $vehicle->fuel_type) === 'Dizel' ? 'selected' : '' }}>Dizel</option>
                                <option value="Hibrit" {{ old('fuel_type', $vehicle->fuel_type) === 'Hibrit' ? 'selected' : '' }}>Hibrit</option>
                                <option value="Elektrik" {{ old('fuel_type', $vehicle->fuel_type) === 'Elektrik' ? 'selected' : '' }}>Elektrik</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vites Tipi</label>
                            <select name="transmission" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                                <option value="Manuel" {{ old('transmission', $vehicle->transmission) === 'Manuel' ? 'selected' : '' }}>Manuel</option>
                                <option value="Otomatik" {{ old('transmission', $vehicle->transmission) === 'Otomatik' ? 'selected' : '' }}>Otomatik</option>
                                <option value="Yarı Otomatik" {{ old('transmission', $vehicle->transmission) === 'Yarı Otomatik' ? 'selected' : '' }}>Yarı Otomatik</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kasa Tipi</label>
                            <input type="text" name="body_type" value="{{ old('body_type', $vehicle->body_type) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Renk</label>
                            <input type="text" name="color" value="{{ old('color', $vehicle->color) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Motor Gücü (HP)</label>
                            <input type="number" name="engine_power" value="{{ old('engine_power', $vehicle->engine_power) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Motor Hacmi (cc)</label>
                            <input type="number" name="engine_size" value="{{ old('engine_size', $vehicle->engine_size) }}" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Açıklama -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">İlan Açıklaması</label>
                <textarea name="description" rows="6" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">{{ old('description', $vehicle->description) }}</textarea>
            </div>

            <!-- Görsel Yönetimi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ana Görsel</label>
                    <div class="flex items-start space-x-4">
                        <img src="{{ asset('storage/' . $vehicle->image) }}" alt="Mevcut görsel" class="w-48 h-48 object-cover rounded-lg border border-gray-300">
                        <div class="flex-1">
                            <label class="block">
                                <span class="sr-only">Yeni görsel seç</span>
                                <input type="file" name="image" onchange="previewMainImage(this)"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                            </label>
                            <img id="main_preview_img" src="" alt="Önizleme" class="mt-4 w-32 h-32 object-cover rounded-lg border border-gray-300 hidden">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Görselleri</label>
                    <input type="file" name="images[]" multiple onchange="previewGalleryImages(this)"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    <div id="gallery_preview" class="grid grid-cols-3 gap-2 mt-4">
                        @if($vehicle->images)
                            @foreach($vehicle->images as $img)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center text-white text-xs">Mevcut</div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Durum -->
            <div class="flex items-center space-x-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $vehicle->is_active) ? 'checked' : '' }} 
                           class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <span class="ml-2 text-sm font-medium text-gray-900">İlan Aktif</span>
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $vehicle->is_featured) ? 'checked' : '' }} 
                           class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <span class="ml-2 text-sm font-medium text-gray-900">Öne Çıkarılmış İlan</span>
                </label>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('admin.vehicles.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    İptal
                </a>
                <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-bold transition-colors shadow-lg shadow-primary-500/20">
                    Güncelle
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
        // keep existing images
        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `<img src="${e.target.result}" alt="Önizleme ${index + 1}" class="w-full h-24 object-cover rounded-lg border border-gray-300">`;
                    preview.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endsection
