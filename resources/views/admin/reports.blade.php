<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure - Reports</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1b3d2f; --sidebar-hover: #254d3c; --sidebar-active: #2e6048;
            --accent: #3d8b6e; --accent-light: #4fa882; --accent-soft: #e8f5f0;
            --text-primary: #1a2e25; --text-muted: #6b7f77; --border: #e4ece8;
            --card-bg: #ffffff; --page-bg: #f4f7f5; --success: #2e8b5e;
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
        .btn-logout { display: flex; align-items: center; gap: 10px; width: 100%; background: none; border: none; padding: 8px 6px; color: rgba(255,255,255,.65); font-size: .82rem; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all .18s; text-align: left; }
        .btn-logout:hover { background: var(--sidebar-hover); color: #fff; }
        .btn-logout i { font-size: 1rem; width: 18px; text-align: center; }
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

        /* Stat cards */
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
        .stat-card.stat-leaf { background: linear-gradient(135deg, #e6f4ed, #d4eadd); border-color: #9fc9b5; }
        .stat-card.stat-gold { background: linear-gradient(135deg, #fef7e0, #fdf2c7); border-color: #f5e6a3; }
        .stat-card.stat-orange { background: linear-gradient(135deg, #fef2e8, #fde4d1); border-color: #fac5a1; }
        .stat-card.stat-emerald { background: linear-gradient(135deg, #e0f5ea, #c7f0d7); border-color: #9fdfb5; }
        .stat-label { font-size: .68rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #2e6048; margin-bottom: 7px; }
        .stat-value { font-size: 2rem; font-weight: 700; color: #153126; line-height: 1; }
        .stat-meta { font-size: .74rem; color: #4f6d61; margin-top: 7px; }
        .stat-up { color: var(--success); font-weight: 600; }

        /* Card panel */
        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .panel-sub { font-size: .75rem; color: var(--text-muted); }
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
        .trend-graph-wrap {
            margin-top: 12px;
            background: #f6fbf8;
            border: 1px solid #d7e8df;
            border-radius: 12px;
            padding: 10px 10px 8px;
        }
        .trend-graph { width: 100%; height: 160px; display: block; }
        .trend-legend {
            margin-top: 8px;
            display: flex;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
            font-size: .7rem;
            color: #4f6d61;
        }

        /* Bar chart */
        .bar-chart { display: flex; align-items: flex-end; gap: 8px; height: 120px; margin-top: 20px; }
        .bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; }
        .bar { width: 100%; background: var(--sidebar-bg); border-radius: 4px 4px 0 0; transition: opacity .2s; min-height: 4px; }
        .bar:hover { opacity: .75; }
        .bar-day { font-size: .63rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .06em; }

        /* Diagnoses */
        .diag-item { margin-bottom: 14px; }
        .diag-header { display: flex; justify-content: space-between; font-size: .8rem; color: var(--text-primary); margin-bottom: 5px; }
        .diag-pct { font-weight: 600; color: var(--text-muted); }
        .diag-bar { height: 6px; background: #e8efeb; border-radius: 10px; overflow: hidden; }
        .diag-fill { height: 100%; background: var(--sidebar-bg); border-radius: 10px; }
        .donut-wrap { display: flex; align-items: center; gap: 18px; margin-top: 10px; flex-wrap: wrap; }
        .donut-chart { width: 170px; height: 170px; display: block; }
        .donut-center-label { font-size: .7rem; fill: #5f7e72; text-anchor: middle; }
        .donut-center-value { font-size: 1.25rem; font-weight: 700; fill: #163428; text-anchor: middle; }
        .donut-legend { display: grid; gap: 8px; min-width: 210px; flex: 1; }
        .donut-legend-item { display: flex; align-items: center; justify-content: space-between; gap: 12px; font-size: .76rem; color: #2a4a3c; }
        .donut-legend-left { display: inline-flex; align-items: center; gap: 8px; }
        .donut-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .donut-legend-value { font-weight: 700; color: #163428; }

        /* Report table */
        .report-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .report-table thead th { font-size: .68rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); padding: 0 0 10px; border-bottom: 1px solid var(--border); }
        .report-table tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
        .report-table tbody tr:last-child { border-bottom: none; }
        .report-table tbody tr:hover { background: var(--accent-soft); }
        .report-table td { padding: 12px 0; font-size: .845rem; color: var(--text-primary); }

        /* Filter row */
        .filter-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .filter-select { border: 1px solid var(--border); border-radius: 8px; padding: 8px 14px; font-size: .83rem; font-family: 'DM Sans', sans-serif; color: var(--text-primary); background: var(--page-bg); outline: none; cursor: pointer; }
        .filter-select:focus { border-color: var(--accent); }
        .btn-export { background: var(--sidebar-bg); color: #fff; border: none; border-radius: 8px; padding: 9px 18px; font-size: .8rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: background .18s; }
        .btn-export:hover { background: var(--accent); }

        .dash-footer { font-size: .7rem; color: var(--text-muted); border-top: 1px solid var(--border); padding: 14px 32px; display: flex; justify-content: space-between; }
        .footer-links a { color: var(--text-muted); text-decoration: none; margin-left: 18px; font-size: .7rem; }
        .footer-links a:hover { color: var(--accent); }
        @media (prefers-reduced-motion: no-preference) {
            @keyframes pageFadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes softRise { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
            body { animation: pageFadeIn .35s ease-out; }
            .stat-card, .card-panel, .chart-panel { animation: softRise .35s ease-out both; }
            .btn, button, .sidebar-link, .act-btn, .filter-btn, .topbar-icon {
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
            <h3>Reports</h3>
            <p>Clinical and operational analytics</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-icon"><i class="bi bi-bell"></i></div>
            <div class="topbar-icon"><i class="bi bi-gear"></i></div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <main class="content">

        <div class="section-header" style="align-items:flex-end; gap:16px;">
            <div>
                <div class="section-title">Analytics & Reports</div>
                <div class="section-sub">Report period: {{ $reportPeriodLabel ?? 'This Month' }}.</div>
            </div>
            <form method="GET" action="{{ route('admin.reports') }}" class="filter-row" style="margin:0;">
                <label>
                    <span class="visually-hidden">Period</span>
                    <select name="period" class="filter-select" onchange="const dateInput = document.getElementById('report-date'); if (this.value === 'year') { dateInput.type = 'number'; dateInput.placeholder = 'YYYY'; } else { dateInput.type = 'date'; dateInput.placeholder = 'YYYY-MM-DD'; }">
                        <option value="month" {{ request('period', 'month') === 'month' ? 'selected' : '' }}>Month</option>
                        <option value="day" {{ request('period') === 'day' ? 'selected' : '' }}>Day</option>
                        <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Year</option>
                    </select>
                </label>
                <label>
                    <span class="visually-hidden">Date</span>
                    <input id="report-date" name="date" class="filter-select" type="{{ request('period', 'month') === 'year' ? 'number' : 'date' }}" placeholder="{{ request('period', 'month') === 'year' ? 'YYYY' : 'YYYY-MM-DD' }}" value="{{ request('date', now()->format(request('period', 'month') === 'year' ? 'Y' : 'Y-m-d')) }}" />
                </label>
                <button type="submit" class="btn-export" style="padding:9px 14px;">Apply</button>
            </form>
            <a href="{{ route('admin.reports.export', request()->only('period', 'date')) }}" class="btn-export">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card stat-teal">
                    <div class="stat-label">Total Patients</div>
                    <div class="stat-value">{{ number_format($totalPatients) }}</div>
                    <div class="stat-meta">Registered in system</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card stat-mint">
                    <div class="stat-label">Consultations</div>
                    <div class="stat-value">{{ number_format($totalConsultations) }}</div>
                    <div class="stat-meta">Completed consultations</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card stat-sage">
                    <div class="stat-label">Avg Wait Time</div>
                    <div class="stat-value">{{ $avgWaitMinutes }}m</div>
                    <div class="stat-meta">Queue to call time</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card stat-leaf">
                    <div class="stat-label">Records Filed</div>
                    <div class="stat-value">{{ number_format($recordsFiled) }}</div>
                    <div class="stat-meta">For selected period</div>
                </div>
            </div>
        </div>

        <!-- Revenue Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card stat-gold">
                    <div class="stat-label">Revenue</div>
                    <div class="stat-value">₱{{ number_format($monthlyRevenue, 2) }}</div>
                    <div class="stat-meta">Paid in selected period</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card stat-orange">
                    <div class="stat-label">Pending Payments</div>
                    <div class="stat-value">₱{{ number_format($monthlyPending, 2) }}</div>
                    <div class="stat-meta">Outstanding in selected period</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card stat-emerald">
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value">₱{{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-meta">Collected in selected period</div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card-panel" style="height:100%;">
                    <div class="d-flex align-items-start justify-content-between gap-2">
                        <div>
                            <div class="panel-title" id="trendTitle">Daily Patient Volume (This Week)</div>
                            <div class="panel-sub">Queue traffic for operational planning.</div>
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
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-panel" style="height:100%;">
                    <div class="panel-title mb-3">Common Diagnoses</div>
                    @forelse($topDiagnoses as $item)
                        @php $pct = round(($item->total / $diagTotal) * 100, 1); @endphp
                        <div class="diag-item" @if($loop->last) style="margin-bottom:0;" @endif>
                            <div class="diag-header">
                                <span>{{ $item->diagnosis }}</span>
                                <span class="diag-pct">{{ $pct }}%</span>
                            </div>
                            <div class="diag-bar"><div class="diag-fill" style="width:{{ $pct }}%"></div></div>
                        </div>
                    @empty
                        <div class="panel-sub">No diagnosis data available yet.</div>
                    @endforelse

                    <hr style="border:none; border-top:1px solid var(--border); margin:16px 0 14px;">
                    <div class="panel-title">Patient Age Group Distribution</div>
                    <div class="panel-sub">Most frequent age group in registered patients.</div>
                    <div class="donut-wrap">
                        <svg id="ageDonutChart" class="donut-chart" viewBox="0 0 180 180" role="img" aria-label="Patient age group donut chart"></svg>
                        <div id="ageDonutLegend" class="donut-legend"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Breakdown -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card-panel">
                    <div class="panel-title mb-3">Revenue by Check-up Type</div>
                    <div class="panel-sub">Earnings breakdown for selected period.</div>
                    @forelse($revenueByType as $item)
                        @php $totalRev = $revenueByType->sum('revenue'); $pct = $totalRev > 0 ? round(($item->revenue / $totalRev) * 100, 1) : 0; @endphp
                        <div class="diag-item" @if($loop->last) style="margin-bottom:0;" @endif>
                            <div class="diag-header">
                                <span>{{ $item->name }}</span>
                                <span class="diag-pct">₱{{ number_format($item->revenue, 2) }}</span>
                            </div>
                            <div class="diag-bar"><div class="diag-fill" style="width:{{ $pct }}%"></div></div>
                        </div>
                    @empty
                        <div class="panel-sub">No revenue data available yet.</div>
                    @endforelse
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-panel">
                    <div class="panel-title mb-3">Payment Status Overview</div>
                    <div class="panel-sub">Current payment collection status.</div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-card stat-gold" style="margin-bottom:0;">
                                <div class="stat-label">Paid in Period</div>
                                <div class="stat-value">₱{{ number_format($monthlyRevenue, 2) }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card stat-orange" style="margin-bottom:0;">
                                <div class="stat-label">Pending in Period</div>
                                <div class="stat-value">₱{{ number_format($monthlyPending, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="panel-sub">Collection Rate: {{ $monthlyRevenue + $monthlyPending > 0 ? round(($monthlyRevenue / ($monthlyRevenue + $monthlyPending)) * 100, 1) : 0 }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Table -->
        <div class="card-panel">
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <div>
                    <div class="panel-title">{{ $reportPeriodLabel ?? 'Selected Period Summary' }}</div>
                    <div class="panel-sub">Breakdown by doctor and department</div>
                </div>
            </div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Specialty</th>
                        <th>Patients Seen</th>
                        <th>Avg Consultation Time (min)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalSeen = $doctorStats->sum('patients_seen');
                        $avgDurationAll = $doctorStats->pluck('consultation_avg')->filter(fn($v) => $v !== null)->avg();
                    @endphp
                    @forelse($doctorStats as $doctor)
                        <tr>
                            <td><strong>{{ $doctor->name ?: ($doctor->user->name ?? 'Unknown Doctor') }}</strong></td>
                            <td style="color:var(--text-muted);">{{ $doctor->specialization ?: 'N/A' }}</td>
                            <td>{{ number_format($doctor->patients_seen) }}</td>
                            <td>{{ $doctor->consultation_avg !== null ? number_format($doctor->consultation_avg, 1) : 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted">No doctor data available.</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td style="font-weight:700;">Total</td>
                        <td></td>
                        <td style="font-weight:700;">{{ number_format($totalSeen) }}</td>
                        <td style="font-weight:700;">{{ $avgDurationAll ? number_format($avgDurationAll, 1) : 'N/A' }}</td>
                    </tr>
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
    const weekData = @json($weekData);
    const monthData = @json($monthData);
    const chartData = { week: weekData, month: monthData };
    const chart = document.getElementById('clinicTrendGraph');
    const legend = document.getElementById('clinicTrendLegend');
    const trendTitle = document.getElementById('trendTitle');
    const modeButtons = document.querySelectorAll('.trend-mode-btn');

    function renderTrendChart(mode) {
        const source = chartData[mode] || [];
        if (!chart || !legend || source.length === 0) return;
        trendTitle.textContent = mode === 'month' ? 'Daily Patient Volume (This Month)' : 'Daily Patient Volume (This Week)';

        const width = 600;
        const height = 160;
        const padX = 24;
        const padY = 16;
        const points = source.map(d => Number(d.count) || 0);
        const max = Math.max(...points, 1);
        const stepX = (width - (padX * 2)) / Math.max(points.length - 1, 1);

        const coords = points.map((value, i) => {
            const x = padX + (i * stepX);
            const y = height - padY - ((value / max) * (height - (padY * 2)));
            return { x, y, value, label: source[i].label };
        });

        const linePoints = coords.map(p => `${p.x},${p.y}`).join(' ');
        const areaPoints = [
            `${coords[0].x},${height - padY}`,
            ...coords.map(p => `${p.x},${p.y}`),
            `${coords[coords.length - 1].x},${height - padY}`
        ].join(' ');

        chart.innerHTML = `
            <defs>
                <linearGradient id="trendFillReport" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#4fa882" stop-opacity="0.35"></stop>
                    <stop offset="100%" stop-color="#4fa882" stop-opacity="0.04"></stop>
                </linearGradient>
            </defs>
            <line x1="${padX}" y1="${height - padY}" x2="${width - padX}" y2="${height - padY}" stroke="#c8ddd2" stroke-width="1"></line>
            <polygon points="${areaPoints}" fill="url(#trendFillReport)"></polygon>
            <polyline points="${linePoints}" fill="none" stroke="#2d7a50" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></polyline>
            ${coords.map(p => `<circle cx="${p.x}" cy="${p.y}" r="4" fill="#1b3d2f"></circle>`).join('')}
        `;

        const legendItems = mode === 'month'
            ? [coords[0], coords[Math.floor(coords.length / 2)], coords[coords.length - 1]]
            : coords;
        legend.innerHTML = legendItems.map(p => `<span><strong>${p.label}</strong>: ${p.value}</span>`).join('');
    }

    modeButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            modeButtons.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
            renderTrendChart(btn.dataset.mode);
        });
    });

    const ageDonutData = @json($demographicsData);
    const ageDonutChart = document.getElementById('ageDonutChart');
    const ageDonutLegend = document.getElementById('ageDonutLegend');

    function renderAgeDonut() {
        if (!ageDonutChart || !Array.isArray(ageDonutData) || ageDonutData.length === 0) return;
        const palette = ['#2d7a50', '#4fa882', '#7fc6a6', '#b7dfcb'];
        const total = ageDonutData.reduce((sum, item) => sum + (Number(item.count) || 0), 0);
        const safeTotal = total > 0 ? total : 1;
        const cx = 90, cy = 90, r = 60, stroke = 22;
        const circumference = 2 * Math.PI * r;

        let offset = 0;
        const rings = ageDonutData.map((item, idx) => {
            const value = Number(item.count) || 0;
            const arc = (value / safeTotal) * circumference;
            const ring = `<circle cx="${cx}" cy="${cy}" r="${r}" fill="none" stroke="${palette[idx % palette.length]}" stroke-width="${stroke}" stroke-dasharray="${arc} ${circumference - arc}" stroke-dashoffset="${-offset}" transform="rotate(-90 ${cx} ${cy})"></circle>`;
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

    renderTrendChart('week');
    renderAgeDonut();
</script>
</body>
</html>