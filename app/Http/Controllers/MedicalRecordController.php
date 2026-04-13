<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\PatientQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'doctor') {
            $doctorId = $user->doctor ? $user->doctor->id : null;

            $records = MedicalRecord::where(function($query) use ($doctorId) {
                    $query->where('doctor_id', $doctorId)
                          ->orWhereNull('doctor_id'); 
                })
                ->with(['patient', 'doctor.user'])
                ->latest('consultation_date')
                ->get();
        } else {
            $records = MedicalRecord::with(['patient', 'doctor.user'])->latest()->get();
        }

        $mappedRecords = $records->map(function($r) {
            return [
                'id'           => $r->id,
                'patient_name' => $r->patient->name,
                'age'          => $r->patient->age,
                'gender'       => $r->patient->gender,
                'civil_status' => $r->patient->civil_status,
                'contact'      => $r->patient->contact_number,
                'address'      => $r->patient->address,
                'blood_type'   => $r->patient->blood_type,
                'height'       => $r->patient->height,
                'weight'       => $r->patient->weight,
                'philhealth'   => $r->patient->philhealth_no,
                'hmo'          => $r->patient->hmo_provider,
                'emg_name'     => $r->patient->emergency_contact_name,
                'emg_contact'  => $r->patient->emergency_contact_number,
                'allergies'    => $r->patient->allergies,
                'conditions'   => $r->patient->medical_conditions,
                'medications'  => $r->patient->current_medications,
                'symptoms'     => $r->symptoms,
                'doctor'       => $r->doctor_name ?? $r->doctor?->user?->name,
                'room'         => $r->assigned_room,
                'duration'     => $r->duration_minutes,
                'diagnosis'    => $r->diagnosis,
                'prescription' => $r->prescription,
                'notes'        => $r->notes,
                'date'         => date('M d, Y', strtotime($r->consultation_date))
            ];
        });

        $viewPath = ($user->role === 'doctor') ? 'doctor.medical-records' : 'admin.medical-records';
        return view($viewPath, compact('records', 'mappedRecords'));
    }

    public function adminIndex()
    {
        $records = MedicalRecord::with('patient')->latest()->get();
        return view('admin.medical-records', compact('records'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'queue_id'          => 'required|integer',
            'patient_id'        => 'required|exists:patients,id',
            'doctor_id'         => 'required|exists:doctors,id',
            'doctor_name'       => 'required|string|max:255',
            'assigned_room'     => 'required|string|max:50',
            'symptoms'          => 'required|string',
            'diagnosis'         => 'nullable|string',
            'prescription'      => 'nullable|string',
            'notes'             => 'nullable|string',
            'record_status'     => 'required|string',
            'consultation_date' => 'required|date',
            'consultation_time' => 'required',
        ]);

        $record = MedicalRecord::create([
            'queue_id'          => $request->queue_id,
            'patient_id'        => $request->patient_id,
            'doctor_id'         => $request->doctor_id ?? Auth::user()->doctor?->id,
            'doctor_name'       => $request->doctor_name,
            'assigned_room'     => $request->assigned_room,
            'symptoms'          => $request->symptoms ?? PatientQueue::find($request->queue_id)?->symptoms,
            'diagnosis'         => $request->diagnosis,
            'prescription'      => $request->prescription,
            'notes'             => $request->notes,
            'record_status'     => $request->record_status ?? 'completed',
            'duration_minutes'  => $request->duration_minutes,
            'consultation_date' => $request->consultation_date,
            'consultation_time' => $request->consultation_time,
        ]);

        if ($record->record_status === 'completed' && $request->queue_id) {
            PatientQueue::find($request->queue_id)?->update([
                'status'       => 'done',
                'completed_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Medical record saved successfully!');
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $request->validate([
            'doctor_id'         => 'nullable|exists:doctors,id',
            'doctor_name'       => 'nullable|string|max:255',
            'assigned_room'     => 'nullable|string|max:50',
            'symptoms'          => 'nullable|string',
            'diagnosis'         => 'nullable|string',
            'prescription'      => 'nullable|string',
            'notes'             => 'nullable|string',
            'record_status'     => 'nullable|in:draft,held_for_labs,completed',
            'duration_minutes'  => 'nullable|integer',
            'consultation_date' => 'required|date',
            'consultation_time' => 'nullable',
        ]);

        $medicalRecord->update($request->only([
            'doctor_id', 
            'doctor_name', 
            'assigned_room', 
            'symptoms', 
            'diagnosis',
            'prescription', 
            'notes', 
            'record_status', 
            'duration_minutes',
            'consultation_date', 
            'consultation_time',
        ]));

        if ($medicalRecord->record_status === 'completed' && $medicalRecord->queue_id) {
            PatientQueue::find($medicalRecord->queue_id)?->update([
                'status'       => 'done',
                'completed_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Medical record updated successfully!');
    }
}