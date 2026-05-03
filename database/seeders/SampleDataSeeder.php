<?php

namespace Database\Seeders;

use App\Models\CheckupType;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $staff = User::updateOrCreate(
            ['username' => 'seed_staff'],
            [
                'name' => 'Seed Staff',
                'password' => Hash::make('password123'),
                'role' => 'staff',
            ]
        );

        $doctorSeeds = [
            ['seed_doc1', 'Dr. Clara Reyes', 'General Medicine', 'LIC-SMP-001', 'Room 1'],
            ['seed_doc2', 'Dr. Marco Lim', 'Internal Medicine', 'LIC-SMP-002', 'Room 2'],
        ];

        $doctorRows = [];
        foreach ($doctorSeeds as [$username, $name, $specialization, $license, $room]) {
            $doctorUser = User::updateOrCreate(
                ['username' => $username],
                [
                    'name' => $name,
                    'password' => Hash::make('password123'),
                    'role' => 'doctor',
                ]
            );

            $doctorRows[] = Doctor::updateOrCreate(
                ['user_id' => $doctorUser->id],
                [
                    'name' => $name,
                    'specialization' => $specialization,
                    'license_number' => $license,
                    'assigned_room' => $room,
                ]
            );
        }

        $checkupTypes = [
            ['General Consultation', 300.00],
            ['Follow-up Visit', 150.00],
            ['Urgent Care', 500.00],
        ];

        $checkupTypeIds = [];
        foreach ($checkupTypes as [$typeName, $fee]) {
            $checkupTypeIds[] = CheckupType::updateOrCreate(
                ['name' => $typeName],
                ['fee' => $fee, 'is_active' => true]
            )->id;
        }

        $monthNow = Carbon::now();
        $year = $monthNow->year;
        $todayDay = max(1, $monthNow->day);

        $mayNames = [
            'Miguel Dela Cruz',
            'Andrea Ramos',
            'Kevin Alonzo',
            'Bianca Mendoza',
            'Isaiah Torres',
            'Celeste Garcia',
            'Mark Javier',
            'Sophia Lopez',
            'Gabriel Aquino',
            'Ella Cruz',
        ];

        $aprilNames = [
            'Carlos Villanueva',
            'Denise Santos',
            'Ramon Pineda',
            'Mia Reyes',
            'Joshua Valdez',
        ];

        $barangays = [
            'Brgy. Poblacion, Makati',
            'Brgy. San Isidro, Pasig',
            'Brgy. Santa Cruz, Quezon City',
            'Brgy. Bagong Silang, Caloocan',
            'Brgy. San Roque, Antipolo',
        ];

        $bloodTypes = ['A+', 'B+', 'O+', 'AB+', 'A-', 'B-'];
        $civilStatuses = ['Single', 'Married'];
        $hmoList = ['None', 'Maxicare', 'Medicard', 'Intellicare'];
        $allergies = ['None', 'Penicillin', 'Seafood', 'Dust'];
        $conditions = ['None', 'Hypertension', 'Type 2 Diabetes', 'Asthma'];
        $medications = ['None', 'Paracetamol 500mg', 'Loratadine 10mg', 'Metformin 500mg'];
        $symptomsPool = [
            'Mild fever with sore throat',
            'Persistent headache after long screen time',
            'Lower back pain on standing',
            'Stomach discomfort after meals',
            'Intermittent dizziness and fatigue',
            'Body ache and nasal congestion',
            'Skin rash with itching',
            'Mild joint pain after physical activity',
        ];
        $diagnosisPool = [
            'Acute viral pharyngitis',
            'Tension headache',
            'Lumbar strain',
            'Gastritis',
            'Benign positional vertigo',
            'Allergic rhinitis',
            'Contact dermatitis',
            'Mild dehydration',
        ];
        $prescriptions = [
            'Paracetamol 500mg every 6 hours as needed; rest and hydrate',
            'Ibuprofen 400mg after meals for 3 days',
            'Omeprazole 20mg once daily before breakfast for 10 days',
            'Cetirizine 10mg once daily for 5 days',
            'Loratadine 10mg once daily for 7 days',
        ];
        $notesPool = [
            'Follow up in one week if symptoms persist.',
            'Hydration and rest recommended.',
            'Monitor symptoms and return if condition worsens.',
            'Avoid heavy lifting for 3 days.',
            'Continue medication as prescribed.',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('patient_queue_priorities')->truncate();
        DB::table('medical_records')->truncate();
        DB::table('patient_queue')->truncate();
        DB::table('patients')->truncate();
        DB::table('report_snapshots')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $patientQueueCounter = 1;

        $seedEntries = [];

        foreach ($mayNames as $index => $name) {
            $day = 1 + ($index % $todayDay);
            $seedEntries[] = [
                'name' => $name,
                'queue_date' => $monthNow->copy()->startOfMonth()->addDays($day - 1),
            ];
        }

        $aprilDays = [5, 10, 14, 19, 24];
        foreach ($aprilNames as $index => $name) {
            $seedEntries[] = [
                'name' => $name,
                'queue_date' => Carbon::create($year, 4, $aprilDays[$index]),
            ];
        }

        foreach ($seedEntries as $index => $entry) {
            $age = rand(24, 60);
            $dob = Carbon::today()->subYears($age)->subDays(rand(0, 365));
            $contact = '09' . str_pad((string) (960000000 + $index * 121), 9, '0', STR_PAD_LEFT);
            $emergencyContact = '09' . str_pad((string) (970000000 + $index * 113), 9, '0', STR_PAD_LEFT);

            $patientId = DB::table('patients')->insertGetId([
                'name' => $entry['name'],
                'date_of_birth' => $dob->toDateString(),
                'age' => $age,
                'gender' => $index % 2 === 0 ? 'Male' : 'Female',
                'civil_status' => $civilStatuses[$index % count($civilStatuses)],
                'address' => $barangays[$index % count($barangays)],
                'blood_type' => $bloodTypes[$index % count($bloodTypes)],
                'height' => (string) rand(153, 178),
                'weight' => (string) rand(52, 85),
                'contact_number' => $contact,
                'philhealth_no' => 'PH' . str_pad((string) (100000000 + $index), 10, '0', STR_PAD_LEFT),
                'hmo_insurance' => $hmoList[$index % count($hmoList)],
                'emergency_contact_name' => 'Maria ' . explode(' ', $entry['name'])[1],
                'emergency_contact_number' => $emergencyContact,
                'known_allergies' => $allergies[$index % count($allergies)],
                'existing_conditions' => $conditions[$index % count($conditions)],
                'current_medications' => $medications[$index % count($medications)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $queueDate = $entry['queue_date'];
            $queuedAt = $queueDate->copy()->setTime(8 + ($index % 5), 10 + (($index * 11) % 40));
            $calledAt = $queuedAt->copy()->addMinutes(10 + ($index % 10));
            $completedAt = $calledAt->copy()->addMinutes(18 + ($index % 9));
            $doctor = $doctorRows[$index % count($doctorRows)];
            $checkupTypeId = $checkupTypeIds[$index % count($checkupTypeIds)];
            $symptom = $symptomsPool[$index % count($symptomsPool)];
            $diagnosis = $diagnosisPool[$index % count($diagnosisPool)];
            $prescription = $prescriptions[$index % count($prescriptions)];
            $notes = $notesPool[$index % count($notesPool)];

            $queueId = DB::table('patient_queue')->insertGetId([
                'queue_number' => $queueDate->format('Ymd') . '-' . str_pad((string) $patientQueueCounter, 3, '0', STR_PAD_LEFT),
                'queue_date' => $queueDate->toDateString(),
                'patient_id' => $patientId,
                'registered_by' => $staff->id,
                'symptoms' => $symptom,
                'status' => 'done',
                'assigned_room' => $doctor->assigned_room,
                'checkup_type_id' => $checkupTypeId,
                'queued_at' => $queuedAt->toDateTimeString(),
                'called_at' => $calledAt->toDateTimeString(),
                'completed_at' => $completedAt->toDateTimeString(),
                'created_at' => $queuedAt->toDateTimeString(),
                'updated_at' => $completedAt->toDateTimeString(),
            ]);

            DB::table('medical_records')->insert([
                'queue_id' => $queueId,
                'patient_id' => $patientId,
                'patient_name' => $entry['name'],
                'doctor_id' => $doctor->id,
                'symptoms' => $symptom,
                'diagnosis' => $diagnosis,
                'prescription' => $prescription,
                'notes' => $notes,
                'record_status' => 'completed',
                'assigned_room' => $doctor->assigned_room,
                'consultation_date' => $queueDate->toDateString(),
                'consultation_time' => $calledAt->format('H:i:s'),
                'duration_minutes' => $calledAt->diffInMinutes($queuedAt),
                'created_at' => $completedAt->toDateTimeString(),
                'updated_at' => $completedAt->toDateTimeString(),
            ]);

            $patientQueueCounter++;
        }
    }
}
