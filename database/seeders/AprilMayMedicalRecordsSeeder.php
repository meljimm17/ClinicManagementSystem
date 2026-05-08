<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\PatientQueue;
use App\Models\MedicalRecord;
use App\Models\Payment;
use App\Models\Doctor;
use App\Models\CheckupType;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class AprilMayMedicalRecordsSeeder extends Seeder
{
    public function run(): void
    {
        $doctor = Doctor::first();
        if (! $doctor) {
            $this->command->error('No doctor record found. Please create a doctor first.');
            return;
        }

        $staffUser = User::where('role', 'staff')->first() ?? User::where('role', 'admin')->first();

        $checkupTypes = CheckupType::active()->orderBy('id')->get();
        if ($checkupTypes->isEmpty()) {
            $this->command->error('No active checkup types found. Please add at least one active checkup type.');
            return;
        }

        $queueFormat = strtoupper(Setting::getValue('queue_format', 'Q-001'));
        preg_match('/^([A-Z0-9#-]*?)(\d+)$/', $queueFormat, $matches);
        $queuePrefix = $matches[1] ?? 'Q-';
        $queueDigits = isset($matches[2]) ? strlen($matches[2]) : 3;

        $sampleFirstNames = [
            'Maya', 'Noah', 'Luca', 'Ariel', 'Sofia', 'Gabriel', 'Ella', 'Leo', 'Iris', 'Enzo',
            'Nina', 'Mateo', 'Zara', 'Felix', 'Clara', 'Jonah', 'Mila', 'Marco', 'Ava', 'Patrick',
            'Mia', 'Evan', 'Hannah', 'Daniel', 'Luna', 'Rico', 'Elena', 'Caleb', 'Bianca', 'Samuel',
            'Rhea', 'Isaac', 'Jade', 'Oliver', 'Paula', 'Rey', 'Nico', 'Sara', 'Noelle', 'Aaron',
            'Leah', 'Owen', 'Mila', 'Rico', 'Faith', 'Diego', 'Hazel', 'Miguel', 'Alana'
        ];

        $sampleLastNames = [
            'Santos', 'Reyes', 'Garcia', 'Dela Cruz', 'Lopez', 'Rivera', 'Fernandez', 'Torres',
            'Delos Santos', 'Ramos', 'Gonzales', 'Navarro', 'Cruz', 'Morales', 'Vargas', 'Pena',
            'Mendoza', 'Bautista', 'Santiago', 'De Guzman', 'Alvarez', 'Torres', 'Ortiz', 'Dominguez',
            'Rivers', 'Del Rosario', 'Valdez', 'Quintana', 'Castillo', 'Ramirez', 'Salazar', 'Velez',
            'Serrano', 'Pineda', 'Garcia', 'Ocampo', 'España', 'Luna', 'Cardenas', 'Aguirre', 'Navarro',
            'Cortes', 'Arias', 'Marquez', 'Flores', 'Guerrero', 'Campos', 'Soto', 'Cruz', 'Navarro'
        ];

        $civilStatuses = ['Single', 'Married', 'Widowed', 'Separated'];
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        $symptoms = [
            'Fever and headache',
            'Cough with mild body pain',
            'Stomach discomfort and nausea',
            'Sore throat and fatigue',
            'Back pain after physical activity',
            'Shortness of breath on exertion',
            'Skin rash with mild itching',
            'Joint pain and swelling',
            'Ear discomfort and dizziness',
            'Eye irritation and redness',
            'Mild abdominal cramps',
            'Nasal congestion and sneezing',
            'Headache after prolonged screen use',
            'Chest tightness and cough',
            'General weakness and chills',
        ];

        $diagnoses = [
            'Upper respiratory infection',
            'Mild gastroenteritis',
            'Tension headache',
            'Allergic rhinitis',
            'Muscle strain',
            'Acute bronchitis',
            'Viral fever',
            'Gastric upset',
            'Ear infection',
            'Conjunctivitis',
            'Hypertension monitoring',
            'Routine check-up',
            'Follow-up stable condition',
            'Dehydration',
            'Minor sprain',
        ];

        $prescriptions = [
            'Paracetamol 500mg, three times daily as needed',
            'Amoxicillin 500mg, twice daily for 5 days',
            'Loperamide 2mg after each loose stool',
            'Cetirizine 10mg once daily',
            'Ibuprofen 400mg every 8 hours after meals',
            'Saline nasal spray, 2-3 times daily',
            'Vitamin C 500mg once daily',
            'Omeprazole 20mg before breakfast',
            'Eye drops twice daily',
            'Topical cream twice daily',
            'Multivitamin one tablet daily',
            'Oral rehydration salts as directed',
            'Cold compress for 15 minutes twice daily',
            'Gentle stretching exercises once daily',
            'Warm saltwater gargle three times daily',
        ];

        $dateBatches = [
            '2026-04-29' => 15,
            '2026-04-30' => 15,
            '2026-05-08' => 15,
        ];

        $baseContact = 9170000000;
        $baseEmergency = 9180000000;

        foreach ($dateBatches as $date => $count) {
            for ($index = 0; $index < $count; $index++) {
                $rowIndex = array_search($date, array_keys($dateBatches)) * 15 + $index;
                $firstName = $sampleFirstNames[$rowIndex % count($sampleFirstNames)];
                $lastName = $sampleLastNames[$rowIndex % count($sampleLastNames)];
                $name = "$firstName $lastName";
                $gender = $rowIndex % 2 === 0 ? 'Female' : 'Male';
                $age = [6, 10, 14, 18, 24, 29, 33, 38, 42, 47, 53, 58, 63, 68, 74, 80, 85, 12, 21, 30, 36, 44, 51, 59, 67, 72, 77, 25, 31, 40, 49, 55, 60, 66, 70, 78, 83, 16, 27, 35, 41, 50, 56, 62, 69, 75][$rowIndex % 45];
                $dateOfBirth = Carbon::createFromDate(2026 - $age, rand(1, 12), rand(1, 28))->toDateString();
                $contactNumber = '09' . str_pad($baseContact + $rowIndex, 9, '0', STR_PAD_LEFT);
                $emergencyContactNumber = '09' . str_pad($baseEmergency + $rowIndex, 9, '0', STR_PAD_LEFT);
                $address = "Unit " . ($rowIndex + 2) . ", Brgy. " . Arr::random(['San Isidro', 'Poblacion', 'San Antonio', 'Santo Niño', 'Malinao', 'Bagumbayan', 'San Miguel']) . ", Davao City";
                $bloodType = Arr::random($bloodTypes);
                $civilStatus = Arr::random($civilStatuses);
                $height = round(110 + ($age * 0.9) + rand(-5, 5), 2);
                $weight = round(18 + ($age * 0.8) + rand(-5, 5), 2);
                $philhealth = 'PH' . str_pad($rowIndex + 1000, 8, '0', STR_PAD_LEFT);
                $hmo = $rowIndex % 3 === 0 ? 'Mercantile' : null;
                $symptom = Arr::random($symptoms);
                $diagnosis = Arr::random($diagnoses);
                $prescription = Arr::random($prescriptions);
                $notes = 'Follow up if symptoms persist or worsen.';
                $checkupType = $checkupTypes[$rowIndex % $checkupTypes->count()];

                $queueNumber = $this->generateQueueNumberForDate($date, $queuePrefix, $queueDigits);
                $queuedAt = Carbon::parse($date . ' 08:00')->addMinutes($index * 12)->setSeconds(0);
                $calledAt = (clone $queuedAt)->addMinutes(10 + ($index % 6));
                $completedAt = (clone $calledAt)->addMinutes(15 + ($index % 10));

                $patient = Patient::create([
                    'name' => $name,
                    'date_of_birth' => $dateOfBirth,
                    'age' => $age,
                    'gender' => $gender,
                    'civil_status' => $civilStatus,
                    'contact_number' => $contactNumber,
                    'address' => $address,
                    'blood_type' => $bloodType,
                    'height' => $height,
                    'weight' => $weight,
                    'philhealth_no' => $philhealth,
                    'hmo_insurance' => $hmo,
                    'emergency_contact_name' => 'Maria ' . $lastName,
                    'emergency_contact_number' => $emergencyContactNumber,
                    'known_allergies' => $rowIndex % 4 === 0 ? 'None' : 'Dust, pollen',
                    'existing_conditions' => $rowIndex % 5 === 0 ? 'Hypertension' : null,
                    'current_medications' => $rowIndex % 6 === 0 ? 'Multivitamins' : null,
                ]);

                $queueEntry = PatientQueue::create([
                    'queue_number' => $queueNumber,
                    'queue_date' => $date,
                    'patient_id' => $patient->id,
                    'patient_name' => $patient->name,
                    'registered_by' => $staffUser?->id,
                    'symptoms' => $symptom,
                    'status' => 'done',
                    'assigned_room' => $doctor->assigned_room,
                    'queued_at' => $queuedAt,
                    'called_at' => $calledAt,
                    'completed_at' => $completedAt,
                    'checkup_type_id' => $checkupType->id,
                    'custom_fee' => null,
                ]);

                MedicalRecord::create([
                    'queue_id' => $queueEntry->id,
                    'patient_id' => $patient->id,
                    'patient_name' => $patient->name,
                    'doctor_id' => $doctor->id,
                    'symptoms' => $symptom,
                    'diagnosis' => $diagnosis,
                    'prescription' => $prescription,
                    'notes' => $notes,
                    'record_status' => 'completed',
                    'consultation_date' => $date,
                    'consultation_time' => $completedAt->format('H:i:s'),
                    'patient_age' => $patient->age,
                    'patient_gender' => $patient->gender,
                    'patient_civil_status' => $patient->civil_status,
                    'patient_contact' => $patient->contact_number,
                    'patient_address' => $patient->address,
                    'patient_blood_type' => $patient->blood_type,
                    'patient_height' => $patient->height,
                    'patient_weight' => $patient->weight,
                    'patient_philhealth' => $patient->philhealth_no,
                    'patient_hmo' => $patient->hmo_insurance,
                    'patient_emergency_name' => $patient->emergency_contact_name,
                    'patient_emergency_contact' => $patient->emergency_contact_number,
                    'patient_allergies' => $patient->known_allergies,
                    'patient_conditions' => $patient->existing_conditions,
                    'patient_medications' => $patient->current_medications,
                ]);

                Payment::create([
                    'visit_id' => $queueEntry->id,
                    'amount' => $checkupType->fee,
                    'remaining' => 0,
                    'status' => 'paid',
                    'payment_method' => 'cash',
                    'paid_at' => $completedAt,
                ]);
            }
        }

        $this->command->info('Created 45 completed patient records for April 29, April 30, and May 8.');
    }

    private function generateQueueNumberForDate(string $date, string $queuePrefix, int $queueDigits): string
    {
        $latest = PatientQueue::withTrashed()
            ->whereDate('queue_date', $date)
            ->pluck('queue_number')
            ->map(function ($value) use ($queuePrefix) {
                $escapedPrefix = preg_quote($queuePrefix, '/');
                if (preg_match('/^' . $escapedPrefix . '(\d+)$/', $value, $matches)) {
                    return (int) $matches[1];
                }
                return 0;
            })
            ->max() ?? 0;

        return $queuePrefix . str_pad($latest + 1, $queueDigits, '0', STR_PAD_LEFT);
    }
}
