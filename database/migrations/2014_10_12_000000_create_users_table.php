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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('permission_level', ['1', '2', '3']);
            $table->string('image');
            $table->text('description')->nullable();
            $table->string('contact_number')->nullable();
            $table->float('deposit_range')->default(0);
            $table->string('service_type')->nullable();
            $table->time('opening_hour')->nullable();
            $table->time('closing_hour')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('beneficiary_acc_number')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->string('qr_code_image')->nullable();
            $table->string('user_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
