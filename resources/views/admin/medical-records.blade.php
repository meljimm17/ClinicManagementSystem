<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure - Medical Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
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
            --primary: #2d7a50;
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

        .sidebar-nav { flex: 1; padding: 14px 0; }

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

        .sidebar-link:hover { background: var(--sidebar-hover); color: #fff; }

        .sidebar-link.active {
            background: var(--sidebar-active);
            color: #fff;
            border-left-color: var(--accent-light);
            font-weight: 500;
        }

        .sidebar-link i { font-size: 1rem; width: 18px; text-align: center; }

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

        .sidebar-footer { padding: 10px 0 4px; }

        /* ── Main ── */
        .main-wrap {
            margin-left: 220px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
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

        .topbar-actions { display: flex; align-items: center; gap: 10px; }

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
        .content { padding: 28px 32px 40px; flex: 1; }

        /* Stat chips */
        .stat-chip {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stat-chip-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .stat-chip-icon.green { background: var(--accent-soft); color: var(--primary); }
        .stat-chip-icon.dark  { background: var(--sidebar-bg); color: #4fce9e; }
        .stat-chip-icon.slate { background: #f0f4f8; color: #5a6a7a; }

        .stat-chip-label { font-size: .65rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); }
        .stat-chip-value { font-size: 1.4rem; font-weight: 700; color: var(--text-primary); line-height: 1.1; }

        /* Card panel */
        .card-panel {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 22px 24px;
        }

        .panel-title {
            font-size: .9rem;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-primary);
        }

        /* Search */
        .search-input {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px 14px 8px 36px;
            font-size: .845rem;
            font-family: 'DM Sans', sans-serif;
            background: var(--page-bg);
            color: var(--text-primary);
            outline: none;
            width: 220px;
            transition: border-color .15s, width .2s;
        }

        .search-input:focus { border-color: var(--accent); width: 260px; background: #fff; }

        .filter-btn {
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 8px 14px;
            font-size: .8rem;
            font-family: 'DM Sans', sans-serif;
            background: var(--page-bg);
            color: var(--text-muted);
            cursor: pointer;
            transition: all .15s;
        }

        .filter-btn.active, .filter-btn:hover {
            background: var(--accent-soft);
            border-color: #c0dfd0;
            color: var(--primary);
        }

        /* Medical Record table */
        .medical-record-table { width: 100%; border-collapse: separate; border-spacing: 0; }

        .medical-record-table thead th {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
        }

        .medical-record-table tbody tr { transition: background .12s; }
        .medical-record-table tbody tr:hover { background: #fafcfb; }

        .medical-record-table tbody td {
            padding: 14px 14px;
            border-bottom: 1px solid var(--border);
            font-size: .845rem;
            font-family: 'DM Sans', sans-serif;
            vertical-align: middle;
        }

        .medical-record-table tbody tr:last-child td { border-bottom: none; }

        /* Queue ID */
        .q-id {
            font-family: 'DM Serif Display', serif;
            font-size: 1.05rem;
            color: var(--sidebar-bg);
        }

        /* Patient name */
        .patient-name-btn {
            background: none;
            border: none;
            padding: 0;
            font-family: 'DM Sans', sans-serif;
            font-size: .875rem;
            font-weight: 600;
            color: var(--text-primary);
            cursor: pointer;
            text-align: left;
            text-decoration: underline;
            text-decoration-color: transparent;
            text-underline-offset: 3px;
            transition: color .15s, text-decoration-color .15s;
        }

        .patient-name-btn:hover {
            color: var(--primary);
            text-decoration-color: var(--primary);
        }

        /* Done badge */
        .badge-done {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            background: #f0f4f8;
            color: #5a6a7a;
            border: 1px solid #d8e2ec;
        }

        .badge-done::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #5a6a7a;
            flex-shrink: 0;
        }

        /* Diagnosis chip */
        .diag-chip {
            display: inline-block;
            background: var(--accent-soft);
            color: var(--primary);
            border: 1px solid #c0dfd0;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 600;
            padding: 3px 10px;
            font-family: 'DM Sans', sans-serif;
        }

        /* Doctor name */
        .doctor-name {
            font-size: .845rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .doctor-role {
            font-size: .7rem;
            color: var(--text-muted);
        }

        /* Duration chip */
        .duration-chip {
            font-size: .78rem;
            font-weight: 600;
            color: var(--text-muted);
            font-family: 'DM Sans', sans-serif;
        }

        /* Action button */
        .act-btn {
            width: 32px; height: 32px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--page-bg);
            color: var(--text-muted);
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .85rem;
            cursor: pointer;
            transition: all .15s;
            font-family: 'DM Sans', sans-serif;
        }

        .act-btn:hover { background: var(--accent-soft); border-color: #c0dfd0; color: var(--primary); }

        /* ── Modals ── */
        .modal-content {
            border: 1px solid var(--border);
            border-radius: 14px;
            font-family: 'DM Sans', sans-serif;
        }

        .modal-header {
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--border);
        }

        .modal-title { font-weight: 700; font-size: .95rem; font-family: 'DM Sans', sans-serif; }
        .modal-body { padding: 22px 24px; }
        .modal-footer { padding: 14px 24px; border-top: 1px solid var(--border); }

        .info-label {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 3px;
            font-family: 'DM Sans', sans-serif;
        }

        .info-value {
            font-size: .875rem;
            font-weight: 500;
            color: var(--text-primary);
            padding: 9px 14px;
            background: var(--page-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
        }

        .patient-avatar-lg {
            width: 56px; height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light));
            color: #fff;
            font-size: 1.4rem;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-family: 'DM Serif Display', serif;
        }

        .view-only-chip {
            background: #f0f4f8;
            color: #5a6a7a;
            border: 1px solid #d8e2ec;
            border-radius: 20px;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .06em;
            padding: 3px 10px;
            text-transform: uppercase;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-ghost {
            background: none;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 9px 18px;
            font-size: .845rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-muted);
            cursor: pointer;
            transition: all .15s;
        }

        .btn-ghost:hover { background: var(--page-bg); color: var(--text-primary); }

        /* Footer */
        .dash-footer {
            text-align: center;
            font-size: .7rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border);
            padding: 14px 32px;
            display: flex;
            justify-content: space-between;
            font-family: 'DM Sans', sans-serif;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            margin-left: 18px;
            font-size: .7rem;
        }

        .footer-links a:hover { color: var(--accent); }

        @keyframes pulse {
            0%,100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(1.4); }
        }
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

    <a href="{{ route('admin.schedule') }}" class="sidebar-link">
        <i class="bi bi-calendar3"></i>
        <span>Schedule</span>
    </a>

    <a href="{{ route('admin.medical-records') }}" class="sidebar-link {{ request()->routeIs('admin.medical-records') ? 'active' : '' }}">
        <i class="bi bi-journal-medical"></i>           
        <span>Medical Records</span>
    </a>
    <a href="{{ route('admin.reports') }}" class="sidebar-link">
            <i class="bi bi-graph-up-arrow"></i> Reports
        </a>

    <a href="#" class="sidebar-link">
        <i class="bi bi-shield-lock"></i>
        <span>Administration</span>
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
    <button type="submit" class="sidebar-link" style="background:none; border:none; width:100%; text-align:left;">
        <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
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
            <h3>Patient Medical Records</h3>
            <p>All completed consultations and diagnoses</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-icon"><i class="bi bi-bell"></i></div>
            <div class="topbar-icon"><i class="bi bi-gear"></i></div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <!-- Content -->
    <main class="content">

        <!-- Stat Chips -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon dark"><i class="bi bi-check2-all"></i></div>
                    <div>
                        <div class="stat-chip-label">Total Completed</div>
                        <div class="stat-chip-value">432</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon green"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <div class="stat-chip-label">Completed Today</div>
                        <div class="stat-chip-value">8</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon slate"><i class="bi bi-stopwatch"></i></div>
                    <div>
                        <div class="stat-chip-label">Avg. Consult Time</div>
                        <div class="stat-chip-value">38 min</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Record Table -->
        <div class="card-panel">
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <div class="panel-title mb-0">Completed Consultations</div>
                    <p class="mb-0" style="font-size:.75rem; color:var(--text-muted);">Click a patient's name to view their full record</p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute" style="left:11px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:.8rem;"></i>
                        <input type="text" class="search-input" placeholder="Search patient…" id="searchInput" oninput="filterTable()">
                    </div>
                    <button class="filter-btn active" onclick="setFilter('all', this)">All</button>
                    <button class="filter-btn" onclick="setFilter('today', this)">Today</button>
                    <button class="filter-btn" onclick="setFilter('yesterday', this)">Yesterday</button>
                </div>
            </div>

            <table class="medical-record-table">
                <thead>
                    <tr>
                        <th>Queue ID</th>
                        <th>Patient</th>
                        <th>Diagnosis</th>
                        <th>Attending Physician</th>
                        <th>Date &amp; Time</th>
                        <th>Duration</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody id="medicalRecordBody">

                    <!-- Record 1 -->
                    <tr data-date="today">
                        <td><span class="q-id">Q-001</span></td>
                        <td>
                            <button class="patient-name-btn" onclick="openViewModal({
                                id: 'Q-001', name: 'Elena Rodriguez', date: 'Apr 10, 2026', time: '08:30 AM',
                                age: 27, gender: 'Female', contact: '+63 912 345 6789',
                                address: '14 Mahogany St, Davao City',
                                blood: 'O+', height: '165 cm', weight: '55 kg',
                                symptoms: 'Persistent headache and mild fever for 3 days. Reports fatigue and occasional dizziness.',
                                diagnosis: 'Migraine with Aura',
                                doctor: 'Dr. Isabel Santos', duration: '45 min', room: 'Room 02'
                            })">Elena Rodriguez</button>
                            <div style="font-size:.72rem; color:var(--text-muted);">F · 27 yrs</div>
                        </td>
                        <td><span class="diag-chip">Migraine with Aura</span></td>
                        <td>
                            <div class="doctor-name">Dr. Isabel Santos</div>
                            <div class="doctor-role">Physician</div>
                        </td>
                        <td>
                            <div style="font-size:.845rem;">Apr 10, 2026</div>
                            <div style="font-size:.72rem; color:var(--text-muted);">08:30 AM</div>
                        </td>
                        <td><span class="duration-chip"><i class="bi bi-clock me-1"></i>45 min</span></td>
                        <td style="text-align:right;">
                            <button class="act-btn" title="View Record" onclick="openViewModal({
                                id: 'Q-001', name: 'Elena Rodriguez', date: 'Apr 10, 2026', time: '08:30 AM',
                                age: 27, gender: 'Female', contact: '+63 912 345 6789',
                                address: '14 Mahogany St, Davao City',
                                blood: 'O+', height: '165 cm', weight: '55 kg',
                                symptoms: 'Persistent headache and mild fever for 3 days. Reports fatigue and occasional dizziness.',
                                diagnosis: 'Migraine with Aura',
                                doctor: 'Dr. Isabel Santos', duration: '45 min', room: 'Room 02'
                            })"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>

                    <!-- Record 2 -->
                    <tr data-date="today">
                        <td><span class="q-id">Q-002</span></td>
                        <td>
                            <button class="patient-name-btn" onclick="openViewModal({
                                id: 'Q-002', name: 'Marcus Chen', date: 'Apr 10, 2026', time: '09:15 AM',
                                age: 34, gender: 'Male', contact: '+63 917 654 3210',
                                address: '7 Acacia Lane, Calinan, Davao City',
                                blood: 'A+', height: '172 cm', weight: '70 kg',
                                symptoms: 'Chest tightness and shortness of breath since this morning. No prior cardiac history.',
                                diagnosis: 'Anxiety-Induced Chest Pain',
                                doctor: 'Dr. Ramon Reyes', duration: '30 min', room: 'Room 03'
                            })">Marcus Chen</button>
                            <div style="font-size:.72rem; color:var(--text-muted);">M · 34 yrs</div>
                        </td>
                        <td><span class="diag-chip">Anxiety-Induced Chest Pain</span></td>
                        <td>
                            <div class="doctor-name">Dr. Ramon Reyes</div>
                            <div class="doctor-role">Physician</div>
                        </td>
                        <td>
                            <div style="font-size:.845rem;">Apr 10, 2026</div>
                            <div style="font-size:.72rem; color:var(--text-muted);">09:15 AM</div>
                        </td>
                        <td><span class="duration-chip"><i class="bi bi-clock me-1"></i>30 min</span></td>
                        <td style="text-align:right;">
                            <button class="act-btn" title="View Record" onclick="openViewModal({
                                id: 'Q-002', name: 'Marcus Chen', date: 'Apr 10, 2026', time: '09:15 AM',
                                age: 34, gender: 'Male', contact: '+63 917 654 3210',
                                address: '7 Acacia Lane, Calinan, Davao City',
                                blood: 'A+', height: '172 cm', weight: '70 kg',
                                symptoms: 'Chest tightness and shortness of breath since this morning. No prior cardiac history.',
                                diagnosis: 'Anxiety-Induced Chest Pain',
                                doctor: 'Dr. Ramon Reyes', duration: '30 min', room: 'Room 03'
                            })"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>

                    <!-- Record 3 -->
                    <tr data-date="today">
                        <td><span class="q-id">Q-003</span></td>
                        <td>
                            <button class="patient-name-btn" onclick="openViewModal({
                                id: 'Q-003', name: 'Sofia Reyes', date: 'Apr 10, 2026', time: '09:55 AM',
                                age: 22, gender: 'Female', contact: '+63 920 111 2233',
                                address: '3 Rosewood Dr, Toril, Davao City',
                                blood: 'B-', height: '158 cm', weight: '48 kg',
                                symptoms: 'Severe abdominal pain and nausea. Last meal 6 hours ago. Vomited twice.',
                                diagnosis: 'Acute Gastritis',
                                doctor: 'Dr. Isabel Santos', duration: '40 min', room: 'Room 01'
                            })">Sofia Reyes</button>
                            <div style="font-size:.72rem; color:var(--text-muted);">F · 22 yrs</div>
                        </td>
                        <td><span class="diag-chip">Acute Gastritis</span></td>
                        <td>
                            <div class="doctor-name">Dr. Isabel Santos</div>
                            <div class="doctor-role">Physician</div>
                        </td>
                        <td>
                            <div style="font-size:.845rem;">Apr 10, 2026</div>
                            <div style="font-size:.72rem; color:var(--text-muted);">09:55 AM</div>
                        </td>
                        <td><span class="duration-chip"><i class="bi bi-clock me-1"></i>40 min</span></td>
                        <td style="text-align:right;">
                            <button class="act-btn" title="View Record" onclick="openViewModal({
                                id: 'Q-003', name: 'Sofia Reyes', date: 'Apr 10, 2026', time: '09:55 AM',
                                age: 22, gender: 'Female', contact: '+63 920 111 2233',
                                address: '3 Rosewood Dr, Toril, Davao City',
                                blood: 'B-', height: '158 cm', weight: '48 kg',
                                symptoms: 'Severe abdominal pain and nausea. Last meal 6 hours ago. Vomited twice.',
                                diagnosis: 'Acute Gastritis',
                                doctor: 'Dr. Isabel Santos', duration: '40 min', room: 'Room 01'
                            })"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>

                    <!-- Record 4 -->
                    <tr data-date="today">
                        <td><span class="q-id">Q-004</span></td>
                        <td>
                            <button class="patient-name-btn" onclick="openViewModal({
                                id: 'Q-004', name: 'James Villanueva', date: 'Apr 10, 2026', time: '10:40 AM',
                                age: 45, gender: 'Male', contact: '+63 905 887 7654',
                                address: '21 Palm Ave, Mintal, Davao City',
                                blood: 'AB+', height: '175 cm', weight: '82 kg',
                                symptoms: 'Lower back pain radiating to the right leg. Pain score 7/10. Has history of lumbar disc issues.',
                                diagnosis: 'Lumbar Disc Herniation',
                                doctor: 'Dr. Ana Cruz', duration: '55 min', room: 'Room 04'
                            })">James Villanueva</button>
                            <div style="font-size:.72rem; color:var(--text-muted);">M · 45 yrs</div>
                        </td>
                        <td><span class="diag-chip">Lumbar Disc Herniation</span></td>
                        <td>
                            <div class="doctor-name">Dr. Ana Cruz</div>
                            <div class="doctor-role">Physician</div>
                        </td>
                        <td>
                            <div style="font-size:.845rem;">Apr 10, 2026</div>
                            <div style="font-size:.72rem; color:var(--text-muted);">10:40 AM</div>
                        </td>
                        <td><span class="duration-chip"><i class="bi bi-clock me-1"></i>55 min</span></td>
                        <td style="text-align:right;">
                            <button class="act-btn" title="View Record" onclick="openViewModal({
                                id: 'Q-004', name: 'James Villanueva', date: 'Apr 10, 2026', time: '10:40 AM',
                                age: 45, gender: 'Male', contact: '+63 905 887 7654',
                                address: '21 Palm Ave, Mintal, Davao City',
                                blood: 'AB+', height: '175 cm', weight: '82 kg',
                                symptoms: 'Lower back pain radiating to the right leg. Pain score 7/10. Has history of lumbar disc issues.',
                                diagnosis: 'Lumbar Disc Herniation',
                                doctor: 'Dr. Ana Cruz', duration: '55 min', room: 'Room 04'
                            })"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>

                    <!-- Record 5 (Yesterday) -->
                    <tr data-date="yesterday">
                        <td><span class="q-id">Q-005</span></td>
                        <td>
                            <button class="patient-name-btn" onclick="openViewModal({
                                id: 'Q-005', name: 'Maria Santos', date: 'Apr 9, 2026', time: '11:30 AM',
                                age: 52, gender: 'Female', contact: '+63 918 223 4455',
                                address: '88 Sampaguita St, Buhangin, Davao City',
                                blood: 'O-', height: '160 cm', weight: '65 kg',
                                symptoms: 'Recurring headaches and elevated BP reading of 150/95 mmHg. On monitoring for 2 weeks.',
                                diagnosis: 'Hypertension Stage 1',
                                doctor: 'Dr. Ramon Reyes', duration: '35 min', room: 'Room 03'
                            })">Maria Santos</button>
                            <div style="font-size:.72rem; color:var(--text-muted);">F · 52 yrs</div>
                        </td>
                        <td><span class="diag-chip">Hypertension Stage 1</span></td>
                        <td>
                            <div class="doctor-name">Dr. Ramon Reyes</div>
                            <div class="doctor-role">Physician</div>
                        </td>
                        <td>
                            <div style="font-size:.845rem;">Apr 9, 2026</div>
                            <div style="font-size:.72rem; color:var(--text-muted);">11:30 AM</div>
                        </td>
                        <td><span class="duration-chip"><i class="bi bi-clock me-1"></i>35 min</span></td>
                        <td style="text-align:right;">
                            <button class="act-btn" title="View Record" onclick="openViewModal({
                                id: 'Q-005', name: 'Maria Santos', date: 'Apr 9, 2026', time: '11:30 AM',
                                age: 52, gender: 'Female', contact: '+63 918 223 4455',
                                address: '88 Sampaguita St, Buhangin, Davao City',
                                blood: 'O-', height: '160 cm', weight: '65 kg',
                                symptoms: 'Recurring headaches and elevated BP reading of 150/95 mmHg.',
                                diagnosis: 'Hypertension Stage 1',
                                doctor: 'Dr. Ramon Reyes', duration: '35 min', room: 'Room 03'
                            })"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>

                    <!-- Record 6 (Yesterday) -->
                    <tr data-date="yesterday">
                        <td><span class="q-id">Q-006</span></td>
                        <td>
                            <button class="patient-name-btn" onclick="openViewModal({
                                id: 'Q-006', name: 'Liam Domingo', date: 'Apr 9, 2026', time: '10:00 AM',
                                age: 19, gender: 'Male', contact: '+63 927 556 8812',
                                address: '5 Narra Blvd, Tibungco, Davao City',
                                blood: 'A-', height: '168 cm', weight: '60 kg',
                                symptoms: 'Sore throat, runny nose, mild cough for 4 days. Temp: 37.8°C.',
                                diagnosis: 'Upper Respiratory Infection',
                                doctor: 'Dr. Ana Cruz', duration: '25 min', room: 'Room 01'
                            })">Liam Domingo</button>
                            <div style="font-size:.72rem; color:var(--text-muted);">M · 19 yrs</div>
                        </td>
                        <td><span class="diag-chip">Upper Respiratory Infection</span></td>
                        <td>
                            <div class="doctor-name">Dr. Ana Cruz</div>
                            <div class="doctor-role">Physician</div>
                        </td>
                        <td>
                            <div style="font-size:.845rem;">Apr 9, 2026</div>
                            <div style="font-size:.72rem; color:var(--text-muted);">10:00 AM</div>
                        </td>
                        <td><span class="duration-chip"><i class="bi bi-clock me-1"></i>25 min</span></td>
                        <td style="text-align:right;">
                            <button class="act-btn" title="View Record" onclick="openViewModal({
                                id: 'Q-006', name: 'Liam Domingo', date: 'Apr 9, 2026', time: '10:00 AM',
                                age: 19, gender: 'Male', contact: '+63 927 556 8812',
                                address: '5 Narra Blvd, Tibungco, Davao City',
                                blood: 'A-', height: '168 cm', weight: '60 kg',
                                symptoms: 'Sore throat, runny nose, mild cough for 4 days. Temp: 37.8°C.',
                                diagnosis: 'Upper Respiratory Infection',
                                doctor: 'Dr. Ana Cruz', duration: '25 min', room: 'Room 01'
                            })"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>

                    <!-- Record 7 (Yesterday) -->
                    <tr data-date="yesterday">
                        <td><span class="q-id">Q-007</span></td>
                        <td>
                            <button class="patient-name-btn" onclick="openViewModal({
                                id: 'Q-007', name: 'Alyssa Tan', date: 'Apr 9, 2026', time: '03:45 PM',
                                age: 58, gender: 'Female', contact: '+63 916 778 9900',
                                address: '12 Orchid St, Panacan, Davao City',
                                blood: 'B+', height: '155 cm', weight: '72 kg',
                                symptoms: 'Follow-up consultation. Fasting blood sugar: 8.2 mmol/L. Reports polyuria and fatigue.',
                                diagnosis: 'Type 2 Diabetes – Follow-up',
                                doctor: 'Dr. Isabel Santos', duration: '50 min', room: 'Room 02'
                            })">Alyssa Tan</button>
                            <div style="font-size:.72rem; color:var(--text-muted);">F · 58 yrs</div>
                        </td>
                        <td><span class="diag-chip">Type 2 Diabetes – Follow-up</span></td>
                        <td>
                            <div class="doctor-name">Dr. Isabel Santos</div>
                            <div class="doctor-role">Physician</div>
                        </td>
                        <td>
                            <div style="font-size:.845rem;">Apr 9, 2026</div>
                            <div style="font-size:.72rem; color:var(--text-muted);">03:45 PM</div>
                        </td>
                        <td><span class="duration-chip"><i class="bi bi-clock me-1"></i>50 min</span></td>
                        <td style="text-align:right;">
                            <button class="act-btn" title="View Record" onclick="openViewModal({
                                id: 'Q-007', name: 'Alyssa Tan', date: 'Apr 9, 2026', time: '03:45 PM',
                                age: 58, gender: 'Female', contact: '+63 916 778 9900',
                                address: '12 Orchid St, Panacan, Davao City',
                                blood: 'B+', height: '155 cm', weight: '72 kg',
                                symptoms: 'Follow-up consultation. Fasting blood sugar: 8.2 mmol/L. Reports polyuria and fatigue.',
                                diagnosis: 'Type 2 Diabetes – Follow-up',
                                doctor: 'Dr. Isabel Santos', duration: '50 min', room: 'Room 02'
                            })"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>

                    <!-- Record 8 (Yesterday) -->
                    <tr data-date="yesterday">
                        <td><span class="q-id">Q-008</span></td>
                        <td>
                            <button class="patient-name-btn" onclick="openViewModal({
                                id: 'Q-008', name: 'Carlos Mendoza', date: 'Apr 9, 2026', time: '01:20 PM',
                                age: 41, gender: 'Male', contact: '+63 933 441 6677',
                                address: '9 Mango Ave, Agdao, Davao City',
                                blood: 'O+', height: '170 cm', weight: '76 kg',
                                symptoms: 'Productive cough with yellow sputum, fever 38.4°C, malaise for 5 days.',
                                diagnosis: 'Acute Bronchitis',
                                doctor: 'Dr. Ramon Reyes', duration: '30 min', room: 'Room 03'
                            })">Carlos Mendoza</button>
                            <div style="font-size:.72rem; color:var(--text-muted);">M · 41 yrs</div>
                        </td>
                        <td><span class="diag-chip">Acute Bronchitis</span></td>
                        <td>
                            <div class="doctor-name">Dr. Ramon Reyes</div>
                            <div class="doctor-role">Physician</div>
                        </td>
                        <td>
                            <div style="font-size:.845rem;">Apr 9, 2026</div>
                            <div style="font-size:.72rem; color:var(--text-muted);">01:20 PM</div>
                        </td>
                        <td><span class="duration-chip"><i class="bi bi-clock me-1"></i>30 min</span></td>
                        <td style="text-align:right;">
                            <button class="act-btn" title="View Record" onclick="openViewModal({
                                id: 'Q-008', name: 'Carlos Mendoza', date: 'Apr 9, 2026', time: '01:20 PM',
                                age: 41, gender: 'Male', contact: '+63 933 441 6677',
                                address: '9 Mango Ave, Agdao, Davao City',
                                blood: 'O+', height: '170 cm', weight: '76 kg',
                                symptoms: 'Productive cough with yellow sputum, fever 38.4°C, malaise for 5 days.',
                                diagnosis: 'Acute Bronchitis',
                                doctor: 'Dr. Ramon Reyes', duration: '30 min', room: 'Room 03'
                            })"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </main>

    <!-- Footer -->
    <footer class="dash-footer">
        <span>© 2024 CuraSure · Staff Portal</span>
        <div class="footer-links">
            <a href="#">Privacy Protocol</a>
            <a href="#">Support</a>
        </div>
    </footer>
</div>


<!-- ══════════════ VIEW MODAL (read-only) ══════════════ -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="patient-avatar-lg" id="viewAvatar">E</div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="modal-title" id="viewName">—</span>
                            <span class="view-only-chip">Completed</span>
                        </div>
                        <div style="font-size:.75rem; color:var(--text-muted);">
                            <span id="viewId"></span> &nbsp;·&nbsp; <span id="viewDate"></span> at <span id="viewTime"></span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="info-label">Age</div>
                        <div class="info-value" id="viewAge">—</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Gender</div>
                        <div class="info-value" id="viewGender">—</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Contact Number</div>
                        <div class="info-value" id="viewContact">—</div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-label">Address</div>
                        <div class="info-value" id="viewAddress">—</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Blood Type</div>
                        <div class="info-value" id="viewBlood">—</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Height</div>
                        <div class="info-value" id="viewHeight">—</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Weight</div>
                        <div class="info-value" id="viewWeight">—</div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-label">Primary Symptoms</div>
                        <div class="info-value" id="viewSymptoms" style="white-space:pre-wrap; line-height:1.6;">—</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Final Diagnosis</div>
                        <div class="info-value" id="viewDiagnosis" style="font-weight:700; color:var(--primary);">—</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Attending Physician</div>
                        <div class="info-value" id="viewDoctor">—</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Assigned Room</div>
                        <div class="info-value" id="viewRoom">—</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Consultation Duration</div>
                        <div class="info-value" id="viewDuration">—</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    /* ── View Modal ── */
    function openViewModal(p) {
        document.getElementById('viewAvatar').textContent  = p.name.charAt(0).toUpperCase();
        document.getElementById('viewName').textContent    = p.name;
        document.getElementById('viewId').textContent      = p.id;
        document.getElementById('viewDate').textContent    = p.date;
        document.getElementById('viewTime').textContent    = p.time;
        document.getElementById('viewAge').textContent     = p.age + ' yrs';
        document.getElementById('viewGender').textContent  = p.gender;
        document.getElementById('viewContact').textContent = p.contact;
        document.getElementById('viewAddress').textContent = p.address;
        document.getElementById('viewBlood').textContent   = p.blood;
        document.getElementById('viewHeight').textContent  = p.height;
        document.getElementById('viewWeight').textContent  = p.weight;
        document.getElementById('viewSymptoms').textContent = p.symptoms;
        document.getElementById('viewDiagnosis').textContent = p.diagnosis;
        document.getElementById('viewDoctor').textContent  = p.doctor;
        document.getElementById('viewRoom').textContent    = p.room;
        document.getElementById('viewDuration').textContent = p.duration;
        new bootstrap.Modal(document.getElementById('viewModal')).show();
    }

    /* ── Search ── */
    function filterTable() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('#medicalRecordBody tr').forEach(row => {
            const name = row.querySelector('.patient-name-btn').textContent.toLowerCase();
            row.style.display = name.includes(q) ? '' : 'none';
        });
    }

    /* ── Date filter ── */
    let activeFilter = 'all';
    function setFilter(filter, btn) {
        activeFilter = filter;
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('searchInput').value = '';
        document.querySelectorAll('#medicalRecordBody tr').forEach(row => {
            const date = row.dataset.date;
            row.style.display = (filter === 'all' || date === filter) ? '' : 'none';
        });
    }
</script>
</body>
</html>