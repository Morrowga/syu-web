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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->foreign('order_id')
            ->references('id')
            ->on('orders')->onDelete('cascade');
            $table->string('product_id');
            $table->foreign('product_id')
            ->references('id')
            ->on('products')->onDelete('cascade');
            $table->string('size_id');
            $table->foreign('size_id')
            ->references('id')
            ->on('sizes')->onDelete('cascade');
            $table->string('quality_id');
            $table->foreign('quality_id')
            ->references('id')
            ->on('qualities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
