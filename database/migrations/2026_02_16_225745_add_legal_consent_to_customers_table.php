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
        Schema::table('customers', function (Blueprint $table) {
            $table->json('legal_consents')->nullable()->after('kvkk_consent'); // Hangi yasal metinleri onayladı
            $table->timestamp('consent_given_at')->nullable()->after('legal_consents'); // Onay tarihi
            $table->string('consent_ip')->nullable()->after('consent_given_at'); // Onay IP adresi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['legal_consents', 'consent_given_at', 'consent_ip']);
        });
    }
};
