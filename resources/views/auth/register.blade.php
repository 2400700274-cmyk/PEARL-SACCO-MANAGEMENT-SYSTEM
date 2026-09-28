<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Kulima Agri-SACCO</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(rgba(0, 80, 150, 0.7), rgba(0, 80, 150, 0.7)), url('{{ asset("images/hero.jpg") }}') center/cover no-repeat;
            font-family: var(--font-family);
            padding: 40px 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 900px;
            background-color: var(--surface-color);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .auth-header h1 {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 8px;
        }

        .auth-header p {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .form-section-title {
            font-size: 14px; 
            margin-bottom: 16px; 
            margin-top: 24px; 
            color: var(--primary-color); 
            border-bottom: 1px solid var(--border-light); 
            padding-bottom: 8px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 16px;
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
            border-radius: 4px;
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

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            border-radius: 4px;
            margin-top: 16px;
        }

        .form-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .form-footer {
            max-width: 400px;
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
            <h1>Register your SACCO</h1>
            <p>Create your isolated workspace and admin account</p>
        </div>
        
        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            
            <div class="form-layout">
                <!-- Left Column -->
                <div class="form-column">
                    <h3 class="form-section-title" style="margin-top: 0;">1. Organization Details</h3>
                    
                    <div class="form-group">
                        <label class="form-label" for="sacco_name">SACCO Name</label>
                        <input class="form-control" type="text" id="sacco_name" name="sacco_name" value="{{ old('sacco_name') }}" placeholder="e.g. Mbarara Farmers Cooperative" required autofocus>
                        @error('sacco_name')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_number">Registration Number (Optional)</label>
                        <input class="form-control" type="text" id="reg_number" name="reg_number" value="{{ old('reg_number') }}">
                        @error('reg_number')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="address">Headquarters Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                        @error('address')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <h3 class="form-section-title" style="margin-top: 0;">2. Administrator Account</h3>

                    <div class="form-group">
                        <label class="form-label" for="name">Your Full Name</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Admin Email Address</label>
                        <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" type="password" id="password" name="password" required>
                            @error('password')<span class="error-message">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary btn-submit">Create Workspace</button>
                
                <div style="text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-secondary);">
                    Already registered your SACCO? <a href="{{ route('login') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Sign in</a>
                </div>
                
                <div style="text-align: center; margin-top: 12px;">
                    <a href="{{ url('/') }}" style="font-size: 13px; color: var(--text-secondary); text-decoration: none;">&larr; Back to Home</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
