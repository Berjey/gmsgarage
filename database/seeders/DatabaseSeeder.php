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
            CarBrandSeeder::class, // Arabam.com'dan marka ve modelleri çek
            VehicleSeeder::class,
            BlogPostSeeder::class,
            ContactSettingsSeeder::class,
        ]);
    }
}
