<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // default(false) → eski kayıtlar "pazarlık yok" olarak güvenle kalır
            $table->boolean('price_negotiable')->default(false)->after('swap');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('price_negotiable');
        });
    }
};
