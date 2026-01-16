<?php

namespace App\Data;

class VehicleModels
{
    /**
     * Marka bazında model listesi
     */
    public static function getModels(string $marka): array
    {
        $data = self::getMockData();
        $markaKey = strtoupper(trim($marka));
        
        return $data[$markaKey] ?? [];
    }
    
    /**
     * Mock data - Gerçek API bağlantısı yapılınca bu kısım değiştirilecek
     */
    private static function getMockData(): array
    {
        return [
            'AUDI' => [
                'A3',
                'A4',
                'A5',
                'A6',
                'A7',
                'A8',
                'Q3',
                'Q5',
                'Q7',
                'Q8',
                'TT',
                'R8'
            ],
            'BMW' => [
                '1 Serisi',
                '2 Serisi',
                '3 Serisi',
                '4 Serisi',
                '5 Serisi',
                '6 Serisi',
                '7 Serisi',
                'X1',
                'X3',
                'X5',
                'X7',
                'Z4'
            ],
            'MERCEDES-BENZ' => [
                'A-Serisi',
                'B-Serisi',
                'C-Serisi',
                'E-Serisi',
                'S-Serisi',
                'CLA',
                'CLS',
                'GLA',
                'GLC',
                'GLE',
                'GLS',
                'AMG GT'
            ],
            'VOLKSWAGEN' => [
                'Golf',
                'Polo',
                'Passat',
                'Jetta',
                'Arteon',
                'Tiguan',
                'Touareg',
                'T-Cross',
                'T-Roc',
                'Amarok'
            ],
            'FORD' => [
                'Fiesta',
                'Focus',
                'Mondeo',
                'Kuga',
                'Edge',
                'Explorer',
                'Mustang',
                'Ranger'
            ],
            'RENAULT' => [
                'Clio',
                'Megane',
                'Fluence',
                'Talisman',
                'Kadjar',
                'Koleos',
                'Captur',
                'Duster'
            ],
            'TOYOTA' => [
                'Corolla',
                'Camry',
                'Yaris',
                'Auris',
                'RAV4',
                'Highlander',
                'Land Cruiser',
                'Prius'
            ],
            'OPEL' => [
                'Corsa',
                'Astra',
                'Insignia',
                'Crossland',
                'Grandland',
                'Mokka'
            ],
            'PEUGEOT' => [
                '208',
                '308',
                '508',
                '2008',
                '3008',
                '5008',
                'Partner'
            ],
            'CITROEN' => [
                'C3',
                'C4',
                'C5',
                'C3 Aircross',
                'C5 Aircross',
                'Berlingo'
            ],
            'HYUNDAI' => [
                'i10',
                'i20',
                'i30',
                'Elantra',
                'Sonata',
                'Tucson',
                'Santa Fe',
                'Kona'
            ],
            'KIA' => [
                'Rio',
                'Ceed',
                'Optima',
                'Sportage',
                'Sorento',
                'Stonic',
                'Niro'
            ],
            'SKODA' => [
                'Fabia',
                'Octavia',
                'Superb',
                'Kodiaq',
                'Karoq',
                'Kamiq'
            ],
            'SEAT' => [
                'Ibiza',
                'Leon',
                'Ateca',
                'Tarraco',
                'Arona'
            ],
        ];
    }
}
