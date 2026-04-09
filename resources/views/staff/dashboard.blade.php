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

/* Custom Form Styles */
.form-label-custom { font-size: .68rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 5px; display: block; }
.form-control-custom { border: 1px solid var(--border); border-radius: 8px; padding: 9px 14px; font-size: .845rem; font-family: 'DM Sans', sans-serif; color: var(--text-primary); background: var(--page-bg); width: 100%; outline: none; transition: border-color .15s; }
.form-control-custom:focus { border-color: var(--accent); background: #fff; }
.form-control-custom[readonly] { background-color: #f8f9fa; color: #555; }

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
.modal-content-clean { 
    border: none; 
    border-radius: 28px; 
    padding: 25px; 
}

/* Header: Pic and Name */
.modal-header-profile { 
    display: flex; 
    align-items: center; 
    gap: 20px; 
    margin-bottom: 30px; 
}

.profile-pic-large { 
    width: 80px; height: 80px; 
    border-radius: 20px; 
    background: #f2f7f5; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 2rem; 
    font-family: 'DM Serif Display', serif; 
    color: #1b3d2f; 
}

.profile-title-area h2 { 
    font-family: 'DM Serif Display', serif; 
    margin: 0; 
    font-size: 1.6rem; 
    color: #1a202c; 
}

/* Tab Underline */
.modal-tabs { 
    display: flex; 
    gap: 25px; 
    border-bottom: 1px solid #e9ecef; 
    margin-bottom: 25px; 
}

.tab-item { 
    padding-bottom: 10px; 
    font-weight: 700; 
    font-size: 0.85rem; 
    color: #718096; 
}

.tab-item.active { 
    color: #3d8b6e; 
    border-bottom: 3px solid #3d8b6e; 
}

/* Info Grid Layout */
.info-grid { 
    display: grid; 
    grid-template-columns: 1fr 1fr; 
    gap: 25px; 
}

.info-row-full { grid-column: span 2; }

.info-box { 
    display: flex; 
    align-items: flex-start; 
    gap: 15px; 
}

.info-icon { 
    width: 38px; height: 38px; 
    border-radius: 10px; 
    background: #f2f7f5; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    color: #3d8b6e; 
    font-size: 1.1rem; 
}

.info-content label { 
    display: block; 
    font-size: 0.65rem; 
    text-transform: uppercase; 
    font-weight: 800; 
    color: #718096; 
    margin-bottom: 2px; 
}

.info-content span { 
    font-size: 1rem; 
    font-weight: 700; 
    color: #1a202c; 
}

/* Rounded Close Button */
.btn-close-custom { 
    width: 100%; 
    padding: 14px; 
    border-radius: 50px; 
    border: 1px solid #e9ecef; 
    background: white; 
    font-weight: 700; 
    color: #718096; 
    margin-top: 35px; 
}

.dash-footer { text-align: center; font-size: .7rem; color: var(--text-muted); border-top: 1px solid var(--border); padding: 14px 32px; display: flex; justify-content: space-between; }
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
            <div class="topbar-icon"><i class="bi bi-bell"></i></div>
            <div class="avatar" data-bs-toggle="modal" data-bs-target="#staffProfileModal">
    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
</div>
        </div>
    </header>

    <main class="content">
        <div class="row g-4">
            <div class="col-lg-6 col-md-12">
                <div class="card-panel">
                    <div class="panel-title mb-4">Patient Registration</div>
                    <form>
                        <div class="mb-3">
                            <label class="form-label-custom">Full Patient Name</label>
                            <input type="text" class="form-control-custom" placeholder="e.g. Elena Rodriguez" required>
                        </div>
                        <div class="row mb-3 g-2">
                            <div class="col-md-3">
                                <label class="form-label-custom">Age</label>
                                <input type="number" class="form-control-custom" placeholder="24">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Gender</label>
                                <select class="form-control-custom" style="appearance: auto;">
                                    <option selected disabled>Select</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Contact Number</label>
                                <input type="text" class="form-control-custom" placeholder="+63 (555) 000-0000">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label-custom">Address</label>
                            <input type="text" class="form-control-custom" placeholder="123 Health St, Wellness City">
                        </div>
                        <div class="row mb-3 g-2">
                            <div class="col-md-4">
                                <label class="form-label-custom">Blood Type</label>
                                <select class="form-control-custom" style="appearance: auto;">
                                    <option>Select Type</option>
                                    <option>A+</option><option>A-</option><option>O+</option><option>O-</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Height (cm)</label>
                                <input type="number" class="form-control-custom" placeholder="170">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Weight (kg)</label>
                                <input type="number" class="form-control-custom" placeholder="70">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label-custom">Primary Symptoms</label>
                            <textarea class="form-control-custom" rows="4" placeholder="Describe symptoms..."></textarea>
                        </div>
                        <button type="submit" class="btn-register">
                            <i class="bi bi-person-check me-2"></i> Complete Registration
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card-panel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="panel-title mb-0">Recent Entries</div>
                        <span class="badge-live">Live Updates</span>
                    </div>
                    <div class="recent-patients-list mb-3">
                        <div class="patient-entry-item">
                            <div class="d-flex align-items-center gap-3">
                                <div class="entry-avatar">ER</div>
                                <div>
                                    <div class="entry-name">Elena Rodriguez</div>
                                    <div class="entry-meta">Q-001 • 08:30 AM</div>
                                </div>
                            </div>
                            <span class="status-indicator diagnosing">Diagnosing</span>
                        </div>
                        <div class="patient-entry-item">
                            <div class="d-flex align-items-center gap-3">
                                <div class="entry-avatar">MC</div>
                                <div>
                                    <div class="entry-name">Marcus Chen</div>
                                    <div class="entry-meta">Q-002 • 08:45 AM</div>
                                </div>
                            </div>
                            <span class="status-indicator waiting">Waiting</span>
                        </div>
                    </div>
                    <a href="{{ route('staff.queue') }}" style="display:block; text-align:center; font-size:.78rem; color:var(--primary); text-decoration:none; margin:15px 0; font-weight:600;">View all recent registrations →</a>
                    <div class="row g-3">
                        <div class="col-6"><div class="mini-stat-card green-dark"><i class="bi bi-clock-history"></i> Avg Intake Time <div class="h5 mb-0 fw-bold">12m</div></div></div>
                        <div class="col-6"><div class="mini-stat-card green-light"><i class="bi bi-people"></i> Daily Total<div class="h5 mb-0 fw-bold">03</div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="dash-footer">
        <span>© 2024 CuraSure · Staff Portal</span>
        <div class="footer-links"><a href="#" style="color:var(--text-muted); text-decoration:none; font-size:.7rem; margin-left:15px;">Privacy Protocol</a><a href="#" style="color:var(--text-muted); text-decoration:none; font-size:.7rem; margin-left:15px;">Support</a></div>
    </footer>
</div>

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
                    <div class="info-content">
                        <label>Full Name</label>
                        <span>Sarah Staff</span>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-calendar-event"></i></div>
                    <div class="info-content">
                        <label>Age</label>
                        <span>28 Years</span>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-gender-ambiguous"></i></div>
                    <div class="info-content">
                        <label>Gender</label>
                        <span>Female</span>
                    </div>
                </div>

                <div class="info-box info-row-full">
                    <div class="info-icon"><i class="bi bi-geo-alt"></i></div>
                    <div class="info-content">
                        <label>Address</label>
                        <span>123 Medical Ave, Davao City</span>
                    </div>
                </div>

                <hr class="info-row-full" style="opacity: 0.1; margin: 5px 0;">

                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-card-text"></i></div>
                    <div class="info-content">
                        <label>Staff ID Number</label>
                        <span>ID-88291</span>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon"><i class="bi bi-briefcase"></i></div>
                    <div class="info-content">
                        <label>Current Role</label>
                        <span>Front Desk</span>
                    </div>
                </div>
            </div>

            <button type="button" class="btn-close-custom" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>