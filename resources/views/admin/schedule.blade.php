<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure – Staff Roster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* MATCHED YOUR EXACT ROOT VARIABLES FROM DASHBOARD.BLADE.PHP */
        :root {
            --sidebar-bg: #1b3d2f; --sidebar-hover: #254d3c; --sidebar-active: #2e6048;
            --accent: #3d8b6e; --accent-light: #4fa882; --accent-soft: #e8f5f0;
            --text-primary: #1a2e25; --text-muted: #6b7f77; --border: #e4ece8;
            --card-bg: #ffffff; --page-bg: #f4f7f5; --success: #2e8b5e; --danger: #c0392b;
            --badge-live: #1b3d2f;
        }
        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--page-bg); color: var(--text-primary); margin: 0; min-height: 100vh; }

        /* MATCHED YOUR EXACT SIDEBAR STYLING */
        .sidebar { width: 220px; min-height: 100vh; background: var(--sidebar-bg); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 28px 22px 20px; border-bottom: 1px solid rgba(255,255,255,.08); }
        .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.15rem; color: #fff; }
        .sidebar-nav { flex: 1; padding: 14px 0; }
        .sidebar-link { display: flex; align-items: center; gap: 11px; padding: 10px 22px; color: rgba(255,255,255,.65); text-decoration: none; font-size: .875rem; font-weight: 400; border-left: 3px solid transparent; transition: all .18s; }
        .sidebar-link:hover { background: var(--sidebar-hover); color: #fff; }
        .sidebar-link.active { background: var(--sidebar-active); color: #fff; border-left-color: var(--accent-light); font-weight: 500; }
        .sidebar-link i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-bottom { padding: 16px 16px 24px; border-top: 1px solid rgba(255,255,255,.08); }
        .btn-new-appt { width: 100%; background: var(--accent-light); color: #fff; border: none; border-radius: 8px; padding: 10px 0; font-size: .82rem; font-weight: 600; cursor: pointer; transition: background .18s; }
        .btn-new-appt:hover { background: var(--accent); }
        
        /* MATCHED YOUR EXACT TOPBAR STYLING */
        .main-wrap { margin-left: 220px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: rgba(255,255,255,.85); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); padding: 0 32px; height: 58px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-left h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; }
        .topbar-left p { font-size: .75rem; color: var(--text-muted); margin: 2px 0 0; }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .topbar-icon { width: 36px; height: 36px; border-radius: 8px; background: var(--page-bg); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: .95rem; cursor: pointer; }
        .avatar { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light)); color: #fff; font-size: .8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; }

        /* CONTENT COMPONENTS */
        .content { padding: 28px 32px 40px; flex: 1; }
        .section-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 22px; }
        .section-title { font-size: 1.35rem; font-weight: 700; }
        .section-sub { font-size: .8rem; color: var(--text-muted); margin-top: 3px; }
        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        
        /* CALENDAR SPECIFIC */
        .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .cal-cell { min-height: 100px; background: var(--card-bg); border: 1px solid var(--border); border-radius: 8px; padding: 8px; }
        .cal-date { font-size: .78rem; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; }
        .cal-event { color: #fff; font-size: .6rem; font-weight: 600; border-radius: 4px; padding: 2px 5px; margin-bottom: 3px; background: var(--sidebar-bg); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        
        /* ROSTER LIST */
        .sched-item { display: flex; align-items: center; gap: 16px; padding: 14px 0; border-bottom: 1px solid var(--border); }
        .sched-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--accent); }
        .sched-time { font-size: .75rem; font-weight: 600; color: var(--text-muted); min-width: 110px; }
        .sched-badge { margin-left: auto; font-size: .65rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; background: #e5f7ef; color: #1e7a4c; }

        .btn-assign { background: var(--sidebar-bg); color: #fff; border: none; border-radius: 8px; padding: 8px 18px; font-size: .8rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: background .18s; }
        .btn-assign:hover { background: var(--accent); }
        .form-ctrl { border: 1px solid var(--border); border-radius: 8px; padding: 9px; font-size: .85rem; background: var(--page-bg); width: 100%; margin-bottom: 12px; outline: none; }
        .form-label-sm { font-size: .65rem; font-weight: 600; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 4px; }
        @media (prefers-reduced-motion: no-preference) {
            @keyframes pageFadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes softRise { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
            body { animation: pageFadeIn .35s ease-out; }
            .stat-chip, .card-panel, .calendar-wrap, .modal-content { animation: softRise .35s ease-out both; }
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

<aside class="sidebar">
    <div class="sidebar-brand"><div class="brand-name">CuraSure</div></div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i><span>Admin Dashboard</span>
        </a>
        <a href="{{ route('admin.queue') }}" class="sidebar-link {{ request()->routeIs('admin.queue') ? 'active' : '' }}">
            <i class="bi bi-people"></i><span>Patient Queue</span>
        </a>
        <a href="{{ route('admin.schedule') }}" class="sidebar-link active">
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
        <button class="btn-new-appt" data-bs-toggle="modal" data-bs-target="#addPatientModal"><i class="bi bi-plus-lg me-1"></i> Add Patient</button>
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

<div class="main-wrap">
    <header class="topbar">
        <div class="topbar-left">
            <h3>Staff Scheduling</h3>
            <p>Manage clinic floor coverage and room assignments</p>
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
                <div class="section-title">Staff Duty Roster</div>
                <div class="section-sub">Daily room assignments for medical personnel.</div>
            </div>
            <button class="btn-assign" data-bs-toggle="modal" data-bs-target="#assignRoomModal">
                <i class="bi bi-door-open"></i> Assign Room
            </button>
        </div>

        <div class="card-panel mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 id="calMonthLabel" style="font-size: .9rem; font-weight: 700; color: var(--text-primary); margin:0;"></h4>
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-secondary" onclick="changeMonth(-1)"><i class="bi bi-chevron-left"></i></button>
                    <button class="btn btn-sm btn-outline-secondary" onclick="changeMonth(1)"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>
            <div class="cal-grid">
                <div class="text-center fw-bold small text-muted">SUN</div>
                <div class="text-center fw-bold small text-muted">MON</div>
                <div class="text-center fw-bold small text-muted">TUE</div>
                <div class="text-center fw-bold small text-muted">WED</div>
                <div class="text-center fw-bold small text-muted">THU</div>
                <div class="text-center fw-bold small text-muted">FRI</div>
                <div class="text-center fw-bold small text-muted">SAT</div>
            </div>
            <div class="cal-grid mt-2" id="calBody"></div>
        </div>

        <div class="card-panel">
            <div class="panel-title">Today's Active Staff</div>
            <div class="panel-sub mb-3">Currently assigned personnel and locations</div>

            @forelse($todayAssignments as $assignment)
                <div class="sched-item">
                    <div class="sched-dot"></div>
                    <div class="sched-time">{{ $assignment['shift'] }}</div>
                    <div>
                        <div class="fw-bold">{{ $assignment['name'] }}</div>
                        <div class="small text-muted">Room Number: {{ $assignment['room'] }}</div>
                    </div>
                    <span class="sched-badge">ON DUTY</span>
                </div>
            @empty
                <div class="small text-muted">No active staff assignments found for today.</div>
            @endforelse
        </div>
    </main>

    <footer class="dash-footer" style="font-size: .7rem; color: var(--text-muted); border-top: 1px solid var(--border); padding: 14px 32px; display: flex; justify-content: space-between;">
        <span>© 2024 CuraSure · Central Management</span>
        <div class="footer-links"><a href="#" style="color: var(--text-muted); text-decoration: none; margin-left: 18px;">Privacy Protocol</a></div>
    </footer>
</div>

<div class="modal fade" id="assignRoomModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px; border:none;">
            <div class="modal-header border-bottom px-4">
                <h5 class="modal-title fw-bold" style="font-size: 1rem;">Room Assignment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.schedule.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-3">
                    <label class="form-label-sm">Doctor / Staff Name</label>
                    <select name="staff_id" class="form-ctrl" required>
                        <option value="">— Select Personnel —</option>
                        @foreach($staffList as $staff)
                            <option value="{{ $staff->id }}">
                                {{ $staff->name ?: ($staff->user->name ?? 'Unknown Staff') }}
                            </option>
                        @endforeach
                    </select>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label-sm">Room Number</label>
                            <input type="text" name="room_number" class="form-ctrl" placeholder="e.g. 101" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Shift Type</label>
                            <select name="shift_type" class="form-ctrl">
                                <option value="regular">Regular Clinic</option>
                                <option value="on-call">On-Call</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label-sm">Start Time</label>
                            <input type="datetime-local" name="start_at" class="form-ctrl" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">End Time</label>
                            <input type="datetime-local" name="end_at" class="form-ctrl" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="submit" class="btn btn-success w-100" style="border-radius:8px; font-weight:600; background: var(--sidebar-bg); border:none; padding:10px;">Confirm Assignment</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.partials.add-patient-modal')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const eventCounts = @json($calendarEvents ?? []);
    let current = new Date();
    function changeMonth(dir) {
        current.setMonth(current.getMonth() + dir);
        renderCalendar();
    }
    function renderCalendar() {
        const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        document.getElementById('calMonthLabel').textContent = months[current.getMonth()] + ' ' + current.getFullYear();
        const body = document.getElementById('calBody');
        body.innerHTML = '';
        const year = current.getFullYear(), month = current.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        for (let i = 0; i < firstDay; i++) {
            body.appendChild(Object.assign(document.createElement('div'), {className: 'cal-cell bg-light opacity-50'}));
        }
        for (let d = 1; d <= daysInMonth; d++) {
            const cell = document.createElement('div');
            cell.className = 'cal-cell';
            const dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            const count = eventCounts[dateKey] ?? 0;
            const badge = count > 0 ? `<div class="cal-event">${count} consult${count > 1 ? 's' : ''}</div>` : '';
            cell.innerHTML = `<div class="cal-date">${d}</div>${badge}`;
            body.appendChild(cell);
        }
    }
    renderCalendar();
</script>
</body>
</html>