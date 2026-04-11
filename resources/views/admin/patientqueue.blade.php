<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure – Patient Queue</title>
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-logo {
            width: 40px; height: 40px;
            background: rgba(255,255,255,.1);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .brand-logo i { color: #4fce9e; font-size: 1.2rem; }

        .brand-name {
            font-family: 'DM Serif Display', serif;
            font-size: 1.1rem;
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
            color: var(--text-primary);
            margin: 0;
            letter-spacing: .01em;
        }

        .topbar-left p {
            font-size: .75rem;
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
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
        }

        /* Content */
        .content { padding: 28px 32px 40px; flex: 1; }

        /* Stats row */
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
        .stat-chip-icon.amber { background: #fff4e5; color: #b07000; }
        .stat-chip-icon.dark  { background: var(--sidebar-bg); color: #4fce9e; }

        .stat-chip-label { font-size: .65rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); }
        .stat-chip-value { font-size: 1.4rem; font-weight: 700; color: var(--text-primary); line-height: 1.1; }

        /* Card Panel */
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
        }

        /* Search / Filter bar */
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

        /* Table */
        .queue-table { width: 100%; border-collapse: separate; border-spacing: 0; }

        .queue-table thead th {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 10px 14px;
            border-bottom: 1px solid var(--border);
        }

        .queue-table tbody tr {
            border-radius: 8px;
            transition: background .12s;
        }

        .queue-table tbody tr:hover { background: #fafcfb; }

        .queue-table tbody td {
            padding: 14px 14px;
            border-bottom: 1px solid var(--border);
            font-size: .845rem;
            vertical-align: middle;
        }

        .queue-table tbody tr:last-child td { border-bottom: none; }

        /* Queue ID */
        .q-id {
            font-family: 'DM Serif Display', serif;
            font-size: 1.05rem;
            color: var(--sidebar-bg);
        }

        /* Patient name — clickable */
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

        /* Status badges */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .badge-status::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .badge-diagnosing {
            background: var(--accent-soft);
            color: var(--primary);
            border: 1px solid #c0dfd0;
        }

        .badge-diagnosing::before { background: var(--primary); animation: pulse 1.6s ease infinite; }

        .badge-waiting {
            background: #fff4e5;
            color: #b07000;
            border: 1px solid #f0d9a0;
        }

        .badge-waiting::before { background: #b07000; }

        .badge-done {
            background: #f0f4f8;
            color: #5a6a7a;
            border: 1px solid #d8e2ec;
        }

        .badge-done::before { background: #5a6a7a; }

        @keyframes pulse {
            0%,100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(1.4); }
        }

        /* Room */
        .room-active { font-weight: 700; color: var(--primary); }
        .room-waiting { color: var(--text-muted); font-style: italic; }

        /* Action buttons */
/* --- Action Buttons: Text Version --- */
.act-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 30px;
    padding: 0 14px;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

/* Edit Button - Uses Dashboard Primary Green */
.act-btn.edit {
    background-color: var(--primary); /* #2d7a50 from your root */
    color: #ffffff;
}

.act-btn.edit:hover {
    background-color: var(--accent); /* #3d8b6e */
    transform: translateY(-1px);
}

/* Done/Disable Button - Uses Dashboard Mint Palette */
.act-btn.done, .act-btn.disable {
    background-color: var(--accent-soft); /* #e8f5f0 */
    border-color: #c0dfd0;
    color: var(--primary); /* Forest green text for readability */
}

.act-btn.done:hover, .act-btn.disable:hover {
    background-color: #d1e7dd;
    color: var(--sidebar-bg); /* Darker green on hover */
}

/* Remove Button - Subtle Red for contrast */
.act-btn.remove {
    background: #fff0f0;
    border: 1px solid #f5b8b8;
    color: #c0392b;
}

.act-btn.remove:hover {
    background: #f8d7da;
}

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

        .modal-title { font-weight: 700; font-size: .95rem; }
        .modal-body { padding: 22px 24px; }
        .modal-footer { padding: 14px 24px; border-top: 1px solid var(--border); }

        /* Info modal field rows */
        .info-label {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 3px;
        }

        .info-value {
            font-size: .875rem;
            font-weight: 500;
            color: var(--text-primary);
            padding: 9px 14px;
            background: var(--page-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
        }

        /* Edit modal form */
        .form-label-custom {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 5px;
            display: block;
        }

        .form-control-custom, .form-select-custom {
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

        .form-control-custom:focus, .form-select-custom:focus {
            border-color: var(--accent);
            background: #fff;
        }

        .btn-primary-custom {
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 9px 22px;
            font-size: .845rem;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: background .18s;
        }

        .btn-primary-custom:hover { background: var(--accent); }

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

        /* Avatar in view modal */
        .patient-avatar-lg {
            width: 56px; height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light));
            color: #fff;
            font-size: 1.4rem;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .view-only-chip {
            background: #fff4e5;
            color: #b07000;
            border: 1px solid #f0d9a0;
            border-radius: 20px;
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .06em;
            padding: 3px 10px;
            text-transform: uppercase;
        }

        /* --- PROFILE MODAL STYLING --- */
.modal-content-clean { 
    border: none; 
    border-radius: 28px; 
    padding: 25px; 
}

/* Header: Pic and Name */
.modal-header-profile { 
    display: flex; 
    align-items: center; 
    gap: 20px; 
    margin-bottom: 30px; 
}

.profile-pic-large { 
    width: 80px; height: 80px; 
    border-radius: 20px; 
    background: #f2f7f5; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 2rem; 
    font-family: 'DM Serif Display', serif; 
    color: #1b3d2f; 
}

.profile-title-area h2 { 
    font-family: 'DM Serif Display', serif; 
    margin: 0; 
    font-size: 1.6rem; 
    color: #1a202c; 
}

/* Tab Underline */
.modal-tabs { 
    display: flex; 
    gap: 25px; 
    border-bottom: 1px solid #e9ecef; 
    margin-bottom: 25px; 
}

.tab-item { 
    padding-bottom: 10px; 
    font-weight: 700; 
    font-size: 0.85rem; 
    color: #718096; 
}

.tab-item.active { 
    color: #3d8b6e; 
    border-bottom: 3px solid #3d8b6e; 
}

/* Info Grid Layout */
.info-grid { 
    display: grid; 
    grid-template-columns: 1fr 1fr; 
    gap: 25px; 
}

.info-row-full { grid-column: span 2; }

.info-box { 
    display: flex; 
    align-items: flex-start; 
    gap: 15px; 
}

.info-icon { 
    width: 38px; height: 38px; 
    border-radius: 10px; 
    background: #f2f7f5; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    color: #3d8b6e; 
    font-size: 1.1rem; 
}

.info-content label { 
    display: block; 
    font-size: 0.65rem; 
    text-transform: uppercase; 
    font-weight: 800; 
    color: #718096; 
    margin-bottom: 2px; 
}

.info-content span { 
    font-size: 1rem; 
    font-weight: 700; 
    color: #1a202c; 
}

/* Rounded Close Button */
.btn-close-custom { 
    width: 100%; 
    padding: 14px; 
    border-radius: 50px; 
    border: 1px solid #e9ecef; 
    background: white; 
    font-weight: 700; 
    color: #718096; 
    margin-top: 35px; 
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
                <button type="submit" class="sidebar-link w-100 text-start" style="background:none;border:none;padding:8px 6px;cursor:pointer;">
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
            <h3>Patient Queue</h3>
            <p>Monitoring live diagnostic flow</p>
        </div>
        <<div class="topbar-actions">
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
                    <div class="stat-chip-icon dark"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="stat-chip-label">Total in Queue</div>
                        <div class="stat-chip-value">4</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon green"><i class="bi bi-activity"></i></div>
                    <div>
                        <div class="stat-chip-label">Being Diagnosed</div>
                        <div class="stat-chip-value">2</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon amber"><i class="bi bi-hourglass-split"></i></div>
                    <div>
                        <div class="stat-chip-label">Waiting</div>
                        <div class="stat-chip-value">2</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Queue Table Card -->
        <div class="card-panel">
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <div class="panel-title mb-0">Active Queue</div>
                    <p class="mb-0" style="font-size:.75rem; color:var(--text-muted);">Click a patient's name to view their full info</p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="position-relative">
                        <i class="bi bi-search position-absolute" style="left:11px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:.8rem;"></i>
                        <input type="text" class="search-input" placeholder="Search patient…" id="searchInput" oninput="filterTable()">
                    </div>
                    <button class="filter-btn active" onclick="setFilter('all', this)">All</button>
                    <button class="filter-btn" onclick="setFilter('diagnosing', this)">Diagnosing</button>
                    <button class="filter-btn" onclick="setFilter('waiting', this)">Waiting</button>
                </div>
            </div>

            <table class="queue-table">
                <thead>
                    <tr>
                        <th>Queue ID</th>
                        <th>Patient</th>
                        <th>Status</th>
                        <th>Room</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody id="queueBody">

                    <!-- Row 1 -->
                    <tr data-status="diagnosing">
                        <tr data-status="diagnosing">
    <td><span class="q-id">Q-001</span></td>
    <td>
        <button class="patient-name-btn" onclick="openViewModal({
            id: 'Q-001', name: 'Elena Rodriguez', time: '08:30 AM',
            age: 27, gender: 'Female', contact: '+63 912 345 6789',
            address: '14 Mahogany St, Davao City',
            blood: 'O+', height: '165 cm', weight: '55 kg',
            symptoms: 'Persistent headache and mild fever for 3 days. Reports fatigue and occasional dizziness.',
            status: 'Being Diagnosed', room: 'Room 02'
        })">Elena Rodriguez</button>
        <div style="font-size:.72rem; color:var(--text-muted);">08:30 AM</div>
    </td>
    <td><span class="badge-status badge-diagnosing">Being Diagnosed</span></td>
    <td><span class="room-active">Room 02</span></td>
    <td style="text-align:right;">
        <button class="act-btn edit" onclick="openEditModal({ id: 'Q-001', name: 'Elena Rodriguez', status: 'diagnosing', room: 'Room 02' })">Edit</button>
        <button class="act-btn done ms-1">Done</button>
    </td>
</tr>

<tr data-status="waiting">
    <td><span class="q-id">Q-002</span></td>
    <td>
        <button class="patient-name-btn" onclick="openViewModal({
            id: 'Q-002', name: 'Marcus Chen', time: '08:45 AM',
            age: 34, gender: 'Male', contact: '+63 917 654 3210',
            address: '7 Acacia Lane, Calinan, Davao City',
            blood: 'A+', height: '172 cm', weight: '70 kg',
            symptoms: 'Chest tightness and shortness of breath since this morning. No prior cardiac history.',
            status: 'Waiting', room: 'Waiting Area'
        })">Marcus Chen</button>
        <div style="font-size:.72rem; color:var(--text-muted);">08:45 AM</div>
    </td>
    <td><span class="badge-status badge-waiting">Waiting</span></td>
    <td><span class="room-waiting">Waiting Area</span></td>
    <td style="text-align:right;">
        <button class="act-btn edit" onclick="openEditModal({ id: 'Q-002', name: 'Marcus Chen', status: 'waiting', room: '' })">Edit</button>
        <button class="act-btn remove ms-1">Remove</button>
    </td>
</tr>

<tr data-status="diagnosing">
    <td><span class="q-id">Q-003</span></td>
    <td>
        <button class="patient-name-btn" onclick="openViewModal({
            id: 'Q-003', name: 'Sofia Reyes', time: '09:10 AM',
            age: 22, gender: 'Female', contact: '+63 920 111 2233',
            address: '3 Rosewood Dr, Toril, Davao City',
            blood: 'B-', height: '158 cm', weight: '48 kg',
            symptoms: 'Severe abdominal pain and nausea. Last meal 6 hours ago. Vomited twice.',
            status: 'Being Diagnosed', room: 'Room 01'
        })">Sofia Reyes</button>
        <div style="font-size:.72rem; color:var(--text-muted);">09:10 AM</div>
    </td>
    <td><span class="badge-status badge-diagnosing">Being Diagnosed</span></td>
    <td><span class="room-active">Room 01</span></td>
    <td style="text-align:right;">
        <button class="act-btn edit" onclick="openEditModal({ id: 'Q-003', name: 'Sofia Reyes', status: 'diagnosing', room: 'Room 01' })">Edit</button>
        <button class="act-btn done ms-1">Done</button>
    </td>
</tr>

<tr data-status="waiting">
    <td><span class="q-id">Q-004</span></td>
    <td>
        <button class="patient-name-btn" onclick="openViewModal({
            id: 'Q-004', name: 'James Villanueva', time: '09:25 AM',
            age: 45, gender: 'Male', contact: '+63 905 887 7654',
            address: '21 Palm Ave, Mintal, Davao City',
            blood: 'AB+', height: '175 cm', weight: '82 kg',
            symptoms: 'Lower back pain radiating to the right leg. Pain score 7/10. Has history of lumbar disc issues.',
            status: 'Waiting', room: 'Waiting Area'
        })">James Villanueva</button>
        <div style="font-size:.72rem; color:var(--text-muted);">09:25 AM</div>
    </td>
    <td><span class="badge-status badge-waiting">Waiting</span></td>
    <td><span class="room-waiting">Waiting Area</span></td>
    <td style="text-align:right;">
        <button class="act-btn edit" onclick="openEditModal({ id: 'Q-004', name: 'James Villanueva', status: 'waiting', room: '' })">Edit</button>
        <button class="act-btn remove ms-1">Remove</button>
    </td>
</tr>
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
                            <span class="modal-title" id="viewName">Elena Rodriguez</span>
                            <span class="view-only-chip">View Only</span>
                        </div>
                        <div style="font-size:.75rem; color:var(--text-muted);">
                            <span id="viewId"></span> &nbsp;·&nbsp; Arrived at <span id="viewTime"></span>
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
                        <div class="info-label">Current Status</div>
                        <div class="info-value" id="viewStatus">—</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Assigned Room</div>
                        <div class="info-value" id="viewRoom">—</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- ══════════════ EDIT MODAL ══════════════ -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-gear me-2" style="color:var(--primary);"></i>Edit Patient Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label-custom">Full Name</label>
                        <input type="text" class="form-control-custom" id="editName">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Queue ID</label>
                        <input type="text" class="form-control-custom" id="editQueueId" readonly style="background:#f8f9fa;">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-custom">Age</label>
                        <input type="number" class="form-control-custom" id="editAge">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Gender</label>
                        <select class="form-select-custom" id="editGender">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Blood Type</label>
                        <input type="text" class="form-control-custom" id="editBlood">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-custom">Contact Number</label>
                        <input type="text" class="form-control-custom" id="editContact">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label-custom">Address</label>
                        <input type="text" class="form-control-custom" id="editAddress">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-custom">Height</label>
                        <input type="text" class="form-control-custom" id="editHeight">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Weight</label>
                        <input type="text" class="form-control-custom" id="editWeight">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label-custom">Symptoms</label>
                        <textarea class="form-control-custom" id="editSymptoms" rows="3"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label-custom">Status</label>
                        <select class="form-select-custom" id="editStatus">
                            <option value="waiting">Waiting</option>
                            <option value="diagnosing">Being Diagnosed</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Assigned Room</label>
                        <select class="form-select-custom" id="editRoom">
                            <option value="">Waiting Area</option>
                            <option value="Room 01">Room 01</option>
                            <option value="Room 02">Room 02</option>
                            <option value="Room 03">Room 03</option>
                            <option value="Room 04">Room 04</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn-primary-custom" data-bs-dismiss="modal">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="staffProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-clean">
            
            <div class="modal-header-profile">
                <div class="profile-pic-large">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div class="profile-title-area">
                    <h2>{{ Auth::user()->name }}</h2>
                    <p class="text-muted small">{{ Auth::user()->role ?? 'Medical Staff' }}</p>
                </div>
            </div>

            <div class="modal-tabs">
                <div class="tab-item active">Information</div>
                <div class="tab-item">Account</div>
            </div>

            <div class="info-grid">
                <div class="info-box info-row-full">
                    <div class="info-icon"><i class="bi bi-person-badge"></i></div>
                    <div class="info-content">
                        <label>Full Name</label>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-calendar-event"></i></div>
                    <div class="info-content">
                        <label>Age</label>
                        <span>28 Years</span>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-gender-ambiguous"></i></div>
                    <div class="info-content">
                        <label>Gender</label>
                        <span>Female</span>
                    </div>
                </div>

                <div class="info-box info-row-full">
                    <div class="info-icon"><i class="bi bi-geo-alt"></i></div>
                    <div class="info-content">
                        <label>Address</label>
                        <span>123 Medical Ave, Davao City</span>
                    </div>
                </div>

                <hr class="info-row-full" style="opacity: 0.1; margin: 5px 0;">

                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-card-text"></i></div>
                    <div class="info-content">
                        <label>Staff ID Number</label>
                        <span>ID-{{ Auth::user()->id ?? '88291' }}</span>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-briefcase"></i></div>
                    <div class="info-content">
                        <label>Current Role</label>
                        <span>Front Desk</span>
                    </div>
                </div>
            </div>

            <button type="button" class="btn-close-custom" data-bs-dismiss="modal">Close</button>
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
        document.getElementById('viewTime').textContent    = p.time;
        document.getElementById('viewAge').textContent     = p.age + ' yrs';
        document.getElementById('viewGender').textContent  = p.gender;
        document.getElementById('viewContact').textContent = p.contact;
        document.getElementById('viewAddress').textContent = p.address;
        document.getElementById('viewBlood').textContent   = p.blood;
        document.getElementById('viewHeight').textContent  = p.height;
        document.getElementById('viewWeight').textContent  = p.weight;
        document.getElementById('viewSymptoms').textContent = p.symptoms;
        document.getElementById('viewStatus').textContent  = p.status;
        document.getElementById('viewRoom').textContent    = p.room;
        new bootstrap.Modal(document.getElementById('viewModal')).show();
    }

    /* ── Edit Modal ── */
   function openEditModal(p) {
    // Populate all fields
    document.getElementById('editName').value = p.name;
    document.getElementById('editQueueId').value = p.id;
    document.getElementById('editAge').value = p.age;
    document.getElementById('editGender').value = p.gender;
    document.getElementById('editContact').value = p.contact;
    document.getElementById('editAddress').value = p.address;
    document.getElementById('editBlood').value = p.blood;
    document.getElementById('editHeight').value = p.height;
    document.getElementById('editWeight').value = p.weight;
    document.getElementById('editSymptoms').value = p.symptoms;
    document.getElementById('editStatus').value = p.status;
    document.getElementById('editRoom').value = p.room;

    // Open Modal
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

    /* ── Search ── */
    function filterTable() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('#queueBody tr').forEach(row => {
            const name = row.querySelector('.patient-name-btn').textContent.toLowerCase();
            row.style.display = name.includes(q) ? '' : 'none';
        });
    }

    /* ── Status filter ── */
    let activeFilter = 'all';
    function setFilter(filter, btn) {
        activeFilter = filter;
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('#queueBody tr').forEach(row => {
            const status = row.dataset.status;
            row.style.display = (filter === 'all' || status === filter) ? '' : 'none';
        });
    }
</script>
</body>
</html>