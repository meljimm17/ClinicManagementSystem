<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportSnapshot extends Model
{
    protected $fillable = [
        'snapshot_date',
        'total_patients',
        'total_consultations',
        'records_filed',
        'avg_wait_minutes',
        'top_diagnoses',
        'doctor_stats',
        'meta',
    ];

    protected $casts = [
        'snapshot_date' => 'date',
        'top_diagnoses' => 'array',
        'doctor_stats' => 'array',
        'meta' => 'array',
    ];
}
