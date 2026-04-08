<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

.sidebar-footer {
    padding: 6px 0 0;
}

.sidebar-footer .sidebar-link {
    padding: 8px 6px;
    font-size: .82rem;
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

/* Stat Cards */
.stat-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 22px 24px;
}

.stat-label {
    font-size: .72rem;
    font-weight: 600;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 8px;
}

.stat-value {
    font-size: 2.1rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1;
}

.stat-value.green { color: var(--primary); }

/* Panel Cards */
.card-panel {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 22px 24px;
    height: 100%;
}

.panel-title {
    font-size: .9rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.panel-sub {
    font-size: .75rem;
    color: var(--text-muted);
    margin-bottom: 0;
}

.btn-view-queue {
    background: var(--sidebar-bg);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 7px 16px;
    font-size: .78rem;
    font-weight: 600;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: background .18s;
    white-space: nowrap;
}

.btn-view-queue:hover { background: var(--accent); }

.empty-state {
    text-align: center;
    color: var(--text-muted);
    font-size: .8rem;
    padding: 32px 0;
}

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
        <a href="#" class="sidebar-link">
            <i class="bi bi-people"></i> Patient Queue
        </a>
        <a href="#" class="sidebar-link">
            <i class="bi bi-journal-medical"></i> Medical Records
        </a>
    </nav>

    <div class="sidebar-bottom">
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- ═══════════════════ MAIN ═══════════════════ -->
<div class="main-wrap">

    <!-- Topbar -->
    <header class="topbar">
        <div class="topbar-left">
            <h3>Dashboard</h3>
            <p>Welcome back, {{ Auth::user()->name }}!</p>
        </div>
        <div class="topbar-actions">
            <div class="topbar-icon"><i class="bi bi-bell"></i></div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        </div>
    </header>

    <!-- Content -->
    <main class="content">

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Patients Seen Today</div>
                    <div class="stat-value">0</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Avg Consultation Time</div>
                    <div class="stat-value">--</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Remaining in Queue</div>
                    <div class="stat-value green">0</div>
                </div>
            </div>
        </div>

        <!-- Queue & Activity -->
        <div class="row g-3">
            <div class="col-md-8">
                <div class="card-panel">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <div class="panel-title">Active Queue Overview</div>
                            <div class="panel-sub">Live patient queue status</div>
                        </div>
                        <button class="btn-view-queue">View Full Queue</button>
                    </div>
                    <div class="empty-state">
                        <i class="bi bi-people d-block mb-2" style="font-size:1.5rem;"></i>
                        No patients in queue.
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-panel">
                    <div class="panel-title">Activity Log</div>
                    <div class="panel-sub mb-3">Recent actions</div>
                    <div class="empty-state">
                        <i class="bi bi-clock-history d-block mb-2" style="font-size:1.5rem;"></i>
                        No recent activity found.
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="dash-footer">
        <span>© 2024 CuraSure · Doctor Portal</span>
        <div class="footer-links">
            <a href="#">Privacy Protocol</a>
            <a href="#">Support</a>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>