<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\PatientQueue;
use Illuminate\Http\Request;

class PatientQueueController extends Controller
{
    // Public waiting area view (queue board display)
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

    // Show patient queue page
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

    // app/Http/Controllers/PatientQueueController.php

    public function adminIndex()
    {
        // Fetches all queue entries for today with their associated patient data
        $queueEntries = PatientQueue::with('patient')
            ->whereDate('created_at', today())
            ->orderBy('queued_at', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.patientqueue', compact('queueEntries'));
    }

    // Update patient status and room
    public function update(Request $request, PatientQueue $patientQueue)
    {
        $request->validate([
            'status' => 'required|in:waiting,diagnosing,done',
            'assigned_room' => 'nullable|string|max:50|regex:/^[A-Za-z0-9\-\s#]+$/',
            'symptoms' => 'nullable|string|max:1000',
            'diagnosis' => 'nullable|string', // Add this for the 'done' state
        ], [
            'status.required' => 'Status is required.',
            'status.in' => 'Selected status is invalid.',
            'assigned_room.regex' => 'Assigned room contains invalid characters.',
            'symptoms.max' => 'Symptoms must not exceed 1000 characters.',
        ]);

        $patientQueue->update($request->only(['status', 'assigned_room', 'symptoms']));

        // ADD THIS: Automatically create a Medical Record when status is 'done'
        if ($request->status === 'done') {
            MedicalRecord::create([
                'queue_id' => $patientQueue->id,
                'patient_name' => $patientQueue->patient?->name ?? 'Unknown Patient', // FIX: Save patient name snapshot
                'doctor_id' => auth()->user()->doctor?->id,
                'symptoms' => $request->symptoms ?? $patientQueue->symptoms,
                'diagnosis' => $request->diagnosis,
                'consultation_date' => now()->toDateString(),
                'record_status' => 'completed',
            ]);
        }

        return redirect()->back()->with('success', 'Queue updated and record saved!');
    }

    // Delete a queue entry
    public function destroy(PatientQueue $patientQueue)
    {
        $patientQueue->delete();

        return redirect()->back()->with('success', 'Patient removed from queue!');
    }
}
