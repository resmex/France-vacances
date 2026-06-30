<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add check-in / check-out dates to bookings for self-catering rental logic
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('check_in_date')->nullable()->after('travel_date');
            $table->date('check_out_date')->nullable()->after('check_in_date');
            $table->integer('nights')->nullable()->after('check_out_date');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['check_in_date', 'check_out_date', 'nights']);
        });
    }
};
