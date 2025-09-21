<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('sale_invoices')) {
            Schema::table('sale_invoices', function (Blueprint $table) {
                if (Schema::hasColumn('sale_invoices', 'status')) {
                    $table->string('status')->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sale_invoices')) {
            Schema::table('sale_invoices', function (Blueprint $table) {
                if (!Schema::hasColumn('sale_invoices', 'status')) {
                    $table->enum('status', ['draft', 'confirmed', 'canceled'])->change();

                }
            });
        }
    }
};
