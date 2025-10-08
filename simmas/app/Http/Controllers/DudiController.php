<?php

namespace App\Http\Controllers;

use App\Models\Dudi;
use App\Models\Internship;
use App\Models\User;
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

        if ($user->role === 'admin' && $request->boolean('with_trashed')) {
            $query->withTrashed();
        }

        // Per-page options: siswa view uses 6/9/12/18; admin/guru uses 5/10/25/50
        if ($user->role === 'siswa') {
            $perPage = (int) $request->input('per_page', 6);
            $allowed = [6, 9, 12, 18];
            $perPage = in_array($perPage, $allowed) ? $perPage : 6;
        } else {
            $perPage = (int) $request->input('per_page', 10);
            $allowed = [5, 10, 25, 50];
            $perPage = in_array($perPage, $allowed) ? $perPage : 10;
        }

        $stats = null;
        if ($user->role === 'admin') {
            $stats = [
                'total' => Dudi::count(),
                'active' => Dudi::where('status', 'Aktif')->count(),
                'pending' => Dudi::where('status', 'Pending')->count(),
                'inactive' => Dudi::where('status', 'Tidak Aktif')->count(),
                'totalStudents' => Internship::whereIn('status', ['active','Aktif'])->count(),
            ];
        }

        $dudis = $query->orderBy('name')->paginate($perPage)->withQueryString();

        $totalSiswaMagang = Internship::whereIn('status', ['active', 'Aktif'])->count();

        return view('dudis.index', compact('dudis', 'stats', 'perPage', 'totalSiswaMagang'));
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
            'status' => 'required|in:Pending,Aktif,Tidak Aktif',
            'student_quota' => 'required|integer|min:1',
            'category' => 'required|string|max:100',
            'teacher_id' => 'nullable|exists:users,id',
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
            'status' => 'required|in:Pending,Aktif,Tidak Aktif',
            'student_quota' => 'required|integer|min:1',
            'category' => 'required|string|max:100',
            'teacher_id' => 'nullable|exists:users,id',
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

    /**
     * Allow student to apply to a DUDI with max 3 active/pending applications.
     */
    public function apply(Request $request, Dudi $dudi)
    {
        $user = $request->user();
        if ($user->role !== 'siswa') {
            abort(403);
        }

        if (!in_array($dudi->status, ['Aktif', 'Pending'])) {
            return back()->with('success', 'DUDI tidak aktif. Pendaftaran tidak dapat dilakukan.');
        }

        // Prevent duplicate application to the same DUDI with non-finalized status
        $duplicate = Internship::where('student_id', $user->id)
            ->where('dudi_id', $dudi->id)
            ->whereIn('status', ['Pending', 'Aktif', 'proses', 'process'])
            ->exists();
        if ($duplicate) {
            return back()->with('success', 'Anda sudah mendaftar ke DUDI ini.');
        }

        // Enforce max 3 applications that are not final (Pending/Aktif/Proses)
        $activeCount = Internship::where('student_id', $user->id)
            ->whereIn('status', ['Pending', 'Aktif', 'proses', 'process'])
            ->count();
        if ($activeCount >= 3) {
            return back()->with('success', 'Batas pendaftaran 3 DUDI telah tercapai.');
        }

        // Auto-assign any available teacher (first guru) if exists
        $teacherId = User::where('role', 'guru')->value('id');

        Internship::create([
            'student_id' => $user->id,
            'teacher_id' => $teacherId, // may be null if no teacher exists
            'dudi_id' => $dudi->id,
            'status' => 'Pending',
        ]);

        return back()->with('success', 'Pendaftaran magang berhasil diajukan, menunggu verivikasi dari pihak guru');
    }

    private function authorizeAdmin(Request $request): void
    {
        if ($request->user()->role !== 'admin') {
            abort(403);
        }
    }
}
