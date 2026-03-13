<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // nullable — eski kayıtlar null kalır, frontend bunu güvenli şekilde işler
            $table->string('condition', 20)->nullable()->default(null)->after('vehicle_status');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('condition');
        });
    }
};
