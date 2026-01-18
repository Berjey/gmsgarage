<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'brand',
        'model',
        'year',
        'price',
        'kilometer',
        'fuel_type',
        'transmission',
        'body_type',
        'color',
        'engine_size',
        'horse_power',
        'description',
        'features',
        'image',
        'images',
        'is_featured',
        'is_active',
        'sahibinden_url',
        'sahibinden_id',
    ];

    protected $casts = [
        'images' => 'array',
        'features' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'kilometer' => 'integer',
        'year' => 'integer',
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
