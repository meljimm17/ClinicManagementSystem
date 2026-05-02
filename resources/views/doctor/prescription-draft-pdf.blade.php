<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescription Draft</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm;
        }
        html, body {
            width: 100%;
            height: 100%;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1a2e25;
            font-size: 12px;
            margin: 0;
        }
        .header { border-bottom: 2px solid #1b3d2f; margin-bottom: 16px; padding-bottom: 10px; }
        .title { font-size: 20px; font-weight: 700; margin: 0; color: #1b3d2f; }
        .meta { margin-top: 4px; color: #6b7f77; font-size: 11px; }
        .grid { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        .grid td { width: 50%; padding: 6px 0; vertical-align: top; }
        .label { font-size: 10px; text-transform: uppercase; color: #6b7f77; letter-spacing: 0.08em; margin-bottom: 2px; }
        .value { font-size: 13px; font-weight: 600; }
        .section { margin-bottom: 12px; }
        .box {
            border: 1px solid #dfe8e3;
            border-radius: 4px;
            min-height: 56px;
            padding: 8px 10px;
            white-space: pre-wrap;
            line-height: 1.5;
        }
        .footer { margin-top: 16px; font-size: 10px; color: #6b7f77; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <p class="title">CuraSure Prescription</p>
        <p class="meta">Generated: {{ ($generatedAt ?? now())->format('F d, Y h:i A') }}</p>
    </div>

    <table class="grid">
        <tr>
            <td>
                <div class="label">Patient</div>
                <div class="value">{{ $patientName ?? 'N/A' }}</div>
            </td>
            <td>
                <div class="label">Doctor</div>
                <div class="value">Dr. {{ $doctorName ?? 'N/A' }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label">Consultation Date</div>
                <div class="value">{{ $consultationDate ?? 'N/A' }}</div>
            </td>
            <td>
                <div class="label">Consultation Time</div>
                <div class="value">{{ $consultationTime ?? 'N/A' }}</div>
            </td>
        </tr>
    </table>

    <div class="section">
        <div class="label">Symptoms</div>
        <div class="box">{{ $symptoms ?: 'None recorded.' }}</div>
    </div>

    <div class="section">
        <div class="label">Diagnosis</div>
        <div class="box">{{ $diagnosis ?: 'None recorded.' }}</div>
    </div>

    <div class="section">
        <div class="label">Prescription / Treatment Plan</div>
        <div class="box">{{ $prescription ?: 'None recorded.' }}</div>
    </div>

    <div class="section">
        <div class="label">Additional Notes</div>
        <div class="box">{{ $notes ?: 'None recorded.' }}</div>
    </div>

    <div class="section" style="margin-top: 18px;">
        <div style="display: flex; justify-content: flex-end; gap: 40px; align-items: flex-end;">
            <div style="text-align: center; width: 45%;">
                <div style="border-bottom: 1px solid #6b7f77; height: 1px; margin-bottom: 8px;"></div>
                <div style="font-size: 11px; color: #6b7f77;">Doctor Signature</div>
                <div style="font-size: 12px; font-weight: 700; margin-top: 6px;">Dr. {{ $doctorName ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <div class="footer">
        This PDF was generated from the diagnosis panel before final record submission.
    </div>
</body>
</html>
