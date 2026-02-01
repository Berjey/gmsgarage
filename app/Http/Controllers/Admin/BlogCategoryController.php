<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogCategoryController extends Controller
{
    /**
     * Kategori listesi
     */
    public function index(Request $request)
    {
        // Arama
        $search = $request->get('search', '');
        
        // Sıralama
        $sort = $request->get('sort', 'name_asc'); // name_asc, name_desc, posts_asc, posts_desc
        
        // Tüm kategorileri ve kullanım sayılarını getir
        $query = BlogPost::select('category', DB::raw('count(*) as post_count'))
            ->whereNotNull('category')
            ->where('category', '!=', '');
        
        // Arama filtresi
        if (!empty($search)) {
            $query->where('category', 'like', "%{$search}%");
        }
        
        $query->groupBy('category');
        
        // Sıralama
        switch ($sort) {
            case 'name_desc':
                $query->orderBy('category', 'desc');
                break;
            case 'posts_asc':
                $query->orderBy('post_count', 'asc');
                break;
            case 'posts_desc':
                $query->orderBy('post_count', 'desc');
                break;
            case 'name_asc':
            default:
                $query->orderBy('category', 'asc');
                break;
        }
        
        $categories = $query->get()->map(function ($item) {
            // Son yazıları getir
            $latestPosts = BlogPost::where('category', $item->category)
                ->select('id', 'title', 'is_published', 'created_at', 'views')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
            
            // Yayınlanmış yazı sayısı
            $publishedCount = BlogPost::where('category', $item->category)
                ->where('is_published', true)
                ->count();
            
            // Toplam görüntülenme
            $totalViews = BlogPost::where('category', $item->category)
                ->sum('views');
            
            return [
                'name' => $item->category,
                'post_count' => $item->post_count,
                'published_count' => $publishedCount,
                'draft_count' => $item->post_count - $publishedCount,
                'total_views' => $totalViews,
                'slug' => \Illuminate\Support\Str::slug($item->category),
                'latest_posts' => $latestPosts,
            ];
        });
        
        // İstatistikler
        $stats = [
            'total_categories' => $categories->count(),
            'total_posts' => BlogPost::whereNotNull('category')->where('category', '!=', '')->count(),
            'most_popular' => $categories->sortByDesc('post_count')->first(),
            'total_views' => BlogPost::whereNotNull('category')->where('category', '!=', '')->sum('views'),
        ];
        
        return view('admin.blog.categories.index', compact('categories', 'stats', 'search', 'sort'));
    }

    /**
     * Yeni kategori ekle
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Kategori adı zorunludur.',
        ]);

        $categoryName = trim($validated['name']);

        // Kategori zaten var mı kontrol et
        $exists = BlogPost::where('category', $categoryName)->exists();
        if ($exists) {
            return back()->withErrors(['name' => 'Bu kategori zaten mevcut.'])->withInput();
        }

        // Kategori ekleme işlemi - Blog yazısı oluşturma sayfasına yönlendir
        return redirect()->route('admin.blog.create', ['category' => $categoryName])
            ->with('info', "Kategori '{$categoryName}' eklendi. Şimdi bu kategori ile yeni bir blog yazısı oluşturabilirsiniz.");
    }

    /**
     * Kategori güncelle
     */
    public function update(Request $request, $oldName)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Kategori adı zorunludur.',
        ]);

        $newName = trim($validated['name']);

        // Aynı isimse değişiklik yok
        if ($oldName === $newName) {
            return redirect()->route('admin.blog.categories.index')
                ->with('info', 'Kategori adı değişmedi.');
        }

        // Yeni isim zaten başka bir kategoride kullanılıyor mu?
        $exists = BlogPost::where('category', $newName)
            ->where('category', '!=', $oldName)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'Bu kategori adı zaten kullanılıyor.'])->withInput();
        }

        // Tüm blog yazılarında kategoriyi güncelle
        $affected = BlogPost::where('category', $oldName)
            ->update(['category' => $newName]);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', "Kategori '{$oldName}' başarıyla '{$newName}' olarak güncellendi. ({$affected} yazı güncellendi)");
    }

    /**
     * Kategori sil
     */
    public function destroy(Request $request, $name)
    {
        // URL decode
        $name = urldecode($name);
        
        // Kategoriye ait yazı sayısını kontrol et
        $postCount = BlogPost::where('category', $name)->count();

        // Eğer yazı varsa, yeni kategori seçilmeli
        if ($postCount > 0) {
            $request->validate([
                'new_category' => 'required|string|max:255',
            ], [
                'new_category.required' => 'Yazıların taşınacağı yeni kategori seçilmelidir.',
            ]);

            $newCategory = trim($request->input('new_category'));

            // Yeni kategori mevcut kategoriyle aynı olamaz
            if ($name === $newCategory) {
                return back()->withErrors(['new_category' => 'Yeni kategori mevcut kategoriyle aynı olamaz.'])->withInput();
            }

            // Tüm yazıları yeni kategoriye taşı
            $affected = BlogPost::where('category', $name)
                ->update(['category' => $newCategory]);

            return redirect()->route('admin.blog.categories.index')
                ->with('success', "Kategori '{$name}' silindi ve {$affected} yazı '{$newCategory}' kategorisine taşındı.");
        }

        // Kategoriye ait yazı yoksa direkt sil (aslında zaten yok)
        return redirect()->route('admin.blog.categories.index')
            ->with('success', "Kategori '{$name}' silindi.");
    }

    /**
     * Kategori detayları (AJAX için)
     */
    public function show($name)
    {
        // URL decode
        $name = urldecode($name);
        
        $category = [
            'name' => $name,
            'post_count' => BlogPost::where('category', $name)->count(),
            'posts' => BlogPost::where('category', $name)
                ->select('id', 'title', 'is_published', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get(),
        ];

        return response()->json($category);
    }
}
