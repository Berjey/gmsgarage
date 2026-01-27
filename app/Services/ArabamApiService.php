<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Support\Str;

/**
 * Arabam.com API Entegrasyon Servisi
 * Araç markalarını, modellerini ve diğer bilgileri çeker
 */
class ArabamApiService
{
    private $baseUrl = 'https://www.arabam.com/PriceOffer';
    
    /**
     * Arabam.com'dan tüm markaları çek
     */
    public function fetchBrands(): ?array
    {
        try {
            $response = Http::timeout(10)
                ->withOptions(['verify' => false])
                ->withHeaders([
                    'Accept' => 'application/json',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                ])
                ->get($this->baseUrl . '/step-definition', [
                    'CurrentStep' => 'null'
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['Data']['Items'])) {
                    Log::info('Arabam API başarılı - marka sayısı: ' . count($data['Data']['Items']));
                    return $data['Data']['Items'];
                }
            }
            
            Log::warning('Arabam API başarısız');
            return null;
        } catch (\Exception $e) {
            Log::error('Arabam API fetchBrands error: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Belirli bir marka için modelleri çek
     */
    public function fetchModels(int $brandId): ?array
    {
        try {
            $response = Http::timeout(10)
                ->withOptions(['verify' => false])
                ->withHeaders([
                    'Accept' => 'application/json',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                ])
                ->get($this->baseUrl . '/step-definition', [
                    'CurrentStep' => 'Brand',
                    'BrandId' => $brandId
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['Data']['Items'])) {
                    Log::info("Marka ID $brandId için model sayısı: " . count($data['Data']['Items']));
                    return $data['Data']['Items'];
                }
            }
            
            return null;
        } catch (\Exception $e) {
            Log::error("Arabam API fetchModels error (BrandId: $brandId): " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Markaları veritabanına kaydet
     */
    public function saveBrandsToDatabase(): int
    {
        $brands = $this->fetchBrands();
        
        if (!$brands) {
            Log::error('Arabam API\'den marka verisi alınamadı');
            return 0;
        }
        
        $savedCount = 0;
        
        foreach ($brands as $index => $brand) {
            try {
                CarBrand::updateOrCreate(
                    ['arabam_id' => $brand['Id']],
                    [
                        'name' => $brand['Name'],
                        'slug' => Str::slug($brand['Name']),
                        'is_active' => true,
                        'order' => $index + 1,
                    ]
                );
                $savedCount++;
            } catch (\Exception $e) {
                Log::error("Marka kaydedilemedi: {$brand['Name']}", [
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        Log::info("Toplam $savedCount marka veritabanına kaydedildi");
        return $savedCount;
    }
    
    /**
     * Tüm markaların modellerini veritabanına kaydet
     */
    public function saveModelsToDatabase(): int
    {
        $brands = CarBrand::where('is_active', true)->get();
        
        if ($brands->isEmpty()) {
            Log::error('Veritabanında marka bulunamadı. Önce markaları kaydedin.');
            return 0;
        }
        
        $savedCount = 0;
        
        foreach ($brands as $brand) {
            $models = $this->fetchModels($brand->arabam_id);
            
            if (!$models) {
                Log::warning("Marka {$brand->name} için model bulunamadı");
                continue;
            }
            
            foreach ($models as $index => $model) {
                try {
                    CarModel::updateOrCreate(
                        [
                            'car_brand_id' => $brand->id,
                            'arabam_id' => $model['Id']
                        ],
                        [
                            'name' => $model['Name'],
                            'slug' => Str::slug($model['Name']),
                            'is_active' => true,
                            'order' => $index + 1,
                        ]
                    );
                    $savedCount++;
                } catch (\Exception $e) {
                    Log::error("Model kaydedilemedi: {$brand->name} - {$model['Name']}", [
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Rate limiting için kısa bekleme
            usleep(100000); // 100ms
        }
        
        Log::info("Toplam $savedCount model veritabanına kaydedildi");
        return $savedCount;
    }
    
    /**
     * Tüm verileri senkronize et (markalar + modeller)
     */
    public function syncAllData(): array
    {
        Log::info('Arabam.com veri senkronizasyonu başlatıldı');
        
        $brandsCount = $this->saveBrandsToDatabase();
        $modelsCount = $this->saveModelsToDatabase();
        
        Log::info('Arabam.com veri senkronizasyonu tamamlandı', [
            'brands' => $brandsCount,
            'models' => $modelsCount
        ]);
        
        return [
            'brands' => $brandsCount,
            'models' => $modelsCount,
            'success' => true,
        ];
    }
}
