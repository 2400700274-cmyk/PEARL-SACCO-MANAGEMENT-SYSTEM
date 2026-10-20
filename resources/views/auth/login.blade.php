<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Pearl SACCO Management System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, rgba(0, 43, 94, 0.88), rgba(0, 120, 212, 0.85)), url('{{ asset("images/hero.jpg") }}') center/cover no-repeat;
            font-family: var(--font-family);
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background-color: var(--surface-color);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            margin: 20px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }

        .auth-header p {
            color: var(--text-secondary);
            font-size: 14px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 13px;
            color: var(--text-primary);
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 120, 212, 0.1);
        }

        .error-message {
            color: var(--danger-color);
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }

        .email-status {
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .email-status.valid {
            color: #107c10;
        }

        .email-status.invalid {
            color: #d13438;
        }

        .email-status.checking {
            color: #0078d4;
        }

        .alert-box {
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .alert-info {
            background-color: #f0f6ff;
            color: #004578;
            border: 1px solid #cce4f7;
        }

        .alert-success {
            background-color: #dff6dd;
            color: #107c10;
            border: 1px solid #b7ebb4;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            border-radius: 6px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 8px; color: var(--primary-color);">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            </div>
            <h1>Pearl SACCO Management System</h1>
            <p>Sign in to access your administrative workspace</p>
        </div>

        @if(session('info'))
            <div class="alert-box alert-info">
                {{ session('info') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert-box alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@domain.com" autocomplete="email">
                <div id="email-feedback" class="email-status" style="display: none;"></div>
                @error('email')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            
            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label class="form-label" for="password" style="margin-bottom: 0;">Password</label>
                    <a href="{{ route('password.request') }}" tabindex="-1" style="font-size: 12px;">Forgot password?</a>
                </div>
                <input class="form-control" type="password" id="password" name="password" required placeholder="••••••••" autocomplete="current-password">
            </div>
            
            <div class="checkbox-container">
                <input type="checkbox" id="remember" name="remember" style="accent-color: var(--primary-color);">
                <label for="remember" style="font-size: 13px; color: var(--text-secondary);">Keep me signed in</label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-login">Sign In</button>

            <div style="text-align: center; margin-top: 24px; font-size: 13px;">
                Looking to onboard a new cooperative? <a href="{{ route('register') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Apply to register SACCO</a>
            </div>
            
            <div style="text-align: center; margin-top: 14px;">
                <a href="{{ url('/') }}" style="font-size: 13px; color: var(--text-secondary); text-decoration: none;">&larr; Back to Pearl SACCO Home</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emailInput = document.getElementById('email');
            const feedback = document.getElementById('email-feedback');
            let debounceTimer = null;

            emailInput.addEventListener('input', function () {
                const val = emailInput.value.trim();
                clearTimeout(debounceTimer);

                if (val.length === 0) {
                    feedback.style.display = 'none';
                    return;
                }

                // If incomplete email, wait or show subtle hint
                if (!val.includes('@') || !val.includes('.')) {
                    feedback.style.display = 'none';
                    return;
                }

                feedback.className = 'email-status checking';
                feedback.textContent = 'Verifying email & domain...';
                feedback.style.display = 'flex';

                debounceTimer = setTimeout(() => {
                    fetch('{{ route("api.check-email") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ email: val, context: 'login' })
                    })
                    .then(res => res.json())
                    .then(data => {
                        feedback.style.display = 'flex';
                        if (data.status === 'exists') {
                            feedback.className = 'email-status valid';
                            feedback.textContent = data.message;
                        } else if (data.status === 'not_found') {
                            feedback.className = 'email-status invalid';
                            feedback.textContent = data.message;
                        } else if (data.status === 'domain_not_found') {
                            feedback.className = 'email-status invalid';
                            feedback.textContent = data.message;
                        } else {
                            feedback.className = 'email-status ' + (data.valid ? 'valid' : 'invalid');
                            feedback.textContent = data.message;
                        }
                    })
                    .catch(err => {
                        feedback.style.display = 'none';
                    });
                }, 400);
            });
        });
    </script>
</body>
</html>
