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
    protected $signature = 'arabam:sync {--brands-only : Sadece markaları senkronize et} {--models-only : Sadece modelleri senkronize et} {--full : Tüm cascade verisini (yıl/kasa/yakıt/şanzıman/versiyon) DB\'ye çek} {--resume : Sadece eksik markaları senkronize et (zaten var olanları atla)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Arabam.com\'dan araç verilerini senkronize eder (markalar, modeller, tam cascade)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new ArabamApiService();
        
        $this->info('🚀 Arabam.com veri senkronizasyonu başlatılıyor...');
        $this->newLine();
        
        if ($this->option('full') || $this->option('resume')) {
            $resume = $this->option('resume');
            $this->info($resume ? '🔄 RESUME: Eksik markalar senkronize ediliyor...' : '🔄 TAM CASCADE senkronizasyonu başlatılıyor...');
            $this->warn('  Bu işlem arabam.com\'daki TÜM yıl/kasa/yakıt/şanzıman/versiyon verilerini çeker.');
            $this->warn('  Süre: markaya göre değişir, saatler alabilir. Ctrl+C ile durdurabilirsiniz.');
            $this->newLine();

            $result = $service->syncFullCascade($this, $resume);

            $this->newLine();
            $this->info("✅ Toplam {$result['rows']} satır, {$result['brands']} marka işlendi.");

        } elseif ($this->option('brands-only')) {
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
