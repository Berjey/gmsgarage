<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Blog yazıları listesi
     */
    public function index(Request $request)
    {
        $query = BlogPost::query();

        // Arama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Kategori filtresi
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Durum filtresi
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            } elseif ($request->status === 'featured') {
                $query->where('is_featured', true);
            }
        }

        // Sıralama
        $sort = $request->get('sort', 'newest');
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'views') {
            $query->orderBy('views', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $perPage = $request->get('per_page', 15);
        $posts = $query->paginate($perPage)->withQueryString();
        
        // Kategoriler (sadece var olan ve boş olmayanlar)
        $categories = BlogPost::select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category', 'asc')
            ->pluck('category');

        // Kategori istatistikleri (kategori yönetimi için)
        $categoryStats = BlogPost::select('category', DB::raw('count(*) as post_count'))
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->groupBy('category')
            ->orderBy('category', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->category,
                    'post_count' => $item->post_count,
                ];
            });

        return view('admin.blog.index', compact('posts', 'categories', 'categoryStats'));
    }

    /**
     * Yeni blog yazısı formu
     */
    public function create(Request $request)
    {
        // Sabit kategoriler
        $defaultCategories = [
            'Araç Alım Satım Rehberi',
            'Sürücü Rehberi',
            'Otomobil Dünyası',
            'Otomobil Sözlüğü',
            'Araç Bakımı ve Onarımı',
            'Dünden Bugüne',
        ];

        // Veritabanından mevcut kategorileri çek
        $dbCategories = BlogPost::select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category', 'asc')
            ->pluck('category')
            ->toArray();

        // Kategorileri birleştir ve benzersiz yap
        $categories = array_unique(array_merge($defaultCategories, $dbCategories));
        sort($categories);

        // URL'den gelen kategori parametresini al
        $selectedCategory = $request->get('category');

        return view('admin.blog.create', compact('categories', 'selectedCategory'));
    }

    /**
     * Yeni blog yazısı kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
            'featured_image_url' => 'nullable|url',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords_string' => 'nullable|string',
            'category' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ], [
            'title.required' => 'Başlık zorunludur.',
            'excerpt.required' => 'Kısa özet zorunludur.',
            'content.required' => 'İçerik zorunludur.',
            'category.required' => 'Kategori zorunludur.',
        ]);

        // Checkbox değerlerini düzelt
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['is_published'] = $request->has('is_published') ? true : false;

        // Slug oluştur
        $validated['slug'] = Str::slug($validated['title']);
        
        // Slug benzersizliğini kontrol et
        $originalSlug = $validated['slug'];
        $counter = 1;
        while (BlogPost::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Meta keywords'ü array'e çevir
        if (isset($validated['meta_keywords_string']) && !empty($validated['meta_keywords_string'])) {
            $validated['meta_keywords'] = array_map('trim', explode(',', $validated['meta_keywords_string']));
            unset($validated['meta_keywords_string']);
        }

        // Meta title ve description varsayılanları
        if (empty($validated['meta_title'])) {
            $validated['meta_title'] = $validated['title'] . ' - GMSGARAGE Blog';
        }
        if (empty($validated['meta_description'])) {
            $validated['meta_description'] = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160);
        }

        // Author varsayılanı
        if (empty($validated['author'])) {
            $validated['author'] = 'GMSGARAGE';
        }

        // Görsel yükleme ve resize
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::random(10) . '.jpg';
            
            if (class_exists(\Intervention\Image\ImageManager::class)) {
                try {
                    // Intervention Image ile resize
                    $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                    $img = $manager->read($image->getRealPath());
                    
                    // Web sitesine uygun boyutlar: 1200x675 (16:9 aspect ratio)
                    $img->cover(1200, 675);
                    
                    // Kalite ayarı
                    $img->toJpeg(85);
                    
                    // Storage'a kaydet
                    $imagePath = 'blog/' . $imageName;
                    Storage::disk('public')->put($imagePath, (string) $img->encode());
                    
                    $validated['featured_image'] = asset('storage/' . $imagePath);
                } catch (\Exception $e) {
                    // Hata durumunda normal yükleme yap
                    $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('blog', $imageName, 'public');
                    $validated['featured_image'] = asset('storage/' . $imagePath);
                }
            } else {
                // Intervention Image yüklü değilse, normal yükleme yap
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('blog', $imageName, 'public');
                $validated['featured_image'] = asset('storage/' . $imagePath);
            }
        } elseif ($request->filled('featured_image_url')) {
            $validated['featured_image'] = $request->featured_image_url;
        }

        BlogPost::create($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Blog yazısı başarıyla eklendi.');
    }

    /**
     * Blog yazısı düzenleme formu
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        
        // Sabit kategoriler
        $defaultCategories = [
            'Araç Alım Satım Rehberi',
            'Sürücü Rehberi',
            'Otomobil Dünyası',
            'Otomobil Sözlüğü',
            'Araç Bakımı ve Onarımı',
            'Dünden Bugüne',
        ];

        // Veritabanından mevcut kategorileri çek
        $dbCategories = BlogPost::select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category', 'asc')
            ->pluck('category')
            ->toArray();

        // Kategorileri birleştir ve benzersiz yap
        $categories = array_unique(array_merge($defaultCategories, $dbCategories));
        sort($categories);

        return view('admin.blog.edit', compact('post', 'categories'));
    }

    /**
     * Blog yazısı güncelle
     */
    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:5120',
            'featured_image_url' => 'nullable|url',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords_string' => 'nullable|string',
            'category' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ], [
            'title.required' => 'Başlık zorunludur.',
            'excerpt.required' => 'Kısa özet zorunludur.',
            'content.required' => 'İçerik zorunludur.',
            'category.required' => 'Kategori zorunludur.',
        ]);

        // Checkbox değerlerini düzelt
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        $validated['is_published'] = $request->has('is_published') ? true : false;

        // Slug güncelle (eğer title değiştiyse)
        if ($post->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
            
            // Slug benzersizliğini kontrol et
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (BlogPost::where('slug', $validated['slug'])->where('id', '!=', $id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        // Meta keywords'ü array'e çevir
        if (isset($validated['meta_keywords_string']) && !empty($validated['meta_keywords_string'])) {
            $validated['meta_keywords'] = array_map('trim', explode(',', $validated['meta_keywords_string']));
            unset($validated['meta_keywords_string']);
        } else {
            $validated['meta_keywords'] = null;
        }

        // Meta title ve description varsayılanları
        if (empty($validated['meta_title'])) {
            $validated['meta_title'] = $validated['title'] . ' - GMSGARAGE Blog';
        }
        if (empty($validated['meta_description'])) {
            $validated['meta_description'] = $validated['excerpt'] ?? Str::limit(strip_tags($validated['content']), 160);
        }

        // Görsel yükleme ve resize
        if ($request->hasFile('featured_image')) {
            // Eski görseli sil (eğer storage'da ise)
            if ($post->featured_image && str_starts_with($post->featured_image, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $post->featured_image);
                Storage::disk('public')->delete($oldPath);
            }
            
            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::random(10) . '.jpg';
            
            if (class_exists(\Intervention\Image\ImageManager::class)) {
                try {
                    // Intervention Image ile resize
                    $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                    $img = $manager->read($image->getRealPath());
                    
                    // Web sitesine uygun boyutlar: 1200x675 (16:9 aspect ratio)
                    $img->cover(1200, 675);
                    
                    // Kalite ayarı
                    $img->toJpeg(85);
                    
                    // Storage'a kaydet
                    $imagePath = 'blog/' . $imageName;
                    Storage::disk('public')->put($imagePath, (string) $img->encode());
                    
                    $validated['featured_image'] = asset('storage/' . $imagePath);
                } catch (\Exception $e) {
                    // Hata durumunda normal yükleme yap
                    $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('blog', $imageName, 'public');
                    $validated['featured_image'] = asset('storage/' . $imagePath);
                }
            } else {
                // Intervention Image yüklü değilse, normal yükleme yap
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('blog', $imageName, 'public');
                $validated['featured_image'] = asset('storage/' . $imagePath);
            }
        } elseif ($request->filled('featured_image_url')) {
            $validated['featured_image'] = $request->featured_image_url;
        }

        $post->update($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Blog yazısı başarıyla güncellendi.');
    }

    /**
     * Blog yazısı sil
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog yazısı başarıyla silindi.');
    }

    /**
     * Öne çıkan durumunu değiştir
     */
    public function toggleFeatured(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $post->is_featured = $request->input('is_featured', false);
        $post->save();

        return response()->json([
            'success' => true,
            'is_featured' => $post->is_featured,
            'message' => $post->is_featured ? 'Yazı öne çıkarıldı.' : 'Yazı öne çıkandan kaldırıldı.'
        ]);
    }

    /**
     * Kategori güncelle (AJAX)
     */
    public function updateCategory(Request $request, $oldName)
    {
        $oldName = urldecode($oldName);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $newName = trim($validated['name']);

        if ($oldName === $newName && !$request->hasFile('image')) {
            return response()->json(['success' => false, 'message' => 'Kategori adı değişmedi.']);
        }

        // Kategori adı değişiyorsa kontrol et
        if ($oldName !== $newName) {
            $exists = BlogPost::where('category', $newName)
                ->where('category', '!=', $oldName)
                ->exists();

            if ($exists) {
                return response()->json(['success' => false, 'message' => 'Bu kategori adı zaten kullanılıyor.']);
            }

            $affected = BlogPost::where('category', $oldName)
                ->update(['category' => $newName]);
        }

        // Kategori görseli yükle
        $categoryImagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'category_' . Str::slug($newName ?: $oldName) . '_' . time() . '.jpg';
            
            if (class_exists(\Intervention\Image\ImageManager::class)) {
                try {
                    $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                    $img = $manager->read($image->getRealPath());
                    $img->cover(800, 450); // 16:9 aspect ratio
                    $img->toJpeg(85);
                    
                    $imagePath = 'blog/categories/' . $imageName;
                    Storage::disk('public')->put($imagePath, (string) $img->encode());
                    $categoryImagePath = asset('storage/' . $imagePath);
                } catch (\Exception $e) {
                    $imageName = 'category_' . Str::slug($newName ?: $oldName) . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $image->storeAs('blog/categories', $imageName, 'public');
                    $categoryImagePath = asset('storage/' . $imagePath);
                }
            } else {
                $imageName = 'category_' . Str::slug($newName ?: $oldName) . '_' . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('blog/categories', $imageName, 'public');
                $categoryImagePath = asset('storage/' . $imagePath);
            }
        }

        return response()->json([
            'success' => true,
            'message' => isset($affected) ? "Kategori güncellendi. ({$affected} yazı güncellendi)" : "Kategori güncellendi.",
            'image_url' => $categoryImagePath
        ]);
    }

    /**
     * Quill Editor için görsel yükleme (AJAX)
     */
    public function uploadContentImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB max
        ]);

        $image = $request->file('image');
        $imageName = 'content_' . time() . '_' . Str::random(10) . '.jpg';
        
        if (class_exists(\Intervention\Image\ImageManager::class)) {
            try {
                $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
                $img = $manager->read($image->getRealPath());
                
                // İçerik görselleri için maksimum genişlik 1200px, yükseklik orantılı
                $img->scale(width: 1200);
                
                $img->toJpeg(85);
                
                $imagePath = 'blog/content/' . $imageName;
                Storage::disk('public')->put($imagePath, (string) $img->encode());
                
                return response()->json([
                    'success' => true,
                    'url' => asset('storage/' . $imagePath)
                ]);
            } catch (\Exception $e) {
                $imageName = 'content_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('blog/content', $imageName, 'public');
                return response()->json([
                    'success' => true,
                    'url' => asset('storage/' . $imagePath)
                ]);
            }
        } else {
            $imageName = 'content_' . time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('blog/content', $imageName, 'public');
            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $imagePath)
            ]);
        }
    }

    /**
     * Kategori sil (AJAX)
     */
    public function deleteCategory(Request $request, $name)
    {
        $name = urldecode($name);
        
        $postCount = BlogPost::where('category', $name)->count();

        if ($postCount > 0) {
            $validated = $request->validate([
                'new_category' => 'required|string|max:255',
            ]);

            $newCategory = trim($validated['new_category']);

            if ($name === $newCategory) {
                return response()->json(['success' => false, 'message' => 'Yeni kategori mevcut kategoriyle aynı olamaz.']);
            }

            $affected = BlogPost::where('category', $name)
                ->update(['category' => $newCategory]);

            return response()->json([
                'success' => true,
                'message' => "Kategori silindi ve {$affected} yazı taşındı."
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kategori silindi.'
        ]);
    }
}
