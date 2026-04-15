<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientQueuePriority extends Model
{
    protected $fillable = [
        'patient_queue_id',
        'priority_type',
        'notes',
        'created_by',
    ];

    public function queue()
    {
        return $this->belongsTo(PatientQueue::class, 'patient_queue_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
