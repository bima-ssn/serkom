<?php

namespace Tests\Feature;

use App\Models\Dudi;
use App\Models\Internship;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Carbon;

class JournalVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_sees_student_journals_in_index_even_with_capitalized_role(): void
    {
        // Create teacher with capitalized role
        $teacher = User::factory()->create([
            'role' => 'Guru',
            'name' => 'Guru Pembimbing',
            'email' => 'guru@example.test',
        ]);

        // Create student
        $student = User::factory()->create([
            'role' => 'siswa',
            'name' => 'Siswa Magang',
            'email' => 'siswa@example.test',
        ]);

        // Create DUDI
        $dudi = Dudi::create([
            'name' => 'PT Maju Jaya',
            'address' => 'Jl. Industri No. 1',
            'phone' => '08123456789',
            'email' => 'dudi@example.test',
            'pic_name' => 'Bapak PIC',
            'status' => 'Aktif',
        ]);

        // Create internship linking teacher and student
        $internship = Internship::create([
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'dudi_id' => $dudi->id,
            'status' => 'Aktif',
            'start_date' => now()->subDays(7)->toDateString(),
            'end_date' => now()->addDays(7)->toDateString(),
        ]);

        // Create journals for that internship
        $journal1 = Journal::create([
            'internship_id' => $internship->id,
            'date' => now()->toDateString(),
            'description' => 'Mengerjakan landing page dan memperbaiki bug UI.',
            'status' => 'Menunggu Verifikasi',
        ]);

        $journal2 = Journal::create([
            'internship_id' => $internship->id,
            'date' => now()->subDay()->toDateString(),
            'description' => 'Mempelajari API perusahaan dan membuat dokumentasi.',
            'status' => 'Disetujui',
        ]);

        // Act as the teacher and visit journals index
        $response = $this->actingAs($teacher)->get(route('journals.index'));

        $response->assertOk();
        // Should see student's name and both journal descriptions
        $response->assertSee('Siswa Magang');
        $response->assertSee('Mengerjakan landing page');
        $response->assertSee('Mempelajari API perusahaan');
    }
}
