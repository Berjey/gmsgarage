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
        Schema::table('vehicles', function (Blueprint $table) {
            // A) Araç Özellikleri (Opsiyonel - Web'de tablo satırı olarak göster)
            $table->string('package_version')->nullable()->after('model'); // Paket/Versiyon
            $table->enum('drive_type', ['Önden Çekiş', 'Arkadan İtiş', '4x4'])->nullable()->after('transmission'); // Çekiş Tipi
            $table->integer('door_count')->nullable()->after('body_type'); // Kapı Sayısı
            $table->integer('seat_count')->nullable()->after('door_count'); // Koltuk Sayısı
            $table->integer('torque')->nullable()->after('horse_power'); // Tork (Nm)
            $table->string('color_type')->nullable()->after('color'); // Renk Tipi (Metalik/Mat/İnci)
            
            // B) Hasar & Geçmiş (Opsiyonel - Sadece panelde veya web'de minimal gösterim)
            $table->enum('tramer_status', ['Yok', 'Var', 'Bilinmiyor'])->nullable()->after('description'); // Tramer Durumu
            $table->decimal('tramer_amount', 10, 2)->nullable()->after('tramer_status'); // Tramer Tutarı
            $table->json('painted_parts')->nullable()->after('tramer_amount'); // Boyalı Parçalar (array)
            $table->json('replaced_parts')->nullable()->after('painted_parts'); // Değişen Parçalar (array)
            $table->integer('owner_number')->nullable()->after('replaced_parts'); // Kaçıncı Sahip
            $table->date('inspection_date')->nullable()->after('owner_number'); // Muayene Tarihi
            $table->boolean('has_warranty')->default(false)->after('inspection_date'); // Garanti Var/Yok
            $table->date('warranty_end_date')->nullable()->after('has_warranty'); // Garanti Bitiş Tarihi
            
            // C) Sahibinden Entegrasyonu (Gizli - İleride API için)
            $table->string('source')->default('manual')->after('sahibinden_id'); // manual / sahibinden / arabam
            $table->string('external_id')->nullable()->after('source'); // Dış kaynak ID
            
            // D) Medya (Sıralama ve ana görsel)
            $table->json('images_meta')->nullable()->after('images'); // [{path, sort_order, is_main}, ...]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'package_version',
                'drive_type',
                'door_count',
                'seat_count',
                'torque',
                'color_type',
                'tramer_status',
                'tramer_amount',
                'painted_parts',
                'replaced_parts',
                'owner_number',
                'inspection_date',
                'has_warranty',
                'warranty_end_date',
                'source',
                'external_id',
                'images_meta',
            ]);
        });
    }
};
