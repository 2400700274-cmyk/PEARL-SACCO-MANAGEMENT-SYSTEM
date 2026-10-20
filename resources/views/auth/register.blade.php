<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for SACCO Registration - Pearl SACCO Management System</title>
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
            padding: 40px 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 920px;
            background-color: var(--surface-color);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-header h1 {
            font-size: 24px;
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

        .notice-banner {
            background-color: #f0f6ff;
            border-left: 4px solid var(--primary-color);
            padding: 14px 18px;
            border-radius: 6px;
            margin-bottom: 24px;
            font-size: 13px;
            line-height: 1.5;
            color: #004578;
        }

        .form-section-title {
            font-size: 14px; 
            margin-bottom: 16px; 
            margin-top: 24px; 
            color: var(--primary-color); 
            border-bottom: 1px solid var(--border-light); 
            padding-bottom: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group {
            margin-bottom: 16px;
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

        .email-status.valid { color: #107c10; }
        .email-status.invalid { color: #d13438; }
        .email-status.checking { color: #0078d4; }

        .form-hint {
            font-size: 11px;
            color: var(--text-secondary);
            margin-top: 4px;
            display: block;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
            font-size: 15px;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 16px;
        }

        .form-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .form-footer {
            max-width: 440px;
            margin: 32px auto 0 auto;
        }

        @media (max-width: 768px) {
            .form-layout {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 8px; color: var(--primary-color);">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            </div>
            <h1>Apply for SACCO Registration</h1>
            <p>Pearl SACCO Management System Onboarding</p>
        </div>

        <div class="notice-banner">
            <strong>Security & Oversight Policy:</strong> Pearl SACCO Management System is an authorized regulatory and management platform. Registration requests are placed in <strong>Pending Review</strong> status. Access to system services is granted only after administrative verification by the platform team.
        </div>
        
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            
            <div class="form-layout">
                <!-- Left Column -->
                <div class="form-column">
                    <h3 class="form-section-title" style="margin-top: 0;">1. SACCO Society Details</h3>
                    
                    <div class="form-group">
                        <label class="form-label" for="sacco_name">SACCO Name</label>
                        <input class="form-control" type="text" id="sacco_name" name="sacco_name" value="{{ old('sacco_name') }}" placeholder="e.g. Bushenyi Tea Growers SACCO" required autofocus>
                        @error('sacco_name')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_number">Ministry / Registrar Number (Optional)</label>
                        <input class="form-control" type="text" id="reg_number" name="reg_number" value="{{ old('reg_number') }}" placeholder="e.g. COOP/2026/8492">
                        @error('reg_number')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">SACCO Official Telephone</label>
                        <input class="form-control" type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+256 700 000 000">
                        @error('phone')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="address">Headquarters / District Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required placeholder="Plot number, Street, District, Uganda">{{ old('address') }}</textarea>
                        @error('address')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <h3 class="form-section-title" style="margin-top: 0;">2. Primary Administrator Account</h3>

                    <div class="form-group">
                        <label class="form-label" for="name">Administrator Full Name</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Sarah Namubiru">
                        @error('name')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="nin">Uganda National ID (NIN)</label>
                        <input class="form-control" type="text" id="nin" name="nin" value="{{ old('nin') }}" maxlength="14" required placeholder="CM90012345ABCD" style="text-transform: uppercase;">
                        <span class="form-hint">14 alphanumeric characters compliant with Uganda NIRA format</span>
                        @error('nin')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Administrator Email Address</label>
                        <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="admin@sacco.org">
                        <div id="email-feedback" class="email-status" style="display: none;"></div>
                        @error('email')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" type="password" id="password" name="password" required placeholder="Min. 8 characters">
                            @error('password')<span class="error-message">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required placeholder="Repeat password">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary btn-submit">Submit Registration Application</button>
                
                <div style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-secondary);">
                    Already managing an active SACCO? <a href="{{ route('login') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Sign in here</a>
                </div>
                
                <div style="text-align: center; margin-top: 12px;">
                    <a href="{{ url('/') }}" style="font-size: 13px; color: var(--text-secondary); text-decoration: none;">&larr; Return to Pearl SACCO Home</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-format Ugandan NIN to uppercase
            const ninInput = document.getElementById('nin');
            if (ninInput) {
                ninInput.addEventListener('input', function () {
                    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                });
            }

            // Real-time email validation
            const emailInput = document.getElementById('email');
            const feedback = document.getElementById('email-feedback');
            let debounceTimer = null;

            if (emailInput && feedback) {
                emailInput.addEventListener('input', function () {
                    const val = emailInput.value.trim();
                    clearTimeout(debounceTimer);

                    if (val.length === 0 || !val.includes('@') || !val.includes('.')) {
                        feedback.style.display = 'none';
                        return;
                    }

                    feedback.className = 'email-status checking';
                    feedback.textContent = 'Verifying email domain...';
                    feedback.style.display = 'flex';

                    debounceTimer = setTimeout(() => {
                        fetch('{{ route("api.check-email") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ email: val, context: 'register' })
                        })
                        .then(res => res.json())
                        .then(data => {
                            feedback.style.display = 'flex';
                            feedback.className = 'email-status ' + (data.valid ? 'valid' : 'invalid');
                            feedback.textContent = data.message;
                        })
                        .catch(() => {
                            feedback.style.display = 'none';
                        });
                    }, 400);
                });
            }
        });
    </script>
</body>
</html>
