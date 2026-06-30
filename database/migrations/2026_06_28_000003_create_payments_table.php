<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // The base payments table was created in 2020_09_21_140407.
        // This migration adds the fields needed for France Vacances booking payments.
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id')->nullable()->after('id');
            $table->string('reference', 30)->nullable()->unique()->after('currency');
            $table->string('method', 30)->default('card')->after('reference');
            $table->string('status', 20)->default('completed')->after('method');
            $table->boolean('is_simulated')->default(true)->after('status');

            $table->foreign('booking_id')
                  ->references('id')
                  ->on('bookings')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['booking_id']);
            $table->dropColumn(['booking_id', 'reference', 'method', 'status', 'is_simulated']);
        });
    }
};
