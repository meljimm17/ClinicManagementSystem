<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Doctor;
use App\Models\CheckupType;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'username' => 'admins',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'contact_number' => '09171234567',
            'address' => 'Davao City',
        ]);

        User::create([
            'name' => 'Justine',
            'username' => 'staff',
            'email' => 'justine@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'staff',
            'contact_number' => '09181234567',
            'address' => 'Davao City',
        ]);

        $doctorUser = User::create([
            'name' => 'Dr. Mel Joves',
            'username' => 'drmel',
            'email' => 'drmel@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'doctor',
            'contact_number' => '09191234567',
            'address' => 'Davao City',
        ]);

        Doctor::create([
            'user_id' => $doctorUser->id,
            'name' => 'Dr. Mel Joves',
            'specialization' => 'General Medicine',
            'license_number' => 'LIC-2024-00123',
            'room' => 'Room 1',
            'assigned_room' => 'Room 1',
        ]);

        // ========== CHECKUP TYPES ==========
        $checkupTypes = [
            ['name' => 'General Consultation', 'fee' => 300.00, 'is_active' => true],
            ['name' => 'Follow-up Visit', 'fee' => 150.00, 'is_active' => true],
            ['name' => 'Pediatric Consultation', 'fee' => 350.00, 'is_active' => true],
            ['name' => 'Senior Citizen Check-up', 'fee' => 250.00, 'is_active' => true],
            ['name' => 'Urgent Care', 'fee' => 500.00, 'is_active' => true],
            ['name' => 'Physical Examination', 'fee' => 400.00, 'is_active' => true],
        ];

        foreach ($checkupTypes as $type) {
            CheckupType::create($type);
        }
    }
}