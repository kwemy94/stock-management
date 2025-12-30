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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Free, Basic, Pro, Entreprise, etc.');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('duration_days')->comment('Duration 30j, 365j, etc.');
            $table->json('features')->nullable()->comment('List of features included in the plan');
            $table->json('limits')->nullable()->comment('Limits like max users, max products, etc.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
