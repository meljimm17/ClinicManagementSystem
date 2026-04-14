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
            --sidebar-bg: #1b3d2f; --sidebar-hover: #254d3c; --sidebar-active: #2e6048;
            --accent: #3d8b6e; --accent-light: #4fa882; --accent-soft: #e8f5f0;
            --text-primary: #1a2e25; --text-muted: #6b7f77; --border: #e4ece8;
            --card-bg: #ffffff; --page-bg: #f4f7f5; --primary: #2d7a50;
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
        .topbar-icon { width: 36px; height: 36px; border-radius: 8px; background: var(--page-bg); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: .95rem; cursor: pointer; }
        .topbar-icon:hover { background: var(--accent-soft); color: var(--accent); }
        .avatar { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light)); color: #fff; font-size: .8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; }
        .content { padding: 28px 32px 40px; flex: 1; }
        .stat-chip { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; gap: 14px; }
        .stat-chip-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .stat-chip-icon.green { background: var(--accent-soft); color: var(--primary); }
        .stat-chip-icon.dark  { background: var(--sidebar-bg); color: #4fce9e; }
        .stat-chip-icon.slate { background: #f0f4f8; color: #5a6a7a; }
        .stat-chip-label { font-size: .65rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); }
        .stat-chip-value { font-size: 1.4rem; font-weight: 700; color: var(--text-primary); line-height: 1.1; }
        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); }
        .search-input { border: 1px solid var(--border); border-radius: 8px; padding: 8px 14px 8px 36px; font-size: .845rem; font-family: 'DM Sans', sans-serif; background: var(--page-bg); color: var(--text-primary); outline: none; width: 220px; transition: border-color .15s, width .2s; }
        .search-input:focus { border-color: var(--accent); width: 260px; background: #fff; }
        .filter-btn { border: 1px solid var(--border); border-radius: 8px; padding: 8px 14px; font-size: .8rem; font-family: 'DM Sans', sans-serif; background: var(--page-bg); color: var(--text-muted); cursor: pointer; transition: all .15s; }
        .filter-btn.active, .filter-btn:hover { background: var(--accent-soft); border-color: #c0dfd0; color: var(--primary); }
        .medical-record-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .medical-record-table thead th { font-size: .65rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); padding: 10px 14px; border-bottom: 1px solid var(--border); }
        .medical-record-table tbody tr { transition: background .12s; }
        .medical-record-table tbody tr:hover { background: #fafcfb; }
        .medical-record-table tbody td { padding: 14px 14px; border-bottom: 1px solid var(--border); font-size: .845rem; vertical-align: middle; }
        .medical-record-table tbody tr:last-child td { border-bottom: none; }
        .q-id { font-family: 'DM Serif Display', serif; font-size: 1.05rem; color: var(--sidebar-bg); }
        .patient-name-btn { background: none; border: none; padding: 0; font-family: 'DM Sans', sans-serif; font-size: .875rem; font-weight: 600; color: var(--text-primary); cursor: pointer; text-align: left; text-decoration: underline; text-decoration-color: transparent; text-underline-offset: 3px; transition: color .15s, text-decoration-color .15s; }
        .patient-name-btn:hover { color: var(--primary); text-decoration-color: var(--primary); }
        .diag-chip { display: inline-block; background: var(--accent-soft); color: var(--primary); border: 1px solid #c0dfd0; border-radius: 20px; font-size: .7rem; font-weight: 600; padding: 3px 10px; }
        .doctor-name { font-size: .845rem; font-weight: 500; color: var(--text-primary); }
        .doctor-role { font-size: .7rem; color: var(--text-muted); }
        .duration-chip { font-size: .78rem; font-weight: 600; color: var(--text-muted); }
        .act-btn { width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border); background: var(--page-bg); color: var(--text-muted); display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; cursor: pointer; transition: all .15s; }
        .act-btn:hover { background: var(--accent-soft); border-color: #c0dfd0; color: var(--primary); }
        /* Modal */
        .modal-content { border: 1px solid var(--border); border-radius: 14px; font-family: 'DM Sans', sans-serif; }
        .modal-header { padding: 20px 24px 16px; border-bottom: 1px solid var(--border); }
        .modal-title { font-weight: 700; font-size: .95rem; }
        .modal-body { padding: 22px 24px; }
        .modal-footer { padding: 14px 24px; border-top: 1px solid var(--border); }
        .info-label { font-size: .65rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 3px; }
        .info-value { font-size: .875rem; font-weight: 500; color: var(--text-primary); padding: 9px 14px; background: var(--page-bg); border: 1px solid var(--border); border-radius: 8px; }
        .patient-avatar-lg { width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light)); color: #fff; font-size: 1.4rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-family: 'DM Serif Display', serif; }
        .view-only-chip { background: #f0f4f8; color: #5a6a7a; border: 1px solid #d8e2ec; border-radius: 20px; font-size: .65rem; font-weight: 700; letter-spacing: .06em; padding: 3px 10px; text-transform: uppercase; }
        .btn-ghost { background: none; border: 1px solid var(--border); border-radius: 8px; padding: 9px 18px; font-size: .845rem; font-family: 'DM Sans', sans-serif; color: var(--text-muted); cursor: pointer; transition: all .15s; }
        .btn-ghost:hover { background: var(--page-bg); color: var(--text-primary); }
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
            <h3>Patient Medical Records</h3>
            <p>All completed consultations and diagnoses</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-icon"><i class="bi bi-bell"></i></div>
            <div class="topbar-icon"><i class="bi bi-gear"></i></div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <main class="content">

        <!-- Stat Chips — real counts -->
        @php
            $totalCompleted  = $records->where('record_status', 'completed')->count();
            $todayCompleted  = $records->where('consultation_date', today()->toDateString())->count();
            $avgDuration     = $records->whereNotNull('duration_minutes')->avg('duration_minutes');
        @endphp
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon dark"><i class="bi bi-check2-all"></i></div>
                    <div>
                        <div class="stat-chip-label">Total Completed</div>
                        <div class="stat-chip-value">{{ $totalCompleted }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon green"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <div class="stat-chip-label">Completed Today</div>
                        <div class="stat-chip-value">{{ $todayCompleted }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon slate"><i class="bi bi-stopwatch"></i></div>
                    <div>
                        <div class="stat-chip-label">Avg. Consult Time</div>
                        <div class="stat-chip-value">{{ $avgDuration ? round($avgDuration).' min' : '—' }}</div>
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
                    @forelse($mappedRecords as $r)
                    @php
                        $recDate  = \Carbon\Carbon::parse($records[$loop->index]->consultation_date);
                        $dateKey  = $recDate->isToday() ? 'today' : ($recDate->isYesterday() ? 'yesterday' : 'older');
                    @endphp
                    <tr data-date="{{ $dateKey }}">
                        <td><span class="q-id">{{ $records[$loop->index]->queue_id ?? '—' }}</span></td>
                        <td>
                            <button class="patient-name-btn" onclick="openViewModal({
                                id: '{{ $records[$loop->index]->queue_id ?? '—' }}',
                                name: '{{ addslashes($r['patient_name']) }}',
                                date: '{{ $r['date'] }}',
                                time: '{{ $r['time'] ?? '—' }}',
                                age: '{{ $r['age'] ?? '—' }}',
                                gender: '{{ $r['gender'] ?? '—' }}',
                                contact: '{{ addslashes($r['contact'] ?? '—') }}',
                                address: '{{ addslashes($r['address'] ?? '—') }}',
                                blood: '{{ $r['blood_type'] ?? '—' }}',
                                height: '{{ $r['height'] ?? '—' }}',
                                weight: '{{ $r['weight'] ?? '—' }}',
                                symptoms: '{{ addslashes($r['symptoms'] ?? '—') }}',
                                diagnosis: '{{ addslashes($r['diagnosis'] ?? '—') }}',
                                prescription: '{{ addslashes($r['prescription'] ?? '—') }}',
                                notes: '{{ addslashes($r['notes'] ?? '—') }}',
                                doctor: '{{ addslashes($r['doctor'] ?? '—') }}',
                                duration: '{{ $r['duration'] ? $r['duration'].' min' : '—' }}',
                                room: '{{ $r['room'] ?? '—' }}'
                            })">{{ $r['patient_name'] }}</button>
                            <div style="font-size:.72rem; color:var(--text-muted);">
                                {{ $r['gender'] ?? '' }}{{ $r['age'] ? ' · '.$r['age'].' yrs' : '' }}
                            </div>
                        </td>
                        <td>
                            @if($r['diagnosis'])
                                <span class="diag-chip">{{ Str::limit($r['diagnosis'], 30) }}</span>
                            @else
                                <span style="color:var(--text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="doctor-name">{{ $r['doctor'] ?? '—' }}</div>
                            <div class="doctor-role">Physician</div>
                        </td>
                        <td>
                            <div style="font-size:.845rem;">{{ $r['date'] }}</div>
                            @if($r['time'])
                            <div style="font-size:.72rem; color:var(--text-muted);">{{ $r['time'] }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="duration-chip">
                                @if($r['duration'])
                                    <i class="bi bi-clock me-1"></i>{{ $r['duration'] }} min
                                @else
                                    —
                                @endif
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <button class="act-btn" title="View Record" onclick="openViewModal({
                                id: '{{ $records[$loop->index]->queue_id ?? '—' }}',
                                name: '{{ addslashes($r['patient_name']) }}',
                                date: '{{ $r['date'] }}',
                                time: '{{ $r['time'] ?? '—' }}',
                                age: '{{ $r['age'] ?? '—' }}',
                                gender: '{{ $r['gender'] ?? '—' }}',
                                contact: '{{ addslashes($r['contact'] ?? '—') }}',
                                address: '{{ addslashes($r['address'] ?? '—') }}',
                                blood: '{{ $r['blood_type'] ?? '—' }}',
                                height: '{{ $r['height'] ?? '—' }}',
                                weight: '{{ $r['weight'] ?? '—' }}',
                                symptoms: '{{ addslashes($r['symptoms'] ?? '—') }}',
                                diagnosis: '{{ addslashes($r['diagnosis'] ?? '—') }}',
                                prescription: '{{ addslashes($r['prescription'] ?? '—') }}',
                                notes: '{{ addslashes($r['notes'] ?? '—') }}',
                                doctor: '{{ addslashes($r['doctor'] ?? '—') }}',
                                duration: '{{ $r['duration'] ? $r['duration'].' min' : '—' }}',
                                room: '{{ $r['room'] ?? '—' }}'
                            })"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px 0; color:var(--text-muted);">
                            <i class="bi bi-journal-x" style="font-size:1.5rem; display:block; margin-bottom:8px;"></i>
                            No medical records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

    <footer class="dash-footer">
        <span>© 2024 CuraSure · Staff Portal</span>
        <div class="footer-links"><a href="#">Privacy Protocol</a><a href="#">Support</a></div>
    </footer>
</div>

<!-- VIEW MODAL -->
<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="patient-avatar-lg" id="viewAvatar">—</div>
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
                    <div class="col-md-4"><div class="info-label">Age</div><div class="info-value" id="viewAge">—</div></div>
                    <div class="col-md-4"><div class="info-label">Gender</div><div class="info-value" id="viewGender">—</div></div>
                    <div class="col-md-4"><div class="info-label">Contact Number</div><div class="info-value" id="viewContact">—</div></div>
                    <div class="col-md-12"><div class="info-label">Address</div><div class="info-value" id="viewAddress">—</div></div>
                    <div class="col-md-4"><div class="info-label">Blood Type</div><div class="info-value" id="viewBlood">—</div></div>
                    <div class="col-md-4"><div class="info-label">Height</div><div class="info-value" id="viewHeight">—</div></div>
                    <div class="col-md-4"><div class="info-label">Weight</div><div class="info-value" id="viewWeight">—</div></div>
                    <div class="col-md-12"><div class="info-label">Primary Symptoms</div><div class="info-value" id="viewSymptoms" style="white-space:pre-wrap;line-height:1.6;">—</div></div>
                    <div class="col-md-6"><div class="info-label">Final Diagnosis</div><div class="info-value" id="viewDiagnosis" style="font-weight:700;color:var(--primary);">—</div></div>
                    <div class="col-md-6"><div class="info-label">Attending Physician</div><div class="info-value" id="viewDoctor">—</div></div>
                    <div class="col-md-12"><div class="info-label">Prescription</div><div class="info-value" id="viewPrescription" style="white-space:pre-wrap;">—</div></div>
                    <div class="col-md-12"><div class="info-label">Notes</div><div class="info-value" id="viewNotes" style="white-space:pre-wrap;">—</div></div>
                    <div class="col-md-6"><div class="info-label">Assigned Room</div><div class="info-value" id="viewRoom">—</div></div>
                    <div class="col-md-6"><div class="info-label">Consultation Duration</div><div class="info-value" id="viewDuration">—</div></div>
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
    function openViewModal(p) {
        document.getElementById('viewAvatar').textContent      = p.name.charAt(0).toUpperCase();
        document.getElementById('viewName').textContent        = p.name;
        document.getElementById('viewId').textContent          = p.id;
        document.getElementById('viewDate').textContent        = p.date;
        document.getElementById('viewTime').textContent        = p.time;
        document.getElementById('viewAge').textContent         = p.age + ' yrs';
        document.getElementById('viewGender').textContent      = p.gender;
        document.getElementById('viewContact').textContent     = p.contact;
        document.getElementById('viewAddress').textContent     = p.address;
        document.getElementById('viewBlood').textContent       = p.blood;
        document.getElementById('viewHeight').textContent      = p.height;
        document.getElementById('viewWeight').textContent      = p.weight;
        document.getElementById('viewSymptoms').textContent    = p.symptoms;
        document.getElementById('viewDiagnosis').textContent   = p.diagnosis;
        document.getElementById('viewPrescription').textContent = p.prescription;
        document.getElementById('viewNotes').textContent       = p.notes;
        document.getElementById('viewDoctor').textContent      = p.doctor;
        document.getElementById('viewRoom').textContent        = p.room;
        document.getElementById('viewDuration').textContent    = p.duration;
        new bootstrap.Modal(document.getElementById('viewModal')).show();
    }

    function filterTable() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('#medicalRecordBody tr[data-date]').forEach(row => {
            const name = row.querySelector('.patient-name-btn')?.textContent.toLowerCase() ?? '';
            row.style.display = name.includes(q) ? '' : 'none';
        });
    }

    let activeFilter = 'all';
    function setFilter(filter, btn) {
        activeFilter = filter;
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('searchInput').value = '';
        document.querySelectorAll('#medicalRecordBody tr[data-date]').forEach(row => {
            row.style.display = (filter === 'all' || row.dataset.date === filter) ? '' : 'none';
        });
    }
</script>
</body>
</html>