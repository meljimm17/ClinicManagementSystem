<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — The Clinical Sanctuary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #f5f7f5; }
        .left-panel {
            background: linear-gradient(145deg, #1a3d2e 0%, #1e5c3a 55%, #2d7a50 100%);
            min-height: 100vh; position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse 60% 50% at 80% 15%, rgba(58,173,110,.18) 0%, transparent 70%),
                        radial-gradient(ellipse 50% 55% at 5% 85%, rgba(15,36,25,.45) 0%, transparent 65%);
            pointer-events: none;
        }
        .deco-ring { position: absolute; border-radius: 50%; border: 1px solid rgba(255,255,255,.07); pointer-events: none; }
        .ring-1 { width:420px;height:420px;top:-110px;right:-160px; }
        .ring-2 { width:260px;height:260px;bottom:50px;right:-90px; }
        .ring-3 { width:130px;height:130px;bottom:-35px;left:45px;border-color:rgba(255,255,255,.04); }
        .brand-box {
            width:38px;height:38px;background:rgba(255,255,255,.12);
            border:1.5px solid rgba(255,255,255,.25);border-radius:9px;
            display:flex;align-items:center;justify-content:center;
        }
        .headline { font-family:'DM Serif Display',serif;font-size:clamp(1.9rem,2.8vw,2.7rem);line-height:1.18;color:#fff;letter-spacing:-.01em; }
        .subtext { color:rgba(255,255,255,.62);font-size:.875rem;line-height:1.7; }
        .security-badge { background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);backdrop-filter:blur(10px);border-radius:11px; }
        .badge-icon-wrap { width:34px;height:34px;background:rgba(58,173,110,.3);border-radius:7px;display:flex;align-items:center;justify-content:center; }
        .right-panel { min-height:100vh;background:#fff;display:flex;align-items:center;justify-content:center; }
        .form-card { width:100%;max-width:390px; }
        .form-title { font-family:'DM Serif Display',serif;font-size:1.7rem;color:#0f2419;letter-spacing:-.01em; }
        .form-subtitle { font-size:.82rem;color:#6b7c74; }
        .form-label { font-size:.775rem;font-weight:600;color:#0f2419;letter-spacing:.01em; }
        .input-group-text { background:#f8faf9;border-color:#d8e4dd;color:#6b7c74; }
        .form-control { background:#f8faf9;border-color:#d8e4dd;font-size:.875rem;font-family:'DM Sans',sans-serif;color:#0f2419; }
        .form-control::placeholder { color:#a8b9b0; }
        .form-control:focus { background:#fff;border-color:#3aad6e;box-shadow:0 0 0 .2rem rgba(58,173,110,.15); }
        .form-control.is-invalid { border-color:#c0392b; }
        .pwd-toggle { background:#f8faf9;border-color:#d8e4dd;border-left:none;color:#6b7c74;cursor:pointer;transition:color .15s; }
        .pwd-toggle:hover { color:#1e5c3a;background:#f8faf9; }
        .form-check-input:checked { background-color:#3aad6e;border-color:#3aad6e; }
        .form-check-label { font-size:.8rem;color:#6b7c74; }
        .btn-login {
            background:linear-gradient(135deg,#1e5c3a 0%,#2d7a50 100%);border:none;color:#fff;
            font-weight:600;font-size:.875rem;letter-spacing:.02em;font-family:'DM Sans',sans-serif;
            transition:transform .15s,box-shadow .2s;box-shadow:0 4px 14px rgba(30,92,58,.25);
        }
        .btn-login:hover { transform:translateY(-1px);box-shadow:0 6px 20px rgba(30,92,58,.32);color:#fff;background:linear-gradient(135deg,#1a3d2e 0%,#1e5c3a 100%); }
        .btn-login:active { transform:translateY(0); }
        .btn-login:disabled { opacity:.7;transform:none; }
        .btn-access { border:1.5px solid #d8e4dd;color:#1e5c3a;font-weight:600;font-size:.875rem;font-family:'DM Sans',sans-serif;background:transparent;transition:border-color .2s,background .2s; }
        .btn-access:hover { border-color:#3aad6e;background:rgba(58,173,110,.04);color:#1e5c3a; }
        .divider-line { border-top:1px solid #d8e4dd; }
        .divider-text { font-size:.75rem;color:#6b7c74;background:#fff;padding:0 .8rem; }
        .footer-link { font-size:.72rem;color:#6b7c74;text-decoration:none;transition:color .15s; }
        .footer-link:hover { color:#1e5c3a; }
        .footer-copy { font-size:.68rem;color:#b0c0b8; }
        .forgot-link { font-size:.75rem;color:#2d7a50;text-decoration:none;font-weight:500; }
        .forgot-link:hover { color:#1a3d2e; }
        .alert-clinic-error { background:#fdf0ef;border:1px solid #f5c6c2;color:#c0392b;font-size:.82rem;border-radius:8px; }
        .alert-clinic-success { background:#edf7f2;border:1px solid #b6dfca;color:#1e5c3a;font-size:.82rem;border-radius:8px; }
        .spinner-sm { width:14px;height:14px;border:2px solid rgba(255,255,255,.3);border-top-color:white;border-radius:50%;animation:spin .6s linear infinite;display:inline-block;vertical-align:middle; }
        @keyframes spin { to { transform:rotate(360deg); } }
        .fade-in-up { animation:fadeUp .5s cubic-bezier(.22,1,.36,1) both; }
        @keyframes fadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
        @media(max-width:767.98px){body{overflow:auto;}.right-panel{padding:2rem 1.25rem;}}
    </style>
</head>
<body>
<div class="container-fluid p-0">
  <div class="row g-0">

    {{-- LEFT PANEL --}}
    <div class="col-md-6 d-none d-md-flex left-panel flex-column justify-content-between p-5">
      <div class="deco-ring ring-1"></div>
      <div class="deco-ring ring-2"></div>
      <div class="deco-ring ring-3"></div>

      <div class="d-flex align-items-center gap-2 position-relative">
        <div class="brand-box">
          <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
            <path d="M10 2C10 2 4 5 4 11C4 14.3 6.7 17 10 17C13.3 17 16 14.3 16 11C16 5 10 2 10 2Z" fill="white" fill-opacity=".85"/>
            <path d="M10 7V13M7 10H13" stroke="#1e5c3a" stroke-width="1.5" stroke-linecap="round"/>
          </svg>
        </div>
        <span style="font-size:.85rem;font-weight:500;color:rgba(255,255,255,.9)">The Clinical Sanctuary</span>
      </div>

      <div class="position-relative">
        <h1 class="headline mb-3">Where clinical<br>precision meets<br>curated wellness.</h1>
        <p class="subtext mb-0" style="max-width:310px">Manage your medical practice with a professional interface designed for clarity, speed, and patient-centric focus.</p>
      </div>

      <div class="security-badge d-flex align-items-center gap-3 px-3 py-3 position-relative" style="width:fit-content">
        <div class="badge-icon-wrap">
          <i class="bi bi-shield-check" style="color:rgba(255,255,255,.85);font-size:.95rem"></i>
        </div>
        <div>
          <div style="font-size:.62rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;color:rgba(255,255,255,.55)">Security Level</div>
          <div style="font-size:.82rem;font-weight:600;color:#fff">Enterprise Certified</div>
        </div>
      </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="col-md-6 right-panel">
      <div class="form-card fade-in-up px-2">
        <h2 class="form-title mb-1">Clinic Management<br>System</h2>
        <p class="form-subtitle mb-4">Login to your account to continue</p>

        @if(session('error'))
          <div class="alert alert-clinic-error d-flex align-items-start gap-2 mb-3 p-3">
            <i class="bi bi-exclamation-circle-fill mt-1" style="flex-shrink:0"></i>
            <span>{{ session('error') }}</span>
          </div>
        @endif

        @if(session('success'))
          <div class="alert alert-clinic-success d-flex align-items-start gap-2 mb-3 p-3">
            <i class="bi bi-check-circle-fill mt-1" style="flex-shrink:0"></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-clinic-error d-flex align-items-start gap-2 mb-3 p-3">
            <i class="bi bi-exclamation-circle-fill mt-1" style="flex-shrink:0"></i>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
          @csrf

          {{-- Email --}}
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope" style="font-size:.85rem"></i></span>
              <input type="email" id="email" name="email"
                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                value="{{ old('email') }}"
                placeholder="dr.smith@sanctuary.com"
                autocomplete="email" required>
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          {{-- Password --}}
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label for="password" class="form-label mb-0">Password</label>
              <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
            </div>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock" style="font-size:.85rem"></i></span>
              <input type="password" id="password" name="password"
                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="••••••••" autocomplete="current-password" required>
              <button class="btn pwd-toggle" type="button" onclick="togglePwd()">
                <i class="bi bi-eye" id="eyeIcon" style="font-size:.9rem"></i>
              </button>
              @error('password')<div class="invalid-feedback order-last">{{ $message }}</div>@enderror
            </div>
          </div>

          {{-- Remember --}}
          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">Keep me signed in for 30 days</label>
          </div>

          <button type="submit" class="btn btn-login w-100 py-2" id="loginBtn">Login to Portal</button>
        </form>

        {{-- Divider --}}
        <div class="position-relative text-center my-3">
          <hr class="divider-line">
          <span class="divider-text position-absolute top-50 start-50 translate-middle">Don't have an account yet?</span>
        </div>

        <a href="{{ route('access.request') }}" class="text-decoration-none">
          <button class="btn btn-access w-100 py-2">Request Access</button>
        </a>

        <div class="text-center mt-4">
          <div class="d-flex justify-content-center gap-3 mb-1">
            <a href="{{ route('privacy') }}" class="footer-link">Privacy Policy</a>
            <a href="{{ route('terms') }}"   class="footer-link">Terms of Service</a>
            <a href="{{ route('help') }}"    class="footer-link">Help Center</a>
          </div>
          <p class="footer-copy mb-0">© {{ date('Y') }} The Clinical Sanctuary. All rights reserved.</p>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePwd() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') { input.type = 'text'; icon.className = 'bi bi-eye-slash'; }
    else                           { input.type = 'password'; icon.className = 'bi bi-eye'; }
  }
  document.getElementById('loginForm').addEventListener('submit', function () {
    const btn = document.getElementById('loginBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-sm me-1"></span> Verifying...';
  });
</script>
</body>
</html>