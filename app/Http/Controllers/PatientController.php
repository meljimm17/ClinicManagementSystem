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
            // Personal
            'name'                     => 'required|string|max:255',
            'date_of_birth'            => 'nullable|date',
            'age'                      => 'nullable|integer',
            'gender'                   => 'required|in:Male,Female',
            'civil_status'             => 'nullable|in:Single,Married,Widowed,Separated',
            'contact_number'           => 'nullable|string|max:20',
            'address'                  => 'nullable|string',
            'blood_type'               => 'nullable|string|max:5',
            'height'                   => 'nullable|string|max:20',
            'weight'                   => 'nullable|string|max:20',
            // Administrative
            'philhealth_no'            => 'nullable|string|max:30',   // FIXED: was philhealth_number
            'hmo_insurance'            => 'nullable|string|max:100',
            'emergency_contact_name'   => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|max:20',
            // Medical history
            'known_allergies'          => 'nullable|string',
            'existing_conditions'      => 'nullable|string',
            'current_medications'      => 'nullable|string',
            // Visit
            'primary_symptoms'         => 'nullable|string',          // FIXED: was symptoms
        ]);

        // Convert "N/A" from the UI toggle to null before saving
        $adminFields = [
            'philhealth_no',                                          // FIXED: was philhealth_number
            'hmo_insurance',
            'emergency_contact_name',
            'emergency_contact_number',
            'known_allergies',
            'existing_conditions',
            'current_medications',
        ];
        foreach ($adminFields as $field) {
            if ($request->$field === 'N/A') {
                $request->merge([$field => null]);
            }
        }

        // Create patient
        $patient = Patient::create($request->only([
            'name', 'date_of_birth', 'age', 'gender', 'civil_status',
            'contact_number', 'address', 'blood_type', 'height', 'weight',
            'philhealth_no',                                          // FIXED: was philhealth_number
            'hmo_insurance',
            'emergency_contact_name', 'emergency_contact_number',
            'known_allergies', 'existing_conditions', 'current_medications',
        ]));

        // Generate queue number (e.g. Q-001, Q-002...)
        $queueCount  = PatientQueue::whereDate('created_at', today())->count();
        $queueNumber = 'Q-' . str_pad($queueCount + 1, 3, '0', STR_PAD_LEFT);

        // Add to queue
        PatientQueue::create([
            'queue_number'  => $queueNumber,
            'patient_id'    => $patient->id,
            'registered_by' => auth()->id(),
            'symptoms'      => $request->primary_symptoms,           // FIXED: was $request->symptoms
            'status'        => 'waiting',
        ]);

        return redirect()->back()->with('success', 'Patient registered and added to queue as ' . $queueNumber . '!');
    }

    // Search patients for returning patient lookup
    public function search(Request $request)
    {
        $query = $request->get('q');

        $patients = Patient::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('contact_number', 'LIKE', "%{$query}%")
                    ->limit(5)
                    ->get([
                        'id', 'name', 'date_of_birth', 'age', 'gender', 'civil_status',
                        'contact_number', 'address', 'blood_type', 'height', 'weight',
                        'philhealth_no', 'hmo_insurance',
                        'emergency_contact_name', 'emergency_contact_number',
                        'known_allergies', 'existing_conditions', 'current_medications',
                    ]);                                               // FIXED: now returns all fields

        return response()->json($patients);
    }
}