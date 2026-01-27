<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Services\ArabamApiService;

class CarBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Arabam.com\'dan marka ve model verileri çekiliyor...');
        
        $service = new ArabamApiService();
        $result = $service->syncAllData();
        
        if ($result['success']) {
            $this->command->info("✅ {$result['brands']} marka kaydedildi");
            $this->command->info("✅ {$result['models']} model kaydedildi");
            $this->command->info('🎉 Veri senkronizasyonu tamamlandı!');
        } else {
            $this->command->error('❌ Veri senkronizasyonu başarısız oldu');
        }
    }
}
