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
        'patient_name', // ✅ ADDED - allows snapshot name to be saved
        'registered_by',
        'symptoms',
        'status',
        'assigned_room',
        'queued_at',
        'called_at',
        'completed_at',
        'checkup_type_id',
        'custom_fee',
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

    // Belongs to a checkup type
    public function checkupType()
    {
        return $this->belongsTo(CheckupType::class, 'checkup_type_id');
    }

    // Has one payment record
    public function payment()
    {
        return $this->hasOne(Payment::class, 'visit_id');
    }

    // Get the effective fee (custom fee takes precedence)
    public function getEffectiveFeeAttribute(): float
    {
        if ($this->custom_fee !== null) {
            return (float) $this->custom_fee;
        }
        
        if ($this->checkupType) {
            return (float) $this->checkupType->fee;
        }
        
        return 0;
    }

    public function getDisplayQueueNumberAttribute(): string
    {
        $queueNumber = (string) ($this->queue_number ?? '');

        // Hide legacy date prefixes like 20260414-001 or 20260414Q-001.
        return preg_replace('/^\d{8}[-_]?/', '', $queueNumber) ?: $queueNumber;
    }
}