<?php

namespace App\Data;

class VehicleFeatures
{
    /**
     * Araç donanım özelliklerini kategori bazında döndürür.
     *
     * @return array<string, array<string>>
     */
    public static function all(): array
    {
        return [
            'Güvenlik' => [
                'ABS (Kilit Önleyici Fren)',
                'ESP (Elektronik Denge Programı)',
                'Hava Yastığı (Sürücü)',
                'Hava Yastığı (Yolcu)',
                'Yan Hava Yastıkları',
                'Perde Hava Yastıkları',
                'Diz Hava Yastığı',
                'Yokuş Kalkış Desteği',
                'Şerit Takip Uyarısı',
                'Kör Nokta Uyarısı',
                'Ön Çarpışma Uyarısı',
                'Otomatik Acil Fren',
                'Yorgunluk Uyarı Sistemi',
                'ISOFIX Çocuk Koltuğu Bağlantısı',
                'Lastik Basınç İzleme',
            ],
            'Konfor' => [
                'Otomatik Klima',
                'Çift Bölge Otomatik Klima',
                'Isıtmalı Ön Koltuklar',
                'Havalandırmalı Ön Koltuklar',
                'Elektrikli Ön Koltuk Ayarı',
                'Hafızalı Sürücü Koltuğu',
                'Isıtmalı Direksiyon',
                'Elektrikli Bagaj Kapısı',
                'Akıllı Giriş & Çalıştırma',
                'Uzaktan Çalıştırma',
                'Panoramik Cam Tavan',
                'Elektrikli Cam Tavan',
                'Arka Koltuk Isıtma',
                'Otomatik Park Asistanı',
                'Adaptif Hız Sabitleyici (ACC)',
                'Hız Sabitleyici (Cruise Control)',
                'Elektrikli Ayna Ayarı',
                'Isıtmalı Aynalar',
                'Otomatik Kapanır Aynalar',
                'Yağmur Sensörü',
                'Işık Sensörü',
            ],
            'Multimedya & Bağlantı' => [
                'Dokunmatik Ekran',
                'Apple CarPlay',
                'Android Auto',
                'Navigasyon Sistemi',
                'Bluetooth',
                'USB Bağlantısı',
                'Kablosuz Şarj',
                'Premium Ses Sistemi',
                'Çok Fonksiyonlu Direksiyon',
                'Dijital Gösterge Paneli',
                'Head-Up Display (HUD)',
                'Arka Eğlence Sistemi',
                'Wi-Fi Hotspot',
            ],
            'Görüş & Aydınlatma' => [
                'LED Far',
                'Full LED Far',
                'Lazer Far',
                'Adaptif Far Sistemi',
                'LED Arka Stop',
                'Gündüz Farı (DRL)',
                'Sis Farı (Ön)',
                'Sis Farı (Arka)',
                'Arka Görüş Kamerası',
                '360 Derece Kamera',
                'Park Sensörü (Ön)',
                'Park Sensörü (Arka)',
                'Karşıdan Gelen Araç Aydınlatma',
            ],
            'Dış Görünüm' => [
                'Alaşım Jant',
                '18" Jant',
                '19" Jant',
                '20" Jant veya Üstü',
                'Spor Body Kit',
                'Çelik Tampon Koruyucu',
                'Çatı Rayı (Railing)',
                'Çekme Kancası',
                'Elektrikli Otomatik Adım',
                'Güneş Koruyucu Film',
            ],
            'İç Görünüm' => [
                'Deri Döşeme',
                'Alcantara Döşeme',
                'Spor Koltuklar',
                'Ayak Bölgesi Aydınlatması',
                'Ambiyans Aydınlatması',
                'Alüminyum İç Aksanlar',
                'Ahşap İç Aksanlar',
                'Karbon Fiber İç Aksanlar',
                'Sürücü Profil Seçimi',
                'Şeffaf Motor Kaputu Görünümü',
            ],
        ];
    }

    /**
     * Düz liste olarak tüm özellikleri döndürür.
     *
     * @return array<string>
     */
    public static function flat(): array
    {
        return array_merge(...array_values(static::all()));
    }
}
