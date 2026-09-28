# Kulima Agri-SACCO

The premier operating system built specifically to digitize, secure, and scale agricultural cooperative societies across East Africa.

## 🚀 Features

- **Multi-Tenant Architecture**: Create isolated workspaces for different SACCOs securely.
- **Member Management**: Keep a unified digital registry of all members with National ID (NIN) tracking and profile photos.
- **Savings & Deposits**: Track member contributions accurately with automated balance calculations and complete transaction histories.
- **Loan & Credit Processing**: End-to-end credit management. Track applications, calculate interest, manage multi-stage approvals, and monitor repayments.
- **Role-Based Access Control (RBAC)**: Fine-grained permissions for administrators, loan officers, and tellers using Spatie Permissions.
- **Beautiful, Premium UI**: A modern, responsive, enterprise-grade design system built for professional environments.
- **Automated Notifications**: Welcome emails, credential dispatching, and password resets powered by Brevo.

## 🛠️ Tech Stack

- **Framework**: [Laravel 11](https://laravel.com)
- **Language**: PHP 8.2+
- **Frontend**: Blade Templating Engine + Vanilla CSS (Custom Design System)
- **Database**: MySQL / SQLite
- **Mailing**: SMTP via Brevo

## 💻 Local Setup & Installation

Follow these steps to get the project running on your local machine:

1. **Clone the repository**
   ```bash
   git clone https://github.com/Mathewphillip/kulima-agri-sacco.git
   cd kulima-agri-sacco
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Environment Setup**
   Copy the example environment file and generate a new application key:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   Update your `.env` file with your database credentials. 
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kulima_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Mail Configuration (Brevo)**
   Ensure your SMTP settings are configured in the `.env` to allow email sending (e.g., Staff welcome emails):
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp-relay.brevo.com
   MAIL_PORT=587
   MAIL_USERNAME=bb8388001@smtp-brevo.com
   MAIL_PASSWORD=your_brevo_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="mathewx027@gmail.com"
   MAIL_FROM_NAME="kulima agri-SACCO"
   ```

6. **Run Migrations & Seeders**
   This will set up the database schema and inject the required default roles and permissions:
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Link Storage**
   Link the storage directory to allow public access to uploaded member and staff profile photos:
   ```bash
   php artisan storage:link
   ```

8. **Start the Development Server**
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000` in your browser.

## 👥 Usage Workflow

1. Navigate to the **Home Page** and click **Register SACCO**.
2. Fill in the organization details and the primary administrator's account information.
3. Upon registration, log in and you will be directed to the dashboard.
4. From the dashboard, administrators can create new Staff accounts (which auto-emails their credentials) and configure System Settings.
5. Begin registering members and managing financial workflows.

## 🛡️ Security & Support

If you discover any security-related issues, please contact the administrative team directly at `support@kulima.app` instead of using the issue tracker.

## 📄 License

This project is proprietary software developed for Kulima Agri-SACCO. All rights reserved.
