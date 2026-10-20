@extends('components.layouts.app')

@section('title', 'SACCO Oversight - ' . $sacco->name)

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('saccos.index') }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to SACCOs Directory</a>
            <h1 style="margin: 0; font-size: 24px;">SACCO Details: {{ $sacco->name }}</h1>
        </div>

        <div style="display: flex; gap: 10px;">
            @if($sacco->status === 'Pending')
                <form method="POST" action="{{ route('saccos.approve', $sacco) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="background: #107c10; border-color: #107c10; font-weight: 600;">
                        Approve Application & Enable Access
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('saccos.toggle-status', $sacco) }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="font-weight: 600; color: {{ $sacco->status === 'Active' ? 'var(--danger-color)' : 'var(--success-color)' }};">
                        {{ $sacco->status === 'Active' ? 'Suspend SACCO Workspace' : 'Reactivate SACCO Workspace' }}
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #dff6dd; color: var(--success-color); padding: 14px 18px; border-radius: 6px; margin-bottom: 24px; border: 1px solid #c8e6c9; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Portfolio Metrics -->
    <div class="grid grid-cols-4" style="margin-bottom: 24px; gap: 16px;">
        <div class="card stat-card" style="padding: 18px;">
            <span class="stat-label">SACCO Status</span>
            <div style="margin-top: 6px;">
                @if($sacco->status === 'Active')
                    <span class="badge badge-success" style="font-size: 13px; padding: 4px 10px;">Active Workspace</span>
                @elseif($sacco->status === 'Pending')
                    <span class="badge badge-warning" style="background: #fff4ce; color: #795500; font-size: 13px; padding: 4px 10px;">Pending Authorization</span>
                @else
                    <span class="badge badge-danger" style="font-size: 13px; padding: 4px 10px;">Suspended</span>
                @endif
            </div>
        </div>

        <div class="card stat-card" style="padding: 18px;">
            <span class="stat-label">Registered Members</span>
            <span class="stat-value" style="font-size: 24px; color: var(--primary-color);">{{ $membersCount }}</span>
        </div>

        <div class="card stat-card" style="padding: 18px;">
            <span class="stat-label">Total Savings Balance</span>
            <span class="stat-value" style="font-size: 20px; color: #107c10;">UGX {{ number_format($totalSavings, 2) }}</span>
        </div>

        <div class="card stat-card" style="padding: 18px;">
            <span class="stat-label">Active Loans Balance</span>
            <span class="stat-value" style="font-size: 20px; color: #d13438;">UGX {{ number_format($activeLoans, 2) }}</span>
        </div>
    </div>

    <div class="grid" style="grid-template-columns: 1fr 2fr; gap: 24px;">
        <!-- Left: SACCO & Admin Info -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 16px 20px; font-weight: 600; color: var(--primary-color);">
                    SACCO Profile
                </div>
                <div style="padding: 20px;">
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Cooperative Name</div>
                        <div style="font-weight: 700; font-size: 16px;">{{ $sacco->name }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Registration Number</div>
                        <div style="font-family: monospace; font-size: 14px;">{{ $sacco->registration_number ?? 'Pending' }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Headquarters Address</div>
                        <div style="font-size: 14px;">{{ $sacco->address }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Official Phone</div>
                        <div style="font-size: 14px;">{{ $sacco->phone ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Registration Date</div>
                        <div style="font-size: 14px;">{{ $sacco->created_at->format('M d, Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 16px 20px; font-weight: 600; color: var(--primary-color);">
                    Assigned Administrator
                </div>
                <div style="padding: 20px;">
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Administrator Name</div>
                        <div style="font-weight: 600; font-size: 15px;">{{ $sacco->admin->name ?? 'None' }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Email Address</div>
                        <div style="font-size: 14px;">{{ $sacco->admin->email ?? 'N/A' }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Uganda National ID (NIN)</div>
                        <div style="font-family: monospace; font-size: 14px; color: var(--primary-color);">{{ $sacco->admin->nin ?? 'Not Provided' }}</div>
                    </div>

                    <div>
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Admin User Status</div>
                        <div>
                            <span class="badge badge-{{ $sacco->admin && $sacco->admin->status === 'Active' ? 'success' : 'warning' }}">
                                {{ $sacco->admin->status ?? 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Staff Members under this SACCO -->
        <div class="card">
            <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 16px 20px; font-weight: 600; color: var(--primary-color); display: flex; justify-content: space-between; align-items: center;">
                <span>SACCO Staff Members ({{ $sacco->admin && $sacco->admin->staff ? $sacco->admin->staff->count() : 0 }})</span>
            </div>
            
            <div class="table-container" style="padding: 12px;">
                <table>
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-light); text-align: left;">
                            <th>Staff Member</th>
                            <th>NIN</th>
                            <th>Allocated Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($sacco->admin && $sacco->admin->staff && $sacco->admin->staff->count() > 0)
                            @foreach($sacco->admin->staff as $staffMember)
                                <tr style="border-bottom: 1px solid var(--border-light);">
                                    <td style="padding: 12px 8px; font-weight: 600;">
                                        {{ $staffMember->name }}
                                        <div style="font-size: 11px; color: var(--text-secondary); font-weight: normal;">{{ $staffMember->email }}</div>
                                    </td>
                                    <td style="padding: 12px 8px; font-family: monospace; font-size: 13px;">{{ $staffMember->nin ?? 'N/A' }}</td>
                                    <td style="padding: 12px 8px;">
                                        <span style="font-size: 11px; font-weight: 600; color: var(--primary-color); background: rgba(0, 120, 212, 0.08); padding: 2px 8px; border-radius: 4px;">
                                            {{ $staffMember->role?->name ?? 'Staff' }}
                                        </span>
                                    </td>
                                    <td style="padding: 12px 8px;">
                                        <span class="badge badge-{{ $staffMember->status === 'Active' ? 'success' : 'warning' }}">{{ $staffMember->status }}</span>
                                    </td>
                                    <td style="padding: 12px 8px; font-size: 13px; color: var(--text-secondary);">
                                        {{ $staffMember->created_at->format('M d, Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-secondary);">
                                    No staff accounts have been allocated under this SACCO yet.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
