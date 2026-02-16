<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Admin kontrolü (eski sistem uyumluluğu için)
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || (bool) $this->is_admin;
    }

    /**
     * Manager kontrolü
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Editor kontrolü
     */
    public function isEditor(): bool
    {
        return $this->role === 'editor';
    }

    /**
     * Belirli bir role sahip mi?
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Belirli rollerden birine sahip mi?
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Role badge rengi
     */
    public function getRoleBadgeColorAttribute(): string
    {
        return match($this->role) {
            'admin' => 'red',
            'manager' => 'blue',
            'editor' => 'green',
            default => 'gray'
        };
    }

    /**
     * Role Türkçe ismi
     */
    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Süper Yönetici',
            'manager' => 'Galeri Yöneticisi',
            'editor' => 'İçerik Editörü',
            default => 'Bilinmeyen'
        };
    }
}
