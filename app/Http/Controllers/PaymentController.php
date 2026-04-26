<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PatientQueue;
use App\Models\CheckupType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Show payment list for staff
    public function index(Request $request)
    {
        $date = $request->get('date', today()->toDateString());
        
        $payments = Payment::with(['visit.patient', 'visit.checkupType'])
            ->whereHas('visit', function ($query) use ($date) {
                $query->whereDate('queue_date', $date);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('staff.payments', compact('payments', 'date'));
    }

    // Mark payment as paid
    public function markAsPaid(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_method' => 'nullable|string|max:50',
        ]);

        $payment->update([
            'status' => 'paid',
            'payment_method' => $request->payment_method ?? 'cash',
            'paid_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Payment marked as paid!');
    }

    // Show receipt for printing
    public function showReceipt(Payment $payment)
    {
        $payment->load(['visit.patient', 'visit.checkupType', 'visit.registeredBy']);
        
        return view('staff.receipt', compact('payment'));
    }

    // Get checkup types for AJAX
    public function getCheckupTypes()
    {
        $checkupTypes = CheckupType::active()->orderBy('name')->get();
        return response()->json($checkupTypes);
    }

    // Get fee for a specific checkup type
    public function getFee(CheckupType $checkupType)
    {
        return response()->json([
            'fee' => $checkupType->fee,
            'name' => $checkupType->name,
        ]);
    }
}