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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_no')->nullable();
            $table->string('user_id');
            $table->foreign('user_id')
            ->references('id')
            ->on('users')->onDelete('cascade');
            $table->date('waiting_start_date');
            $table->date('waiting_end_date');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->decimal('overall_price', 10, 2)->default(0);
            $table->text('note')->nullable();
            $table->dateTime('order_expired_date');
            $table->tinyInteger('paid_delivery_cost')->default(0);
            $table->string('payment_method')->nullable();
            $table->enum('order_status', ['pending', 'confirmed', 'expired', 'cancel', 'delivered'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
