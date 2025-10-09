<?php

namespace App\Http\Controllers;

use App\Models\Dudi;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $user = $request->user();
        if ($user->role === 'siswa') {
            return redirect()->route('student.internship');
        }
        $search = $request->get('search');
        $status = $request->get('status'); // Pending|Aktif|Selesai|Ditolak
        $dudiId = $request->get('dudi_id');
        $perPage = (int) $request->integer('per_page', 10);
        $perPage = in_array($perPage, [5, 10, 25, 50]) ? $perPage : 10;

        $query = Internship::with(['dudi', 'student', 'teacher']);

        // Role scoping: siswa melihat miliknya; guru & admin melihat semua
        if ($user->role === 'siswa') {
            $query->where('student_id', $user->id);
        }

        if ($dudiId) {
            $query->where('dudi_id', $dudiId);
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('teacher', function ($q3) use ($search) {
                    $q3->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('dudi', function ($q4) use ($search) {
                    $q4->where('name', 'like', "%{$search}%");
                });
            });
        }

        $internships = $query->orderByDesc('created_at')->paginate($perPage)->withQueryString();
        
        // Build base query for counters (same scoping and filters except status and pagination)
        $counterBase = Internship::query();
        if ($user->role === 'siswa') {
            $counterBase->where('student_id', $user->id);
        }
        if ($dudiId) {
            $counterBase->where('dudi_id', $dudiId);
        }
        if ($search) {
            $counterBase->where(function ($q) use ($search) {
                $q->whereHas('student', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('teacher', function ($q3) use ($search) {
                    $q3->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('dudi', function ($q4) use ($search) {
                    $q4->where('name', 'like', "%{$search}%");
                });
            });
        }

        $totalCount = (clone $counterBase)->count();
        $aktifCount = (clone $counterBase)->where('status', 'Aktif')->count();
        $selesaiCount = (clone $counterBase)->where('status', 'Selesai')->count();
        $pendingCount = (clone $counterBase)->where('status', 'Pending')->count();

        return view('internships.index', [
            'internships' => $internships,
            'perPage' => $perPage,
            'totalCount' => $totalCount,
            'aktifCount' => $aktifCount,
            'selesaiCount' => $selesaiCount,
            'pendingCount' => $pendingCount,
        ]);
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
        return view('internships.pdf', $data + ['isFallback' => true]);
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

    /**
     * Show confirmation form to mark internship as finished and collect signatures.
     */
    public function confirmFinishForm(Request $request, Internship $internship)
    {
        if ($request->user()->role !== 'guru') {
            abort(403);
        }
        $internship->load(['dudi', 'student', 'teacher']);
        return view('internships.confirm-finish', compact('internship'));
    }

    /**
     * Store signatures, set status to Selesai, and persist certificate meta.
     */
    public function confirmFinishStore(Request $request, Internship $internship)
    {
        if ($request->user()->role !== 'guru') {
            abort(403);
        }

        $validated = $request->validate([
            'teacher_signature' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'dudi_signature' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'certificate_notes' => 'nullable|string|max:1000',
            'finished_at' => 'nullable|date',
        ]);

        // Store signatures in public storage
        $teacherSignaturePath = $request->file('teacher_signature')->store('signatures', 'public');
        $dudiSignaturePath = $request->file('dudi_signature')->store('signatures', 'public');

        // Update internship as finished and save meta to json column via description or new attributes if available
        $internship->status = 'Selesai';
        if (isset($validated['finished_at'])) {
            $internship->end_date = $validated['finished_at'];
        }

        // Persist certificate meta in description (if no dedicated column exists)
        $meta = [
            'certificate_notes' => $validated['certificate_notes'] ?? null,
            'teacher_signature_path' => $teacherSignaturePath,
            'dudi_signature_path' => $dudiSignaturePath,
        ];
        $currentDescription = (string)($internship->description ?? '');
        $metaBlock = "\n\n--- CERTIFICATE META ---\n" . json_encode($meta);
        $internship->description = trim($currentDescription . $metaBlock);

        $internship->save();

        return redirect()
            ->route('internships.certificate.download', $internship->id)
            ->with('success', 'Magang dikonfirmasi selesai. Sertifikat siap diunduh.');
    }

    /**
     * Download certificate PDF for finished internship.
     */
    public function downloadCertificate(Request $request, Internship $internship)
    {
        if ($request->user()->role !== 'guru') {
            abort(403);
        }

        $internship->load(['dudi', 'student', 'teacher']);

        // Extract meta from description if present
        $meta = [
            'teacher_signature_path' => null,
            'dudi_signature_path' => null,
            'certificate_notes' => null,
        ];
        if (!empty($internship->description) && ($pos = strrpos($internship->description, '--- CERTIFICATE META ---')) !== false) {
            $json = trim(substr($internship->description, $pos + strlen('--- CERTIFICATE META ---')));
            $decoded = json_decode($json, true);
            if (is_array($decoded)) {
                $meta = array_merge($meta, $decoded);
            }
        }

        $data = compact('internship', 'meta');

        try {
            if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
                $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('internships.certificate', $data)->setPaper('a4', 'portrait');
                $filename = 'sertifikat-magang-' . str($internship->student->name)->slug('-') . '-' . now()->format('Ymd_His') . '.pdf';
                return $pdf->download($filename);
            }
        } catch (\Throwable $e) {
            // Fallback to HTML view
        }

        return view('internships.certificate', $data + ['isFallback' => true]);
    }
}
