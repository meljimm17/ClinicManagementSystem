<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsPatientsSeeder extends Seeder
{
    public function run(): void
    {
        $doctorId = DB::table('doctors')->orderBy('id')->value('id');
        if (!$doctorId) {
            // Nothing to seed without a doctor to attach completed consultations to.
            return;
        }

        $doctorAssignedRoom = DB::table('doctors')->where('id', $doctorId)->value('assigned_room');
        $doctorAssignedRoom = $doctorAssignedRoom ?: '1';

        $staffId = DB::table('users')->where('role', 'staff')->value('id'); // nullable is fine

        $symptomsPool = [
            'Fever and cough',
            'Headache with dizziness',
            'Stomach pain after meals',
            'Back pain and fatigue',
            'Sore throat and body aches',
            'Joint pain and mild fever',
            'Persistent cough with shortness of breath',
            'Lower back pain after lifting',
        ];

        $diagnosisPool = [
            'Viral URI',
            'Hypertension',
            'Gastritis',
            'Migraine',
            'Acid peptic disease',
            'Tension-type headache',
            'Allergic rhinitis',
            'Lumbar muscle strain',
        ];

        $prescriptions = [
            'Paracetamol 500mg every 6 hours as needed; increase fluids and rest',
            'Omeprazole 20mg once daily before breakfast for 14 days',
            'Cetirizine 10mg once nightly for 5 days',
            'Ibuprofen 400mg every 8 hours after meals for 3 days',
            'Metformin 500mg twice daily with meals (as clinically indicated)',
        ];

        $notesPool = [
            'Advise follow-up in 5 to 7 days if symptoms persist.',
            'Monitor blood pressure at home and reduce sodium intake.',
            'Return immediately if shortness of breath or chest pain occurs.',
            'Lifestyle counseling provided; hydration and sleep emphasized.',
        ];

        $civilStatuses = ['Single', 'Married', 'Widowed', 'Separated'];
        $bloodTypes = ['A+', 'B+', 'O+', 'AB+'];
        $allergies = ['None', 'Penicillin', 'Seafood', 'Dust', 'Latex'];
        $conditions = ['None', 'Hypertension', 'Type 2 Diabetes', 'Asthma', 'Seasonal Allergies'];
        $medications = ['None', 'Losartan 50mg', 'Metformin 500mg', 'Salbutamol Inhaler', 'Cetirizine 10mg'];

        $targetCount = 20; // exactly 20 completed consultations
        $createdCount = 0;

        $cursor = 0;
        while ($createdCount < $targetCount) {
            // Spread across the last 5 days: 4 records per day = 20.
            $dayIndex = intdiv($cursor, 4); // 0..4
            $queueDate = Carbon::today()->subDays($dayIndex);
            $queueNumberIndex = ($cursor % 4) + 1; // 1..4
            $queueNumber = 'Q' . str_pad((string) $queueNumberIndex, 3, '0'); // Q001..Q004

            // Prevent unique conflicts for the same day/queue number.
            $alreadyExists = DB::table('patient_queue')
                ->where('queue_number', $queueNumber)
                ->where('queue_date', $queueDate->toDateString())
                ->exists();

            if ($alreadyExists) {
                $cursor++;
                continue;
            }

            $isSenior = $createdCount >= 12; // 12 adults + 8 seniors = 20
            $age = $isSenior ? rand(60, 80) : rand(20, 59);
            $dob = Carbon::today()->subYears($age)->subDays(rand(0, 364));
            $gender = rand(0, 1) ? 'Male' : 'Female';

            $patientNamePrefix = $isSenior ? 'Senior' : 'Adult';
            $patientName = $patientNamePrefix . ' Patient ' . ($createdCount + 1);

            $contact = '09' . str_pad((string) rand(0, 99999999), 8, '0', STR_PAD_LEFT);
            $address = 'Barangay ' . rand(1, 25);

            $symptoms = $symptomsPool[$createdCount % count($symptomsPool)];
            $diagnosis = $diagnosisPool[($createdCount + 3) % count($diagnosisPool)];
            $prescription = $prescriptions[$createdCount % count($prescriptions)];
            $notes = $notesPool[($createdCount + 1) % count($notesPool)];

            $queuedAt = $queueDate->copy()->setTime(8, 0)->addMinutes($queueNumberIndex * 22 + $dayIndex * 7);
            $calledAt = $queuedAt->copy()->addMinutes(rand(6, 18));
            $completedAt = $calledAt->copy()->addMinutes(rand(10, 28));

            $patientId = DB::table('patients')->insertGetId([
                'name' => $patientName,
                'date_of_birth' => $dob->toDateString(),
                'age' => $age,
                'gender' => $gender,
                'contact_number' => $contact,
                'address' => $address,
                'civil_status' => $civilStatuses[$createdCount % count($civilStatuses)],
                'blood_type' => $bloodTypes[$createdCount % count($bloodTypes)],
                'height' => (string) rand(148, 182),
                'weight' => (string) rand(45, 92),
                'philhealth_no' => 'PH-' . str_pad((string) ($createdCount + 1) * 17, 8, '0', STR_PAD_LEFT),
                'hmo_insurance' => 'Maxicare',
                'emergency_contact_name' => 'Contact ' . ($createdCount + 1),
                'emergency_contact_number' => '09' . str_pad((string) rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                'known_allergies' => $allergies[$createdCount % count($allergies)],
                'existing_conditions' => $conditions[($createdCount + 2) % count($conditions)],
                'current_medications' => $medications[($createdCount + 1) % count($medications)],
                'created_at' => $queuedAt,
                'updated_at' => $queuedAt,
            ]);

            $queueId = DB::table('patient_queue')->insertGetId([
                'queue_number' => $queueNumber,
                'queue_date' => $queueDate->toDateString(),
                'patient_id' => $patientId,
                'patient_name' => $patientName,
                'registered_by' => $staffId,
                'symptoms' => $symptoms,
                'status' => 'done',
                'assigned_room' => $doctorAssignedRoom,
                'queued_at' => $queuedAt->toDateTimeString(),
                'called_at' => $calledAt->toDateTimeString(),
                'completed_at' => $completedAt->toDateTimeString(),
                'created_at' => $queuedAt->toDateTimeString(),
                'updated_at' => $completedAt->toDateTimeString(),
            ]);

            DB::table('medical_records')->updateOrInsert(
                ['queue_id' => $queueId],
                [
                    'doctor_id' => $doctorId,
                    'symptoms' => $symptoms,
                    'diagnosis' => $diagnosis,
                    'prescription' => $prescription,
                    'notes' => $notes,
                    'record_status' => 'completed',
                    'consultation_date' => $queueDate->toDateString(),
                    'consultation_time' => $calledAt->format('H:i:s'),
                    'created_at' => $queuedAt->toDateTimeString(),
                    'updated_at' => $completedAt->toDateTimeString(),
                ]
            );

            $createdCount++;
            $cursor++;
        }
    }
}

