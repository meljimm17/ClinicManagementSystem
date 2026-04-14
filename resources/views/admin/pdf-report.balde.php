<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Clinic Report - {{ date('M Y') }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #1a2e25; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1b3d2f; padding-bottom: 10px; }
        .clinic-name { font-size: 24px; font-weight: bold; color: #1b3d2f; margin: 0; }
        .report-title { font-size: 18px; color: #6b7f77; margin: 5px 0; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f4f7f5; color: #1b3d2f; font-size: 12px; text-transform: uppercase; padding: 10px; border: 1px solid #e4ece8; }
        td { padding: 10px; border: 1px solid #e4ece8; font-size: 13px; }
        .text-right { text-align: right; }
        .footer { margin-top: 50px; font-size: 10px; color: #6b7f77; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="clinic-name">CURASURE CLINIC</div>
        <div class="report-title">Monthly Staff Performance Report</div>
        <div>Date Generated: {{ date('F d, Y') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Doctor / Staff</th>
                <th>Specialty</th>
                <th class="text-right">Patients Seen</th>
                <th class="text-right">Avg Duration</th>
                <th class="text-right">Completion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($staffData as $staff)
            <tr>
                <td><strong>{{ $staff->name }}</strong></td>
                <td>{{ $staff->specialty ?? 'General Medicine' }}</td>
                <td class="text-right">{{ $staff->patients_seen ?? 0 }}</td>
                <td class="text-right">{{ $staff->avg_duration ?? 0 }} min</td>
                <td class="text-right">{{ $staff->accuracy_rate ?? 100 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        © {{ date('Y') }} CuraSure Central Management - Confidential Clinical Document
    </div>
</body>
</html>