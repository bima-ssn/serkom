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
    public function index()
    {
        $user = auth()->user();
        $journals = [];

        if ($user->role === 'admin' || $user->role === 'guru') {
            if ($user->role === 'guru') {
                $journals = Journal::whereHas('internship', function($q) use ($user) {
                        $q->where('teacher_id', $user->id);
                    })
                    ->with('internship')
                    ->latest()
                    ->paginate(10);
            } else {
                $journals = Journal::with('internship')->latest()->paginate(10);
            }
        } else {
            $internships = Internship::where('student_id', $user->id)->pluck('id');
            $journals = Journal::whereIn('internship_id', $internships)->with('internship')->latest()->paginate(10);
        }

        return view('journals.index', compact('journals'));
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
