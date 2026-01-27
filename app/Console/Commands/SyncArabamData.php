<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArabamApiService;

class SyncArabamData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'arabam:sync {--brands-only : Sadece markaları senkronize et} {--models-only : Sadece modelleri senkronize et}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Arabam.com\'dan araç marka ve model verilerini senkronize eder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new ArabamApiService();
        
        $this->info('🚀 Arabam.com veri senkronizasyonu başlatılıyor...');
        $this->newLine();
        
        if ($this->option('brands-only')) {
            // Sadece markalar
            $this->info('📦 Markalar çekiliyor...');
            $brandsCount = $service->saveBrandsToDatabase();
            $this->info("✅ {$brandsCount} marka kaydedildi");
            
        } elseif ($this->option('models-only')) {
            // Sadece modeller
            $this->info('📦 Modeller çekiliyor...');
            $modelsCount = $service->saveModelsToDatabase();
            $this->info("✅ {$modelsCount} model kaydedildi");
            
        } else {
            // Hem markalar hem modeller
            $result = $service->syncAllData();
            
            if ($result['success']) {
                $this->info("✅ {$result['brands']} marka kaydedildi");
                $this->info("✅ {$result['models']} model kaydedildi");
            } else {
                $this->error('❌ Veri senkronizasyonu başarısız oldu');
                return 1;
            }
        }
        
        $this->newLine();
        $this->info('🎉 İşlem tamamlandı!');
        
        return 0;
    }
}
