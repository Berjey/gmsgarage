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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->decimal('price', 12, 2);
            $table->integer('kilometer')->nullable();
            $table->string('fuel_type')->nullable(); // Benzin, Dizel, Hybrid, Elektrik
            $table->string('transmission')->nullable(); // Manuel, Otomatik
            $table->string('body_type')->nullable(); // Sedan, Hatchback, SUV, vb.
            $table->string('color')->nullable();
            $table->string('engine_size')->nullable();
            $table->integer('horse_power')->nullable();
            $table->text('description')->nullable();
            $table->json('features')->nullable(); // Özellikler listesi
            $table->json('images')->nullable(); // Görseller array
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('sahibinden_url')->nullable(); // Sahibinden.com linki
            $table->string('sahibinden_id')->nullable(); // Sahibinden.com ID (Faz 2 için)
            $table->timestamps();

            $table->index('slug');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('brand');
            $table->index('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
