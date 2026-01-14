<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            [
                'title' => '2023 BMW 3.20i M Sport',
                'brand' => 'BMW',
                'model' => '3.20i',
                'year' => 2023,
                'price' => 2850000,
                'kilometer' => 15000,
                'fuel_type' => 'Benzin',
                'transmission' => 'Otomatik',
                'body_type' => 'Sedan',
                'color' => 'Siyah',
                'engine_size' => '2.0',
                'horse_power' => 184,
                'description' => '2023 model BMW 3.20i M Sport paketli, tek elden, bakımlı, garantili. Tüm özellikler mevcut.',
                'features' => [
                    'M Sport Paketi',
                    'Panoramik Cam Tavan',
                    'Harman Kardon Ses Sistemi',
                    'Adaptive Cruise Control',
                    '360 Kamera',
                    'Deri Döşeme',
                    'Isıtmalı Koltuklar',
                ],
                'images' => [
                    '/images/vehicles/bmw-320i-1.jpg',
                    '/images/vehicles/bmw-320i-2.jpg',
                    '/images/vehicles/bmw-320i-3.jpg',
                ],
                'is_featured' => true,
                'is_active' => true,
                'sahibinden_url' => 'https://www.sahibinden.com/ilan/123456',
            ],
            [
                'title' => '2022 Mercedes-Benz C200 AMG Line',
                'brand' => 'Mercedes-Benz',
                'model' => 'C200',
                'year' => 2022,
                'price' => 3200000,
                'kilometer' => 22000,
                'fuel_type' => 'Benzin',
                'transmission' => 'Otomatik',
                'body_type' => 'Sedan',
                'color' => 'Beyaz',
                'engine_size' => '1.5',
                'horse_power' => 204,
                'description' => '2022 model Mercedes-Benz C200 AMG Line, full donanım, tek elden, ekspertizli.',
                'features' => [
                    'AMG Line Paketi',
                    'Panoramik Cam Tavan',
                    'Burmester Ses Sistemi',
                    'MBUX Sistem',
                    'Çok Bölgeli Klima',
                    'Deri Döşeme',
                    'Isıtmalı ve Havalandırmalı Koltuklar',
                ],
                'images' => [
                    '/images/vehicles/mercedes-c200-1.jpg',
                    '/images/vehicles/mercedes-c200-2.jpg',
                ],
                'is_featured' => true,
                'is_active' => true,
                'sahibinden_url' => 'https://www.sahibinden.com/ilan/123457',
            ],
            [
                'title' => '2021 Audi A4 2.0 TDI Quattro',
                'brand' => 'Audi',
                'model' => 'A4',
                'year' => 2021,
                'price' => 2450000,
                'kilometer' => 35000,
                'fuel_type' => 'Dizel',
                'transmission' => 'Otomatik',
                'body_type' => 'Sedan',
                'color' => 'Gri',
                'engine_size' => '2.0',
                'horse_power' => 190,
                'description' => '2021 model Audi A4 2.0 TDI Quattro, full donanım, servis bakımlı.',
                'features' => [
                    'Quattro 4x4',
                    'Virtual Cockpit',
                    'MMI Navigation Plus',
                    'Matrix LED Farlar',
                    'Deri Döşeme',
                    'Isıtmalı Koltuklar',
                ],
                'images' => [
                    '/images/vehicles/audi-a4-1.jpg',
                    '/images/vehicles/audi-a4-2.jpg',
                ],
                'is_featured' => false,
                'is_active' => true,
                'sahibinden_url' => 'https://www.sahibinden.com/ilan/123458',
            ],
            [
                'title' => '2023 Volkswagen Golf 8 1.5 TSI',
                'brand' => 'Volkswagen',
                'model' => 'Golf',
                'year' => 2023,
                'price' => 1850000,
                'kilometer' => 12000,
                'fuel_type' => 'Benzin',
                'transmission' => 'Otomatik',
                'body_type' => 'Hatchback',
                'color' => 'Mavi',
                'engine_size' => '1.5',
                'horse_power' => 150,
                'description' => '2023 model Volkswagen Golf 8, yeni nesil, full donanım, garantili.',
                'features' => [
                    'Digital Cockpit',
                    'Adaptive Cruise Control',
                    'Park Assist',
                    'Kumaş Döşeme',
                    'Isıtmalı Ön Koltuklar',
                ],
                'images' => [
                    '/images/vehicles/golf-8-1.jpg',
                ],
                'is_featured' => false,
                'is_active' => true,
                'sahibinden_url' => 'https://www.sahibinden.com/ilan/123459',
            ],
            [
                'title' => '2022 Range Rover Evoque',
                'brand' => 'Land Rover',
                'model' => 'Range Rover Evoque',
                'year' => 2022,
                'price' => 4200000,
                'kilometer' => 18000,
                'fuel_type' => 'Benzin',
                'transmission' => 'Otomatik',
                'body_type' => 'SUV',
                'color' => 'Siyah',
                'engine_size' => '2.0',
                'horse_power' => 249,
                'description' => '2022 model Range Rover Evoque, lüks donanım, tek elden, bakımlı.',
                'features' => [
                    'Panoramik Cam Tavan',
                    'Meridian Ses Sistemi',
                    'Terrain Response',
                    'Deri Döşeme',
                    'Isıtmalı ve Havalandırmalı Koltuklar',
                    '360 Kamera',
                ],
                'images' => [
                    '/images/vehicles/evoque-1.jpg',
                    '/images/vehicles/evoque-2.jpg',
                ],
                'is_featured' => true,
                'is_active' => true,
                'sahibinden_url' => 'https://www.sahibinden.com/ilan/123460',
            ],
            [
                'title' => '2021 Toyota Corolla 1.6',
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'year' => 2021,
                'price' => 1650000,
                'kilometer' => 45000,
                'fuel_type' => 'Benzin',
                'transmission' => 'Manuel',
                'body_type' => 'Sedan',
                'color' => 'Beyaz',
                'engine_size' => '1.6',
                'horse_power' => 132,
                'description' => '2021 model Toyota Corolla, ekonomik, bakımlı, servis kayıtlı.',
                'features' => [
                    'Klima',
                    'Bluetooth',
                    'USB Giriş',
                    'Kumaş Döşeme',
                ],
                'images' => [
                    '/images/vehicles/corolla-1.jpg',
                ],
                'is_featured' => false,
                'is_active' => true,
                'sahibinden_url' => 'https://www.sahibinden.com/ilan/123461',
            ],
        ];

        foreach ($vehicles as $vehicle) {
            Vehicle::create($vehicle);
        }
    }
}
