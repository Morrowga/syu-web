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
            $table->uuid('id')->primary();
            $table->string('name');
            $table->decimal('points', 10, 2)->default(100);
            $table->string('email')->unique()->nullable();
            $table->string('msisdn')->unique();
            $table->longText('shipping_address')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'empty'])->default('empty');
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('is_above_eighteen')->nullable();
            $table->text('extra_address')->nullable();
            $table->string('password');
            $table->tinyInteger('is_active')->default(1);
            $table->rememberToken();
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
