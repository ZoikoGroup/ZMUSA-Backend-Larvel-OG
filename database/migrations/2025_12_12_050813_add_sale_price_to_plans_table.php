<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->decimal('sale_price', 10, 2)
                  ->nullable()
                  ->after('price');
        });

        // Fill sale_price = 60% of price (40% discount)
        DB::statement('UPDATE plans SET sale_price = price * 0.60');
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('sale_price');
        });
    }
};
