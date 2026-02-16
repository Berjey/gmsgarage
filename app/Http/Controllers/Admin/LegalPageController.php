<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalPage;
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
            'is_required' => 'boolean',
        ]);

        $page->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
            'is_required' => $request->has('is_required'),
        ]);

        return redirect()->route('admin.legal-pages.index')
            ->with('success', 'Yasal metin başarıyla güncellendi. Versiyon: ' . $page->version);
    }
}
