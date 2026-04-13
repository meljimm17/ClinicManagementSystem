<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>CuraSure – Doctor Dashboard</title>
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

.btn-view-queue {
    background-color: var(--sidebar-bg);
    color: #ffffff;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 0.75rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.2s ease;
}
.btn-view-queue:hover {
    background-color: var(--accent);
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.btn-view-queue:active { transform: translateY(0); }

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
.topbar-actions { display: flex; align-items: center; gap: 12px; }
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
    position: relative;
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
    transition: transform 0.2s;
}
.avatar:hover { transform: scale(1.05); }

/* ── Bell notification ── */
.bell-wrapper { position: relative; }
.bell-badge {
    position: absolute;
    top: -4px; right: -4px;
    width: 10px; height: 10px;
    background: #e53935;
    border-radius: 50%;
    border: 2px solid #fff;
    display: none;
    animation: bellPulse 1.5s infinite;
}
.bell-badge.show { display: block; }
@keyframes bellPulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: .7; }
}

/* Notification dropdown */
.notif-dropdown {
    display: none;
    position: absolute;
    top: 44px; right: 0;
    width: 280px;
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,.1);
    z-index: 200;
    overflow: hidden;
}
.notif-dropdown.open { display: block; }
.notif-header {
    padding: 12px 16px;
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--text-muted);
    border-bottom: 1px solid var(--border);
}
.notif-item {
    padding: 12px 16px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: .8rem;
}
.notif-item:last-child { border-bottom: none; }
.notif-dot { width: 8px; height: 8px; border-radius: 50%; background: #f0a500; flex-shrink: 0; }
.notif-dot.diagnosing { background: var(--primary); }
.notif-empty { padding: 20px 16px; text-align: center; color: var(--text-muted); font-size: .78rem; }

/* Modal Design Elements */
.profile-modal .modal-content { border-radius: 24px; border: none; overflow: hidden; }
.profile-header { padding: 30px 24px; display: flex; align-items: center; gap: 18px; background: #fff; }
.profile-icon-container {
    width: 75px; height: 75px; border-radius: 18px; background: #f0f4f2;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.2rem; font-family: 'DM Serif Display'; color: var(--sidebar-bg);
}
.profile-tabs { padding: 0 24px; display: flex; gap: 25px; border-bottom: 1px solid var(--border); }
.tab-link {
    padding: 12px 0; font-size: 0.85rem; font-weight: 600; color: var(--text-muted);
    cursor: pointer; border-bottom: 2px solid transparent;
}
.tab-link.active { color: var(--primary); border-bottom: 2px solid var(--primary); }
.info-item { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 20px; }
.info-item-icon {
    width: 36px; height: 36px; border-radius: 10px; background: var(--accent-soft);
    color: var(--primary); display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

/* Content & Panels */
.content { padding: 28px 32px 40px; flex: 1; }
.stat-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
.stat-label { font-size: .72rem; font-weight: 600; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px; }
.stat-value { font-size: 2.1rem; font-weight: 700; color: var(--text-primary); }
.stat-value.green { color: var(--primary); }
.card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; height: 100%; }
.panel-title { font-size: .9rem; font-weight: 700; }

/* Footer */
.dash-footer { text-align: center; font-size: .7rem; color: var(--text-muted); border-top: 1px solid var(--border); padding: 14px 32px; display: flex; justify-content: space-between; }
.footer-links a { color: var(--text-muted); text-decoration: none; margin-left: 18px; }

/* Activity Log */
.activity-item { display: flex; align-items: flex-start; margin-bottom: 16px; gap: 12px; }
.activity-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; flex-shrink: 0; }
.activity-info .title { font-size: 0.8rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1px; }
.activity-info .subtitle { font-size: 0.7rem; color: var(--text-muted); }
.activity-info .time { font-size: 0.65rem; color: var(--text-muted); }

/* Status badges */
.badge-waiting    { background: #fff4e5; color: #b07000; padding: 3px 10px; border-radius: 20px; font-size: .72rem; font-weight: 700; }
.badge-diagnosing { background: var(--accent-soft); color: var(--primary); padding: 3px 10px; border-radius: 20px; font-size: .72rem; font-weight: 700; }

/* Empty state */
.empty-queue { text-align: center; padding: 40px 20px; color: var(--text-muted); font-size: .8rem; }
.empty-queue i { font-size: 2rem; display:block; margin-bottom: 8px; opacity: .2; }
</style>
</head>
<body>

{{-- ── Compute stats ── --}}
@php
    $waitingCount   = $queue->where('status', 'waiting')->count();
    $remainingCount = $queue->whereIn('status', ['waiting', 'diagnosing'])->count();

    $doneTodayWithTimes = \App\Models\PatientQueue::whereDate('created_at', today())
        ->where('status', 'done')
        ->whereNotNull('called_at')
        ->whereNotNull('completed_at')
        ->get();

    $avgMinutes = null;
    if ($doneTodayWithTimes->count() > 0) {
        $totalMinutes = $doneTodayWithTimes->sum(function($q) {
            return \Carbon\Carbon::parse($q->called_at)->diffInMinutes(\Carbon\Carbon::parse($q->completed_at));
        });
        $avgMinutes = round($totalMinutes / $doneTodayWithTimes->count());
    }

    $recentActivity = \App\Models\PatientQueue::with('patient')
        ->whereDate('created_at', today())
        ->whereIn('status', ['done', 'diagnosing'])
        ->orderByDesc('updated_at')
        ->take(5)
        ->get();
@endphp

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo"><i class="bi bi-shield-plus"></i></div>
        <div class="brand-name">CuraSure</div>
    </div>
    <nav class="sidebar-nav">
        @if(Auth::user()->role === 'doctor')
            <a href="{{ route('doctor.dashboard') }}" class="sidebar-link {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('doctor.queue') }}" class="sidebar-link {{ request()->routeIs('doctor.queue') ? 'active' : '' }}">
                <i class="bi bi-people"></i> <span>Patient Queue</span>
            </a>
            <a href="{{ route('doctor.medical-records') }}" class="sidebar-link {{ request()->routeIs('doctor.medical-records') ? 'active' : '' }}">
                <i class="bi bi-journal-medical"></i> <span>Medical Records</span>
            </a>
        @else
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> <span>Admin Dashboard</span>
            </a>
            <a href="{{ route('admin.queue') }}" class="sidebar-link {{ request()->routeIs('admin.queue') ? 'active' : '' }}">
                <i class="bi bi-people"></i> <span>Patient Queue</span>
            </a>
            <a href="{{ route('admin.medical-records') }}" class="sidebar-link {{ request()->routeIs('admin.medical-records') ? 'active' : '' }}">
                <i class="bi bi-journal-medical"></i> <span>Medical Records</span>
            </a>
        @endif
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

<div class="main-wrap">
    <header class="topbar">
        <div class="topbar-left">
            <h3>Dashboard</h3>
            <p>Welcome back, Dr. {{ Auth::user()->name }}! &nbsp;·&nbsp; {{ now()->format('l, F j, Y') }}</p>
        </div>
        <div class="topbar-actions">

            {{-- Bell with red dot if waiting patients exist --}}
            <div class="topbar-icon bell-wrapper" id="bellBtn" onclick="toggleNotif()" style="cursor:pointer;">
                <i class="bi bi-bell"></i>
                <span class="bell-badge {{ $waitingCount > 0 ? 'show' : '' }}" id="bellBadge"></span>
            </div>

            {{-- Notification Dropdown --}}
            <div class="notif-dropdown" id="notifDropdown">
                <div class="notif-header">
                    <i class="bi bi-bell-fill me-1"></i> Waiting Patients ({{ $waitingCount }})
                </div>
                @forelse($queue->where('status', 'waiting') as $w)
                    <div class="notif-item">
                        <span class="notif-dot"></span>
                        <div style="flex:1;">
                            <div style="font-weight:700;">{{ $w->patient->name }}</div>
                            <div style="color:var(--text-muted); font-size:.72rem;">{{ $w->queue_number }} · {{ $w->created_at->format('g:i A') }}</div>
                        </div>
                        <a href="{{ route('doctor.queue') }}?call={{ $w->id }}"
                           style="font-size:.72rem; font-weight:700; color:var(--primary); text-decoration:none; white-space:nowrap;">
                           Call →
                        </a>
                    </div>
                @empty
                    <div class="notif-empty">No waiting patients</div>
                @endforelse
            </div>

            <div class="avatar" data-bs-toggle="modal" data-bs-target="#doctorProfileModal">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>
    </header>

    <main class="content">

        {{-- ── Stat Cards ── --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Patients Seen Today</div>
                    <div class="stat-value">{{ $patientsSeen }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Avg Consultation Time</div>
                    <div class="stat-value">
                        {{ $avgMinutes !== null ? $avgMinutes . 'm' : '—' }}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Remaining in Queue</div>
                    <div class="stat-value green">{{ $remainingCount }}</div>
                </div>
            </div>
        </div>

        <div class="row g-3">

            {{-- ── Active Queue Overview ── --}}
            <div class="col-md-8">
                <div class="card-panel">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <div class="panel-title">Active Queue Overview</div>
                            <p class="text-muted small">Live patient queue status</p>
                        </div>
                        <a href="{{ route('doctor.queue') }}" class="btn-view-queue">
                            View Full Queue
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th>Queue ID</th>
                                    <th>Patient Name</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($queue->whereIn('status', ['waiting', 'diagnosing']) as $entry)
                                <tr>
                                    <td><strong>{{ $entry->queue_number }}</strong></td>
                                    <td>{{ $entry->patient->name }}</td>
                                    <td>
                                        @if($entry->status === 'diagnosing')
                                            <span class="badge-diagnosing">Diagnosing</span>
                                        @else
                                            <span class="badge-waiting">Waiting</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($entry->status === 'diagnosing')
                                            <form method="POST" action="{{ route('doctor.queue.complete', $entry->id) }}" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-success">Complete</button>
                                            </form>
                                        @else
                                            {{-- Call redirects to queue page and auto-loads patient --}}
                                            <a href="{{ route('doctor.queue') }}?call={{ $entry->id }}"
                                               class="btn btn-sm btn-outline-secondary">
                                               <i class="bi bi-telephone-fill me-1"></i>Call
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-queue">
                                            <i class="bi bi-people"></i>
                                            No patients in queue today.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ── Activity Log ── --}}
            <div class="col-md-4">
                <div class="card-panel">
                    <div class="panel-title">Activity Log</div>
                    <p class="text-muted small mb-3">Recent actions today</p>
                    <div class="activity-list">
                        @forelse($recentActivity as $activity)
                            <div class="activity-item">
                                @if($activity->status === 'done')
                                    <div class="activity-icon text-success" style="background:#e8f5e9;">
                                        <i class="bi bi-check2-circle"></i>
                                    </div>
                                    <div class="activity-info">
                                        <div class="title">Session Completed</div>
                                        <div class="subtitle">{{ $activity->queue_number }} · {{ $activity->patient->name }}</div>
                                        <div class="time">{{ $activity->completed_at ? \Carbon\Carbon::parse($activity->completed_at)->format('g:i A') : '' }}</div>
                                    </div>
                                @else
                                    <div class="activity-icon text-primary" style="background:#e8f0fe;">
                                        <i class="bi bi-megaphone"></i>
                                    </div>
                                    <div class="activity-info">
                                        <div class="title">Patient Called</div>
                                        <div class="subtitle">{{ $activity->queue_number }} · {{ $activity->patient->name }}</div>
                                        <div class="time">{{ $activity->called_at ? \Carbon\Carbon::parse($activity->called_at)->format('g:i A') : $activity->created_at->format('g:i A') }}</div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div style="text-align:center; color:var(--text-muted); font-size:.78rem; padding: 30px 0;">
                                <i class="bi bi-clock-history" style="font-size:1.5rem; display:block; margin-bottom:6px; opacity:.2;"></i>
                                No activity yet today.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="dash-footer">
        <span>© {{ date('Y') }} CuraSure · Doctor Portal</span>
        <div class="footer-links">
            <a href="#">Privacy Protocol</a>
            <a href="#">Support</a>
        </div>
    </footer>
</div>

{{-- ── Doctor Profile Modal ── --}}
<div class="modal fade profile-modal" id="doctorProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="profile-header">
                <div class="profile-icon-container">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                <div>
                    <h4 class="mb-0" style="font-family: 'DM Serif Display';">Dr. {{ Auth::user()->name }}</h4>
                    <p class="text-muted small mb-0">{{ $doctor->specialization ?? 'Medical Officer' }}</p>
                </div>
            </div>
            <div class="profile-tabs">
                <div class="tab-link active">Information</div>
                <div class="tab-link">Account</div>
            </div>
            <div class="p-4">
                <div class="info-item">
                    <div class="info-item-icon"><i class="bi bi-person-badge"></i></div>
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Full Name</div>
                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon"><i class="bi bi-envelope"></i></div>
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Email</div>
                        <div class="fw-bold">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="info-item">
                            <div class="info-item-icon"><i class="bi bi-card-checklist"></i></div>
                            <div>
                                <div class="text-muted small fw-bold text-uppercase">License No.</div>
                                <div class="fw-bold">{{ $doctor->license_number ?? '—' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-item">
                            <div class="info-item-icon"><i class="bi bi-hospital"></i></div>
                            <div>
                                <div class="text-muted small fw-bold text-uppercase">Room</div>
                                <div class="fw-bold">{{ $doctor?->assigned_room ? 'Room ' . $doctor->assigned_room : '—' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon"><i class="bi bi-activity"></i></div>
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Patients Seen Today</div>
                        <div class="fw-bold">{{ $patientsSeen }}</div>
                    </div>
                </div>
                <button type="button" class="btn w-100 rounded-pill border text-muted fw-bold mt-2" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle notification dropdown
    function toggleNotif() {
        document.getElementById('notifDropdown').classList.toggle('open');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const bell = document.getElementById('bellBtn');
        const dropdown = document.getElementById('notifDropdown');
        if (!bell.contains(e.target)) {
            dropdown.classList.remove('open');
        }
    });

    // Poll every 10 seconds to check for new waiting patients and update bell
    function checkWaitingPatients() {
        fetch('/api/queue-status', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('bellBadge');
            if (data.waiting > 0) {
                badge.classList.add('show');
            } else {
                badge.classList.remove('show');
            }
        })
        .catch(() => {}); // silent fail
    }

    setInterval(checkWaitingPatients, 10000);
</script>
</body>
</html>