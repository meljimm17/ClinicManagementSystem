<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'specialization',
        'license_number',
        'assigned_room',
    ];

    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}