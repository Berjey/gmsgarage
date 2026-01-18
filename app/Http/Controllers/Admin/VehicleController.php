<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Data\CarBrands;
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'kilometer' => 'nullable|integer|min:0',
            'fuel_type' => 'nullable|string',
            'transmission' => 'nullable|string',
            'body_type' => 'nullable|string',
            'color' => 'nullable|string|max:255',
            'engine_size' => 'nullable|string|max:50',
            'horse_power' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'images' => 'nullable|array',
            'main_image' => 'nullable|image|max:5120',
            'images.*' => 'nullable|image|max:5120',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sahibinden_url' => 'nullable|url',
        ], [
            'title.required' => 'Başlık zorunludur.',
            'brand.required' => 'Marka zorunludur.',
            'model.required' => 'Model zorunludur.',
            'year.required' => 'Yıl zorunludur.',
            'price.required' => 'Fiyat zorunludur.',
        ]);

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
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('vehicles', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        // Ek görseller yükleme
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('vehicles', $imageName, 'public');
                $images[] = $imagePath;
            }
            $validated['images'] = json_encode($images);
        }

        Vehicle::create($validated);

        return redirect()->route('admin.vehicles.index')->with('success', 'Araç başarıyla eklendi.');
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
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'kilometer' => 'nullable|integer|min:0',
            'fuel_type' => 'nullable|string',
            'transmission' => 'nullable|string',
            'body_type' => 'nullable|string',
            'color' => 'nullable|string|max:255',
            'engine_size' => 'nullable|string|max:50',
            'horse_power' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'images' => 'nullable|array',
            'main_image' => 'nullable|image|max:5120',
            'images.*' => 'nullable|image|max:5120',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sahibinden_url' => 'nullable|url',
        ], [
            'title.required' => 'Başlık zorunludur.',
            'brand.required' => 'Marka zorunludur.',
            'model.required' => 'Model zorunludur.',
            'year.required' => 'Yıl zorunludur.',
            'price.required' => 'Fiyat zorunludur.',
        ]);

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
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('vehicles', $imageName, 'public');
            $validated['image'] = $imagePath;
        }

        // Ek görseller yükleme
        if ($request->hasFile('images')) {
            $existingImages = $vehicle->images ? json_decode($vehicle->images, true) : [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('vehicles', $imageName, 'public');
                $existingImages[] = $imagePath;
            }
            $validated['images'] = json_encode($existingImages);
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
}
