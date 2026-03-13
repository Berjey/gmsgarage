<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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
        'vehicle_status',
        'condition',
        'city',
        'swap',
        'price_negotiable',
        'views',
        
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
        'is_featured'    => 'boolean',
        'is_active'      => 'boolean',
        'swap'            => 'boolean',
        'price_negotiable'=> 'boolean',
        'vehicle_status' => 'string',
        'views'          => 'integer',
        'has_warranty' => 'boolean',
        'price' => 'decimal:2',
        'tramer_amount' => 'decimal:2',
        'kilometer' => 'integer',
        'year' => 'integer',
        'engine_size' => 'integer',
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
                $vehicle->slug = static::generateUniqueSlug($vehicle->title);
            }
        });

        static::updating(function ($vehicle) {
            // Yalnızca slug tamamen boşsa otomatik üret; dolu slug'ı asla üzerine yazma
            if (empty($vehicle->slug)) {
                $vehicle->slug = static::generateUniqueSlug($vehicle->title, $vehicle->id);
            }
        });
    }

    /**
     * Verilen başlıktan benzersiz bir slug üretir.
     * Çakışma varsa sonuna -1, -2, ... ekler.
     * excludeId: güncelleme sırasında kendi kaydını dışarıda bırakmak için.
     */
    public static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $base    = Str::slug($title) ?: 'arac';
        $slug    = $base;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Route model binding için slug kullan
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /** Türkiye'nin 81 ili (alfabetik) */
    public const CITIES = [
        'Adana','Adıyaman','Afyonkarahisar','Ağrı','Aksaray','Amasya','Ankara','Antalya',
        'Ardahan','Artvin','Aydın','Balıkesir','Bartın','Batman','Bayburt','Bilecik',
        'Bingöl','Bitlis','Bolu','Burdur','Bursa','Çanakkale','Çankırı','Çorum',
        'Denizli','Diyarbakır','Düzce','Edirne','Elazığ','Erzincan','Erzurum','Eskişehir',
        'Gaziantep','Giresun','Gümüşhane','Hakkari','Hatay','Iğdır','Isparta','İstanbul',
        'İzmir','Kahramanmaraş','Karabük','Karaman','Kars','Kastamonu','Kayseri','Kilis',
        'Kırıkkale','Kırklareli','Kırşehir','Kocaeli','Konya','Kütahya','Malatya','Manisa',
        'Mardin','Mersin','Muğla','Muş','Nevşehir','Niğde','Ordu','Osmaniye','Rize',
        'Sakarya','Samsun','Siirt','Sinop','Sivas','Şanlıurfa','Şırnak','Tekirdağ',
        'Tokat','Trabzon','Tunceli','Uşak','Van','Yalova','Yozgat','Zonguldak','Diğer',
    ];

    /** Geçerli condition değerleri ve Türkçe etiketleri */
    public const CONDITIONS = [
        'second_hand' => 'İkinci El',
        'zero_km'     => 'Sıfır',
    ];

    /** Condition için Türkçe etiket */
    public function getConditionLabelAttribute(): ?string
    {
        if (empty($this->condition)) {
            return null;
        }
        return self::CONDITIONS[$this->condition] ?? $this->condition;
    }

    /** Geçerli vehicle_status değerleri */
    public const STATUSES = [
        'available'   => 'Satılık',
        'sold'        => 'Satıldı',
        'reserved'    => 'Rezerve',
        'opportunity' => 'Fırsat',
    ];

    /** Türkçe durum etiketi */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->vehicle_status ?? 'available'] ?? 'Satılık';
    }

    /**
     * Tailwind badge renk sınıfları (bg + text).
     * is_active ve vehicle_status birbirinden bağımsızdır.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->vehicle_status ?? 'available') {
            'sold'        => 'bg-red-100 text-red-700 border-red-200',
            'reserved'    => 'bg-yellow-100 text-yellow-700 border-yellow-200',
            'opportunity' => 'bg-green-100 text-green-700 border-green-200',
            default       => 'bg-blue-100 text-blue-700 border-blue-200',
        };
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
     * Herhangi bir görsel yolunu display-ready URL'ye çevirir.
     * Tüm path formatlarıyla geriye dönük uyumludur:
     *   - 'vehicles/file.jpg'      → '/storage/vehicles/file.jpg'
     *   - '/storage/vehicles/...'  → değişmeden
     *   - 'https://...'            → değişmeden
     *   - '/'  ile başlayan        → değişmeden
     */
    public static function resolveImageUrl(?string $path): string
    {
        if (empty($path)) {
            return asset('images/vehicles/default.jpg');
        }
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        if (str_starts_with($path, '/')) {
            return $path;
        }
        return Storage::url($path);
    }

    /**
     * images[] dizisinden images_meta[] dizisi oluşturur ve senkronize tutar.
     * Boş/null path'leri siler; TypeHint güvenliği için önce filtreler.
     */
    public static function buildImagesMeta(array $images, ?string $mainPath = null): array
    {
        $images = array_values(array_filter($images, fn ($p) => is_string($p) && $p !== ''));

        return array_values(array_map(function (string $path, int $index) use ($mainPath): array {
            return [
                'path'       => $path,
                'sort_order' => $index,
                'is_main'    => !empty($mainPath) ? ($path === $mainPath) : ($index === 0),
            ];
        }, $images, array_keys($images)));
    }

    /**
     * Tüm görselleri display-ready URL olarak döner.
     * Eski kayıtlarda images null ise sadece 'image' alanından fallback yapar.
     */
    public function getAllImagesAttribute(): array
    {
        $paths = [];

        if (is_array($this->images) && count($this->images) > 0) {
            $paths = $this->images;
        } elseif (!empty($this->image)) {
            $paths = [$this->image];
        }

        return array_values(array_filter(array_map(
            fn ($p) => static::resolveImageUrl($p),
            $paths
        )));
    }

    /**
     * Ana (kapak) görseli display-ready URL olarak döner.
     */
    public function getFirstImageAttribute(): string
    {
        if (is_array($this->images) && count($this->images) > 0) {
            return static::resolveImageUrl($this->images[0]);
        }
        if (!empty($this->image)) {
            return static::resolveImageUrl($this->image);
        }
        return asset('images/vehicles/default.jpg');
    }
}
