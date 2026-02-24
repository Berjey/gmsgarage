<?php

namespace App\Http\Controllers;

use App\Models\EvaluationRequest;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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
        
        // Veritabanından marka ve modellerini al
        $brand = CarBrand::where('name', $marka)->first();
        
        if ($brand) {
            $models = CarModel::where('brand_id', $brand->id)
                ->orderBy('name')
                ->pluck('name')
                ->toArray();
        } else {
            $models = [];
        }
        
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
        
        // Şimdilik boş yapı döndür - kullanıcı manuel girebilir
        $options = [
            'paket' => [],
            'motor' => [],
            'sanzuman' => ['Manuel', 'Otomatik', 'Yarı Otomatik'],
            'yakit' => ['Benzin', 'Dizel', 'LPG', 'Hibrit', 'Elektrik']
        ];
        
        return response()->json([
            'success' => true,
            'options' => $options
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
        
        return response()->json([
            'success' => true,
            'versions' => []
        ]);
    }
    
    /**
     * Proxy for arabam.com price offer API - Get brands
     */
    public function getArabamBrands()
    {
        // Cache for 24 hours
        $brands = Cache::remember('arabam_brands', 60 * 60 * 24, function () {
            try {
                $response = Http::timeout(10)
                    ->withOptions([
                        'verify' => false, // SSL doğrulamasını geliştirme ortamında devre dışı bırak
                    ])
                    ->withHeaders([
                        'Accept' => 'application/json',
                        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                    ])
                    ->get('https://www.arabam.com/PriceOffer/step-definition', [
                        'CurrentStep' => 'null'
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['Data']['Items'])) {
                        \Log::info('Arabam API başarılı - marka sayısı: ' . count($data['Data']['Items']));
                        return $data['Data'];
                    }
                }
                
                \Log::warning('Arabam API başarısız, fallback kullanılıyor');
                return null;
            } catch (\Exception $e) {
                \Log::error('Arabam API error: ' . $e->getMessage());
                return null;
            }
        });

        // Eğer arabam.com API'den veri alınamadıysa, veritabanından markaları kullan
        if (!$brands) {
            \Log::info('Fallback: Veritabanından markalar çekiliyor');
            $dbBrands = CarBrand::orderBy('name')->get();
            
            // Arabam.com formatına dönüştür
            $formattedBrands = [];
            foreach ($dbBrands as $brand) {
                $formattedBrands[] = [
                    'Id' => $brand->id,
                    'Name' => $brand->name,
                    'Value' => $brand->id
                ];
            }
            
            $brands = [
                'Items' => $formattedBrands,
                'SelectedItem' => null
            ];
        }

        if ($brands) {
            return response()->json([
                'success' => true,
                'data' => $brands
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Markalar yüklenemedi'
        ], 500);
    }

    /**
     * Proxy for arabam.com price offer API - Get next step data
     */
    public function getArabamStepData(Request $request)
    {
        $step = $request->get('step');
        $brandId = $request->get('brandId');
        $modelId = $request->get('modelId');
        $yearId = $request->get('yearId');
        $modelYear = $request->get('modelYear');
        $modelGroupId = $request->get('modelGroupId');
        $bodyTypeId = $request->get('bodyTypeId');
        $fuelTypeId = $request->get('fuelTypeId');
        $transmissionTypeId = $request->get('transmissionTypeId');
        $versionId = $request->get('versionId');

        $cacheKey = 'arabam_step_' . md5(json_encode($request->all()));

        // Cache for 1 hour
        $data = Cache::remember($cacheKey, 60 * 60, function () use ($step, $brandId, $modelId, $yearId, $modelYear, $modelGroupId, $bodyTypeId, $fuelTypeId, $transmissionTypeId, $versionId) {
            try {
                $params = ['CurrentStep' => $step];

                if ($brandId) $params['BrandId'] = $brandId;
                if ($modelId) $params['ModelId'] = $modelId;
                if ($yearId) $params['YearId'] = $yearId;
                if ($modelYear) $params['ModelYear'] = $modelYear;
                if ($modelGroupId) $params['ModelGroupId'] = $modelGroupId;
                if ($bodyTypeId) $params['BodyTypeId'] = $bodyTypeId;
                if ($fuelTypeId) $params['FuelTypeId'] = $fuelTypeId;
                if ($transmissionTypeId) $params['TransmissionTypeId'] = $transmissionTypeId;
                if ($versionId) $params['VersionId'] = $versionId;

                $response = Http::timeout(10)
                    ->withOptions([
                        'verify' => false, // SSL doğrulamasını geliştirme ortamında devre dışı bırak
                    ])
                    ->withHeaders([
                        'Accept' => 'application/json',
                        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                    ])
                    ->get('https://www.arabam.com/PriceOffer/step-definition', $params);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['Data'])) {
                        return $data['Data'];
                    }
                }
                return null;
            } catch (\Exception $e) {
                \Log::error('Arabam API error: ' . $e->getMessage());
                return null;
            }
        });

        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Veri yüklenemedi'
        ]);
    }

    /**
     * Submit evaluation form
     */
    public function submit(Request $request)
    {
        try {
            // Log incoming request data
            \Log::info('Evaluation form submission started', [
                'all_data' => $request->all(),
                'method' => $request->method(),
                'ajax' => $request->ajax(),
            ]);

            $request->validate([
                'marka' => 'required|string|max:255',
                'yil' => 'required',
                'model' => 'required|string|max:255',
                'govde_tipi' => 'nullable|string|max:255',
                'yakit_tipi' => 'nullable|string|max:255',
                'vites_tipi' => 'nullable|string|max:255',
                'versiyon' => 'nullable|string|max:255',
                'kilometre' => 'required|string|max:50',
                'renk' => 'required|string|max:255',
                'tramer' => 'required|in:YOK,VAR,BILMIYORUM,AGIR_HASAR',
                'tramer_tutari' => 'required_if:tramer,VAR,AGIR_HASAR|nullable|string|max:50',
                'ekspertiz' => 'nullable|string',
                'ad' => 'required|string|max:255',
                'soyad' => 'required|string|max:255',
                'telefon' => 'required|string|max:20',
                'email' => 'required|email|max:255',
                'not' => 'nullable|string|max:1000',
            ], [
                'marka.required' => 'Marka alanı zorunludur.',
                'model.required' => 'Model alanı zorunludur.',
                'kilometre.required' => 'Kilometre alanı zorunludur.',
                'renk.required' => 'Renk seçimi zorunludur.',
                'tramer.required' => 'Tramer bilgisi zorunludur.',
                'tramer_tutari.required_if' => 'Hasar/tramer durumunda toplam tutar girilmesi zorunludur.',
                'ad.required' => 'Ad alanı zorunludur.',
                'soyad.required' => 'Soyad alanı zorunludur.',
                'telefon.required' => 'Telefon alanı zorunludur.',
                'email.required' => 'E-posta alanı zorunludur.',
                'email.email' => 'Geçerli bir e-posta adresi girin.',
            ]);

            // Dinamik yasal onay validasyonu
            $formPages = \App\Models\LegalPage::getFormPages();
            $legalRules = [];
            $legalMessages = [];
            foreach ($formPages as $page) {
                $field = 'legal_consent_' . $page->slug;
                $legalRules[$field] = 'required|accepted';
                $legalMessages[$field . '.required'] = $page->title . ' metnini kabul etmelisiniz.';
                $legalMessages[$field . '.accepted'] = $page->title . ' metnini kabul etmelisiniz.';
            }
            if (!empty($legalRules)) {
                $request->validate($legalRules, $legalMessages);
            }

            \Log::info('Validation passed');

            // Parse kilometre (remove dots)
            $kilometre = (int) str_replace('.', '', $request->kilometre);

            // Parse tramer tutari (remove dots)
            $tramerTutari = $request->tramer_tutari ? (int) str_replace('.', '', $request->tramer_tutari) : null;

            // Parse ekspertiz JSON
            $ekspertiz = $request->ekspertiz ? json_decode($request->ekspertiz, true) : [];

            // Determine condition based on tramer
            $condition = match($request->tramer) {
                'VAR' => 'Tramer Kayıtlı',
                'AGIR_HASAR' => 'Ağır Hasar Kayıtlı',
                'BILMIYORUM' => 'Bilinmiyor',
                default => 'Hasarsız',
            };

            \Log::info('Data parsed', [
                'kilometre' => $kilometre,
                'tramerTutari' => $tramerTutari,
                'ekspertiz' => $ekspertiz,
                'condition' => $condition,
            ]);

            // Save to database
            $evaluationRequest = EvaluationRequest::create([
                'name' => $request->ad . ' ' . $request->soyad,
                'email' => $request->email,
                'phone' => $request->telefon,
                'brand' => $request->marka,
                'model' => $request->model,
                'year' => $request->yil,
                'version' => $request->versiyon,
                'mileage' => $kilometre,
                'fuel_type' => $request->yakit_tipi,
                'transmission' => $request->vites_tipi,
                'condition' => $condition,
                'message' => json_encode([
                    'govde_tipi' => $request->govde_tipi,
                    'renk' => $request->renk,
                    'tramer' => $request->tramer,
                    'tramer_tutari' => $tramerTutari,
                    'ekspertiz' => $ekspertiz,
                    'not' => $request->not,
                ], JSON_UNESCAPED_UNICODE),
            ]);

            \Log::info('Evaluation request saved', ['id' => $evaluationRequest->id]);

            return response()->json([
                'success' => true,
                'message' => 'Talebiniz başarıyla gönderildi. En kısa sürede sizinle iletişime geçeceğiz.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Doğrulama hatası: ' . implode(', ', collect($e->errors())->flatten()->toArray())
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Evaluation form submission error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

}
