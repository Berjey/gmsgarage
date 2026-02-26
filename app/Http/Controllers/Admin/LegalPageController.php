<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;
use App\Support\AdminPermissions;
use Illuminate\Http\Request;

class LegalPageController extends Controller
{
    public function index()
    {
        $pages = LegalPage::orderBy('title')->get();
        return view('admin.legal-pages.index', compact('pages'));
    }

    public function edit($id)
    {
        $page = LegalPage::findOrFail($id);
        return view('admin.legal-pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = LegalPage::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
            'is_required_in_forms' => 'boolean',
        ]);

        $page->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
            'is_required_in_forms' => $request->has('is_required_in_forms'),
        ]);

        return redirect()->route('admin.legal-pages.index')
            ->with('success', 'Yasal metin başarıyla güncellendi. Versiyon: ' . $page->version);
    }

    /**
     * API: Slug'a göre sayfa içeriğini getir (Footer ayarları için)
     */
    public function getBySlug(Request $request)
    {
        $slug = $request->get('slug');
        
        if (!$slug) {
            return response()->json(['content' => '', 'error' => 'Slug bulunamadı'], 404);
        }

        $page = LegalPage::where('slug', $slug)->first();

        if (!$page) {
            return response()->json(['content' => '', 'message' => 'Bu sayfa henüz oluşturulmamış'], 404);
        }

        return response()->json([
            'content' => $page->content,
            'title' => $page->title,
            'version' => $page->version
        ]);
    }

    /**
     * API: Sayfa içeriğini kaydet veya güncelle (Footer ayarları için).
     * Yalnızca admin rolü bu işlemi yapabilir.
     * Route middleware (role:admin) birincil katman; bu kontrol defense-in-depth.
     */
    public function storeOrUpdate(Request $request)
    {
        if (!AdminPermissions::can(auth()->user()->role, AdminPermissions::LEGAL_PAGE)) {
            return response()->json([
                'success' => false,
                'message' => 'Bu işlem için yetkiniz bulunmamaktadır.',
            ], 403);
        }

        $request->validate([
            'slug'    => 'required|string',
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $page = LegalPage::updateOrCreate(
            ['slug' => $request->slug],
            [
                'title'       => $request->title,
                'content'     => $request->content,
                'is_active'   => true,
                'is_required' => false,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'İçerik başarıyla kaydedildi.',
            'version' => $page->version,
        ]);
    }
}
