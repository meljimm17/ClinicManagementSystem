<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure – Schedule</title>
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
        }
        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--page-bg); color: var(--text-primary); margin: 0; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 220px; min-height: 100vh; background: var(--sidebar-bg); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 28px 22px 20px; border-bottom: 1px solid rgba(255,255,255,.08); }
        .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.15rem; color: #fff; line-height: 1.2; }
        .sidebar-nav { flex: 1; padding: 14px 0; }
        .sidebar-link { display: flex; align-items: center; gap: 11px; padding: 10px 22px; color: rgba(255,255,255,.65); text-decoration: none; font-size: .875rem; font-weight: 400; border-left: 3px solid transparent; transition: all .18s ease; }
        .sidebar-link:hover { background: var(--sidebar-hover); color: #fff; }
        .sidebar-link.active { background: var(--sidebar-active); color: #fff; border-left-color: var(--accent-light); font-weight: 500; }
        .sidebar-link i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-bottom { padding: 16px 16px 24px; border-top: 1px solid rgba(255,255,255,.08); }
        .btn-new-appt { width: 100%; background: var(--accent-light); color: #fff; border: none; border-radius: 8px; padding: 10px 0; font-size: .82rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: background .18s; }
        .btn-new-appt:hover { background: var(--accent); }
        .btn-logout { display: flex; align-items: center; gap: 10px; width: 100%; background: none; border: none; padding: 8px 6px; color: rgba(255,255,255,.65); font-size: .82rem; font-family: 'DM Sans', sans-serif; cursor: pointer; border-left: 3px solid transparent; transition: all .18s; text-align: left; }
        .btn-logout:hover { background: var(--sidebar-hover); color: #fff; }
        .btn-logout i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-footer { padding: 10px 0 4px; }

        /* Main */
        .main-wrap { margin-left: 220px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: rgba(255,255,255,.85); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); padding: 0 32px; height: 58px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-left h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; }
        .topbar-left p { font-size: .75rem; color: var(--text-muted); margin: 2px 0 0; }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .topbar-icon { width: 36px; height: 36px; border-radius: 8px; background: var(--page-bg); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: .95rem; cursor: pointer; transition: background .15s; }
        .topbar-icon:hover { background: var(--accent-soft); color: var(--accent); }
        .avatar { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light)); color: #fff; font-size: .8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .content { padding: 28px 32px 40px; flex: 1; }

        /* Section */
        .section-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 22px; }
        .section-title { font-size: 1.35rem; font-weight: 700; color: var(--text-primary); line-height: 1.2; }
        .section-sub { font-size: .8rem; color: var(--text-muted); margin-top: 3px; }

        /* Calendar grid */
        .cal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
        .cal-month { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); }
        .cal-nav { display: flex; gap: 8px; }
        .cal-nav-btn { width: 32px; height: 32px; border: 1px solid var(--border); border-radius: 8px; background: var(--page-bg); color: var(--text-muted); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .15s; }
        .cal-nav-btn:hover { background: var(--accent-soft); color: var(--accent); border-color: #c0dfd0; }

        .cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .cal-day-label { text-align: center; font-size: .65rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); padding: 6px 0; }
        .cal-cell { min-height: 80px; background: var(--card-bg); border: 1px solid var(--border); border-radius: 8px; padding: 8px; position: relative; cursor: pointer; transition: border-color .15s; }
        .cal-cell:hover { border-color: var(--accent-light); background: var(--accent-soft); }
        .cal-cell.today { border-color: var(--accent); background: var(--accent-soft); }
        .cal-cell.other-month { background: #f9faf9; opacity: .5; cursor: default; }
        .cal-date { font-size: .78rem; font-weight: 600; color: var(--text-muted); margin-bottom: 4px; }
        .cal-cell.today .cal-date { color: var(--accent); }
        .cal-event { background: var(--sidebar-bg); color: #fff; font-size: .62rem; font-weight: 600; border-radius: 4px; padding: 2px 5px; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .cal-event.green { background: var(--accent); }
        .cal-event.light { background: var(--accent-light); }

        /* Upcoming list */
        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .panel-sub { font-size: .75rem; color: var(--text-muted); }

        .sched-item { display: flex; align-items: center; gap: 16px; padding: 14px 0; border-bottom: 1px solid var(--border); }
        .sched-item:last-child { border-bottom: none; }
        .sched-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .sched-dot.green { background: var(--accent); }
        .sched-dot.dark { background: var(--sidebar-bg); }
        .sched-dot.light { background: var(--accent-light); }
        .sched-time { font-size: .78rem; font-weight: 600; color: var(--text-muted); min-width: 70px; }
        .sched-title { font-size: .875rem; font-weight: 600; color: var(--text-primary); }
        .sched-sub { font-size: .72rem; color: var(--text-muted); }
        .sched-badge { margin-left: auto; font-size: .65rem; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; padding: 3px 10px; border-radius: 20px; }
        .badge-confirmed { background: #e5f7ef; color: #1e7a4c; }
        .badge-pending { background: #fff8e5; color: #b06a00; }

        .btn-add-sched { background: var(--sidebar-bg); color: #fff; border: none; border-radius: 8px; padding: 8px 18px; font-size: .8rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: background .18s; }
        .btn-add-sched:hover { background: var(--accent); }

        /* Footer */
        .dash-footer { text-align: center; font-size: .7rem; color: var(--text-muted); border-top: 1px solid var(--border); padding: 14px 32px; display: flex; justify-content: space-between; }
        .footer-links a { color: var(--text-muted); text-decoration: none; margin-left: 18px; font-size: .7rem; }
        .footer-links a:hover { color: var(--accent); }

        /* Modal */
        .modal-content { border: 1px solid var(--border); border-radius: 14px; font-family: 'DM Sans', sans-serif; }
        .modal-header { padding: 20px 24px 16px; border-bottom: 1px solid var(--border); }
        .modal-title { font-weight: 700; font-size: .95rem; }
        .modal-body { padding: 22px 24px; }
        .modal-footer { padding: 14px 24px; border-top: 1px solid var(--border); }
        .form-label-sm { font-size: .65rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 5px; display: block; }
        .form-ctrl { border: 1px solid var(--border); border-radius: 8px; padding: 9px 14px; font-size: .845rem; font-family: 'DM Sans', sans-serif; color: var(--text-primary); background: var(--page-bg); width: 100%; outline: none; transition: border-color .15s; }
        .form-ctrl:focus { border-color: var(--accent); background: #fff; }
        .btn-save { background: var(--sidebar-bg); color: #fff; border: none; border-radius: 8px; padding: 9px 22px; font-size: .83rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: background .18s; }
        .btn-save:hover { background: var(--accent); }
        .btn-ghost { background: none; border: 1px solid var(--border); border-radius: 8px; padding: 9px 18px; font-size: .845rem; font-family: 'DM Sans', sans-serif; color: var(--text-muted); cursor: pointer; transition: all .15s; }
        .btn-ghost:hover { background: var(--page-bg); color: var(--text-primary); }
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
        <button class="btn-new-appt" data-bs-toggle="modal" data-bs-target="#addSchedModal">
            <i class="bi bi-plus-lg me-1"></i> New Appointment
        </button>
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
            <h3>Schedule</h3>
            <p>Doctor appointments and clinic scheduling</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-icon"><i class="bi bi-bell"></i></div>
            <div class="topbar-icon"><i class="bi bi-gear"></i></div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <main class="content">

        <!-- Section Header -->
        <div class="section-header">
            <div>
                <div class="section-title">Appointment Calendar</div>
                <div class="section-sub">View and manage all doctor schedules.</div>
            </div>
            <button class="btn-add-sched" data-bs-toggle="modal" data-bs-target="#addSchedModal">
                <i class="bi bi-plus-lg"></i> Add Appointment
            </button>
        </div>

        <!-- Calendar -->
        <div class="card-panel mb-4">
            <div class="cal-header">
                <div class="cal-month" id="calMonthLabel">April 2026</div>
                <div class="cal-nav">
                    <button class="cal-nav-btn" onclick="changeMonth(-1)"><i class="bi bi-chevron-left"></i></button>
                    <button class="cal-nav-btn" onclick="changeMonth(1)"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>
            <div class="cal-grid" id="calDayLabels">
                <div class="cal-day-label">Sun</div>
                <div class="cal-day-label">Mon</div>
                <div class="cal-day-label">Tue</div>
                <div class="cal-day-label">Wed</div>
                <div class="cal-day-label">Thu</div>
                <div class="cal-day-label">Fri</div>
                <div class="cal-day-label">Sat</div>
            </div>
            <div class="cal-grid mt-1" id="calBody"></div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="card-panel">
            <div class="d-flex align-items-start justify-content-between mb-3">
                <div>
                    <div class="panel-title">Upcoming Appointments</div>
                    <div class="panel-sub">Next 7 days schedule</div>
                </div>
            </div>
            <div class="sched-item">
                <div class="sched-dot green"></div>
                <div class="sched-time">08:00 AM</div>
                <div>
                    <div class="sched-title">Dr. Isabel Santos – OPD Clinic</div>
                    <div class="sched-sub">Room 01 · Up to 20 patients</div>
                </div>
                <span class="sched-badge badge-confirmed">Confirmed</span>
            </div>
            <div class="sched-item">
                <div class="sched-dot dark"></div>
                <div class="sched-time">09:30 AM</div>
                <div>
                    <div class="sched-title">Dr. Ramon Reyes – Internal Medicine</div>
                    <div class="sched-sub">Room 03 · Up to 15 patients</div>
                </div>
                <span class="sched-badge badge-confirmed">Confirmed</span>
            </div>
            <div class="sched-item">
                <div class="sched-dot light"></div>
                <div class="sched-time">01:00 PM</div>
                <div>
                    <div class="sched-title">Dr. Ana Cruz – Follow-up Consultations</div>
                    <div class="sched-sub">Room 02 · Up to 10 patients</div>
                </div>
                <span class="sched-badge badge-pending">Pending</span>
            </div>
            <div class="sched-item">
                <div class="sched-dot green"></div>
                <div class="sched-time">02:30 PM</div>
                <div>
                    <div class="sched-title">Staff Meeting – Monthly Review</div>
                    <div class="sched-sub">Conference Room · All staff required</div>
                </div>
                <span class="sched-badge badge-confirmed">Confirmed</span>
            </div>
        </div>

    </main>

    <footer class="dash-footer">
        <span>© 2024 CuraSure · Central Management</span>
        <div class="footer-links"><a href="#">Privacy Protocol</a><a href="#">Audit Log</a></div>
    </footer>
</div>

<!-- Add Schedule Modal -->
<div class="modal fade" id="addSchedModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">New Appointment / Schedule</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.schedule.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-sm">Title / Description</label>
                            <input type="text" name="title" class="form-ctrl" placeholder="e.g. Dr. Santos – OPD Clinic" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Date</label>
                            <input type="date" name="date" class="form-ctrl" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Time</label>
                            <input type="time" name="time" class="form-ctrl" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Doctor</label>
                            <select name="doctor_id" class="form-ctrl">
                                <option value="">— Select Doctor —</option>
                                <option>Dr. Isabel Santos</option>
                                <option>Dr. Ramon Reyes</option>
                                <option>Dr. Ana Cruz</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Room</label>
                            <select name="room" class="form-ctrl">
                                <option>Room 01</option>
                                <option>Room 02</option>
                                <option>Room 03</option>
                                <option>Conference Room</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label-sm">Notes (optional)</label>
                            <textarea name="notes" class="form-ctrl" rows="2" placeholder="Additional details…"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-ghost" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-save">Save Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sample events keyed by YYYY-MM-DD
    const events = {
        '2026-04-13': ['Dr. Santos – OPD'],
        '2026-04-14': ['Dr. Reyes – IM', 'Dr. Cruz – F/U'],
        '2026-04-15': ['Staff Meeting'],
        '2026-04-17': ['Dr. Santos – OPD'],
        '2026-04-20': ['Dr. Reyes – IM'],
        '2026-04-22': ['Dr. Cruz – F/U'],
        '2026-04-24': ['Dr. Santos – OPD', 'Board Review'],
    };
    const colors = ['', 'green', 'light'];

    let current = new Date(2026, 3, 1); // April 2026

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
        const daysInPrev = new Date(year, month, 0).getDate();
        const today = new Date();

        // Prev month padding
        for (let i = firstDay - 1; i >= 0; i--) {
            const cell = document.createElement('div');
            cell.className = 'cal-cell other-month';
            cell.innerHTML = `<div class="cal-date">${daysInPrev - i}</div>`;
            body.appendChild(cell);
        }
        // Current month days
        for (let d = 1; d <= daysInMonth; d++) {
            const cell = document.createElement('div');
            const key = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === d;
            cell.className = 'cal-cell' + (isToday ? ' today' : '');
            let html = `<div class="cal-date">${d}</div>`;
            if (events[key]) {
                events[key].forEach((ev, i) => {
                    html += `<div class="cal-event ${colors[i % colors.length]}">${ev}</div>`;
                });
            }
            cell.innerHTML = html;
            body.appendChild(cell);
        }
        // Next month padding
        const totalCells = firstDay + daysInMonth;
        const remaining = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
        for (let d = 1; d <= remaining; d++) {
            const cell = document.createElement('div');
            cell.className = 'cal-cell other-month';
            cell.innerHTML = `<div class="cal-date">${d}</div>`;
            body.appendChild(cell);
        }
    }
    renderCalendar();
</script>
</body>
</html>