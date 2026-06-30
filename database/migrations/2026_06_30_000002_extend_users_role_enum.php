<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('customer','admin','owner','finance','it') NOT NULL DEFAULT 'customer'");
    }

    public function down(): void
    {
        // Revert to original two values — rows with other roles will be invalid; back this up first.
        DB::statement("UPDATE users SET role = 'customer' WHERE role NOT IN ('customer','admin')");
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('customer','admin') NOT NULL DEFAULT 'customer'");
    }
};
