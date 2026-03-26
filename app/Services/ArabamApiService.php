<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\ArabamVehicleConfig;
use Illuminate\Support\Str;

/**
 * Arabam.com API Entegrasyon Servisi
 * Araç markalarını, modellerini ve diğer bilgileri çeker
 */
class ArabamApiService
{
    private $baseUrl = 'https://www.arabam.com/PriceOffer';
    private ?string $proxy = null;
    private array $proxyList = [];
    private int $proxyIndex = 0;

    public function __construct(?string $proxy = null)
    {
        $this->proxy = $proxy;
    }

    /**
     * Proxy listesi ayarla (rotasyon için)
     */
    public function setProxyList(array $proxies): self
    {
        $this->proxyList = $proxies;
        $this->proxyIndex = 0;
        return $this;
    }

    /**
     * Sıradaki proxy'yi al (round-robin)
     */
    private function getNextProxy(): ?string
    {
        if (!empty($this->proxyList)) {
            $proxy = $this->proxyList[$this->proxyIndex % count($this->proxyList)];
            $this->proxyIndex++;
            return $proxy;
        }
        return $this->proxy;
    }

    /**
     * Arabam.com'dan tüm markaları çek
     */
    public function fetchBrands(): ?array
    {
        try {
            $proxy = $this->getNextProxy();
            $options = ['verify' => false];
            if ($proxy) {
                $options['proxy'] = $proxy;
            }

            $response = Http::timeout(15)
                ->withOptions($options)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                    'Referer' => 'https://www.arabam.com/fiyat-teklifi',
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
            $proxy = $this->getNextProxy();
            $options = ['verify' => false];
            if ($proxy) {
                $options['proxy'] = $proxy;
            }

            $response = Http::timeout(15)
                ->withOptions($options)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                    'Referer' => 'https://www.arabam.com/fiyat-teklifi',
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
     * Arabam.com step-definition API'sine istek at (Cloudflare farkında, retry destekli)
     */
    private function fetchStep(array $params, int $retries = 3): ?array
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:125.0) Gecko/20100101 Firefox/125.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 14.4; rv:125.0) Gecko/20100101 Firefox/125.0',
        ];

        for ($attempt = 0; $attempt <= $retries; $attempt++) {
            try {
                $proxy = $this->getNextProxy();
                $options = ['verify' => false];
                if ($proxy) {
                    $options['proxy'] = $proxy;
                }

                $response = Http::timeout(25)
                    ->withOptions($options)
                    ->withHeaders([
                        'Accept'           => 'application/json, text/plain, */*',
                        'Accept-Language'  => 'tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7',
                        'Accept-Encoding'  => 'gzip, deflate, br',
                        'User-Agent'       => $userAgents[array_rand($userAgents)],
                        'Referer'          => 'https://www.arabam.com/fiyat-teklifi',
                        'Origin'           => 'https://www.arabam.com',
                        'Sec-Ch-Ua'        => '"Chromium";v="124", "Google Chrome";v="124", "Not-A.Brand";v="99"',
                        'Sec-Ch-Ua-Mobile' => '?0',
                        'Sec-Ch-Ua-Platform' => '"Windows"',
                        'Sec-Fetch-Dest'   => 'empty',
                        'Sec-Fetch-Mode'   => 'cors',
                        'Sec-Fetch-Site'   => 'same-origin',
                    ])
                    ->get($this->baseUrl . '/step-definition', $params);

                $body = $response->body();

                // Cloudflare challenge kontrolü
                if (str_contains($body, 'Just a moment') || str_contains($body, 'cloudflare') || $response->status() === 403) {
                    $proxyInfo = $proxy ? " [proxy: $proxy]" : ' [no proxy]';
                    Log::warning("Arabam API Cloudflare engeli (deneme " . ($attempt+1) . ")$proxyInfo", $params);
                    if ($attempt < $retries) {
                        sleep(3 + $attempt * 2);
                        continue;
                    }
                    return null;
                }

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['Data']['Items'])) {
                        return $data['Data']['Items'];
                    }
                }
                return null;
            } catch (\Exception $e) {
                Log::warning('Arabam step fetch hatası: ' . $e->getMessage(), $params);
                if ($attempt < $retries) {
                    sleep(2 + $attempt);
                    continue;
                }
                return null;
            }
        }
        return null;
    }

    /**
     * Tüm cascade verisini DB'ye senkronize et.
     * Wizard adım sırası: Yıl(10) → ModelGrubu(20) → Kasa(30) → Yakıt(40) → Şanzıman(50) → Versiyon(60)
     * Integer step numaraları kullanılır — string isimler bazı adımlarda yanlış veri döndürür.
     */
    public function syncFullCascade(\Illuminate\Console\Command $output = null, bool $resumeOnly = false): array
    {
        $brands      = CarBrand::where('is_active', true)->orderBy('name')->get();
        $totalRows   = 0;
        $totalBrands = $brands->count();
        $processed   = 0;

        // Resume: sadece DB'de hiç verisi olmayan markaları al
        $syncedBrandIds = $resumeOnly
            ? ArabamVehicleConfig::select('brand_arabam_id')->distinct()->pluck('brand_arabam_id')->toArray()
            : [];

        foreach ($brands as $brand) {
            $processed++;
            $brandArabamId = (int) $brand->arabam_id;

            if ($resumeOnly && in_array($brandArabamId, $syncedBrandIds)) {
                $output && $output->line("[$processed/$totalBrands] {$brand->name} zaten senkronize, atlandı.");
                continue;
            }

            $msg = "[$processed/$totalBrands] {$brand->name} (arabam_id: {$brandArabamId}) işleniyor...";
            $output ? $output->info($msg) : Log::info($msg);

            // ── Step 10: Yıllar ─────────────────────────────────────────
            $years = $this->fetchStep([
                'CurrentStep' => 10,
                'BrandId'     => $brandArabamId,
            ]);
            usleep(500000); // 500ms

            if (empty($years)) {
                $output && $output->warn("  -> Yıl bulunamadı, atlandı.");
                continue;
            }

            foreach ($years as $year) {
                $yearVal = $year['Id']; // "2023", "2024" vb.

                // ── Step 20: Model Grupları ──────────────────────────────
                $modelGroups = $this->fetchStep([
                    'CurrentStep' => 20,
                    'BrandId'     => $brandArabamId,
                    'ModelYear'   => $yearVal,
                ]);
                usleep(300000); // 300ms

                if (empty($modelGroups)) continue;

                foreach ($modelGroups as $mg) {
                    $mgId   = (int) $mg['Id'];
                    $mgName = $mg['Name'];

                    // ── Step 30: Kasa Tipleri ────────────────────────────
                    $bodyTypes = $this->fetchStep([
                        'CurrentStep'  => 30,
                        'BrandId'      => $brandArabamId,
                        'ModelYear'    => $yearVal,
                        'ModelGroupId' => $mgId,
                    ]);
                    usleep(300000); // 300ms

                    if (empty($bodyTypes)) {
                        // Kasa yoksa yalnızca marka+yıl+model grubu kaydet
                        ArabamVehicleConfig::updateOrCreate(
                            [
                                'brand_arabam_id' => $brandArabamId,
                                'model_year'      => $yearVal,
                                'model_group_id'  => $mgId,
                                'body_type_id'    => null,
                                'fuel_type_id'    => null,
                                'transmission_id' => null,
                                'version_id'      => null,
                            ],
                            ['brand_name' => $brand->name, 'model_group_name' => $mgName]
                        );
                        $totalRows++;
                        continue;
                    }

                    foreach ($bodyTypes as $bt) {
                        $btId   = (int) $bt['Id'];
                        $btName = $bt['Name'];

                        // ── Step 40: Yakıt Tipleri ───────────────────────
                        $fuelTypes = $this->fetchStep([
                            'CurrentStep'  => 40,
                            'BrandId'      => $brandArabamId,
                            'ModelYear'    => $yearVal,
                            'ModelGroupId' => $mgId,
                            'BodyTypeId'   => $btId,
                        ]);
                        usleep(250000); // 250ms

                        if (empty($fuelTypes)) continue;

                        foreach ($fuelTypes as $ft) {
                            $ftId   = (int) $ft['Id'];
                            $ftName = $ft['Name'];

                            // ── Step 50: Şanzıman Tipleri ────────────────
                            $transmissions = $this->fetchStep([
                                'CurrentStep'  => 50,
                                'BrandId'      => $brandArabamId,
                                'ModelYear'    => $yearVal,
                                'ModelGroupId' => $mgId,
                                'BodyTypeId'   => $btId,
                                'FuelTypeId'   => $ftId,
                            ]);
                            usleep(250000); // 250ms

                            if (empty($transmissions)) continue;

                            foreach ($transmissions as $tr) {
                                $trId   = (int) $tr['Id'];
                                $trName = $tr['Name'];

                                // ── Step 60: Versiyonlar ─────────────────
                                $versions = $this->fetchStep([
                                    'CurrentStep'        => 60,
                                    'BrandId'            => $brandArabamId,
                                    'ModelYear'          => $yearVal,
                                    'ModelGroupId'       => $mgId,
                                    'BodyTypeId'         => $btId,
                                    'FuelTypeId'         => $ftId,
                                    'TransmissionTypeId' => $trId,
                                ]);
                                usleep(250000); // 250ms

                                if (empty($versions)) {
                                    ArabamVehicleConfig::updateOrCreate(
                                        [
                                            'brand_arabam_id' => $brandArabamId,
                                            'model_year'      => $yearVal,
                                            'model_group_id'  => $mgId,
                                            'body_type_id'    => $btId,
                                            'fuel_type_id'    => $ftId,
                                            'transmission_id' => $trId,
                                            'version_id'      => null,
                                        ],
                                        [
                                            'brand_name'        => $brand->name,
                                            'model_group_name'  => $mgName,
                                            'body_type_name'    => $btName,
                                            'fuel_type_name'    => $ftName,
                                            'transmission_name' => $trName,
                                        ]
                                    );
                                    $totalRows++;
                                    continue;
                                }

                                foreach ($versions as $ver) {
                                    ArabamVehicleConfig::updateOrCreate(
                                        [
                                            'brand_arabam_id' => $brandArabamId,
                                            'model_year'      => $yearVal,
                                            'model_group_id'  => $mgId,
                                            'body_type_id'    => $btId,
                                            'fuel_type_id'    => $ftId,
                                            'transmission_id' => $trId,
                                            'version_id'      => (int) $ver['Id'],
                                        ],
                                        [
                                            'brand_name'        => $brand->name,
                                            'model_group_name'  => $mgName,
                                            'body_type_name'    => $btName,
                                            'fuel_type_name'    => $ftName,
                                            'transmission_name' => $trName,
                                            'version_name'      => $ver['Name'],
                                        ]
                                    );
                                    $totalRows++;
                                }
                            }
                        }
                    }
                }
            }

            $output && $output->line("  -> {$brand->name} tamamlandı. Toplam satır: $totalRows");
            sleep(2); // Markalar arası 2 saniye bekle (Cloudflare rate limit önleme)
        }

        return ['rows' => $totalRows, 'brands' => $totalBrands];
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
