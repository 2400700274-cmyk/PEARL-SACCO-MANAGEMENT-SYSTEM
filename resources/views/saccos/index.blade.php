@extends('components.layouts.app')

@section('title', 'Manage SACCOs - Pearl SACCO Management System')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                <h1 style="font-size: 24px; color: var(--primary-color); margin: 0;">SACCO Governance & Directory</h1>
                <span style="font-size: 12px; font-weight: 600; color: #107c10; background: #dff6dd; border: 1px solid #b7ebb4; padding: 3px 10px; border-radius: 12px;">
                    Pearl Master System
                </span>
            </div>
            <div style="font-size: 13px; color: var(--text-secondary);">
                Central oversight of all registered, active, and pending SACCO cooperatives across Uganda.
            </div>
        </div>
        <div>
            <a href="{{ route('saccos.create') }}" class="btn btn-primary" style="padding: 10px 20px; font-weight: 600;">
                + Register New SACCO
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #dff6dd; color: var(--success-color); padding: 14px 18px; border-radius: 6px; margin-bottom: 24px; border: 1px solid #c8e6c9; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <!-- System-Wide Metrics (Modification 7) -->
    <div class="grid grid-cols-4" style="margin-bottom: 32px; gap: 20px;">
        <div class="card stat-card" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 22px;">
            <div>
                <div class="stat-label" style="font-size: 13px; font-weight: 600;">Total SACCOs Managed</div>
                <div class="stat-value" style="font-size: 30px; color: var(--primary-color); font-weight: 800;">{{ $metrics['total_saccos'] }}</div>
                <div style="font-size: 11px; color: var(--text-secondary); margin-top: 4px;">{{ $metrics['active_saccos'] }} Active • {{ $metrics['pending_saccos'] }} Pending</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 8px; background: rgba(0, 120, 212, 0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            </div>
        </div>

        <div class="card stat-card" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 22px;">
            <div>
                <div class="stat-label" style="font-size: 13px; font-weight: 600;">Pending Applications</div>
                <div class="stat-value" style="font-size: 30px; color: {{ $metrics['pending_saccos'] > 0 ? '#d83b01' : '#107c10' }}; font-weight: 800;">
                    {{ $metrics['pending_saccos'] }}
                </div>
                <div style="font-size: 11px; color: var(--text-secondary); margin-top: 4px;">Awaiting verification</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 8px; background: #fff4ce; color: #d83b01; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            </div>
        </div>

        <div class="card stat-card" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 22px;">
            <div>
                <div class="stat-label" style="font-size: 13px; font-weight: 600;">Total Members Registered</div>
                <div class="stat-value" style="font-size: 30px; color: #107c10; font-weight: 800;">{{ $metrics['total_members'] }}</div>
                <div style="font-size: 11px; color: var(--text-secondary); margin-top: 4px;">Across all SACCOs</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 8px; background: #dff6dd; color: #107c10; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
        </div>

        <div class="card stat-card" style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; padding: 22px;">
            <div>
                <div class="stat-label" style="font-size: 13px; font-weight: 600;">Total System Savings</div>
                <div class="stat-value" style="font-size: 20px; color: var(--primary-color); font-weight: 800;">UGX {{ number_format($metrics['total_savings'], 0) }}</div>
                <div style="font-size: 11px; color: var(--text-secondary); margin-top: 4px;">Credit: UGX {{ number_format($metrics['total_loans'], 0) }}</div>
            </div>
            <div style="width: 48px; height: 48px; border-radius: 8px; background: rgba(0, 120, 212, 0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            </div>
        </div>
    </div>

    <!-- SACCOs Table -->
    <div class="card">
        <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 18px 24px; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; font-size: 16px; color: var(--primary-color);">Registered SACCOs List</h2>
            <span style="font-size: 13px; color: var(--text-secondary);">Showing {{ $saccos->count() }} of {{ $saccos->total() }} SACCO(s)</span>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-light); text-align: left;">
                        <th style="padding: 14px 16px;">SACCO Name</th>
                        <th style="padding: 14px 16px;">Reg Number</th>
                        <th style="padding: 14px 16px;">Administrator</th>
                        <th style="padding: 14px 16px;">Members</th>
                        <th style="padding: 14px 16px;">Status</th>
                        <th style="padding: 14px 16px;">Registered On</th>
                        <th style="padding: 14px 16px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($saccos as $sacco)
                        <tr style="border-bottom: 1px solid var(--border-light);">
                            <td style="padding: 14px 16px; font-weight: 600; color: var(--primary-color);">
                                <a href="{{ route('saccos.show', $sacco) }}" style="text-decoration: none; color: inherit;">
                                    {{ $sacco->name }}
                                </a>
                                @if($sacco->address)
                                    <div style="font-size: 11px; color: var(--text-secondary); font-weight: normal;">{{ Str::limit($sacco->address, 30) }}</div>
                                @endif
                            </td>
                            <td style="padding: 14px 16px; font-family: monospace; font-size: 13px;">
                                {{ $sacco->registration_number ?? 'Pending' }}
                            </td>
                            <td style="padding: 14px 16px;">
                                <div>{{ $sacco->admin->name ?? 'N/A' }}</div>
                                <div style="font-size: 11px; color: var(--text-secondary);">{{ $sacco->email ?? $sacco->admin->email ?? 'N/A' }}</div>
                            </td>
                            <td style="padding: 14px 16px; font-weight: 600;">
                                {{ $sacco->members_count ?? 0 }}
                            </td>
                            <td style="padding: 14px 16px;">
                                @if($sacco->status === 'Active')
                                    <span class="badge badge-success">Active</span>
                                @elseif($sacco->status === 'Pending')
                                    <span class="badge badge-warning" style="background: #fff4ce; color: #795500;">Pending Approval</span>
                                @else
                                    <span class="badge badge-danger">Suspended</span>
                                @endif
                            </td>
                            <td style="padding: 14px 16px; font-size: 13px; color: var(--text-secondary);">
                                {{ $sacco->created_at->format('M d, Y') }}
                            </td>
                            <td style="padding: 14px 16px; text-align: right;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    @if($sacco->status === 'Pending')
                                        <form method="POST" action="{{ route('saccos.approve', $sacco) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-primary" style="background: #107c10; border-color: #107c10; font-size: 12px; padding: 4px 10px;">
                                                Approve
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('saccos.toggle-status', $sacco) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary" style="font-size: 12px; padding: 4px 10px; color: {{ $sacco->status === 'Active' ? 'var(--danger-color)' : 'var(--success-color)' }};">
                                                {{ $sacco->status === 'Active' ? 'Suspend' : 'Activate' }}
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('saccos.show', $sacco) }}" class="btn btn-secondary" style="font-size: 12px; padding: 4px 10px;">
                                        View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 48px; color: var(--text-secondary);">
                                No SACCOs registered in the system yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($saccos->hasPages())
            <div style="padding: 16px 24px; border-top: 1px solid var(--border-light);">
                {{ $saccos->links() }}
            </div>
        @endif
    </div>
@endsection
