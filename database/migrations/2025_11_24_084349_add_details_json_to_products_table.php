<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsJsonToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Basic metadata
            $table->string('model_number')->nullable()->after('slug');
            $table->string('network')->nullable()->after('model_number');
            $table->string('sku')->nullable()->after('network');
            $table->boolean('in_stock')->default(true)->after('featured');

            // Technical details stored as JSON
            $table->json('technical_specs')->nullable()->after('variants');
            $table->json('perks')->nullable()->after('technical_specs');
            $table->json('faqs')->nullable()->after('perks');
            $table->json('whats_included')->nullable()->after('faqs');

            // Multiple images stored as JSON array of paths
            $table->json('images')->nullable()->after('image_url');

            // Optional extra fields appearing on the WP page
            $table->string('warranty')->nullable()->after('in_stock'); // eg "6 months refurbisher warranty"
            $table->string('condition_label')->nullable()->after('warranty');
            $table->json('related_products')->nullable()->after('whats_included');

            // Ensure existing timestamp columns remain
            // (no change to created_at / updated_at)
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'model_number', 'network', 'sku', 'in_stock',
                'technical_specs', 'perks', 'faqs', 'whats_included',
                'images', 'warranty', 'condition_label'
            ]);
        });
    }
}
