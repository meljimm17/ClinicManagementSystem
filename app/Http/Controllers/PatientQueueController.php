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
                ->whereIn('status', ['waiting', 'diagnosing']) // ← add this line
                ->orderBy('created_at')
                ->get();

    return view('staff.patientqueue', compact('queue'));
}

    // Update patient status and room
    public function update(Request $request, PatientQueue $patientQueue)
    {
        $request->validate([
            'status'        => 'required|in:waiting,diagnosing,done',
            'assigned_room' => 'nullable|string|max:50',
            'symptoms'      => 'nullable|string',
        ]);

        $patientQueue->update($request->only([
            'status', 'assigned_room', 'symptoms'
        ]));

        return redirect()->back()->with('success', 'Queue updated successfully!');
    }

    // Delete a queue entry
    public function destroy(PatientQueue $patientQueue)
    {
        $patientQueue->delete();
        return redirect()->back()->with('success', 'Patient removed from queue!');
    }
}