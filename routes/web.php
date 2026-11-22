<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\RepaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaccoController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/services', function () {
    return view('pages.services');
})->name('services');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Real-time email existence verification endpoint
Route::match(['get', 'post'], '/api/check-email', [EmailVerificationController::class, 'check'])->name('api.check-email');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.post');

    Route::get('forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view-dashboard');

    // Super Administrator - Multi-SACCO Management
    Route::middleware('permission:manage-saccos')->group(function () {
        Route::get('/saccos', [SaccoController::class, 'index'])->name('saccos.index');
        Route::get('/saccos/create', [SaccoController::class, 'create'])->name('saccos.create');
        Route::post('/saccos', [SaccoController::class, 'store'])->name('saccos.store');
        Route::get('/saccos/{sacco}', [SaccoController::class, 'show'])->name('saccos.show');
        Route::post('/saccos/{sacco}/approve', [SaccoController::class, 'approve'])->name('saccos.approve');
        Route::post('/saccos/{sacco}/toggle-status', [SaccoController::class, 'toggleStatus'])->name('saccos.toggle-status');
    });

    Route::middleware('permission:view-members')->group(function () {
        Route::post('members/{member}/open-savings', [MemberController::class, 'openSavingsAccount'])->name('members.open-savings');
        Route::resource('members', MemberController::class);
    });

    Route::middleware('permission:view-loans')->group(function () {
        Route::post('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve')->middleware('permission:approve-loans');
        Route::post('/loans/{loan}/apply-penalty', [LoanController::class, 'applyPenalty'])->name('loans.apply-penalty');
        Route::post('/loans/{loan}/flag-default', [LoanController::class, 'flagDefault'])->name('loans.flag-default');
        Route::resource('loans', LoanController::class);
    });

    Route::middleware('permission:record-repayments')->group(function () {
        Route::get('/repayments', [RepaymentController::class, 'index'])->name('repayments.index');
        Route::get('/loans/{loan}/repayments/create', [RepaymentController::class, 'create'])->name('loans.repayments.create');
        Route::post('/loans/{loan}/repayments', [RepaymentController::class, 'store'])->name('loans.repayments.store');
    });

    Route::middleware('permission:view-reports')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
        Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    });

    Route::middleware('permission:manage-settings')->group(function () {
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });

    Route::middleware('permission:manage-staff')->group(function () {
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    });

    Route::middleware('permission:view-savings')->group(function () {
        Route::get('/savings', [SavingsController::class, 'index'])->name('savings.index');
        Route::get('/savings/{saving}', [SavingsController::class, 'show'])->name('savings.show');
        Route::get('/savings/{saving}/transaction', [SavingsController::class, 'createTransaction'])->name('savings.transaction')->middleware('permission:transact-savings');
        Route::post('/savings/{saving}/transaction', [SavingsController::class, 'storeTransaction'])->name('savings.transaction.store')->middleware('permission:transact-savings');
    });

    // Member Self-Service Portal (Requirements MD-009, MD-014, MD-020, MD-021, MD-024, MD-026, MD-027, MD-028)
    Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');
    Route::post('/member/loans/apply', [MemberDashboardController::class, 'applyLoan'])->name('member.loans.apply');
    Route::get('/member/savings/statement', [MemberDashboardController::class, 'downloadSavingsStatement'])->name('member.savings.statement');
    Route::get('/member/loans/{loan}/statement', [MemberDashboardController::class, 'downloadLoanStatement'])->name('member.loans.statement');
    Route::post('/member/password', [MemberDashboardController::class, 'updatePassword'])->name('member.password.update');
});
