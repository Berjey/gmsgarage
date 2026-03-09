<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            LegalPagesSeeder::class,
            CarBrandSeeder::class,
            VehicleSeeder::class,
            BlogPostSeeder::class,
            ContactSettingsSeeder::class,
            FeaturesCatalogSeeder::class,
        ]);
    }
}
