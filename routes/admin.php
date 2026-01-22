<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\VehicleRequestController;
use App\Http\Controllers\Admin\EvaluationRequestController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ContactSettingsController;
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
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Araç Yönetimi
        Route::prefix('vehicles')->name('vehicles.')->group(function () {
            Route::get('/', [AdminVehicleController::class, 'index'])->name('index');
            Route::get('/create', [AdminVehicleController::class, 'create'])->name('create');
            Route::post('/', [AdminVehicleController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminVehicleController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminVehicleController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminVehicleController::class, 'destroy'])->name('destroy');
        });
        
        // Blog Yönetimi
        Route::prefix('blog')->name('blog.')->group(function () {
            Route::get('/', [AdminBlogController::class, 'index'])->name('index');
            Route::get('/create', [AdminBlogController::class, 'create'])->name('create');
            Route::post('/', [AdminBlogController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminBlogController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminBlogController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminBlogController::class, 'destroy'])->name('destroy');
        });
        
        // Site Ayarları
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::put('/', [SettingController::class, 'update'])->name('update');
        });
        
        // İletişim Sayfası Ayarları
        Route::prefix('contact-settings')->name('contact-settings.')->group(function () {
            Route::get('/', [ContactSettingsController::class, 'index'])->name('index');
            Route::put('/', [ContactSettingsController::class, 'update'])->name('update');
        });
        
        // Sayfa Yönetimi
        Route::prefix('pages')->name('pages.')->group(function () {
            Route::get('/', [AdminPageController::class, 'index'])->name('index');
            Route::get('/create', [AdminPageController::class, 'create'])->name('create');
            Route::post('/', [AdminPageController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminPageController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminPageController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminPageController::class, 'destroy'])->name('destroy');
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
        
        // İletişim Mesajları
        Route::prefix('contact-messages')->name('contact-messages.')->group(function () {
            Route::get('/', [ContactMessageController::class, 'index'])->name('index');
            Route::post('/bulk-action', [ContactMessageController::class, 'bulkAction'])->name('bulk-action');
            Route::get('/{id}', [ContactMessageController::class, 'show'])->name('show');
            Route::post('/{id}/read', [ContactMessageController::class, 'markAsRead'])->name('read');
            Route::post('/{id}/unread', [ContactMessageController::class, 'markAsUnread'])->name('unread');
            Route::delete('/{id}', [ContactMessageController::class, 'destroy'])->name('destroy');
            Route::delete('/all', [ContactMessageController::class, 'destroyAll'])->name('destroy-all');
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
            Route::post('/{id}/read', [EvaluationRequestController::class, 'markAsRead'])->name('read');
            Route::delete('/{id}', [EvaluationRequestController::class, 'destroy'])->name('destroy');
        });
        
        // Medya Yönetimi
        Route::prefix('media')->name('media.')->group(function () {
            Route::get('/', [MediaController::class, 'index'])->name('index');
            Route::post('/upload', [MediaController::class, 'upload'])->name('upload');
            Route::delete('/delete', [MediaController::class, 'destroy'])->name('destroy');
        });
    });
});
