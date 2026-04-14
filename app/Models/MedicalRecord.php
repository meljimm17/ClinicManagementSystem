<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'queue_id', 
        'doctor_id', 
        'symptoms', 
        'diagnosis', 
        'prescription', 
        'notes', 
        'record_status', 
        'consultation_date', 
        'consultation_time'
    ];

    public function doctor() 
    { 
        return $this->belongsTo(Doctor::class); 
    }

    public function queue()
    {
        return $this->belongsTo(PatientQueue::class, 'queue_id');
    }
}