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
        Schema::create('legal_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Başlık (Örn: KVKK Aydınlatma Metni)
            $table->string('slug')->unique(); // URL slug (Örn: kvkk-aydinlatma-metni)
            $table->longText('content'); // Yasal metin içeriği
            $table->boolean('is_active')->default(true); // Aktif/Pasif
            $table->boolean('is_required')->default(true); // Zorunlu okuma gerekli mi?
            $table->integer('version')->default(1); // Metin versiyonu (yasal kayıt için)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_pages');
    }
};
