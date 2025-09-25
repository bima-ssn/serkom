<?php

namespace App\Http\Controllers;

use App\Models\Dudi;
use Illuminate\Http\Request;

class DudiController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin,guru');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dudis = Dudi::all();
        return view('dudis.index', compact('dudis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dudis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
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
    public function edit(Dudi $dudi)
    {
        return view('dudis.edit', compact('dudi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dudi $dudi)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
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
    public function destroy(Dudi $dudi)
    {
        $dudi->delete();

        return redirect()->route('dudis.index')
            ->with('success', 'DUDI berhasil dihapus.');
    }
}
