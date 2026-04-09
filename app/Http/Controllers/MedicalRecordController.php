<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    // Show all medical records
    public function index()
    {
        $records = MedicalRecord::with(['patient', 'doctor'])
                    ->latest('consultation_date')
                    ->get();
        return view('medical-records', compact('records'));
    }

    // Store a new medical record (when queue is marked done)
    public function store(Request $request)
    {
        $request->validate([
            'queue_id'          => 'nullable|exists:patient_queue,id',
            'patient_id'        => 'required|exists:patients,id',
            'doctor_id'         => 'nullable|exists:doctors,id',
            'symptoms'          => 'nullable|string',
            'diagnosis'         => 'nullable|string|max:255',
            'assigned_room'     => 'nullable|string|max:50',
            'duration_minutes'  => 'nullable|integer',
            'consultation_date' => 'required|date',
            'consultation_time' => 'nullable',
        ]);

        MedicalRecord::create($request->all());

        return redirect()->back()->with('success', 'Medical record saved!');
    }
}