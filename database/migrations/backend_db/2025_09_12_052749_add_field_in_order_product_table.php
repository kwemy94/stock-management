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
        if(Schema::hasTable('order_products')){
            Schema::table('order_products', function (Blueprint $table) {
                if(!Schema::hasColumn('order_products', 'unit_price')){
                    $table->decimal('unit_price')->nullable()->after('quantity');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('order_products')){
            Schema::table('order_products', function (Blueprint $table) {
                if(Schema::hasColumn('order_products', 'unit_price')){
                    $table->dropColumn('unit_price');
                }
            });
        }
    }
};
