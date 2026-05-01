<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure – Staff Dashboard</title>
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
            gap: 8px;
        }

.brand-logo {
    width: 40px; height: 40px;
    background: rgba(255,255,255,.1);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

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
.sidebar-link.active { background: var(--sidebar-active); color: #fff; border-left-color: var(--accent-light); font-weight: 500; }
.sidebar-link i { font-size: 1rem; width: 18px; text-align: center; }

.sidebar-bottom { padding: 16px 16px 24px; border-top: 1px solid rgba(255,255,255,.08); }

.btn-logout {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    background: none; border: none;
    padding: 8px 6px;
    color: rgba(255,255,255,.65);
    font-size: .82rem;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    border-left: 3px solid transparent;
    transition: all .18s;
}

/* ── Main ── */
.main-wrap { margin-left: 220px; min-height: 100vh; display: flex; flex-direction: column; }

.topbar {
    background: rgba(255,255,255,.85);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--border);
    padding: 0 32px;
    height: 58px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky; top: 0; z-index: 50;
}

.topbar-left h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; letter-spacing: .01em; }
.topbar-left p { font-size: .75rem; color: var(--text-muted); margin: 2px 0 0; }

.topbar-actions { display: flex; align-items: center; gap: 10px; }

.topbar-icon {
    width: 36px; height: 36px;
    border-radius: 8px;
    background: var(--page-bg);
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--text-muted); font-size: .95rem;
    cursor: pointer;
}

.avatar {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light));
    color: #fff; font-size: .8rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
}

/* Content Area */
.content { padding: 28px 32px 40px; flex: 1; }
.card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
.panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }

/* Section divider inside form */
.form-section-label {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--primary);
    padding: 6px 0 4px;
    border-bottom: 1px solid var(--accent-soft);
    margin-bottom: 14px;
    display: block;
}

/* Custom Form Styles */
.form-label-custom { font-size: .68rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 5px; display: block; }
.form-control-custom { border: 1px solid var(--border); border-radius: 8px; padding: 9px 14px; font-size: .845rem; font-family: 'DM Sans', sans-serif; color: var(--text-primary); background: var(--page-bg); width: 100%; outline: none; transition: border-color .15s; }
.form-control-custom:focus { border-color: var(--accent); background: #fff; }
.input-invalid { border-color: #dc3545 !important; background: #fff5f5 !important; }
.input-error-text { color: #b02a37; font-size: .72rem; margin-top: 4px; }
.form-control-custom[readonly], .form-control-custom:disabled { background-color: #f0f4f2; color: #9aada6; border-color: #dce6e1; cursor: not-allowed; }

/* N/A Toggle */
.na-field-wrap { position: relative; }
.na-toggle-row { display: flex; align-items: center; gap: 8px; margin-bottom: 5px; }
.na-toggle-row .form-label-custom { margin-bottom: 0; flex: 1; }
.na-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: var(--page-bg);
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 2px 9px;
    font-size: .62rem;
    font-weight: 700;
    letter-spacing: .06em;
    color: var(--text-muted);
    cursor: pointer;
    transition: all .15s;
    text-transform: uppercase;
    white-space: nowrap;
    flex-shrink: 0;
}
.na-btn:hover { background: #fff4e5; border-color: #f0d9a0; color: #b07000; }
.na-btn.active { background: #fff4e5; border-color: #f0d9a0; color: #b07000; }
.na-btn.active::before { content: '✓ '; }

/* Priority Toggle */
.form-toggle-row {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--accent-soft);
    border: 1px solid #c0dfd0;
    border-radius: 10px;
    padding: 10px 14px;
    margin-bottom: 18px;
    cursor: pointer;
}
.form-toggle-row input[type="checkbox"] { accent-color: var(--primary); width: 15px; height: 15px; cursor: pointer; }
.form-toggle-row label { font-size: .8rem; font-weight: 600; color: var(--primary); cursor: pointer; margin: 0; }
.form-toggle-row small { font-size: .7rem; color: var(--text-muted); }

.btn-register { width: 100%; background: var(--sidebar-bg); color: #fff; border: none; border-radius: 8px; padding: 11px 0; font-size: .85rem; font-weight: 600; cursor: pointer; transition: background .18s; }
.btn-register:hover { background: var(--accent); }

/* Live Updates Section */
.badge-live { background: var(--accent-soft); color: #1b7a4e; border: 1px solid #c0dfd0; font-size: .65rem; font-weight: 600; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px; text-transform: uppercase; }
.badge-live::before { content: ''; width: 6px; height: 6px; background: #1b7a4e; border-radius: 50%; animation: pulse 1.6s infinite; }
@keyframes pulse { 0%,100% { opacity: 1; transform: scale(1); } 50% { opacity: .5; transform: scale(1.3); } }

.patient-entry-item { padding: 12px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.patient-entry-item:last-child { border-bottom: none; }
.entry-avatar { width: 32px; height: 32px; background: var(--sidebar-bg); color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: 700; }
.entry-name { font-size: 0.85rem; font-weight: 600; color: var(--text-primary); }
.entry-meta { font-size: 0.7rem; color: var(--text-muted); }
.status-indicator { font-size: 0.65rem; font-weight: 700; padding: 2px 8px; border-radius: 12px; text-transform: uppercase; }
.status-indicator.diagnosing { background: var(--accent-soft); color: var(--primary); }
.status-indicator.waiting { background: #fff4e5; color: #b07000; }

.mini-stat-card { border-radius: 10px; padding: 14px 16px; }
.mini-stat-card.green-dark { background: var(--sidebar-bg); color: #fff; }
.mini-stat-card.green-light { background: #d1e7dd; }

/* --- PROFILE MODAL STYLING --- */
.modal-content-clean { border: none; border-radius: 28px; padding: 25px; }
.modal-header-profile { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; }
.profile-pic-large { width: 80px; height: 80px; border-radius: 20px; background: #f2f7f5; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-family: 'DM Serif Display', serif; color: #1b3d2f; }
.profile-title-area h2 { font-family: 'DM Serif Display', serif; margin: 0; font-size: 1.6rem; color: #1a202c; }
.modal-tabs { display: flex; gap: 25px; border-bottom: 1px solid #e9ecef; margin-bottom: 25px; }
.tab-item { padding-bottom: 10px; font-weight: 700; font-size: 0.85rem; color: #718096; }
.tab-item.active { color: #3d8b6e; border-bottom: 3px solid #3d8b6e; }
.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
.info-row-full { grid-column: span 2; }
.info-box { display: flex; align-items: flex-start; gap: 15px; }
.info-icon { width: 38px; height: 38px; border-radius: 10px; background: #f2f7f5; display: flex; align-items: center; justify-content: center; color: #3d8b6e; font-size: 1.1rem; }
.info-content label { display: block; font-size: 0.65rem; text-transform: uppercase; font-weight: 800; color: #718096; margin-bottom: 2px; }
.info-content span { font-size: 1rem; font-weight: 700; color: #1a202c; }
.btn-close-custom { width: 100%; padding: 14px; border-radius: 50px; border: 1px solid #e9ecef; background: white; font-weight: 700; color: #718096; margin-top: 35px; }

.dash-footer { text-align: center; font-size: .7rem; color: var(--text-muted); border-top: 1px solid var(--border); padding: 14px 32px; display: flex; justify-content: space-between; }

@keyframes bellPulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: .7; }
}
@media (prefers-reduced-motion: no-preference) {
    @keyframes pageFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes softRise { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
    body { animation: pageFadeIn .35s ease-out; }
    .stat-chip, .card-panel, .queue-table-wrap, .search-wrap, .modal-content { animation: softRise .35s ease-out both; }
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
    <div class="sidebar-brand">
         <img src="{{ asset('img/logo.png') }}" alt="CuraSure" style="width:64px; height:64px; object-fit:contain; border-radius:8px;">
        <div class="brand-name">CuraSure</div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('staff.dashboard') }}" class="sidebar-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i> Dashboard</a>
        <a href="{{ route('staff.queue') }}" class="sidebar-link {{ request()->routeIs('staff.queue') ? 'active' : '' }}"><i class="bi bi-people"></i> Patient Queue</a>
        <a href="{{ route('staff.payments') }}" class="sidebar-link {{ request()->routeIs('staff.payments') ? 'active' : '' }}"><i class="bi bi-cash-stack"></i> Billing & Payments</a>
    </nav>
    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-left"></i> Logout</button>
        </form>
    </div>
</aside>

<div class="main-wrap">
    <header class="topbar">
        <div class="topbar-left">
            <h3>Dashboard</h3>
            <p>Welcome back, {{ Auth::user()->name }}</p>
        </div>
        <div class="topbar-actions">
            {{-- Bell with red dot + dropdown --}}
            <div style="position:relative;" id="staffBellBtn" onclick="toggleStaffNotif()">
                <div class="topbar-icon" style="cursor:pointer; position:relative;">
                    <i class="bi bi-bell"></i>
                    @php $diagnosingCount = \App\Models\PatientQueue::whereDate('created_at', today())->where('status','diagnosing')->count(); @endphp
                    @if($diagnosingCount > 0)
                        <span id="staffBellBadge" style="position:absolute;top:-4px;right:-4px;width:10px;height:10px;background:#e53935;border-radius:50%;border:2px solid #fff;display:block;animation:bellPulse 1.5s infinite;"></span>
                    @else
                        <span id="staffBellBadge" style="position:absolute;top:-4px;right:-4px;width:10px;height:10px;background:#e53935;border-radius:50%;border:2px solid #fff;display:none;"></span>
                    @endif
                </div>
                <div id="staffNotifDropdown" style="display:none;position:absolute;top:44px;right:0;width:290px;background:#fff;border:1px solid var(--border);border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.1);z-index:200;overflow:hidden;">
                    <div style="padding:12px 16px;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--text-muted);border-bottom:1px solid var(--border);">
                        <i class="bi bi-activity me-1"></i> Doctor Activity
                    </div>
                    @php $diagnosing = \App\Models\PatientQueue::with('patient')->whereDate('created_at', today())->where('status','diagnosing')->get(); @endphp
                    @forelse($diagnosing as $d)
                        <a href="{{ route('staff.queue') }}" style="display:flex;align-items:center;gap:10px;padding:12px 16px;border-bottom:1px solid var(--border);text-decoration:none;color:var(--text-primary);">
                            <span style="width:8px;height:8px;border-radius:50%;background:var(--primary);flex-shrink:0;"></span>
                            <div style="flex:1;">
                                <div style="font-weight:700;font-size:.8rem;">{{ $d->patient_name ?? $d->patient?->name ?? 'Unknown Patient' }}</div>
                                <div style="font-size:.7rem;color:var(--text-muted);">{{ $d->display_queue_number }} · Being diagnosed {{ $d->called_at ? '· '.\Carbon\Carbon::parse($d->called_at)->format('g:i A') : '' }}</div>
                            </div>
                            <span style="font-size:.7rem;font-weight:700;color:var(--primary);white-space:nowrap;">View →</span>
                        </a>
                    @empty
                        <div style="padding:20px 16px;text-align:center;color:var(--text-muted);font-size:.78rem;">No active diagnoses</div>
                    @endforelse
                    <a href="{{ route('staff.queue') }}" style="display:block;text-align:center;padding:10px;font-size:.78rem;font-weight:700;color:var(--primary);text-decoration:none;border-top:1px solid var(--border);">
                        Go to Patient Queue →
                    </a>
                </div>
            </div>

            <div class="avatar" data-bs-toggle="modal" data-bs-target="#staffProfileModal">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>
    </header>

    <main class="content">
        <div class="row g-4">
            <!-- ── Registration Form ── -->
            <div class="col-lg-6 col-md-12">
                <div class="card-panel">
                    <div class="panel-title mb-1">Patient Registration</div>
                    <p style="font-size:.72rem; color:var(--text-muted); margin-bottom:16px;">Fields marked <span style="color:#b07000; font-weight:700;">N/A</span> can be toggled if information is unavailable.</p>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert" style="background:#e8f5f0; border:1px solid #c0dfd0; color:#1b7a4e; border-radius:8px; padding:10px 14px; font-size:.82rem; font-weight:600; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
                            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert" style="background:#fff5f5; border:1px solid #f1b0b7; color:#b02a37; border-radius:8px; padding:10px 14px; font-size:.8rem; margin-bottom:16px;">
                            <strong>Please fix the following:</strong>
                            <ul style="margin:6px 0 0 16px; padding:0;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- ── Duplicate Patient Warning Banner ── --}}
                    <div id="duplicateWarningBanner" style="display:none; background:#fff8e1; border:1.5px solid #f6c90e; color:#7a5c00; border-radius:10px; padding:13px 16px; margin-bottom:16px; font-size:.82rem;">
                        <div style="display:flex; align-items:flex-start; gap:10px;">
                            <i class="bi bi-exclamation-triangle-fill" style="font-size:1.2rem; color:#e6a817; flex-shrink:0; margin-top:1px;"></i>
                            <div>
                                <div style="font-weight:700; font-size:.87rem; margin-bottom:3px;">⚠ Patient Already in Queue Today</div>
                                <div id="duplicateWarningText">This patient is already in queue. Are you sure you want to add this? This might lead to duplication.</div>
                                <div style="margin-top:8px; display:flex; gap:8px; flex-wrap:wrap;">
                                    <button type="button" onclick="acknowledgeDuplicateWarning()" style="display:inline-flex; align-items:center; gap:5px; background:#1b3d2f; color:#fff; border-radius:6px; padding:5px 13px; font-size:.76rem; font-weight:700; cursor:pointer;">
                                        <i class="bi bi-check-circle"></i> Okay
                                    </button>
                                    <button type="button" onclick="dismissDuplicateWarning()" style="display:inline-flex; align-items:center; gap:5px; background:none; border:1.5px solid #c9a800; color:#7a5c00; border-radius:6px; padding:5px 13px; font-size:.76rem; font-weight:700; cursor:pointer;">
                                        <i class="bi bi-x-circle"></i> Dismiss & Proceed Anyway
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Returning Patient Warning Banner ── --}}
                    <div id="returningWarningBanner" style="display:none; background:#e8f0ff; border:1.5px solid #4a90e2; color:#1e40af; border-radius:10px; padding:13px 16px; margin-bottom:16px; font-size:.82rem;">
                        <div style="display:flex; align-items:flex-start; gap:10px;">
                            <i class="bi bi-info-circle-fill" style="font-size:1.2rem; color:#4a90e2; flex-shrink:0; margin-top:1px;"></i>
                            <div>
                                <div style="font-weight:700; font-size:.87rem; margin-bottom:3px;">ℹ Returning Patient Detected</div>
                                <div id="returningWarningText">This patient has a diagnosis history in the system. Are you sure you want to add them again?</div>
                                <div style="margin-top:8px; display:flex; gap:8px; flex-wrap:wrap;">
                                    <button type="button" onclick="dismissReturningWarning()" style="display:inline-flex; align-items:center; gap:5px; background:#1b3d2f; color:#fff; border-radius:6px; padding:5px 13px; font-size:.76rem; font-weight:700; cursor:pointer;">
                                        <i class="bi bi-check-circle"></i> Yes, Proceed
                                    </button>
                                    <button type="button" onclick="cancelReturningWarning()" style="display:inline-flex; align-items:center; gap:5px; background:none; border:1.5px solid #4a90e2; color:#1e40af; border-radius:6px; padding:5px 13px; font-size:.76rem; font-weight:700; cursor:pointer;">
                                        <i class="bi bi-x-circle"></i> Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('staff.store') }}">
                        @csrf

                        {{-- ── Personal Info ── --}}
                        <span class="form-section-label"><i class="bi bi-person me-1"></i> Personal Information</span>

                        <div class="mb-3">
                            <label class="form-label-custom">Full Patient Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control-custom {{ $errors->has('name') ? 'input-invalid' : '' }}" placeholder="e.g. Elena Rodriguez" required onblur="checkDuplicatePatient()">
                        </div>

                        <div class="row mb-3 g-2">
                            <div class="col-md-4">
                                <label class="form-label-custom">Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control-custom {{ $errors->has('date_of_birth') ? 'input-invalid' : '' }}" id="dob" onchange="calcAge()" onblur="checkDuplicatePatient()">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label-custom">Age</label>
                                <input type="number" name="age" value="{{ old('age') }}" class="form-control-custom {{ $errors->has('age') ? 'input-invalid' : '' }}" id="age" placeholder="—" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Gender</label>
                                <select name="gender" class="form-control-custom {{ $errors->has('gender') ? 'input-invalid' : '' }}" style="appearance: auto;" required>
                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select</option>
                                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Civil Status</label>
                                <select name="civil_status" class="form-control-custom {{ $errors->has('civil_status') ? 'input-invalid' : '' }}" style="appearance: auto;">
                                    <option value="" {{ old('civil_status') ? '' : 'selected' }}>Select</option>
                                    <option value="Single" {{ old('civil_status') === 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('civil_status') === 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Widowed" {{ old('civil_status') === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                    <option value="Separated" {{ old('civil_status') === 'Separated' ? 'selected' : '' }}>Separated</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3 g-2">
                            <div class="col-md-6">
                                <label class="form-label-custom">Contact Number</label>
                                <input type="text" name="contact_number" value="{{ old('contact_number') }}" class="form-control-custom {{ $errors->has('contact_number') ? 'input-invalid' : '' }}" placeholder="+63 (555) 000-0000" required onblur="checkDuplicatePatient()">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Address</label>
                                <input type="text" name="address" value="{{ old('address') }}" class="form-control-custom {{ $errors->has('address') ? 'input-invalid' : '' }}" placeholder="123 Health St, Davao City" required onblur="checkDuplicatePatient()">
                            </div>
                        </div>

                        <div class="row mb-4 g-2">
                            <div class="col-md-4">
                                <label class="form-label-custom">Blood Type</label>
                                <select name="blood_type" onchange="checkDuplicatePatient()" class="form-control-custom {{ $errors->has('blood_type') ? 'input-invalid' : '' }}" style="appearance: auto;">
                                    <option value="">Select Type</option>
                                    <option value="A+"  {{ old('blood_type') === 'A+'  ? 'selected' : '' }}>A+</option>
                                    <option value="A-"  {{ old('blood_type') === 'A-'  ? 'selected' : '' }}>A-</option>
                                    <option value="B+"  {{ old('blood_type') === 'B+'  ? 'selected' : '' }}>B+</option>
                                    <option value="B-"  {{ old('blood_type') === 'B-'  ? 'selected' : '' }}>B-</option>
                                    <option value="O+"  {{ old('blood_type') === 'O+'  ? 'selected' : '' }}>O+</option>
                                    <option value="O-"  {{ old('blood_type') === 'O-'  ? 'selected' : '' }}>O-</option>
                                    <option value="AB+" {{ old('blood_type') === 'AB+' ? 'selected' : '' }}>AB+</option>
                                    <option value="AB-" {{ old('blood_type') === 'AB-' ? 'selected' : '' }}>AB-</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Height (cm)</label>
                                <input type="number" name="height" value="{{ old('height') }}" class="form-control-custom {{ $errors->has('height') ? 'input-invalid' : '' }}" placeholder="170">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Weight (kg)</label>
                                <input type="number" name="weight" value="{{ old('weight') }}" class="form-control-custom {{ $errors->has('weight') ? 'input-invalid' : '' }}" placeholder="70">
                            </div>
                        </div>

                        {{-- ── Administrative ── --}}
                        <span class="form-section-label"><i class="bi bi-card-checklist me-1"></i> Administrative Details</span>

                        <div class="row mb-3 g-2">
                            <div class="col-md-6">
                                <div class="na-toggle-row">
                                    <label class="form-label-custom">PhilHealth No.</label>
                                    <button type="button" class="na-btn" onclick="toggleNA(this, 'philhealth')">N/A</button>
                                </div>
                                <input type="text" name="philhealth_no" value="{{ old('philhealth_no') }}" class="form-control-custom {{ $errors->has('philhealth_no') ? 'input-invalid' : '' }}" id="philhealth" placeholder="XX-XXXXXXXXX-X">
                            </div>
                            <div class="col-md-6">
                                <div class="na-toggle-row">
                                    <label class="form-label-custom">HMO / Insurance</label>
                                    <button type="button" class="na-btn" onclick="toggleNA(this, 'hmo')">N/A</button>
                                </div>
                                <input type="text" name="hmo_insurance" value="{{ old('hmo_insurance') }}" class="form-control-custom {{ $errors->has('hmo_insurance') ? 'input-invalid' : '' }}" id="hmo" placeholder="Provider & Member No.">
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="na-toggle-row">
                                <label class="form-label-custom">Emergency Contact</label>
                                <button type="button" class="na-btn" onclick="toggleNA(this, 'emgContact'); toggleNA(this, 'emgName')">N/A</button>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" class="form-control-custom {{ $errors->has('emergency_contact_name') ? 'input-invalid' : '' }}" id="emgName" placeholder="Contact Person Name" onblur="checkDuplicatePatient()">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="emergency_contact_number" value="{{ old('emergency_contact_number') }}" class="form-control-custom {{ $errors->has('emergency_contact_number') ? 'input-invalid' : '' }}" id="emgContact" placeholder="+63 (555) 000-0000" onblur="checkDuplicatePatient()">
                                </div>
                            </div>
                        </div>

                        {{-- ── Medical History ── --}}
                        <span class="form-section-label"><i class="bi bi-heart-pulse me-1"></i> Medical History</span>

                        <div class="mb-3">
                            <div class="na-toggle-row">
                                <label class="form-label-custom">Known Allergies</label>
                                <button type="button" class="na-btn" onclick="toggleNA(this, 'allergies')">N/A</button>
                            </div>
                            <input type="text" name="known_allergies" value="{{ old('known_allergies') }}" class="form-control-custom {{ $errors->has('known_allergies') ? 'input-invalid' : '' }}" id="allergies" placeholder="e.g. Penicillin, Shellfish, Dust">
                        </div>

                        <div class="mb-3">
                            <div class="na-toggle-row">
                                <label class="form-label-custom">Existing Conditions</label>
                                <button type="button" class="na-btn" onclick="toggleNA(this, 'conditions')">N/A</button>
                            </div>
                            <input type="text" name="existing_conditions" value="{{ old('existing_conditions') }}" class="form-control-custom {{ $errors->has('existing_conditions') ? 'input-invalid' : '' }}" id="conditions" placeholder="e.g. Hypertension, Diabetes Type 2">
                        </div>

                        <div class="mb-4">
                            <div class="na-toggle-row">
                                <label class="form-label-custom">Current Medications</label>
                                <button type="button" class="na-btn" onclick="toggleNA(this, 'medications')">N/A</button>
                            </div>
                            <input type="text" name="current_medications" value="{{ old('current_medications') }}" class="form-control-custom {{ $errors->has('current_medications') ? 'input-invalid' : '' }}" id="medications" placeholder="e.g. Metformin 500mg, Losartan 50mg">
                        </div>

                        {{-- ── Visit Info ── --}}
                        <span class="form-section-label"><i class="bi bi-clipboard2-pulse me-1"></i> Visit Information</span>

                        <div class="mb-4">
                            <label class="form-label-custom">Primary Symptoms</label>
                            <textarea name="primary_symptoms" class="form-control-custom {{ $errors->has('primary_symptoms') ? 'input-invalid' : '' }}" rows="3" placeholder="Describe symptoms…" required>{{ old('primary_symptoms') }}</textarea>
                        </div>

                        {{-- ── Check-up Type & Billing ── --}}
                        <span class="form-section-label"><i class="bi bi-cash-stack me-1"></i> Check-up Type & Billing</span>

                        <div class="row mb-3 g-2">
                            <div class="col-md-6">
                                <label class="form-label-custom">Select Check-up Type</label>
                                <select name="checkup_type_id" id="checkupTypeSelect" class="form-control-custom {{ $errors->has('checkup_type_id') ? 'input-invalid' : '' }}" style="appearance:auto;" onchange="updateFeeDisplay()">
                                    <option value="">-- Select Type --</option>
                                    @forelse($checkupTypes as $type)
                                        <option value="{{ $type->id }}" data-fee="{{ $type->fee }}" {{ old('checkup_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }} - ₱{{ number_format($type->fee, 2) }}
                                        </option>
                                    @empty
                                        <option value="">No check-up types available</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Or Custom Fee (Override)</label>
                                <input type="number" name="custom_fee" id="customFee" value="{{ old('custom_fee') }}" class="form-control-custom {{ $errors->has('custom_fee') ? 'input-invalid' : '' }}" placeholder="0.00" step="0.01" min="0" onchange="toggleCustomFee()">
                            </div>
                        </div>
                        <div id="feeDisplay" class="mb-3" style="font-size: .8rem; color: var(--text-muted);">
                            <i class="bi bi-info-circle me-1"></i> Fee will be automatically assigned based on check-up type
                        </div>

                        <span class="form-section-label"><i class="bi bi-exclamation-octagon me-1"></i> Priority Handling</span>
                        <div class="form-toggle-row mb-3" onclick="togglePriority(this)">
                            <input type="checkbox" id="priorityCheck" name="is_priority" value="1" {{ old('is_priority') ? 'checked' : '' }}>
                            <div>
                                <label for="priorityCheck">Mark as Priority Patient?</label><br>
                                <small>Use for seniors, PWD, pregnant, or urgent cases.</small>
                            </div>
                        </div>
                        <div id="priorityFields" style="display: {{ old('is_priority') ? 'block' : 'none' }};">
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Priority Type</label>
                                    <select name="priority_type" class="form-control-custom {{ $errors->has('priority_type') ? 'input-invalid' : '' }}" style="appearance:auto;">
                                        <option value="">Select priority type</option>
                                        <option value="senior"   {{ old('priority_type') === 'senior'   ? 'selected' : '' }}>Senior Citizen</option>
                                        <option value="pwd"      {{ old('priority_type') === 'pwd'      ? 'selected' : '' }}>PWD</option>
                                        <option value="pregnant" {{ old('priority_type') === 'pregnant' ? 'selected' : '' }}>Pregnant</option>
                                        <option value="urgent"   {{ old('priority_type') === 'urgent'   ? 'selected' : '' }}>Urgent Case</option>
                                        <option value="other"    {{ old('priority_type') === 'other'    ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Priority Notes</label>
                                    <input type="text" name="priority_notes" value="{{ old('priority_notes') }}" class="form-control-custom" placeholder="Optional note">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-register" id="submitRegistrationBtn" onclick="return handleRegistrationSubmit(event)">
                            <i class="bi bi-person-check me-2"></i> Complete Registration
                        </button>
                    </form>
                </div>
            </div>

            <!-- ── Recent Entries ── -->
            <div class="col-lg-6 col-md-12">
                <div class="card-panel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="panel-title mb-0">Recent Entries</div>
                        <span class="badge-live">Live Updates</span>
                    </div>
                    <div class="recent-patients-list mb-3">
                        @forelse($recentQueue as $entry)
                        <div class="patient-entry-item">
                            <div class="d-flex align-items-center gap-3">
                                <div class="entry-avatar">{{ strtoupper(substr($entry->patient_name ?? $entry->patient?->name ?? 'UN', 0, 2)) }}</div>
                                <div>
                                    <div class="entry-name">{{ $entry->patient_name ?? $entry->patient?->name ?? 'Unknown Patient' }}</div>
                                    <div class="entry-meta">{{ $entry->display_queue_number }} • {{ \Carbon\Carbon::parse($entry->queued_at)->format('h:i A') }}</div>
                                </div>
                            </div>
                            <span class="status-indicator {{ $entry->status }}">{{ ucfirst($entry->status) }}</span>
                        </div>
                        @empty
                        <div style="text-align:center; padding:20px; color:var(--text-muted); font-size:.82rem;">
                            No patients registered today yet.
                        </div>
                        @endforelse
                    </div>
                    <a href="{{ route('staff.queue') }}" style="display:block; text-align:center; font-size:.78rem; color:var(--primary); text-decoration:none; margin:15px 0; font-weight:600;">View all recent registrations →</a>
                    <div class="row g-3">
                        <div class="col-6"><div class="mini-stat-card green-dark"><i class="bi bi-clock-history"></i> Avg Intake Time <div class="h5 mb-0 fw-bold">—</div></div></div>
                        <div class="col-6"><div class="mini-stat-card green-light"><i class="bi bi-people"></i> Daily Total<div class="h5 mb-0 fw-bold">{{ $recentQueue->count() }}</div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="dash-footer">
        <span>© 2024 CuraSure · Staff Portal</span>
        <div class="footer-links">
            <a href="#" style="color:var(--text-muted); text-decoration:none; font-size:.7rem; margin-left:15px;">Privacy Protocol</a>
            <a href="{{ route('support') }}" style="color:var(--text-muted); text-decoration:none; font-size:.7rem; margin-left:15px;">Support</a>
        </div>
    </footer>
</div>

<!-- Staff Profile Modal -->
<div class="modal fade" id="staffProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-clean">
            <div class="modal-header-profile">
                <div class="profile-pic-large">S</div>
                <div class="profile-title-area">
                    <h2>Sarah Staff</h2>
                    <p class="text-muted small">Medical Staff</p>
                </div>
            </div>
            <div class="modal-tabs">
                <div class="tab-item active">Information</div>
                <div class="tab-item">Account</div>
            </div>
            <div class="info-grid">
                <div class="info-box info-row-full">
                    <div class="info-icon"><i class="bi bi-person-badge"></i></div>
                    <div class="info-content"><label>Full Name</label><span>Sarah Staff</span></div>
                </div>
                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-calendar-event"></i></div>
                    <div class="info-content"><label>Age</label><span>28 Years</span></div>
                </div>
                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-gender-ambiguous"></i></div>
                    <div class="info-content"><label>Gender</label><span>Female</span></div>
                </div>
                <div class="info-box info-row-full">
                    <div class="info-icon"><i class="bi bi-geo-alt"></i></div>
                    <div class="info-content"><label>Address</label><span>123 Medical Ave, Davao City</span></div>
                </div>
                <hr class="info-row-full" style="opacity: 0.1; margin: 5px 0;">
                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-card-text"></i></div>
                    <div class="info-content"><label>Staff ID Number</label><span>ID-88291</span></div>
                </div>
                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-briefcase"></i></div>
                    <div class="info-content"><label>Current Role</label><span>Front Desk</span></div>
                </div>
            </div>
            <button type="button" class="btn-close-custom" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    /* Auto-calculate age from DOB */
    function calcAge() {
        const dob = document.getElementById('dob').value;
        if (!dob) return;
        const today = new Date();
        const birth = new Date(dob);
        let age = today.getFullYear() - birth.getFullYear();
        const m = today.getMonth() - birth.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
        document.getElementById('age').value = age;
    }

    /* Update fee display when checkup type changes */
    function updateFeeDisplay() {
        const select = document.getElementById('checkupTypeSelect');
        const customFee = document.getElementById('customFee');
        const display = document.getElementById('feeDisplay');
        
        if (select.selectedOptions.length > 0) {
            const option = select.selectedOptions[0];
            const fee = option.getAttribute('data-fee');
            if (fee && !customFee.value) {
                display.innerHTML = '<i class="bi bi-info-circle me-1"></i> Selected: <strong>₱' + parseFloat(fee).toFixed(2) + '</strong>';
            } else if (customFee.value) {
                display.innerHTML = '<i class="bi bi-info-circle me-1"></i> Custom fee override: <strong>₱' + parseFloat(customFee.value).toFixed(2) + '</strong>';
            } else {
                display.innerHTML = '<i class="bi bi-info-circle me-1"></i> Fee will be automatically assigned based on check-up type';
            }
        }
    }

    /* Toggle custom fee when manually entered */
    function toggleCustomFee() {
        const customFee = document.getElementById('customFee');
        const select = document.getElementById('checkupTypeSelect');
        const display = document.getElementById('feeDisplay');
        
        if (customFee.value && parseFloat(customFee.value) > 0) {
            select.value = ''; // Clear checkup type when using custom fee
            display.innerHTML = '<i class="bi bi-info-circle me-1"></i> Custom fee override: <strong>₱' + parseFloat(customFee.value).toFixed(2) + '</strong>';
        } else {
            updateFeeDisplay();
        }
    }

    /* N/A toggle for a field */
    function toggleNA(btn, fieldId) {
        const field = document.getElementById(fieldId);
        if (!field) return;
        const isNA = btn.classList.toggle('active');
        field.disabled = isNA;
        if (isNA) {
            field._prev = field.value;
            field.value = 'N/A';
        } else {
            field.value = field._prev || '';
        }
    }

    function togglePriority(wrapper) {
        const cb = wrapper.querySelector('input[type="checkbox"]');
        cb.checked = !cb.checked;
        const fields = document.getElementById('priorityFields');
        fields.style.display = cb.checked ? 'block' : 'none';
    }

    /* ── Duplicate Patient Detection ── */
    let _duplicateWarningDismissed = false;
    let _returningWarningDismissed = false;
    let _duplicateCheckTimeout = null;

    function checkDuplicatePatient() {
        const name      = (document.querySelector('[name="name"]')?.value ?? '').trim();
        const dob       = (document.querySelector('[name="date_of_birth"]')?.value ?? '').trim();
        const address   = (document.querySelector('[name="address"]')?.value ?? '').trim();
        const age       = (document.querySelector('[name="age"]')?.value ?? '').trim();
        const contact   = (document.querySelector('[name="contact_number"]')?.value ?? '').trim();
        const bloodType = (document.querySelector('[name="blood_type"]')?.value ?? '').trim();
        const emgName   = (document.getElementById('emgName')?.value ?? '').trim();
        const emgContact= (document.getElementById('emgContact')?.value ?? '').trim();

        const filledCount = [dob, age, contact, bloodType, emgName, emgContact].filter(v => v && v !== 'N/A').length;
        if (!name || !dob || !address || !age || !contact || !bloodType) return;

        clearTimeout(_duplicateCheckTimeout);
        _duplicateCheckTimeout = setTimeout(() => {
            // Check for duplicate in today's queue
            fetch(`{{ route('patients.check-queue') }}?` + new URLSearchParams({
                name, date_of_birth: dob, address, age, contact_number: contact,
                blood_type: bloodType, emergency_contact_name: emgName,
                emergency_contact_number: emgContact
            }))
            .then(res => res.json())
            .then(data => {
                if (data.in_queue && !_duplicateWarningDismissed) {
                    const banner = document.getElementById('duplicateWarningBanner');
                    const text   = document.getElementById('duplicateWarningText');
                    text.innerHTML = `<strong>${data.patient_name ?? name}</strong> is already in queue. Are you sure you want to add this? This might lead to duplication.`;
                    banner.style.display = 'block';
                    banner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else if (!data.in_queue) {
                    hideDuplicateBanner();
                }
            })
            .catch(() => {});

            // Check for returning patient (assuming a route 'patients.check-existence' exists)
            fetch(`{{ route('patients.check-existence') }}?` + new URLSearchParams({
                name, date_of_birth: dob, address
            }))
            .then(res => res.json())
            .then(data => {
                if (data.exists && !_returningWarningDismissed) {
                    const banner = document.getElementById('returningWarningBanner');
                    const text   = document.getElementById('returningWarningText');
                    text.innerHTML = `<strong>${data.patient_name ?? name}</strong> is a returning patient with diagnosis history in the system. Are you sure you want to add them again?`;
                    banner.style.display = 'block';
                    banner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                } else if (!data.exists) {
                    hideReturningBanner();
                }
            })
            .catch(() => {});
        }, 500);
    }

    function ucfirstStatus(s) {
        return s ? s.charAt(0).toUpperCase() + s.slice(1) : s;
    }

    function hideDuplicateBanner() {
        document.getElementById('duplicateWarningBanner').style.display = 'none';
    }

    function acknowledgeDuplicateWarning() {
        hideDuplicateBanner();
    }

    function dismissDuplicateWarning() {
        _duplicateWarningDismissed = true;
        hideDuplicateBanner();
    }

    function dismissReturningWarning() {
        _returningWarningDismissed = true;
        hideReturningBanner();
    }

    function cancelReturningWarning() {
        // Optionally clear the form or focus on name field
        document.querySelector('[name="name"]').focus();
        hideReturningBanner();
    }

    function hideReturningBanner() {
        document.getElementById('returningWarningBanner').style.display = 'none';
    }

    function handleRegistrationSubmit(e) {
        const duplicateBanner = document.getElementById('duplicateWarningBanner');
        const returningBanner = document.getElementById('returningWarningBanner');
        if ((duplicateBanner.style.display !== 'none' && !_duplicateWarningDismissed) ||
            (returningBanner.style.display !== 'none' && !_returningWarningDismissed)) {
            e.preventDefault();
            if (duplicateBanner.style.display !== 'none') {
                duplicateBanner.style.outline = '2.5px solid #e6a817';
                duplicateBanner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                setTimeout(() => { duplicateBanner.style.outline = 'none'; }, 1800);
            }
            if (returningBanner.style.display !== 'none') {
                returningBanner.style.outline = '2.5px solid #4a90e2';
                returningBanner.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                setTimeout(() => { returningBanner.style.outline = 'none'; }, 1800);
            }
            return false;
        }
        return true;
    }

    function toggleStaffNotif() {
        const d = document.getElementById('staffNotifDropdown');
        d.style.display = d.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(e) {
        const btn = document.getElementById('staffBellBtn');
        const dropdown = document.getElementById('staffNotifDropdown');
        if (btn && !btn.contains(e.target)) dropdown.style.display = 'none';
    });
</script>

</body>
</html>