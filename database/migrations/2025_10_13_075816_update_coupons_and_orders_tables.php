<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add used_count to coupons
        Schema::table('coupons', function (Blueprint $table) {
            if (!Schema::hasColumn('coupons', 'used_count')) {
                $table->unsignedInteger('used_count')->default(0)->after('limit');
            }

            // ⚠️ Skip adding unique slug if it already exists
            // $table->unique('slug'); // Remove this line
        });

        // Add discount, total_after_discount, coupon_code to orders
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0)->after('total');
            }
            if (!Schema::hasColumn('orders', 'total_after_discount')) {
                $table->decimal('total_after_discount', 10, 2)->nullable()->after('discount');
            }
            if (!Schema::hasColumn('orders', 'coupon_code')) {
                $table->string('coupon_code', 255)->nullable()->after('total_after_discount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (Schema::hasColumn('coupons', 'used_count')) {
                $table->dropColumn('used_count');
            }

            // ⚠️ Skip dropping unique slug to avoid errors
            // $table->dropUnique(['slug']); 
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['discount', 'total_after_discount', 'coupon_code']);
        });
    }
};
