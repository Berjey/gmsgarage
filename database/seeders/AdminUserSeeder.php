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
                'name' => 'Admin',
                'email' => 'admin@gmsgarage.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]);
        }
    }
}
