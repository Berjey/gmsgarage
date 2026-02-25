<?php

namespace App\Http\Controllers;

use App\Models\LegalPage;
use Illuminate\Http\Request;

class LegalPageController extends Controller
{
    /**
     * Display the specified legal page
     */
    public function show($slug)
    {
        $page = LegalPage::getBySlug($slug);
        
        return view('legal-page', compact('page'));
    }

    /**
     * Get legal page content for AJAX modal
     */
    public function getContent($slug)
    {
        $page = LegalPage::getBySlug($slug);
        
        return response()->json([
            'title' => $page->title,
            'content' => $page->content,
            'version' => $page->version,
            'is_required' => !$page->is_optional_in_forms, // Opsiyonel ise scroll zorunlu değil
        ]);
    }
}
