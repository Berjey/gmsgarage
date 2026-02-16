<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mevcut kullanıcıları güncelle (eğer role yoksa)
        User::whereNull('role')->update(['role' => 'admin']);

        // Demo kullanıcılar - mevcut varsa güncelle, yoksa oluştur
        $users = [
            [
                'name' => 'Süper Yönetici',
                'email' => 'admin@gmsgarage.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_admin' => true,
            ],
            [
                'name' => 'Galeri Yöneticisi',
                'email' => 'manager@gmsgarage.com',
                'password' => Hash::make('manager123'),
                'role' => 'manager',
                'is_admin' => false,
            ],
            [
                'name' => 'İçerik Editörü',
                'email' => 'editor@gmsgarage.com',
                'password' => Hash::make('editor123'),
                'role' => 'editor',
                'is_admin' => false,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
            $this->command->info("✅ {$user->name} ({$user->email}) - Role: {$user->role}");
        }

        // TÜM kullanıcıların role'lerini kontrol et ve logla
        $this->command->info('');
        $this->command->info('📊 Veritabanındaki tüm kullanıcılar:');
        User::all()->each(function($user) {
            $this->command->info("  - {$user->email} => Role: " . ($user->role ?? 'NULL'));
        });

        $this->command->info('');
        $this->command->info('🔑 Giriş Bilgileri:');
        $this->command->info('📧 Admin: admin@gmsgarage.com / admin123');
        $this->command->info('📧 Manager: manager@gmsgarage.com / manager123');
        $this->command->info('📧 Editor: editor@gmsgarage.com / editor123');
    }
}
