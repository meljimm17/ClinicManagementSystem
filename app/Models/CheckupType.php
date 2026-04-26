<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckupType extends Model
{
    protected $table = 'checkup_types';

    protected $fillable = [
        'name',
        'fee',
        'is_active',
    ];

    protected $casts = [
        'fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // A checkup type can be associated with many queue visits
    public function queueVisits()
    {
        return $this->hasMany(PatientQueue::class, 'checkup_type_id');
    }

    // Scope to get only active checkup types
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}