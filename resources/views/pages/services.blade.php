@extends('components.layouts.frontend')

@section('title', 'Services - Kulima Agri-SACCO')

@section('styles')
<style>
    .hero-services {
        background: linear-gradient(rgba(0, 80, 150, 0.8), rgba(0, 80, 150, 0.9)), url('{{ asset("images/hero.jpg") }}') center/cover;
        color: white;
        padding: 100px 5% 80px;
        text-align: center;
    }
    
    .services-container {
        padding: 80px 5%;
        background-color: var(--bg-color);
    }
    
    .service-block {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto 100px;
    }
    
    .service-block:nth-child(even) {
        direction: rtl;
    }
    
    .service-block:nth-child(even) .service-content {
        direction: ltr;
    }
    
    .service-image {
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .service-content h2 {
        font-size: 32px;
        color: var(--primary-color);
        margin-bottom: 20px;
    }
    
    .service-content p {
        font-size: 16px;
        line-height: 1.8;
        color: var(--text-secondary);
        margin-bottom: 24px;
    }
    
    .feature-list {
        list-style: none;
        padding: 0;
    }
    
    .feature-list li {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--text-primary);
        font-weight: 500;
    }
</style>
@endsection

@section('content')
    <div class="hero-services">
        <h1 style="font-size: 48px; margin-bottom: 20px; color: white;">Our Services</h1>
        <p style="font-size: 20px; max-width: 800px; margin: 0 auto; opacity: 0.9;">A comprehensive suite of tools designed specifically to handle the unique financial workflows of Agricultural SACCOs.</p>
    </div>
    
    <div class="services-container">
        
        <div class="service-block">
            <div>
                <img src="{{ asset('images/visual.jpg') }}" alt="Member Management" class="service-image">
            </div>
            <div class="service-content">
                <h2>Member Management</h2>
                <p>Keep a unified, digital registry of all your cooperative members. Ditch the paper files and instantly access member profiles, histories, and contact information.</p>
                <ul class="feature-list">
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Secure National ID (NIN) tracking</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Profile photo uploads</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Member status toggling (Active/Suspended)</li>
                </ul>
            </div>
        </div>

        <div class="service-block">
            <div>
                <img src="{{ asset('images/about.jpg') }}" alt="Savings & Deposits" class="service-image">
            </div>
            <div class="service-content">
                <h2>Savings & Deposits</h2>
                <p>Track member contributions and savings accurately in real-time. Members can have complete confidence that their funds are securely recorded and accounted for.</p>
                <ul class="feature-list">
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Automated balance calculations</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Full transaction history per member</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Deposit and withdrawal management</li>
                </ul>
            </div>
        </div>

        <div class="service-block">
            <div>
                <img src="{{ asset('images/hero.jpg') }}" alt="Loan Processing" class="service-image">
            </div>
            <div class="service-content">
                <h2>Loan & Credit Processing</h2>
                <p>Streamline your lending process. From application to approval and repayment tracking, manage the entire lifecycle of agricultural loans efficiently.</p>
                <ul class="feature-list">
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Multi-stage approval workflows</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Interest rate calculation</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Repayment tracking and arrears alerts</li>
                </ul>
            </div>
        </div>

    </div>
@endsection
