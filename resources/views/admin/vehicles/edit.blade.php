@extends('admin.layouts.app')

@section('title', 'Araç Düzenle - Admin Panel')
@section('page-title', 'Araç Düzenle')
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Dashboard</a>
    <span>/</span>
    <a href="{{ route('admin.vehicles.index') }}" class="hover:text-primary-600 dark:hover:text-primary-400">Araçlar</a>
    <span>/</span>
    <span>Düzenle</span>
@endsection

@section('content')
<div class="bg-white dark:bg-[#252525] rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
    <div class="p-6">
        <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Info -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Temel Bilgiler</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Başlık *</label>
                        <input type="text" name="title" value="{{ old('title', $vehicle->title) }}" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Marka *</label>
                        <select name="brand" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Marka Seçin</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ old('brand', $vehicle->brand) === $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Model *</label>
                        <input type="text" name="model" value="{{ old('model', $vehicle->model) }}" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yıl *</label>
                        <input type="number" name="year" value="{{ old('year', $vehicle->year) }}" min="1990" max="{{ date('Y') + 1 }}" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fiyat (₺) *</label>
                        <input type="number" name="price" value="{{ old('price', $vehicle->price) }}" min="0" step="0.01" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kilometre</label>
                        <input type="number" name="kilometer" value="{{ old('kilometer', $vehicle->kilometer) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Özellikler</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yakıt Tipi</label>
                        <select name="fuel_type"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Seçiniz</option>
                            <option value="Benzin" {{ old('fuel_type', $vehicle->fuel_type) === 'Benzin' ? 'selected' : '' }}>Benzin</option>
                            <option value="Dizel" {{ old('fuel_type', $vehicle->fuel_type) === 'Dizel' ? 'selected' : '' }}>Dizel</option>
                            <option value="Hibrit" {{ old('fuel_type', $vehicle->fuel_type) === 'Hibrit' ? 'selected' : '' }}>Hibrit</option>
                            <option value="Elektrik" {{ old('fuel_type', $vehicle->fuel_type) === 'Elektrik' ? 'selected' : '' }}>Elektrik</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Vites Tipi</label>
                        <select name="transmission"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="">Seçiniz</option>
                            <option value="Manuel" {{ old('transmission', $vehicle->transmission) === 'Manuel' ? 'selected' : '' }}>Manuel</option>
                            <option value="Otomatik" {{ old('transmission', $vehicle->transmission) === 'Otomatik' ? 'selected' : '' }}>Otomatik</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kasa Tipi</label>
                        <input type="text" name="body_type" value="{{ old('body_type', $vehicle->body_type) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Renk</label>
                        <input type="text" name="color" value="{{ old('color', $vehicle->color) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Motor Hacmi</label>
                        <input type="text" name="engine_size" value="{{ old('engine_size', $vehicle->engine_size) }}" placeholder="Örn: 2.0"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Beygir Gücü</label>
                        <input type="number" name="horse_power" value="{{ old('horse_power', $vehicle->horse_power) }}" min="0"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Açıklama</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">{{ old('description', $vehicle->description) }}</textarea>
            </div>

            <!-- Images -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Görseller</h3>
                <div class="space-y-4">
                    @if($vehicle->image)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mevcut Ana Görsel</label>
                        <img src="{{ asset('storage/' . $vehicle->image) }}" alt="Mevcut görsel" class="w-48 h-48 object-cover rounded-lg border border-gray-300 dark:border-gray-700">
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $vehicle->image ? 'Yeni Ana Görsel (Değiştirmek için seçin)' : 'Ana Görsel' }}</label>
                        <div class="flex items-center space-x-4">
                            <input type="file" name="main_image" id="main_image" accept="image/*" 
                                   class="hidden" onchange="previewImage(this, 'main_preview')">
                            <label for="main_image" 
                                   class="cursor-pointer px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#1e1e1e] transition-colors">
                                {{ $vehicle->image ? 'Görsel Değiştir' : 'Görsel Seç' }}
                            </label>
                            <div id="main_preview" class="hidden">
                                <img id="main_preview_img" src="" alt="Önizleme" class="w-32 h-32 object-cover rounded-lg border border-gray-300 dark:border-gray-700">
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ek Görseller (Çoklu seçim yapabilirsiniz)</label>
                        <div class="flex items-center space-x-4">
                            <input type="file" name="images[]" id="images" accept="image/*" multiple
                                   class="hidden" onchange="previewMultipleImages(this, 'images_preview')">
                            <label for="images" 
                                   class="cursor-pointer px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#1e1e1e] transition-colors">
                                Görseller Seç
                            </label>
                        </div>
                        <div id="images_preview" class="grid grid-cols-4 gap-4 mt-4"></div>
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Seçenekler</h3>
                <div class="space-y-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $vehicle->is_featured) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 border-gray-300 dark:border-gray-700 rounded focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Öne Çıkan Araç</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $vehicle->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 border-gray-300 dark:border-gray-700 rounded focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                    </label>
                </div>
            </div>

            <!-- Sahibinden URL -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sahibinden.com URL</label>
                <input type="url" name="sahibinden_url" value="{{ old('sahibinden_url', $vehicle->sahibinden_url) }}"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-[#2a2a2a] text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-800">
                <a href="{{ route('admin.vehicles.index') }}" 
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

function previewMultipleImages(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Önizleme ${index + 1}" class="w-full h-32 object-cover rounded-lg border border-gray-300 dark:border-gray-700">
                    <button type="button" onclick="removeImagePreview(this)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">×</button>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}

function removeImagePreview(button) {
    button.parentElement.remove();
}
</script>
@endpush
@endsection
