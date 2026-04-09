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
        'assigned_room',
        'duration_minutes',
        'consultation_date',
        'consultation_time',
    ];

    // Belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Belongs to a doctor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Belongs to a queue entry
    public function queue()
    {
        return $this->belongsTo(PatientQueue::class, 'queue_id');
    }
}