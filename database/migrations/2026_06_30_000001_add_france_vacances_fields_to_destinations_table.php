<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('property_type', 50)->nullable()->after('tour_type');
            $table->string('location', 100)->nullable()->after('property_type');
            $table->string('region', 50)->nullable()->after('location');
            $table->unsignedTinyInteger('bedrooms')->nullable()->default(1)->after('region');
            $table->unsignedTinyInteger('bathrooms')->nullable()->default(1)->after('bedrooms');
            $table->unsignedTinyInteger('max_guests')->nullable()->default(2)->after('bathrooms');
            $table->json('amenities')->nullable()->after('max_guests');
            $table->boolean('featured')->default(false)->after('amenities');
            $table->decimal('price_per_night', 10, 2)->nullable()->after('featured');
            $table->decimal('rating_cached', 3, 2)->nullable()->after('price_per_night');
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn([
                'property_type', 'location', 'region',
                'bedrooms', 'bathrooms', 'max_guests',
                'amenities', 'featured', 'price_per_night', 'rating_cached',
            ]);
        });
    }
};
