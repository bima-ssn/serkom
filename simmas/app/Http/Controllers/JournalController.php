<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JournalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $perPage = (int) $request->integer('per_page', 10);
        $status = $request->get('status'); // Disetujui | Ditolak | Menunggu Verifikasi
        $month = $request->integer('month');
        $year = $request->integer('year');
        $date = $request->get('date'); // YYYY-MM-DD
        $search = $request->get('search');

        // Base query depends on role
        if ($user->role === 'admin') {
            $baseQuery = Journal::query();
        } elseif ($user->role === 'guru') {
            // Use explicit JOIN to reliably scope journals by mentor (teacher)
            $baseQuery = Journal::query()
                ->join('internships', 'internships.id', '=', 'journals.internship_id')
                ->where('internships.teacher_id', $user->id)
                ->select('journals.*');
        } else { // siswa
            $internshipIds = Internship::where('student_id', $user->id)->pluck('id');
            $baseQuery = Journal::whereIn('internship_id', $internshipIds);
        }

        // Counters for stat cards (without filters)
        $totalCount = (clone $baseQuery)->count();
        $pendingCount = (clone $baseQuery)->where('journals.status', 'Menunggu Verifikasi')->count();
        $approvedCount = (clone $baseQuery)->where('journals.status', 'Disetujui')->count();
        $rejectedCount = (clone $baseQuery)->where('journals.status', 'Ditolak')->count();

        // Apply filters to listing query
        $query = (clone $baseQuery)
            ->with(['internship.student', 'internship.teacher', 'internship.dudi']);

        if ($status) {
            $query->where('journals.status', $status);
        }
        if ($month) {
            $query->whereMonth('journals.date', $month);
        }
        if ($year) {
            $query->whereYear('journals.date', $year);
        }
        if ($date) {
            $query->whereDate('journals.date', $date);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('journals.description', 'like', "%{$search}%")
                  ->orWhere('journals.teacher_notes', 'like', "%{$search}%")
                  ->orWhereHas('internship.student', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('internship.dudi', function ($q3) use ($search) {
                      $q3->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $journals = $query
            ->orderByDesc('journals.date')
            ->orderByDesc('journals.created_at')
            ->paginate($perPage)
            ->withQueryString();

        // Student reminder if no journal created today
        $showReminder = false;
        if ($user->role === 'siswa') {
            $hasTodayJournal = (clone $baseQuery)->whereDate('journals.date', now()->toDateString())->exists();
            $showReminder = !$hasTodayJournal;
        }

        return view('journals.index', [
            'journals' => $journals,
            'totalCount' => $totalCount,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'perPage' => $perPage,
            'filters' => [
                'status' => $status,
                'month' => $month,
                'year' => $year,
                'date' => $date,
                'search' => $search,
            ],
            'showReminder' => $showReminder,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $internships = [];

        if ($user->role === 'admin') {
            $internships = Internship::with(['student', 'dudi'])->get();
        } else if ($user->role === 'guru') {
            $internships = Internship::where('teacher_id', $user->id)
                ->with(['student', 'dudi'])
                ->get();
        } else {
            $internships = Internship::where('student_id', $user->id)
                ->whereIn('status', ['active','Aktif'])
                ->with(['student', 'dudi'])
                ->get();
        }

        return view('journals.create', compact('internships'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'date' => 'required|date',
            'description' => 'required|string',
            'documentation' => 'nullable|image|max:2048',
        ]);

        $journal = new Journal();
        $journal->internship_id = $request->internship_id;
        $journal->date = $request->date;
        $journal->description = $request->description;
        $journal->status = 'Menunggu Verifikasi';

        if ($request->hasFile('documentation')) {
            $path = $request->file('documentation')->store('journal_documentations', 'public');
            $journal->documentation_path = $path;
        }

        $journal->save();

        return redirect()->route('journals.index')->with('success', 'Jurnal berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $journal = Journal::with('internship.student', 'internship.teacher', 'internship.dudi')->findOrFail($id);
        return view('journals.show', compact('journal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $journal = Journal::findOrFail($id);
        $internships = Internship::with(['student', 'dudi'])->get();
        
        return view('journals.edit', compact('journal', 'internships'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'date' => 'required|date',
            'description' => 'required|string',
            'documentation' => 'nullable|image|max:2048',
        ]);

        $journal = Journal::findOrFail($id);
        $journal->internship_id = $request->internship_id;
        $journal->date = $request->date;
        $journal->description = $request->description;
        
        if ($request->has('status')) {
            $journal->status = $request->status;
        }
        
        if ($request->has('teacher_notes')) {
            $journal->teacher_notes = $request->teacher_notes;
        }

        if ($request->hasFile('documentation')) {
            // Hapus file lama jika ada
            if ($journal->documentation_path) {
                Storage::disk('public')->delete($journal->documentation_path);
            }
            
            $path = $request->file('documentation')->store('journal_documentations', 'public');
            $journal->documentation_path = $path;
        }

        $journal->save();

        return redirect()->route('journals.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $journal = Journal::findOrFail($id);
        
        // Hapus file dokumentasi jika ada
        if ($journal->documentation_path) {
            Storage::disk('public')->delete($journal->documentation_path);
        }
        
        $journal->delete();

        return redirect()->route('journals.index')->with('success', 'Jurnal berhasil dihapus.');
    }
    
    /**
     * Verify journal by teacher.
     */
    public function verify(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak',
            'teacher_notes' => 'nullable|string',
        ]);

        $journal = Journal::findOrFail($id);
        $journal->status = $request->status;
        $journal->teacher_notes = $request->teacher_notes;
        $journal->save();

        return redirect()->route('journals.show', $journal->id)->with('success', 'Status jurnal berhasil diperbarui.');
    }
}
