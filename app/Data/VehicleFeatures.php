<?php

namespace App\Data;

class VehicleFeatures
{
    /**
     * Araç donanım listesi - Kategorize edilmiş
     */
    public static function all()
    {
        return [
            'Güvenlik' => [
                'ABS',
                'ESP',
                'Hava Yastığı (Sürücü)',
                'Hava Yastığı (Yolcu)',
                'Yan Hava Yastıkları',
                'Perde Hava Yastıkları',
                'Diz Hava Yastığı',
                'Alarm',
                'İmmobilizer',
                'Çocuk Kilidi',
                'Merkezi Kilit',
                'Uzaktan Merkezi Kilit',
                'Park Sensörü (Ön)',
                'Park Sensörü (Arka)',
                '360 Derece Kamera',
                'Geri Görüş Kamerası',
                'Kör Nokta Uyarı',
                'Şerit Takip Asistanı',
                'Otonom Acil Fren',
                'Adaptif Hız Sabitleyici',
                'Hız Sabitleyici',
                'Lastik Basınç Göstergesi',
            ],
            'İç Donanım' => [
                'Deri Direksiyon',
                'Deri Koltuk',
                'Isıtmalı Koltuk',
                'Havalandırmalı Koltuk',
                'Elektrikli Koltuk',
                'Hafızalı Koltuk',
                'Masajlı Koltuk',
                'Katlanabilir Ayna',
                'Elektrikli Ayna',
                'Isıtmalı Ayna',
                'Panoramik Cam Tavan',
                'Elektrikli Cam Tavan',
                'Çift Ekran Klima',
                'Otomatik Klima',
                'Yağmur Sensörü',
                'Far Sensörü',
                'Start/Stop Sistemi',
                'Anahtarsız Giriş',
                'Kablosuz Şarj',
            ],
            'Multimedya' => [
                'Bluetooth',
                'Android Auto',
                'Apple CarPlay',
                'Dokunmatik Ekran',
                'Navigasyon',
                'Geri Görüş Kamerası',
                'USB Girişi',
                'Aux Girişi',
                'Premium Ses Sistemi',
                'Dijital Gösterge',
                'Head-Up Display',
            ],
            'Dış Donanım' => [
                'Alüminyum Jant',
                'Sis Farları',
                'Xenon Far',
                'LED Far',
                'Gündüz Farları',
                'Elektrikli Bagaj',
                'Çeki Demiri',
                'Cam Tavan',
                'Krom Paket',
                'Spor Paket',
                'AMG Paket',
                'M Sport Paket',
                'S-Line Paket',
            ],
        ];
    }

    /**
     * Tüm donanımları düz liste olarak getir
     */
    public static function flat()
    {
        $flat = [];
        foreach (self::all() as $category => $features) {
            foreach ($features as $feature) {
                $flat[] = $feature;
            }
        }
        return $flat;
    }

    /**
     * Kategorileri getir
     */
    public static function categories()
    {
        return array_keys(self::all());
    }
}
