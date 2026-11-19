<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bqorders', function (Blueprint $table) {
            $table->id();
            $table->json('billing_address')->nullable();
            $table->json('shipping_address')->nullable();
            $table->json('card_address')->nullable();
            $table->json('cart')->nullable();
            $table->json('totals')->nullable();
            $table->boolean('agreed_to_terms')->default(false);
            $table->foreignId('payment_type_id')->nullable();
            $table->foreignId('subscriber_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bqorders');
    }
};
