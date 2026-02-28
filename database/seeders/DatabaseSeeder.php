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
            AdminUserSeeder::class, // Admin kullanıcıları oluştur
            LegalPagesSeeder::class, // Yasal sayfalar oluştur
            CarBrandSeeder::class, // Arabam.com'dan marka ve modelleri çek
            VehicleSeeder::class,
            BlogPostSeeder::class,
            ContactSettingsSeeder::class,
        ]);
    }
}
