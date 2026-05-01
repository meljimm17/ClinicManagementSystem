<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — CuraSure Clinic Management</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        html, body { margin: 0; padding: 0; width: 100%; overflow-x: hidden; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif; }

        .left-panel {
            background: linear-gradient(135deg, #1a3d2e, #2d7a50);
            min-height: 100vh;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before{
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 45% at 80% 15%, rgba(58,173,110,.22) 0%, transparent 70%),
                radial-gradient(ellipse 55% 55% at 10% 90%, rgba(15,36,25,.45) 0%, transparent 65%);
            pointer-events: none;
        }

        .left-content{
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            text-align: left;
        }

        .brand-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255,255,255,.12);
            border: 1.5px solid rgba(255,255,255,.25);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.15rem;
        }

        .left-panel h1{
            font-size: clamp(1.65rem, 2.7vw, 2.6rem);
            line-height: 1.12;
            font-weight: 700;
            letter-spacing: -0.01em;
            margin: 0;
        }

        .right-panel {
            min-height: 100vh;
            background: linear-gradient(180deg, #ffffff 0%, #f6f8f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-card {
            max-width: 400px;
            width: 100%;
            background: rgba(255,255,255,.92);
            border-radius: 16px;
            border: 1px solid rgba(216,228,221,.9);
            box-shadow: 0 18px 50px rgba(15,36,25,.12);
        }
        .form-title { font-size: 1.8rem; font-weight: 600; color: #0f2419; }

        /* Fix: Removes Bootstrap's default validation icon that cuts the line */
        .form-control.is-invalid {
            background-image: none !important;
            border-color: #d8e4dd; /* Reset to default, let wrapper handle red */
        }

        .input-group-custom {
            display: flex;
            border: 1px solid #d8e4dd;
            border-radius: 12px;
            background: #f8faf9;
            overflow: hidden;
        }

        /* The Red Border Wrapper */
        .is-invalid-border {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .1);
        }

        .input-group-custom .form-control { border: none !important; flex: 1; background: transparent; }
        
        .input-group-text-custom {
            background: transparent;
            border: none;
            color: #6b7c74;
            cursor: pointer;
            display: flex;
            align-items: center;
            padding: 0 12px;
        }

        .btn-login {
            background: linear-gradient(135deg, #1e5c3a, #2d7a50);
            color: #fff; border: none;
            border-radius: 12px;
            padding-left: 1rem;
            padding-right: 1rem;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0 m-0">
    <div class="row g-0 m-0 p-0">
        <div class="col-md-6 d-none d-md-flex left-panel">
            <div class="left-content text-center">
                <div class="mb-4">
                    <img src="{{ asset('img/logo.png') }}" alt="CuraSure" style="width:160px; height:160px; object-fit:contain;">
                </div>
                <div class="brand-box mx-auto mb-4" aria-hidden="true" style="display:none;">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                        <path d="M10 2C10 2 4 5 4 11C4 14.3 6.7 17 10 17C13.3 17 16 14.3 16 11C16 5 10 2 10 2Z" fill="white" fill-opacity=".85"/>
                        <path d="M10 7V13M7 10H13" stroke="#1e5c3a" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <h1>Where clinical<br>precision meets<br>curated wellness.</h1>
            </div>
        </div>

        <div class="col-md-6 right-panel">
            <div class="form-card p-4">
                <h2 class="form-title">Welcome Back!</h2>
                <p class="text-muted mb-4">Login to your account</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                     <div class="mb-3">
                         <label class="form-label">Username / Email</label>
                         <input type="text" name="username" 
                                class="form-control @error('username') is-invalid @enderror" 
                                value="{{ old('username') }}" required autofocus>
                     </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group-custom @if($errors->any()) is-invalid-border @endif">
                            <input type="password" name="password" id="password" 
                                   class="form-control" 
                                   value="{{ old('password') }}" required>
                            
                            <span class="input-group-text-custom" onclick="togglePassword()">
                                <i id="eyeIcon" class="bi bi-eye"></i>
                            </span>
                        </div>

                        @if($errors->any())
                            <div class="text-danger mt-2" style="font-size: 0.875rem;">
                                {{ $errors->first('username') }}
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-login w-100 py-2">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
</body>
</html>