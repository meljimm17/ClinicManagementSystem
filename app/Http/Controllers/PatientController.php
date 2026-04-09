<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientQueue;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Show dashboard with registration form
    public function index()
    {
        $recentQueue = PatientQueue::with('patient')
                        ->latest()
                        ->take(5)
                        ->get();
        return view('dashboard', compact('recentQueue'));
    }

    // Register a new patient and add to queue
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'age'            => 'required|integer',
            'gender'         => 'required|in:Male,Female',
            'contact_number' => 'nullable|string|max:20',
            'address'        => 'nullable|string',
            'blood_type'     => 'nullable|string|max:5',
            'height'         => 'nullable|string|max:20',
            'weight'         => 'nullable|string|max:20',
            'symptoms'       => 'nullable|string',
        ]);

        // Create patient
        $patient = Patient::create($request->only([
            'name', 'age', 'gender', 'contact_number',
            'address', 'blood_type', 'height', 'weight',
        ]));

        // Generate queue number
        $queueCount = PatientQueue::whereDate('created_at', today())->count();
        $queueNumber = 'Q-' . str_pad($queueCount + 1, 3, '0', STR_PAD_LEFT);

        // Add to queue
        PatientQueue::create([
            'queue_number'  => $queueNumber,
            'patient_id'    => $patient->id,
            'registered_by' => auth()->id(),
            'symptoms'      => $request->symptoms,
            'status'        => 'waiting',
        ]);

        return redirect()->back()->with('success', 'Patient registered successfully!');
    }
}