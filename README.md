# Pearl SACCO Management System

The multi-tenant management system built specifically to digitize, oversee, and empower Savings and Credit Cooperative Organizations (SACCOs) across Uganda and East Africa.

## 🚀 Features

- **Multi-SACCO Oversight**: Master administration to monitor registered SACCOs, member totals, and aggregate savings/loan liquidity.
- **Controlled Onboarding**: SACCO registrations are reviewed and activated by system administrators to maintain institutional security.
- **Member Management**: Unified digital registry with Ugandan NIRA NIN validation, Next of Kin records, and profile photos.
- **Savings & Deposits**: Member contributions and withdrawals with transaction logs and reserve lock protection against active loans.
- **Loan & Credit Processing**: Repayment progress tracking, loan maturity dates, late penalty fees, guarantor verification, and collateral safeguards.
- **Role-Based Access Control (RBAC)**: Clear role allocation and visual badges for Super Administrators, SACCO Admins, Loan Officers, and Tellers.
- **Real-Time Email Verification**: Instant domain DNS MX record check and database presence validation during input.
- **Premium UI & Modern Theme**: High-contrast, accessible design system with glassmorphic cards and intuitive workflows.

## 🛠️ Tech Stack

- **Framework**: Laravel 11 / 12
- **Language**: PHP 8.2+
- **Frontend**: Blade Templating Engine + Vanilla CSS Design System
- **Database**: SQLite / MySQL
- **Mailing**: SMTP via Brevo

## 💻 Local Setup & Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Mathewphillip/kulima-agri-sacco.git
   cd kulima-agri-sacco
   ```

2. **Install PHP & Frontend Dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Environment Setup**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Run Migrations & Seeders**
   ```bash
   php artisan migrate --seed
   ```

5. **Start Development Server**
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000` in your browser.

## 👥 Default Accounts (Seeded)

- **Super Administrator**:
  - Email: `admin@pearlsacco.org`
  - Password: `password`

## 🛡️ Security & Support

For support or security inquiries, please contact `support@pearlsacco.org`.

## 📄 License

This software is developed for the Pearl SACCO Management System. All rights reserved.
