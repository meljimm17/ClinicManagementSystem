<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — The Clinical Sanctuary</title>

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
        }

        .right-panel {
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-card { max-width: 400px; width: 100%; }
        .form-title { font-size: 1.8rem; font-weight: 600; color: #0f2419; }

        /* Fix: Removes Bootstrap's default validation icon that cuts the line */
        .form-control.is-invalid {
            background-image: none !important;
            border-color: #d8e4dd; /* Reset to default, let wrapper handle red */
        }

        .input-group-custom {
            display: flex;
            border: 1px solid #d8e4dd;
            border-radius: 0.375rem;
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
        }
    </style>
</head>
<body>

<div class="container-fluid p-0 m-0">
    <div class="row g-0 m-0 p-0">
        <div class="col-md-6 d-none d-md-flex left-panel">
            <div>
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
                        <label class="form-label">Username</label>
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