<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::latest()->get();
        return view('hospitals.index', compact('hospitals'));
    }

    public function create()
    {
        return view('hospitals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:hospitals,email',
            'telepon' => 'required|string|max:20',
        ]);

        Hospital::create($validated);

        return redirect()->route('hospitals.index')
            ->with('success', 'Data rumah sakit berhasil ditambahkan.');
    }

    public function show(Hospital $hospital)
    {
        return view('hospitals.show', compact('hospital'));
    }

    public function edit(Hospital $hospital)
    {
        return view('hospitals.edit', compact('hospital'));
    }

    public function update(Request $request, Hospital $hospital)
    {
        $validated = $request->validate([
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:hospitals,email,' . $hospital->id,
            'telepon' => 'required|string|max:20',
        ]);

        $hospital->update($validated);

        return redirect()->route('hospitals.index')
            ->with('success', 'Data rumah sakit berhasil diupdate.');
    }

    public function destroy(Hospital $hospital)
    {
        try {
            $hospital->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data rumah sakit berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data.'
            ], 500);
        }
    }
}