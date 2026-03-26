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
        Schema::create('arabam_vehicle_configs', function (Blueprint $table) {
            $table->id();

            // Marka
            $table->integer('brand_arabam_id');
            $table->string('brand_name', 100);

            // Yıl
            $table->string('model_year', 10);

            // Model Grubu
            $table->integer('model_group_id');
            $table->string('model_group_name', 150);

            // Kasa Tipi
            $table->integer('body_type_id')->nullable();
            $table->string('body_type_name', 100)->nullable();

            // Yakıt Tipi
            $table->integer('fuel_type_id')->nullable();
            $table->string('fuel_type_name', 100)->nullable();

            // Şanzıman
            $table->integer('transmission_id')->nullable();
            $table->string('transmission_name', 100)->nullable();

            // Versiyon / Paket
            $table->integer('version_id')->nullable();
            $table->string('version_name', 255)->nullable();

            $table->timestamps();

            // Cascade sorguları için index'ler
            $table->index('brand_arabam_id');
            $table->index(['brand_arabam_id', 'model_year']);
            $table->index(['brand_arabam_id', 'model_year', 'model_group_id']);
            $table->index(['brand_arabam_id', 'model_year', 'model_group_id', 'body_type_id']);
            $table->index(['brand_arabam_id', 'model_year', 'model_group_id', 'body_type_id', 'fuel_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arabam_vehicle_configs');
    }
};
