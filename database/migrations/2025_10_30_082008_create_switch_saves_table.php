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
    Schema::create('switch_saves', function (Blueprint $table) {
        $table->id();
        $table->string('fname');
        $table->string('email');
        $table->string('msisdn');
        $table->string('simno');
        $table->string('plan');
        $table->string('cat');
        $table->string('ospno');
        $table->string('osppass');
        $table->string('addr1');
        $table->string('addr2');
        $table->string('city');
        $table->string('state');
        $table->string('zip');
        $table->boolean('concent')->default(false);
        $table->boolean('terms')->default(false);
        $table->timestamps();
    });
}

};
