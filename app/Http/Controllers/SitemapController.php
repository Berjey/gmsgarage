<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\BlogPost;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $content = view('sitemap.index', [
            'vehicles' => Vehicle::active()->select('slug', 'updated_at')->get(),
            'blogPosts' => BlogPost::published()->select('slug', 'category', 'updated_at')->get(),
            'blogCategories' => BlogPost::published()
                ->select('category')
                ->distinct()
                ->pluck('category')
                ->filter(),
        ])->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
