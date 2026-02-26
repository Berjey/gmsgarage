<?php

namespace App\Support;

/**
 * Merkezi admin panel yetki haritası.
 *
 * Bir rol için izin vermek veya kaldırmak istediğinizde
 * yalnızca bu dosyayı düzenlemeniz yeterlidir.
 *
 * Kullanım:
 *   AdminPermissions::can('editor', AdminPermissions::BLOG)         // true
 *   AdminPermissions::can('editor', AdminPermissions::LEGAL_PAGE)   // false
 *   AdminPermissions::permissionsFor('manager')                     // ['blog', 'vehicle', ...]
 */
final class AdminPermissions
{
    // -------------------------------------------------------
    // İçerik türü sabitleri
    // -------------------------------------------------------
    const LEGAL_PAGE         = 'legal_page';
    const BLOG               = 'blog';
    const VEHICLE            = 'vehicle';
    const CUSTOMER           = 'customer';
    const CUSTOMER_EXPORT    = 'customer_export';
    const CUSTOMER_BULK_MAIL = 'customer_bulk_mail';
    const CONTACT_MESSAGE    = 'contact_message';
    const EVALUATION_REQUEST = 'evaluation_request';
    const SETTING            = 'setting';
    const USER               = 'user';
    const SITEMAP            = 'sitemap';
    const ACTIVITY_LOG       = 'activity_log';

    // -------------------------------------------------------
    // Rol → İzin haritası
    // Yeni bir içerik türü veya rol eklemek için
    // yalnızca bu diziyi güncelleyin.
    // -------------------------------------------------------
    private static array $map = [

        'admin' => [
            self::LEGAL_PAGE,
            self::BLOG,
            self::VEHICLE,
            self::CUSTOMER,
            self::CUSTOMER_EXPORT,
            self::CUSTOMER_BULK_MAIL,
            self::CONTACT_MESSAGE,
            self::EVALUATION_REQUEST,
            self::SETTING,
            self::USER,
            self::SITEMAP,
            self::ACTIVITY_LOG,
        ],

        'manager' => [
            self::BLOG,
            self::VEHICLE,
            self::CUSTOMER,
            self::CUSTOMER_EXPORT,
            self::CUSTOMER_BULK_MAIL,
            self::CONTACT_MESSAGE,
            self::EVALUATION_REQUEST,
        ],

        'editor' => [
            self::BLOG,
            self::CUSTOMER,
        ],
    ];

    /**
     * Belirtilen rolün belirtilen içerik türü için yetkisi var mı?
     */
    public static function can(string $role, string $contentType): bool
    {
        return in_array($contentType, self::$map[$role] ?? [], true);
    }

    /**
     * Belirtilen rolün tüm izinlerini döndür.
     */
    public static function permissionsFor(string $role): array
    {
        return self::$map[$role] ?? [];
    }

    /**
     * Belirtilen içerik türüne erişebilen tüm rolleri döndür.
     */
    public static function rolesFor(string $contentType): array
    {
        return array_keys(array_filter(
            self::$map,
            fn(array $permissions) => in_array($contentType, $permissions, true)
        ));
    }
}
