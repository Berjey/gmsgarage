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
            $table->boolean('show_in_footer')->default(true)->after('is_required');
            $table->integer('footer_order')->default(0)->after('show_in_footer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_pages', function (Blueprint $table) {
            $table->dropColumn(['show_in_footer', 'footer_order']);
        });
    }
};
