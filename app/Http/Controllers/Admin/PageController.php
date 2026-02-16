<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of pages
     */
    public function index()
    {
        $pages = Page::orderBy('order')->orderBy('title')->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created page
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $page = new Page($request->all());
        if (empty($page->slug)) {
            $page->slug = Str::slug($page->title);
        }
        $page->save();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Sayfa başarıyla oluşturuldu.');
    }

    /**
     * Show the form for editing a page
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update a page
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $id,
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $page->fill($request->all());
        if (empty($page->slug)) {
            $page->slug = Str::slug($page->title);
        }
        $page->save();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Sayfa başarıyla güncellendi.');
    }

    /**
     * Remove a page
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Sayfa başarıyla silindi.');
    }

    /**
     * API: Get page content by slug
     * Used by settings page modal
     */
    public function getBySlug(Request $request)
    {
        $slug = $request->query('slug');
        
        if (!$slug) {
            return response()->json(['error' => 'Slug parameter is required'], 400);
        }
        
        // Slug'dan /kurumsal/ prefix'ini temizle
        $cleanSlug = str_replace('/kurumsal/', '', $slug);
        $cleanSlug = trim($cleanSlug, '/');
        
        $page = Page::where('slug', $cleanSlug)->first();
        
        if (!$page) {
            return response()->json([
                'content' => '',
                'title' => '',
                'message' => 'Sayfa henüz oluşturulmamış'
            ]);
        }
        
        return response()->json([
            'content' => $page->content ?? '',
            'title' => $page->title,
            'slug' => $page->slug
        ]);
    }

    /**
     * API: Store or update page content
     * Used by settings page modal
     */
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'slug' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);
        
        // Slug'dan /kurumsal/ prefix'ini temizle
        $cleanSlug = str_replace('/kurumsal/', '', $request->slug);
        $cleanSlug = trim($cleanSlug, '/');
        
        $page = Page::updateOrCreate(
            ['slug' => $cleanSlug],
            [
                'title' => $request->title,
                'content' => $request->content,
                'is_active' => true,
            ]
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Sayfa içeriği başarıyla kaydedildi',
            'page' => [
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
            ]
        ]);
    }
}
