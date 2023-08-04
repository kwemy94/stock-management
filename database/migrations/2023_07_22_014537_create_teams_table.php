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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('team_name', 30);
            $table->string('team_email', 30)->nullable();
            $table->string('team_function', 30)->nullable();
            $table->text('team_description', 30)->nullable();
            $table->string('team_avatar')->nullable();
            $table->string('team_facebook_profile', 50)->nullable();
            $table->string('team_linkedin_profile', 50)->nullable();
            $table->string('team_twitter_profile', 50)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
