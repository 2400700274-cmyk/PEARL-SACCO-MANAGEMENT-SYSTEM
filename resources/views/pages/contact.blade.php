@extends('components.layouts.frontend')

@section('title', 'Contact Support - Pearl SACCO Management System')

@section('styles')
<style>
    .contact-container {
        padding: 80px 5%;
        background-color: var(--bg-color);
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 60px;
    }
    
    .contact-info {
        background: linear-gradient(135deg, #002b5e 0%, #0078d4 100%);
        color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    
    .contact-info h3 {
        font-size: 24px;
        margin-bottom: 24px;
        color: white;
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 24px;
    }
    
    .info-item p {
        margin: 0;
        line-height: 1.5;
        opacity: 0.95;
    }
    
    .contact-form {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-light);
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
        color: var(--text-primary);
    }
    
    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-family: inherit;
        font-size: 14px;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 120, 212, 0.1);
    }

    @media (max-width: 768px) {
        .contact-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 60px 5%; text-align: center;">
        <h1 style="font-size: 38px; color: var(--primary-color); margin-bottom: 16px;">Platform Support & Inquiries</h1>
        <p style="font-size: 18px; color: var(--text-secondary); max-width: 650px; margin: 0 auto;">Have questions about onboarding your SACCO, compliance audits, or system integration? Our team is ready to assist.</p>
    </div>
    
    <div class="contact-container">
        <div class="contact-info">
            <h3>Central Office</h3>
            
            <div class="info-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                <p>Pearl House, Floor 4,<br>Kampala, Uganda</p>
            </div>
            
            <div class="info-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                <p>+256 800 247 000<br>Mon-Fri 8:30am to 5:30pm EAT</p>
            </div>
            
            <div class="info-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <p>support@pearlsacco.org<br>admin@pearlsacco.org</p>
            </div>
        </div>
        
        <div class="contact-form">
            <h3 style="font-size: 22px; margin-bottom: 24px; color: var(--text-primary);">Send us an Inquiry</h3>
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Your message has been sent to the Pearl SACCO Management System support team.');">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" required placeholder="John">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" required placeholder="Okello">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" required placeholder="user@domain.com">
                </div>
                
                <div class="form-group">
                    <label class="form-label">SACCO Name (If Applicable)</label>
                    <input type="text" class="form-control" placeholder="e.g. Masaka Traders SACCO">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" rows="5" required placeholder="Describe your inquiry or support request..."></textarea>
                </div>
                
                <button type="submit" class="btn-solid" style="width: 100%; border: none; cursor: pointer; font-size: 16px;">Submit Inquiry</button>
            </form>
        </div>
    </div>
@endsection
