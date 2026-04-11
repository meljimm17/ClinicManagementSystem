<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        // Personal Info
        'name',
        'date_of_birth',
        'age',
        'gender',
        'civil_status',
        'contact_number',
        'address',

        // Vitals
        'blood_type',
        'height',
        'weight',

        // Administrative
        'philhealth_no',
        'hmo_insurance',
        'emergency_contact_name',
        'emergency_contact_number',

        // Medical History
        'known_allergies',       // FIXED: was 'allergies'
        'existing_conditions',
        'current_medications',

        // Visit Info
        'primary_symptoms',
    ];

    // A patient can have many queue entries
    public function queues()
    {
        return $this->hasMany(PatientQueue::class);
    }

    // A patient can have many medical records
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}