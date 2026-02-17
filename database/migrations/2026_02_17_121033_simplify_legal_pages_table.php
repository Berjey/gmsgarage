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
            // Gereksiz kolonları kaldır
            if (Schema::hasColumn('legal_pages', 'show_in_footer')) {
                $table->dropColumn('show_in_footer');
            }
            if (Schema::hasColumn('legal_pages', 'footer_order')) {
                $table->dropColumn('footer_order');
            }
            
            // is_required kolonunu is_required_in_forms olarak yeniden adlandır
            if (Schema::hasColumn('legal_pages', 'is_required')) {
                $table->renameColumn('is_required', 'is_required_in_forms');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_pages', function (Blueprint $table) {
            // Geri alma
            if (Schema::hasColumn('legal_pages', 'is_required_in_forms')) {
                $table->renameColumn('is_required_in_forms', 'is_required');
            }
            
            $table->boolean('show_in_footer')->default(true);
            $table->integer('footer_order')->default(0);
        });
    }
};
