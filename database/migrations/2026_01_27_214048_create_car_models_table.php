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
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_brand_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Model adı
            $table->integer('arabam_id')->nullable(); // Arabam.com ID
            $table->string('slug'); // URL friendly
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // Sıralama
            $table->timestamps();
            
            $table->unique(['car_brand_id', 'name']); // Aynı marka altında aynı model 1 kere
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
};
