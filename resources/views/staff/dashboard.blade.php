<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CuraSure – Staff Dashboard</title>
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

/* Returning Patient Toggle */
.returning-toggle {
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
.returning-toggle input[type="checkbox"] { accent-color: var(--primary); width: 15px; height: 15px; cursor: pointer; }
.returning-toggle label { font-size: .8rem; font-weight: 600; color: var(--primary); cursor: pointer; margin: 0; }
.returning-toggle small { font-size: .7rem; color: var(--text-muted); }

#returningSearch { display: none; }
#returningSearch.visible { display: block; }

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
        <div class="brand-logo"><i class="bi bi-shield-plus" style="color:#4fce9e; font-size: 1.2rem;"></i></div>
        <div class="brand-name">CuraSure</div>
    </div>
    <nav class="sidebar-nav">
        <a href="#" class="sidebar-link active"><i class="bi bi-grid-1x2"></i> Dashboard</a>
        <a href="{{ route('staff.queue') }}" class="sidebar-link"><i class="bi bi-people"></i> Patient Queue</a>
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

                    {{-- FIXED: added method, action, and @csrf --}}
                    <form method="POST" action="{{ route('staff.store') }}">
                        @csrf
                        <input type="hidden" name="returning_patient_id" id="returning_patient_id" value="{{ old('returning_patient_id') }}">

                        {{-- ── Returning Patient ── --}}
                        <div class="returning-toggle" onclick="toggleReturning(this)">
                            <input type="checkbox" id="returningCheck">
                            <div>
                                <label for="returningCheck">Returning Patient?</label><br>
                                <small>Toggle to search existing records instead of re-entering details</small>
                            </div>
                        </div>
                        <div id="returningSearch" class="mb-3">
    <label class="form-label-custom">Search Existing Patient</label>
    <input type="text" id="patientSearchInput" class="form-control-custom" placeholder="Search by name or contact number…">
    
    {{-- Dropdown results --}}
    <div id="searchResults" style="background:#fff; border:1px solid var(--border); border-radius:8px; margin-top:4px; display:none;"></div>
</div>

                        {{-- ── Personal Info ── --}}
                        <span class="form-section-label"><i class="bi bi-person me-1"></i> Personal Information</span>

                        <div class="mb-3">
                            <label class="form-label-custom">Full Patient Name</label>
                            {{-- FIXED: added name="name" --}}
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control-custom {{ $errors->has('name') ? 'input-invalid' : '' }}" placeholder="e.g. Elena Rodriguez" required>
                        </div>

                        <div class="row mb-3 g-2">
                            <div class="col-md-4">
                                <label class="form-label-custom">Date of Birth</label>
                                {{-- FIXED: added name="date_of_birth" --}}
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control-custom {{ $errors->has('date_of_birth') ? 'input-invalid' : '' }}" id="dob" onchange="calcAge()">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label-custom">Age</label>
                                {{-- FIXED: added name="age" --}}
                                <input type="number" name="age" value="{{ old('age') }}" class="form-control-custom {{ $errors->has('age') ? 'input-invalid' : '' }}" id="age" placeholder="—" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Gender</label>
                                {{-- FIXED: added name="gender" --}}
                                <select name="gender" class="form-control-custom {{ $errors->has('gender') ? 'input-invalid' : '' }}" style="appearance: auto;" required>
                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select</option>
                                    <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Civil Status</label>
                                {{-- FIXED: added name="civil_status" --}}
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
                                {{-- FIXED: added name="contact_number" --}}
                                <input type="text" name="contact_number" value="{{ old('contact_number') }}" class="form-control-custom {{ $errors->has('contact_number') ? 'input-invalid' : '' }}" placeholder="+63 (555) 000-0000" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Address</label>
                                {{-- FIXED: added name="address" --}}
                                <input type="text" name="address" value="{{ old('address') }}" class="form-control-custom {{ $errors->has('address') ? 'input-invalid' : '' }}" placeholder="123 Health St, Davao City" required>
                            </div>
                        </div>

                        <div class="row mb-4 g-2">
                            <div class="col-md-4">
                                <label class="form-label-custom">Blood Type</label>
                                {{-- FIXED: added name="blood_type" --}}
                                <select name="blood_type" class="form-control-custom {{ $errors->has('blood_type') ? 'input-invalid' : '' }}" style="appearance: auto;">
                                    <option value="">Select Type</option>
                                    <option value="A+" {{ old('blood_type') === 'A+' ? 'selected' : '' }}>A+</option><option value="A-" {{ old('blood_type') === 'A-' ? 'selected' : '' }}>A-</option><option value="B+" {{ old('blood_type') === 'B+' ? 'selected' : '' }}>B+</option><option value="B-" {{ old('blood_type') === 'B-' ? 'selected' : '' }}>B-</option>
                                    <option value="O+" {{ old('blood_type') === 'O+' ? 'selected' : '' }}>O+</option><option value="O-" {{ old('blood_type') === 'O-' ? 'selected' : '' }}>O-</option><option value="AB+" {{ old('blood_type') === 'AB+' ? 'selected' : '' }}>AB+</option><option value="AB-" {{ old('blood_type') === 'AB-' ? 'selected' : '' }}>AB-</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Height (cm)</label>
                                {{-- FIXED: added name="height" --}}
                                <input type="number" name="height" value="{{ old('height') }}" class="form-control-custom {{ $errors->has('height') ? 'input-invalid' : '' }}" placeholder="170">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Weight (kg)</label>
                                {{-- FIXED: added name="weight" --}}
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
                                {{-- FIXED: added name="philhealth_no" --}}
                                <input type="text" name="philhealth_no" value="{{ old('philhealth_no') }}" class="form-control-custom {{ $errors->has('philhealth_no') ? 'input-invalid' : '' }}" id="philhealth" placeholder="XX-XXXXXXXXX-X">
                            </div>
                            <div class="col-md-6">
                                <div class="na-toggle-row">
                                    <label class="form-label-custom">HMO / Insurance</label>
                                    <button type="button" class="na-btn" onclick="toggleNA(this, 'hmo')">N/A</button>
                                </div>
                                {{-- FIXED: added name="hmo_insurance" --}}
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
                                    {{-- FIXED: added name="emergency_contact_name" --}}
                                    <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" class="form-control-custom {{ $errors->has('emergency_contact_name') ? 'input-invalid' : '' }}" id="emgName" placeholder="Contact Person Name">
                                </div>
                                <div class="col-md-6">
                                    {{-- FIXED: added name="emergency_contact_number" --}}
                                    <input type="text" name="emergency_contact_number" value="{{ old('emergency_contact_number') }}" class="form-control-custom {{ $errors->has('emergency_contact_number') ? 'input-invalid' : '' }}" id="emgContact" placeholder="+63 (555) 000-0000">
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
                            {{-- FIXED: added name="allergies" --}}
                            <input type="text" name="known_allergies" value="{{ old('known_allergies') }}" class="form-control-custom {{ $errors->has('known_allergies') ? 'input-invalid' : '' }}" id="allergies" placeholder="e.g. Penicillin, Shellfish, Dust">
                        </div>

                        <div class="mb-3">
                            <div class="na-toggle-row">
                                <label class="form-label-custom">Existing Conditions</label>
                                <button type="button" class="na-btn" onclick="toggleNA(this, 'conditions')">N/A</button>
                            </div>
                            {{-- FIXED: added name="existing_conditions" --}}
                            <input type="text" name="existing_conditions" value="{{ old('existing_conditions') }}" class="form-control-custom {{ $errors->has('existing_conditions') ? 'input-invalid' : '' }}" id="conditions" placeholder="e.g. Hypertension, Diabetes Type 2">
                        </div>

                        <div class="mb-4">
                            <div class="na-toggle-row">
                                <label class="form-label-custom">Current Medications</label>
                                <button type="button" class="na-btn" onclick="toggleNA(this, 'medications')">N/A</button>
                            </div>
                            {{-- FIXED: added name="current_medications" --}}
                            <input type="text" name="current_medications" value="{{ old('current_medications') }}" class="form-control-custom {{ $errors->has('current_medications') ? 'input-invalid' : '' }}" id="medications" placeholder="e.g. Metformin 500mg, Losartan 50mg">
                        </div>

                        {{-- ── Visit Info ── --}}
                        <span class="form-section-label"><i class="bi bi-clipboard2-pulse me-1"></i> Visit Information</span>

                        <div class="mb-4">
                            <label class="form-label-custom">Primary Symptoms</label>
                            {{-- FIXED: added name="primary_symptoms" --}}
                            <textarea name="primary_symptoms" class="form-control-custom {{ $errors->has('primary_symptoms') ? 'input-invalid' : '' }}" rows="3" placeholder="Describe symptoms…" required>{{ old('primary_symptoms') }}</textarea>
                        </div>

                        <span class="form-section-label"><i class="bi bi-exclamation-octagon me-1"></i> Priority Handling</span>
                        <div class="returning-toggle mb-3" onclick="togglePriority(this)">
                            <input type="checkbox" id="priorityCheck" name="is_priority" value="1" {{ old('is_priority') ? 'checked' : '' }}>
                            <div>
                                <label for="priorityCheck">Mark as Priority Patient?</label><br>
                                <small>Use for seniors, PWD, pregnant, or urgent cases.</small>
                            </div>
                        </div>
                        <div id="priorityFields" class="{{ old('is_priority') ? 'visible' : '' }}" style="display: {{ old('is_priority') ? 'block' : 'none' }};">
                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Priority Type</label>
                                    <select name="priority_type" class="form-control-custom {{ $errors->has('priority_type') ? 'input-invalid' : '' }}" style="appearance:auto;">
                                        <option value="">Select priority type</option>
                                        <option value="senior" {{ old('priority_type') === 'senior' ? 'selected' : '' }}>Senior Citizen</option>
                                        <option value="pwd" {{ old('priority_type') === 'pwd' ? 'selected' : '' }}>PWD</option>
                                        <option value="pregnant" {{ old('priority_type') === 'pregnant' ? 'selected' : '' }}>Pregnant</option>
                                        <option value="urgent" {{ old('priority_type') === 'urgent' ? 'selected' : '' }}>Urgent Case</option>
                                        <option value="other" {{ old('priority_type') === 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Priority Notes</label>
                                    <input type="text" name="priority_notes" value="{{ old('priority_notes') }}" class="form-control-custom" placeholder="Optional note">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-register">
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
            <a href="#" style="color:var(--text-muted); text-decoration:none; font-size:.7rem; margin-left:15px;">Support</a>
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

    /* Returning patient toggle */
    function toggleReturning(wrapper) {
        const cb = wrapper.querySelector('input[type="checkbox"]');
        cb.checked = !cb.checked;
        const search = document.getElementById('returningSearch');
        search.classList.toggle('visible', cb.checked);
    }

    function togglePriority(wrapper) {
        const cb = wrapper.querySelector('input[type="checkbox"]');
        cb.checked = !cb.checked;
        const fields = document.getElementById('priorityFields');
        fields.style.display = cb.checked ? 'block' : 'none';
    }

    /* Live search — attached after DOM is ready */
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('patientSearchInput');
        const results     = document.getElementById('searchResults');
        const returningId = document.getElementById('returning_patient_id');

        if (searchInput && returningId) {
            searchInput.addEventListener('input', function () {
                if (!this.value.trim()) {
                    returningId.value = '';
                }
            });
        }

        searchInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault(); // stop form submission

        const first = document.querySelector('#searchResults div');
        if (first) {
            first.click(); // auto-fill first result
        }
    }
});

        searchInput.addEventListener('input', function () {
            const query = this.value.trim();

            if (query.length < 2) {
                results.style.display = 'none';
                return;
            }

            fetch(`{{ route('patients.search') }}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(patients => {
                    if (patients.length === 0) {
                        results.innerHTML = `<div style="padding:10px 14px; font-size:.8rem; color:var(--text-muted);">No patients found.</div>`;
                    } else {
                        results.innerHTML = patients.map(p => `
                            <div onclick="fillPatient(${JSON.stringify(p).replace(/"/g, '&quot;')})"
                                 style="padding:10px 14px; font-size:.83rem; cursor:pointer; border-bottom:1px solid var(--border);"
                                 onmouseover="this.style.background='var(--accent-soft)'"
                                 onmouseout="this.style.background='#fff'">
                                <strong>${p.name}</strong>
                                <span style="color:var(--text-muted); font-size:.75rem;"> · ${p.contact_number ?? 'No contact'}</span>
                            </div>
                        `).join('');
                    }
                    results.style.display = 'block';
                })
                .catch(err => console.error('Search error:', err));
        });

        /* Hide results when clicking outside */
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !results.contains(e.target)) {
                results.style.display = 'none';
            }
        });
    });

    

    /* Fill all form fields with returning patient data */
    function fillPatient(p) {
        document.getElementById('searchResults').style.display = 'none';
        document.getElementById('patientSearchInput').value = p.name;
        document.getElementById('returning_patient_id').value = p.id ?? '';

        // Personal
        document.querySelector('[name="name"]').value            = p.name ?? '';
        document.querySelector('[name="date_of_birth"]').value   = p.date_of_birth ?? '';
        document.querySelector('[name="age"]').value             = p.age ?? '';
        document.querySelector('[name="gender"]').value          = p.gender ?? '';
        document.querySelector('[name="civil_status"]').value    = p.civil_status ?? '';
        document.querySelector('[name="contact_number"]').value  = p.contact_number ?? '';
        document.querySelector('[name="address"]').value         = p.address ?? '';

        // Vitals
        document.querySelector('[name="blood_type"]').value      = p.blood_type ?? '';
        document.querySelector('[name="height"]').value          = p.height ?? '';
        document.querySelector('[name="weight"]').value          = p.weight ?? '';

        // Administrative
        document.querySelector('[name="philhealth_no"]').value   = p.philhealth_no ?? '';
        document.querySelector('[name="hmo_insurance"]').value   = p.hmo_insurance ?? '';
        document.getElementById('emgName').value                 = p.emergency_contact_name ?? '';
        document.getElementById('emgContact').value              = p.emergency_contact_number ?? '';

        // Medical History
        document.getElementById('allergies').value               = p.known_allergies ?? '';
        document.getElementById('conditions').value              = p.existing_conditions ?? '';
        document.getElementById('medications').value             = p.current_medications ?? '';
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