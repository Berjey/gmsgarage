<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Araçlar listeleme sayfası
     */
    public function index(Request $request)
    {
        $query = Vehicle::active();

        // Filtreleme
        if ($request->has('brand') && $request->brand) {
            $query->where('brand', $request->brand);
        }

        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('fuel_type') && $request->fuel_type) {
            $query->where('fuel_type', $request->fuel_type);
        }

        if ($request->has('body_type') && $request->body_type) {
            $query->where('body_type', $request->body_type);
        }

        $vehicles = $query->orderBy('created_at', 'desc')->paginate(12);

        // Filtreler için markalar
        $brands = Vehicle::active()->distinct()->pluck('brand')->sort();

        return view('pages.vehicles.index', compact('vehicles', 'brands'));
    }

    /**
     * Araç detay sayfası (slug ile)
     */
    public function show($slug)
    {
        $vehicle = Vehicle::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Benzer araçlar (aynı marka)
        $relatedVehicles = Vehicle::active()
            ->where('brand', $vehicle->brand)
            ->where('id', '!=', $vehicle->id)
            ->limit(4)
            ->get();

        return view('pages.vehicles.show', compact('vehicle', 'relatedVehicles'));
    }
}
