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
        Schema::create('purchase_order_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('quantity');
            $table->decimal('remaining_quantity');
            $table->decimal('received_quantity')->default(0);
            $table->decimal('unit_price');
            $table->decimal('taxe')->default(0);
            $table->decimal('remise')->default(0);
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_lines');
    }
};
