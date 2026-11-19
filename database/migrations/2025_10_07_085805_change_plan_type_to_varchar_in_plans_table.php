<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->string('plan_type', 255)
                ->nullable()
                ->comment('Plan type stored as text')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('plan_type')
                ->nullable()
                ->comment('Plan type stored as integer')
                ->change();
        });
    }
};
