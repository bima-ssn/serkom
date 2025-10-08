<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update ENUM to include 'Pending'
        DB::statement("ALTER TABLE `dudis` MODIFY `status` ENUM('Aktif','Tidak Aktif','Pending') NOT NULL DEFAULT 'Aktif'");
    }

    public function down(): void
    {
        // Revert ENUM to original values (may fail if rows still have 'Pending')
        DB::statement("ALTER TABLE `dudis` MODIFY `status` ENUM('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif'");
    }
};

