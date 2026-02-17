<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\VehicleRequestController;
use App\Http\Controllers\Admin\EvaluationRequestController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SitemapController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\LegalPageController as AdminLegalPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin Auth Routes (Login/Logout)
Route::prefix('admin')->name('admin.')->group(function () {
    // Ana admin route - login sayfasına yönlendir
    Route::get('/', function () {
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });
    
    // Login sayfası (guest middleware ile)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    });
    
    // Logout (auth middleware ile)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin paneli (admin middleware ile korumalı)
    Route::middleware(['auth', 'admin'])->group(function () {
        // Dashboard - Herkes erişebilir
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Profil - Herkes erişebilir
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile/update-info', [ProfileController::class, 'updateInfo'])->name('profile.update-info');
        Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
        
        // ============================================
        // SADECE ADMIN (Süper Yönetici)
        // ============================================
        Route::middleware(['role:admin'])->group(function () {
            // Site Ayarları
            Route::prefix('settings')->name('settings.')->group(function () {
                Route::get('/', [SettingController::class, 'index'])->name('index');
                Route::put('/', [SettingController::class, 'update'])->name('update');
                
                // Footer'dan Yasal Sayfa Yönetimi
                Route::post('/add-legal-page', [SettingController::class, 'addLegalPage'])->name('add-legal-page');
                Route::delete('/delete-legal-page/{id}', [SettingController::class, 'deleteLegalPage'])->name('delete-legal-page');
            });
            
            // Yasal Sayfalar Yönetimi
            Route::prefix('legal-pages')->name('legal-pages.')->group(function () {
                Route::get('/', [AdminLegalPageController::class, 'index'])->name('index');
                Route::get('/{id}/edit', [AdminLegalPageController::class, 'edit'])->name('edit');
                Route::put('/{id}', [AdminLegalPageController::class, 'update'])->name('update');
            });
            
            // Kullanıcı Yönetimi
            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/', [UserController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
                Route::put('/{id}', [UserController::class, 'update'])->name('update');
                Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
            });
            
            // Sitemap Yönetimi
            Route::prefix('sitemap')->name('sitemap.')->group(function () {
                Route::get('/', [SitemapController::class, 'index'])->name('index');
                Route::post('/generate', [SitemapController::class, 'generate'])->name('generate');
                Route::get('/preview', [SitemapController::class, 'preview'])->name('preview');
            });
        });
        
        // ============================================
        // ADMIN + MANAGER (Galeri Yöneticisi)
        // ============================================
        Route::middleware(['role:admin,manager'])->group(function () {
            // Araç Yönetimi
            Route::prefix('vehicles')->name('vehicles.')->group(function () {
                Route::get('/', [AdminVehicleController::class, 'index'])->name('index');
                Route::get('/create', [AdminVehicleController::class, 'create'])->name('create');
                Route::post('/', [AdminVehicleController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [AdminVehicleController::class, 'edit'])->name('edit');
                Route::put('/{id}', [AdminVehicleController::class, 'update'])->name('update');
                Route::delete('/{id}', [AdminVehicleController::class, 'destroy'])->name('destroy');
                
                // API endpoints for vehicle form
                Route::get('/api/brands', [AdminVehicleController::class, 'getBrands'])->name('api.brands');
                Route::get('/api/models', [AdminVehicleController::class, 'getModels'])->name('api.models');
            });
            
            // İletişim Mesajları
            Route::prefix('contact-messages')->name('contact-messages.')->group(function () {
                Route::get('/', [ContactMessageController::class, 'index'])->name('index');
                Route::post('/bulk-action', [ContactMessageController::class, 'bulkAction'])->name('bulk-action');
                Route::delete('/destroy-all', [ContactMessageController::class, 'destroyAll'])->name('destroy-all');
                Route::get('/{id}', [ContactMessageController::class, 'show'])->name('show');
                Route::post('/{id}/read', [ContactMessageController::class, 'markAsRead'])->name('read');
                Route::post('/{id}/unread', [ContactMessageController::class, 'markAsUnread'])->name('unread');
                Route::delete('/{id}', [ContactMessageController::class, 'destroy'])->name('destroy');
            });
            
            // Araç İstekleri
            Route::prefix('vehicle-requests')->name('vehicle-requests.')->group(function () {
                Route::get('/', [VehicleRequestController::class, 'index'])->name('index');
                Route::get('/{id}', [VehicleRequestController::class, 'show'])->name('show');
                Route::post('/{id}/read', [VehicleRequestController::class, 'markAsRead'])->name('read');
                Route::delete('/{id}', [VehicleRequestController::class, 'destroy'])->name('destroy');
            });
            
            // Değerleme İstekleri
            Route::prefix('evaluation-requests')->name('evaluation-requests.')->group(function () {
                Route::get('/', [EvaluationRequestController::class, 'index'])->name('index');
                Route::get('/{id}', [EvaluationRequestController::class, 'show'])->name('show');
                Route::get('/{id}/pdf', [EvaluationRequestController::class, 'downloadPdf'])->name('pdf');
                Route::post('/{id}/read', [EvaluationRequestController::class, 'markAsRead'])->name('read');
                Route::delete('/{id}', [EvaluationRequestController::class, 'destroy'])->name('destroy');
            });
            
        });
        
        // ============================================
        // HERKES (Admin + Manager + Editor)
        // ============================================
        Route::middleware(['role:admin,manager,editor'])->group(function () {
            // Müşteri Yönetimi (CRM) - HERKES ERİŞEBİLİR
            Route::prefix('customers')->name('customers.')->group(function () {
                Route::get('/', [CustomerController::class, 'index'])->name('index');
                Route::get('/export', [CustomerController::class, 'export'])->name('export'); // Excel/CSV Export
                Route::post('/send-bulk-email', [CustomerController::class, 'sendBulkEmail'])->name('send-bulk-email'); // Toplu Mail
                Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('edit');
                Route::put('/{id}', [CustomerController::class, 'update'])->name('update');
                Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('destroy');
            });
            // Blog Yönetimi
            Route::prefix('blog')->name('blog.')->group(function () {
                Route::get('/', [AdminBlogController::class, 'index'])->name('index');
                Route::get('/create', [AdminBlogController::class, 'create'])->name('create');
                Route::post('/', [AdminBlogController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [AdminBlogController::class, 'edit'])->name('edit');
                Route::put('/{id}', [AdminBlogController::class, 'update'])->name('update');
                Route::post('/{id}/toggle-featured', [AdminBlogController::class, 'toggleFeatured'])->name('toggle-featured');
                Route::delete('/{id}', [AdminBlogController::class, 'destroy'])->name('destroy');
            });
            // Footer Ayarları API
            Route::prefix('api/pages')->name('api.pages.')->group(function () {
                Route::get('/get-by-slug', [AdminLegalPageController::class, 'getBySlug'])->name('get-by-slug');
                Route::post('/store-or-update', [AdminLegalPageController::class, 'storeOrUpdate'])->name('store-or-update');
            });
        });
    });
});
