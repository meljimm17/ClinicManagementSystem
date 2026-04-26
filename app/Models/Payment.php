<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'visit_id',
        'amount',
        'status',
        'payment_method',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // A payment belongs to a queue visit
    public function visit()
    {
        return $this->belongsTo(PatientQueue::class, 'visit_id');
    }

    // Get the associated patient through visit
    public function patient()
    {
        return $this->visit->patient ?? null;
    }

    // Scope for unpaid payments
    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    // Scope for paid payments
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // Scope for today's payments
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Check if payment is completed
    public function isPaid(): bool
    {
        return in_array($this->status, ['paid', 'partial']);
    }

    // Mark as paid
    public function markAsPaid(string $method = 'cash'): bool
    {
        $this->status = 'paid';
        $this->payment_method = $method;
        $this->paid_at = now();
        return $this->save();
    }
}