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

            $records = MedicalRecord::where(function ($query) use ($doctorId) {
                    $query->where('doctor_id', $doctorId)
                          ->orWhereNull('doctor_id');
                })
                ->with(['doctor.user', 'queue.patient'])
                ->orderByDesc('consultation_date')
                ->orderByDesc('consultation_time')
                ->orderByDesc('id')
                ->get();
        } else {
            $records = MedicalRecord::with(['doctor.user', 'queue.patient'])
                ->orderByDesc('consultation_date')
                ->orderByDesc('consultation_time')
                ->orderByDesc('id')
                ->get();
        }

        $mappedRecords = $records->map(function ($r) {
            $patient = $r->queue?->patient;
            $duration = null;
            if ($r->queue?->called_at && $r->queue?->completed_at) {
                $duration = \Carbon\Carbon::parse($r->queue->called_at)
                    ->diffInMinutes(\Carbon\Carbon::parse($r->queue->completed_at));
            }

            return [
                'id'           => $r->id,
                'patient_name' => $patient?->name,
                'age'          => $patient?->age,
                'gender'       => $patient?->gender,
                'civil_status' => $patient?->civil_status,
                'contact'      => $patient?->contact_number,
                'address'      => $patient?->address,
                'blood_type'   => $patient?->blood_type,
                'height'       => $patient?->height,
                'weight'       => $patient?->weight,
                'philhealth'   => $patient?->philhealth_no,
                'hmo'          => $patient?->hmo_insurance,
                'emg_name'     => $patient?->emergency_contact_name,
                'emg_contact'  => $patient?->emergency_contact_number,
                'allergies'    => $patient?->known_allergies,
                'conditions'   => $patient?->existing_conditions,
                'medications'  => $patient?->current_medications,
                'symptoms'     => $r->symptoms,
                'doctor'       => $r->doctor?->name,
                'room'         => $r->queue?->assigned_room ?? $r->doctor?->assigned_room,
                'duration'     => $duration,
                'diagnosis'    => $r->diagnosis,
                'prescription' => $r->prescription,
                'notes'        => $r->notes,
                'status'       => $r->record_status,
                'date'         => date('M d, Y', strtotime($r->consultation_date)),
                'time'         => $r->consultation_time
                    ? date('h:i A', strtotime($r->consultation_time))
                    : null,
            ];
        });

        $viewPath = ($user->role === 'doctor') ? 'doctor.medical-records' : 'admin.medical-records';
        return view($viewPath, compact('records', 'mappedRecords'));
    }

    /**
     * Admin-specific index — uses the shared index() logic above.
     * Kept as an alias so both routes work.
     */
    public function adminIndex()
    {
        return $this->index();
    }

    public function store(Request $request)
    {
        $request->validate([
            'queue_id'          => 'required|integer',
            'doctor_id'         => 'required|exists:doctors,id',
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
            'doctor_id'         => $request->doctor_id ?? Auth::user()->doctor?->id,
            'symptoms'          => $request->symptoms ?? PatientQueue::find($request->queue_id)?->symptoms,
            'diagnosis'         => $request->diagnosis,
            'prescription'      => $request->prescription,
            'notes'             => $request->notes,
            'record_status'     => $request->record_status ?? 'completed',
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
            'symptoms'          => 'nullable|string',
            'diagnosis'         => 'nullable|string',
            'prescription'      => 'nullable|string',
            'notes'             => 'nullable|string',
            'record_status'     => 'nullable|in:draft,held_for_labs,completed',
            'consultation_date' => 'required|date',
            'consultation_time' => 'nullable',
        ]);

        $medicalRecord->update($request->only([
            'doctor_id',
            'symptoms',
            'diagnosis',
            'prescription',
            'notes',
            'record_status',
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