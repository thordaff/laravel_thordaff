<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $hospitals = Hospital::all();
        $query = Patient::with('hospital');

        if ($request->ajax() && $request->has('hospital_id')) {
            $query->where('hospital_id', $request->hospital_id);
        }

        $patients = $query->latest()->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $patients
            ]);
        }

        return view('patients.index', compact('patients', 'hospitals'));
    }

    public function create()
    {
        $hospitals = Hospital::all();
        return view('patients.create', compact('hospitals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|numeric|digits_between:10,15',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        Patient::create($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function show(Patient $patient)
    {
        $patient->load('hospital');
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $hospitals = Hospital::all();
        return view('patients.edit', compact('patient', 'hospitals'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|numeric|digits_between:10,15',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')
            ->with('success', 'Data pasien berhasil diupdate.');
    }

    public function destroy(Patient $patient)
    {
        try {
            $patient->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data pasien berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data.'
            ], 500);
        }
    }
}