<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        // Temel Bilgiler
        'title',
        'slug',
        'brand',
        'model',
        'package_version',
        'year',
        'price',
        'kilometer',
        
        // Teknik Özellikler
        'fuel_type',
        'transmission',
        'drive_type',
        'body_type',
        'color',
        'color_type',
        'engine_size',
        'horse_power',
        'torque',
        'door_count',
        'seat_count',
        
        // Donanımlar & Açıklama
        'description',
        'features',
        
        // Hasar & Geçmiş
        'tramer_status',
        'tramer_amount',
        'painted_parts',
        'replaced_parts',
        'owner_number',
        'inspection_date',
        'has_warranty',
        'warranty_end_date',
        
        // Medya
        'image',
        'images',
        'images_meta',
        
        // Durum
        'is_featured',
        'is_active',
        
        // Entegrasyon
        'sahibinden_url',
        'sahibinden_id',
        'source',
        'external_id',
    ];

    protected $casts = [
        'images' => 'array',
        'features' => 'array',
        'painted_parts' => 'array',
        'replaced_parts' => 'array',
        'images_meta' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'has_warranty' => 'boolean',
        'price' => 'decimal:2',
        'tramer_amount' => 'decimal:2',
        'kilometer' => 'integer',
        'year' => 'integer',
        'horse_power' => 'integer',
        'torque' => 'integer',
        'door_count' => 'integer',
        'seat_count' => 'integer',
        'owner_number' => 'integer',
        'inspection_date' => 'date',
        'warranty_end_date' => 'date',
    ];

    /**
     * Boot method - otomatik slug oluşturma
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vehicle) {
            if (empty($vehicle->slug)) {
                $vehicle->slug = Str::slug($vehicle->title);
            }
        });

        static::updating(function ($vehicle) {
            if ($vehicle->isDirty('title') && empty($vehicle->slug)) {
                $vehicle->slug = Str::slug($vehicle->title);
            }
        });
    }

    /**
     * Route model binding için slug kullan
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Aktif araçları getir
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Öne çıkan araçları getir
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    /**
     * Fiyat formatı
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . ' ₺';
    }

    /**
     * İlk görseli getir
     */
    public function getFirstImageAttribute()
    {
        if (is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }
        return '/images/vehicles/default.jpg';
    }
}
