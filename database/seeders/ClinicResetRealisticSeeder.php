<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ClinicResetRealisticSeeder extends Seeder
{
    public function run(): void
    {
        $doctorId = DB::table('doctors')->value('id');
        $staffId = DB::table('users')->where('role', 'staff')->value('id') ?? DB::table('users')->value('id');

        $names = [
            'Maria Santos', 'Juan Dela Cruz', 'Angela Reyes', 'Ramon Villanueva', 'Catherine Lim',
            'Paolo Navarro', 'Jasmine Flores', 'Daniel Mendoza', 'Trisha Mercado', 'Leo Gonzales',
            'Bea Castillo', 'Marco Fernandez', 'Ivy Dominguez', 'Noel Bautista', 'Shiela Ramos',
            'Adrian Pascual', 'Mae Torres', 'Ryan Salazar', 'Nicole Aquino', 'Kevin Herrera',
            'Patricia Chua', 'Stephen Lopez', 'Carla Valencia', 'Francis Ortiz', 'Mika Dizon',
            'Harold Cabrera', 'Anne Velasco', 'Joshua Soriano',
        ];

        $civilStatuses = ['Single', 'Married', 'Widowed', 'Separated'];
        $hmoList = ['None', 'Maxicare', 'Intellicare', 'Medicard'];
        $barangays = ['Poblacion', 'San Isidro', 'Mabini', 'Santa Cruz', 'Bagong Silang', 'San Roque'];
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'O+', 'O-'];
        $allergies = ['None', 'Penicillin', 'Seafood', 'Dust', 'Latex'];
        $conditions = ['None', 'Hypertension', 'Type 2 Diabetes', 'Asthma', 'Seasonal Allergies'];
        $medications = ['None', 'Losartan 50mg', 'Metformin 500mg', 'Salbutamol Inhaler', 'Cetirizine 10mg'];
        $symptomsPool = [
            'Persistent cough and mild fever',
            'Headache with neck stiffness',
            'Lower back pain after lifting',
            'Epigastric pain after meals',
            'Intermittent dizziness and fatigue',
            'Sore throat and body aches',
            'Allergic rhinitis flare-up',
            'Mild skin rash and itching',
        ];
        $diagnosisPool = [
            'Acute upper respiratory infection',
            'Tension-type headache',
            'Lumbar muscle strain',
            'Acid peptic disease',
            'Benign positional vertigo',
            'Viral pharyngitis',
            'Allergic rhinitis',
            'Contact dermatitis',
        ];
        $prescriptions = [
            'Paracetamol 500mg every 6 hours as needed; increase fluids and rest',
            'Ibuprofen 400mg every 8 hours after meals for 3 days',
            'Omeprazole 20mg once daily before breakfast for 14 days',
            'Cetirizine 10mg once nightly for 5 days',
            'Mefenamic acid 500mg then 250mg every 6 hours as needed',
            'Loratadine 10mg once daily for 7 days',
        ];
        $notesPool = [
            'Advise follow-up in 5 to 7 days if symptoms persist.',
            'Monitor blood pressure at home and reduce sodium intake.',
            'Return immediately if shortness of breath or chest pain occurs.',
            'Lifestyle counseling provided; hydration and sleep emphasized.',
            'Issued medical certificate for one day rest.',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('patient_queue_priorities')->truncate();
        DB::table('medical_records')->truncate();
        DB::table('patient_queue')->truncate();
        DB::table('patients')->truncate();
        DB::table('report_snapshots')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $patientIds = [];
        $seededAt = now();

        foreach ($names as $idx => $name) {
            $age = rand(19, 68);
            $dob = Carbon::today()->subYears($age)->subDays(rand(0, 364));

            $patientIds[] = DB::table('patients')->insertGetId([
                'name' => $name,
                'date_of_birth' => $dob->toDateString(),
                'age' => $age,
                'gender' => rand(0, 1) ? 'Male' : 'Female',
                'civil_status' => $civilStatuses[array_rand($civilStatuses)],
                'contact_number' => '09' . rand(100000000, 999999999),
                'address' => $barangays[array_rand($barangays)] . ', Clinic City',
                'philhealth_number' => 'PH' . rand(1000000000, 9999999999),
                'philhealth_no' => 'PH' . rand(1000000000, 9999999999),
                'hmo_insurance' => $hmoList[array_rand($hmoList)],
                'emergency_contact_name' => 'Contact ' . ($idx + 1),
                'emergency_contact_number' => '09' . rand(100000000, 999999999),
                'known_allergies' => $allergies[array_rand($allergies)],
                'existing_conditions' => $conditions[array_rand($conditions)],
                'current_medications' => $medications[array_rand($medications)],
                'blood_type' => $bloodTypes[array_rand($bloodTypes)],
                'height' => (string) rand(148, 182),
                'weight' => (string) rand(48, 94),
                'created_at' => $seededAt,
                'updated_at' => $seededAt,
            ]);
        }

        foreach ($patientIds as $idx => $patientId) {
            // Keep activity healthy and recent: first 8 patients are today's completed consults.
            $daysAgo = $idx < 8 ? 0 : rand(1, 18);
            $queueDate = Carbon::today()->subDays($daysAgo);
            $queuedAt = $queueDate->copy()->setTime(rand(8, 15), rand(0, 59));
            $calledAt = $queuedAt->copy()->addMinutes(rand(8, 28));
            $completedAt = $calledAt->copy()->addMinutes(rand(12, 35));

            $symptom = $symptomsPool[array_rand($symptomsPool)];
            $diagnosis = $diagnosisPool[array_rand($diagnosisPool)];
            $queueNumber = $queueDate->format('Ymd') . '-' . str_pad((string) ($idx + 1), 3, '0', STR_PAD_LEFT);

            $queueId = DB::table('patient_queue')->insertGetId([
                'queue_number' => $queueNumber,
                'queue_date' => $queueDate->toDateString(),
                'patient_id' => $patientId,
                'registered_by' => $staffId,
                'symptoms' => $symptom,
                'status' => 'done',
                'assigned_room' => 'Room ' . rand(1, 5),
                'queued_at' => $queuedAt->toDateTimeString(),
                'called_at' => $calledAt->toDateTimeString(),
                'completed_at' => $completedAt->toDateTimeString(),
                'created_at' => $queuedAt->toDateTimeString(),
                'updated_at' => $completedAt->toDateTimeString(),
            ]);

            DB::table('medical_records')->insert([
                'queue_id' => $queueId,
                'doctor_id' => $doctorId,
                'symptoms' => $symptom,
                'diagnosis' => $diagnosis,
                'prescription' => $prescriptions[array_rand($prescriptions)],
                'notes' => $notesPool[array_rand($notesPool)],
                'record_status' => 'completed',
                'consultation_date' => $queueDate->toDateString(),
                'consultation_time' => $calledAt->format('H:i:s'),
                'created_at' => $completedAt->toDateTimeString(),
                'updated_at' => $completedAt->toDateTimeString(),
            ]);
        }
    }
}
