<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('audit_logs');
    }

    public function down(): void
    {
        Schema::create('audit_logs', function ($table) {
            $table->id();
            $table->timestamps();
        });
    }
};
