<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - CuraSure Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; padding: 0; }
            .receipt-container { box-shadow: none; border: none; }
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .receipt-container {
            background: white;
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed #dee2e6;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .clinic-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1b3d2f;
            margin-bottom: 5px;
        }
        .clinic-address {
            font-size: 0.8rem;
            color: #6c757d;
        }
        .receipt-title {
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            color: #1b3d2f;
            margin-bottom: 20px;
            padding: 8px;
            background: #e8f5f0;
            border-radius: 6px;
        }
        .receipt-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .receipt-row:last-child {
            border-bottom: none;
        }
        .receipt-label {
            color: #6c757d;
            font-size: 0.85rem;
        }
        .receipt-value {
            font-weight: 600;
            color: #212529;
            font-size: 0.9rem;
        }
        .total-row {
            background: #1b3d2f;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        .total-row .receipt-label {
            color: rgba(255,255,255,0.8);
        }
        .total-row .receipt-value {
            color: white;
            font-size: 1.2rem;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px dashed #dee2e6;
            font-size: 0.75rem;
            color: #6c757d;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-paid {
            background: #d1e7dd;
            color: #0f5132;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <div class="clinic-name"><i class="bi bi-shield-plus me-2"></i>CuraSure Clinic</div>
            <div class="clinic-address">123 Health Street, Davao City</div>
            <div class="clinic-address">Tel: (082) 123-4567</div>
        </div>

        <div class="receipt-title">
            <i class="bi bi-receipt me-2"></i>OFFICIAL RECEIPT
        </div>

        <div class="receipt-row">
            <span class="receipt-label">Receipt No.</span>
            <span class="receipt-value">RCPT-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>

        <div class="receipt-row">
            <span class="receipt-label">Date</span>
            <span class="receipt-value">{{ \Carbon\Carbon::parse($payment->created_at)->format('F d, Y') }}</span>
        </div>

        <div class="receipt-row">
            <span class="receipt-label">Time</span>
            <span class="receipt-value">{{ \Carbon\Carbon::parse($payment->created_at)->format('h:i A') }}</span>
        </div>

        <div class="receipt-row">
            <span class="receipt-label">Queue No.</span>
            <span class="receipt-value">{{ $payment->visit->display_queue_number ?? 'N/A' }}</span>
        </div>

        <div class="receipt-row">
            <span class="receipt-label">Patient Name</span>
            <span class="receipt-value">{{ $payment->visit->patient_name ?? $payment->visit->patient->name ?? 'N/A' }}</span>
        </div>

        <div class="receipt-row">
            <span class="receipt-label">Check-up Type</span>
            <span class="receipt-value">{{ $payment->visit->checkupType->name ?? 'N/A' }}</span>
        </div>

        <div class="receipt-row">
            <span class="receipt-label">Staff</span>
            <span class="receipt-value">{{ $payment->visit->registeredBy->name ?? 'N/A' }}</span>
        </div>

        <div class="total-row">
            <div class="receipt-row" style="margin: 0; border: none;">
                <span class="receipt-label">Amount Paid</span>
                <span class="receipt-value">₱{{ number_format($payment->amount, 2) }}</span>
            </div>
        </div>

        <div class="receipt-row" style="margin-top: 10px;">
            <span class="receipt-label">Payment Method</span>
            <span class="receipt-value">{{ ucfirst($payment->payment_method ?? 'Cash') }}</span>
        </div>

        <div class="receipt-row">
            <span class="receipt-label">Status</span>
            <span class="status-badge status-paid">
                <i class="bi bi-check-circle me-1"></i>{{ ucfirst($payment->status) }}
            </span>
        </div>

        <div class="receipt-footer">
            <p>Thank you for choosing CuraSure Clinic!</p>
            <p>Please keep this receipt for your records.</p>
            <p class="mb-0">Generated on {{ now()->format('F d, Y g:i A') }}</p>
        </div>

        <div class="text-center mt-4 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer me-2"></i>Print Receipt
            </button>
            <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-secondary ms-2">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>
</body>
</html>