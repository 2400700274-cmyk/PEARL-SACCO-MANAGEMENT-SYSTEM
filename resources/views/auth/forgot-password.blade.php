<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Kulima Agri-SACCO</title>
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
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background-color: var(--surface-color);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            margin: 20px;
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

        .form-group {
            margin-bottom: 20px;
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

        .btn-submit {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-header">
            <h1>Reset Password</h1>
            <p>Enter your email address to receive a password reset link.</p>
        </div>

        @if (session('status'))
            <div style="background-color: #dff6dd; color: var(--success-color); padding: 12px; border-radius: 4px; margin-bottom: 24px; font-size: 14px; text-align: center;">
                {{ session('status') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="email">Email Address</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            
            <button type="submit" class="btn btn-primary btn-submit">Send Password Reset Link</button>
            
            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ route('login') }}" style="font-size: 13px; color: var(--text-secondary); text-decoration: none;">&larr; Back to Login</a>
            </div>
        </form>
    </div>
</body>
</html>
