<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('become_retailer_forms', function (Blueprint $table) {
            $table->id();
            $table->string('companyName');
            $table->string('website')->nullable();
            $table->string('name');
            $table->string('job');
            $table->string('email');
            $table->string('phone');
            $table->string('countrycode')->nullable();
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->json('businessTypes')->nullable();
            $table->json('marketingChannels')->nullable();
            $table->json('planToPromotes')->nullable();
            $table->string('monthlyTraffic')->nullable();
            $table->string('promotoBrands')->nullable();
            $table->string('monthlyActivations')->nullable();
            $table->boolean('agreeEligibility')->default(false);
            $table->boolean('agreeTerms')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('become_retailer_forms');
    }
};
