<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'queue_id', 
        'patient_id', 
        'doctor_id', 
        'doctor_name', 
        'assigned_room', 
        'symptoms', 
        'diagnosis', 
        'prescription', 
        'notes', 
        'record_status', 
        'consultation_date', 
        'consultation_time'
    ];

    public function patient() 
    { 
        return $this->belongsTo(Patient::class); 
    }

    public function doctor() 
    { 
        return $this->belongsTo(Doctor::class); 
    }
}