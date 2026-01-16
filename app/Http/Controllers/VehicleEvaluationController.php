<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleEvaluationController extends Controller
{
    /**
     * Araç değerleme sayfası - Step-by-step Wizard
     */
    public function index(Request $request)
    {
        try {
            // URL parametrelerinden gelen değerler (Hero'dan) - safe defaults
            $selectedTip = $request->get('tip') ?? '';
            $selectedYil = $request->get('yil') ?? '';
            $selectedMarka = $request->get('marka') ?? '';
            
            // Vehicle types
            $vehicleTypes = [
                'AUTO' => 'Otomobil',
                'SUV' => 'SUV',
                'TICARI' => 'Ticari',
                'MOTOSIKLET' => 'Motosiklet',
            ];
            
            // Fuel types
            $fuelTypes = [
                'BENZIN' => 'Benzin',
                'DIZEL' => 'Dizel',
                'HIBRIT' => 'Hibrit',
                'ELEKTRIK' => 'Elektrik',
            ];
            
            // Transmission types
            $transmissionTypes = [
                'MANUEL' => 'Manuel',
                'OTOMATIK' => 'Otomatik',
                'YARI_OTOMATIK' => 'Yarı Otomatik',
            ];
            
            // Damage status
            $damageStatuses = [
                'YOK' => 'Yok',
                'VAR' => 'Var',
                'BILMIYORUM' => 'Bilmiyorum',
            ];
            
            // Contact methods
            $contactMethods = [
                'TELEFON' => 'Telefon',
                'WHATSAPP' => 'WhatsApp',
                'EMAIL' => 'E-posta',
            ];
            
            // Render view with all required variables
            return view('pages.evaluation.wizard', compact(
                'selectedTip', 'selectedYil', 'selectedMarka', 
                'vehicleTypes', 'fuelTypes', 'transmissionTypes', 
                'damageStatuses', 'contactMethods'
            ));
            
        } catch (\Throwable $e) {
            \Log::error('evaluation.index error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->route('home')->with('error', 'Sayfa yüklenirken bir hata oluştu. Lütfen tekrar deneyin.');
        }
    }
    
    /**
     * Get vehicle models for a brand
     */
    public function getVehicleModels(Request $request)
    {
        $marka = $request->get('marka');
        
        if (!$marka) {
            return response()->json([
                'success' => false,
                'message' => 'Marka gerekli'
            ]);
        }
        
        $models = \App\Data\VehicleModels::getModels($marka);
        
        return response()->json([
            'success' => true,
            'models' => $models
        ]);
    }
    
    /**
     * Get vehicle options for hybrid system
     */
    public function getVehicleOptions(Request $request)
    {
        $marka = $request->get('marka');
        $model = $request->get('model');
        
        if (!$marka || !$model) {
            return response()->json([
                'success' => false,
                'message' => 'Marka ve model gerekli'
            ]);
        }
        
        $options = \App\Data\VehicleOptions::getOptions($marka, $model);
        
        if ($options) {
            return response()->json([
                'success' => true,
                'options' => $options
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Veri bulunamadı'
        ]);
    }
    
    /**
     * Get vehicle versions for a model
     */
    public function getVehicleVersions(Request $request)
    {
        $marka = $request->get('marka');
        $model = $request->get('model');
        
        if (!$marka || !$model) {
            return response()->json([
                'success' => false,
                'message' => 'Marka ve model gerekli'
            ]);
        }
        
        $options = \App\Data\VehicleOptions::getOptions($marka, $model);
        
        if ($options && isset($options['model_tipi']) && is_array($options['model_tipi'])) {
            return response()->json([
                'success' => true,
                'versions' => $options['model_tipi']
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Versiyon bulunamadı'
        ]);
    }
    
    /**
     * Submit evaluation form
     */
    public function submit(Request $request)
    {
        $request->validate([
            'tip' => 'required|in:AUTO,SUV,TICARI,MOTOSIKLET',
            'yil' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'marka' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'gövde_tipi' => 'nullable|string|max:255',
            'gövde_tipi_manual' => 'nullable|string|max:255',
            'yakıt_tipi_manual' => 'nullable|string|max:255',
            'vites_tipi_manual' => 'nullable|string|max:255',
            'model_tipi_manual' => 'nullable|string|max:255',
            'yakıt_tipi' => 'nullable|in:BENZIN,DIZEL,HIBRIT,ELEKTRIK',
            'vites_tipi' => 'nullable|in:MANUEL,OTOMATIK,YARI_OTOMATIK',
            'model_tipi' => 'nullable|string|max:255',
            'donanım_paketi' => 'nullable|string|max:255',
            'kilometre' => 'required|integer|min:0|max:9999999',
            'renk' => 'nullable|string|max:255',
            'tramer' => 'required|in:YOK,VAR',
            'tramer_tutarı' => 'nullable|required_if:tramer,VAR|numeric|min:0',
            'ekspertiz' => 'nullable|array',
            'ad' => 'required|string|max:255',
            'soyad' => 'required|string|max:255',
            'telefon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'şehir' => 'required|string|max:255',
            'kvkk_onay' => 'required|accepted',
            'kampanya_izin' => 'nullable|boolean',
        ], [
            'model.required' => 'Model alanı zorunludur.',
            'kilometre.required' => 'Kilometre alanı zorunludur.',
            'tramer.required' => 'Tramer bilgisi zorunludur.',
            'tramer_tutarı.required_if' => 'Tramer tutarı zorunludur.',
            'ad.required' => 'Ad alanı zorunludur.',
            'soyad.required' => 'Soyad alanı zorunludur.',
            'telefon.required' => 'Telefon alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'şehir.required' => 'Şehir alanı zorunludur.',
            'kvkk_onay.required' => 'KVKK onayı zorunludur.',
        ]);
        
        // TODO: Save to database or send email
        \Log::info('Vehicle Evaluation Submitted', $request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Talebiniz başarıyla gönderildi. En kısa sürede dönüş yapacağız.'
        ]);
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
