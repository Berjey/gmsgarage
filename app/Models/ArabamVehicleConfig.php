<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArabamVehicleConfig extends Model
{
    protected $fillable = [
        'brand_arabam_id', 'brand_name',
        'model_year',
        'model_group_id', 'model_group_name',
        'body_type_id', 'body_type_name',
        'fuel_type_id', 'fuel_type_name',
        'transmission_id', 'transmission_name',
        'version_id', 'version_name',
    ];

    protected $casts = [
        'brand_arabam_id'  => 'integer',
        'model_group_id'   => 'integer',
        'body_type_id'     => 'integer',
        'fuel_type_id'     => 'integer',
        'transmission_id'  => 'integer',
        'version_id'       => 'integer',
    ];

    /**
     * Belirli bir marka için yılları döndürür (yeniden eskiye).
     */
    public static function getYears(int $brandArabamId): array
    {
        return self::where('brand_arabam_id', $brandArabamId)
            ->select('model_year')
            ->distinct()
            ->orderByDesc('model_year')
            ->pluck('model_year')
            ->toArray();
    }

    /**
     * Marka + yıl için model gruplarını döndürür.
     */
    public static function getModelGroups(int $brandArabamId, string $year): array
    {
        return self::where('brand_arabam_id', $brandArabamId)
            ->where('model_year', $year)
            ->select('model_group_id', 'model_group_name')
            ->distinct()
            ->orderBy('model_group_name')
            ->get()
            ->map(fn($r) => ['Id' => $r->model_group_id, 'Name' => $r->model_group_name])
            ->toArray();
    }

    /**
     * Marka + yıl + model grubu için kasa tiplerini döndürür.
     */
    public static function getBodyTypes(int $brandArabamId, string $year, int $modelGroupId): array
    {
        return self::where('brand_arabam_id', $brandArabamId)
            ->where('model_year', $year)
            ->where('model_group_id', $modelGroupId)
            ->whereNotNull('body_type_id')
            ->select('body_type_id', 'body_type_name')
            ->distinct()
            ->orderBy('body_type_name')
            ->get()
            ->map(fn($r) => ['Id' => $r->body_type_id, 'Name' => $r->body_type_name])
            ->toArray();
    }

    /**
     * Marka + yıl + model grubu + kasa tipi için yakıt tiplerini döndürür.
     */
    public static function getFuelTypes(int $brandArabamId, string $year, int $modelGroupId, int $bodyTypeId): array
    {
        return self::where('brand_arabam_id', $brandArabamId)
            ->where('model_year', $year)
            ->where('model_group_id', $modelGroupId)
            ->where('body_type_id', $bodyTypeId)
            ->whereNotNull('fuel_type_id')
            ->select('fuel_type_id', 'fuel_type_name')
            ->distinct()
            ->orderBy('fuel_type_name')
            ->get()
            ->map(fn($r) => ['Id' => $r->fuel_type_id, 'Name' => $r->fuel_type_name])
            ->toArray();
    }

    /**
     * Şanzıman tiplerini döndürür.
     */
    public static function getTransmissions(int $brandArabamId, string $year, int $modelGroupId, int $bodyTypeId, int $fuelTypeId): array
    {
        return self::where('brand_arabam_id', $brandArabamId)
            ->where('model_year', $year)
            ->where('model_group_id', $modelGroupId)
            ->where('body_type_id', $bodyTypeId)
            ->where('fuel_type_id', $fuelTypeId)
            ->whereNotNull('transmission_id')
            ->select('transmission_id', 'transmission_name')
            ->distinct()
            ->orderBy('transmission_name')
            ->get()
            ->map(fn($r) => ['Id' => $r->transmission_id, 'Name' => $r->transmission_name])
            ->toArray();
    }

    /**
     * Versiyonları döndürür.
     */
    public static function getVersions(int $brandArabamId, string $year, int $modelGroupId, int $bodyTypeId, int $fuelTypeId, int $transmissionId): array
    {
        return self::where('brand_arabam_id', $brandArabamId)
            ->where('model_year', $year)
            ->where('model_group_id', $modelGroupId)
            ->where('body_type_id', $bodyTypeId)
            ->where('fuel_type_id', $fuelTypeId)
            ->where('transmission_id', $transmissionId)
            ->whereNotNull('version_id')
            ->select('version_id', 'version_name')
            ->distinct()
            ->orderBy('version_name')
            ->get()
            ->map(fn($r) => ['Id' => $r->version_id, 'Name' => $r->version_name])
            ->toArray();
    }

    /**
     * DB'nin dolu olup olmadığını kontrol eder.
     */
    public static function isSynced(): bool
    {
        return self::exists();
    }
}
