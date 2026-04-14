<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure – Dashboard</title>
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
        .stat-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .stat-label { font-size: .72rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px; }
        .stat-value { font-size: 2.1rem; font-weight: 700; color: var(--text-primary); line-height: 1; }
        .stat-meta { font-size: .75rem; color: var(--text-muted); margin-top: 6px; }
        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .panel-sub { font-size: .75rem; color: var(--text-muted); }
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
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Total Patients</div>
                    <div class="stat-value">{{ number_format($totalPatients) }}</div>
                    <div class="stat-meta">All registered patients</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Completed Consultations</div>
                    <div class="stat-value">{{ number_format($completedConsultations) }}</div>
                    <div class="stat-meta">All-time completed records</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Active Queue Today</div>
                    <div class="stat-value">{{ $activeQueueCount }}</div>
                    <div class="stat-meta">Waiting or being diagnosed</div>
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

        <!-- ── Charts Row ── -->
        <div class="row g-3 mb-4">

            <!-- Daily Patient Trends — real data -->
            <div class="col-md-6">
                <div class="card-panel" style="height:100%;">
                    <div class="panel-title">Daily Patient Trends (Last 7 Days)</div>
                    <div class="bar-chart" id="barChart"></div>
                    <div class="bar-chart" style="height:auto;margin-top:4px;">
                        @foreach($weekData as $day)
                            <div class="bar-col"><span class="bar-day">{{ $day['label'] }}</span></div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Common Diagnoses — real data -->
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
                </div>
            </div>
        </div>

    </main>

    <footer class="dash-footer">
        <span>© 2024 CuraSure · Central Management</span>
        <div class="footer-links"><a href="#">Privacy Protocol</a><a href="#">Audit Log</a></div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Build bar chart from real server data
    const weekData = @json($weekData);
    const counts   = weekData.map(d => d.count);
    const max      = Math.max(...counts, 1);
    const chart    = document.getElementById('barChart');
    chart.innerHTML = '';

    counts.forEach((v) => {
        const col = document.createElement('div');
        col.className = 'bar-col';
        const heightPct = Math.round((v / max) * 100);
        const bar = document.createElement('div');
        bar.className = 'bar';
        bar.style.height    = (heightPct || 2) + '%';
        bar.style.minHeight = '4px';
        bar.style.background = (v === max && v > 0) ? '#1b3d2f' : '#b8d9c9';
        bar.title = v + ' patients';
        col.appendChild(bar);
        chart.appendChild(col);
    });
</script>
</body>
</html>