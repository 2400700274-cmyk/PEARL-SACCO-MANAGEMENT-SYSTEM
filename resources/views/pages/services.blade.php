@extends('components.layouts.frontend')

@section('title', 'Services & Modules - Pearl SACCO Management System')

@section('styles')
<style>
    .hero-services {
        background: linear-gradient(135deg, rgba(0, 43, 94, 0.88), rgba(0, 120, 212, 0.85)), url('{{ asset("images/hero.jpg") }}') center/cover;
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
        margin: 0 auto 80px;
    }
    
    .service-block:nth-child(even) {
        direction: rtl;
    }
    
    .service-block:nth-child(even) .service-content {
        direction: ltr;
    }
    
    .service-image {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .service-content h2 {
        font-size: 30px;
        color: var(--primary-color);
        margin-bottom: 18px;
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
        font-size: 15px;
    }

    @media (max-width: 768px) {
        .service-block {
            grid-template-columns: 1fr;
            direction: ltr !important;
        }
    }
</style>
@endsection

@section('content')
    <div class="hero-services">
        <h1 style="font-size: 44px; margin-bottom: 20px; color: white;">Platform Modules & Capabilities</h1>
        <p style="font-size: 19px; max-width: 800px; margin: 0 auto; opacity: 0.95; line-height: 1.6;">A complete governance suite built to manage SACCOs, track credit disbursements, apply recovery penalties, and enforce member accountability.</p>
    </div>
    
    <div class="services-container">
        
        <div class="service-block">
            <div>
                <img src="{{ asset('images/visual.jpg') }}" alt="Member Registry" class="service-image">
            </div>
            <div class="service-content">
                <h2>Member Governance & Next of Kin</h2>
                <p>Maintain authenticated member records compliant with Ugandan regulatory standards. Every member is verified with mandatory Next of Kin emergency details and official 14-character Ugandan NIRA NINs.</p>
                <ul class="feature-list">
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> Next of Kin name, contact, relationship & address documentation</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> Strict Uganda NIRA 14-character NIN validation</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> Real-time email syntax and domain existence checks</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> Account status enforcement (Active, Inactive, Suspended)</li>
                </ul>
            </div>
        </div>

        <div class="service-block">
            <div>
                <img src="{{ asset('images/about.jpg') }}" alt="Savings Security" class="service-image">
            </div>
            <div class="service-content">
                <h2>Savings Safeguards & Collateral Holds</h2>
                <p>Protect member capital with automated ledger reconciliation. Suspended and inactive members are strictly prohibited from depositing or withdrawing funds, and active borrowers cannot drain savings used to secure active credit.</p>
                <ul class="feature-list">
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> Restricted access for inactive and suspended accounts</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> Automated loan security reserve holds against outstanding loans</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> Immediate audit logging for every financial entry</li>
                </ul>
            </div>
        </div>

        <div class="service-block">
            <div>
                <img src="{{ asset('images/hero.jpg') }}" alt="Credit & Penalties" class="service-image">
            </div>
            <div class="service-content">
                <h2>Loan Tracking, Late Penalties & Recovery</h2>
                <p>End-to-end credit management with visual progress indicators tracking how far repayments have progressed. Apply enforceable late penalty fees and default suspensions so members cannot default without accountability.</p>
                <ul class="feature-list">
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> Real-time repayment progress bars and maturity countdowns</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> One-click late penalty fee application (fixed or percentage)</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> Collateral documentation and verified Guarantor NIN tracking</li>
                    <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--primary-color)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg> Auto-suspension security protocol for defaulted credit</li>
                </ul>
            </div>
        </div>

    </div>
@endsection
