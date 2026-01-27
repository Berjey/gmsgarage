<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'car_brand_id',
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
     * Get the brand that owns this model
     */
    public function carBrand()
    {
        return $this->belongsTo(CarBrand::class);
    }
}
