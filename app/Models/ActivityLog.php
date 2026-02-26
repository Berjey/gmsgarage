<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * İlişki: Log hangi kullanıcıya ait
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper: Aktivite logla
     */
    public static function log(string $action, string $description, ?string $modelType = null, ?int $modelId = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Accessor: İkon
     */
    public function getIconAttribute()
    {
        return match($this->action) {
            'login' => '🔐',
            'created' => '➕',
            'updated' => '✏️',
            'deleted' => '🗑️',
            'viewed' => '👁️',
            default => '📝',
        };
    }

    /**
     * Accessor: Renk
     */
    public function getColorAttribute()
    {
        return match($this->action) {
            'login' => 'blue',
            'created' => 'green',
            'updated' => 'amber',
            'deleted' => 'red',
            'viewed' => 'gray',
            default => 'gray',
        };
    }
}
