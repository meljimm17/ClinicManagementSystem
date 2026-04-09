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
            --sidebar-bg: #1b3d2f;
            --sidebar-hover: #254d3c;
            --sidebar-active: #2e6048;
            --accent: #3d8b6e;
            --accent-light: #4fa882;
            --accent-soft: #e8f5f0;
            --text-primary: #1a2e25;
            --text-muted: #6b7f77;
            --border: #e4ece8;
            --card-bg: #ffffff;
            --page-bg: #f4f7f5;
            --success: #2e8b5e;
            --danger: #c0392b;
            --badge-live: #1b3d2f;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--page-bg);
            color: var(--text-primary);
            margin: 0;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 220px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 28px 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .brand-name {
            font-family: 'DM Serif Display', serif;
            font-size: 1.15rem;
            color: #fff;
            line-height: 1.2;
            letter-spacing: .01em;
        }

        .brand-sub {
            font-size: .68rem;
            color: rgba(255,255,255,.45);
            letter-spacing: .12em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 14px 0;
        }

        .nav-label {
            font-size: .63rem;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: rgba(255,255,255,.3);
            padding: 12px 22px 6px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 22px;
            color: rgba(255,255,255,.65);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 400;
            border-left: 3px solid transparent;
            transition: all .18s ease;
        }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-link.active {
            background: var(--sidebar-active);
            color: #fff;
            border-left-color: var(--accent-light);
            font-weight: 500;
        }

        .sidebar-link i {
            font-size: 1rem;
            width: 18px;
            text-align: center;
        }

        .sidebar-bottom {
            padding: 16px 16px 24px;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .btn-new-appt {
            width: 100%;
            background: var(--accent-light);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 0;
            font-size: .82rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: .02em;
            transition: background .18s;
            cursor: pointer;
        }

        .btn-new-appt:hover { background: var(--accent); }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            background: none;
            border: none;
            padding: 8px 6px;
            color: rgba(255,255,255,.65);
            font-size: .82rem;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            border-left: 3px solid transparent;
            transition: all .18s;
            text-align: left;
        }

        .btn-logout:hover { background: var(--sidebar-hover); color: #fff; }
        .btn-logout i { font-size: 1rem; width: 18px; text-align: center; }

        .sidebar-footer {
            padding: 10px 0 4px;
        }

        /* ── Main ── */
        .main-wrap {
            margin-left: 220px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top bar */
        .topbar {
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left h3 {
            font-size: 1rem;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: .01em;
        }

        .topbar-left p {
            font-size: .75rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            background: var(--page-bg);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted);
            font-size: .95rem;
            cursor: pointer;
            transition: background .15s;
        }

        .topbar-icon:hover { background: var(--accent-soft); color: var(--accent); }

        .avatar {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light));
            color: #fff;
            font-size: .8rem;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
        }

        /* Content */
        .content {
            padding: 28px 32px 40px;
            flex: 1;
        }

        /* Section header */
        .section-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .section-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .section-sub {
            font-size: .8rem;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .badge-live {
            background: var(--badge-live);
            color: #fff;
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .badge-live::before {
            content: '';
            width: 7px; height: 7px;
            background: #4fce9e;
            border-radius: 50%;
            animation: pulse 1.6s ease infinite;
        }

        @keyframes pulse {
            0%,100% { opacity: 1; transform: scale(1); }
            50% { opacity: .5; transform: scale(1.3); }
        }

        /* Stat cards */
        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 22px 24px;
        }

        .stat-label {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 2.1rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-meta {
            font-size: .75rem;
            color: var(--text-muted);
            margin-top: 6px;
        }

        .stat-up {
            color: var(--success);
            font-weight: 600;
        }

        /* Cards */
        .card-panel {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 22px 24px;
        }

        .panel-title {
            font-size: .9rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .panel-sub {
            font-size: .75rem;
            color: var(--text-muted);
        }

        /* User table */
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        .user-table thead th {
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0 0 10px;
            border-bottom: 1px solid var(--border);
        }

        .user-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .12s;
        }

        .user-table tbody tr:last-child { border-bottom: none; }
        .user-table tbody tr:hover { background: var(--accent-soft); }

        .user-table td {
            padding: 13px 0;
            font-size: .845rem;
            color: var(--text-primary);
        }

        .user-name { font-weight: 600; }
        .user-role { color: var(--text-muted); font-size: .8rem; }
        .user-email { color: var(--text-muted); font-size: .8rem; }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: .7rem;
            font-weight: 600;
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .status-active {
            background: #e5f7ef;
            color: #1e7a4c;
        }

        .status-active::before {
            content: ''; width: 6px; height: 6px;
            background: #1e7a4c; border-radius: 50%;
        }

        .status-disabled {
            background: #f2f2f2;
            color: #888;
        }

        .status-disabled::before {
            content: ''; width: 6px; height: 6px;
            background: #aaa; border-radius: 50%;
        }

        /* Base Button Structure */
.action-btn {
    background: none;
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 4px 12px;
    font-size: .75rem;
    color: var(--text-muted);
    cursor: pointer;
    transition: all .15s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Edit Button - Primary Style */
.btn-edit {
    background-color: var(--accent);
    border-color: var(--accent);
    color: white;
}

.btn-edit:hover {
    background-color: var(--accent);
    filter: brightness(1.1);
    border-color: var(--accent);
    color: white;
}

/* Disable Button - Light Green Style */
.btn-disable {
    background-color: #f0fdf4; /* Very light green */
    border-color: #bbf7d0;     /* Soft green border */
    color: #166534;           /* Dark green text for contrast */
}

.btn-disable:hover {
    background-color: #dcfce7;
    border-color: #86efac;
    color: #14532d;
}

/* Utility margin */
.ms-1 {
    margin-left: 0.25rem;
}

        /* Bar chart */
        .bar-chart {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            height: 90px;
            padding-bottom: 0;
            margin-top: 20px;
        }

        .bar-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .bar {
            width: 100%;
            border-radius: 4px 4px 0 0;
            transition: opacity .2s;
        }

        .bar:hover { opacity: .75; }

        .bar-day {
            font-size: .65rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        /* Diagnoses */
        .diag-item {
            margin-bottom: 14px;
        }

        .diag-header {
            display: flex;
            justify-content: space-between;
            font-size: .8rem;
            color: var(--text-primary);
            margin-bottom: 5px;
        }

        .diag-pct {
            font-weight: 600;
            color: var(--text-muted);
        }

        .diag-bar {
            height: 6px;
            background: #e8efeb;
            border-radius: 10px;
            overflow: hidden;
        }

        .diag-fill {
            height: 100%;
            background: var(--sidebar-bg);
            border-radius: 10px;
        }

        /* System settings */
        .settings-field label {
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .settings-field input {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 9px 14px;
            font-size: .845rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-primary);
            background: var(--page-bg);
            width: 100%;
            outline: none;
            transition: border-color .15s;
        }

        .settings-field input:focus {
            border-color: var(--accent);
            background: #fff;
        }

        .btn-save {
            background: var(--sidebar-bg);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 9px 22px;
            font-size: .83rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: background .18s;
        }

        .btn-save:hover { background: var(--accent); }

        .btn-reset {
            background: none;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 9px 22px;
            font-size: .83rem;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-muted);
            cursor: pointer;
            margin-left: 10px;
            transition: all .15s;
        }

        .btn-reset:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .btn-add-user {
            background: var(--sidebar-bg);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: .8rem;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: background .18s;
        }

        .btn-add-user:hover { background: var(--accent); }

        /* Footer */
        .dash-footer {
            text-align: center;
            font-size: .7rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border);
            padding: 14px 32px;
            display: flex;
            justify-content: space-between;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            margin-left: 18px;
            font-size: .7rem;
        }

        .footer-links a:hover { color: var(--accent); }
    </style>
</head>
<body>

<!-- ═══════════════════ SIDEBAR ═══════════════════ -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-name">CuraSure</div>
       
    </div>

    <nav class="sidebar-nav">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2"></i>
        <span>Admin Dashboard</span>
    </a>
    <a href="{{ route('admin.queue') }}" class="sidebar-link {{ request()->routeIs('admin.queue') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        <span>Patient Queue</span>
    </a>
        <a href="#" class="sidebar-link">
            <i class="bi bi-calendar3"></i> Schedule
        </a>
        <a href="{{ route('admin.medical-records') }}" class="sidebar-link {{ request()->routeIs('admin.medical-records') ? 'active' : '' }}">
            <i class="bi bi-journal-medical"></i>
            <span>Medical Records</span>
        </a>
        <a href="#" class="sidebar-link">
            <i class="bi bi-graph-up-arrow"></i> Reports
        </a>
         <a href="#" class="sidebar-link">
            <i class="bi bi-shield-lock"></i> Administration
        </a>
    </nav>

    <div class="sidebar-bottom">
        <button class="btn-new-appt">
            <i class="bi bi-plus-lg me-1"></i> New Appointment
        </button>
        <div class="sidebar-footer mt-3">
            <a href="#" class="sidebar-link" style="padding:8px 6px;">
                <i class="bi bi-question-circle"></i> Support
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- ═══════════════════ MAIN ═══════════════════ -->
<div class="main-wrap">

    <!-- Topbar -->
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

    <!-- Content -->
    <main class="content">

        <!-- ── Dashboard Overview ── -->
        <div class="section-header">
            <div>
                <div class="section-title">Dashboard Overview</div>
                <div class="section-sub">Real-time system health and clinical throughput.</div>
            </div>
            <span class="badge-live">System Live</span>
        </div>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Total Patients</div>
                    <div class="stat-value">1,284</div>
                    <div class="stat-meta">
                        <span class="stat-up">+13%</span> from last month
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Completed Consultations</div>
                    <div class="stat-value">432</div>
                    <div class="stat-meta">Daily average: 24</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Active Queue Summary</div>
                    <div class="stat-value">18</div>
                    <div class="stat-meta">Estimated wait: 45m</div>
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
                <button class="btn-add-user">
                    <i class="bi bi-person-plus-fill"></i> Add User
                </button>
            </div>

            <table class="user-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="user-name">Dr. Isabel Santos</div>
                            <div class="user-role">Physician</div>
                        </td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td class="user-email">i.santos@curasure.ph</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>
                            <button class="action-btn btn-edit"">Edit</button>
                            <button class="action-btn btn-delete ms-1">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-name">Dr. Ramon Reyes</div>
                            <div class="user-role">Physician</div>
                        </td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td class="user-email">r.reyes@curasure.ph</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>
                            <button class="action-btn btn-edit">Edit</button>
                            <button class="action-btn btn-delete ms-1">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-name">Dr. Ana Cruz</div>
                            <div class="user-role">Physician</div>
                        </td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td class="user-email">a.cruz@curasure.ph</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>
                            <button class="action-btn btn-edit">Edit</button>
                            <button class="action-btn btn-delete ms-1">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-name">Nurse Patricia Lim</div>
                            <div class="user-role">Head Nurse</div>
                        </td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td class="user-email">p.lim@curasure.ph</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>
                            <button class="action-btn btn-edit">Edit</button>
                            <button class="action-btn btn-delete ms-1">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-name">Marco Villanueva</div>
                            <div class="user-role">Front Desk</div>
                        </td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td class="user-email">m.villanueva@curasure.ph</td>
                        <td><span class="status-badge status-active">Active</span></td>
                        <td>
                            <button class="action-btn btn-edit">Edit</button>
                            <button class="action-btn btn-delete ms-1">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-name">Carla Domingo</div>
                            <div class="user-role">Medical Records</div>
                        </td>
                        <td><span class="status-badge status-disabled">Inactive</span></td>
                        <td class="user-email">c.domingo@curasure.ph</td>
                        <td><span class="status-badge status-disabled">Inactive</span></td>
                        <td>
                            <button class="action-btn btn-edit">Edit</button>
                            <button class="action-btn btn-delete ms-1">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ── Charts Row ── -->
        <div class="row g-3 mb-4">

            <!-- Daily Patient Trends -->
            <div class="col-md-6">
                <div class="card-panel" style="height:100%;">
                    <div class="panel-title">Daily Patient Trends</div>
                    <div class="bar-chart" id="barChart">
                        <!-- Bars injected by JS -->
                    </div>
                    <div class="bar-chart" style="height:auto;margin-top:4px;">
                        <!-- Day labels -->
                        <?php
                        $days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
                        foreach ($days as $d) {
                            echo "<div class='bar-col'><span class='bar-day'>$d</span></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Common Diagnoses -->
            <div class="col-md-6">
                <div class="card-panel" style="height:100%;">
                    <div class="panel-title mb-3">Common Diagnoses</div>

                    <div class="diag-item">
                        <div class="diag-header">
                            <span>Upper Respiratory Infection</span>
                            <span class="diag-pct">28%</span>
                        </div>
                        <div class="diag-bar"><div class="diag-fill" style="width:28%"></div></div>
                    </div>
                    <div class="diag-item">
                        <div class="diag-header">
                            <span>Hypertension</span>
                            <span class="diag-pct">22%</span>
                        </div>
                        <div class="diag-bar"><div class="diag-fill" style="width:22%"></div></div>
                    </div>
                    <div class="diag-item">
                        <div class="diag-header">
                            <span>Acute Gastritis</span>
                            <span class="diag-pct">18%</span>
                        </div>
                        <div class="diag-bar"><div class="diag-fill" style="width:18%"></div></div>
                    </div>
                    <div class="diag-item">
                        <div class="diag-header">
                            <span>Migraine</span>
                            <span class="diag-pct">15%</span>
                        </div>
                        <div class="diag-bar"><div class="diag-fill" style="width:15%"></div></div>
                    </div>
                    <div class="diag-item">
                        <div class="diag-header">
                            <span>Type 2 Diabetes</span>
                            <span class="diag-pct">10%</span>
                        </div>
                        <div class="diag-bar"><div class="diag-fill" style="width:10%"></div></div>
                    </div>
                    <div class="diag-item" style="margin-bottom:0;">
                        <div class="diag-header">
                            <span>Lumbar Disc Issues</span>
                            <span class="diag-pct">7%</span>
                        </div>
                        <div class="diag-bar"><div class="diag-fill" style="width:7%"></div></div>
                    </div>
            </div>
        </div>

        <!-- ── System Settings ── -->
        <div class="card-panel">
            <div class="mb-4">
                <div class="panel-title">System Settings</div>
                <div class="panel-sub">Global configuration for clinic identity and workflow numbering.</div>
            </div>
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <div class="settings-field">
                        <label>Clinic Display Name</label>
                        <input type="text" value="CuraSure">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="settings-field">
                        <label>Queue Format ID</label>
                        <input type="text" value="Q-001">
                    </div>
                </div>
                <div class="col-md-5 d-flex align-items-end">
                    <button class="btn-save">Save Changes</button>
                    <button class="btn-reset">Reset Defaults</button>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="dash-footer">
        <span>© 2024 The Clinical Atelier · Central Management</span>
        <div class="footer-links">
            <a href="#">Privacy Protocol</a>
            <a href="#">Audit Log</a>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Bar chart data
    const values = [38, 52, 45, 70, 90, 60, 42];
    const max = Math.max(...values);
    const chart = document.getElementById('barChart');
    chart.innerHTML = '';

    values.forEach((v, i) => {
        const col = document.createElement('div');
        col.className = 'bar-col';
        const heightPct = Math.round((v / max) * 100);
        const isHighest = v === max;
        const bar = document.createElement('div');
        bar.className = 'bar';
        bar.style.height = heightPct + '%';
        bar.style.background = isHighest ? '#1b3d2f' : '#b8d9c9';
        bar.title = v + ' patients';
        col.appendChild(bar);
        chart.appendChild(col);
    });
</script>
</body>
</html>