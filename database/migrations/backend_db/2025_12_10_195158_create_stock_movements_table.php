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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('goods_receipt_id')->nullable();
            $table->string('movement_type'); // 'in' or 'out'
            $table->integer('quantity');
            $table->string('reference')->nullable(); // Reference to the related document (e.g., purchase order, sales order)
            $table->string('from_location')->nullable();
            $table->string('to_location')->nullable();
            $table->text('notes')->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('goods_receipt_id')->references('id')->on('goods_receipts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
