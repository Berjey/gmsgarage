<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'brand',
        'model',
        'year',
        'budget',
        'message',
        'is_read',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    /**
     * Mark request as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }
}
