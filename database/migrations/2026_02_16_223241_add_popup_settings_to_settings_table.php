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
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('popup_status')->default(false)->after('og_image');
            $table->string('popup_image')->nullable()->after('popup_status');
            $table->string('popup_title')->nullable()->after('popup_image');
            $table->text('popup_text')->nullable()->after('popup_title');
            $table->string('popup_link')->nullable()->after('popup_text');
            $table->string('popup_button_text')->default('Detayları İncele')->after('popup_link');
            $table->enum('popup_display_frequency', ['always', 'daily', 'once'])->default('daily')->after('popup_button_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'popup_status',
                'popup_image',
                'popup_title',
                'popup_text',
                'popup_link',
                'popup_button_text',
                'popup_display_frequency'
            ]);
        });
    }
};
