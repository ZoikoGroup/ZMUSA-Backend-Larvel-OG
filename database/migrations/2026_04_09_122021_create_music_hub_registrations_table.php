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
    Schema::create('music_hub_registrations', function (Blueprint $table) {
        $table->id();
        $table->string('fname');
        $table->string('email');
        $table->string('countrycode')->nullable();
        $table->string('phone');
        $table->string('statusproof')->nullable();

        $table->string('desc')->nullable();

        $table->boolean('perks')->default(false);
        $table->boolean('discount')->default(false);
        $table->boolean('tools')->default(false);
        $table->boolean('storage')->default(false);
        $table->boolean('access')->default(false);

        $table->string('other')->nullable();
        $table->text('musicjourney')->nullable();

        $table->boolean('concent')->default(false);
        $table->boolean('terms')->default(false);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('music_hub_registrations');
    }
};
