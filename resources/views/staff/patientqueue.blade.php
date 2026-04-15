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

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--page-bg);
    color: var(--text-primary);
    min-height: 100vh;
    display: flex;
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

.sidebar-footer { padding: 6px 0 0; }

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

/* ── Main content ── */
.main-wrap {
    margin-left: 220px;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.topbar {
    background: #fff;
    border-bottom: 1px solid var(--border);
    padding: 0 32px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky; top: 0; z-index: 50;
}

.topbar-left h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; }
.topbar-left p  { font-size: .72rem; color: var(--text-muted); margin: 0; }

.topbar-actions { display: flex; align-items: center; gap: 10px; }

.topbar-icon {
    width: 34px; height: 34px; border-radius: 8px;
    background: var(--page-bg); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--text-muted); font-size: .9rem; cursor: pointer;
}

.avatar {
    width: 34px; height: 34px; border-radius: 9px;
    background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light));
    color: #fff; font-size: .78rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
}

/* ── Page content ── */
.content { padding: 28px 32px; flex: 1; }

/* ── Stat cards ── */
.stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }

.stat-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 20px 22px;
    display: flex;
    align-items: center;
    gap: 16px;
}

.stat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; flex-shrink: 0;
}

.stat-icon.green  { background: var(--accent-soft); color: var(--primary); }
.stat-icon.blue   { background: #e8f0fe; color: #3367d6; }
.stat-icon.yellow { background: #fff8e1; color: #f09800; }

.stat-label { font-size: .68rem; font-weight: 700; text-transform: uppercase; letter-spacing: .07em; color: var(--text-muted); margin-bottom: 2px; }
.stat-value { font-size: 1.6rem; font-weight: 700; color: var(--text-primary); line-height: 1; }

/* ── Queue table panel ── */
.panel {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
}

.panel-header {
    padding: 18px 22px 14px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); }
.panel-sub   { font-size: .72rem; color: var(--text-muted); margin-top: 2px; }

.filter-group { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }

.search-box {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--page-bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 6px 12px;
    font-size: .8rem;
    color: var(--text-muted);
    min-width: 180px;
}

.search-box input {
    border: none; background: none; outline: none;
    font-size: .8rem; font-family: 'DM Sans', sans-serif;
    color: var(--text-primary); width: 100%;
}

.btn-filter {
    padding: 6px 14px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: var(--card-bg);
    font-size: .78rem;
    font-weight: 600;
    color: var(--text-muted);
    cursor: pointer;
    transition: all .15s;
    font-family: 'DM Sans', sans-serif;
}

.btn-filter:hover, .btn-filter.active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
}

/* ── Table ── */
.queue-table { width: 100%; border-collapse: collapse; }

.queue-table thead th {
    padding: 10px 22px;
    font-size: .65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
    background: var(--page-bg);
}

.queue-table tbody td {
    padding: 14px 22px;
    border-bottom: 1px solid var(--border);
    font-size: .82rem;
    vertical-align: middle;
}

.queue-table tbody tr:last-child td { border-bottom: none; }
.queue-table tbody tr:hover td { background: var(--page-bg); }

.queue-id { font-weight: 700; font-size: .9rem; color: var(--text-primary); }

.patient-name { font-weight: 600; color: var(--text-primary); }
.patient-time { font-size: .68rem; color: var(--text-muted); margin-top: 2px; }

/* Status badges */
.badge-waiting {
    display: inline-flex; align-items: center; gap: 5px;
    background: #fff8e1; color: #b07000;
    font-size: .7rem; font-weight: 700;
    padding: 4px 10px; border-radius: 20px;
    text-transform: uppercase;
}

.badge-diagnosing {
    display: inline-flex; align-items: center; gap: 5px;
    background: var(--accent-soft); color: var(--primary);
    font-size: .7rem; font-weight: 700;
    padding: 4px 10px; border-radius: 20px;
    text-transform: uppercase;
}

.badge-diagnosing::before, .badge-waiting::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}

.badge-diagnosing::before { background: var(--primary); animation: pulse 1.4s infinite; }
.badge-waiting::before    { background: #f0a500; }

@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }

.room-text { font-size: .8rem; color: var(--text-muted); font-style: italic; }

/* Action buttons */
.btn-edit {
    padding: 5px 14px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 7px;
    font-size: .75rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: background .15s;
    margin-right: 6px;
}
.btn-edit:hover { background: var(--accent); }

.btn-remove {
    padding: 5px 14px;
    background: #fff0f0;
    color: #c0392b;
    border: 1px solid #f5c6c6;
    border-radius: 7px;
    font-size: .75rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: all .15s;
}
.btn-remove:hover { background: #c0392b; color: #fff; border-color: #c0392b; }

/* Empty state */
.empty-row td {
    padding: 60px 22px !important;
    text-align: center;
    color: var(--text-muted);
}

/* Edit Modal */
.modal-content { border-radius: 18px; border: none; }
.modal-header { border-bottom: 1px solid var(--border); padding: 20px 24px; }
.modal-title { font-size: .95rem; font-weight: 700; }
.modal-body  { padding: 20px 24px; }
.modal-footer { border-top: 1px solid var(--border); padding: 16px 24px; }

.form-label-custom {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: var(--text-muted);
    margin-bottom: 6px;
    display: block;
}

.form-control-custom {
    width: 100%;
    border: 1px solid var(--border);
    border-radius: 9px;
    padding: 9px 14px;
    font-size: .84rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--text-primary);
    background: var(--card-bg);
    outline: none;
    transition: border-color .15s;
}
.form-control-custom:focus { border-color: var(--accent); }

.btn-save-modal {
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 9px;
    padding: 9px 22px;
    font-size: .82rem;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
}
.btn-save-modal:hover { background: var(--accent); }

.btn-cancel-modal {
    background: none;
    border: 1px solid var(--border);
    border-radius: 9px;
    padding: 9px 22px;
    font-size: .82rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    color: var(--text-muted);
    cursor: pointer;
}

/* Auto-refresh indicator */
.refresh-indicator {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .68rem;
    color: var(--text-muted);
}

.refresh-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--accent);
    animation: pulse 2s infinite;
}
@media (prefers-reduced-motion: no-preference) {
    @keyframes pageFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes softRise { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    body { animation: pageFadeIn .35s ease-out; }
    .stat-chip, .card-panel, .queue-table-wrap, .modal-content { animation: softRise .35s ease-out both; }
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

{{-- ── Sidebar ── --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo"><i class="bi bi-shield-plus"></i></div>
        <div class="brand-name">CuraSure</div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('staff.dashboard') }}" class="sidebar-link"><i class="bi bi-grid-1x2"></i> Staff Dashboard</a>
        <a href="{{ route('staff.queue') }}" class="sidebar-link active"><i class="bi bi-people"></i> Patient Queue</a>
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

{{-- ── Main ── --}}
<div class="main-wrap">
    <header class="topbar">
        <div class="topbar-left">
            <h3>Patient Queue</h3>
            <p>Monitoring live diagnostic flow</p>
        </div>
        <div class="topbar-actions">
            <div class="refresh-indicator">
                <div class="refresh-dot"></div>
                Live · refreshes every 5s
            </div>
            <div class="topbar-icon"><i class="bi bi-bell"></i></div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <div class="content">
        @if(session('success'))
            <div class="alert mb-3" style="background:#e8f5f0; border:1px solid #c0dfd0; color:#1b7a4e; border-radius:8px; padding:10px 14px; font-size:.82rem; font-weight:600;">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert mb-3" style="background:#fff5f5; border:1px solid #f1b0b7; color:#b02a37; border-radius:8px; padding:10px 14px; font-size:.8rem;">
                <strong>Unable to save changes:</strong>
                <ul style="margin:6px 0 0 16px; padding:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Stats --}}
        @php
            $totalToday     = $queue->count();
            $diagnosing     = $queue->where('status', 'diagnosing')->count();
            $waiting        = $queue->where('status', 'waiting')->count();
        @endphp

        <div class="stat-row">
            <div class="stat-card">
                <div class="stat-icon green"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="stat-label">Total in Queue</div>
                    <div class="stat-value">{{ $totalToday }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-activity"></i></div>
                <div>
                    <div class="stat-label">Being Diagnosed</div>
                    <div class="stat-value">{{ $diagnosing }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <div class="stat-label">Waiting</div>
                    <div class="stat-value">{{ $waiting }}</div>
                </div>
            </div>
        </div>

        {{-- Queue Table --}}
        <div class="panel">
            <div class="panel-header">
                <div>
                    <div class="panel-title">Active Queue</div>
                    <div class="panel-sub">Click a patient's name to view their full info</div>
                </div>
                <div class="filter-group">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchInput" placeholder="Search patient..." onkeyup="filterTable()">
                    </div>
                    <button class="btn-filter active" onclick="filterStatus('all', this)">All</button>
                    <button class="btn-filter" onclick="filterStatus('diagnosing', this)">Diagnosing</button>
                    <button class="btn-filter" onclick="filterStatus('waiting', this)">Waiting</button>
                </div>
            </div>

            <table class="queue-table" id="queueTable">
                <thead>
                    <tr>
                        <th>Queue ID</th>
                        <th>Patient</th>
                        <th>Status</th>
                        <th>Room</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($queue as $entry)
                    <tr data-status="{{ $entry->status }}">
                        <td><div class="queue-id">{{ $entry->display_queue_number }}</div></td>
                        <td>
                            <div class="patient-name">{{ $entry->patient->name }}</div>
                            <div class="patient-time">{{ $entry->created_at->format('g:i A') }}</div>
                        </td>
                        <td>
                            @if($entry->status === 'diagnosing')
                                <span class="badge-diagnosing">Diagnosing</span>
                            @else
                                <span class="badge-waiting">Waiting</span>
                            @endif
                        </td>
                        <td>
                            <span class="room-text">
                                {{ $entry->assigned_room ? 'Room ' . $entry->assigned_room : 'Waiting Area' }}
                            </span>
                        </td>
                        <td class="text-end">
                            {{-- Edit button --}}
                            <button class="btn-edit"
                                onclick="openEdit(
                                    {{ $entry->id }},
                                    '{{ $entry->status }}',
                                    '{{ $entry->assigned_room ?? '' }}',
                                    '{{ addslashes($entry->symptoms ?? '') }}'
                                )">
                                Edit
                            </button>

                            {{-- Remove button --}}
                            <form method="POST"
                                  action="{{ route('staff.queue.destroy', $entry->id) }}"
                                  style="display:inline;"
                                  onsubmit="return confirm('Remove {{ $entry->patient->name }} from queue?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="5">
                            <i class="bi bi-people" style="font-size:2rem; display:block; margin-bottom:8px; opacity:.2;"></i>
                            No patients in queue today.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- ── Edit Modal ── --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Queue Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label-custom">Status</label>
                        <select name="status" id="edit-status" class="form-control-custom">
                            <option value="waiting">Waiting</option>
                            <option value="diagnosing">Diagnosing</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Assigned Room</label>
                        <input type="text" name="assigned_room" id="edit-room" class="form-control-custom" placeholder="e.g. Room 1">
                    </div>
                    <div class="mb-1">
                        <label class="form-label-custom">Symptoms</label>
                        <textarea name="symptoms" id="edit-symptoms" class="form-control-custom" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel-modal" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-save-modal">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Open edit modal and populate fields
    function openEdit(id, status, room, symptoms) {
        document.getElementById('editForm').action = `/staff/patientqueue/${id}`;
        document.getElementById('edit-status').value   = status;
        document.getElementById('edit-room').value     = room;
        document.getElementById('edit-symptoms').value = symptoms;
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    // Filter by status buttons
    function filterStatus(status, btn) {
        document.querySelectorAll('.btn-filter').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        document.querySelectorAll('#queueTable tbody tr[data-status]').forEach(row => {
            if (status === 'all' || row.dataset.status === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Search filter
    function filterTable() {
        const val = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('#queueTable tbody tr[data-status]').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
        });
    }

    // Auto-refresh every 5 seconds to pick up status changes from doctor
    setTimeout(() => location.reload(), 5000);
</script>
</body>
</html>