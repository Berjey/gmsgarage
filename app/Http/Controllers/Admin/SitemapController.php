<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\BlogPost;
use App\Models\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemapPath = public_path('sitemap.xml');
        $lastGenerated = File::exists($sitemapPath) ? File::lastModified($sitemapPath) : null;

        $stats = [
            'vehicles' => Vehicle::active()->count(),
            'blogPosts' => BlogPost::published()->count(),
            'blogCategories' => BlogPost::published()->distinct('category')->count('category'),
            'legalPages' => LegalPage::where('is_active', true)->count(),
            'staticPages' => 6, // Anasayfa, Hakkımızda, İletişim, Araçlar, Değerleme, Blog
        ];

        $stats['total'] = $stats['vehicles'] + $stats['blogPosts'] + $stats['blogCategories'] + $stats['legalPages'] + $stats['staticPages'];

        return view('admin.sitemap.index', [
            'stats' => $stats,
            'lastGenerated' => $lastGenerated,
            'fileExists' => File::exists($sitemapPath),
        ]);
    }

    public function generate(Request $request)
    {
        $vehicles = Vehicle::active()->select('slug', 'updated_at')->get();
        $blogPosts = BlogPost::published()->select('slug', 'category', 'updated_at')->get();
        $blogCategories = BlogPost::published()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter();
        $legalPages = LegalPage::where('is_active', true)->select('slug')->get();

        $content = view('sitemap.index', [
            'vehicles' => $vehicles,
            'blogPosts' => $blogPosts,
            'blogCategories' => $blogCategories,
            'legalPages' => $legalPages,
        ])->render();

        $path = public_path('sitemap.xml');
        File::put($path, $content);

        $staticPageCount = 6; // Anasayfa, Hakkımızda, İletişim, Araçlar, Değerleme, Blog
        $totalUrls = $vehicles->count() + $blogPosts->count() + $blogCategories->count() + $legalPages->count() + $staticPageCount;

        return redirect()->route('admin.sitemap.index')
            ->with('success', 'Sitemap başarıyla oluşturuldu! Toplam ' . $totalUrls . ' URL eklendi.');
    }

    public function preview()
    {
        $vehicles = Vehicle::active()->select('slug', 'updated_at')->get();
        $blogPosts = BlogPost::published()->select('slug', 'category', 'updated_at')->get();
        $blogCategories = BlogPost::published()
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter();
        $legalPages = LegalPage::where('is_active', true)->select('slug', 'title')->get();

        $urls = collect();

        // Statik sayfalar
        $staticPages = [
            ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily', 'type' => 'Anasayfa'],
            ['loc' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly', 'type' => 'Hakkımızda'],
            ['loc' => route('contact'), 'priority' => '0.8', 'changefreq' => 'monthly', 'type' => 'İletişim'],
            ['loc' => route('vehicles.index'), 'priority' => '0.9', 'changefreq' => 'daily', 'type' => 'Araçlar'],
            ['loc' => route('evaluation.index'), 'priority' => '0.8', 'changefreq' => 'monthly', 'type' => 'Araç Değerleme'],
            ['loc' => route('blog.index'), 'priority' => '0.9', 'changefreq' => 'daily', 'type' => 'Blog'],
        ];

        foreach ($staticPages as $page) {
            $urls->push($page);
        }

        // Yasal Sayfalar (Dinamik)
        foreach ($legalPages as $legalPage) {
            $urls->push([
                'loc' => route('legal.show', $legalPage->slug),
                'priority' => '0.3',
                'changefreq' => 'yearly',
                'type' => 'Yasal - ' . $legalPage->title,
            ]);
        }

        // Araçlar
        foreach ($vehicles as $vehicle) {
            $urls->push([
                'loc' => route('vehicles.show', $vehicle->slug),
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'type' => 'Araç',
                'lastmod' => $vehicle->updated_at->format('Y-m-d'),
            ]);
        }

        // Blog kategorileri
        foreach ($blogCategories as $category) {
            $urls->push([
                'loc' => route('blog.category', $category),
                'priority' => '0.7',
                'changefreq' => 'weekly',
                'type' => 'Blog Kategori',
            ]);
        }

        // Blog yazıları
        foreach ($blogPosts as $post) {
            $urls->push([
                'loc' => route('blog.show', $post->slug),
                'priority' => '0.7',
                'changefreq' => 'monthly',
                'type' => 'Blog Yazısı',
                'lastmod' => $post->updated_at->format('Y-m-d'),
            ]);
        }

        return response()->json($urls);
    }
}
