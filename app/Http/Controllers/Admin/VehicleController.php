<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Data\CarBrands;
use App\Data\VehicleFeatures;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * Araç listesi
     */
    public function index(Request $request)
    {
        $query = Vehicle::query();

        // Arama
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        // Filtreleme
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'featured') {
                $query->where('is_featured', true);
            }
        }

        $vehicles = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Yeni araç formu
     */
    public function create()
    {
        $brands = CarBrands::all();
        return view('admin.vehicles.create', compact('brands'));
    }

    /**
     * Yeni araç kaydet
     */
    public function store(Request $request)
    {
        // Action'ı belirle (draft veya publish)
        $action = $request->input('action', 'draft');
        $isPublishing = ($action === 'publish');
        
        // Publish için zorunlu alanları kontrol et
        $requiredRule = $isPublishing ? 'required' : 'nullable';
        $mainImageRule = $isPublishing ? 'required|image|max:5120' : 'nullable|image|max:5120';
        
        $validated = $request->validate([
            // Temel Bilgiler (Publish için zorunlu)
            'title' => $requiredRule . '|string|max:255',
            'brand' => $requiredRule . '|string|max:255',
            'model' => $requiredRule . '|string|max:255',
            'year' => $requiredRule . '|integer|min:1990|max:' . (date('Y') + 1),
            'price' => $requiredRule . '|numeric|min:0',
            'kilometer' => $requiredRule . '|integer|min:0',
            
            // Teknik Özellikler (Opsiyonel)
            'package_version' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string',
            'transmission' => 'nullable|string',
            'drive_type' => 'nullable|in:Önden Çekiş,Arkadan İtiş,4x4',
            'body_type' => 'nullable|string|max:100',
            'door_count' => 'nullable|integer|min:2|max:5',
            'seat_count' => 'nullable|integer|min:2|max:9',
            'color' => 'nullable|string|max:255',
            'color_type' => 'nullable|string|max:50',
            'engine_size' => 'nullable|integer|min:0',
            'horse_power' => 'nullable|integer|min:0',
            'torque' => 'nullable|integer|min:0',
            
            // Hasar & Geçmiş
            'tramer_status' => 'nullable|in:Yok,Var,Bilinmiyor',
            'tramer_amount' => 'nullable|numeric|min:0',
            'painted_parts' => 'nullable|array',
            'replaced_parts' => 'nullable|array',
            'owner_number' => 'nullable|integer|min:1',
            'inspection_date' => 'nullable|date',
            'warranty_end_date' => 'nullable|date',
            
            // Donanımlar & Açıklama
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            
            // Medya
            'main_image' => $mainImageRule,
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:5120',
            
            // Durum
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            
            // Entegrasyon
            'sahibinden_url' => 'nullable|url|max:500',
            'sahibinden_id' => 'nullable|string|max:100',
        ], [
            'title.required' => 'Başlık zorunludur.',
            'brand.required' => 'Marka zorunludur.',
            'model.required' => 'Model zorunludur.',
            'year.required' => 'Yıl zorunludur.',
            'price.required' => 'Fiyat zorunludur.',
            'kilometer.required' => 'Kilometre zorunludur.',
            'main_image.required' => 'Ana görsel zorunludur.',
        ]);

        // Boolean değerleri düzenle
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        // Slug oluştur
        $validated['slug'] = Str::slug($validated['title']);
        
        // Slug benzersizliğini kontrol et
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (Vehicle::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Ana görsel yükleme
        if ($request->hasFile('main_image')) {
            $image = $request->file('main_image');
            $imageName = time() . '_main_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('vehicles', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        // Ek görseller yükleme
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('vehicles', $imageName, 'public');
                $images[] = $imagePath;
            }
        }
        
        // Ana görseli images array'ine de ekle (ilk sırada)
        if (isset($validated['image'])) {
            array_unshift($images, $validated['image']);
        }
        
        $validated['images'] = $images;

        Vehicle::create($validated);

        $message = $isPublishing ? 'Araç başarıyla kaydedildi ve yayınlandı.' : 'Araç taslak olarak kaydedildi.';
        return redirect()->route('admin.vehicles.index')->with('success', $message);
    }

    /**
     * Araç düzenleme formu
     */
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $brands = CarBrands::all();
        return view('admin.vehicles.edit', compact('vehicle', 'brands'));
    }

    /**
     * Araç güncelle
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $validated = $request->validate([
            // Temel Bilgiler (Zorunlu)
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'kilometer' => 'required|integer|min:0',
            
            // Teknik Özellikler (Opsiyonel)
            'package_version' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string',
            'transmission' => 'nullable|string',
            'drive_type' => 'nullable|in:Önden Çekiş,Arkadan İtiş,4x4',
            'body_type' => 'nullable|string|max:100',
            'door_count' => 'nullable|integer|min:2|max:5',
            'seat_count' => 'nullable|integer|min:2|max:9',
            'color' => 'nullable|string|max:255',
            'color_type' => 'nullable|string|max:50',
            'engine_size' => 'nullable|integer|min:0',
            'horse_power' => 'nullable|integer|min:0',
            'torque' => 'nullable|integer|min:0',
            
            // Hasar & Geçmiş
            'tramer_status' => 'nullable|in:Yok,Var,Bilinmiyor',
            'tramer_amount' => 'nullable|numeric|min:0',
            'painted_parts' => 'nullable|array',
            'replaced_parts' => 'nullable|array',
            'owner_number' => 'nullable|integer|min:1',
            'inspection_date' => 'nullable|date',
            'warranty_end_date' => 'nullable|date',
            
            // Donanımlar & Açıklama
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            
            // Medya
            'main_image' => 'nullable|image|max:5120',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:5120',
            
            // Durum
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            
            // Entegrasyon
            'sahibinden_url' => 'nullable|url|max:500',
            'sahibinden_id' => 'nullable|string|max:100',
        ], [
            'title.required' => 'Başlık zorunludur.',
            'brand.required' => 'Marka zorunludur.',
            'model.required' => 'Model zorunludur.',
            'year.required' => 'Yıl zorunludur.',
            'price.required' => 'Fiyat zorunludur.',
            'kilometer.required' => 'Kilometre zorunludur.',
        ]);

        // Boolean değerleri düzenle
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['is_active'] = $request->has('is_active') ? true : false;

        // Slug güncelle (eğer title değiştiyse)
        if ($vehicle->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
            
            // Slug benzersizliğini kontrol et
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Vehicle::where('slug', $validated['slug'])->where('id', '!=', $id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Ana görsel yükleme
        if ($request->hasFile('main_image')) {
            // Eski görseli sil
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            $image = $request->file('main_image');
            $imageName = time() . '_main_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('vehicles', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        // Ek görseller yükleme
        if ($request->hasFile('images')) {
            $existingImages = $vehicle->images ?? [];
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('vehicles', $imageName, 'public');
                $existingImages[] = $imagePath;
            }
            $validated['images'] = $existingImages;
        }

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')->with('success', 'Araç başarıyla güncellendi.');
    }

    /**
     * Araç sil
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')->with('success', 'Araç başarıyla silindi.');
    }

    /**
     * Get brands from database (API endpoint for vehicle form)
     */
    public function getBrands()
    {
        $brands = CarBrand::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get(['id', 'name', 'arabam_id']);

        return response()->json([
            'success' => true,
            'data' => [
                'Items' => $brands->map(function($brand) {
                    return [
                        'Id' => $brand->id,
                        'Name' => $brand->name,
                        'Value' => $brand->id,
                        'ArabamId' => $brand->arabam_id
                    ];
                })->toArray(),
                'SelectedItem' => null
            ]
        ]);
    }

    /**
     * Get models for a brand from database (API endpoint for vehicle form)
     */
    public function getModels(Request $request)
    {
        $brandId = $request->get('brandId');

        if (!$brandId) {
            return response()->json([
                'success' => false,
                'message' => 'Brand ID gerekli'
            ], 400);
        }

        $models = CarModel::where('car_brand_id', $brandId)
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get(['id', 'name', 'arabam_id']);

        return response()->json([
            'success' => true,
            'data' => [
                'Items' => $models->map(function($model) {
                    return [
                        'Id' => $model->id,
                        'Name' => $model->name,
                        'Value' => $model->id,
                        'ArabamId' => $model->arabam_id
                    ];
                })->toArray(),
                'SelectedItem' => null
            ]
        ]);
    }
}
