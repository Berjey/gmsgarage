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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Kısa özet
            $table->longText('content'); // İçerik
            $table->string('featured_image')->nullable(); // Öne çıkan görsel
            $table->string('meta_title')->nullable(); // SEO başlık
            $table->text('meta_description')->nullable(); // SEO açıklama
            $table->json('meta_keywords')->nullable(); // SEO anahtar kelimeler
            $table->string('category')->default('Genel'); // Kategori
            $table->string('author')->default('GMSGARAGE'); // Yazar
            $table->integer('views')->default(0); // Görüntülenme sayısı
            $table->integer('reading_time')->nullable(); // Okuma süresi (dakika)
            $table->boolean('is_featured')->default(false); // Öne çıkan
            $table->boolean('is_published')->default(true); // Yayınlandı mı
            $table->timestamp('published_at')->nullable(); // Yayın tarihi
            $table->timestamps();

            $table->index('slug');
            $table->index('is_published');
            $table->index('is_featured');
            $table->index('category');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
