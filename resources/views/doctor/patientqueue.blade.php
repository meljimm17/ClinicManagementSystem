<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
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

/* ── Col 2: Queue List ── */
.queue-col {
    width: 220px;
    min-height: 100vh;
    background: var(--card-bg);
    border-right: 1px solid var(--border);
    position: fixed;
    left: 220px;
    top: 0;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}

.queue-col-header {
    padding: 16px 16px 10px;
    border-bottom: 1px solid var(--border);
    position: sticky; top: 0;
    background: var(--card-bg);
    z-index: 10;
}

.queue-section-label {
    font-size: .6rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.queue-section-label::before {
    content: '';
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #f0a500;
}

.queue-section-label.diagnosing::before { background: var(--primary); }
.queue-section-label.done-label::before { background: #aaa; }

/* Queue patient card */
.queue-card {
    padding: 12px 16px;
    border-bottom: 1px solid var(--border);
    cursor: pointer;
    transition: background .15s;
    position: relative;
}
.queue-card:hover { background: var(--page-bg); }
.queue-card.active-card {
    background: var(--accent-soft);
    border-left: 3px solid var(--primary);
}

.queue-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2px;
}

.queue-card-name { font-size: .82rem; font-weight: 700; color: var(--text-primary); }
.queue-card-time { font-size: .65rem; color: var(--text-muted); }
.queue-card-meta { font-size: .7rem; color: var(--text-muted); }

.active-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: var(--primary);
    color: #fff;
    font-size: .58rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 20px;
    text-transform: uppercase;
    margin-bottom: 4px;
}
.active-badge::before {
    content: '';
    width: 5px; height: 5px;
    background: #7fffd4;
    border-radius: 50%;
    animation: pulse 1.4s infinite;
}
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }

.done-badge {
    display: inline-block;
    background: #eee;
    color: #999;
    font-size: .58rem;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 20px;
    text-transform: uppercase;
}

/* ── Col 3: Main Content ── */
.main-col {
    margin-left: 440px;
    flex: 1;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* Topbar */
.topbar {
    background: rgba(255,255,255,.9);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--border);
    padding: 0 28px;
    height: 54px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky; top: 0; z-index: 50;
}
.topbar-title { font-size: .95rem; font-weight: 700; color: var(--text-primary); }
.topbar-sub { font-size: .72rem; color: var(--text-muted); }
.topbar-actions { display: flex; align-items: center; gap: 10px; }
.topbar-icon {
    width: 34px; height: 34px; border-radius: 8px;
    background: var(--page-bg); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--text-muted); font-size: .9rem; cursor: pointer;
}
.topbar-icon:hover { background: var(--accent-soft); color: var(--accent); }
.avatar {
    width: 34px; height: 34px; border-radius: 9px;
    background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light));
    color: #fff; font-size: .78rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
}

/* ── Diagnosis Panel ── */
.diag-content { padding: 28px 32px 40px; flex: 1; }

.diag-header { margin-bottom: 24px; }
.diag-title {
    font-family: 'DM Serif Display', serif;
    font-size: 1.5rem;
    color: var(--text-primary);
    margin-bottom: 4px;
}
.diag-sub { font-size: .78rem; color: var(--text-muted); }

/* Vitals grid */
.vitals-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 16px;
}

.vital-item label {
    font-size: .62rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--text-muted);
    display: block;
    margin-bottom: 3px;
}

.vital-item .val { font-size: .92rem; font-weight: 700; color: var(--text-primary); }

/* Symptoms box */
.symptoms-box {
    background: #fff8f0;
    border: 1px solid #f0d9a0;
    border-radius: 10px;
    padding: 14px 16px;
    margin-bottom: 22px;
}

.symptoms-box-label {
    font-size: .62rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #b07000;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.symptoms-box p { font-size: .82rem; color: var(--text-primary); margin: 0; line-height: 1.6; }
.symptoms-box-meta { font-size: .68rem; color: var(--text-muted); margin-top: 6px; }

/* Form sections */
.form-section { margin-bottom: 20px; }

.form-section-label {
    font-size: .72rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 8px;
    display: block;
}

.form-field {
    width: 100%;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 12px 16px;
    font-size: .84rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--text-primary);
    background: var(--card-bg);
    outline: none;
    transition: border-color .15s;
    resize: vertical;
}
.form-field:focus { border-color: var(--accent); background: #fff; }
.form-field::placeholder { color: #b0c0b8; }

/* Action bar */
.action-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 32px;
    border-top: 1px solid var(--border);
    background: var(--card-bg);
    position: sticky;
    bottom: 0;
}

.btn-discard {
    display: flex;
    align-items: center;
    gap: 6px;
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: .8rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 8px;
    transition: background .15s;
}
.btn-discard:hover { background: var(--page-bg); color: var(--text-primary); }

.btn-save {
    display: flex;
    align-items: center;
    gap: 7px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 9px;
    padding: 10px 20px;
    font-size: .82rem;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: background .15s;
}
.btn-save:hover { background: var(--accent); }

/* Empty state */
.empty-state {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    padding: 60px 20px;
    text-align: center;
}
.empty-state i { font-size: 3rem; margin-bottom: 14px; opacity: .25; }
.empty-state h4 { font-size: .95rem; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; }
.empty-state p { font-size: .78rem; }

/* Profile Modal */
.profile-modal .modal-content { border-radius: 24px; border: none; overflow: hidden; }
.profile-header { padding: 28px 22px; display: flex; align-items: center; gap: 16px; }
.profile-icon-container {
    width: 70px; height: 70px; border-radius: 16px; background: #f0f4f2;
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; font-family: 'DM Serif Display'; color: var(--sidebar-bg);
}
.profile-tabs { padding: 0 22px; display: flex; gap: 22px; border-bottom: 1px solid var(--border); }
.tab-link { padding: 11px 0; font-size: 0.83rem; font-weight: 600; color: var(--text-muted); cursor: pointer; border-bottom: 2px solid transparent; }
.tab-link.active { color: var(--primary); border-bottom: 2px solid var(--primary); }
.info-item { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 18px; }
.info-item-icon { width: 34px; height: 34px; border-radius: 9px; background: var(--accent-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
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
        <a href="{{ route('doctor.dashboard') }}" class="sidebar-link"><i class="bi bi-grid-1x2"></i> Dashboard</a>
        <a href="{{ route('doctor.queue') }}" class="sidebar-link active"><i class="bi bi-people"></i> Patient Queue</a>
        <a href="#" class="sidebar-link"><i class="bi bi-journal-medical"></i> Medical Records</a>
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

{{-- ── Col 2: Queue List ── --}}
<div class="queue-col">
    <div class="queue-col-header">
        <div style="font-size:.75rem; font-weight:700; color:var(--text-primary); margin-bottom:2px;">Today's Queue</div>
        <div style="font-size:.65rem; color:var(--text-muted);">{{ now()->format('M j, Y') }}</div>
    </div>

    {{-- Waiting / Diagnosing --}}
    @php $waiting = $queue->whereIn('status', ['waiting', 'diagnosing']); @endphp
    @if($waiting->isNotEmpty())
        <div style="padding: 10px 16px 4px;">
            <div class="queue-section-label">Waiting for Diagnosis</div>
        </div>
        @foreach($waiting as $entry)
            <div class="queue-card {{ $entry->status === 'diagnosing' ? 'active-card' : '' }}"
                 id="card-{{ $entry->id }}"
                 onclick="loadPatient({{ $entry->id }})">
                @if($entry->status === 'diagnosing')
                    <div class="active-badge">Active</div>
                @endif
                <div class="queue-card-top">
                    <div class="queue-card-name">{{ $entry->patient->name }}</div>
                    <div class="queue-card-time">{{ $entry->created_at->format('g:i A') }}</div>
                </div>
                <div class="queue-card-meta">
                    Ref: {{ $entry->queue_number }} &bull;
                    Age: {{ $entry->patient->age ?? '—' }}
                </div>
            </div>
        @endforeach
    @endif

    {{-- Done -- hidden from queue, moved to medical records --}}
    @if($queue->isEmpty())
        <div style="padding:40px 16px; text-align:center; color:var(--text-muted); font-size:.78rem;">
            <i class="bi bi-people" style="font-size:1.8rem; display:block; margin-bottom:8px; opacity:.3;"></i>
            No patients today yet.
        </div>
    @endif
</div>

{{-- ── Col 3: Diagnosis Panel ── --}}
<div class="main-col">
    <header class="topbar">
        <div>
            <div class="topbar-title" id="topbar-patient-name">Patient Queue</div>
            <div class="topbar-sub" id="topbar-patient-sub">{{ now()->format('l, F j, Y') }}</div>
        </div>
        <div class="topbar-actions">
            <div class="topbar-icon"><i class="bi bi-printer"></i></div>
            <div class="topbar-icon"><i class="bi bi-clock-history"></i></div>
            <div class="avatar" data-bs-toggle="modal" data-bs-target="#doctorProfileModal">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>
    </header>

    {{-- No patient selected state --}}
    <div class="empty-state" id="empty-state">
        <i class="bi bi-person-lines-fill"></i>
        <h4>No patient selected</h4>
        <p>Click a patient from the queue on the left to begin a consultation.</p>
    </div>

    {{-- Diagnosis Form (hidden until patient selected) --}}
    <div id="diag-panel" style="display:none; flex-direction:column; flex:1;">
        <div class="diag-content">

            {{-- Header --}}
            <div class="diag-header">
                <div class="diag-title" id="diag-patient-name">—</div>
                <div class="diag-sub" id="diag-patient-sub">—</div>
            </div>

            {{-- Vitals --}}
            <div class="vitals-grid">
                <div class="vital-item">
                    <label>Age</label>
                    <div class="val" id="v-age">—</div>
                </div>
                <div class="vital-item">
                    <label>Blood Type</label>
                    <div class="val" id="v-blood">—</div>
                </div>
                <div class="vital-item">
                    <label>ID Number</label>
                    <div class="val" id="v-id">—</div>
                </div>
                <div class="vital-item">
                    <label>Height / Weight</label>
                    <div class="val" id="v-hw">—</div>
                </div>
            </div>

            {{-- Reported Symptoms --}}
            <div class="symptoms-box">
                <div class="symptoms-box-label"><i class="bi bi-exclamation-triangle-fill"></i> Reported Symptoms</div>
                <p id="v-symptoms">—</p>
                <div class="symptoms-box-meta" id="v-submitted-by">Submitted by staff</div>
            </div>

            {{-- Diagnosis & Treatment Form --}}
            <form method="POST" action="{{ route('doctor.record.store') }}" id="diag-form">
                @csrf
                <input type="hidden" name="queue_id" id="f-queue-id">
                <input type="hidden" name="patient_id" id="f-patient-id">
                <input type="hidden" name="doctor_id" value="{{ Auth::user()->doctor->id ?? '' }}">
                <input type="hidden" name="record_status" id="f-record-status" value="completed">
                <input type="hidden" name="consultation_date" value="{{ now()->toDateString() }}">
                <input type="hidden" name="consultation_time" value="{{ now()->format('H:i') }}">

                <div class="form-section">
                    <label class="form-section-label">Clinical Diagnosis</label>
                    <textarea name="diagnosis" class="form-field" rows="3" placeholder="Enter clinical diagnosis..."></textarea>
                </div>

                <div class="form-section">
                    <label class="form-section-label">Prescription / Treatment Plan</label>
                    <textarea name="prescription" class="form-field" rows="4" placeholder="List medications and dosages..."></textarea>
                </div>

                <div class="form-section">
                    <label class="form-section-label">Additional Notes <span style="color:var(--text-muted); font-weight:400;">(Optional)</span></label>
                    <textarea name="notes" class="form-field" rows="3" placeholder="Internal clinical notes, follow-up scheduling, etc."></textarea>
                </div>
            </form>

        </div>

        {{-- Action Bar --}}
        <div class="action-bar">
            <button type="button" class="btn-discard" onclick="clearPanel()">
                <i class="bi bi-trash3"></i> Discard Draft
            </button>
            <button type="button" class="btn-save" onclick="submitRecord('completed')">
                <i class="bi bi-check-circle-fill"></i> Save & Generate Medical Record
            </button>
        </div>
    </div>
</div>

{{-- ── Doctor Profile Modal ── --}}
<div class="modal fade profile-modal" id="doctorProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="profile-header">
                <div class="profile-icon-container">D</div>
                <div>
                    <h4 class="mb-0" style="font-family: 'DM Serif Display';">Dr. {{ Auth::user()->name }}</h4>
                    <p class="text-muted small mb-0">Senior Medical Officer</p>
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
                <div class="row">
                    <div class="col-6">
                        <div class="info-item">
                            <div class="info-item-icon"><i class="bi bi-card-checklist"></i></div>
                            <div>
                                <div class="text-muted small fw-bold text-uppercase">License No.</div>
                                <div class="fw-bold">PRC-7654321</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-item">
                            <div class="info-item-icon"><i class="bi bi-hospital"></i></div>
                            <div>
                                <div class="text-muted small fw-bold text-uppercase">Room</div>
                                <div class="fw-bold">{{ Auth::user()->doctor->assigned_room ?? 'Room —' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn w-100 rounded-pill border text-muted fw-bold mt-2" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Pass queue data to JS --}}
<script>
    const queueData = {
        @foreach($queue as $entry)
        {{ $entry->id }}: {
            id: {{ $entry->id }},
            patient_id: {{ $entry->patient_id }},
            queue_number: "{{ $entry->queue_number }}",
            name: "{{ addslashes($entry->patient->name) }}",
            age: "{{ $entry->patient->age ?? '—' }}",
            gender: "{{ $entry->patient->gender ?? '—' }}",
            blood_type: "{{ $entry->patient->blood_type ?? '—' }}",
            height: "{{ $entry->patient->height ?? '—' }}",
            weight: "{{ $entry->patient->weight ?? '—' }}",
            symptoms: "{{ addslashes($entry->symptoms ?? '—') }}",
            status: "{{ $entry->status }}",
            registered: "{{ $entry->created_at->format('g:i A') }}",
        },
        @endforeach
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Load patient into the right panel + mark as diagnosing via AJAX
    function loadPatient(id) {
        const p = queueData[id];
        if (!p) return;

        // ── Mark as diagnosing via AJAX ──
        fetch(`/doctor/queue/${id}/call`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        });

        // Update topbar
        document.getElementById('topbar-patient-name').textContent = 'Diagnosis & Treatment: ' + p.name;
        document.getElementById('topbar-patient-sub').textContent = 'Documenting visit · ' + p.queue_number;

        // Update diag header
        document.getElementById('diag-patient-name').textContent = 'Diagnosis & Treatment: ' + p.name;
        document.getElementById('diag-patient-sub').textContent = 'Documenting visit for ' + p.queue_number;

        // Update vitals
        document.getElementById('v-age').textContent = p.age + ' Years';
        document.getElementById('v-blood').textContent = p.blood_type;
        document.getElementById('v-id').textContent = p.queue_number;
        document.getElementById('v-hw').textContent = (p.height !== '—' ? p.height + 'cm' : '—') + ' / ' + (p.weight !== '—' ? p.weight + 'kg' : '—');
        document.getElementById('v-symptoms').textContent = p.symptoms;
        document.getElementById('v-submitted-by').textContent = 'Submitted at ' + p.registered;

        // Set hidden form fields
        document.getElementById('f-queue-id').value = p.id;
        document.getElementById('f-patient-id').value = p.patient_id;

        // Show panel
        document.getElementById('empty-state').style.display = 'none';
        document.getElementById('diag-panel').style.display = 'flex';

        // Highlight active card
        document.querySelectorAll('.queue-card').forEach(c => c.classList.remove('active-card'));
        const activeCard = document.getElementById('card-' + id);
        if (activeCard) activeCard.classList.add('active-card');
    }

    // Submit the record form
    function submitRecord(status) {
        document.getElementById('f-record-status').value = status;
        document.getElementById('diag-form').submit();
    }

    // Clear / discard
    function clearPanel() {
        document.getElementById('diag-panel').style.display = 'none';
        document.getElementById('empty-state').style.display = 'flex';
        document.getElementById('diag-form').reset();
        document.getElementById('topbar-patient-name').textContent = 'Patient Queue';
        document.getElementById('topbar-patient-sub').textContent = '{{ now()->format("l, F j, Y") }}';
        document.querySelectorAll('.queue-card').forEach(c => c.classList.remove('active-card'));
    }

    // Auto-open if there's an active diagnosing patient
    @php $active = $queue->firstWhere('status', 'diagnosing'); @endphp
    @if($active)
        window.addEventListener('DOMContentLoaded', () => loadPatient({{ $active->id }}));
    @endif
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>