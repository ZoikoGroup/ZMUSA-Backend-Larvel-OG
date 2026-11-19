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
        Schema::table('become_affiliate_forms', function (Blueprint $table) {
            // Add the new column after 'monthly_sales' if it exists
            if (!Schema::hasColumn('become_affiliate_forms', 'estimated_monthly_purchase')) {
                $table->string('estimated_monthly_purchase', 255)
                      ->nullable()
                      ->after('monthly_sales');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('become_affiliate_forms', function (Blueprint $table) {
            if (Schema::hasColumn('become_affiliate_forms', 'estimated_monthly_purchase')) {
                $table->dropColumn('estimated_monthly_purchase');
            }
        });
    }
};
