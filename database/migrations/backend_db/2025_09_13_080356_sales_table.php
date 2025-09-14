<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Articles
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'prix_gros')) {
                    $table->decimal('prix_gros')->nullable()->after('sale_price');
                }
            });
        }

        // Factures
        Schema::create('sale_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->date('date');
            $table->enum('type_vente', ['gros', 'detail']);
            $table->decimal('montant_facture', 15, 2)->default(0);
            $table->decimal('montant_encaisse', 15, 2)->default(0);
            $table->decimal('montant_du', 15, 2)->default(0);
            $table->enum('status', ['draft', 'confirmed', 'cancelled'])->default('draft');
            $table->softDeletes();
            $table->timestamps();
        });

        // Lignes de facture
        Schema::create('sale_invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('sale_invoices')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->decimal('remise', 15, 2)->default(0);
            $table->decimal('taxe', 15, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        // Tarifications
        Schema::create('sale_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->enum('type_vente', ['gros', 'detail']);
            $table->integer('quantite_min')->default(1);
            $table->decimal('prix_unitaire', 15, 2);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('payment_modes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ex: "Espèces", "Chèque", "Virement bancaire", "Mobile Money"
            $table->string('code')->unique(); // ex: "cash", "cheque", "bank_transfer", "momo"
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });


        // Paiements
        Schema::create('sale_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('sale_invoices')->cascadeOnDelete();
            $table->foreignId('mode_id')->constrained('payment_modes');
            $table->decimal('montant', 15, 2);
            $table->date('date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_payments');
        Schema::dropIfExists('sale_pricings');
        Schema::dropIfExists('sale_invoice_lines');
        Schema::dropIfExists('sale_invoices');

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (Schema::hasColumn('products', 'prix_gros')) {
                    $table->dropColumn('prix_gros');
                }
            });
        }
    }
};
