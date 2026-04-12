<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'queue_id',
        'patient_id',
        'doctor_id',
        'symptoms',
        'diagnosis',
        'prescription',      // NEW
        'notes',             // NEW
        'record_status',     // NEW
        'assigned_room',
        'duration_minutes',
        'consultation_date',
        'consultation_time',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function queue()
    {
        return $this->belongsTo(PatientQueue::class, 'queue_id');
    }
}