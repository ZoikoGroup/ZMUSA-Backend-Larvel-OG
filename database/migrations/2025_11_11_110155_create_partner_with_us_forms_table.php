<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('partner_with_us_forms', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('website')->nullable();
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('name');
            $table->string('job');
            $table->string('email');
            $table->string('countrycode')->nullable();
            $table->string('phone');
            $table->string('years_in_business');
            $table->string('monthly_sales');
            $table->json('business_types')->nullable();
            $table->json('solutions')->nullable();
            $table->string('sale_other_carriers');
            $table->string('target_market');
            $table->string('preferred_partnership_model');
            $table->string('bank_transfer')->nullable();
            $table->string('billing_contact');
            $table->string('billing_email');
            $table->string('preferred_shipping_method');
            $table->boolean('agree_eligibility')->default(false);
            $table->boolean('agree_terms')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_with_us_forms');
    }
};
