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
        if(Schema::hasTable('sale_invoice_lines')){
            Schema::table('sale_invoice_lines', function (Blueprint $table) {
                if(!Schema::hasColumn('sale_invoice_lines', 'buy_price')){
                    $table->decimal('buy_price')->default(0.0)->after('quantity');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasTable('sale_invoice_lines')){
            Schema::table('sale_invoice_lines', function (Blueprint $table) {
                if(Schema::hasColumn('sale_invoice_lines', 'buy_price')){
                    $table->dropColumn('buy_price');
                }
            });
        }
    }
};
