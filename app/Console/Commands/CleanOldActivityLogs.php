<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CleanOldActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clean-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '7 günden eski aktivite loglarını otomatik temizler';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧹 7 günden eski aktivite logları temizleniyor...');
        
        $sevenDaysAgo = Carbon::now()->subDays(7);
        
        $deletedCount = ActivityLog::where('created_at', '<', $sevenDaysAgo)->delete();
        
        if ($deletedCount > 0) {
            $this->info("✅ {$deletedCount} adet eski log başarıyla silindi!");
        } else {
            $this->info('✅ Silinecek eski log bulunamadı.');
        }
        
        return 0;
    }
}
