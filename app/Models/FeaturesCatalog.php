<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturesCatalog extends Model
{
    protected $table = 'features_catalog';

    protected $fillable = [
        'name',
        'category',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Aktif özellikleri kategori => [name, ...] formatında döner.
     * Boş dönerse VehicleFeatures::all() fallback'i kullanılabilir.
     *
     * @return array<string, string[]>
     */
    public static function grouped(): array
    {
        return static::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category')
            ->map(fn ($items) => $items->pluck('name')->toArray())
            ->toArray();
    }

}
