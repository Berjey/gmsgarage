<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create {--reset : Reset existing admin password}';
    protected $description = 'Create or reset admin user';

    public function handle()
    {
        $email = 'admin@gmsgarage.com';
        $password = 'admin123';
        
        $user = User::where('email', $email)->first();
        
        if ($user) {
            if ($this->option('reset') || $this->confirm('Admin user exists. Reset password?', true)) {
                $user->password = Hash::make($password);
                $user->is_admin = true;
                $user->save();
                $this->info('Admin password reset successfully!');
                $this->info("Email: {$email}");
                $this->info("Password: {$password}");
            } else {
                $this->info('Admin user already exists. Use --reset to reset password.');
            }
        } else {
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]);
            $this->info('Admin user created successfully!');
            $this->info("Email: {$email}");
            $this->info("Password: {$password}");
        }
        
        return 0;
    }
}
