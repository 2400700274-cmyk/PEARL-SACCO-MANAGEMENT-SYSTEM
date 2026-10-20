@extends('components.layouts.frontend')

@section('title', 'About Platform - Pearl SACCO Management System')

@section('styles')
<style>
    .hero-about {
        background: linear-gradient(135deg, rgba(0, 43, 94, 0.88), rgba(0, 120, 212, 0.85)), url('{{ asset("images/about.jpg") }}') center/cover;
        color: white;
        padding: 100px 5% 80px;
        text-align: center;
    }
    
    .hero-about h1 {
        font-size: 44px;
        margin-bottom: 20px;
        color: white;
    }
    
    .hero-about p {
        font-size: 19px;
        max-width: 800px;
        margin: 0 auto;
        opacity: 0.95;
        line-height: 1.6;
    }
    
    .content-section {
        padding: 80px 5%;
        background-color: white;
    }
    
    .grid-about {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .about-image {
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        width: 100%;
    }
    
    .about-text h2 {
        font-size: 32px;
        color: var(--primary-color);
        margin-bottom: 24px;
    }
    
    .about-text p {
        font-size: 16px;
        line-height: 1.8;
        color: var(--text-secondary);
        margin-bottom: 20px;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        max-width: 1200px;
        margin: 60px auto 0;
    }

    .value-card {
        background: var(--surface-color);
        padding: 40px;
        border-radius: 12px;
        text-align: center;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-sm);
    }
    
    .value-card h3 {
        color: var(--primary-color);
        margin-bottom: 16px;
    }

    @media (max-width: 768px) {
        .grid-about {
            grid-template-columns: 1fr;
        }
        .values-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
    <div class="hero-about">
        <h1>Transforming SACCO Operations Across Uganda</h1>
        <p>Pearl SACCO Management System is an enterprise-grade multi-SACCO management and oversight platform engineered to bring digital governance, transparent ledger keeping, and automated credit tracking to cooperative societies throughout Uganda.</p>
    </div>
    
    <div class="content-section">
        <div class="grid-about">
            <div class="about-text">
                <h2>Our Mission & Vision</h2>
                <p><strong>Mission:</strong> To provide a multi-tenant digital operating system that enables cooperative societies to register, manage members, safeguard savings, and disburse credit transparently while upholding national compliance guidelines.</p>
                <p><strong>Vision:</strong> A connected national cooperative finance ecosystem where every registered SACCO operates with bank-grade security, automated credit recovery protocols, and verified member identification.</p>
                <p>By shifting SACCOs away from paper registers and vulnerable spreadsheets, Pearl SACCO Management System protects member funds and standardizes operations for cooperative leadership and national stakeholders.</p>
            </div>
            <div>
                <img src="{{ asset('images/about.jpg') }}" alt="Cooperative Members" class="about-image">
            </div>
        </div>
        
        <div class="section-header" style="margin-top: 100px;">
            <h2>Core Pillars</h2>
            <p>The foundations driving the Pearl SACCO Management System architecture.</p>
        </div>
        
        <div class="values-grid">
            <div class="value-card">
                <h3>Multi-SACCO Governance</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">Unified oversight enabling the platform to monitor, approve, and audit distinct cooperative societies in separated, secure workspaces.</p>
            </div>
            <div class="value-card">
                <h3>Risk Mitigation & Recovery</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">Automated late penalty calculation, mandatory collateral/guarantor documentation, and account suspension safeguards to curb credit default.</p>
            </div>
            <div class="value-card">
                <h3>Verified Compliance</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">Ugandan NIRA NIN enforcement, Next of Kin records, and real-time email verification ensuring authentic, accountable member participation.</p>
            </div>
        </div>
    </div>
@endsection
