<?php

namespace App\Http\Controllers;

use App\Models\Dudi;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;

class InternshipController extends Controller
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
        $query = Internship::with(['dudi', 'student', 'teacher'])->latest();
        if ($dudiId = $request->input('dudi_id')) {
            $query->where('dudi_id', $dudiId);
        }
        $internships = $query->get();
        return view('internships.index', compact('internships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->user()->role !== 'guru') {
            abort(403);
        }
        $dudis = Dudi::whereIn('status', ['Aktif', 'Pending'])->get();
        $students = User::where('role', 'siswa')->get();
        $teachers = User::where('role', 'guru')->get();
        
        return view('internships.create', compact('dudis', 'students', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->user()->role !== 'guru') {
            abort(403);
        }
        $request->validate([
            'dudi_id' => 'required|exists:dudis,id',
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,Aktif,Selesai,Ditolak',
        ]);

        Internship::create($request->all());

        return redirect()->route('internships.index')->with('success', 'Data magang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Internship $internship)
    {
        $internship->load(['dudi', 'student', 'teacher', 'journals']);
        return view('internships.show', compact('internship'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Internship $internship)
    {
        if ($request->user()->role !== 'guru') {
            abort(403);
        }
        $dudis = Dudi::whereIn('status', ['Aktif', 'Pending'])->get();
        $students = User::where('role', 'siswa')->get();
        $teachers = User::where('role', 'guru')->get();
        
        return view('internships.edit', compact('internship', 'dudis', 'students', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Internship $internship)
    {
        if ($request->user()->role !== 'guru') {
            abort(403);
        }
        $validated = $request->validate([
            'dudi_id' => 'required|exists:dudis,id',
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,Aktif,Selesai,Ditolak',
            'final_score' => 'nullable|numeric|min:0|max:100',
        ]);

        // Only allow setting final_score when status is 'Selesai'
        if (($validated['status'] ?? $internship->status) !== 'Selesai') {
            $validated['final_score'] = null;
        }

        $internship->update($validated);

        return redirect()->route('internships.index')->with('success', 'Data magang berhasil diperbarui');
    }

    /**
     * Display student's internship data.
     */
    public function studentInternship(Request $request)
    {
        if ($request->user()->role !== 'siswa') {
            abort(403);
        }
        
        $user = $request->user();
        $internship = Internship::with(['dudi', 'teacher'])
            ->where('student_id', $user->id)
            ->latest()
            ->first();
            
        return view('internships.student', compact('internship'));
    }

    /**
     * Export internships list to PDF for teacher (guru).
     */
    public function exportPdf(Request $request)
    {
        if ($request->user()->role !== 'guru') {
            abort(403);
        }

        $internships = Internship::with(['dudi', 'student', 'teacher'])
            ->latest()
            ->get();

        $data = [
            'internships' => $internships,
        ];

        try {
            if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('internships.pdf', $data)->setPaper('a4', 'portrait');
                $filename = 'siswa-magang-' . now()->format('Ymd_His') . '.pdf';
                return $pdf->download($filename);
            }
        } catch (\Throwable $e) {
            // Fallback to HTML view below if PDF library is not installed or fails.
        }

        // Fallback: render printable HTML (user can use browser print to save as PDF)
        return view('internships.pdf', $data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Internship $internship)
    {
        if ($request->user()->role !== 'guru') {
            abort(403);
        }
        $internship->delete();
        return redirect()->route('internships.index')->with('success', 'Data magang berhasil dihapus');
    }
}
