<?php

namespace App\Http\Controllers;

use App\Models\PatientQueue;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientQueueController extends Controller
{
    public function waitingArea()
    {
        $queue = PatientQueue::query()
            ->whereDate('created_at', today())
            ->whereIn('status', ['waiting', 'diagnosing'])
            ->orderByRaw("CASE WHEN status = 'diagnosing' THEN 0 ELSE 1 END")
            ->orderBy('queued_at', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('queue-waiting-area', compact('queue'));
    }

    public function index()
    {
        $queue = PatientQueue::with('patient')
                    ->whereDate('created_at', today())
                    ->whereIn('status', ['waiting', 'diagnosing']) 
                    ->orderBy('queued_at', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();

        return view('staff.patientqueue', compact('queue'));
    }

    public function adminIndex()
    {
        $queueEntries = PatientQueue::with('patient')
                        ->whereDate('created_at', today())
                        ->orderBy('queued_at', 'asc')
                        ->orderBy('id', 'asc')
                        ->get();

        return view('admin.patientqueue', compact('queueEntries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'symptoms'   => 'nullable|string|max:1000',
        ]);

        // Find the patient to snapshot their name
        $patient = Patient::findOrFail($request->patient_id);

        // Generate a unique queue number for today e.g. Q-001, Q-002
        $todayCount = PatientQueue::whereDate('created_at', today())->count();
        $queueNumber = 'Q-' . str_pad($todayCount + 1, 3, '0', STR_PAD_LEFT);

        PatientQueue::create([
            'queue_number'  => $queueNumber,
            'patient_id'    => $patient->id,
            'patient_name'  => $patient->name, // 👈 snapshot saved here
            'symptoms'      => $request->symptoms,
            'registered_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Patient added to queue successfully!');
    }

    public function update(Request $request, PatientQueue $patientQueue)
    {
        $request->validate([
            'status'        => 'required|in:waiting,diagnosing,done',
            'assigned_room' => 'nullable|string|max:50|regex:/^[A-Za-z0-9\-\s#]+$/',
            'symptoms'      => 'nullable|string|max:1000',
            'diagnosis'     => 'nullable|string', 
        ]);

        $patientQueue->update($request->only(['status', 'assigned_room', 'symptoms']));

        if ($request->status === 'done') {
            // Load patient relationship with the queue BEFORE creating the medical record.
            // This ensures we capture patient_id and patient_name even if the queue is
            // later deleted, so the medical record retains accurate info.
            $patientQueue->load('patient');
            
            MedicalRecord::create([
                // Capture the patient name SNAPSHOT - this survives queue deletion
                'patient_name'      => $patientQueue->patient_name
                                        ?? $patientQueue->patient?->name
                                        ?? 'Unknown Patient', // 👈 uses snapshot first
                'queue_id'          => $patientQueue->id,
                // Capture patient_id so we can still fetch patient data
                // even if the queue is deleted later
                'patient_id'        => $patientQueue->patient_id,
                'doctor_id'         => auth()->user()->doctor?->id, 
                'symptoms'          => $request->symptoms ?? $patientQueue->symptoms,
                'diagnosis'         => $request->diagnosis,
                'consultation_date' => now()->toDateString(),
                'consultation_time' => now()->toTimeString(),
                'record_status'     => 'completed'
            ]);
            
            $patientQueue->update(['completed_at' => now()]);
        }

        return redirect()->back()->with('success', 'Queue updated successfully!');
    }

    public function destroy(PatientQueue $patientQueue)
    {
        $patientQueue->delete();
        return redirect()->back()->with('success', 'Queue entry removed.');
    }
}