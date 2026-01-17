<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Data\CarBrands;
use App\Data\TurkishCities;
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

        if ($request->has('fuel_type') && is_array($request->fuel_type) && count($request->fuel_type) > 0) {
            $query->whereIn('fuel_type', $request->fuel_type);
        } elseif ($request->has('fuel_type') && $request->fuel_type) {
            $query->where('fuel_type', $request->fuel_type);
        }

        if ($request->has('body_type') && $request->body_type) {
            $query->where('body_type', $request->body_type);
        }

        if ($request->has('min_year') && $request->min_year) {
            $query->where('year', '>=', $request->min_year);
        }

        if ($request->has('max_year') && $request->max_year) {
            $query->where('year', '<=', $request->max_year);
        }

        if ($request->has('transmission') && is_array($request->transmission) && count($request->transmission) > 0) {
            $query->whereIn('transmission', $request->transmission);
        } elseif ($request->has('transmission') && $request->transmission) {
            $query->where('transmission', $request->transmission);
        }

        if ($request->has('min_km') && $request->min_km) {
            $query->where('kilometer', '>=', $request->min_km);
        }

        if ($request->has('max_km') && $request->max_km) {
            $query->where('kilometer', '<=', $request->max_km);
        }

        if ($request->has('horse_power') && $request->horse_power) {
            $query->where('horse_power', '>=', $request->horse_power);
        }

        if ($request->has('engine_size') && $request->engine_size) {
            $query->where('engine_size', $request->engine_size);
        }

        if ($request->has('color') && $request->color) {
            $query->where('color', $request->color);
        }

        // İlan Tarihi
        if ($request->has('ad_date') && $request->ad_date) {
            $dateFilter = $request->ad_date;
            
            switch ($dateFilter) {
                case '24h':
                    $query->where('created_at', '>=', now()->subHours(24));
                    break;
                case '3d':
                    $query->where('created_at', '>=', now()->subDays(3));
                    break;
                case '7d':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
                case '30d':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
            }
        }

        // Kelime ile Filtre
        if ($request->has('keyword') && $request->keyword) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%")
                  ->orWhere('brand', 'like', "%{$keyword}%")
                  ->orWhere('model', 'like', "%{$keyword}%");
            });
        }

        // Sıralama
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'km_asc':
                $query->orderBy('kilometer', 'asc');
                break;
            case 'km_desc':
                $query->orderBy('kilometer', 'desc');
                break;
            case 'year_asc':
                $query->orderBy('year', 'asc');
                break;
            case 'year_desc':
                $query->orderBy('year', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $vehicles = $query->paginate(12);

        // Filtreler için veriler
        $brands = CarBrands::all();
        $cities = TurkishCities::all();
        
        // Model yılları
        $currentYear = (int) date('Y');
        $years = range($currentYear + 1, 1990);

        return view('pages.vehicles.index', compact('vehicles', 'brands', 'cities', 'years'));
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

    /**
     * Satıcı profil sayfası
     */
    public function sellerProfile($slug)
    {
        // İleride bu bilgiler Seller modelinden gelecek
        // Şimdilik placeholder veriler
        $sellerData = [
            'name' => 'Ali Yılmaz',
            'slug' => 'ali-yilmaz',
            'position' => 'Kıdemli Satış Danışmanı',
            'is_verified' => true,
            'response_time' => '2 saat',
            'total_listings' => 45,
            'location' => 'İstanbul',
            'joined_date' => '2020-01-15',
        ];

        // Slug kontrolü
        if ($slug !== $sellerData['slug']) {
            abort(404);
        }

        // Aktif ilanlar (en son yayınlananlar)
        $activeVehicles = Vehicle::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Kaldırılan ilanlar (aktif olmayan)
        $inactiveVehicles = Vehicle::where('is_active', false)
            ->orderBy('updated_at', 'desc')
            ->limit(20)
            ->get();

        return view('pages.seller.profile', compact('sellerData', 'activeVehicles', 'inactiveVehicles'));
    }
}
