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
        Schema::create('military_discount_forms', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('email');
            $table->string('countrycode')->nullable();
            $table->string('phone');
            $table->string('statusproof')->nullable(); // file path
            $table->string('plan')->nullable();
            $table->string('cat')->nullable();
            $table->boolean('concent')->default(false);
            $table->boolean('terms')->default(false);
            $table->json('family')->nullable(); // JSON array of family members
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('military_discount_forms');
    }
};
