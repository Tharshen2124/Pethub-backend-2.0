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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointment_id');
            $table->foreignId('pet_id');
            $table->foreignId('user_id');
            $table->integer('pet_service_provider_ref');
            $table->string('appointment_type');
            $table->date('date');
            $table->time('time');
            $table->text('important_details');
            $table->text('issue_description')->nullable();
            $table->string('appointment_status');
            $table->string('upload_payment_proof')->nullable();
            $table->timestamp('created_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
