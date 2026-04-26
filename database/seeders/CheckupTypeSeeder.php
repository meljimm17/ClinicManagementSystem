<?php

namespace Database\Seeders;

use App\Models\CheckupType;
use Illuminate\Database\Seeder;

class CheckupTypeSeeder extends Seeder
{
    public function run(): void
    {
        $checkupTypes = [
            [
                'name' => 'General Consultation',
                'fee' => 300.00,
                'is_active' => true,
            ],
            [
                'name' => 'Follow-up Visit',
                'fee' => 150.00,
                'is_active' => true,
            ],
            [
                'name' => 'Pediatric Consultation',
                'fee' => 350.00,
                'is_active' => true,
            ],
            [
                'name' => 'Senior Citizen Check-up',
                'fee' => 250.00,
                'is_active' => true,
            ],
            [
                'name' => 'Urgent Care',
                'fee' => 500.00,
                'is_active' => true,
            ],
            [
                'name' => 'Physical Examination',
                'fee' => 400.00,
                'is_active' => true,
            ],
        ];

        foreach ($checkupTypes as $type) {
            CheckupType::create($type);
        }
    }
}