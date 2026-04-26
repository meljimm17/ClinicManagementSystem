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
        .stat-chip-icon.amber { background: #fff4e5; color: #b07000; }
        .stat-chip-icon.dark  { background: var(--sidebar-bg); color: #4fce9e; }
        .stat-chip-label { font-size: .65rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); }
        .stat-chip-value { font-size: 1.4rem; font-weight: 700; color: var(--text-primary); line-height: 1.1; }
        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); }
        .search-input { border: 1px solid var(--border); border-radius: 8px; padding: 8px 14px 8px 36px; font-size: .845rem; font-family: 'DM Sans', sans-serif; background: var(--page-bg); color: var(--text-primary); outline: none; width: 220px; transition: border-color .15s, width .2s; }
        .search-input:focus { border-color: var(--accent); width: 260px; background: #fff; }
        .filter-btn { border: 1px solid var(--border); border-radius: 8px; padding: 8px 14px; font-size: .8rem; font-family: 'DM Sans', sans-serif; background: var(--page-bg); color: var(--text-muted); cursor: pointer; transition: all .15s; }
        .filter-btn.active, .filter-btn:hover { background: var(--accent-soft); border-color: #c0dfd0; color: var(--primary); }
        .queue-table-wrap {
            max-height: 560px;
            overflow-y: auto;
            overflow-x: auto;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
        }
        .queue-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .queue-table thead th { font-size: .65rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); padding: 10px 14px; border-bottom: 1px solid var(--border); position: sticky; top: 0; background: #fff; z-index: 2; }
        .queue-table tbody tr { transition: background .12s; }
        .queue-table tbody tr:hover { background: #fafcfb; }
        .queue-table tbody td { padding: 14px 14px; border-bottom: 1px solid var(--border); font-size: .845rem; vertical-align: middle; }
        .queue-table tbody tr:last-child td { border-bottom: none; }
        .day-separator-row:hover { background: transparent !important; }
        .day-separator-cell {
            padding: 0 !important;
            background: #fbfcfb;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 40px;
            z-index: 1;
        }
        .day-separator-label {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: var(--text-muted);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        .day-separator-label::before,
        .day-separator-label::after {
            content: '';
            height: 1px;
            background: var(--border);
            flex: 1;
        }
        .q-id { font-family: 'DM Serif Display', serif; font-size: 1.05rem; color: var(--sidebar-bg); }
        .patient-name-btn { background: none; border: none; padding: 0; font-family: 'DM Sans', sans-serif; font-size: .875rem; font-weight: 600; color: var(--text-primary); cursor: pointer; text-align: left; text-decoration: underline; text-decoration-color: transparent; text-underline-offset: 3px; transition: color .15s, text-decoration-color .15s; }
        .patient-name-btn:hover { color: var(--primary); text-decoration-color: var(--primary); }
        .badge-status { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: .68rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; }
        .badge-status::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .badge-diagnosing { background: var(--accent-soft); color: var(--primary); border: 1px solid #c0dfd0; }
        .badge-diagnosing::before { background: var(--primary); animation: pulse 1.6s ease infinite; }
        .badge-waiting { background: #fff4e5; color: #b07000; border: 1px solid #f0d9a0; }
        .badge-waiting::before { background: #b07000; }
        .badge-done { background: #f0f4f8; color: #5a6a7a; border: 1px solid #d8e2ec; }
        .badge-done::before { background: #5a6a7a; }
        @keyframes pulse { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:.4; transform:scale(1.4); } }
        .room-active { font-weight: 700; color: var(--primary); }
        .room-waiting { color: var(--text-muted); font-style: italic; }
        .act-btn { display: inline-flex; align-items: center; justify-content: center; height: 30px; padding: 0 14px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.03em; text-transform: uppercase; cursor: pointer; transition: all 0.2s; border: 1px solid transparent; }
        .act-btn.edit { background-color: var(--primary); color: #fff; }
        .act-btn.edit:hover { background-color: var(--accent); }
        .act-btn.remove { background: #fff0f0; border: 1px solid #f5b8b8; color: #c0392b; }
        .act-btn.remove:hover { background: #f8d7da; }
        .dash-footer { font-size: .7rem; color: var(--text-muted); border-top: 1px solid var(--border); padding: 14px 32px; display: flex; justify-content: space-between; }
        .footer-links a { color: var(--text-muted); text-decoration: none; margin-left: 18px; font-size: .7rem; }
        .footer-links a:hover { color: var(--accent); }
        /* Modal styles */
        .modal-content { border: 1px solid var(--border); border-radius: 14px; font-family: 'DM Sans', sans-serif; }
        .modal-header { padding: 20px 24px 16px; border-bottom: 1px solid var(--border); }
        .modal-title { font-weight: 700; font-size: .95rem; }
        .modal-body { padding: 22px 24px; }
        .modal-footer { padding: 14px 24px; border-top: 1px solid var(--border); }
        .info-label { font-size: .65rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 3px; }
        .info-value { font-size: .875rem; font-weight: 500; color: var(--text-primary); padding: 9px 14px; background: var(--page-bg); border: 1px solid var(--border); border-radius: 8px; }
        .patient-avatar-lg { width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light)); color: #fff; font-size: 1.4rem; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .view-only-chip { background: #fff4e5; color: #b07000; border: 1px solid #f0d9a0; border-radius: 20px; font-size: .65rem; font-weight: 700; letter-spacing: .06em; padding: 3px 10px; text-transform: uppercase; }
        .btn-ghost { background: none; border: 1px solid var(--border); border-radius: 8px; padding: 9px 18px; font-size: .845rem; font-family: 'DM Sans', sans-serif; color: var(--text-muted); cursor: pointer; transition: all .15s; }
        .btn-ghost:hover { background: var(--page-bg); color: var(--text-primary); }
        @media (prefers-reduced-motion: no-preference) {
            @keyframes pageFadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes softRise { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
            body { animation: pageFadeIn .35s ease-out; }
            .stat-chip, .card-panel, .queue-table-wrap, .modal-content { animation: softRise .35s ease-out both; }
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
            <h3>Patient Queue</h3>
            <p>Monitoring live diagnostic flow — {{ now()->format('F d, Y') }}</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-icon"><i class="bi bi-bell"></i></div>
            <div class="topbar-icon"><i class="bi bi-gear"></i></div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <main class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius:10px;font-size:.845rem;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="border-radius:10px;font-size:.845rem;">
                <strong>Unable to save changes:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stat Chips — computed from $queueEntries -->
        @php
            $totalInQueue    = $queueEntries->count();
            $diagnosingCount = $queueEntries->where('status', 'diagnosing')->count();
            $waitingCount    = $queueEntries->where('status', 'waiting')->count();
        @endphp
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon dark"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="stat-chip-label">Total in Queue</div>
                        <div class="stat-chip-value">{{ $totalInQueue }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon green"><i class="bi bi-activity"></i></div>
                    <div>
                        <div class="stat-chip-label">Being Diagnosed</div>
                        <div class="stat-chip-value">{{ $diagnosingCount }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-chip">
                    <div class="stat-chip-icon amber"><i class="bi bi-hourglass-split"></i></div>
                    <div>
                        <div class="stat-chip-label">Waiting</div>
                        <div class="stat-chip-value">{{ $waitingCount }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Queue Table -->
        <div class="card-panel">
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <div class="panel-title mb-0">Active Queue</div>
                    <p class="mb-0" style="font-size:.75rem; color:var(--text-muted);">Click a patient's name to view their info</p>
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

            <div class="queue-table-wrap">
            <table class="queue-table">
                <thead>
                    <tr>
                        <th>Queue ID</th>
                        <th>Patient</th>
                        <th>Symptoms</th>
                        <th>Status</th>
                        <th>Room</th>
                        <th>Queued At</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody id="queueBody">
                    @forelse($queueEntries as $entry)
                    @php
                        $entryDate = $entry->queue_date
                            ? \Carbon\Carbon::parse($entry->queue_date)
                            : ($entry->queued_at ? \Carbon\Carbon::parse($entry->queued_at) : null);
                        $currentDateKey = $entryDate?->toDateString();
                        $previousDateKey = isset($previousDateKey) ? $previousDateKey : null;
                    @endphp
                    @if($currentDateKey !== $previousDateKey)
                    <tr class="day-separator-row" data-date-separator="{{ $currentDateKey }}">
                        <td colspan="7" class="day-separator-cell">
                            <div class="day-separator-label">
                                {{ $entryDate ? $entryDate->format('F d, Y') : 'No Date' }}
                            </div>
                        </td>
                    </tr>
                    @php $previousDateKey = $currentDateKey; @endphp
                    @endif
                    <tr data-status="{{ $entry->status }}" data-date-group="{{ $currentDateKey }}">
                        <td><span class="q-id">{{ $entry->display_queue_number }}</span></td>
                        <td>
                            <button class="patient-name-btn" onclick="openViewModal({
                                id: '{{ $entry->display_queue_number }}',
                                name: '{{ addslashes($entry->patient_name ?? $entry->patient?->name ?? 'Unknown Patient') }}',
                                time: '{{ $entry->queued_at ? \Carbon\Carbon::parse($entry->queued_at)->format('h:i A') : '—' }}',
                                age: '{{ $entry->patient->age ?? '—' }}',
                                gender: '{{ $entry->patient->gender ?? '—' }}',
                                contact: '{{ $entry->patient->contact_number ?? '—' }}',
                                address: '{{ addslashes($entry->patient->address ?? '—') }}',
                                blood: '{{ $entry->patient->blood_type ?? '—' }}',
                                height: '{{ $entry->patient->height ?? '—' }}',
                                weight: '{{ $entry->patient->weight ?? '—' }}',
                                symptoms: '{{ addslashes($entry->symptoms ?? '—') }}',
                                status: '{{ ucfirst($entry->status) }}',
                                room: '{{ $entry->assigned_room ?? 'Waiting Area' }}'
                            })">{{ $entry->patient_name ?? $entry->patient?->name ?? 'Unknown Patient' }}</button>
                            @if($entry->priority)
                                <div style="margin-top:4px;"><span class="btn-ghost" style="padding:4px 10px;font-size:.7rem;text-transform:uppercase;">{{ strtoupper($entry->priority->priority_type) }}</span></div>
                            @endif
                            <div style="font-size:.72rem; color:var(--text-muted);">
                                {{ $entry->patient->gender ?? '' }}{{ $entry->patient->age ? ' · '.$entry->patient->age.' yrs' : '' }}
                            </div>
                        </td>
                        <td style="max-width:180px; font-size:.78rem; color:var(--text-muted); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            {{ $entry->symptoms ?? '—' }}
                        </td>
                        <td>
                            <span class="badge-status badge-{{ $entry->status }}">
                                {{ $entry->status === 'diagnosing' ? 'Being Diagnosed' : ucfirst($entry->status) }}
                            </span>
                        </td>
                        <td>
                            @if($entry->assigned_room)
                                <span class="room-active">{{ $entry->assigned_room }}</span>
                            @else
                                <span class="room-waiting">Waiting Area</span>
                            @endif
                        </td>
                        <td style="font-size:.78rem; color:var(--text-muted);">
                            {{ $entry->queued_at ? \Carbon\Carbon::parse($entry->queued_at)->format('h:i A') : '—' }}
                        </td>
                        <td style="text-align:right;">
                            <button type="button"
                                    class="act-btn edit"
                                    onclick="openEditQueueModal({{ $entry->id }}, '{{ $entry->status }}', '{{ $entry->assigned_room ?? '' }}', '{{ addslashes($entry->symptoms ?? '') }}')">
                                Edit
                            </button>
                            <form action="{{ route('admin.queue.destroy', $entry->id) }}" method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirm('Remove {{ $entry->patient_name ?? $entry->patient?->name ?? 'this patient' }} from queue?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="act-btn remove ms-1">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:32px 0; color:var(--text-muted);">
                            <i class="bi bi-check2-all" style="font-size:1.5rem; display:block; margin-bottom:8px;"></i>
                            No active patients in queue today.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

    </main>

    <footer class="dash-footer">
        <span>© 2024 CuraSure · Staff Portal</span>
        <div class="footer-links"><a href="#">Privacy Protocol</a><a href="{{ route('support') }}">Support</a></div>
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
                    <div class="col-md-4"><div class="info-label">Age</div><div class="info-value" id="viewAge">—</div></div>
                    <div class="col-md-4"><div class="info-label">Gender</div><div class="info-value" id="viewGender">—</div></div>
                    <div class="col-md-4"><div class="info-label">Contact</div><div class="info-value" id="viewContact">—</div></div>
                    <div class="col-md-12"><div class="info-label">Address</div><div class="info-value" id="viewAddress">—</div></div>
                    <div class="col-md-4"><div class="info-label">Blood Type</div><div class="info-value" id="viewBlood">—</div></div>
                    <div class="col-md-4"><div class="info-label">Height</div><div class="info-value" id="viewHeight">—</div></div>
                    <div class="col-md-4"><div class="info-label">Weight</div><div class="info-value" id="viewWeight">—</div></div>
                    <div class="col-md-12"><div class="info-label">Symptoms</div><div class="info-value" id="viewSymptoms" style="white-space:pre-wrap;line-height:1.6;">—</div></div>
                    <div class="col-md-6"><div class="info-label">Status</div><div class="info-value" id="viewStatus">—</div></div>
                    <div class="col-md-6"><div class="info-label">Assigned Room</div><div class="info-value" id="viewRoom">—</div></div>
                    <div class="col-md-6"><div class="info-label">Priority</div><div class="info-value" id="viewPriority">—</div></div>
                    <div class="col-md-6"><div class="info-label">Priority Notes</div><div class="info-value" id="viewPriorityNotes">—</div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-ghost" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editQueueModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Edit Queue Entry</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editQueueForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="info-label">Status</label>
                        <select name="status" id="editQueueStatus" class="info-value" style="width:100%;">
                            <option value="waiting">Waiting</option>
                            <option value="diagnosing">Diagnosing</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="info-label">Assigned Room</label>
                        <input type="text" name="assigned_room" id="editQueueRoom" class="info-value" style="width:100%;" placeholder="e.g. Room 1">
                    </div>
                    <div>
                        <label class="info-label">Symptoms</label>
                        <textarea name="symptoms" id="editQueueSymptoms" class="info-value" style="width:100%; min-height:90px; white-space:pre-wrap;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-ghost" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="act-btn edit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.partials.add-patient-modal')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openEditQueueModal(id, status, room, symptoms) {
        document.getElementById('editQueueForm').action = '/admin/queue/' + id;
        document.getElementById('editQueueStatus').value = status;
        document.getElementById('editQueueRoom').value = room;
        document.getElementById('editQueueSymptoms').value = symptoms;
        new bootstrap.Modal(document.getElementById('editQueueModal')).show();
    }

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
        document.getElementById('viewPriority').textContent = p.priority;
        document.getElementById('viewPriorityNotes').textContent = p.priority_notes;
        new bootstrap.Modal(document.getElementById('viewModal')).show();
    }

    function filterTable() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('#queueBody tr[data-status]').forEach(row => {
            const name = row.querySelector('.patient-name-btn')?.textContent.toLowerCase() ?? '';
            row.style.display = name.includes(q) ? '' : 'none';
        });
        updateDateSeparators();
    }

    let activeFilter = 'all';
    function setFilter(filter, btn) {
        activeFilter = filter;
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('searchInput').value = '';
        document.querySelectorAll('#queueBody tr[data-status]').forEach(row => {
            row.style.display = (filter === 'all' || row.dataset.status === filter) ? '' : 'none';
        });
        updateDateSeparators();
    }

    function updateDateSeparators() {
        document.querySelectorAll('#queueBody tr[data-date-separator]').forEach(separator => {
            const dateKey = separator.dataset.dateSeparator;
            const hasVisibleRows = Array.from(document.querySelectorAll('#queueBody tr[data-date-group="' + dateKey + '"]'))
                .some(row => row.style.display !== 'none');

            separator.style.display = hasVisibleRows ? '' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', updateDateSeparators);
</script>
</body>
</html>