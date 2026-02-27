<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'category',
        'author',
        'views',
        'reading_time',
        'is_featured',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'meta_keywords' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
        'reading_time' => 'integer',
    ];

    /**
     * Boot method - otomatik slug oluşturma
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            if (empty($post->reading_time)) {
                $post->reading_time = self::estimateReadingTime($post->content);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            if ($post->isDirty('content')) {
                $post->reading_time = self::estimateReadingTime($post->content);
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
     * Yayınlanmış postları getir
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Öne çıkan postları getir
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_published', true);
    }

    /**
     * Kategoriye göre filtrele
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Türkçe dahil çok dilli metin için okuma süresi hesapla (yaklaşık 200 kelime/dakika)
     */
    private static function estimateReadingTime(?string $content): int
    {
        $text      = strip_tags((string) $content);
        $wordCount = preg_match_all('/\S+/u', $text);
        return max(1, (int) ceil($wordCount / 200));
    }

    /**
     * Görüntülenme sayısını artır
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Meta title yoksa title kullan
     */
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    /**
     * Meta description yoksa excerpt kullan
     */
    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: Str::limit(strip_tags($this->excerpt ?: $this->content), 160);
    }
}
