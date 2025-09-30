<?php

namespace App\Http\Controllers;

use App\Models\Dudi;
use App\Models\Internship;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view with role-specific data.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();

        $data = [
            'todayDateFormatted' => $today->format('d F Y'),
            'role' => $user->role,
        ];

        if ($user->isAdmin()) {
            $data['adminStats'] = [
                'totalStudents' => User::where('role', 'siswa')->count(),
                'totalDudis' => Dudi::count(),
                'activeInternships' => Internship::whereIn('status', ['active', 'Aktif'])->count(),
                'journalsToday' => Journal::whereDate('date', $today)->count(),
            ];

            $data['latestInternships'] = Internship::with(['student', 'teacher', 'dudi'])
                ->latest()
                ->take(5)
                ->get();

            $data['latestJournals'] = Journal::with(['internship.student', 'internship.dudi'])
                ->latest()
                ->take(5)
                ->get();

            $data['activeDudisWithCounts'] = Dudi::where('status', 'Aktif')
                ->withCount([
                    'internships as active_internships_count' => function ($q) {
                        $q->where('status', 'active');
                    },
                ])
                ->orderByDesc('active_internships_count')
                ->take(5)
                ->get();
        } elseif ($user->isTeacher()) {
            $teacherId = $user->id;

            $data['mentorStats'] = [
                'totalMentees' => Internship::where('teacher_id', $teacherId)
                    ->distinct('student_id')
                    ->count('student_id'),
                'relatedDudiCount' => Dudi::whereIn('id', Internship::where('teacher_id', $teacherId)->pluck('dudi_id'))
                    ->distinct()
                    ->count('id'),
                'activeMentorInternships' => Internship::where('teacher_id', $teacherId)
                    ->whereIn('status', ['active', 'Aktif'])
                    ->count(),
                'journalsTodayMentor' => Journal::whereHas('internship', function ($q) use ($teacherId) {
                        $q->where('teacher_id', $teacherId);
                    })
                    ->whereDate('date', $today)
                    ->count(),
            ];

            $data['latestMentorInternships'] = Internship::with(['student', 'dudi'])
                ->where('teacher_id', $teacherId)
                ->latest()
                ->take(5)
                ->get();

            $data['latestMentorJournals'] = Journal::whereHas('internship', function ($q) use ($teacherId) {
                    $q->where('teacher_id', $teacherId);
                })
                ->with(['internship.student', 'internship.dudi'])
                ->latest()
                ->take(5)
                ->get();

            $data['mentorActiveDudisWithCounts'] = Dudi::where('status', 'Aktif')
                ->whereIn('id', Internship::where('teacher_id', $teacherId)->pluck('dudi_id'))
                ->withCount([
                    'internships as active_internships_count' => function ($q) use ($teacherId) {
                        $q->where('teacher_id', $teacherId)->where('status', 'active');
                    },
                ])
                ->orderByDesc('active_internships_count')
                ->take(5)
                ->get();
        } elseif ($user->isStudent()) {
            $studentInternship = Internship::with(['dudi', 'teacher'])
                ->where('student_id', $user->id)
                ->latest()
                ->first();

            $progressPercent = null;
            if ($studentInternship && $studentInternship->start_date && $studentInternship->end_date) {
                $start = Carbon::parse($studentInternship->start_date);
                $end = Carbon::parse($studentInternship->end_date);
                $totalDays = max(1, $start->diffInDays($end) + 1);
                if ($today->lt($start)) {
                    $elapsed = 0;
                } elseif ($today->gt($end)) {
                    $elapsed = $totalDays;
                } else {
                    $elapsed = $start->diffInDays($today) + 1;
                }
                $progressPercent = (int) round(($elapsed / $totalDays) * 100);
            }

            $data['studentInternship'] = $studentInternship;
            $data['studentProgressPercent'] = $progressPercent;
            $data['hasJournalToday'] = Journal::whereHas('internship', function ($q) use ($user) {
                    $q->where('student_id', $user->id);
                })
                ->whereDate('date', $today)
                ->exists();
        }

        return view('dashboard', $data);
    }
}

