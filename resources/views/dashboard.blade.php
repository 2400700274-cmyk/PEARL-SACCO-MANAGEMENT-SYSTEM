@extends('components.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                <h1 style="font-size: 24px; color: var(--primary-color); margin: 0;">Dashboard</h1>
                <span style="font-size: 12px; font-weight: 600; color: var(--primary-color); background: rgba(0, 120, 212, 0.1); border: 1px solid rgba(0, 120, 212, 0.2); padding: 3px 10px; border-radius: 12px;">
                    Role: {{ auth()->user()->role?->name ?? 'Staff' }}
                </span>
            </div>
            <div style="font-size: 13px; color: var(--text-secondary);">
                Welcome back, <strong>{{ auth()->user()->name }}</strong>. Overview of {{ \App\Models\Setting::getValue('sacco_name', 'SACCO') }} Operations.
            </div>
        </div>
        <div style="font-size: 13px; color: var(--text-secondary);">
            {{ date('l, F j, Y') }}
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-4" style="margin-bottom: 32px;">
        <div class="card stat-card" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 24px;">
            <div>
                <div class="stat-label" style="font-size: 13px; font-weight: 500;">Total Members</div>
                <div class="stat-value" style="font-size: 28px; color: var(--primary-color);">{{ $metrics['total_members'] }}</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 8px; background: rgba(0, 120, 212, 0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
        </div>
        
        <div class="card stat-card" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 24px;">
            <div>
                <div class="stat-label" style="font-size: 13px; font-weight: 500;">Active Loans</div>
                <div class="stat-value" style="font-size: 28px; color: #107c10;">{{ $metrics['active_loans'] }}</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 8px; background: #dff6dd; color: #107c10; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
            </div>
        </div>
        
        <div class="card stat-card" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 24px;">
            <div>
                <div class="stat-label" style="font-size: 13px; font-weight: 500;">Outstanding Balance</div>
                <div class="stat-value" style="font-size: 24px; color: #d83b01;">UGX {{ number_format($metrics['outstanding_balance'], 0) }}</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 8px; background: #fde7e9; color: #d83b01; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
        </div>
        
        <div class="card stat-card" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 24px;">
            <div>
                <div class="stat-label" style="font-size: 13px; font-weight: 500;">Savings Balance</div>
                <div class="stat-value" style="font-size: 24px; color: #107c10;">UGX {{ number_format($metrics['savings_balance'], 0) }}</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 8px; background: #dff6dd; color: #107c10; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid" style="grid-template-columns: 2fr 1fr; gap: 24px;">
        <!-- Operational Section -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="card" style="padding: 0; overflow: hidden;">
                <div class="card-header" style="padding: 16px 20px; margin: 0; background-color: #f8f9fa; font-size: 15px; color: var(--primary-color);">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Latest Members Registered
                    </div>
                </div>
                
                <div class="table-container">
                    <table style="margin: 0;">
                        <thead style="background: white;">
                            <tr>
                                <th style="padding: 12px 20px; font-weight: 500;">Member Name</th>
                                <th style="padding: 12px 20px; font-weight: 500;">Registration Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMembers as $member)
                                <tr>
                                    <td style="padding: 12px 20px;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #e9ecef; display: flex; align-items: center; justify-content: center; font-weight: 600; color: var(--primary-color); font-size: 12px;">
                                                {{ substr($member->name, 0, 1) }}
                                            </div>
                                            {{ $member->name }}
                                        </div>
                                    </td>
                                    <td style="padding: 12px 20px; color: var(--text-secondary);">{{ $member->member_number }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" style="text-align: center; padding: 24px; color: var(--text-secondary);">No members found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card" style="padding: 0; overflow: hidden;">
                <div class="card-header" style="padding: 16px 20px; margin: 0; background-color: #f8f9fa; font-size: 15px; color: var(--primary-color);">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        Latest Loan Applications
                    </div>
                </div>
                <div class="table-container">
                    <table style="margin: 0;">
                        <thead style="background: white;">
                            <tr>
                                <th style="padding: 12px 20px; font-weight: 500;">Member</th>
                                <th style="padding: 12px 20px; font-weight: 500;">Amount (UGX)</th>
                                <th style="padding: 12px 20px; font-weight: 500;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLoans as $loan)
                                <tr>
                                    <td style="padding: 12px 20px;">{{ $loan->member->name }}</td>
                                    <td style="padding: 12px 20px; font-weight: 500;">{{ number_format($loan->principal_amount, 0) }}</td>
                                    <td style="padding: 12px 20px;">
                                        <span class="badge badge-{{ $loan->status == 'Active' ? 'success' : ($loan->status == 'Pending' ? 'warning' : 'info') }}" style="padding: 4px 10px; {{ $loan->status == 'Pending' ? 'background: #fff4ce; color: #795500;' : '' }}">
                                            {{ $loan->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" style="text-align: center; padding: 24px; color: var(--text-secondary);">No loans found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div>
            <div class="card" style="padding: 0; overflow: hidden;">
                <div class="card-header" style="padding: 16px 20px; margin: 0; border-bottom: 1px solid var(--border-light); font-size: 15px; color: var(--primary-color);">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                        Quick Actions
                    </div>
                </div>
                <div style="display: flex; flex-direction: column;">
                    <a href="{{ route('members.create') }}" style="display: flex; align-items: center; gap: 12px; padding: 16px 20px; color: var(--text-primary); text-decoration: none; border-bottom: 1px solid var(--border-light); transition: background 0.2s;">
                        <div style="width: 32px; height: 32px; border-radius: 6px; background: rgba(0,120,212,0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        </div>
                        <span style="font-weight: 500;">Register New Member</span>
                    </a>
                    
                    <a href="{{ route('loans.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 16px 20px; color: var(--text-primary); text-decoration: none; border-bottom: 1px solid var(--border-light); transition: background 0.2s;">
                        <div style="width: 32px; height: 32px; border-radius: 6px; background: rgba(0,120,212,0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <span style="font-weight: 500;">Manage Loan Applications</span>
                    </a>
                    
                    <a href="{{ route('savings.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 16px 20px; color: var(--text-primary); text-decoration: none; border-bottom: 1px solid var(--border-light); transition: background 0.2s;">
                        <div style="width: 32px; height: 32px; border-radius: 6px; background: rgba(0,120,212,0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
                        </div>
                        <span style="font-weight: 500;">Manage Savings</span>
                    </a>
                    
                    <a href="{{ route('repayments.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 16px 20px; color: var(--text-primary); text-decoration: none; transition: background 0.2s;">
                        <div style="width: 32px; height: 32px; border-radius: 6px; background: rgba(0,120,212,0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <span style="font-weight: 500;">View Repayment Ledger</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card a:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection
