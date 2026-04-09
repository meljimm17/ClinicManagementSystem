<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientQueue extends Model
{
    protected $table = 'patient_queue';

    protected $fillable = [
        'queue_number',
        'patient_id',
        'registered_by',
        'symptoms',
        'status',
        'assigned_room',
        'queued_at',
        'called_at',
        'completed_at',
    ];

    // Belongs to a patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Belongs to a staff user
    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    // Has one medical record
    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class, 'queue_id');
    }
}