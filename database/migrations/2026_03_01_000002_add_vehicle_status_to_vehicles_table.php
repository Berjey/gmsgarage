<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // is_active = yayın görünürlüğü (mevcut, değişmiyor)
            // vehicle_status = satış/iş durumu (yeni)
            $table->string('vehicle_status', 20)->default('available')->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('vehicle_status');
        });
    }
};
