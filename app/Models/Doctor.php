<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
    'user_id', // Add this!
    'name',
    'specialization',
    'license_number',
    'assigned_room',
];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}