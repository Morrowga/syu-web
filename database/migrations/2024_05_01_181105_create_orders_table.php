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
            $table->dateTime('waiting_start_date');
            $table->dateTime('waiting_end_date');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->decimal('save_with_points', 10,2)->default(0);
            $table->text('note')->nullable();
            $table->dateTime('order_expired_date');
            $table->tinyInteger('paid_delivery_cost')->default(0);
            $table->enum('payment_type', ['cod', 'pp'])->default('cod');
            $table->enum('order_status', ['pending', 'confirmed', 'cancel', 'delivered'])->default('pending');

            $table->index(['order_status', 'created_at']);
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
