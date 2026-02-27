<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Blog listesi sayfası
     */
    public function index(Request $request)
    {
        $query = BlogPost::published()->orderByRaw('COALESCE(published_at, created_at) DESC');

        // Kategori filtresi
        if ($request->has('kategori') && $request->kategori) {
            $query->where('category', $request->kategori);
        }

        // Arama
        if ($request->has('arama') && $request->arama) {
            $searchTerm = $request->arama;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        $posts = $query->paginate(9);
        
        // Kategorileri al
        $categories = BlogPost::published()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $featuredPosts = BlogPost::featured()
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(3)
            ->get();

        return view('pages.blog.index', compact('posts', 'categories', 'featuredPosts'));
    }

    /**
     * Blog detay sayfası
     */
    public function show($slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();

        // Görüntülenme sayısını artır
        $post->incrementViews();

        // İlgili postlar (aynı kategoriden)
        $relatedPosts = BlogPost::published()
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Son postlar
        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        return view('pages.blog.show', compact('post', 'relatedPosts', 'recentPosts'));
    }

    /**
     * Kategori sayfası
     */
    public function category($category)
    {
        $posts = BlogPost::published()
            ->where('category', $category)
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate(9);

        $categories = BlogPost::published()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $featuredPosts = BlogPost::featured()
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->limit(3)
            ->get();

        return view('pages.blog.index', compact('posts', 'categories', 'category', 'featuredPosts'));
    }
}
