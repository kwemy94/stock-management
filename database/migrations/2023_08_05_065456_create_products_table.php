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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('product_name', 50)->unique();
            $table->integer('unit_price');
            $table->integer('sale_price');
            $table->integer('stock_quantity');
            $table->integer('stock_alert');
            $table->string('code',25);
            $table->text('barcode');
            $table->string('product_image')->nullable();
            $table->string('description', 50)->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
