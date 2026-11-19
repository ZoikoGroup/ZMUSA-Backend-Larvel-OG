<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('animal_worker_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('email');
            $table->string('countrycode')->nullable();
            $table->string('phone');
            $table->date('dob');
            $table->string('statusproof')->nullable(); // uploaded file
            $table->string('orgname');
            $table->string('jobtitle');
            $table->string('street');
            $table->string('apprt')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zipcode');
            $table->boolean('concent')->default(false);
            $table->boolean('terms')->default(false);
            $table->boolean('updates')->default(false);
            $table->json('family_members')->nullable(); // store up to 5 family/friend members
            $table->json('rawjson')->nullable(); // store full raw JSON
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animal_worker_registrations');
    }
};
