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
        Schema::create('goods_receipt_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goods_receipt_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity_received');
            $table->integer('quantity_expected');
            $table->decimal('unit_price', 15, 2);
            $table->text('observations')->nullable();
            $table->foreign('goods_receipt_id')->references('id')->on('goods_receipts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_lines');
    }
};
