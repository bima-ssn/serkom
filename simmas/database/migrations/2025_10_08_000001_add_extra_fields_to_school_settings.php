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
        Schema::table('school_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('school_settings', 'website')) {
                $table->string('website')->nullable()->after('email');
            }
            if (!Schema::hasColumn('school_settings', 'principal_name')) {
                $table->string('principal_name')->nullable()->after('website');
            }
            if (!Schema::hasColumn('school_settings', 'npsn')) {
                $table->string('npsn')->nullable()->after('principal_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_settings', function (Blueprint $table) {
            if (Schema::hasColumn('school_settings', 'npsn')) {
                $table->dropColumn('npsn');
            }
            if (Schema::hasColumn('school_settings', 'principal_name')) {
                $table->dropColumn('principal_name');
            }
            if (Schema::hasColumn('school_settings', 'website')) {
                $table->dropColumn('website');
            }
        });
    }
};

