<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Doctor;
use App\Models\CheckupType;
use App\Models\MedicalRecord;

$doctor = Doctor::first();
echo "doctor:" . ($doctor ? $doctor->id . '|' . $doctor->name . '|' . $doctor->assigned_room : 'none') . PHP_EOL;
$types = CheckupType::active()->get();
foreach ($types as $type) {
    echo "type:" . $type->id . '|' . $type->name . '|' . $type->fee . PHP_EOL;
}
$records = MedicalRecord::orderBy('created_at', 'desc')->limit(3)->get();
foreach ($records as $record) {
    echo "record:" . $record->id . '|' . $record->patient_name . '|' . $record->status . '|' . $record->created_at . PHP_EOL;
}
