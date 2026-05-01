<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure - Payments</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-bg: #1b3d2f; --sidebar-hover: #254d3c; --sidebar-active: #2e6048;
            --accent: #3d8b6e; --accent-light: #4fa882; --accent-soft: #e8f5f0;
            --text-primary: #1a2e25; --text-muted: #6b7f77; --border: #e4ece8;
            --card-bg: #ffffff; --page-bg: #f4f7f5;
        }
        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: var(--page-bg); color: var(--text-primary); margin: 0; min-height: 100vh; }
        .sidebar { width: 220px; min-height: 100vh; background: var(--sidebar-bg); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 28px 22px 20px; border-bottom: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; gap: 8px; }
        .brand-logo { width: 40px; height: 40px; background: rgba(255,255,255,.1); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.1rem; color: #fff; line-height: 1.2; }
        .sidebar-nav { flex: 1; padding: 14px 0; }
        .sidebar-link { display: flex; align-items: center; gap: 11px; padding: 10px 22px; color: rgba(255,255,255,.65); text-decoration: none; font-size: .875rem; font-weight: 400; border-left: 3px solid transparent; transition: all .18s ease; }
        .sidebar-link:hover { background: var(--sidebar-hover); color: #fff; }
        .sidebar-link.active { background: var(--sidebar-active); color: #fff; border-left-color: var(--accent-light); font-weight: 500; }
        .sidebar-link i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-bottom { padding: 16px 16px 24px; border-top: 1px solid rgba(255,255,255,.08); }
        .btn-logout { display: flex; align-items: center; gap: 10px; width: 100%; background: none; border: none; padding: 8px 6px; color: rgba(255,255,255,.65); font-size: .82rem; font-family: 'DM Sans', sans-serif; cursor: pointer; border-left: 3px solid transparent; transition: all .18s; }
        .main-wrap { margin-left: 220px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: rgba(255,255,255,.85); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); padding: 0 32px; height: 58px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-left h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; }
        .topbar-left p { font-size: .75rem; color: var(--text-muted); margin: 2px 0 0; }
        .content { padding: 28px 32px 40px; flex: 1; }
        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .status-paid { background: #d1e7dd; color: #0f5132; }
        .status-unpaid { background: #fff3cd; color: #856404; }
        .status-partial { background: #cff4fc; color: #055160; }
        .btn-pay { background: var(--sidebar-bg); color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-size: .75rem; font-weight: 600; cursor: pointer; }
        .btn-pay:hover { background: var(--accent); }
        .btn-print { background: none; border: 1px solid var(--border); border-radius: 6px; padding: 6px 10px; font-size: .75rem; color: var(--text-muted); cursor: pointer; }
        .btn-print:hover { background: var(--accent-soft); color: var(--text-primary); }
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
            <h3>Billing & Payments</h3>
            <p>Manage patient payments and generate receipts</p>
        </div>
    </header>

    <main class="content">
        @if(session('success'))
            <div class="alert" style="background:#e8f5f0; border:1px solid #c0dfd0; color:#1b7a4e; border-radius:8px; padding:10px 14px; font-size:.82rem; font-weight:600; margin-bottom:16px;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card-panel">
            <div class="panel-title mb-3">Today's Transactions</div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Queue #</th>
                            <th>Patient Name</th>
                            <th>Check-up Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
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
                            <td>
                                @if($payment->status === 'unpaid')
                                <button class="btn-pay" data-bs-toggle="modal" data-bs-target="#payModal{{ $payment->id }}">
                                    <i class="bi bi-cash me-1"></i> Pay
                                </button>
                                @else
                                <a href="{{ route('staff.payments.receipt', $payment->id) }}" target="_blank" class="btn-print">
                                    <i class="bi bi-printer"></i> Receipt
                                </a>
                                @endif
                            </td>
                        </tr>

                        <!-- Payment Modal -->
                        <div class="modal fade" id="payModal{{ $payment->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Process Payment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('staff.payments.paid', $payment->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label-custom">Patient</label>
                                                <div class="form-control-custom" style="background: #fff;">{{ $payment->visit->patient_name ?? $payment->visit->patient->name ?? 'N/A' }}</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label-custom">Check-up Type</label>
                                                <div class="form-control-custom" style="background: #fff;">{{ $payment->visit->checkupType->name ?? 'N/A' }}</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label-custom">Amount</label>
                                                <div class="form-control-custom" style="background: #fff; font-size: 1.2rem; font-weight: 700;">₱{{ number_format($payment->amount, 2) }}</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label-custom">Payment Method</label>
                                                <select name="payment_method" class="form-control-custom" style="appearance: auto;">
                                                    <option value="cash">Cash</option>
                                                    <option value="gcash">GCash</option>
                                                    <option value="card">Card</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn-pay">Confirm Payment</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No payments found for today.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>