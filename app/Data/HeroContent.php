<?php

namespace App\Data;

class HeroContent
{
    /**
     * Araç Sat sekmesi için içerik
     */
    public static function sellContent(): array
    {
        return [
            'title' => 'Aracını Güvenle Sat',
            'description' => 'Hızlı teklif alın, güvenli süreçten geçin. Aracınızın gerçek değerini öğrenin ve en iyi fiyatı garantileyin.',
        ];
    }

    /**
     * Araç Al sekmesi için içerik
     */
    public static function buyContent(): array
    {
        return [
            'title' => 'Aracını Güvenle Al',
            'description' => 'Garantili, bakımlı ve ekspertizli araçlar. Profesyonel seçim, güvenli alışveriş ve en iyi fiyat garantisi.',
        ];
    }
}
