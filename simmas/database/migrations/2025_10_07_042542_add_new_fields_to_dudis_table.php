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
        Schema::table('dudis', function (Blueprint $table) {
            $table->integer('student_quota')->default(10)->after('status');
            $table->string('category')->nullable()->after('student_quota');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->after('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dudis', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn(['student_quota', 'category', 'teacher_id']);
        });
    }
};
