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

.brand-logo i {
    color: #4fce9e;
    font-size: 1.2rem;
}

.brand-name {
    font-family: 'DM Serif Display', serif;
    font-size: 1.1rem;
    color: #fff;
    line-height: 1.2;
    letter-spacing: .01em;
}

.sidebar-nav {
    flex: 1;
    padding: 14px 0;
}

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

.sidebar-link:hover {
    background: var(--sidebar-hover);
    color: #fff;
}

.sidebar-link.active {
    background: var(--sidebar-active);
    color: #fff;
    border-left-color: var(--accent-light);
    font-weight: 500;
}

.sidebar-link i {
    font-size: 1rem;
    width: 18px;
    text-align: center;
}

.sidebar-bottom {
    padding: 16px 16px 24px;
    border-top: 1px solid rgba(255,255,255,.08);
}

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

.btn-logout:hover {
    background: var(--sidebar-hover);
    color: #fff;
}

.btn-logout i {
    font-size: 1rem;
    width: 18px;
    text-align: center;
}

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

.topbar-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

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
}

/* Content */
.content {
    padding: 28px 32px 40px;
    flex: 1;
}

/* Panel Cards */
.card-panel {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 22px 24px;
}

.panel-title {
    font-size: .9rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
}

/* Form styles */
.form-label-custom {
    font-size: .68rem;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 5px;
    display: block;
}

.form-control-custom {
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 9px 14px;
    font-size: .845rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--text-primary);
    background: var(--page-bg);
    width: 100%;
    outline: none;
    transition: border-color .15s;
}

.form-control-custom:focus {
    border-color: var(--accent);
    background: #fff;
}

.form-select-custom {
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 9px 14px;
    font-size: .845rem;
    font-family: 'DM Sans', sans-serif;
    color: var(--text-primary);
    background: var(--page-bg);
    width: 100%;
    outline: none;
    transition: border-color .15s;
    appearance: auto;
}

.form-select-custom:focus {
    border-color: var(--accent);
    background: #fff;
}

.btn-register {
    width: 100%;
    background: var(--sidebar-bg);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 11px 0;
    font-size: .85rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: background .18s;
}

.btn-register:hover { background: var(--accent); }

/* Recent entries */
.badge-live {
    background: var(--accent-soft);
    color: #1b7a4e;
    border: 1px solid #c0dfd0;
    font-size: .65rem;
    font-weight: 600;
    letter-spacing: .08em;
    text-transform: uppercase;
    padding: 3px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.badge-live::before {
    content: '';
    width: 6px; height: 6px;
    background: #1b7a4e;
    border-radius: 50%;
    animation: pulse 1.6s ease infinite;
}

@keyframes pulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50% { opacity: .5; transform: scale(1.3); }
}

.empty-state {
    text-align: center;
    color: var(--text-muted);
    font-size: .8rem;
    padding: 28px 0;
}

.view-all-link {
    display: block;
    text-align: center;
    font-size: .78rem;
    color: var(--primary);
    font-weight: 600;
    text-decoration: none;
    margin: 8px 0 16px;
}

.view-all-link:hover { color: var(--accent); }

.mini-stat-card {
    border-radius: 10px;
    padding: 14px 16px;
}

.mini-stat-card.green-dark {
    background: var(--sidebar-bg);
    color: #fff;
}

.mini-stat-card.green-light {
    background: #d1e7dd;
}

.mini-stat-card i {
    font-size: 1.1rem;
    display: block;
    margin-bottom: 6px;
}

.mini-stat-card.green-dark i { color: #4fce9e; }
.mini-stat-card.green-light i { color: var(--primary); }

.mini-stat-label {
    font-size: .62rem;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.mini-stat-card.green-dark .mini-stat-label { color: rgba(255,255,255,.6); }
.mini-stat-card.green-light .mini-stat-label { color: var(--primary); }

/* Footer */
.dash-footer {
    text-align: center;
    font-size: .7rem;
    color: var(--text-muted);
    border-top: 1px solid var(--border);
    padding: 14px 32px;
    display: flex;
    justify-content: space-between;
}

.footer-links a {
    color: var(--text-muted);
    text-decoration: none;
    margin-left: 18px;
    font-size: .7rem;
}

.footer-links a:hover { color: var(--accent); }
</style>
</head>
<body>

<!-- ═══════════════════ SIDEBAR ═══════════════════ -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo">
           
        </div>
        <div class="brand-name">CuraSure</div>
    </div>

    <nav class="sidebar-nav">
        <a href="#" class="sidebar-link active">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        <a href="{{ route('staff.queue') }}" class="sidebar-link">
    <i class="bi bi-people"></i> Patient Queue
</a>
    </nav>

    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </div>
</aside>

<!-- ═══════════════════ MAIN ═══════════════════ -->
<div class="main-wrap">

    <!-- Topbar -->
    <header class="topbar">
        <div class="topbar-left">
            <h3>Dashboard</h3>
            <p>Welcome back, {{ Auth::user()->name }}</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-icon"><i class="bi bi-bell"></i></div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <!-- Content -->
    <main class="content">
        <div class="row g-4">

            <!-- Patient Registration -->
            <div class="col-lg-6 col-md-12">
                <div class="card-panel">
                    <div class="panel-title mb-4">Patient Registration</div>
                    <form>
                        <div class="mb-3">
                            <label class="form-label-custom">Full Patient Name</label>
                            <input type="text" name="name" class="form-control-custom" placeholder="e.g. Elena Rodriguez" required>
                        </div>

                        <div class="row mb-3 g-2">
                            <div class="col-md-3">
                                <label class="form-label-custom">Age</label>
                                <input type="number" name="age" class="form-control-custom" placeholder="24">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label-custom">Gender</label>
                                <select name="gender" class="form-select-custom">
                                    <option selected disabled>Select</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Contact Number</label>
                                <input type="text" name="phone" class="form-control-custom" placeholder="+63 (555) 000-0000">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Address</label>
                            <input type="text" name="address" class="form-control-custom" placeholder="123 Health St, Wellness City">
                        </div>

                        <div class="row mb-3 g-2">
                            <div class="col-md-4">
                                <label class="form-label-custom">Blood Type</label>
                                <select name="blood_type" class="form-select-custom">
                                    <option selected>Select Type</option>
                                    <option>A+</option><option>A-</option>
                                    <option>B+</option><option>B-</option>
                                    <option>O+</option><option>O-</option>
                                    <option>AB+</option><option>AB-</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Height (cm)</label>
                                <input type="number" name="height" class="form-control-custom" placeholder="170">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label-custom">Weight (kg)</label>
                                <input type="number" name="weight" class="form-control-custom" placeholder="70">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-custom">Primary Symptoms</label>
                            <textarea name="symptoms" class="form-control-custom" rows="4" placeholder="Describe the acute reason for visit..."></textarea>
                        </div>

                        <button type="submit" class="btn-register">
                            <i class="bi bi-person-check me-2"></i> Complete Registration
                        </button>

                        <p class="text-center mt-3" style="font-size:.75rem; color:var(--text-muted);">
                            System will generate a unique ID and add patient to the active queue.
                        </p>
                    </form>
                </div>
            </div>

            <!-- Recent Entries -->
            <div class="col-lg-6 col-md-12">
                <div class="card-panel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="panel-title mb-0">Recent Entries</div>
                        <span class="badge-live">Live Updates</span>
                    </div>

                    <div class="empty-state">
                        <i class="bi bi-inbox d-block mb-2" style="font-size:1.5rem;"></i>
                        No live update entries available yet.
                    </div>

                    <a href="#" class="view-all-link">view all recent registrations →</a>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="mini-stat-card green-dark">
                                <i class="bi bi-clock-history"></i>
                                <div class="mini-stat-label">Avg Intake Time</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mini-stat-card green-light">
                                <i class="bi bi-people"></i>
                                <div class="mini-stat-label">Daily Total</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="dash-footer">
        <span>© 2024 CuraSure · Staff Portal</span>
        <div class="footer-links">
            <a href="#">Privacy Protocol</a>
            <a href="#">Support</a>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>