<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArabamApiService;

class SyncArabamData extends Command
{
    protected $signature = 'arabam:sync
        {--brands-only : Sadece markaları senkronize et}
        {--models-only : Sadece modelleri senkronize et}
        {--full : Tüm cascade verisini (yıl/kasa/yakıt/şanzıman/versiyon) DB\'ye çek}
        {--resume : Sadece eksik markaları senkronize et (zaten var olanları atla)}
        {--proxy= : HTTP proxy adresi (örn: http://ip:port veya socks5://ip:port)}
        {--proxy-list= : Virgülle ayrılmış proxy listesi (rotasyon için)}
        {--test-proxy : Proxy bağlantısını test et}';

    protected $description = 'Arabam.com\'dan araç verilerini senkronize eder (markalar, modeller, tam cascade)';

    public function handle()
    {
        $proxy = $this->option('proxy');
        $proxyList = $this->option('proxy-list');

        $service = new ArabamApiService($proxy);

        if ($proxyList) {
            $proxies = array_map('trim', explode(',', $proxyList));
            $service->setProxyList($proxies);
            $this->info("🔄 " . count($proxies) . " proxy ile rotasyon aktif");
        } elseif ($proxy) {
            $this->info("🔄 Proxy: $proxy");
        }

        // Proxy test
        if ($this->option('test-proxy')) {
            $this->info('🧪 Proxy test ediliyor...');
            $brands = $service->fetchBrands();
            if ($brands) {
                $this->info("✅ Proxy çalışıyor! " . count($brands) . " marka bulundu.");
            } else {
                $this->error("❌ Proxy ile bağlantı kurulamadı veya Cloudflare engeli devam ediyor.");
            }
            return 0;
        }

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
            $this->info('📦 Markalar çekiliyor...');
            $brandsCount = $service->saveBrandsToDatabase();
            $this->info("✅ {$brandsCount} marka kaydedildi");

        } elseif ($this->option('models-only')) {
            $this->info('📦 Modeller çekiliyor...');
            $modelsCount = $service->saveModelsToDatabase();
            $this->info("✅ {$modelsCount} model kaydedildi");

        } else {
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
