<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

        return view('admin.blog.index', compact('posts', 'categories'));
    }

    /**
     * Yeni blog yazısı formu
     */
    public function create()
    {
        $categories = [
            'Araç Alım Satım Rehberi',
            'Sürücü Rehberi',
            'Otomobil Dünyası',
            'Otomobil Sözlüğü',
            'Araç Bakımı ve Onarımı',
            'Dünden Bugüne',
        ];

        return view('admin.blog.create', compact('categories'));
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

        // Görsel yükleme
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('blog', $imageName, 'public');
            $validated['featured_image'] = Storage::url($imagePath);
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
        
        $categories = [
            'Araç Alım Satım Rehberi',
            'Sürücü Rehberi',
            'Otomobil Dünyası',
            'Otomobil Sözlüğü',
            'Araç Bakımı ve Onarımı',
            'Dünden Bugüne',
        ];

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

        // Görsel yükleme
        if ($request->hasFile('featured_image')) {
            // Eski görseli sil (eğer storage'da ise)
            if ($post->featured_image && str_starts_with($post->featured_image, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $post->featured_image);
                Storage::disk('public')->delete($oldPath);
            }
            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('blog', $imageName, 'public');
            $validated['featured_image'] = Storage::url($imagePath);
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
}
