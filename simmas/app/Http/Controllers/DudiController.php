<?php

namespace App\Http\Controllers;

use App\Models\Dudi;
use App\Models\Internship;
use Illuminate\Http\Request;

class DudiController extends Controller
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

        $query = Dudi::query()->withCount([
            'internships as students_count' => function ($q) {
                $q->whereIn('status', ['active', 'Aktif']);
            },
        ]);

        // Show all DUDI to all roles on listing; editing is still admin-only

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('pic_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Students should see only active DUDI by default
        if ($user->role === 'siswa' && !$request->has('status')) {
            $query->where('status', 'Aktif');
        }

        if ($user->role === 'admin' && $request->boolean('with_trashed')) {
            $query->withTrashed();
        }

        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [5, 10, 25, 50]) ? $perPage : 10;

        $stats = null;
        if ($user->role === 'admin') {
            $stats = [
                'total' => Dudi::count(),
                'active' => Dudi::where('status', 'Aktif')->count(),
                'inactive' => Dudi::where('status', 'Tidak Aktif')->count(),
                'totalStudents' => Internship::whereIn('status', ['active','Aktif'])->count(),
            ];
        }

        $dudis = $query->orderBy('name')->paginate($perPage)->withQueryString();

        $totalSiswaMagang = Internship::whereIn('status', ['active', 'Aktif'])->count();

        $studentPendingCount = 0;
        $studentApplicationsByDudi = collect();
        if ($user->role === 'siswa') {
            $applications = Internship::where('student_id', $user->id)
                ->whereIn('status', ['Pending', 'Aktif'])
                ->get(['dudi_id', 'status']);
            $studentPendingCount = $applications->where('status', 'Pending')->count();
            $studentApplicationsByDudi = $applications->keyBy('dudi_id');
        }

        return view('dudis.index', compact(
            'dudis',
            'stats',
            'perPage',
            'totalSiswaMagang',
            'studentPendingCount',
            'studentApplicationsByDudi'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorizeAdmin($request);
        return view('dudis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin($request);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:dudis,name',
            'address' => 'required|string',
            'phone' => ['required','string','max:20','regex:/^[\d\-\+]+$/'],
            'email' => 'required|email|max:255|unique:dudis,email',
            'pic_name' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        Dudi::create($validated);

        return redirect()->route('dudis.index')
            ->with('success', 'DUDI berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dudi $dudi)
    {
        return view('dudis.show', compact('dudi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dudi $dudi, Request $request)
    {
        $this->authorizeAdmin($request);
        return view('dudis.edit', compact('dudi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dudi $dudi)
    {
        $this->authorizeAdmin($request);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:dudis,name,' . $dudi->id,
            'address' => 'required|string',
            'phone' => ['required','string','max:20','regex:/^[\d\-\+]+$/'],
            'email' => 'required|email|max:255|unique:dudis,email,' . $dudi->id,
            'pic_name' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $dudi->update($validated);

        return redirect()->route('dudis.index')
            ->with('success', 'DUDI berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dudi $dudi, Request $request)
    {
        $this->authorizeAdmin($request);
        $dudi->delete();

        return redirect()->route('dudis.index')
            ->with('success', 'DUDI berhasil dihapus.');
    }

    public function restore(Request $request, $id)
    {
        $this->authorizeAdmin($request);
        $dudi = Dudi::withTrashed()->findOrFail($id);
        $dudi->restore();
        return redirect()->route('dudis.index')->with('success', 'DUDI berhasil dipulihkan.');
    }

    private function authorizeAdmin(Request $request): void
    {
        if ($request->user()->role !== 'admin') {
            abort(403);
        }
    }

    /**
     * Allow student to apply to a DUDI (max 3 pending).
     */
    public function apply(Request $request, Dudi $dudi)
    {
        $user = $request->user();
        if ($user->role !== 'siswa') {
            abort(403);
        }

        if ($dudi->status !== 'Aktif') {
            return back()->with('success', 'Perusahaan tidak aktif untuk pendaftaran.');
        }

        $existingForCompany = Internship::where('student_id', $user->id)
            ->where('dudi_id', $dudi->id)
            ->whereIn('status', ['Pending', 'Aktif'])
            ->exists();
        if ($existingForCompany) {
            return back()->with('success', 'Anda sudah mendaftar atau sedang aktif di perusahaan ini.');
        }

        $pendingCount = Internship::where('student_id', $user->id)
            ->where('status', 'Pending')
            ->count();
        if ($pendingCount >= 3) {
            return back()->with('success', 'Batas maksimum 3 pendaftaran tercapai. Batalkan salah satu pengajuan untuk melanjutkan.');
        }

        Internship::create([
            'student_id' => $user->id,
            'teacher_id' => null,
            'dudi_id' => $dudi->id,
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Pendaftaran magang berhasil diajukan, menunggu verivikasi dari pihak guru');
    }
}
