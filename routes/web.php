<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\VehicleEvaluationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\LegalPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Anasayfa
Route::get('/', [HomeController::class, 'index'])->name('home');

// Hakkımızda
Route::get('/hakkimizda', [PageController::class, 'about'])->name('about');

// İletişim
Route::get('/iletisim', [PageController::class, 'contact'])->name('contact');
Route::post('/iletisim', [PageController::class, 'contactSubmit'])->middleware('throttle:5,1')->name('contact.submit');

// Yasal Sayfalar (Merkezi Sistem)
Route::get('/sayfa/{slug}', [LegalPageController::class, 'show'])->name('legal.show');
Route::get('/api/legal/{slug}', [LegalPageController::class, 'getContent'])->name('legal.content');

// Geriye uyumluluk için redirect'ler
Route::redirect('/kvkk', '/sayfa/kvkk-aydinlatma-metni');
Route::redirect('/kullanim-sartlari', '/sayfa/kullanim-sartlari');

// Araçlar
Route::get('/araclar', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/araclar/{slug}', [VehicleController::class, 'show'])->name('vehicles.show');

// Araç Değerleme
Route::get('/aracimi-degerle', [VehicleEvaluationController::class, 'index'])->name('evaluation.index');
Route::post('/aracimi-degerle/gonder', [VehicleEvaluationController::class, 'submit'])->middleware('throttle:10,1')->name('evaluation.submit');
Route::get('/api/arabam/brands', [VehicleEvaluationController::class, 'getArabamBrands'])->name('api.arabam.brands');
Route::get('/api/arabam/step', [VehicleEvaluationController::class, 'getArabamStepData'])->name('api.arabam.step');

// Landing Page
Route::get('/landing', [PageController::class, 'landing'])->name('landing');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/kategori/{category}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
