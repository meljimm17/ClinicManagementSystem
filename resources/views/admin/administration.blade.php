<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CuraSure - Administration</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
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
        .brand-name { font-family: 'DM Serif Display', serif; font-size: 1.15rem; color: #fff; }
        .sidebar-nav { flex: 1; padding: 14px 0; }
        .sidebar-link { display: flex; align-items: center; gap: 11px; padding: 10px 22px; color: rgba(255,255,255,.65); text-decoration: none; font-size: .875rem; font-weight: 400; border-left: 3px solid transparent; transition: all .18s; }
        .sidebar-link:hover { background: var(--sidebar-hover); color: #fff; }
        .sidebar-link.active { background: var(--sidebar-active); color: #fff; border-left-color: var(--accent-light); font-weight: 500; }
        .sidebar-link i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-bottom { padding: 16px 16px 24px; border-top: 1px solid rgba(255,255,255,.08); }
        .btn-new-appt { width: 100%; background: var(--accent-light); color: #fff; border: none; border-radius: 8px; padding: 10px 0; font-size: .82rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: background .18s; }
        .btn-new-appt:hover { background: var(--accent); }
        .btn-logout { display: flex; align-items: center; gap: 10px; width: 100%; background: none; border: none; padding: 8px 6px; color: rgba(255,255,255,.65); font-size: .82rem; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: all .18s; text-align: left; }
        .btn-logout:hover { background: var(--sidebar-hover); color: #fff; }
        .btn-logout i { font-size: 1rem; width: 18px; text-align: center; }
        .sidebar-footer { padding: 10px 0 4px; }
        .main-wrap { margin-left: 220px; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar { background: rgba(255,255,255,.85); backdrop-filter: blur(10px); border-bottom: 1px solid var(--border); padding: 0 32px; height: 58px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-left h3 { font-size: 1rem; font-weight: 700; color: var(--text-primary); margin: 0; }
        .topbar-left p { font-size: .75rem; color: var(--text-muted); margin: 2px 0 0; }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .topbar-icon { width: 36px; height: 36px; border-radius: 8px; background: var(--page-bg); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: .95rem; cursor: pointer; transition: background .15s; }
        .topbar-icon:hover { background: var(--accent-soft); color: var(--accent); }
        .avatar { width: 36px; height: 36px; border-radius: 10px; background: linear-gradient(135deg, var(--sidebar-bg), var(--accent-light)); color: #fff; font-size: .8rem; font-weight: 700; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .content { padding: 28px 32px 40px; flex: 1; }
        .section-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 22px; }
        .section-title { font-size: 1.35rem; font-weight: 700; }
        .section-sub { font-size: .8rem; color: var(--text-muted); margin-top: 3px; }

        /* Card panel */
        .card-panel { background: var(--card-bg); border: 1px solid var(--border); border-radius: 12px; padding: 22px 24px; }
        .panel-title { font-size: .9rem; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
        .panel-sub { font-size: .75rem; color: var(--text-muted); }

        /* User table */
        .user-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .user-table thead th { font-size: .68rem; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--text-muted); padding: 0 0 10px; border-bottom: 1px solid var(--border); }
        .user-table tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
        .user-table tbody tr:last-child { border-bottom: none; }
        .user-table tbody tr:hover { background: var(--accent-soft); }
        .user-table td { padding: 13px 0; font-size: .845rem; color: var(--text-primary); }
        .user-name { font-weight: 600; }
        .user-role { color: var(--text-muted); font-size: .8rem; }

        .status-badge { display: inline-flex; align-items: center; gap: 5px; font-size: .7rem; font-weight: 600; letter-spacing: .07em; text-transform: uppercase; padding: 3px 10px; border-radius: 20px; }
        .status-active { background: #e5f7ef; color: #1e7a4c; }
        .status-active::before { content: ''; width: 6px; height: 6px; background: #1e7a4c; border-radius: 50%; }
        .status-disabled { background: #f2f2f2; color: #888; }
        .status-disabled::before { content: ''; width: 6px; height: 6px; background: #aaa; border-radius: 50%; }

        .action-btn { background: none; border: 1px solid var(--border); border-radius: 6px; padding: 4px 12px; font-size: .75rem; color: var(--text-muted); cursor: pointer; transition: all .15s; display: inline-flex; align-items: center; justify-content: center; }
        .btn-edit { background-color: var(--accent); border-color: var(--accent); color: white; }
        .btn-edit:hover { filter: brightness(1.1); }
        .btn-delete { background-color: #fff0f0; border-color: #f5b8b8; color: #c0392b; }
        .btn-delete:hover { background-color: #f8d7da; }

        /* Settings */
        .settings-field label { font-size: .72rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px; display: block; }
        .settings-field input, .settings-field select { border: 1px solid var(--border); border-radius: 8px; padding: 9px 14px; font-size: .845rem; font-family: 'DM Sans', sans-serif; color: var(--text-primary); background: var(--page-bg); width: 100%; outline: none; transition: border-color .15s; }
        .settings-field input:focus, .settings-field select:focus { border-color: var(--accent); background: #fff; }
        .btn-save { background: var(--sidebar-bg); color: #fff; border: none; border-radius: 8px; padding: 9px 22px; font-size: .83rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; transition: background .18s; }
        .btn-save:hover { background: var(--accent); }
        .btn-reset { background: none; border: 1px solid var(--border); border-radius: 8px; padding: 9px 22px; font-size: .83rem; font-weight: 500; font-family: 'DM Sans', sans-serif; color: var(--text-muted); cursor: pointer; margin-left: 10px; transition: all .15s; }
        .btn-reset:hover { border-color: var(--accent); color: var(--accent); }
        .btn-add-user { background: var(--sidebar-bg); color: #fff; border: none; border-radius: 8px; padding: 8px 18px; font-size: .8rem; font-weight: 600; font-family: 'DM Sans', sans-serif; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: background .18s; }
        .btn-add-user:hover { background: var(--accent); }

        .dash-footer { font-size: .7rem; color: var(--text-muted); border-top: 1px solid var(--border); padding: 14px 32px; display: flex; justify-content: space-between; }
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
        .btn-ghost { background: none; border: 1px solid var(--border); border-radius: 8px; padding: 9px 18px; font-size: .845rem; font-family: 'DM Sans', sans-serif; color: var(--text-muted); cursor: pointer; transition: all .15s; }
        .btn-ghost:hover { background: var(--page-bg); }
        @media (prefers-reduced-motion: no-preference) {
            @keyframes pageFadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes softRise { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
            body { animation: pageFadeIn .35s ease-out; }
            .stat-chip, .card-panel, .settings-card, .modal-content { animation: softRise .35s ease-out both; }
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

<!-- ═══════════════════ SIDEBAR ═══════════════════ -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('img/logo.png') }}" alt="CuraSure" style="width:64px; height:64px; object-fit:contain; border-radius:8px;">
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
        <button class="btn-new-appt" data-bs-toggle="modal" data-bs-target="#addPatientModal"><i class="bi bi-plus-lg me-1"></i> Add Patient</button>
        <div class="sidebar-footer mt-3">
            <a href="{{ route('support') }}" class="sidebar-link" style="padding:8px 6px;"><i class="bi bi-question-circle"></i> Support</a>
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
            <h3>Administration</h3>
            <p>User management and system configuration</p>
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
                <div class="section-title">System Administration</div>
                <div class="section-sub">Manage staff accounts, roles, and global settings.</div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius:10px;font-size:.845rem;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="border-radius:10px;font-size:.845rem;">
            <strong>Unable to save user.</strong>
            <ul class="mb-0 mt-2 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- ── User Management ── -->
        <div class="card-panel mb-4">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="panel-title">User Management</div>
                    <div class="panel-sub">Staff credentials and access level control</div>
                </div>
                <button class="btn-add-user" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-person-plus-fill"></i> Add User
                </button>
            </div>
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users ?? [] as $user)
                    <tr>
                        <td>
                            <div class="user-name">{{ $user->name }}</div>
                            <div class="user-role">{{ ucfirst($user->role) }}</div>
                        </td>
                        <td><span class="status-badge status-active">{{ ucfirst($user->role) }}</span></td>
                        <td style="color:var(--text-muted);font-size:.8rem;">{{ $user->username }}</td>
                        <td style="color:var(--text-muted);font-size:.8rem;">{{ $user->email ?? '—' }}</td>
                        <td style="color:var(--text-muted);font-size:.8rem;">{{ $user->contact_number ?? '—' }}</td>
                        <td style="color:var(--text-muted);font-size:.8rem;">{{ $user->address ?? '—' }}</td>
                        <td>
                            <span class="status-badge status-active">Active</span>
                        </td>
                        <td>
                            <button class="action-btn btn-edit"
                                onclick="openEditModal(
                                    {{ $user->id }},
                                    '{{ addslashes($user->name) }}',
                                    '{{ addslashes($user->username) }}',
                                    '{{ addslashes($user->email ?? '') }}',
                                    '{{ addslashes($user->contact_number ?? '') }}',
                                    '{{ addslashes($user->address ?? '') }}',
                                    '{{ addslashes($user->doctor->specialization ?? '') }}',
                                    '{{ addslashes($user->doctor->license_number ?? '') }}',
                                    '{{ addslashes($user->doctor->assigned_room ?? '') }}',
                                    '{{ $user->role }}'
                                )">
                                Edit
                            </button>
                            <form action="{{ route('admin.administration.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn btn-delete ms-1"
                                    onclick="return confirm('Remove {{ $user->name }}?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    {{-- Static fallback rows when no DB data --}}
                    <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:24px 0;">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ── System Settings ── -->
        <div class="card-panel">
            <div class="mb-4">
                <div class="panel-title">System Settings</div>
                <div class="panel-sub">Global configuration for clinic identity and workflow numbering.</div>
            </div>
            <form action="{{ route('admin.administration.settings.save') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <div class="settings-field">
                            <label>Clinic Display Name</label>
                            <input type="text" name="clinic_name" value="{{ old('clinic_name', $clinicName) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="settings-field">
                            <label>Queue Format ID</label>
                            <input type="text" name="queue_format" value="{{ old('queue_format', $queueFormat) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="settings-field">
                            <label>Default Role for New Users</label>
                            <select name="default_role">
                                <option value="staff" {{ old('default_role', $defaultRole) === 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="doctor" {{ old('default_role', $defaultRole) === 'doctor' ? 'selected' : '' }}>Doctor</option>
                                <option value="admin" {{ old('default_role', $defaultRole) === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn-save">Save</button>
                        <button type="button" class="btn-reset">Reset</button>
                    </div>
                </div>
            </form>
        </div>

    </main>

    <footer class="dash-footer">
        <span>© 2024 CuraSure · Central Management</span>
        <div class="footer-links"><a href="#">Privacy Protocol</a><a href="#">Audit Log</a></div>
    </footer>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Add New User</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.administration.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-sm">Full Name</label>
                            <input type="text" name="name" class="form-ctrl" placeholder="e.g. Dr. Juan dela Cruz" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label-sm">Username</label>
                            <input type="text" name="username" class="form-ctrl" placeholder="e.g. juandelacruz" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label-sm">Email</label>
                            <input type="email" name="email" class="form-ctrl" placeholder="e.g. juan@curasure.ph" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Contact Number</label>
                            <input type="text" name="contact_number" class="form-ctrl" placeholder="e.g. 09123456789" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Address</label>
                            <input type="text" name="address" class="form-ctrl" placeholder="e.g. Davao City" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Role</label>
                            <select name="role" id="addRole" class="form-ctrl" required onchange="toggleDoctorFields('add')">
                                <option value="">— Select Role —</option>
                                <option value="admin" {{ old('role', $defaultRole) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="doctor" {{ old('role', $defaultRole) === 'doctor' ? 'selected' : '' }}>Doctor</option>
                                <option value="staff" {{ old('role', $defaultRole) === 'staff' ? 'selected' : '' }}>Staff</option>
                            </select>
                        </div>
                        <div class="col-md-6 add-doctor-fields" style="display:none;">
                            <label class="form-label-sm">License Number</label>
                            <input type="text" name="license_number" id="addLicenseNumber" class="form-ctrl" placeholder="e.g. LIC-2026-001">
                        </div>
                        <div class="col-md-6 add-doctor-fields" style="display:none;">
                            <label class="form-label-sm">Specialization</label>
                            <input type="text" name="specialization" id="addSpecialization" class="form-ctrl" placeholder="e.g. General Medicine">
                        </div>
                        <div class="col-md-6 add-doctor-fields" style="display:none;">
                            <label class="form-label-sm">Assigned Room</label>
                            <input type="text" name="assigned_room" id="addAssignedRoom" class="form-ctrl" placeholder="e.g. Room 1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Password</label>
                            <input type="password" name="password" class="form-ctrl" placeholder="Min. 8 characters" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label-sm">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-ctrl" placeholder="Repeat password" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-ghost" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-save">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Edit User</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editUserForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label-sm">Full Name</label>
                            <input type="text" name="name" id="editName" class="form-ctrl" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label-sm">Username</label>
                            <input type="text" name="username" id="editUsername" class="form-ctrl" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label-sm">Email</label>
                            <input type="email" name="email" id="editEmail" class="form-ctrl" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Contact Number</label>
                            <input type="text" name="contact_number" id="editContactNumber" class="form-ctrl" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Address</label>
                            <input type="text" name="address" id="editAddress" class="form-ctrl" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-sm">Role</label>
                            <select name="role" id="editRole" class="form-ctrl" required onchange="toggleDoctorFields('edit')">
                                <option value="admin">Admin</option>
                                <option value="doctor">Doctor</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div class="col-md-6 edit-doctor-fields" style="display:none;">
                            <label class="form-label-sm">License Number</label>
                            <input type="text" name="license_number" id="editLicenseNumber" class="form-ctrl">
                        </div>
                        <div class="col-md-6 edit-doctor-fields" style="display:none;">
                            <label class="form-label-sm">Specialization</label>
                            <input type="text" name="specialization" id="editSpecialization" class="form-ctrl">
                        </div>
                        <div class="col-md-6 edit-doctor-fields" style="display:none;">
                            <label class="form-label-sm">Assigned Room</label>
                            <input type="text" name="assigned_room" id="editAssignedRoom" class="form-ctrl">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-ghost" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin.partials.add-patient-modal')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleDoctorFields(prefix) {
    const roleEl = document.getElementById(prefix + 'Role');
    const isDoctor = roleEl && roleEl.value === 'doctor';
    const fieldClass = '.' + prefix + '-doctor-fields';
    const fields = document.querySelectorAll(fieldClass);

    fields.forEach((field) => {
        field.style.display = isDoctor ? '' : 'none';
        field.querySelectorAll('input').forEach((input) => {
            input.required = isDoctor;
            if (!isDoctor) input.value = '';
        });
    });
}

function openEditModal(id, name, username, email, contactNumber, address, specialization, licenseNumber, assignedRoom, role) {
    document.getElementById('editName').value = name;
    document.getElementById('editUsername').value = username;
    document.getElementById('editEmail').value = email;
    document.getElementById('editContactNumber').value = contactNumber;
    document.getElementById('editAddress').value = address;
    document.getElementById('editSpecialization').value = specialization;
    document.getElementById('editLicenseNumber').value = licenseNumber;
    document.getElementById('editAssignedRoom').value = assignedRoom;
    document.getElementById('editRole').value = role;
    toggleDoctorFields('edit');
    document.getElementById('editUserForm').action = '/admin/administration/users/' + id;
    new bootstrap.Modal(document.getElementById('editUserModal')).show();
}

document.addEventListener('DOMContentLoaded', function () {
    toggleDoctorFields('add');

    @if($errors->any())
        const addModalEl = document.getElementById('addUserModal');
        if (addModalEl) {
            new bootstrap.Modal(addModalEl).show();
        }
    @endif
});
</script>
</body>
</html>