<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientQueue;
use App\Models\PatientQueuePriority;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    // Show dashboard with registration form
    public function index()
    {
        $recentQueue = PatientQueue::with('patient')
                        ->latest('queued_at')
                        ->take(5)
                        ->get();

        return view('staff.dashboard', compact('recentQueue'));
    }

    // Register a new patient and add to queue
    public function store(Request $request)
    {
        $request->validate([
            'returning_patient_id'     => 'nullable|exists:patients,id',
            // Personal
            'name'                     => 'required|string|max:255',
            'date_of_birth'            => 'required|date|before_or_equal:today',
            'age'                      => 'required|integer|min:0|max:130',
            'gender'                   => 'required|in:Male,Female',
            'civil_status'             => 'nullable|in:Single,Married,Widowed,Separated',
            'contact_number'           => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'address'                  => 'required|string|max:255',
            'blood_type'               => 'nullable|string|max:5',
            'height'                   => 'nullable|numeric|min:20|max:300',
            'weight'                   => 'nullable|numeric|min:1|max:700',
            // Administrative
            'philhealth_no'            => 'nullable|string|max:30',
            'hmo_insurance'            => 'nullable|string|max:100',
            'emergency_contact_name'   => 'nullable|string|max:100',
            'emergency_contact_number' => 'nullable|string|max:20|regex:/^[0-9+\-\s()]+$/',
            // Medical history
            'known_allergies'          => 'nullable|string',
            'existing_conditions'      => 'nullable|string',
            'current_medications'      => 'nullable|string',
            // Visit
            'primary_symptoms'         => 'required|string|max:1000',
            'is_priority'              => 'nullable|boolean',
            'priority_type'            => 'required_if:is_priority,1|nullable|in:senior,pwd,pregnant,urgent,other',
            'priority_notes'           => 'nullable|string|max:255',
        ], [
            'name.required' => 'Patient name is required.',
            'date_of_birth.required' => 'Date of birth is required.',
            'age.required' => 'Age is required.',
            'gender.required' => 'Please select the patient gender.',
            'gender.in' => 'Gender must be either Male or Female.',
            'date_of_birth.before_or_equal' => 'Date of birth cannot be in the future.',
            'age.min' => 'Age cannot be negative.',
            'age.max' => 'Age looks invalid. Please check again.',
            'contact_number.required' => 'Contact number is required.',
            'contact_number.regex' => 'Contact number format is invalid.',
            'address.required' => 'Address is required.',
            'emergency_contact_number.regex' => 'Emergency contact number format is invalid.',
            'height.numeric' => 'Height must be a valid number.',
            'weight.numeric' => 'Weight must be a valid number.',
            'primary_symptoms.required' => 'Primary symptoms are required.',
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

        $patientData = $request->only([
            'name', 'date_of_birth', 'age', 'gender', 'civil_status',
            'contact_number', 'address', 'blood_type', 'height', 'weight',
            'philhealth_no',
            'hmo_insurance',
            'emergency_contact_name', 'emergency_contact_number',
            'known_allergies', 'existing_conditions', 'current_medications',
        ]);

        // Always create a new patient row for each registration,
        // including returning patients, so every visit is recorded
        // as a separate patient database entry.
        $patient = Patient::create($patientData);

        // Retry up to 5 times in case of a concurrent duplicate queue number.
        // Each attempt re-reads existing queue numbers for today (including
        // soft-deleted rows) so we never reuse a number that still exists in
        // the unique index (queue_number + queue_date).
        $queueNumber = null;
        $attempts    = 0;

        while ($attempts < 5) {
            try {
                $queueNumber = DB::transaction(function () use ($patient, $request) {
                    $today = today()->toDateString();

                    $latestQueueNumber = PatientQueue::withTrashed()
                        ->whereDate('queue_date', $today)
                        ->pluck('queue_number')
                        ->map(function ($value) {
                            if (!is_string($value)) {
                                return 0;
                            }

                            if (preg_match('/^Q-(\d+)$/', $value, $matches)) {
                                return (int) $matches[1];
                            }

                            return 0;
                        })
                        ->max() ?? 0;

                    $queueNumber = 'Q-' . str_pad($latestQueueNumber + 1, 3, '0', STR_PAD_LEFT);

                    $queueEntry = PatientQueue::create([
                        'queue_number'  => $queueNumber,
                        'queue_date'    => $today,
                        'patient_id'    => $patient->id,
                        'patient_name'  => $patient->name,
                        'registered_by' => auth()->id(),
                        'symptoms'      => $request->primary_symptoms,
                        'status'        => 'waiting',
                        'queued_at'     => now(),
                    ]);

                    if ($request->boolean('is_priority')) {
                        PatientQueuePriority::create([
                            'patient_queue_id' => $queueEntry->id,
                            'priority_type' => $request->priority_type,
                            'notes' => $request->priority_notes,
                            'created_by' => auth()->id(),
                        ]);
                    }

                    return $queueNumber;
                });

                break; // success — exit the loop

            } catch (UniqueConstraintViolationException|QueryException $e) {
                if ($e instanceof QueryException && (string) $e->getCode() !== '23000') {
                    throw $e;
                }

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