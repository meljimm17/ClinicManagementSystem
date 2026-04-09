<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'age',
        'gender',
        'contact_number',
        'address',
        'blood_type',
        'height',
        'weight',
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