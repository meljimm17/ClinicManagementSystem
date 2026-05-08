<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'queue_id',
        'patient_id',        // ← was missing
        'patient_name',      // ← was missing
        'doctor_id',
        'symptoms',
        'diagnosis',
        'prescription',
        'notes',
        'record_status',
        'consultation_date',
        'consultation_time',
        // Patient snapshot fields for when patient is deleted
        'patient_age',
        'patient_gender',
        'patient_civil_status',
        'patient_contact',
        'patient_address',
        'patient_blood_type',
        'patient_height',
        'patient_weight',
        'patient_philhealth',
        'patient_hmo',
        'patient_emergency_name',
        'patient_emergency_contact',
        'patient_allergies',
        'patient_conditions',
        'patient_medications',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function queue()
    {
        return $this->belongsTo(PatientQueue::class, 'queue_id');
    }

    public function patient()        // ← was missing
    {
        return $this->belongsTo(Patient::class);
    }
}