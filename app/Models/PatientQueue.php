<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientQueue extends Model
{
    use SoftDeletes;

    protected $table = 'patient_queue';

    protected $fillable = [
        'queue_number',
        'queue_date',
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

    public function priority()
    {
        return $this->hasOne(PatientQueuePriority::class, 'patient_queue_id');
    }

    public function getDisplayQueueNumberAttribute(): string
    {
        $queueNumber = (string) ($this->queue_number ?? '');

        // Hide legacy date prefixes like 20260414-001 or 20260414Q-001.
        return preg_replace('/^\d{8}[-_]?/', '', $queueNumber) ?: $queueNumber;
    }
}