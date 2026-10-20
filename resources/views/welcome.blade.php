@extends('components.layouts.frontend')

@section('title', 'Pearl SACCO Management System | Multi-SACCO Financial Operations')

@section('styles')
<style>
    .hero {
        background: linear-gradient(135deg, rgba(0, 43, 94, 0.88), rgba(0, 120, 212, 0.85)), url('{{ asset("images/hero.jpg") }}') center/cover no-repeat;
        min-height: 560px;
        display: flex;
        align-items: center;
        color: white;
        padding: 60px 5%;
    }

    .hero-content {
        max-width: 680px;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .hero h1 {
        font-size: 46px;
        font-weight: 800;
        margin-bottom: 20px;
        line-height: 1.2;
        color: white;
        letter-spacing: -0.5px;
    }

    .hero p {
        font-size: 18px;
        opacity: 0.95;
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
        gap: 32px;
    }

    .feature-card {
        padding: 36px;
        border-radius: 12px;
        background: var(--surface-color);
        border: 1px solid var(--border-light);
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    }

    .feature-icon {
        width: 60px;
        height: 60px;
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
        margin-bottom: 12px;
        color: var(--text-primary);
    }

    .feature-card p {
        color: var(--text-secondary);
        line-height: 1.6;
    }

    /* Fixed stats section styling with 100% visible high-contrast labels */
    .stats {
        background: linear-gradient(135deg, #002b5e 0%, #0078d4 100%);
        color: white;
        padding: 60px 5%;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        text-align: center;
        gap: 24px;
    }

    .stat-box {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 28px 20px;
        border-radius: 12px;
        transition: transform 0.2s, background 0.2s;
    }

    .stat-box:hover {
        transform: translateY(-4px);
        background: rgba(255, 255, 255, 0.18);
    }
    
    .stats .stat-number {
        font-size: 46px;
        font-weight: 800;
        color: #ffffff !important;
        margin-bottom: 8px;
        line-height: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .stats .stat-label {
        font-size: 15px !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        opacity: 1 !important;
        letter-spacing: 1px;
        text-transform: uppercase;
        display: block !important;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }

    .cta {
        padding: 90px 5%;
        text-align: center;
        background-color: var(--bg-color);
    }

    @media (max-width: 768px) {
        .stats {
            grid-template-columns: repeat(2, 1fr);
        }
        .hero h1 {
            font-size: 32px;
        }
    }
</style>
@endsection

@section('content')
    <div class="hero">
        <div class="hero-content">
            <div class="hero-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                Multi-SACCO Central Governance Platform
            </div>
            <h1>The Central Management System for SACCOs</h1>
            <p>Pearl SACCO Management System provides a unified, secure operating system designed to register, regulate, audit, and manage cooperative societies across Uganda with automated credit tracking, savings ledgers, and compliance.</p>
            <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                <a href="{{ route('login') }}" class="btn-solid" style="padding: 12px 32px; font-size: 16px;">Access Management Portal</a>
                <a href="{{ route('about') }}" class="btn-outline" style="padding: 12px 32px; font-size: 16px; color: white; border-color: white;">Platform Capabilities</a>
            </div>
        </div>
    </div>

    <div class="features">
        <div class="section-header">
            <h2>Everything Required to Govern & Scale SACCOs</h2>
            <p>A multi-tier platform built for regulatory compliance, individual SACCO autonomy, and end-to-end financial integrity.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
                <h3>Member Directory & NIRA NIN Tracking</h3>
                <p>Register members with Next of Kin documentation, Ugandan NIRA-compliant 14-character NIN validation, and account status controls (Active, Inactive, Suspended).</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
                <h3>Savings & Liquidity Governance</h3>
                <p>Real-time deposit tracking with automated balance computations. Suspended members are restricted from transacting, with automated security holds against active loans.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                </div>
                <h3>Credit Disbursement & Late Penalties</h3>
                <p>Track loan progress percentages, schedule maturity dates, apply automatic late penalty fees, and record collateral and guarantor security to prevent member default.</p>
            </div>
        </div>
    </div>
    
    <!-- Stats Section with clearly visible, high-contrast labels -->
    <div class="stats">
        <div class="stat-box">
            <div class="stat-number">100%</div>
            <span class="stat-label">Digital</span>
        </div>
        <div class="stat-box">
            <div class="stat-number">24/7</div>
            <span class="stat-label">Access</span>
        </div>
        <div class="stat-box">
            <div class="stat-number">Secure</div>
            <span class="stat-label">Data Protection</span>
        </div>
        <div class="stat-box">
            <div class="stat-number">Fast</div>
            <span class="stat-label">Setup Time</span>
        </div>
    </div>

    <div class="cta">
        <h2 style="font-size: 34px; margin-bottom: 16px; color: var(--primary-color);">Cooperative Governance & Oversight</h2>
        <p style="font-size: 17px; color: var(--text-secondary); max-width: 650px; margin: 0 auto 32px;">Pearl SACCO Management System is an enterprise platform. SACCO registrations and tenant provisioning are handled directly by system administrators to maintain institutional security and compliance.</p>
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('login') }}" class="btn-solid" style="padding: 14px 36px; font-size: 16px;">Sign In to Workspace</a>
            <a href="{{ route('contact') }}" class="btn-outline" style="padding: 14px 36px; font-size: 16px;">Contact Central Administration</a>
        </div>
    </div>
@endsection
