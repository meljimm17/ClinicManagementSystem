<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CuraSure Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1a2e25; font-size: 12px; }
        .header { border-bottom: 2px solid #1b3d2f; margin-bottom: 18px; padding-bottom: 10px; }
        .title { font-size: 20px; font-weight: bold; margin: 0; color: #1b3d2f; }
        .subtitle { margin: 4px 0 0; color: #6b7f77; }
        .stats { width: 100%; margin: 12px 0 20px; border-collapse: collapse; }
        .stats td { border: 1px solid #e4ece8; padding: 8px; vertical-align: top; }
        .label { font-size: 10px; text-transform: uppercase; color: #6b7f77; }
        .value { font-size: 16px; font-weight: bold; margin-top: 2px; }
        .section-title { font-size: 13px; font-weight: bold; margin: 16px 0 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e4ece8; padding: 7px; text-align: left; }
        th { background: #f4f7f5; font-size: 10px; text-transform: uppercase; color: #1b3d2f; }
        .text-right { text-align: right; }
        .footer { margin-top: 20px; font-size: 10px; color: #6b7f77; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <p class="title">CuraSure Clinical Report</p>
        <p class="subtitle">Generated: {{ ($generatedAt ?? now())->format('F d, Y h:i A') }}</p>
    </div>

    <table class="stats">
        <tr>
            <td>
                <div class="label">Total Patients</div>
                <div class="value">{{ number_format($totalPatients) }}</div>
            </td>
            <td>
                <div class="label">Consultations</div>
                <div class="value">{{ number_format($totalConsultations) }}</div>
            </td>
            <td>
                <div class="label">Avg Wait Time</div>
                <div class="value">{{ $avgWaitMinutes }}m</div>
            </td>
            <td>
                <div class="label">Records Filed (This Month)</div>
                <div class="value">{{ number_format($recordsFiled) }}</div>
            </td>
        </tr>
    </table>

    <div class="section-title">Patient Age Group Distribution</div>
    <table>
        <thead>
            <tr>
                <th>Age Group</th>
                <th class="text-right">Patients</th>
                <th class="text-right">Share</th>
            </tr>
        </thead>
        <tbody>
            @php $demoTotal = collect($demographicsData ?? [])->sum('count'); @endphp
            @forelse(($demographicsData ?? []) as $group)
                @php
                    $count = (int) ($group['count'] ?? 0);
                    $pct = $demoTotal > 0 ? round(($count / $demoTotal) * 100, 1) : 0;
                @endphp
                <tr>
                    <td>{{ $group['label'] ?? 'N/A' }}</td>
                    <td class="text-right">{{ number_format($count) }}</td>
                    <td class="text-right">{{ $pct }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No demographics data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Top Diagnoses</div>
    <table>
        <thead>
            <tr>
                <th>Diagnosis</th>
                <th class="text-right">Cases</th>
                <th class="text-right">Share</th>
            </tr>
        </thead>
        <tbody>
            @forelse($topDiagnoses as $diag)
                @php $pct = round(($diag->total / $diagTotal) * 100, 1); @endphp
                <tr>
                    <td>{{ $diag->diagnosis }}</td>
                    <td class="text-right">{{ number_format($diag->total) }}</td>
                    <td class="text-right">{{ $pct }}%</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No diagnosis data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Doctor Monthly Summary</div>
    <table>
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Specialty</th>
                <th class="text-right">Patients Seen</th>
                <th class="text-right">Avg Consultation Time (min)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($doctorStats as $doctor)
                <tr>
                    <td>{{ $doctor->name ?: ($doctor->user->name ?? 'Unknown Doctor') }}</td>
                    <td>{{ $doctor->specialization ?: 'N/A' }}</td>
                    <td class="text-right">{{ number_format($doctor->patients_seen) }}</td>
                    <td class="text-right">{{ $doctor->consultation_avg !== null ? number_format($doctor->consultation_avg, 1) : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No doctor data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        © {{ now()->year }} CuraSure Central Management
    </div>
</body>
</html>
