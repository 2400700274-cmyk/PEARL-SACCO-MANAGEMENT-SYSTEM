@extends('components.layouts.frontend')

@section('title', 'About Us - Kulima Agri-SACCO')

@section('styles')
<style>
    .hero-about {
        background: linear-gradient(rgba(0, 80, 150, 0.8), rgba(0, 80, 150, 0.9)), url('{{ asset("images/about.jpg") }}') center/cover;
        color: white;
        padding: 100px 5% 80px;
        text-align: center;
    }
    
    .hero-about h1 {
        font-size: 48px;
        margin-bottom: 20px;
        color: white;
    }
    
    .hero-about p {
        font-size: 20px;
        max-width: 800px;
        margin: 0 auto;
        opacity: 0.9;
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
        border-radius: 8px;
        text-align: center;
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-sm);
    }
    
    .value-card h3 {
        color: var(--primary-color);
        margin-bottom: 16px;
    }
</style>
@endsection

@section('content')
    <div class="hero-about">
        <h1>Empowering Agricultural Communities</h1>
        <p>Kulima Agri-SACCO is dedicated to modernizing how cooperative societies operate, bringing financial inclusion and digital efficiency to farmers across the region.</p>
    </div>
    
    <div class="content-section">
        <div class="grid-about">
            <div class="about-text">
                <h2>Our Mission & Vision</h2>
                <p><strong>Mission:</strong> To provide a robust, secure, and user-friendly digital platform that simplifies the management of Agricultural SACCOs, ensuring transparency and growth for every member.</p>
                <p><strong>Vision:</strong> A future where every agricultural cooperative, regardless of size, has access to enterprise-grade tools to manage savings, disburse loans, and elevate the economic status of the farming community.</p>
                <p>We believe that by digitizing the administrative burden of SACCOs, leadership can focus on what truly matters: serving their members and investing in agricultural innovation.</p>
            </div>
            <div>
                <img src="{{ asset('images/about.jpg') }}" alt="Farmers" class="about-image">
            </div>
        </div>
        
        <div class="section-header" style="margin-top: 100px;">
            <h2>Core Values</h2>
            <p>The principles that guide our platform and our partnership with you.</p>
        </div>
        
        <div class="values-grid">
            <div class="value-card">
                <h3>Transparency</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">Clear, immutable audit trails for every transaction ensuring trust between members and administration.</p>
            </div>
            <div class="value-card">
                <h3>Security</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">Bank-grade data protection ensuring your members' financial information and personal data remain strictly confidential.</p>
            </div>
            <div class="value-card">
                <h3>Simplicity</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">A user interface designed for everyone, requiring minimal training while delivering maximum operational power.</p>
            </div>
        </div>
    </div>
@endsection
