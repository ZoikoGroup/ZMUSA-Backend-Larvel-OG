<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stripe_hooks', function (Blueprint $table) {
            $table->id();

            $table->string('event_id')->unique();
            $table->string('event_type');

            $table->string('payment_intent_id')->nullable();
            $table->string('charge_id')->nullable();
            $table->string('customer_id')->nullable();

            $table->string('status')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('amount', 10, 2)->nullable();

            $table->json('payment_method_details')->nullable();
            $table->json('billing_details')->nullable();

            $table->json('raw_payload');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stripe_hooks');
    }
};
