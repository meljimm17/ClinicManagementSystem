<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure - Medical Records</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
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
            width: 220px; min-height: 100vh; background: var(--sidebar-bg);
            display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100;
        }
        .sidebar-brand {
            padding: 28px 22px 20px; border-bottom: 1px solid rgba(255,255,255,.08);
            display: flex; align-items: center; gap: 8px;
        }
        .brand-logo {
            width: 40px; height: 40px; background: rgba(255,255,255,.1); border-radius: 10px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .brand-logo i { color: #4fce9e; font-size: 1.2rem; }
        .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.1rem; color: #fff; line-height: 1.2; }
        .sidebar-nav { flex: 1; padding: 14px 0; }
        .sidebar-link {
            display: flex; align-items: center; gap: 11px; padding: 10px 22px;
            color: rgba(255,255,255,.65); text-decoration: none; font-size: .875rem;
            font-weight: 400; border-left: 3px solid transparent; transition: all .18s ease;
        }
        .sidebar-link:hover { background: var(--sidebar-hover); color: #fff; }
        .sidebar-link.active { background: var(--sidebar-active); color: #fff; border-left-color: var(--accent-light); font-weight: 500; }
        .sidebar-link i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-bottom { padding: 16px 16px 24px; border-top: 1px solid rgba(255,255,255,.08); }
        .sidebar-footer { padding: 6px 0 0; }
        .btn-logout {
            display: flex; align-items: center; gap: 10px; width: 100%; background: none; border: none;
            padding: 8px 6px; color: rgba(255,255,255,.65); font-size: .82rem; font-family: 'DM Sans', sans-serif;
            cursor: pointer; border-left: 3px solid transparent; transition: all .18s; text-align: left;
        }
        .btn-logout:hover { background: var(--sidebar-hover); color: #fff; }

        /* ── Main ── */
        .main-wrap { margin-left: 220px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            background: rgba(255,255,255,.85); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border);
            padding: 0 32px; height: 58px; display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-left h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; }
        .topbar-left p  { font-size: .75rem; color: var(--text-muted); margin: 2px 0 0; }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .topbar-icon {
            width: 36px; height: 36px; border-radius: 8px; background: var(--page-bg); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: .95rem; cursor: pointer;
        }
        .topbar-icon:hover { background: var(--accent-soft); color: var(--accent); }
        .avatar {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light));
            color: #fff; font-size: .8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; cursor: pointer;
        }

        .content { padding: 28px 32px 40px; flex: 1; }

        /* Stat chips */
        .stat-chip { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 16px 20px; display: flex; align-items: center; gap: 14px; }
        .stat-chip-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .stat-chip-icon.green { background: var(--accent-soft); color: var(--primary); }
        .stat-chip-icon.dark  { background: var(--sidebar-bg); color: #4fce9e; }
        .stat-chip-icon.slate { background: #f0f4f8; color: #5a6a7a; }
        .stat-chip-label { font-size: .65rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); }
        .stat-chip-value { font-size: 1.4rem; font-weight: 700; color: var(--text-primary); line-height: 1.1; }

        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); }

        .search-input {
            border: 1px solid var(--border); border-radius: 8px; padding: 8px 14px 8px 36px;
            font-size: .845rem; font-family: 'DM Sans', sans-serif; background: var(--page-bg);
            color: var(--text-primary); outline: none; width: 220px; transition: border-color .15s, width .2s;
        }
        .search-input:focus { border-color: var(--accent); width: 260px; background: #fff; }

        .filter-btn {
            border: 1px solid var(--border); border-radius: 8px; padding: 8px 14px; font-size: .8rem;
            font-family: 'DM Sans', sans-serif; background: var(--page-bg); color: var(--text-muted); cursor: pointer; transition: all .15s;
        }
        .filter-btn.active, .filter-btn:hover { background: var(--accent-soft); border-color: #c0dfd0; color: var(--primary); }

        .medical-record-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .medical-record-table thead th {
            font-size: .65rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase;
            color: var(--text-muted); padding: 10px 14px; border-bottom: 1px solid var(--border);
        }
        .medical-record-table tbody tr { transition: background .12s; }
        .medical-record-table tbody tr:hover { background: #fafcfb; }
        .medical-record-table tbody td { padding: 14px 14px; border-bottom: 1px solid var(--border); font-size: .845rem; vertical-align: middle; }
        .medical-record-table tbody tr:last-child td { border-bottom: none; }

        .q-id { font-family: 'DM Serif Display', serif; font-size: 1.05rem; color: var(--sidebar-bg); }
        .patient-name-btn {
            background: none; border: none; padding: 0; font-family: 'DM Sans', sans-serif; font-size: .875rem;
            font-weight: 600; color: var(--text-primary); cursor: pointer; text-align: left;
            text-decoration: underline; text-decoration-color: transparent; text-underline-offset: 3px; transition: color .15s, text-decoration-color .15s;
        }
        .patient-name-btn:hover { color: var(--primary); text-decoration-color: var(--primary); }

        .diag-chip { display: inline-block; background: var(--accent-soft); color: var(--primary); border: 1px solid #c0dfd0; border-radius: 20px; font-size: .7rem; font-weight: 600; padding: 3px 10px; }

        .act-btn {
            width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border); background: var(--page-bg);
            color: var(--text-muted); display: inline-flex; align-items: center; justify-content: center; font-size: .85rem; cursor: pointer; transition: all .15s;
        }
        .act-btn:hover { background: var(--accent-soft); border-color: #c0dfd0; color: var(--primary); }

        /* ── Modal ── */
        .modal-content { border: 1px solid var(--border); border-radius: 16px; font-family: 'DM Sans', sans-serif; overflow: hidden; }
        .modal-header { padding: 20px 24px 16px; border-bottom: 1px solid var(--border); }
        .modal-title { font-weight: 700; font-size: .95rem; }
        .modal-body { padding: 22px 24px; max-height: 60vh; overflow-y: auto; }
        .modal-footer { padding: 14px 24px; border-top: 1px solid var(--border); }

        /* Modern Tab Buttons */
        .modal-tabs {
            display: flex; gap: 6px; padding: 10px 24px;
            background: var(--page-bg); border-bottom: 1px solid var(--border);
        }

        .modal-tab-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 16px; border-radius: 8px; border: 1px solid transparent;
            background: none; font-size: .8rem; font-weight: 600;
            font-family: 'DM Sans', sans-serif; color: var(--text-muted);
            cursor: pointer; transition: all .18s;
        }

        .modal-tab-btn i { font-size: .88rem; }

        .modal-tab-btn:hover { background: var(--card-bg); border-color: var(--border); color: var(--text-primary); }

        .modal-tab-btn.active {
            background: var(--card-bg); border-color: var(--border);
            color: var(--primary); box-shadow: 0 1px 4px rgba(0,0,0,.07);
        }

        /* Section label inside modal */
        .modal-section-title {
            font-size: .63rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
            color: var(--text-muted); margin: 4px 0 12px;
            display: flex; align-items: center; gap: 8px;
        }
        .modal-section-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }

        .info-label { font-size: .63rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 3px; }
        .info-value {
            font-size: .875rem; font-weight: 500; color: var(--text-primary);
            padding: 9px 14px; background: var(--page-bg); border: 1px solid var(--border);
            border-radius: 8px; min-height: 38px; line-height: 1.5;
        }

        .patient-avatar-lg {
            width: 52px; height: 52px; border-radius: 14px;
            background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light));
            color: #fff; font-size: 1.3rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-family: 'DM Serif Display', serif;
        }

        .view-only-chip {
            background: var(--accent-soft); color: var(--primary); border: 1px solid #c0dfd0;
            border-radius: 20px; font-size: .62rem; font-weight: 700;
            letter-spacing: .06em; padding: 2px 10px; text-transform: uppercase;
        }

        .btn-ghost {
            background: none; border: 1px solid var(--border); border-radius: 8px; padding: 9px 18px;
            font-size: .845rem; font-family: 'DM Sans', sans-serif; color: var(--text-muted); cursor: pointer; transition: all .15s;
        }
        .btn-ghost:hover { background: var(--page-bg); color: var(--text-primary); }

        .dash-footer { font-size: .7rem; color: var(--text-muted); border-top: 1px solid var(--border); padding: 14px 32px; display: flex; justify-content: space-between; }
        .footer-links a { color: var(--text-muted); text-decoration: none; margin-left: 18px; }
        .footer-links a:hover { color: var(--accent); }
    </style>
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('img/logo.png') }}" alt="CuraSure" style="width:64px; height:64px; object-fit:contain; border-radius:8px;">
        <div class="brand-name">CuraSure</div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('doctor.dashboard') }}" class="sidebar-link {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        <a href="{{ route('doctor.queue') }}" class="sidebar-link {{ request()->routeIs('doctor.queue') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Patient Queue
        </a>
        <a href="{{ route('doctor.medical-records') }}" class="sidebar-link {{ request()->routeIs('doctor.medical-records') ? 'active' : '' }}">
            <i class="bi bi-journal-medical"></i> Medical Records
        </a>
    </nav>
    <div class="sidebar-bottom">
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-left"></i> Logout</button>
            </form>
        </div>
    </div>
</aside>

{{-- Main Content --}}
<div class="main-wrap">
    <header class="topbar">
        <div class="topbar-left">
            <h3>Medical Records</h3>
            <p>All completed consultations and diagnoses</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-icon"><i class="bi bi-bell"></i></div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <main class="content">

        @php
            // SORTING RECORDS BY DESCENDING ID
            $records = $records->sortByDesc('id');

            $totalRecords = $records->count();
            $todayRecords = $records->filter(fn($r) => \Carbon\Carbon::parse($r->consultation_date)->isToday())->count();
            
            $avgMinutes   = null;
            $withTimes    = \App\Models\PatientQueue::whereNotNull('called_at')
                            ->whereNotNull('completed_at')
                            ->where('status', 'done')
                            ->get();

            if ($withTimes->count() > 0) {
                $total      = $withTimes->sum(fn($q) => \Carbon\Carbon::parse($q->called_at)->diffInMinutes(\Carbon\Carbon::parse($q->completed_at)));
                $avgMinutes = round($total / $withTimes->count());
            }
        @endphp

        {{-- Statistics --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon dark"><i class="bi bi-check2-all"></i></div>
                    <div>
                        <div class="stat-chip-label">Total Records</div>
                        <div class="stat-chip-value">{{ $totalRecords }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon green"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <div class="stat-chip-label">Completed Today</div>
                        <div class="stat-chip-value">{{ $todayRecords }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon slate"><i class="bi bi-stopwatch"></i></div>
                    <div>
                        <div class="stat-chip-label">Avg. Consult Time</div>
                        <div class="stat-chip-value">{{ $avgMinutes !== null ? $avgMinutes . ' min' : '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Panel --}}
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
                </div>
            </div>

            <table class="medical-record-table">
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Patient</th>
                        <th>Diagnosis</th>
                        <th>Date &amp; Time</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody id="medicalRecordBody">
                    @forelse($records as $r)
                    @php 
                        $isToday = \Carbon\Carbon::parse($r->consultation_date)->isToday(); 
                        // FIX: Priority is given to the stored patient_name column
                        $display_name = $r->patient_name ?? ($r->queue?->patient?->name ?? 'Unknown Patient');
                    @endphp
                    <tr data-date="{{ $isToday ? 'today' : 'older' }}">
                        <td><span class="q-id">#{{ $r->id }}</span></td>
                        <td>
                            <button class="patient-name-btn" onclick="openRecord({{ $r->id }})">
                                {{ $display_name }}
                            </button>
                            <div style="font-size:.72rem; color:var(--text-muted);">
                                {{ $r->queue?->patient?->gender ?? '' }}{{ ($r->queue?->patient?->age ?? null) ? ' · ' . $r->queue?->patient?->age . ' yrs' : '' }}
                            </div>
                        </td>
                        <td><span class="diag-chip">{{ $r->diagnosis ?? 'No diagnosis' }}</span></td>
                        <td>
                            <div style="font-size:.845rem;">{{ date('M d, Y', strtotime($r->consultation_date)) }}</div>
                            <div style="font-size:.72rem; color:var(--text-muted);">
                                {{ $r->consultation_time ? date('g:i A', strtotime($r->consultation_time)) : '—' }}
                            </div>
                        </td>
                        <td style="text-align:right;">
                            <button class="act-btn" title="View Record" onclick="openRecord({{ $r->id }})">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="act-btn" title="Print Prescription" onclick="printRecord('{{ route('doctor.medical-records.print', $r) }}')">
                                <i class="bi bi-printer"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-x" style="font-size:2rem; display:block; margin-bottom:8px; opacity:.2;"></i>
                            No medical records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>

    <footer class="dash-footer">
        <span>© {{ date('Y') }} CuraSure · Doctor Portal</span>
        <div class="footer-links">
            <a href="#">Privacy Protocol</a>
            <a href="{{ route('support') }}">Support</a>
        </div>
    </footer>
</div>

{{-- View Modal --}}
<div class="modal fade" id="recordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <div class="d-flex align-items-center gap-3">
                    <div class="patient-avatar-lg" id="viewAvatar">—</div>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="modal-title" id="mName">—</span>
                            <span class="view-only-chip">Completed</span>
                        </div>
                        <div style="font-size:.73rem; color:var(--text-muted);">
                            Record <span id="mRecordId"></span> &nbsp;·&nbsp; <span id="mDate"></span>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-tabs">
                <button class="modal-tab-btn active" id="tab-info" onclick="switchTab('info')">
                    <i class="bi bi-person-vcard"></i> Patient Info
                </button>
                <button class="modal-tab-btn" id="tab-medical" onclick="switchTab('medical')">
                    <i class="bi bi-heart-pulse"></i> Medical History
                </button>
                <button class="modal-tab-btn" id="tab-consult" onclick="switchTab('consult')">
                    <i class="bi bi-clipboard2-pulse"></i> Consultation
                </button>
            </div>

            <div class="modal-body">
                <div id="panel-info">
                    <div class="modal-section-title">Personal Details</div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <div class="info-label">Age</div>
                            <div class="info-value" id="mAge">—</div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Gender</div>
                            <div class="info-value" id="mGender">—</div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-label">Civil Status</div>
                            <div class="info-value" id="mCivil">—</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Contact Number</div>
                            <div class="info-value" id="mContact">—</div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-label">Address</div>
                            <div class="info-value" id="mAddress">—</div>
                        </div>
                    </div>
                    </div>

                <div id="panel-medical" style="display:none;">
                    <div class="modal-section-title">Medical Background</div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="info-label">Known Allergies</div>
                            <div class="info-value" id="mAllergies" style="white-space:pre-wrap;">—</div>
                        </div>
                        <div class="col-md-12">
                            <div class="info-label">Existing Conditions</div>
                            <div class="info-value" id="mConditions" style="white-space:pre-wrap;">—</div>
                        </div>
                    </div>
                </div>

                <div id="panel-consult" style="display:none;">
                    <div class="modal-section-title">Clinical Notes</div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="info-label">Primary Symptoms</div>
                            <div class="info-value" id="mSymptoms" style="white-space:pre-wrap;">—</div>
                        </div>
                        <div class="col-md-12">
                            <div class="info-label">Final Diagnosis</div>
                            <div class="info-value" id="mDiagnosis" style="font-weight:700; color:var(--primary);">—</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-ghost" id="modalPrintBtn" onclick="printCurrentRecord()">
                    <i class="bi bi-printer"></i> Print
                </button>
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // FIX: Map records in JS to use the new patient_name column
    const allRecords = @json($records->values()->map(function($r) {
        return array_merge($r->toArray(), [
            'display_name' => $r->patient_name ?? ($r->queue?->patient?->name ?? 'Unknown Patient')
        ]);
    })); 
    
    let activeRecordPrintUrl = null;

    function openRecord(id) {
        const r = allRecords.find(rec => rec.id == id);
        if (!r) return;

        // FIX: Use display_name instead of path through relationships
        document.getElementById('viewAvatar').textContent  = r.display_name ? r.display_name.charAt(0).toUpperCase() : '?';
        document.getElementById('mName').textContent       = r.display_name || '—';
        document.getElementById('mRecordId').textContent   = '#' + r.id;
        document.getElementById('mDate').textContent       = r.consultation_date || '—';
        document.getElementById('mAge').textContent        = r.queue?.patient?.age ? r.queue.patient.age + ' yrs' : '—';
        document.getElementById('mGender').textContent     = r.queue?.patient?.gender || '—';
        document.getElementById('mAllergies').textContent  = r.queue?.patient?.known_allergies || 'None';
        document.getElementById('mDiagnosis').textContent  = r.diagnosis || 'No diagnosis recorded';
        
        activeRecordPrintUrl = "{{ route('doctor.medical-records.print', ':id') }}".replace(':id', r.id);

        switchTab('info');
        new bootstrap.Modal(document.getElementById('recordModal')).show();
    }

    function printRecord(url) {
        if (!url) return;
        window.open(url, '_blank');
    }

    function printCurrentRecord() {
        printRecord(activeRecordPrintUrl);
    }

    function switchTab(tab) {
        ['info', 'medical', 'consult'].forEach(t => {
            const panel = document.getElementById('panel-' + t);
            const btn = document.getElementById('tab-' + t);
            if(panel) panel.style.display = (t === tab) ? '' : 'none';
            if(btn) btn.classList.toggle('active', t === tab);
        });
    }

    function filterTable() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('#medicalRecordBody tr').forEach(row => {
            const name = row.querySelector('.patient-name-btn')?.textContent.toLowerCase() || '';
            row.style.display = name.includes(q) ? '' : 'none';
        });
    }

    function setFilter(filter, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('#medicalRecordBody tr').forEach(row => {
            if (filter === 'all') {
                row.style.display = '';
            } else {
                row.style.display = row.dataset.date === filter ? '' : 'none';
            }
        });
    }
</script>
</body>
</html>