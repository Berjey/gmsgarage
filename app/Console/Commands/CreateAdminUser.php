<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Admin kullanıcı adı?', 'Admin');
        $email = $this->ask('E-posta?', 'admin@gmsgarage.com');
        $password = $this->secret('Şifre?') ?: 'password';
        
        // Check if user exists
        $existingUser = \App\Models\User::where('email', $email)->first();
        
        if ($existingUser) {
            if ($this->confirm('Bu e-posta ile kullanıcı zaten var. Şifreyi güncellemek ister misiniz?')) {
                $existingUser->password = \Illuminate\Support\Facades\Hash::make($password);
                $existingUser->is_admin = true;
                $existingUser->save();
                
                $this->info('✅ Kullanıcı güncellendi!');
                $this->table(
                    ['Ad', 'E-posta', 'Şifre'],
                    [[$existingUser->name, $existingUser->email, $password]]
                );
                return 0;
            }
            
            $this->error('❌ İşlem iptal edildi.');
            return 1;
        }
        
        // Create new admin user
        $user = \App\Models\User::create([
            'name' => $name,
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'is_admin' => true,
        ]);
        
        $this->info('✅ Admin kullanıcı başarıyla oluşturuldu!');
        $this->table(
            ['Ad', 'E-posta', 'Şifre'],
            [[$user->name, $user->email, $password]]
        );
        
        return 0;
    }
}
