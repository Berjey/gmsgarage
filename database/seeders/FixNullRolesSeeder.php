<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FixNullRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role'ü NULL olan tüm kullanıcılara 'editor' rolü ata
        $updated = User::whereNull('role')->update(['role' => 'editor']);
        
        $this->command->info("✅ {$updated} kullanıcının rolü 'editor' olarak güncellendi.");
        
        // Tüm kullanıcıları listele
        $this->command->info('');
        $this->command->info('📊 Veritabanındaki tüm kullanıcılar:');
        User::all()->each(function($user) {
            $roleBadge = match($user->role) {
                'admin' => '🔴',
                'manager' => '🔵',
                'editor' => '🟢',
                default => '⚪'
            };
            $this->command->info("  {$roleBadge} {$user->email} => {$user->role_name}");
        });
    }
}
