<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\PatientQueue;
use Barryvdh\DomPDF\Facade\Pdf;
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
                ->with(['doctor.user', 'queue.patient', 'patient'])  // FIX: eager-load direct patient relationship
                ->orderByDesc('consultation_date')
                ->orderByDesc('consultation_time')
                ->orderByDesc('id')
                ->get();
        } else {
            $records = MedicalRecord::with(['doctor.user', 'queue.patient', 'patient'])  // FIX: eager-load direct patient relationship
                ->orderByDesc('consultation_date')
                ->orderByDesc('consultation_time')
                ->orderByDesc('id')
                ->get();
        }

        $mappedRecords = $records->map(function ($r) {
            // FIX: Prefer the direct patient relationship, fall back to queue->patient,
            // both of which may be null for old/deleted records.
            // However, ALWAYS use the stored snapshot (patient_name) as the primary source
            $patient = $r->patient ?? $r->queue?->patient;

            $duration = null;
            if ($r->queue?->called_at && $r->queue?->completed_at) {
                $duration = \Carbon\Carbon::parse($r->queue->called_at)
                    ->diffInMinutes(\Carbon\Carbon::parse($r->queue->completed_at));
            }

            $resolvedName = $r->patient_name ?? $patient?->name ?? 'Unknown Patient';

            return [
                'id'           => $r->id,
                // FIX: CRITICAL - Use the stored patient_name snapshot FIRST
                // This snapshot was captured when the medical record was created
                // and remains accurate even if the queue entry is later deleted.
                // Only fall back to relationship fetching if snapshot is missing (legacy records).
                'patient_name' => $resolvedName,
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
                'print_url'    => route('doctor.medical-records.print', $r),
                'date'         => date('M d, Y', strtotime($r->consultation_date)),
                'time'         => $r->consultation_time
                    ? date('h:i A', strtotime($r->consultation_time))
                    : null,
            ];
        });

        $viewPath = ($user->role === 'doctor') ? 'doctor.medical-records' : 'admin.medical-records';
        return view($viewPath, compact('records', 'mappedRecords'));
    }

    public function printDoctorRecord(MedicalRecord $medicalRecord)
    {
        $user = Auth::user();
        $doctorId = $user?->doctor?->id;

        if (!$doctorId || ($medicalRecord->doctor_id !== null && (int) $medicalRecord->doctor_id !== (int) $doctorId)) {
            abort(403, 'You are not authorized to print this prescription record.');
        }

        // FIX: Load direct patient relationship for PDF generation
        $medicalRecord->load(['doctor.user', 'queue.patient', 'patient']);

        $data = [
            'record'      => $medicalRecord,
            'generatedAt' => now(),
        ];

        $pdf = Pdf::loadView('doctor.prescription-print', $data)->setPaper('a4', 'portrait');

        return $pdf->stream('Prescription-' . $medicalRecord->id . '.pdf');
    }

    /**
     * Admin-specific index — uses the shared index() logic above.
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

        // FIX: Load the queue with its patient BEFORE creating the record,
        // so the name snapshot is captured even if the queue is later deleted.
        $queue = PatientQueue::with('patient')->find($request->queue_id);

        $record = MedicalRecord::create([
            'queue_id'          => $request->queue_id,
            // FIX: Capture patient_id from the queue
            'patient_id'        => $queue?->patient_id,
            // FIX: Capture patient_name snapshot from the queue's patient
            'patient_name'      => $queue?->patient_name ?? $queue?->patient?->name ?? 'Unknown Patient',
            'doctor_id'         => $request->doctor_id ?? Auth::user()->doctor?->id,
            'symptoms'          => $request->symptoms ?? $queue?->symptoms,
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