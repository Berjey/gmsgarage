<?php

namespace App\Data;

class CarBrands
{
    /**
     * Türkiye'de yaygın otomobil markaları listesi
     * Alfabetik sıralı
     */
    public static function all(): array
    {
        return [
            'Alfa Romeo',
            'Aston Martin',
            'Audi',
            'Bentley',
            'BMW',
            'Bugatti',
            'Cadillac',
            'Chevrolet',
            'Chrysler',
            'Citroën',
            'Dacia',
            'Dodge',
            'DS Automobiles',
            'Ferrari',
            'Fiat',
            'Ford',
            'Genesis',
            'Honda',
            'Hyundai',
            'Infiniti',
            'Isuzu',
            'Jaguar',
            'Jeep',
            'Kia',
            'Lamborghini',
            'Land Rover',
            'Lexus',
            'Lotus',
            'Maserati',
            'Mazda',
            'McLaren',
            'Mercedes-Benz',
            'MG',
            'Mini',
            'Mitsubishi',
            'Nissan',
            'Opel',
            'Peugeot',
            'Porsche',
            'Renault',
            'Rolls-Royce',
            'Seat',
            'Skoda',
            'Smart',
            'SsangYong',
            'Subaru',
            'Suzuki',
            'Tesla',
            'Toyota',
            'Volkswagen',
            'Volvo',
        ];
    }

    /**
     * Marka listesini JSON formatında döndür
     */
    public static function toJson(): string
    {
        return json_encode(self::all(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
