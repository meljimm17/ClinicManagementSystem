<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientQueue;
use App\Models\PatientQueuePriority;
use App\Models\CheckupType;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    // Show dashboard with registration form
    public function index()
    {
        $recentQueue = PatientQueue::with(['patient', 'checkupType', 'payment'])
                        ->whereDate('queued_at', today())
                        ->latest('queued_at')
                        ->take(5)
                        ->get();
        
        // Average intake time in minutes (queued_at → called_at) for today
        $avgIntakeMinutes = PatientQueue::whereDate('queued_at', today())
            ->whereNotNull('called_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, queued_at, called_at)) as avg_intake')
            ->value('avg_intake');
        $avgIntakeMinutes = $avgIntakeMinutes ? round($avgIntakeMinutes) : 0;
        
        $checkupTypes = CheckupType::active()->orderBy('name')->get();

        return view('staff.dashboard', compact('recentQueue', 'avgIntakeMinutes', 'checkupTypes'));
    }

    // Register a new patient and add to queue
    public function store(Request $request)
    {
        $request->validate([
            'returning_patient_id'     => 'nullable|exists:patients,id',
            // Personal
            'name'                     => 'required|string|max:255',
            'date_of_birth'            => 'required|date|before_or_equal:today',
            'age'                      => 'required|integer|min:1|max:130',
            'gender'                   => 'required|in:Male,Female',
            'civil_status'             => 'nullable|in:Single,Married,Widowed,Separated',
            'contact_number'           => ['required','string','regex:/^(?:\+63|63|0)9\d{9}$/'],
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
            'checkup_type_id'          => 'required|exists:checkup_types,id',
            'custom_fee'               => 'nullable|numeric|min:0|max:999999.99',
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
            'contact_number.regex' => 'Contact number must be a valid Philippine mobile number (e.g. 09171234567 or +639171234567).',
            'address.required' => 'Address is required.',
            'emergency_contact_number.regex' => 'Emergency contact number must be a valid Philippine mobile number (e.g. 09171234567 or +639171234567).',
            'age.integer' => 'Age must be a whole number.',
            'age.min' => 'Age must be at least 1 year.',
            'height.numeric' => 'Height must be a valid number.',
            'height.min' => 'Height must be at least 20 cm.',
            'height.max' => 'Height cannot exceed 300 cm.',
            'weight.numeric' => 'Weight must be a valid number.',
            'weight.min' => 'Weight must be at least 1 kg.',
            'weight.max' => 'Weight cannot exceed 700 kg.',
            'checkup_type_id.required' => 'Please select a check-up type.',
            'checkup_type_id.exists' => 'Selected check-up type is invalid.',
            'primary_symptoms.required' => 'Primary symptoms are required.',
        ]);

        // Check if patient is already in today's queue to prevent duplication
        $name = trim($request->name);
        $dob = $request->date_of_birth;
        $address = trim($request->address);
        $age = $request->age;
        $contact = trim($request->contact_number);
        $bloodType = trim($request->blood_type ?? '');
        $emgName = trim($request->emergency_contact_name ?? '');
        $emgContact = trim($request->emergency_contact_number ?? '');

        if (!empty($name)) {
            $candidates = Patient::where('name', 'LIKE', "%{$name}%")->get();
            $matched = $candidates->first(function ($patient) use ($dob, $address, $age, $contact, $bloodType, $emgName, $emgContact) {
                $score = 0;
                if ($dob && $patient->date_of_birth === $dob) $score++;
                if ($address && stripos($patient->address ?? '', $address) !== false) $score++;
                if ($age && (string)$patient->age === $age) $score++;
                if ($contact && $patient->contact_number === $contact) $score++;
                if ($bloodType && $patient->blood_type === $bloodType) $score++;
                if ($emgName && stripos($patient->emergency_contact_name ?? '', $emgName) !== false) $score++;
                if ($emgContact && $patient->emergency_contact_number === $emgContact) $score++;
                return $score >= 2; // Require at least 2 matches besides name
            });

            if ($matched) {
                $queueEntry = PatientQueue::whereDate('queue_date', today())
                    ->where('patient_id', $matched->id)
                    ->whereIn('status', ['waiting', 'diagnosing'])
                    ->first();
                if ($queueEntry) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This patient is already registered in today\'s queue. Please check the queue before registering again.',
                    ], 422);
                }
            }
        }

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
                    $queueFormat = strtoupper(Setting::getValue('queue_format', 'Q-001'));
                    preg_match('/^([A-Z0-9#-]*?)(\d+)$/', $queueFormat, $matches);
                    $queuePrefix = $matches[1] ?? 'Q-';
                    $queueDigits = isset($matches[2]) ? strlen($matches[2]) : 3;

                    $latestQueueNumber = PatientQueue::withTrashed()
                        ->whereDate('queue_date', $today)
                        ->pluck('queue_number')
                        ->map(function ($value) use ($queuePrefix) {
                            if (!is_string($value)) {
                                return 0;
                            }

                            $escapedPrefix = preg_quote($queuePrefix, '/');
                            if (preg_match('/^' . $escapedPrefix . '(\d+)$/', $value, $matches)) {
                                return (int) $matches[1];
                            }

                            return 0;
                        })
                        ->max() ?? 0;

                    $queueNumber = $queuePrefix . str_pad($latestQueueNumber + 1, $queueDigits, '0', STR_PAD_LEFT);

                    $queueEntry = PatientQueue::create([
                        'queue_number'  => $queueNumber,
                        'queue_date'    => $today,
                        'patient_id'    => $patient->id,
                        'patient_name'  => $patient->name,
                        'registered_by' => auth()->id(),
                        'symptoms'      => $request->primary_symptoms,
                        'status'        => 'waiting',
                        'queued_at'     => now(),
                        'checkup_type_id' => $request->checkup_type_id,
                        'custom_fee'    => $request->custom_fee ? $request->custom_fee : null,
                    ]);

                    // Create payment record automatically
                    $fee = 0;
                    if ($request->custom_fee) {
                        $fee = $request->custom_fee;
                    } elseif ($request->checkup_type_id) {
                        $checkupType = CheckupType::find($request->checkup_type_id);
                        if ($checkupType) {
                            $fee = $checkupType->fee;
                        }
                    }
                    
                    if ($fee > 0) {
                        Payment::create([
                            'visit_id' => $queueEntry->id,
                            'amount' => $fee,
                            'status' => 'unpaid',
                        ]);
                    }

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

    // Check if a patient matching the given details is already in today's queue
    public function checkQueue(Request $request)
    {
        $name       = trim($request->get('name', ''));
        $dob        = trim($request->get('date_of_birth', ''));
        $age        = trim($request->get('age', ''));
        $contact    = trim($request->get('contact_number', ''));
        $bloodType  = trim($request->get('blood_type', ''));
        $emgName    = trim($request->get('emergency_contact_name', ''));
        $emgContact = trim($request->get('emergency_contact_number', ''));

        // Require the full patient identity fields for duplicate queue detection.
        if (empty($name) || empty($dob) || empty($age) || empty($contact) || empty($bloodType)) {
            return response()->json(['in_queue' => false]);
        }

        $matched = Patient::where('name', $name)
            ->where('date_of_birth', $dob)
            ->where('age', $age)
            ->where('contact_number', $contact)
            ->where('blood_type', $bloodType)
            ->where('address', $request->get('address', ''))
            ->first();

        if (!$matched) {
            return response()->json(['in_queue' => false]);
        }

        // Check if this patient is currently in today's active queue
        $queueEntry = PatientQueue::whereDate('queue_date', today())
            ->where('patient_id', $matched->id)
            ->whereIn('status', ['waiting', 'diagnosing'])
            ->first();

        if (!$queueEntry) {
            return response()->json(['in_queue' => false]);
        }

        return response()->json([
            'in_queue'     => true,
            'patient_name' => $matched->name,
            'queue_number' => $queueEntry->display_queue_number ?? $queueEntry->queue_number,
            'status'       => $queueEntry->status,
        ]);
    }

    public function checkExistence(Request $request)
    {
        $name    = trim($request->get('name', ''));
        $dob     = trim($request->get('date_of_birth', ''));
        $address = trim($request->get('address', ''));
        $contact = trim($request->get('contact_number', ''));

        // Need at least name and dob, plus either address or contact
        if (empty($name) || empty($dob) || (empty($address) && empty($contact))) {
            return response()->json(['exists' => false]);
        }

        // Check if patient exists with exact matches and has medical records (returning patient)
        $query = Patient::where('name', $name)
            ->where('date_of_birth', $dob)
            ->whereHas('medicalRecords'); // Only if they have medical records

        if (!empty($address)) {
            $query->where('address', $address);
        }
        if (!empty($contact)) {
            $query->where('contact_number', $contact);
        }

        $patient = $query->first();

        if ($patient) {
            return response()->json([
                'exists'      => true,
                'patient_name' => $patient->name,
            ]);
        }

        return response()->json(['exists' => false]);
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);

        return response()->json($patient);
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