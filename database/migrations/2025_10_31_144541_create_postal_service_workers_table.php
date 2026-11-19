<?php

// database/migrations/xxxx_xx_xx_create_postal_service_workers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('postal_service_workers', function (Blueprint $table) {
            $table->id();
            $table->json('data'); // store full form JSON data
            $table->string('file_path')->nullable(); // store uploaded file path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postal_service_workers');
    }
};
