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
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        }

        .left-panel {
            background: linear-gradient(135deg, #1a3d2e, #2d7a50);
            min-height: 100vh;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        .left-panel h1 {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            font-weight: 600;
        }

        .right-panel {
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-card {
            max-width: 400px;
            width: 100%;
        }

        .form-title {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            font-size: 1.8rem;
            font-weight: 600;
            color: #0f2419;
        }

        .form-control {
            border: 1px solid #d8e4dd;
            background: #f8faf9;
        }

        .form-control:focus {
            border-color: #3aad6e;
            box-shadow: 0 0 0 .2rem rgba(58,173,110,.15);
        }

        /* Styling for the Eye Icon button */
        .input-group-text {
            background: #f8faf9;
            border: 1px solid #d8e4dd;
            border-left: none;
            color: #6b7c74;
            cursor: pointer;
        }

        .btn-login {
            background: linear-gradient(135deg, #1e5c3a, #2d7a50);
            color: #fff;
            border: none;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1a3d2e, #1e5c3a);
            color: #fff;
        }

        .footer-link {
            font-size: .75rem;
            color: #6b7c74;
            text-decoration: none;
        }

        .footer-link:hover {
            color: #1e5c3a;
        }
    </style>
</head>

<body>

<div class="container-fluid p-0 m-0">
    <div class="row g-0 m-0 p-0">

        <div class="col-md-6 d-none d-md-flex left-panel">
            <div class="text-center">
                <img src="{{ asset('img/logo.png') }}" alt="CuraSure" style="width:180px; height:180px; object-fit:contain; margin-bottom:2rem;">
                
                <h1>
                    Where clinical<br>
                    precision meets<br>
                    curated wellness.
                </h1>
                <p class="mt-3" style="opacity:0.8; max-width:300px; margin-left: auto; margin-right: auto;">
                    Manage your clinic with a modern and secure system designed for efficiency.
                </p>
            </div>
        </div>

        <div class="col-md-6 right-panel d-flex flex-column justify-content-center">

            <div class="form-card p-4 text-center">

                <h2 class="form-title">CuraSure</h2>
                <p class="text-muted mb-4">Clinic Management System</p>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                     <div class="mb-3">
                         <label class="form-label">Username / Email</label>
                         <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required autofocus>
                         @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                     </div>

                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   style="border-right: none;" required>
                            
                            <span class="input-group-text" onclick="togglePassword()">
                                <i id="eyeIcon" class="bi bi-eye"></i>
                            </span>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login w-100 py-2">
                        Login
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="#" class="footer-link">Forgot password?</a>
                </div>

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