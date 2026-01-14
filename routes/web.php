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

// Araçlar
Route::get('/araclar', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/araclar/{slug}', [VehicleController::class, 'show'])->name('vehicles.show');

// Araç Değerleme
Route::get('/aracimi-degerle', [VehicleEvaluationController::class, 'index'])->name('evaluation.index');
Route::post('/aracimi-degerle/adim-2', [VehicleEvaluationController::class, 'step2'])->name('evaluation.step2');
Route::post('/aracimi-degerle/adim-3', [VehicleEvaluationController::class, 'step3'])->name('evaluation.step3');
Route::post('/aracimi-degerle/adim-4', [VehicleEvaluationController::class, 'step4'])->name('evaluation.step4');
Route::post('/aracimi-degerle/sonuc', [VehicleEvaluationController::class, 'result'])->name('evaluation.result');
