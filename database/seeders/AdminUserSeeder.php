<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin kullanıcısı oluştur (eğer yoksa)
        if (!User::where('email', 'admin@gmsgarage.com')->exists()) {
            User::create([
                'name' => 'Gms Garage Süper Admin',
                'email' => 'admin@gmsgarage.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'role' => 'admin',
            ]);
        }

        // Galeri Yöneticisi
        if (!User::where('email', 'manager@gmsgarage.com')->exists()) {
            User::create([
                'name' => 'Galeri Yöneticisi',
                'email' => 'manager@gmsgarage.com',
                'password' => Hash::make('manager123'),
                'is_admin' => true,
                'role' => 'manager',
            ]);
        }

        // Editör
        if (!User::where('email', 'editor@gmsgarage.com')->exists()) {
            User::create([
                'name' => 'Editör',
                'email' => 'editor@gmsgarage.com',
                'password' => Hash::make('editor123'),
                'is_admin' => true,
                'role' => 'editor',
            ]);
        }
    }
}
