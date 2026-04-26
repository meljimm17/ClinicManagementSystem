<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ScreenshotWaitingPatientsSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();
        $baseTime = $today->copy()->setTime(9, 0);

        // Prefer an existing staff user for "registered_by" so staff screens look realistic.
        $staffId = User::where('role', 'staff')->value('id');

        $rows = [
            [
                'name' => 'John Emmanuel Dos',
                'age' => 22,
                'gender' => 'Male',
                'civil_status' => 'Single',
                'contact_number' => '09700000001',
                'address' => 'Poblacion, Demo City',
                'symptoms' => 'Stomach pain after meals',
            ],
            [
                'name' => 'Maria Santos',
                'age' => 34,
                'gender' => 'Female',
                'civil_status' => 'Married',
                'contact_number' => '09700000002',
                'address' => 'San Isidro, Demo City',
                'symptoms' => 'Headache and dizziness',
            ],
            [
                'name' => 'Ramon Villanueva',
                'age' => 61,
                'gender' => 'Male',
                'civil_status' => 'Married',
                'contact_number' => '09700000003',
                'address' => 'Mabini, Demo City',
                'symptoms' => 'Back pain after lifting',
            ],
            [
                'name' => 'Angela Reyes',
                'age' => 15,
                'gender' => 'Female',
                'civil_status' => 'Single',
                'contact_number' => '09700000004',
                'address' => 'Santa Cruz, Demo City',
                'symptoms' => 'Sore throat and fever',
            ],
            [
                'name' => 'Catherine Lim',
                'age' => 8,
                'gender' => 'Female',
                'civil_status' => 'Single',
                'contact_number' => '09700000005',
                'address' => 'Bagong Silang, Demo City',
                'symptoms' => 'Sneezing and itchy eyes',
            ],
        ];

        foreach ($rows as $i => $r) {
            $dob = $today->copy()->subYears($r['age'])->subDays(10 + $i);

            $patient = Patient::updateOrCreate(
                [
                    'name' => $r['name'],
                    'date_of_birth' => $dob->toDateString(),
                    'contact_number' => $r['contact_number'],
                ],
                [
                    'age' => $r['age'],
                    'gender' => $r['gender'],
                    'civil_status' => $r['civil_status'],
                    'address' => $r['address'],
                    'blood_type' => ['O+', 'A+', 'B+', 'AB+', 'O-'][$i % 5],
                    'height' => (string) (155 + ($i * 3)),
                    'weight' => (string) (50 + ($i * 4)),
                    'philhealth_no' => 'PH-DEMO-' . str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                    'hmo_insurance' => 'None',
                    'emergency_contact_name' => 'Demo Contact ' . ($i + 1),
                    'emergency_contact_number' => '0980000000' . ($i + 1),
                    'known_allergies' => null,
                    'existing_conditions' => null,
                    'current_medications' => null,
                    'primary_symptoms' => $r['symptoms'],
                ]
            );

            $queuedAt = $baseTime->copy()->addMinutes(($i + 1) * 7);

            // Generate a unique, screenshot-friendly queue number (unique column).
            $queueNumber = 'SS-' . $today->format('md') . '-' . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT);

            DB::table('patient_queue')->updateOrInsert(
                [
                    'queue_number' => $queueNumber,
                ],
                [
                    'queue_date' => $today->toDateString(),
                    'patient_id' => $patient->id,
                    'patient_name' => $patient->name,
                    'registered_by' => $staffId,
                    'symptoms' => $r['symptoms'],
                    'status' => 'waiting',
                    'assigned_room' => null,
                    'queued_at' => $queuedAt->toDateTimeString(),
                    'called_at' => null,
                    'completed_at' => null,
                    'created_at' => $queuedAt->toDateTimeString(),
                    'updated_at' => $queuedAt->toDateTimeString(),
                ]
            );
        }
    }
}

