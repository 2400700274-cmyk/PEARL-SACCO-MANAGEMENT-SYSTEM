@extends('components.layouts.frontend')

@section('title', 'Kulima Agri-SACCO | Modernizing Agricultural Cooperatives')

@section('styles')
<style>
    .hero {
        background: linear-gradient(rgba(0, 80, 150, 0.7), rgba(0, 80, 150, 0.8)), url('{{ asset("images/hero.jpg") }}') center/cover no-repeat;
        height: 600px;
        display: flex;
        align-items: center;
        color: white;
        padding: 0 5%;
    }

    .hero-content {
        max-width: 600px;
    }

    .hero h1 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.2;
        color: white;
    }

    .hero p {
        font-size: 18px;
        opacity: 0.9;
        margin-bottom: 32px;
        line-height: 1.6;
    }

    .features {
        padding: 80px 5%;
        background-color: white;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
    }

    .feature-card {
        padding: 40px;
        border-radius: 8px;
        background: var(--surface-color);
        border: 1px solid var(--border-light);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .feature-icon {
        width: 64px;
        height: 64px;
        background: rgba(0, 120, 212, 0.1);
        color: var(--primary-color);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
    }

    .feature-card h3 {
        font-size: 20px;
        margin-bottom: 16px;
        color: var(--text-primary);
    }

    .feature-card p {
        color: var(--text-secondary);
        line-height: 1.6;
    }

    .stats {
        background-color: var(--primary-color);
        color: white;
        padding: 60px 5%;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        text-align: center;
        gap: 20px;
    }
    
    .stat-number {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .stat-label {
        font-size: 16px;
        opacity: 0.8;
    }

    .cta {
        padding: 100px 5%;
        text-align: center;
        background-color: var(--bg-color);
    }
</style>
@endsection

@section('content')
    <div class="hero">
        <div class="hero-content">
            <h1>The Modern OS for Agricultural SACCOs</h1>
            <p>Digitize your cooperative society, manage members, process loans, and track savings securely with our enterprise-grade platform built specifically for East African farmers.</p>
            <div style="display: flex; gap: 16px;">
                <a href="{{ route('register') }}" class="btn-solid" style="padding: 12px 32px; font-size: 16px;">Register SACCO</a>
                <a href="{{ route('about') }}" class="btn-outline" style="padding: 12px 32px; font-size: 16px; color: white; border-color: white;">Learn More</a>
            </div>
        </div>
    </div>

    <div class="features">
        <div class="section-header">
            <h2>Everything you need to grow</h2>
            <p>Replace error-prone spreadsheets and paper ledgers with a robust, secure, and easy-to-use digital ecosystem.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <h3>Member Directory</h3>
                <p>Centralized digital registry for all members with secure profile management, National ID tracking, and active status monitoring.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
                <h3>Savings & Deposits</h3>
                <p>Track member contributions in real-time. Automated balance calculation and complete transaction history for ultimate transparency.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                </div>
                <h3>Loan Processing</h3>
                <p>End-to-end credit management. Track applications, calculate interest, manage approvals, and monitor repayment schedules effortlessly.</p>
            </div>
        </div>
    </div>
    
    <div class="stats">
        <div>
            <div class="stat-number">100%</div>
            <div class="stat-label">Digital</div>
        </div>
        <div>
            <div class="stat-number">24/7</div>
            <div class="stat-label">Access</div>
        </div>
        <div>
            <div class="stat-number">Secure</div>
            <div class="stat-label">Data Protection</div>
        </div>
        <div>
            <div class="stat-number">Fast</div>
            <div class="stat-label">Setup Time</div>
        </div>
    </div>

    <div class="cta">
        <h2 style="font-size: 36px; margin-bottom: 16px; color: var(--primary-color);">Ready to modernize your SACCO?</h2>
        <p style="font-size: 18px; color: var(--text-secondary); max-width: 600px; margin: 0 auto 32px;">Join the digital revolution in agricultural cooperative management today. Create your isolated workspace in seconds.</p>
        <a href="{{ route('register') }}" class="btn-solid" style="padding: 14px 40px; font-size: 18px;">Get Started Now</a>
    </div>
@endsection
