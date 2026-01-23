<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\BlogPost;
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
            'staticPages' => 10,
        ];

        $stats['total'] = $stats['vehicles'] + $stats['blogPosts'] + $stats['blogCategories'] + $stats['staticPages'];

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

        $content = view('sitemap.index', [
            'vehicles' => $vehicles,
            'blogPosts' => $blogPosts,
            'blogCategories' => $blogCategories,
        ])->render();

        $path = public_path('sitemap.xml');
        File::put($path, $content);

        return redirect()->route('admin.sitemap.index')
            ->with('success', 'Sitemap başarıyla oluşturuldu! Toplam ' . ($vehicles->count() + $blogPosts->count() + $blogCategories->count() + 10) . ' URL eklendi.');
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

        $urls = collect();

        // Statik sayfalar
        $staticPages = [
            ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily', 'type' => 'Anasayfa'],
            ['loc' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly', 'type' => 'Hakkımızda'],
            ['loc' => route('contact'), 'priority' => '0.8', 'changefreq' => 'monthly', 'type' => 'İletişim'],
            ['loc' => route('vehicles.index'), 'priority' => '0.9', 'changefreq' => 'daily', 'type' => 'Araçlar'],
            ['loc' => route('evaluation.index'), 'priority' => '0.8', 'changefreq' => 'monthly', 'type' => 'Araç Değerleme'],
            ['loc' => route('vehicle-request.index'), 'priority' => '0.7', 'changefreq' => 'monthly', 'type' => 'Araç İsteği'],
            ['loc' => route('blog.index'), 'priority' => '0.9', 'changefreq' => 'daily', 'type' => 'Blog'],
            ['loc' => route('kvkk'), 'priority' => '0.3', 'changefreq' => 'yearly', 'type' => 'KVKK'],
            ['loc' => route('privacy'), 'priority' => '0.3', 'changefreq' => 'yearly', 'type' => 'Gizlilik'],
            ['loc' => route('terms'), 'priority' => '0.3', 'changefreq' => 'yearly', 'type' => 'Kullanım Şartları'],
        ];

        foreach ($staticPages as $page) {
            $urls->push($page);
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
