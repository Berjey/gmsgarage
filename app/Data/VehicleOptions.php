<?php

namespace App\Data;

class VehicleOptions
{
    /**
     * Araç seçenekleri mock data
     * Format: [Marka][Model] => [Gövde Tipi, Yakıt Tipi, Vites Tipi, Model Tipi]
     */
    public static function getOptions(string $marka, string $model): ?array
    {
        $data = self::getMockData();
        
        $markaKey = strtoupper(trim($marka));
        $modelKey = strtoupper(trim($model));
        
        if (isset($data[$markaKey][$modelKey])) {
            return $data[$markaKey][$modelKey];
        }
        
        // Partial match denemesi (model kısmı)
        foreach ($data[$markaKey] ?? [] as $key => $value) {
            if (stripos($modelKey, $key) !== false || stripos($key, $modelKey) !== false) {
                return $value;
            }
        }
        
        return null;
    }
    
    /**
     * Mock data - Gerçek API bağlantısı yapılınca bu kısım değiştirilecek
     */
    private static function getMockData(): array
    {
        return [
            'AUDI' => [
                'A3' => [
                    'gövde_tipi' => ['SEDAN', 'HATCHBACK', 'SPORTBACK'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK', 'MANUEL'],
                    'model_tipi' => ['TFSI', 'TDI', 'S-LINE', 'SPORT']
                ],
                'A4' => [
                    'gövde_tipi' => ['SEDAN', 'AVANT'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK', 'MANUEL'],
                    'model_tipi' => ['TFSI', 'TDI', 'QUATTRO', 'S-LINE']
                ],
                'A5' => [
                    'gövde_tipi' => ['COUPE', 'SPORTBACK', 'CABRIO'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL'],
                    'vites_tipi' => ['OTOMATIK', 'MANUEL'],
                    'model_tipi' => ['TFSI', 'TDI', 'S-LINE', 'SPORT']
                ],
                'Q5' => [
                    'gövde_tipi' => ['SUV'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK'],
                    'model_tipi' => ['TFSI', 'TDI', 'QUATTRO', 'S-LINE']
                ],
                'Q7' => [
                    'gövde_tipi' => ['SUV'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK'],
                    'model_tipi' => ['TFSI', 'TDI', 'QUATTRO', 'S-LINE']
                ],
            ],
            'BMW' => [
                '3 SERIES' => [
                    'gövde_tipi' => ['SEDAN', 'TOURING'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK', 'MANUEL'],
                    'model_tipi' => ['320i', '320d', '330i', 'M SPORT']
                ],
                '5 SERIES' => [
                    'gövde_tipi' => ['SEDAN', 'TOURING'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK'],
                    'model_tipi' => ['520i', '520d', '530i', 'M SPORT']
                ],
                'X3' => [
                    'gövde_tipi' => ['SUV'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK'],
                    'model_tipi' => ['xDrive20i', 'xDrive20d', 'M SPORT']
                ],
                'X5' => [
                    'gövde_tipi' => ['SUV'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT', 'ELEKTRIK'],
                    'vites_tipi' => ['OTOMATIK'],
                    'model_tipi' => ['xDrive30i', 'xDrive30d', 'M SPORT']
                ],
            ],
            'MERCEDES-BENZ' => [
                'C-CLASS' => [
                    'gövde_tipi' => ['SEDAN', 'ESTATE'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK', 'MANUEL'],
                    'model_tipi' => ['C180', 'C200', 'C220d', 'AMG LINE']
                ],
                'E-CLASS' => [
                    'gövde_tipi' => ['SEDAN', 'ESTATE'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK'],
                    'model_tipi' => ['E200', 'E220d', 'E300', 'AMG LINE']
                ],
                'GLC' => [
                    'gövde_tipi' => ['SUV'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK'],
                    'model_tipi' => ['GLC200', 'GLC220d', 'AMG LINE']
                ],
                'GLE' => [
                    'gövde_tipi' => ['SUV'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK'],
                    'model_tipi' => ['GLE350', 'GLE400d', 'AMG LINE']
                ],
            ],
            'VOLKSWAGEN' => [
                'GOLF' => [
                    'gövde_tipi' => ['HATCHBACK'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT', 'ELEKTRIK'],
                    'vites_tipi' => ['OTOMATIK', 'MANUEL'],
                    'model_tipi' => ['TSI', 'TDI', 'GTI', 'R-LINE']
                ],
                'PASSAT' => [
                    'gövde_tipi' => ['SEDAN', 'VARIANT'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK', 'MANUEL'],
                    'model_tipi' => ['TSI', 'TDI', 'R-LINE']
                ],
                'TIGUAN' => [
                    'gövde_tipi' => ['SUV'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK'],
                    'model_tipi' => ['TSI', 'TDI', 'R-LINE']
                ],
            ],
            'FORD' => [
                'FOCUS' => [
                    'gövde_tipi' => ['HATCHBACK', 'SEDAN'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK', 'MANUEL'],
                    'model_tipi' => ['ECOSPORT', 'TITANIUM', 'ST-LINE']
                ],
                'KUGA' => [
                    'gövde_tipi' => ['SUV'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK'],
                    'model_tipi' => ['TITANIUM', 'ST-LINE']
                ],
            ],
            'RENAULT' => [
                'CLIO' => [
                    'gövde_tipi' => ['HATCHBACK'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK', 'MANUEL'],
                    'model_tipi' => ['ZEN', 'INTENS', 'RS LINE']
                ],
                'MEGANE' => [
                    'gövde_tipi' => ['HATCHBACK', 'SEDAN'],
                    'yakıt_tipi' => ['BENZIN', 'DIZEL', 'HIBRIT'],
                    'vites_tipi' => ['OTOMATIK', 'MANUEL'],
                    'model_tipi' => ['ZEN', 'INTENS', 'RS LINE']
                ],
            ],
            'TOYOTA' => [
                'COROLLA' => [
                    'gövde_tipi' => ['SEDAN', 'HATCHBACK'],
                    'yakıt_tipi' => ['BENZIN', 'HIBRIT', 'ELEKTRIK'],
                    'vites_tipi' => ['OTOMATIK', 'MANUEL'],
                    'model_tipi' => ['HYBRID', 'GR SPORT']
                ],
                'RAV4' => [
                    'gövde_tipi' => ['SUV'],
                    'yakıt_tipi' => ['BENZIN', 'HIBRIT', 'ELEKTRIK'],
                    'vites_tipi' => ['OTOMATIK'],
                    'model_tipi' => ['HYBRID', 'ADVENTURE']
                ],
            ],
        ];
    }
    
    /**
     * Gövde tipleri mapping
     */
    public static function getGövdeTipiLabel(string $value): string
    {
        $labels = [
            'SEDAN' => 'Sedan',
            'HATCHBACK' => 'Hatchback',
            'STATION_WAGON' => 'Station Wagon',
            'COUPE' => 'Coupe',
            'CABRIO' => 'Cabrio',
            'SUV' => 'SUV',
            'AVANT' => 'Avant',
            'SPORTBACK' => 'Sportback',
            'TOURING' => 'Touring',
            'ESTATE' => 'Estate',
            'VARIANT' => 'Variant',
        ];
        
        return $labels[$value] ?? $value;
    }
}
