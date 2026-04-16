<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Record #{{ $record->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #1a2e25;
            margin: 24px;
            line-height: 1.45;
        }
        .header {
            border-bottom: 2px solid #1b3d2f;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        .meta {
            color: #4d5f57;
            font-size: 13px;
            margin-top: 6px;
        }
        .section {
            margin-bottom: 14px;
        }
        .label {
            font-size: 12px;
            color: #6b7f77;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 4px;
        }
        .value {
            border: 1px solid #d6e3dd;
            border-radius: 6px;
            padding: 9px 10px;
            white-space: pre-wrap;
            min-height: 18px;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .footer {
            margin-top: 24px;
            font-size: 12px;
            color: #6b7f77;
            border-top: 1px solid #e4ece8;
            padding-top: 8px;
        }
        @media print {
            body { margin: 12mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    @php
        $patient = $record->queue?->patient;
    @endphp

    <div class="header">
        <h1>CuraSure Prescription Record</h1>
        <div class="meta">
            Record #{{ $record->id }} |
            Printed: {{ ($generatedAt ?? now())->format('M d, Y h:i A') }}
        </div>
    </div>

    <div class="section grid">
        <div>
            <div class="label">Patient Name</div>
            <div class="value">{{ $patient?->name ?? 'N/A' }}</div>
        </div>
        <div>
            <div class="label">Doctor</div>
            <div class="value">Dr. {{ $record->doctor?->name ?? ($record->doctor?->user?->name ?? 'N/A') }}</div>
        </div>
    </div>

    <div class="section grid">
        <div>
            <div class="label">Consultation Date</div>
            <div class="value">{{ $record->consultation_date ? \Carbon\Carbon::parse($record->consultation_date)->format('M d, Y') : 'N/A' }}</div>
        </div>
        <div>
            <div class="label">Consultation Time</div>
            <div class="value">{{ $record->consultation_time ? \Carbon\Carbon::parse($record->consultation_time)->format('h:i A') : 'N/A' }}</div>
        </div>
    </div>

    <div class="section">
        <div class="label">Symptoms</div>
        <div class="value">{{ $record->symptoms ?: 'None recorded.' }}</div>
    </div>

    <div class="section">
        <div class="label">Diagnosis</div>
        <div class="value">{{ $record->diagnosis ?: 'None recorded.' }}</div>
    </div>

    <div class="section">
        <div class="label">Prescription / Treatment Plan</div>
        <div class="value">{{ $record->prescription ?: 'None recorded.' }}</div>
    </div>

    <div class="section">
        <div class="label">Additional Notes</div>
        <div class="value">{{ $record->notes ?: 'None recorded.' }}</div>
    </div>

    <div class="footer">
        This document is generated from CuraSure doctor records.
    </div>

    <script>
        window.addEventListener('load', () => window.print());
    </script>
</body>
</html>
