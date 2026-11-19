<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change int(11) → varchar(255)
        Schema::table('plans', function (Blueprint $table) {
            $table->string('duration_value', 255)
                ->nullable()
                ->comment('Comma-separated number of units for duration_type')
                ->change();
        });
    }

    public function down(): void
    {
        // Revert back to int(11)
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('duration_value')
                ->nullable()
                ->comment('Number of units for the selected duration_type')
                ->change();
        });
    }
};
