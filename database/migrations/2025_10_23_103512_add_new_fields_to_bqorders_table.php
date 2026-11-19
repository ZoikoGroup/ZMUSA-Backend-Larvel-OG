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
        Schema::table('bqorders', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_method_id')->nullable()->after('payment_type_id');
            $table->unsignedBigInteger('address_id')->nullable()->after('subscriber_id');
            $table->json('address_attributes')->nullable()->after('address_id');
            $table->unsignedBigInteger('service_address_id')->nullable()->after('address_attributes');
            $table->unsignedBigInteger('shipping_address_id')->nullable()->after('service_address_id');
            $table->unsignedBigInteger('line_id')->nullable()->after('shipping_address_id');
            $table->unsignedBigInteger('bequick_order_id')->nullable()->after('line_id');
            $table->decimal('bequick_order_amount', 10, 2)->nullable()->after('bequick_order_id');
            $table->json('card_details')->nullable()->after('card_address');
            $table->string('coupon')->nullable()->after('totals');
            $table->longText('raw_data')->nullable()->after('totals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bqorders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method_id',
                'address_id',
                'address_attributes',
                'service_address_id',
                'shipping_address_id',
                'line_id',
                'bequick_order_id',
                'bequick_order_amount',
                'card_details',
                'coupon',
                'raw_data',
            ]);
        });
    }
};
