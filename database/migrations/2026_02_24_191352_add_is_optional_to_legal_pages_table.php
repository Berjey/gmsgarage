<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('legal_pages', function (Blueprint $table) {
            // Opsiyonel form sözleşmesi (görünür ama zorunlu değil, müşteri listesi için gerekli)
            $table->boolean('is_optional_in_forms')->default(false)->after('is_required_in_forms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_pages', function (Blueprint $table) {
            $table->dropColumn('is_optional_in_forms');
        });
    }
};
