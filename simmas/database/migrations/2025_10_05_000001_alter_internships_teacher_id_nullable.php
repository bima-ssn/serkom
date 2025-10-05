<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            // SQLite doesn't support altering columns easily; rebuild the table
            Schema::create('internships_temp', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->foreignId('dudi_id')->constrained('dudis')->onDelete('cascade');
                $table->enum('status', ['Pending', 'Aktif', 'Selesai', 'Ditolak'])->default('Pending');
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->decimal('final_score', 5, 2)->nullable();
                $table->timestamps();
            });

            DB::statement('INSERT INTO internships_temp (id, student_id, teacher_id, dudi_id, status, start_date, end_date, final_score, created_at, updated_at)
                           SELECT id, student_id, teacher_id, dudi_id, status, start_date, end_date, final_score, created_at, updated_at FROM internships');

            Schema::drop('internships');
            Schema::rename('internships_temp', 'internships');
        } else {
            // Drop FK, alter nullability, re-add FK for teacher_id
            Schema::table('internships', function (Blueprint $table) {
                $table->dropForeign(['teacher_id']);
            });

            Schema::table('internships', function (Blueprint $table) {
                $table->unsignedBigInteger('teacher_id')->nullable()->change();
            });

            Schema::table('internships', function (Blueprint $table) {
                $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            // Rebuild back to NOT NULL teacher_id
            Schema::create('internships_temp', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('dudi_id')->constrained('dudis')->onDelete('cascade');
                $table->enum('status', ['Pending', 'Aktif', 'Selesai', 'Ditolak'])->default('Pending');
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->decimal('final_score', 5, 2)->nullable();
                $table->timestamps();
            });

            // Rows with NULL teacher_id will fail; filter them out
            DB::statement('INSERT INTO internships_temp (id, student_id, teacher_id, dudi_id, status, start_date, end_date, final_score, created_at, updated_at)
                           SELECT id, student_id, COALESCE(teacher_id, 1), dudi_id, status, start_date, end_date, final_score, created_at, updated_at FROM internships WHERE teacher_id IS NOT NULL');

            Schema::drop('internships');
            Schema::rename('internships_temp', 'internships');
        } else {
            Schema::table('internships', function (Blueprint $table) {
                $table->dropForeign(['teacher_id']);
            });

            Schema::table('internships', function (Blueprint $table) {
                $table->unsignedBigInteger('teacher_id')->nullable(false)->change();
            });

            Schema::table('internships', function (Blueprint $table) {
                $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }
};
