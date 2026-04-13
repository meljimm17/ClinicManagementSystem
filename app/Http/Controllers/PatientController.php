<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientQueue;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    // Show dashboard with registration form
    public function index()
    {
        $recentQueue = PatientQueue::with('patient')
                        ->latest()
                        ->take(5)
                        ->get();

        return view('staff.dashboard', compact('recentQueue'));
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
            'philhealth_no'            => 'nullable|string|max:30',
            'hmo_insurance'            => 'nullable|string|max:100',
            'emergency_contact_name'   => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|max:20',
            // Medical history
            'known_allergies'          => 'nullable|string',
            'existing_conditions'      => 'nullable|string',
            'current_medications'      => 'nullable|string',
            // Visit
            'primary_symptoms'         => 'nullable|string',
        ]);

        // Convert "N/A" from the UI toggle to null before saving
        $adminFields = [
            'philhealth_no',
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

        // Create the patient first (outside the retry loop — only created once)
        $patient = Patient::create($request->only([
            'name', 'date_of_birth', 'age', 'gender', 'civil_status',
            'contact_number', 'address', 'blood_type', 'height', 'weight',
            'philhealth_no',
            'hmo_insurance',
            'emergency_contact_name', 'emergency_contact_number',
            'known_allergies', 'existing_conditions', 'current_medications',
        ]));

        // Retry up to 5 times in case of a concurrent duplicate queue number.
        // Each attempt re-reads count() so it always picks the correct next slot
        // after any competing insert has committed.
        $queueNumber = null;
        $attempts    = 0;

        while ($attempts < 5) {
            try {
                $queueNumber = DB::transaction(function () use ($patient, $request) {
                    // Use COUNT so the next number is always based on how many
                    // rows actually exist today — avoids string-sort issues with MAX.
                    $count       = PatientQueue::whereDate('created_at', today())->count();
                    $queueNumber = 'Q-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

                    PatientQueue::create([
                        'queue_number'  => $queueNumber,
                        'patient_id'    => $patient->id,
                        'registered_by' => auth()->id(),
                        'symptoms'      => $request->primary_symptoms,
                        'status'        => 'waiting',
                        'queued_at'     => now(),
                    ]);

                    return $queueNumber;
                });

                break; // success — exit the loop

            } catch (UniqueConstraintViolationException $e) {
                $attempts++;

                if ($attempts >= 5) {
                    throw $e; // give up after 5 collisions
                }

                // Small random pause so competing requests don't retry in lockstep
                usleep(random_int(50000, 150000)); // 50–150 ms
            }
        }

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
                    ]);

        return response()->json($patients);
    }
}