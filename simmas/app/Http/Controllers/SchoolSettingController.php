<?php

namespace App\Http\Controllers;

use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = SchoolSetting::first();
        if (!$setting) {
            $setting = SchoolSetting::create([
                'name' => 'SMKN 1 Contoh',
                'abbreviation' => 'SMK1C',
                'address' => 'Jl. Contoh No. 1',
                'phone' => '08123456789',
                'email' => 'info@smk1contoh.sch.id',
            ]);
        }
        
        return view('school-settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolSetting $schoolSetting)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abbreviation' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('logo');
        
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($schoolSetting->logo) {
                Storage::delete('public/' . $schoolSetting->logo);
            }
            
            // Simpan logo baru
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        $schoolSetting->update($data);

        return redirect()->route('school-settings.index')->with('success', 'Pengaturan sekolah berhasil diperbarui');
    }
}
