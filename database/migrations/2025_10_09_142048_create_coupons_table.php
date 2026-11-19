<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('limit')->nullable()->comment('Total usage limit');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->enum('type', ['flat', 'percentage'])->default('flat');
            $table->json('related_product')->nullable()->comment('Array of product IDs');
            $table->json('related_plan')->nullable()->comment('Array of plan IDs');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
