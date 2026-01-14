<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleEvaluationController extends Controller
{
    /**
     * Araç değerleme sayfası - Adım 1
     */
    public function index(Request $request)
    {
        $brands = Vehicle::active()->distinct()->pluck('brand')->sort();
        $bodyTypes = Vehicle::active()->distinct()->pluck('body_type')->filter()->sort();
        
        // URL parametrelerinden gelen değerler
        $selectedTip = $request->get('tip', 'AUTO');
        $selectedYil = $request->get('yil');
        $selectedMarka = $request->get('marka');
        
        return view('pages.evaluation.index', compact('brands', 'bodyTypes', 'selectedTip', 'selectedYil', 'selectedMarka'));
    }

    /**
     * Araç değerleme - Adım 2 (Donanım, Kilometre, Renk, Tramer)
     */
    public function step2(Request $request)
    {
        $request->validate([
            'tip' => 'required|in:AUTO,SUV,TICARI',
            'yil' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'marka' => 'required|string',
            'model' => 'nullable|string',
            'gövde_tipi' => 'nullable|string',
            'yakıt_tipi' => 'nullable|string',
            'vites_tipi' => 'nullable|string',
        ]);

        return view('pages.evaluation.step2', [
            'data' => $request->all()
        ]);
    }

    /**
     * Araç değerleme - Adım 3 (Ekspertiz)
     */
    public function step3(Request $request)
    {
        $request->validate([
            'tip' => 'required',
            'yil' => 'required',
            'marka' => 'required',
            'donanım_paketi' => 'nullable|string',
            'kilometre' => 'required|integer|min:1',
            'renk' => 'nullable|string',
            'tramer' => 'nullable|in:Yok,Var',
        ]);

        return view('pages.evaluation.step3', [
            'data' => $request->all()
        ]);
    }

    /**
     * Araç değerleme - Adım 4 (Kişisel Bilgiler)
     */
    public function step4(Request $request)
    {
        $request->validate([
            'tip' => 'required',
            'yil' => 'required',
            'marka' => 'required',
            'kilometre' => 'required',
            'ekspertiz' => 'nullable|array',
        ]);

        return view('pages.evaluation.step4', [
            'data' => $request->all()
        ]);
    }

    /**
     * Araç değerleme - Sonuç
     */
    public function result(Request $request)
    {
        $request->validate([
            'tip' => 'required',
            'yil' => 'required',
            'marka' => 'required',
            'kilometre' => 'required',
            'ad' => 'required|string|max:255',
            'soyad' => 'required|string|max:255',
            'telefon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'şehir' => 'required|string|max:255',
        ]);

        // Dummy fiyat hesaplama (gerçek hesaplama Faz 2'de yapılacak)
        $basePrice = 500000; // Örnek base fiyat
        $yearMultiplier = ($request->yil - 2000) * 10000;
        $kmMultiplier = max(0, 200000 - $request->kilometre) * 2;
        $estimatedPrice = $basePrice + $yearMultiplier + $kmMultiplier;

        return view('pages.evaluation.result', [
            'data' => $request->all(),
            'estimatedPrice' => $estimatedPrice
        ]);
    }
}
