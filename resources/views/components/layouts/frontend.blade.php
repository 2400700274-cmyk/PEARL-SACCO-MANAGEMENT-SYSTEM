<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pearl SACCO Management System')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --nav-height: 80px;
        }
        
        body {
            font-family: var(--font-family);
            background-color: var(--surface-color);
            margin: 0;
            padding: 0;
            color: var(--text-primary);
            overflow: visible !important;
            height: auto !important;
            display: block !important;
        }

        /* Navbar */
        .navbar {
            height: var(--nav-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            background-color: var(--surface-color);
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -0.3px;
        }

        .navbar-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .navbar-links a {
            text-decoration: none;
            color: var(--text-primary);
            font-weight: 500;
            font-size: 15px;
            transition: color 0.2s;
        }

        .navbar-links a:hover {
            color: var(--primary-color);
        }

        .navbar-actions {
            display: flex;
            gap: 16px;
        }

        .btn-outline {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
            padding: 8px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-solid {
            background: var(--primary-color);
            color: white;
            padding: 10px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
            border: 2px solid var(--primary-color);
        }

        .btn-solid:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        /* Footer */
        .footer {
            background-color: #002b5e;
            color: white;
            padding: 60px 5% 30px;
            margin-top: auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer h3 {
            font-size: 18px;
            margin-bottom: 20px;
            color: white;
        }

        .footer p {
            color: rgba(255,255,255,0.7);
            line-height: 1.6;
            margin-bottom: 16px;
        }

        .footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
            transition: color 0.2s;
        }

        .footer a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 24px;
            text-align: center;
            color: rgba(255,255,255,0.5);
            font-size: 14px;
        }

        /* Page Content Wrapper */
        .page-content {
            margin-top: var(--nav-height);
            min-height: calc(100vh - var(--nav-height));
            display: flex;
            flex-direction: column;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 48px;
        }
        
        .section-header h2 {
            font-size: 34px;
            color: var(--primary-color);
            margin-bottom: 16px;
        }
        
        .section-header p {
            font-size: 17px;
            color: var(--text-secondary);
            max-width: 650px;
            margin: 0 auto;
        }

        @media (max-width: 900px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 600px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }
            .navbar-links {
                display: none;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    
    <nav class="navbar">
        <a href="{{ route('home') }}" class="navbar-brand">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            Pearl SACCO Management System
        </a>

        <div class="navbar-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('about') }}">About Platform</a>
            <a href="{{ route('services') }}">Services & Modules</a>
            <a href="{{ route('contact') }}">Contact & Inquiries</a>
        </div>

        <div class="navbar-actions">
            @auth
                <a href="{{ auth()->user()->isSuperAdmin() ? route('saccos.index') : route('dashboard') }}" class="btn-solid">
                    {{ auth()->user()->isSuperAdmin() ? 'Manage SACCOs' : 'Dashboard' }}
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-outline">Sign In</a>
                <a href="{{ route('register') }}" class="btn-solid">Register SACCO</a>
            @endauth
        </div>
    </nav>

    <div class="page-content">
        @yield('content')
        
        <footer class="footer">
            <div class="footer-grid">
                <div>
                    <h3 style="display: flex; align-items: center; gap: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        Pearl SACCO Management System
                    </h3>
                    <p>The centralized multi-SACCO management platform governing credit societies, cooperative compliance, and financial records throughout Uganda.</p>
                </div>
                <div>
                    <h3>Quick Links</h3>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('about') }}">About Platform</a>
                    <a href="{{ route('services') }}">Services</a>
                    <a href="{{ route('contact') }}">Contact Support</a>
                </div>
                <div>
                    <h3>Governance</h3>
                    <a href="#">Compliance Guidelines</a>
                    <a href="#">Audit Protocols</a>
                    <a href="#">Security Safeguards</a>
                    <a href="#">Privacy Policy</a>
                </div>
                <div>
                    <h3>Platform Support</h3>
                    <p>Kampala, Uganda</p>
                    <p>support@pearlsacco.org</p>
                    <p>+256 800 247 000</p>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Pearl SACCO Management System. All rights reserved.
            </div>
        </footer>
    </div>
    @yield('scripts')
</body>
</html>
