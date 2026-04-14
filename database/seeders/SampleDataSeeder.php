<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Patient;
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
            ['username' => 'sample_staff1'],
            [
                'name' => 'Sample Staff 1',
                'password' => Hash::make('password123'),
                'role' => 'staff',
            ]
        );

        $doctorSeeds = [
            ['sample_doc1', 'Dr. Clara Reyes', 'General Medicine', 'LIC-SMP-001', '1'],
            ['sample_doc2', 'Dr. Marco Lim', 'Internal Medicine', 'LIC-SMP-002', '2'],
            ['sample_doc3', 'Dr. Nina Santos', 'Family Medicine', 'LIC-SMP-003', '3'],
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

        $patientIds = [];
        for ($i = 1; $i <= 24; $i++) {
            $dob = Carbon::now()->subYears(rand(18, 70))->subDays(rand(0, 365));
            $contact = '0917' . str_pad((string) (($i * 137) % 10000000), 7, '0', STR_PAD_LEFT);

            $patient = Patient::updateOrCreate(
                [
                    'name' => 'Sample Patient ' . $i,
                    'date_of_birth' => $dob->toDateString(),
                    'contact_number' => $contact,
                ],
                [
                    'age' => $dob->age,
                    'gender' => $i % 2 ? 'Male' : 'Female',
                    'civil_status' => $i % 3 ? 'Single' : 'Married',
                    'address' => 'Sample Address Block ' . $i,
                    'blood_type' => ['A+', 'B+', 'O+', 'AB+'][$i % 4],
                    'height' => (string) rand(150, 185),
                    'weight' => (string) rand(50, 95),
                    'philhealth_no' => 'PH-' . str_pad((string) $i, 8, '0', STR_PAD_LEFT),
                    'hmo_insurance' => 'Sample HMO',
                    'emergency_contact_name' => 'Contact ' . $i,
                    'emergency_contact_number' => '0998' . str_pad((string) (($i * 97) % 10000000), 7, '0', STR_PAD_LEFT),
                    'known_allergies' => $i % 4 === 0 ? 'Penicillin' : null,
                    'existing_conditions' => $i % 5 === 0 ? 'Hypertension' : null,
                    'current_medications' => $i % 6 === 0 ? 'Losartan 50mg' : null,
                ]
            );

            $patientIds[] = $patient->id;
        }

        $symptoms = [
            'Fever and cough',
            'Headache and dizziness',
            'Stomach pain',
            'Back pain',
            'Sore throat',
            'Joint pain',
            'Fatigue',
        ];

        for ($dayOffset = 0; $dayOffset < 7; $dayOffset++) {
            $date = Carbon::today()->subDays($dayOffset);

            for ($n = 1; $n <= 8; $n++) {
                $queueNumber = 'S' . $date->format('md') . '-' . str_pad((string) $n, 3, '0', STR_PAD_LEFT);
                $status = $n <= 3 ? 'done' : ($n <= 5 ? 'diagnosing' : 'waiting');
                $queuedAt = $date->copy()->setTime(8, 0)->addMinutes($n * 17);
                $calledAt = $status !== 'waiting' ? $queuedAt->copy()->addMinutes(rand(4, 20)) : null;
                $completedAt = $status === 'done' ? $calledAt->copy()->addMinutes(rand(8, 30)) : null;
                $doctor = $doctorRows[($n + $dayOffset) % count($doctorRows)];

                DB::table('patient_queue')->updateOrInsert(
                    [
                        'queue_number' => $queueNumber,
                        'queue_date' => $date->toDateString(),
                    ],
                    [
                        'patient_id' => $patientIds[array_rand($patientIds)],
                        'registered_by' => $staff->id,
                        'symptoms' => $symptoms[array_rand($symptoms)],
                        'status' => $status,
                        'assigned_room' => $status === 'waiting' ? null : ($doctor->assigned_room ?? '1'),
                        'queued_at' => $queuedAt->toDateTimeString(),
                        'called_at' => $calledAt?->toDateTimeString(),
                        'completed_at' => $completedAt?->toDateTimeString(),
                        'created_at' => $queuedAt->toDateTimeString(),
                        'updated_at' => ($completedAt ?? $calledAt ?? $queuedAt)->toDateTimeString(),
                    ]
                );

                $queueRow = DB::table('patient_queue')
                    ->where('queue_number', $queueNumber)
                    ->where('queue_date', $date->toDateString())
                    ->first();

                if ($status === 'done' && $queueRow) {
                    DB::table('medical_records')->updateOrInsert(
                        ['queue_id' => $queueRow->id],
                        [
                            'doctor_id' => $doctor->id,
                            'symptoms' => $queueRow->symptoms,
                            'diagnosis' => ['Viral URI', 'Hypertension', 'Gastritis', 'Migraine'][($n + $dayOffset) % 4],
                            'prescription' => 'Sample prescription',
                            'notes' => 'Generated sample record',
                            'record_status' => 'completed',
                            'consultation_date' => $date->toDateString(),
                            'consultation_time' => ($calledAt ?? $queuedAt)->format('H:i:s'),
                            'created_at' => $queuedAt->toDateTimeString(),
                            'updated_at' => ($completedAt ?? $queuedAt)->toDateTimeString(),
                        ]
                    );
                }
            }
        }
    }
}
