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
        Schema::create('sent_emails', function (Blueprint $table) {
            $table->id();
            $table->string('to');
            $table->string('subject');
            $table->string('customer_name');
            $table->enum('request_type', ['degerleme_alindi', 'iletisim_alindi'])->nullable();
            $table->string('reference_id')->nullable();
            $table->text('message_text');
            $table->text('html_body');
            $table->text('plain_text_body');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->string('smtp_message_id')->nullable();
            $table->text('error')->nullable();
            $table->timestamps();
            
            $table->index('to');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_emails');
    }
};
