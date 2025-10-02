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

        $query = Dudi::query();

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

        $perPage = (int) ($request->input('perPage') ?: 10);
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

        return view('dudis.index', compact('dudis', 'stats', 'perPage'));
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
}
