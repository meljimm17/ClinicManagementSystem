<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure – Reports</title>
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
        .sidebar-brand { padding: 28px 22px 20px; border-bottom: 1px solid rgba(255,255,255,.08); }
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
        .stat-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .stat-label { font-size: .72rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px; }
        .stat-value { font-size: 2.1rem; font-weight: 700; color: var(--text-primary); line-height: 1; }
        .stat-meta { font-size: .75rem; color: var(--text-muted); margin-top: 6px; }
        .stat-up { color: var(--success); font-weight: 600; }

        /* Card panel */
        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .panel-sub { font-size: .75rem; color: var(--text-muted); }

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
    </style>
</head>
<body>

<!-- ═══════════════════ SIDEBAR ═══════════════════ -->
<aside class="sidebar">
    <div class="sidebar-brand"><div class="brand-name">CuraSure</div></div>
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
        <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow"></i><span>Reports</span>
        </a>
        <a href="{{ route('admin.administration') }}" class="sidebar-link {{ request()->routeIs('admin.administration') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i><span>Administration</span>
        </a>
    </nav>
    <div class="sidebar-bottom">
        <button class="btn-new-appt"><i class="bi bi-plus-lg me-1"></i> New Appointment</button>
        <div class="sidebar-footer mt-3">
            <a href="#" class="sidebar-link" style="padding:8px 6px;"><i class="bi bi-question-circle"></i> Support</a>
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

        <div class="section-header">
            <div>
                <div class="section-title">Analytics & Reports</div>
                <div class="section-sub">Monthly summary and export tools.</div>
            </div>
            <a href="{{ route('admin.reports.export') }}" class="btn-export">
                <i class="bi bi-download"></i> Export CSV
            </a>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-label">Total Patients</div>
                    <div class="stat-value">1,284</div>
                    <div class="stat-meta"><span class="stat-up">+13%</span> from last month</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-label">Consultations</div>
                    <div class="stat-value">432</div>
                    <div class="stat-meta">Daily avg: 24</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-label">Avg Wait Time</div>
                    <div class="stat-value">22m</div>
                    <div class="stat-meta"><span class="stat-up">−8%</span> improved</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-label">Records Filed</div>
                    <div class="stat-value">390</div>
                    <div class="stat-meta">This month</div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card-panel" style="height:100%;">
                    <div class="panel-title">Daily Patient Volume</div>
                    <div class="bar-chart" id="barChart"></div>
                    <div style="display:flex;gap:8px;margin-top:4px;">
                        <?php $days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                        foreach ($days as $d) echo "<div style='flex:1;text-align:center;font-size:.63rem;color:var(--text-muted);text-transform:uppercase;'>{$d}</div>"; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-panel" style="height:100%;">
                    <div class="panel-title mb-3">Common Diagnoses</div>
                    <div class="diag-item"><div class="diag-header"><span>Upper Respiratory Infection</span><span class="diag-pct">28%</span></div><div class="diag-bar"><div class="diag-fill" style="width:28%"></div></div></div>
                    <div class="diag-item"><div class="diag-header"><span>Hypertension</span><span class="diag-pct">22%</span></div><div class="diag-bar"><div class="diag-fill" style="width:22%"></div></div></div>
                    <div class="diag-item"><div class="diag-header"><span>Acute Gastritis</span><span class="diag-pct">18%</span></div><div class="diag-bar"><div class="diag-fill" style="width:18%"></div></div></div>
                    <div class="diag-item"><div class="diag-header"><span>Migraine</span><span class="diag-pct">15%</span></div><div class="diag-bar"><div class="diag-fill" style="width:15%"></div></div></div>
                    <div class="diag-item"><div class="diag-header"><span>Type 2 Diabetes</span><span class="diag-pct">10%</span></div><div class="diag-bar"><div class="diag-fill" style="width:10%"></div></div></div>
                    <div class="diag-item" style="margin-bottom:0;"><div class="diag-header"><span>Lumbar Disc Issues</span><span class="diag-pct">7%</span></div><div class="diag-bar"><div class="diag-fill" style="width:7%"></div></div></div>
                </div>
            </div>
        </div>

        <!-- Monthly Report Table -->
        <div class="card-panel">
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <div>
                    <div class="panel-title">Monthly Summary</div>
                    <div class="panel-sub">Breakdown by doctor and department</div>
                </div>
                <div class="filter-row">
                    <select class="filter-select">
                        <option>April 2026</option>
                        <option>March 2026</option>
                        <option>February 2026</option>
                    </select>
                    <select class="filter-select">
                        <option>All Doctors</option>
                        <option>Dr. Isabel Santos</option>
                        <option>Dr. Ramon Reyes</option>
                        <option>Dr. Ana Cruz</option>
                    </select>
                </div>
            </div>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Specialty</th>
                        <th>Patients Seen</th>
                        <th>Avg Duration</th>
                        <th>Records Filed</th>
                        <th>Completion Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Dr. Isabel Santos</strong></td>
                        <td style="color:var(--text-muted);">General Medicine</td>
                        <td>162</td><td>32 min</td><td>158</td>
                        <td><span style="color:var(--success);font-weight:600;">97.5%</span></td>
                    </tr>
                    <tr>
                        <td><strong>Dr. Ramon Reyes</strong></td>
                        <td style="color:var(--text-muted);">Internal Medicine</td>
                        <td>148</td><td>28 min</td><td>145</td>
                        <td><span style="color:var(--success);font-weight:600;">97.9%</span></td>
                    </tr>
                    <tr>
                        <td><strong>Dr. Ana Cruz</strong></td>
                        <td style="color:var(--text-muted);">Family Medicine</td>
                        <td>122</td><td>35 min</td><td>120</td>
                        <td><span style="color:var(--success);font-weight:600;">98.3%</span></td>
                    </tr>
                    <tr>
                        <td style="font-weight:700;">Total</td>
                        <td></td>
                        <td style="font-weight:700;">432</td>
                        <td style="font-weight:700;">31.6 min</td>
                        <td style="font-weight:700;">423</td>
                        <td style="font-weight:700;color:var(--success);">97.9%</td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const heights = [55, 72, 60, 90, 80, 35, 45];
    const chart = document.getElementById('barChart');
    heights.forEach(h => {
        const col = document.createElement('div');
        col.className = 'bar-col';
        col.innerHTML = `<div class="bar" style="height:${h}px"></div>`;
        chart.appendChild(col);
    });
</script>
</body>
</html>