<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredVehicles = Vehicle::featured()
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $brands = Vehicle::active()->distinct()->pluck('brand')->sort();
        $bodyTypes = Vehicle::active()->distinct()->pluck('body_type')->filter()->sort();

        return view('pages.home', compact('featuredVehicles', 'brands', 'bodyTypes'));
    }
}
