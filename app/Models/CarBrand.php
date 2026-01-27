<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'arabam_id',
        'slug',
        'is_active',
        'order',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the models for this brand
     */
    public function carModels()
    {
        return $this->hasMany(CarModel::class);
    }
    
    /**
     * Get active models only
     */
    public function activeModels()
    {
        return $this->hasMany(CarModel::class)->where('is_active', true)->orderBy('order');
    }
}
