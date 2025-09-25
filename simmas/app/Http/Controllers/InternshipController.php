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
        $this->middleware('role:admin,guru')->except(['show']);
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $internships = Internship::with(['dudi', 'student', 'teacher'])->latest()->get();
        return view('internships.index', compact('internships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dudis = Dudi::where('status', 'active')->get();
        $students = User::where('role', 'siswa')->get();
        $teachers = User::where('role', 'guru')->get();
        
        return view('internships.create', compact('dudis', 'students', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dudi_id' => 'required|exists:dudis,id',
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,active,completed,cancelled',
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
    public function edit(Internship $internship)
    {
        $dudis = Dudi::where('status', 'active')->get();
        $students = User::where('role', 'siswa')->get();
        $teachers = User::where('role', 'guru')->get();
        
        return view('internships.edit', compact('internship', 'dudis', 'students', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Internship $internship)
    {
        $request->validate([
            'dudi_id' => 'required|exists:dudis,id',
            'student_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,active,completed,cancelled',
        ]);

        $internship->update($request->all());

        return redirect()->route('internships.index')->with('success', 'Data magang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Internship $internship)
    {
        $internship->delete();
        return redirect()->route('internships.index')->with('success', 'Data magang berhasil dihapus');
    }
}
