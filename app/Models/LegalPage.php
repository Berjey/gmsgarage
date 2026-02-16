<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'is_active',
        'is_required',
        'version',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_required' => 'boolean',
    ];

    /**
     * Get active legal pages
     */
    public static function getActive()
    {
        return self::where('is_active', true)->orderBy('title')->get();
    }

    /**
     * Get page by slug
     */
    public static function getBySlug($slug)
    {
        return self::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    /**
     * Increment version when content is updated
     */
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($page) {
            if ($page->isDirty('content')) {
                $page->version++;
            }
        });
    }
}
