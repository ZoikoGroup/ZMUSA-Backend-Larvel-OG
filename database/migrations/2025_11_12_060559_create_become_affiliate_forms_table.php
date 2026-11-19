<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('become_affiliate_forms', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('business_type')->nullable();
            $table->string('name');
            $table->string('job')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('countrycode')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('years_in_business')->nullable();
            $table->string('monthly_sales')->nullable();
            $table->json('business_types')->nullable();
            $table->string('sale_other_carriers')->nullable();
            $table->json('plan_to_sell')->nullable();
            $table->string('bank_transfer')->nullable();
            $table->string('billing_contact')->nullable();
            $table->string('billing_email')->nullable();
            $table->string('preferred_shipping_method')->nullable();
            $table->boolean('agree_eligibility')->default(false);
            $table->boolean('agree_terms')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('become_affiliate_forms');
    }
};
