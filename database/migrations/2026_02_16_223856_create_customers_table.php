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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('source')->default('contact_form')->comment('contact_form, vehicle_request, evaluation_request');
            $table->boolean('kvkk_consent')->default(false)->comment('KVKK onay durumu');
            $table->string('ip_address')->nullable()->comment('Yasal zorunluluk için IP kaydı');
            $table->timestamps();
            
            // Email ve telefon kombinasyonu unique olabilir (opsiyonel)
            // $table->unique(['email', 'phone']);
            
            // Index'ler
            $table->index('email');
            $table->index('phone');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
