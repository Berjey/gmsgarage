<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use App\Services\SahibindenApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Sahibinden.com API'den araçları senkronize et
 * 
 * Kullanım: php artisan sahibinden:sync
 */
class SyncSahibindenVehicles extends Command
{
    protected $signature = 'sahibinden:sync {--limit=50 : Maksimum araç sayısı}';
    protected $description = 'Sahibinden.com API\'den araçları senkronize et';

    protected $apiService;

    public function __construct(SahibindenApiService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }

    public function handle()
    {
        if (!$this->apiService->isConfigured()) {
            $this->error('Sahibinden API bilgileri yapılandırılmamış!');
            $this->info('Lütfen .env dosyasına şu değişkenleri ekleyin:');
            $this->info('SAHIBINDEN_API_URL=...');
            $this->info('SAHIBINDEN_API_KEY=...');
            $this->info('SAHIBINDEN_API_SECRET=...');
            return 1;
        }

        $this->info('Sahibinden.com API\'den araçlar senkronize ediliyor...');

        $limit = (int) $this->option('limit');
        $filters = ['limit' => $limit];

        $vehicles = $this->apiService->getVehicles($filters);

        if (!$vehicles) {
            $this->error('Araçlar alınamadı! API bağlantısını kontrol edin.');
            return 1;
        }

        $this->info('Toplam ' . count($vehicles) . ' araç bulundu.');

        $bar = $this->output->createProgressBar(count($vehicles));
        $bar->start();

        $synced = 0;
        $updated = 0;
        $created = 0;

        foreach ($vehicles as $vehicleData) {
            try {
                // Sahibinden ID ile kontrol et
                $vehicle = Vehicle::where('sahibinden_id', $vehicleData['id'])->first();

                $data = [
                    'title' => $vehicleData['title'] ?? '',
                    'slug' => Str::slug($vehicleData['title'] ?? ''),
                    'brand' => $vehicleData['brand'] ?? '',
                    'model' => $vehicleData['model'] ?? '',
                    'year' => $vehicleData['year'] ?? null,
                    'price' => $vehicleData['price'] ?? 0,
                    'kilometer' => $vehicleData['kilometer'] ?? 0,
                    'fuel_type' => $vehicleData['fuel_type'] ?? '',
                    'transmission' => $vehicleData['transmission'] ?? '',
                    'body_type' => $vehicleData['body_type'] ?? '',
                    'color' => $vehicleData['color'] ?? '',
                    'engine_size' => $vehicleData['engine_size'] ?? null,
                    'horse_power' => $vehicleData['horse_power'] ?? null,
                    'description' => $vehicleData['description'] ?? '',
                    'images' => $vehicleData['images'] ?? [],
                    'sahibinden_id' => $vehicleData['id'],
                    'sahibinden_url' => $vehicleData['url'] ?? '',
                    'is_active' => true,
                ];

                if ($vehicle) {
                    $vehicle->update($data);
                    $updated++;
                } else {
                    Vehicle::create($data);
                    $created++;
                }

                $synced++;
            } catch (\Exception $e) {
                $this->warn("\nAraç senkronize edilemedi: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Senkronizasyon tamamlandı!");
        $this->info("Yeni: {$created} | Güncellenen: {$updated} | Toplam: {$synced}");

        return 0;
    }
}
