<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\VehicleEvaluationController;
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
Route::post('/iletisim', [PageController::class, 'contactSubmit'])->name('contact.submit');

// KVKK ve Yasal Sayfalar
Route::get('/kvkk', [PageController::class, 'kvkk'])->name('kvkk');
Route::get('/gizlilik-politikasi', [PageController::class, 'privacy'])->name('privacy');
Route::get('/kullanim-sartlari', [PageController::class, 'terms'])->name('terms');

// Araç İsteği
Route::get('/aracimi-bulamiyorum', [PageController::class, 'vehicleRequest'])->name('vehicle-request.index');
Route::post('/aracimi-bulamiyorum', [PageController::class, 'vehicleRequestSubmit'])->name('vehicle-request.submit');

// Araçlar
Route::get('/araclar', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/araclar/{slug}', [VehicleController::class, 'show'])->name('vehicles.show');

// Araç Değerleme
Route::get('/aracimi-degerle', [VehicleEvaluationController::class, 'index'])->name('evaluation.index');
Route::post('/aracimi-degerle/gonder', [VehicleEvaluationController::class, 'submit'])->name('evaluation.submit');
Route::get('/api/vehicle-models', [VehicleEvaluationController::class, 'getVehicleModels'])->name('evaluation.models');
Route::get('/api/vehicle-options', [VehicleEvaluationController::class, 'getVehicleOptions'])->name('evaluation.options');
Route::get('/api/vehicle-versions', [VehicleEvaluationController::class, 'getVehicleVersions'])->name('evaluation.versions');
