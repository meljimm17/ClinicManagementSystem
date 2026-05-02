<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure – Dashboard</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1b3d2f; --sidebar-hover: #254d3c; --sidebar-active: #2e6048;
            --accent: #3d8b6e; --accent-light: #4fa882; --accent-soft: #e8f5f0;
            --text-primary: #1a2e25; --text-muted: #6b7f77; --border: #e4ece8;
            --card-bg: #ffffff; --page-bg: #f4f7f5; --success: #2e8b5e; --danger: #c0392b;
            --badge-live: #1b3d2f;
        }
        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--page-bg); color: var(--text-primary); margin: 0; min-height: 100vh; }
        .sidebar { width: 220px; min-height: 100vh; background: var(--sidebar-bg); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 28px 22px 20px; border-bottom: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; gap: 8px; }
        .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.15rem; color: #fff; }
        .sidebar-nav { flex: 1; padding: 14px 0; }
        .sidebar-link { display: flex; align-items: center; gap: 11px; padding: 10px 22px; color: rgba(255,255,255,.65); text-decoration: none; font-size: .875rem; font-weight: 400; border-left: 3px solid transparent; transition: all .18s; }
        .sidebar-link:hover { background: var(--sidebar-hover); color: #fff; }
        .sidebar-link.active { background: var(--sidebar-active); color: #fff; border-left-color: var(--accent-light); font-weight: 500; }
        .sidebar-link i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-bottom { padding: 16px 16px 24px; border-top: 1px solid rgba(255,255,255,.08); }
        .btn-new-appt { width: 100%; background: var(--accent-light); color: #fff; border: none; border-radius: 8px; padding: 10px 0; font-size: .82rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: background .18s; }
        .btn-new-appt:hover { background: var(--accent); }
        .sidebar-footer { padding: 10px 0 4px; }
        .main-wrap { margin-left: 220px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: rgba(255,255,255,.85); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); padding: 0 32px; height: 58px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-left h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; }
        .topbar-left p { font-size: .75rem; color: var(--text-muted); margin: 2px 0 0; }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .topbar-icon { width: 36px; height: 36px; border-radius: 8px; background: var(--page-bg); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: .95rem; cursor: pointer; transition: background .15s; }
        .topbar-icon:hover { background: var(--accent-soft); color: var(--accent); }
        .avatar { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light)); color: #fff; font-size: .8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .content { padding: 28px 32px 40px; flex: 1; }
        .section-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 22px; }
        .section-title { font-size: 1.35rem; font-weight: 700; }
        .section-sub { font-size: .8rem; color: var(--text-muted); margin-top: 3px; }
        .badge-live { background: var(--badge-live); color: #fff; font-size: .68rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; padding: 5px 12px; border-radius: 20px; display: flex; align-items: center; gap: 6px; }
        .badge-live::before { content: ''; width: 7px; height: 7px; background: #4fce9e; border-radius: 50%; animation: pulse 1.6s ease infinite; }
        @keyframes pulse { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:.5; transform:scale(1.3); } }
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px 22px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 18px rgba(27, 61, 47, 0.06);
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 72px;
            height: 72px;
            border-radius: 0 0 0 64px;
            background: rgba(46, 139, 94, 0.18);
        }
        .stat-card::before {
            content: '';
            position: absolute;
            inset: auto 0 0 0;
            height: 3px;
            background: linear-gradient(90deg, #2d7a50, #4fa882);
            opacity: .8;
        }
        .stat-card.stat-teal { background: linear-gradient(135deg, #edf8f3, #dff1e8); border-color: #b8dccb; }
        .stat-card.stat-mint { background: linear-gradient(135deg, #e8f5f0, #d8ece2); border-color: #abd4c2; }
        .stat-card.stat-sage { background: linear-gradient(135deg, #eef7f2, #e0eee7); border-color: #bfdacc; }
        .stat-link { text-decoration: none; color: inherit; display: block; }
        .stat-link .stat-card { transition: transform .16s ease, box-shadow .2s ease, border-color .2s ease; }
        .stat-link:hover .stat-card { transform: translateY(-3px); box-shadow: 0 14px 24px rgba(27, 61, 47, 0.14); border-color: #9fc9b5; }
        .stat-label { font-size: .68rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #2e6048; margin-bottom: 7px; }
        .stat-value { font-size: 2rem; font-weight: 700; color: #153126; line-height: 1; }
        .stat-meta { font-size: .74rem; color: #4f6d61; margin-top: 7px; }
        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .panel-sub { font-size: .75rem; color: var(--text-muted); }
        .trend-graph-wrap {
            margin-top: 14px;
            background: #f6fbf8;
            border: 1px solid #d7e8df;
            border-radius: 12px;
            padding: 10px 10px 8px;
        }
        .trend-graph {
            width: 100%;
            height: 160px;
            display: block;
        }
        .trend-legend {
            margin-top: 8px;
            display: flex;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
            font-size: .7rem;
            color: #4f6d61;
        }
        .trend-kpi-row { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 10px; margin-top: 12px; }
        .trend-kpi {
            background: #f7fbf9;
            border: 1px solid #d7e8df;
            border-radius: 10px;
            padding: 10px;
        }
        .trend-kpi-label { font-size: .64rem; text-transform: uppercase; letter-spacing: .09em; font-weight: 700; color: #4f6d61; margin-bottom: 4px; }
        .trend-kpi-value { font-size: 1.05rem; font-weight: 700; color: #163428; line-height: 1.1; }
        .trend-kpi-note { font-size: .7rem; color: #5f7e72; margin-top: 3px; }
        .trend-mode-toggle { display: inline-flex; align-items: center; gap: 6px; background: #edf6f1; border: 1px solid #d4e5dc; border-radius: 999px; padding: 4px; }
        .trend-mode-btn {
            border: none;
            background: transparent;
            color: #3f6457;
            font-size: .72rem;
            font-weight: 700;
            border-radius: 999px;
            padding: 5px 12px;
            cursor: pointer;
            transition: all .16s ease;
        }
        .trend-mode-btn.active { background: #2d7a50; color: #fff; box-shadow: 0 4px 10px rgba(45, 122, 80, 0.24); }
        .donut-wrap { display: flex; align-items: center; gap: 18px; margin-top: 10px; flex-wrap: wrap; }
        .donut-chart { width: 180px; height: 180px; display: block; }
        .donut-center-label { font-size: .72rem; fill: #5f7e72; text-anchor: middle; }
        .donut-center-value { font-size: 1.35rem; font-weight: 700; fill: #163428; text-anchor: middle; }
        .donut-legend { display: grid; gap: 8px; min-width: 220px; flex: 1; }
        .donut-legend-item { display: flex; align-items: center; justify-content: space-between; gap: 12px; font-size: .78rem; color: #2a4a3c; }
        .donut-legend-left { display: inline-flex; align-items: center; gap: 8px; }
        .donut-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .donut-legend-value { font-weight: 700; color: #163428; }
        .user-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .user-table thead th { font-size: .68rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); padding: 0 0 10px; border-bottom: 1px solid var(--border); }
        .user-table tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
        .user-table tbody tr:last-child { border-bottom: none; }
        .user-table tbody tr:hover { background: var(--accent-soft); }
        .user-table td { padding: 13px 0; font-size: .845rem; color: var(--text-primary); }
        .user-name { font-weight: 600; }
        .user-role { color: var(--text-muted); font-size: .8rem; }
        .status-badge { display: inline-flex; align-items: center; gap: 5px; font-size: .7rem; font-weight: 600; letter-spacing: .07em; text-transform: uppercase; padding: 3px 10px; border-radius: 20px; }
        .status-active { background: #e5f7ef; color: #1e7a4c; }
        .status-active::before { content: ''; width: 6px; height: 6px; background: #1e7a4c; border-radius: 50%; }
        .status-disabled { background: #f2f2f2; color: #888; }
        .status-disabled::before { content: ''; width: 6px; height: 6px; background: #aaa; border-radius: 50%; }
        .action-btn { background: none; border: 1px solid var(--border); border-radius: 6px; padding: 4px 12px; font-size: .75rem; color: var(--text-muted); cursor: pointer; transition: all .15s; display: inline-flex; align-items: center; justify-content: center; }
        .btn-edit { background-color: var(--accent); border-color: var(--accent); color: white; }
        .btn-edit:hover { filter: brightness(1.1); }
        .bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 90px; margin-top: 20px; }
        .bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 6px; }
        .bar { width: 100%; border-radius: 4px 4px 0 0; transition: opacity .2s; }
        .bar:hover { opacity: .75; }
        .bar-day { font-size: .65rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .06em; }
        .diag-item { margin-bottom: 14px; }
        .diag-header { display: flex; justify-content: space-between; font-size: .8rem; color: var(--text-primary); margin-bottom: 5px; }
        .diag-pct { font-weight: 600; color: var(--text-muted); }
        .diag-bar { height: 6px; background: #e8efeb; border-radius: 10px; overflow: hidden; }
        .diag-fill { height: 100%; background: var(--sidebar-bg); border-radius: 10px; }
        .btn-add-user { background: var(--sidebar-bg); color: #fff; border: none; border-radius: 8px; padding: 8px 18px; font-size: .8rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: background .18s; }
        .btn-add-user:hover { background: var(--accent); }
        .dash-footer { font-size: .7rem; color: var(--text-muted); border-top: 1px solid var(--border); padding: 14px 32px; display: flex; justify-content: space-between; }
        .footer-links a { color: var(--text-muted); text-decoration: none; margin-left: 18px; font-size: .7rem; }
        .footer-links a:hover { color: var(--accent); }
        @media (prefers-reduced-motion: no-preference) {
            @keyframes pageFadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes softRise { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
            body { animation: pageFadeIn .35s ease-out; }
            .stat-chip, .card-panel, .chart-panel, .mini-card, .table-wrap { animation: softRise .35s ease-out both; }
            .btn, button, .sidebar-link, .act-btn, .filter-btn, .patient-name-btn, .topbar-icon {
                transition: transform .16s ease, box-shadow .2s ease, background-color .2s ease, color .2s ease;
            }
            .btn:hover, button:hover, .act-btn:hover, .filter-btn:hover, .topbar-icon:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 16px rgba(27, 61, 47, 0.12);
            }
        }
    </style>
</head>
<body>

<!-- ═══════════════════ SIDEBAR ═══════════════════ -->
<aside class="sidebar">
     <div class="sidebar-brand">
          <img src="{{ asset('img/side_logo.png') }}" alt="CuraSure" style="width:100%; max-width:180px; height:auto; object-fit:contain; border-radius:8px;">
     </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i><span>Admin Dashboard</span>
        </a>
        <a href="{{ route('admin.queue') }}" class="sidebar-link {{ request()->routeIs('admin.queue') ? 'active' : '' }}">
            <i class="bi bi-people"></i><span>Patient Queue</span>
        </a>
        <a href="{{ route('admin.schedule') }}" class="sidebar-link {{ request()->routeIs('admin.schedule') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i><span>Schedule</span>
        </a>
        <a href="{{ route('admin.medical-records') }}" class="sidebar-link {{ request()->routeIs('admin.medical-records') ? 'active' : '' }}">
            <i class="bi bi-journal-medical"></i><span>Medical Records</span>
        </a>
        <a href="{{ route('admin.billing') }}" class="sidebar-link {{ request()->routeIs('admin.billing') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i><span>Billing</span>
        </a>
        <a href="{{ route('admin.checkup-types') }}" class="sidebar-link {{ request()->routeIs('admin.checkup-types') ? 'active' : '' }}">
            <i class="bi bi-tags"></i><span>Check-up Types</span>
        </a>
        <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow"></i><span>Reports</span>
        </a>
        <a href="{{ route('admin.administration') }}" class="sidebar-link {{ request()->routeIs('admin.administration') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i><span>Administration</span>
        </a>
    </nav>
    <div class="sidebar-bottom">
        <button class="btn-new-appt" data-bs-toggle="modal" data-bs-target="#addPatientModal"><i class="bi bi-plus-lg me-1"></i> Add Patient</button>
        <div class="sidebar-footer mt-3">
            <a href="{{ route('support') }}" class="sidebar-link" style="padding:8px 6px;"><i class="bi bi-question-circle"></i> Support</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link" style="background:none; border:none; width:100%; text-align:left;">
                    <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- ═══════════════════ MAIN ═══════════════════ -->
<div class="main-wrap">
    <header class="topbar">
        <div class="topbar-left">
            <h3>System Administration</h3>
            <p>Real-time system health and clinical throughput</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-icon"><i class="bi bi-bell"></i></div>
            <div class="topbar-icon"><i class="bi bi-gear"></i></div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <main class="content">

        <!-- ── Dashboard Overview ── -->
        <div class="section-header">
            <div>
                <div class="section-title">Dashboard Overview</div>
                <div class="section-sub">Real-time system health and clinical throughput.</div>
            </div>
            <span class="badge-live">System Live</span>
        </div>

        <!-- ── Real Stat Cards ── -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <a href="{{ route('admin.queue') }}" class="stat-link" title="Open Patient Queue">
                    <div class="stat-card stat-teal">
                        <div class="stat-label">Total Patients</div>
                        <div class="stat-value">{{ number_format($totalPatients) }}</div>
                        <div class="stat-meta">All registered patients</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.medical-records') }}" class="stat-link" title="Open Medical Records">
                    <div class="stat-card stat-mint">
                        <div class="stat-label">Completed Consultations</div>
                        <div class="stat-value">{{ number_format($completedConsultations) }}</div>
                        <div class="stat-meta">All-time completed records</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.queue') }}" class="stat-link" title="Open Active Queue">
                    <div class="stat-card stat-sage">
                        <div class="stat-label">Active Queue Today</div>
                        <div class="stat-value">{{ $activeQueueCount }}</div>
                        <div class="stat-meta">Waiting or being diagnosed</div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('admin.billing') }}" class="stat-link" title="View Billing">
                    <div class="stat-card" style="background: linear-gradient(135deg, #fff3e0, #ffe0b2); border-color: #ffcc80;">
                        <div class="stat-label" style="color: #e65100;">Today's Revenue</div>
                        <div class="stat-value" style="color: #e65100;">₱{{ number_format($todayRevenue, 2) }}</div>
                        <div class="stat-meta">{{ $todayPaidCount }} paid / {{ $todayUnpaidCount }} pending</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- ── Billing Summary ── -->
        @if($todayPatients > 0)
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card-panel">
                    <div class="panel-title">Patients Today</div>
                    <div class="stat-value" style="font-size: 1.5rem;">{{ $todayPatients }}</div>
                    <div class="panel-sub">Total registered today</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-panel">
                    <div class="panel-title">Paid Today</div>
                    <div class="stat-value" style="font-size: 1.5rem; color: var(--success);">{{ $todayPaidCount }}</div>
                    <div class="panel-sub">Completed payments</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-panel">
                    <div class="panel-title">Most Common Check-up</div>
                    <div class="stat-value" style="font-size: 1.5rem;">{{ $mostCommonCheckupType->name ?? 'N/A' }}</div>
                    <div class="panel-sub">{{ $mostCommonCheckupType ? '₱' . number_format($mostCommonCheckupType->fee, 2) : '' }}</div>
                </div>
            </div>
        </div>
        @endif

        <!-- ── Clinic Statistics Row ── -->
        <div class="row g-3 mb-4">

            <!-- Clinic Throughput Snapshot -->
            <div class="col-md-6">
                <div class="card-panel" style="height:100%;">
                    @php
                        $weekTotal = collect($weekData)->sum('count');
                        $weekAvg = count($weekData) > 0 ? round($weekTotal / count($weekData), 1) : 0;
                        $busiestDay = collect($weekData)->sortByDesc('count')->first();
                        $quietestDay = collect($weekData)->sortBy('count')->first();
                    @endphp
                    <div class="d-flex align-items-start justify-content-between gap-2">
                        <div>
                            <div class="panel-title" id="trendTitle">Clinic Patient Flow (This Week)</div>
                            <div class="panel-sub">Actual daily queue load trend for clinic operations.</div>
                        </div>
                        <div class="trend-mode-toggle" aria-label="Trend range">
                            <button type="button" class="trend-mode-btn active" data-mode="week">This Week</button>
                            <button type="button" class="trend-mode-btn" data-mode="month">This Month</button>
                        </div>
                    </div>

                    <div class="trend-graph-wrap">
                        <svg id="clinicTrendGraph" class="trend-graph" viewBox="0 0 600 160" preserveAspectRatio="none" role="img" aria-label="Patient flow trend graph"></svg>
                        <div class="trend-legend" id="clinicTrendLegend"></div>
                    </div>

                    <div class="trend-kpi-row">
                        <div class="trend-kpi">
                            <div class="trend-kpi-label">Total Visits</div>
                            <div class="trend-kpi-value" id="trendTotalVisits">{{ number_format($weekTotal) }}</div>
                            <div class="trend-kpi-note">Registered queue visits</div>
                        </div>
                        <div class="trend-kpi">
                            <div class="trend-kpi-label">Daily Average</div>
                            <div class="trend-kpi-value" id="trendDailyAverage">{{ $weekAvg }}</div>
                            <div class="trend-kpi-note">Visits per day</div>
                        </div>
                        <div class="trend-kpi">
                            <div class="trend-kpi-label">Peak Load</div>
                            <div class="trend-kpi-value" id="trendPeakDay">{{ $busiestDay['label'] ?? '—' }}</div>
                            <div class="trend-kpi-note"><span id="trendPeakCount">{{ $busiestDay['count'] ?? 0 }}</span> visits</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Common Diagnoses + Patient Demographics -->
            <div class="col-md-6">
                <div class="card-panel" style="height:100%;">
                    <div class="panel-title mb-3">Common Diagnoses</div>
                    @forelse($topDiagnoses as $diag)
                    @php $pct = $diagTotal > 0 ? round(($diag->total / $diagTotal) * 100) : 0; @endphp
                    <div class="diag-item">
                        <div class="diag-header">
                            <span>{{ $diag->diagnosis }}</span>
                            <span class="diag-pct">{{ $pct }}%</span>
                        </div>
                        <div class="diag-bar"><div class="diag-fill" style="width:{{ $pct }}%"></div></div>
                    </div>
                    @empty
                    <p style="color:var(--text-muted); font-size:.845rem;">No diagnosis data yet.</p>
                    @endforelse

                    <hr style="border:none; border-top:1px solid var(--border); margin:16px 0 14px;">
                    <div class="panel-title">Patient Age Group Distribution</div>
                    <div class="panel-sub">Shows which patient group (adult, senior, etc.) is highest.</div>
                    <div class="donut-wrap">
                        <svg id="ageDonutChart" class="donut-chart" viewBox="0 0 180 180" role="img" aria-label="Patient age group donut chart"></svg>
                        <div id="ageDonutLegend" class="donut-legend"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── User Management ── -->
        <div class="card-panel mb-4">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="panel-title">User Management</div>
                    <div class="panel-sub">Staff credentials and access level control</div>
                </div>
                <a href="{{ route('admin.administration') }}" class="btn-add-user">
                    <i class="bi bi-person-plus-fill"></i> Manage Users
                </a>
            </div>

            <table class="user-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $u)
                    <tr>
                        <td>
                            <div class="user-name">{{ $u->name }}</div>
                            <div class="user-role">{{ ucfirst($u->role ?? '—') }}</div>
                        </td>
                        <td><span class="status-badge status-active">{{ ucfirst($u->role ?? '—') }}</span></td>
                        <td style="color:var(--text-muted);font-size:.8rem;">{{ $u->email }}</td>
                        <td>
                            <span class="status-badge {{ ($u->status ?? 'active') === 'active' ? 'status-active' : 'status-disabled' }}">
                                {{ ucfirst($u->status ?? 'active') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center; color:var(--text-muted); padding:24px 0;">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

    <footer class="dash-footer">
        <span>© 2024 CuraSure · Central Management</span>
        <div class="footer-links"><a href="#">Privacy Protocol</a><a href="#">Audit Log</a></div>
    </footer>
</div>

@include('admin.partials.add-patient-modal')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const clinicWeekData = @json($weekData);
    const clinicMonthData = @json($monthData);
    const chart = document.getElementById('clinicTrendGraph');
    const legend = document.getElementById('clinicTrendLegend');
    const title = document.getElementById('trendTitle');
    const totalEl = document.getElementById('trendTotalVisits');
    const avgEl = document.getElementById('trendDailyAverage');
    const peakDayEl = document.getElementById('trendPeakDay');
    const peakCountEl = document.getElementById('trendPeakCount');
    const modeButtons = document.querySelectorAll('.trend-mode-btn');
    const ageDonutData = @json($demographicsData);
    const ageDonutChart = document.getElementById('ageDonutChart');
    const ageDonutLegend = document.getElementById('ageDonutLegend');

    function renderTrend(mode) {
        const sourceData = mode === 'month' ? clinicMonthData : clinicWeekData;
        if (!chart || !Array.isArray(sourceData) || sourceData.length === 0) {
            return;
        }

        title.textContent = mode === 'month' ? 'Clinic Patient Flow (This Month)' : 'Clinic Patient Flow (This Week)';

        const width = 600;
        const height = 160;
        const padX = 24;
        const padY = 16;
        const points = sourceData.map(d => Number(d.count) || 0);
        const max = Math.max(...points, 1);
        const stepX = (width - (padX * 2)) / Math.max(points.length - 1, 1);

        const coords = points.map((value, i) => {
            const x = padX + (i * stepX);
            const y = height - padY - ((value / max) * (height - (padY * 2)));
            return { x, y, value, label: sourceData[i].label };
        });

        const linePoints = coords.map(p => `${p.x},${p.y}`).join(' ');
        const areaPoints = [
            `${coords[0].x},${height - padY}`,
            ...coords.map(p => `${p.x},${p.y}`),
            `${coords[coords.length - 1].x},${height - padY}`
        ].join(' ');

        chart.innerHTML = `
            <defs>
                <linearGradient id="trendFill" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#4fa882" stop-opacity="0.35"></stop>
                    <stop offset="100%" stop-color="#4fa882" stop-opacity="0.04"></stop>
                </linearGradient>
            </defs>
            <line x1="${padX}" y1="${height - padY}" x2="${width - padX}" y2="${height - padY}" stroke="#c8ddd2" stroke-width="1"></line>
            <polygon points="${areaPoints}" fill="url(#trendFill)"></polygon>
            <polyline points="${linePoints}" fill="none" stroke="#2d7a50" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></polyline>
            ${coords.map(p => `<circle cx="${p.x}" cy="${p.y}" r="4" fill="#1b3d2f"></circle>`).join('')}
        `;

        const peak = sourceData.reduce((best, day) => ((day.count || 0) > (best.count || 0) ? day : best), sourceData[0]);
        const total = sourceData.reduce((sum, day) => sum + (Number(day.count) || 0), 0);
        const average = sourceData.length ? (total / sourceData.length) : 0;

        totalEl.textContent = total.toLocaleString();
        avgEl.textContent = average.toFixed(1);
        peakDayEl.textContent = peak?.label || '—';
        peakCountEl.textContent = String(peak?.count || 0);

        const legendItems = mode === 'month'
            ? [coords[0], coords[Math.floor(coords.length / 2)], coords[coords.length - 1]]
            : coords;
        legend.innerHTML = legendItems.map(p => `<span><strong>${p.label}</strong>: ${p.value}</span>`).join('');
    }

    modeButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            modeButtons.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
            renderTrend(btn.dataset.mode);
        });
    });

    function renderAgeDonut() {
        if (!ageDonutChart || !Array.isArray(ageDonutData) || ageDonutData.length === 0) {
            return;
        }

        const palette = ['#2d7a50', '#4fa882', '#7fc6a6', '#b7dfcb'];
        const total = ageDonutData.reduce((sum, item) => sum + (Number(item.count) || 0), 0);
        const safeTotal = total > 0 ? total : 1;
        const cx = 90;
        const cy = 90;
        const r = 60;
        const stroke = 22;
        const circumference = 2 * Math.PI * r;

        let offset = 0;
        const rings = ageDonutData.map((item, idx) => {
            const value = Number(item.count) || 0;
            const arc = (value / safeTotal) * circumference;
            const ring = `<circle cx="${cx}" cy="${cy}" r="${r}" fill="none" stroke="${palette[idx % palette.length]}" stroke-width="${stroke}" stroke-linecap="butt" stroke-dasharray="${arc} ${circumference - arc}" stroke-dashoffset="${-offset}" transform="rotate(-90 ${cx} ${cy})"></circle>`;
            offset += arc;
            return ring;
        }).join('');

        ageDonutChart.innerHTML = `
            <circle cx="${cx}" cy="${cy}" r="${r}" fill="none" stroke="#e3efe9" stroke-width="${stroke}"></circle>
            ${rings}
            <text x="${cx}" y="${cy - 3}" class="donut-center-value">${total.toLocaleString()}</text>
            <text x="${cx}" y="${cy + 16}" class="donut-center-label">Total Patients</text>
        `;

        const topGroup = ageDonutData.reduce((best, item) => ((item.count || 0) > (best.count || 0) ? item : best), ageDonutData[0]);
        ageDonutLegend.innerHTML = ageDonutData.map((item, idx) => {
            const value = Number(item.count) || 0;
            const pct = Math.round((value / safeTotal) * 100);
            const isTop = topGroup?.label === item.label;
            return `<div class="donut-legend-item">
                <div class="donut-legend-left"><span class="donut-dot" style="background:${palette[idx % palette.length]}"></span><span>${item.label}${isTop ? ' (Most)' : ''}</span></div>
                <span class="donut-legend-value">${value} (${pct}%)</span>
            </div>`;
        }).join('');
    }

    renderAgeDonut();
    renderTrend('week');
</script>
</body>
</html>