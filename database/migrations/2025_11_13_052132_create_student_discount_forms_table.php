<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_discount_forms', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('email');
            $table->string('countrycode')->nullable();
            $table->string('phone');
            $table->string('statusproof')->nullable(); // uploaded file path
            $table->string('school');
            $table->date('yos');
            $table->string('keepnumber');
            $table->string('plan');
            $table->string('cat');
            $table->boolean('concent')->default(false);
            $table->boolean('terms')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_discount_forms');
    }
};
