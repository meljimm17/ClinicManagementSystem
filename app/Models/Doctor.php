<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'specialization',
        'license_number',
    ];

    // A doctor can have many medical records
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}