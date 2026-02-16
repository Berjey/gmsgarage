<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\CarBrand;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredVehicles = Vehicle::featured()
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Türkiye'deki tüm markaları al (veritabanından)
        $brands = CarBrand::orderBy('name')->get();
        
        // Veritabanından body type'ları al
        $bodyTypes = Vehicle::active()->distinct()->pluck('body_type')->filter()->sort()->values();
        
        // Model yılları listesi (mevcut yıl + 1'den 1990'a kadar)
        $currentYear = (int) date('Y');
        $years = range($currentYear + 1, 1990);
        
        // Araç tipleri
        $vehicleTypes = [
            'AUTO' => 'Otomobil',
            'SUV' => 'SUV',
            'TICARI' => 'Ticari',
            'MOTOSIKLET' => 'Motosiklet',
        ];

        return view('pages.home', compact('featuredVehicles', 'brands', 'bodyTypes', 'years', 'vehicleTypes'));
    }
}
