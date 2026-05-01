<?php

namespace App\Http\Controllers;

use App\Models\PatientQueue;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientQueueController extends Controller
{
    public function waitingArea()
    {
        $queue = PatientQueue::with(['patient', 'priority'])
            ->whereDate('created_at', today())
            ->whereIn('status', ['waiting', 'diagnosing'])
            ->orderByRaw("CASE WHEN EXISTS (SELECT 1 FROM patient_queue_priorities WHERE patient_queue_priorities.patient_queue_id = patient_queue.id) THEN 0 ELSE 1 END")
            ->orderByRaw("CASE WHEN status = 'diagnosing' THEN 0 ELSE 1 END")
            ->orderBy('queued_at', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('queue-waiting-area', compact('queue'));
    }

    public function index()
    {
        $queue = PatientQueue::with(['patient', 'priority'])
                    ->whereDate('created_at', today())
                    ->whereIn('status', ['waiting', 'diagnosing'])
                    ->orderByRaw("CASE WHEN EXISTS (SELECT 1 FROM patient_queue_priorities WHERE patient_queue_priorities.patient_queue_id = patient_queue.id) THEN 0 ELSE 1 END")
                    ->orderBy('queued_at', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();

        return view('staff.patientqueue', compact('queue'));
    }

    public function adminIndex()
    {
        $queueEntries = PatientQueue::with(['patient', 'priority'])
                        ->orderByDesc('queue_date')
                        ->orderByRaw("CASE WHEN EXISTS (SELECT 1 FROM patient_queue_priorities WHERE patient_queue_priorities.patient_queue_id = patient_queue.id) THEN 0 ELSE 1 END")
                        ->orderByDesc('queued_at')
                        ->orderByDesc('id')
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
        $queueFormat = strtoupper(Setting::getValue('queue_format', 'Q-001'));
        preg_match('/^([A-Z0-9#-]*?)(\d+)$/', $queueFormat, $matches);
        $queuePrefix = $matches[1] ?? 'Q-';
        $queueDigits = isset($matches[2]) ? strlen($matches[2]) : 3;
        $queueNumber = $queuePrefix . str_pad($todayCount + 1, $queueDigits, '0', STR_PAD_LEFT);

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
        // Check if patient is currently being diagnosed or already completed
        if ($patientQueue->status === 'diagnosing') {
            return redirect()->back()->with('error', 'Cannot update this patient. They are currently being diagnosed by a doctor. Please wait until the consultation is complete.');
        }
        if ($patientQueue->status === 'done') {
            return redirect()->back()->with('error', 'Cannot update this patient. Their consultation is already marked as complete.');
        }

        $request->validate([
            // Patient fields
            'name'           => 'required|string|max:255',
            'age'            => 'required|integer|min:0|max:130',
            'gender'         => 'required|in:Male,Female',
            'contact_number' => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'blood_type'     => 'nullable|string|max:5',
            'height'         => 'nullable|numeric|min:20|max:300',
            'weight'         => 'nullable|numeric|min:1|max:700',
            // Queue fields
            'status'         => 'required|in:waiting,diagnosing,done',
            'assigned_room'  => 'nullable|string|max:50|regex:/^[A-Za-z0-9\-\s#]+$/',
            'symptoms'       => 'nullable|string|max:1000',
            'diagnosis'      => 'nullable|string',
        ]);

        // Additional server-side check in case UI was bypassed
        if ($request->status === 'done' && $patientQueue->status !== 'done') {
            // Allow status change to done from waiting/diagnosing
        } else if ($patientQueue->status === 'done') {
            return redirect()->back()->with('error', 'Cannot update this patient. Their consultation is already marked as complete.');
        }

        // Update patient information
        $patient = $patientQueue->patient;
        if ($patient) {
            $patient->update([
                'name'           => $request->name,
                'age'            => $request->age,
                'gender'         => $request->gender,
                'contact_number' => $request->contact_number,
                'address'        => $request->address,
                'blood_type'     => $request->blood_type,
                'height'         => $request->height,
                'weight'         => $request->weight,
            ]);
        }

        // Update queue information (including patient_name snapshot)
        $patientQueue->update([
            'patient_name'  => $request->name,
            'status'        => $request->status,
            'assigned_room' => $request->assigned_room,
            'symptoms'      => $request->symptoms,
        ]);

        if ($request->status === 'done') {
            // Load patient relationship with the queue BEFORE creating the medical record.
            $patientQueue->load('patient');

            MedicalRecord::create([
                'patient_name'      => $patientQueue->patient_name
                                        ?? $patientQueue->patient?->name
                                        ?? 'Unknown Patient',
                'queue_id'          => $patientQueue->id,
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
        // Check if patient is currently being diagnosed or already completed
        if ($patientQueue->status === 'diagnosing') {
            return redirect()->back()->with('error', 'Cannot delete this patient. They are currently being diagnosed by a doctor. Please wait until the consultation is complete.');
        }
        if ($patientQueue->status === 'done') {
            return redirect()->back()->with('error', 'Cannot delete this patient. Their consultation is already marked as complete.');
        }

        $patientQueue->delete();
        return redirect()->back()->with('success', 'Queue entry removed.');
    }
}