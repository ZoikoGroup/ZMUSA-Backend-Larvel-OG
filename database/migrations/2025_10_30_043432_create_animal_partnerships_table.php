<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('animal_partnerships', function (Blueprint $table) {
            $table->id();
            $table->string('orgname');
            $table->string('orgtype');
            $table->string('focus');
            $table->string('website');
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('zipcode');
            $table->text('mission');
            $table->string('name');
            $table->string('role');
            $table->string('email');
            $table->string('countrycode')->nullable();
            $table->string('phone');
            $table->string('prefcontact')->nullable();
            $table->boolean('discount')->default(false);
            $table->boolean('support')->default(false);
            $table->boolean('campaign')->default(false);
            $table->boolean('donation')->default(false);
            $table->boolean('volunteer')->default(false);
            $table->string('other')->nullable();
            $table->text('supportmission')->nullable();
            $table->string('statusproof')->nullable(); // file upload path
            $table->boolean('concent')->default(false);
            $table->boolean('terms')->default(false);
            $table->boolean('updates')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_partnerships');
    }
};
