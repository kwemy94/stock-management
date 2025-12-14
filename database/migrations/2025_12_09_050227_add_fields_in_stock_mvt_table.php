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
        Schema::table('product_suppliers', function (Blueprint $table) {
            $table->string('movement_type')->after('quantity')->nullable()->comment(["ENTREE STOCK", "SORTIE STOCK", "AJUSTEMENT STOCK"]);
            $table->string('from_location')->after('quantity')->nullable();
            $table->string('to_location')->after('quantity')->nullable();
            $table->float('unit_price')->after('quantity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_suppliers', function (Blueprint $table) {
            $table->dropColumn('movement_type');
            $table->dropColumn('from_location');
            $table->dropColumn('to_location');
            $table->dropColumn('unit_price');
        });
    }
};
