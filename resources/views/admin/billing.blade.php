<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing - CuraSure Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1b3d2f; --sidebar-hover: #254d3c; --sidebar-active: #2e6048;
            --accent: #3d8b6e; --accent-light: #4fa882; --accent-soft: #e8f5f0;
            --text-primary: #1a2e25; --text-muted: #6b7f77; --border: #e4ece8;
            --card-bg: #ffffff; --page-bg: #f4f7f5; --success: #2e8b5e; --warning: #f59e0b; --danger: #dc2626;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--page-bg); color: var(--text-primary); margin: 0; min-height: 100vh; }
        .sidebar { width: 220px; min-height: 100vh; background: var(--sidebar-bg); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 28px 22px 20px; border-bottom: 1px solid rgba(255,255,255,.08); }
        .brand-name { font-family: 'Segoe UI', serif; font-size: 1.15rem; color: #fff; font-weight: 600; }
        .sidebar-nav { flex: 1; padding: 14px 0; }
        .sidebar-link { display: flex; align-items: center; gap: 11px; padding: 10px 22px; color: rgba(255,255,255,.65); text-decoration: none; font-size: .875rem; font-weight: 400; border-left: 3px solid transparent; transition: all .18s; }
        .sidebar-link:hover { background: var(--sidebar-hover); color: #fff; }
        .sidebar-link.active { background: var(--sidebar-active); color: #fff; border-left-color: var(--accent-light); font-weight: 500; }
        .sidebar-link i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-bottom { padding: 16px 16px 24px; border-top: 1px solid rgba(255,255,255,.08); }
        .main-wrap { margin-left: 220px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: rgba(255,255,255,.85); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); padding: 0 32px; height: 58px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-left h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; }
        .topbar-left p { font-size: .75rem; color: var(--text-muted); margin: 2px 0 0; }
        .content { padding: 28px 32px 40px; flex: 1; }
        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .stat-card { background: var(--card-bg); border: 1px solid var(--border); border-radius: 14px; padding: 20px 22px; }
        .stat-value { font-size: 2rem; font-weight: 700; color: #153126; line-height: 1; }
        .stat-label { font-size: .68rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #2e6048; margin-bottom: 7px; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-paid { background: #d1e7dd; color: #0f5132; }
        .status-unpaid { background: #fff3cd; color: #856404; }
        .status-partial { background: #cff4fc; color: #055160; }
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
        <a href="{{ route('admin.schedule') }}" class="sidebar-link {{ request()->routeIs('admin.schedule') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i><span>Schedule</span>
        </a>
        <a href="{{ route('admin.medical-records') }}" class="sidebar-link {{ request()->routeIs('admin.medical-records') ? 'active' : '' }}">
            <i class="bi bi-journal-medical"></i><span>Medical Records</span>
        </a>
        <a href="{{ route('admin.billing') }}" class="sidebar-link {{ request()->routeIs('admin.billing') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i><span>Billing</span>
        </a>
        <a href="{{ route('admin.checkup-types') }}" class="sidebar-link {{ request()->routeIs('admin.checkup-types') ? 'active' : '' }}">
            <i class="bi bi-tags"></i><span>Check-up Types</span>
        </a>
        <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow"></i><span>Reports</span>
        </a>
        <a href="{{ route('admin.administration') }}" class="sidebar-link {{ request()->routeIs('admin.administration') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i><span>Administration</span>
        </a>
    </nav>
    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-link" style="background:none; border:none; width:100%; text-align:left;">
                <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<div class="main-wrap">
    <header class="topbar">
        <div class="topbar-left">
            <h3>Billing & Payments</h3>
            <p>View and manage all transactions</p>
        </div>
    </header>

    <main class="content">
        @if(session('success'))
            <div class="alert" style="background:#e8f5f0; border:1px solid #c0dfd0; color:#1b7a4e; border-radius:8px; padding:10px 14px; font-size:.82rem; font-weight:600; margin-bottom:16px;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Date Filter -->
        <div class="card-panel mb-4">
            <form method="GET" action="{{ route('admin.billing') }}" class="d-flex align-items-center gap-3">
                <label class="form-label-custom mb-0">Filter by Date:</label>
                <input type="date" name="date" class="form-control-custom" style="width: auto;" value="{{ $date }}">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="stat-card" style="background: linear-gradient(135deg, #d1e7dd, #a8d5b8); border-color: #8fc9a0;">
                    <div class="stat-label">Total Revenue</div>
                    <div class="stat-value" style="color: #0f5132;">₱{{ number_format($totalRevenue, 2) }}</div>
                    <div class="text-muted small">Collected on {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card" style="background: linear-gradient(135deg, #fff3cd, #ffe69c); border-color: #d4a017;">
                    <div class="stat-label">Pending Payments</div>
                    <div class="stat-value" style="color: #856404;">₱{{ number_format($totalPending, 2) }}</div>
                    <div class="text-muted small">Awaiting payment</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-label">Total Transactions</div>
                    <div class="stat-value">{{ $totalPatients }}</div>
                    <div class="text-muted small">Patient visits on {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="card-panel">
            <div class="panel-title mb-3">Transaction History</div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Queue #</th>
                            <th>Patient Name</th>
                            <th>Check-up Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Paid At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->visit->display_queue_number ?? 'N/A' }}</td>
                            <td>{{ $payment->visit->patient_name ?? $payment->visit->patient->name ?? 'N/A' }}</td>
                            <td>{{ $payment->visit->checkupType->name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($payment->amount, 2) }}</td>
                            <td>
                                <span class="status-badge 
                                    @if($payment->status === 'paid') status-paid
                                    @elseif($payment->status === 'unpaid') status-unpaid
                                    @else status-partial @endif">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ $payment->payment_method ? ucfirst($payment->payment_method) : '-' }}</td>
                            <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('h:i A') : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No transactions found for this date.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

</body>
</html>