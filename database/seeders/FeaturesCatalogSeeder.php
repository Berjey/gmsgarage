<?php

namespace Database\Seeders;

use App\Data\VehicleFeatures;
use App\Models\FeaturesCatalog;
use Illuminate\Database\Seeder;

class FeaturesCatalogSeeder extends Seeder
{
    public function run(): void
    {
        // Zaten kayıtlar varsa tekrar ekleme
        if (FeaturesCatalog::count() > 0) {
            $this->command->info('features_catalog tablosu zaten dolu, atlanıyor.');
            return;
        }

        $sortOrder = 0;
        foreach (VehicleFeatures::all() as $category => $features) {
            foreach ($features as $name) {
                FeaturesCatalog::create([
                    'name'       => $name,
                    'category'   => $category,
                    'is_active'  => true,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        $this->command->info('features_catalog tablosuna ' . $sortOrder . ' kayıt eklendi.');
    }
}
