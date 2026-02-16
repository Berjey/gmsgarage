<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'source',
        'kvkk_consent',
        'ip_address',
        'legal_consents',
        'consent_given_at',
        'consent_ip',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'kvkk_consent' => 'boolean',
        'legal_consents' => 'array',
        'consent_given_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get formatted phone for WhatsApp
     */
    public function getWhatsappLinkAttribute(): string
    {
        if (!$this->phone) {
            return '#';
        }
        
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->phone);
        return "https://wa.me/{$cleanPhone}";
    }

    /**
     * Get source name in Turkish
     */
    public function getSourceNameAttribute(): string
    {
        return match($this->source) {
            'contact_form' => 'İletişim Formu',
            'vehicle_request' => 'Araç İsteği',
            'evaluation_request' => 'Değerleme Talebi',
            default => 'Bilinmiyor'
        };
    }

    /**
     * Get source badge color
     */
    public function getSourceBadgeColorAttribute(): string
    {
        return match($this->source) {
            'contact_form' => 'blue',
            'vehicle_request' => 'green',
            'evaluation_request' => 'purple',
            default => 'gray'
        };
    }

    /**
     * Check if customer exists by email
     */
    public static function existsByEmail(string $email): bool
    {
        return self::where('email', $email)->exists();
    }

    /**
     * Find or create customer with legal consent tracking
     */
    public static function findOrCreateFromRequest(array $data): self
    {
        $legalConsents = [];
        
        // Get all active legal pages and their versions
        $legalPages = \App\Models\LegalPage::getActive();
        foreach ($legalPages as $page) {
            $legalConsents[$page->slug] = [
                'title' => $page->title,
                'version' => $page->version,
                'accepted_at' => now()->toDateTimeString(),
            ];
        }

        return self::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'source' => $data['source'] ?? 'contact_form',
                'kvkk_consent' => $data['kvkk_consent'] ?? false,
                'ip_address' => $data['ip_address'] ?? request()->ip(),
                'legal_consents' => $legalConsents,
                'consent_given_at' => now(),
                'consent_ip' => request()->ip(),
            ]
        );
    }
}
