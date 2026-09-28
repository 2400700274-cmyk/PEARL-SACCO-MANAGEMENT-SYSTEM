<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;

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

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::get('register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.post');

    Route::get('forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:view-dashboard');

    Route::middleware('permission:view-members')->group(function () {
        Route::post('members/{member}/open-savings', [MemberController::class, 'openSavingsAccount'])->name('members.open-savings');
        Route::resource('members', MemberController::class);
    });
    
    Route::middleware('permission:view-loans')->group(function () {
        Route::post('/loans/{loan}/approve', [\App\Http\Controllers\LoanController::class, 'approve'])->name('loans.approve')->middleware('permission:approve-loans');
        Route::resource('loans', \App\Http\Controllers\LoanController::class);
    });
    
    Route::middleware('permission:record-repayments')->group(function () {
        Route::get('/repayments', [\App\Http\Controllers\RepaymentController::class, 'index'])->name('repayments.index');
        Route::get('/loans/{loan}/repayments/create', [\App\Http\Controllers\RepaymentController::class, 'create'])->name('loans.repayments.create');
        Route::post('/loans/{loan}/repayments', [\App\Http\Controllers\RepaymentController::class, 'store'])->name('loans.repayments.store');
    });
    
    Route::middleware('permission:view-reports')->group(function () {
        Route::get('/reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export/pdf', [\App\Http\Controllers\ReportController::class, 'exportPdf'])->name('reports.export.pdf');
        Route::get('/reports/export/excel', [\App\Http\Controllers\ReportController::class, 'exportExcel'])->name('reports.export.excel');
    });
    
    Route::middleware('permission:manage-settings')->group(function () {
        Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    });
    
    Route::middleware('permission:manage-staff')->group(function () {
        Route::get('/staff', [\App\Http\Controllers\StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [\App\Http\Controllers\StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff', [\App\Http\Controllers\StaffController::class, 'store'])->name('staff.store');
    });
    
    Route::middleware('permission:view-savings')->group(function () {
        Route::get('/savings', [\App\Http\Controllers\SavingsController::class, 'index'])->name('savings.index');
        Route::get('/savings/{saving}', [\App\Http\Controllers\SavingsController::class, 'show'])->name('savings.show');
        Route::get('/savings/{saving}/transaction', [\App\Http\Controllers\SavingsController::class, 'createTransaction'])->name('savings.transaction')->middleware('permission:transact-savings');
        Route::post('/savings/{saving}/transaction', [\App\Http\Controllers\SavingsController::class, 'storeTransaction'])->name('savings.transaction.store')->middleware('permission:transact-savings');
    });
});
