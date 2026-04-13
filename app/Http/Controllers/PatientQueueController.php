<?php

namespace App\Http\Controllers;

use App\Models\PatientQueue;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class PatientQueueController extends Controller
{
    // Show patient queue page
    public function index()
{
    $queue = PatientQueue::with('patient')
                ->whereDate('created_at', today())
                ->whereIn('status', ['waiting', 'diagnosing']) 
                ->orderBy('created_at')
                ->get();

    return view('staff.patientqueue', compact('queue'));
}

// app/Http/Controllers/PatientQueueController.php

public function adminIndex()
{
    // Fetches all queue entries for today with their associated patient data
    $queueEntries = \App\Models\PatientQueue::with('patient')
                    ->whereDate('created_at', today())
                    ->orderBy('created_at', 'asc')
                    ->get();

    return view('admin.patientqueue', compact('queueEntries'));
}

    // Update patient status and room
    public function update(Request $request, PatientQueue $patientQueue)
{
    $request->validate([
        'status'        => 'required|in:waiting,diagnosing,done',
        'assigned_room' => 'nullable|string|max:50',
        'symptoms'      => 'nullable|string',
        'diagnosis'     => 'nullable|string', // Add this for the 'done' state
    ]);

    $patientQueue->update($request->only(['status', 'assigned_room', 'symptoms']));

    // ADD THIS: Automatically create a Medical Record when status is 'done'
    if ($request->status === 'done') {
        \App\Models\MedicalRecord::create([
            'queue_id'          => $patientQueue->id,
            'patient_id'        => $patientQueue->patient_id,
            'doctor_id'         => auth()->user()->doctor?->id, 
            'symptoms'          => $request->symptoms ?? $patientQueue->symptoms,
            'diagnosis'         => $request->diagnosis,
            'consultation_date' => now()->toDateString(),
            'record_status'     => 'completed'
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