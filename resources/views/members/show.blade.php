@extends('components.layouts.app')

@section('title', 'Member Profile - ' . $member->member_number)

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('members.index') }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to Directory</a>
            <h1 style="margin: 0; font-size: 24px;">Member Profile: {{ $member->member_number }}</h1>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('member.dashboard', ['member_id' => $member->id]) }}" class="btn btn-secondary" style="font-weight: 600;">Open Member Portal &rarr;</a>
            <a href="{{ route('members.edit', $member) }}" class="btn btn-secondary">Edit Profile</a>
            @if($member->status === 'Active')
                <a href="{{ route('loans.create') }}" class="btn btn-primary">+ Apply for Loan</a>
            @endif
        </div>
    </div>

    @if($member->status !== 'Active')
        <div style="background-color: #fff4ce; border-left: 4px solid var(--warning-color); padding: 14px 20px; border-radius: 6px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--warning-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            <div>
                <strong>Account Status: {{ $member->status }}</strong> — Suspended and inactive member accounts are restricted by policy. They cannot receive loan disbursements or perform savings deposits and withdrawals.
            </div>
        </div>
    @endif

    <div class="grid" style="grid-template-columns: 1fr 2fr; gap: 24px;">
        <!-- Left: Profile Summary -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 16px 20px; font-weight: 600; color: var(--primary-color);">Member Details</div>
                
                <div style="padding: 20px;">
                    <div style="text-align: center; margin-bottom: 20px;">
                        @if($member->passport_photo_path)
                            <img src="{{ Storage::url($member->passport_photo_path) }}" alt="Passport Photo" style="width: 110px; height: 110px; border-radius: 8px; object-fit: cover; border: 3px solid var(--border-color); display: inline-block;">
                        @else
                            <div style="width: 110px; height: 110px; border-radius: 8px; background-color: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 42px; margin: 0 auto;">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Full Name</div>
                        <div style="font-weight: 600; font-size: 15px;">{{ $member->name }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">National ID (NIN)</div>
                        <div style="font-weight: 600; font-family: monospace; font-size: 14px; color: var(--primary-color);">{{ $member->nin ?? 'Not Provided' }}</div>
                    </div>
                    
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Contact Number</div>
                        <div style="font-size: 14px;">{{ $member->contact }}</div>
                    </div>
                    
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Account Status</div>
                        <div>
                            @if($member->status === 'Active')
                                <span class="badge badge-success">{{ $member->status }}</span>
                            @elseif($member->status === 'Suspended')
                                <span class="badge badge-danger">{{ $member->status }}</span>
                            @else
                                <span class="badge badge-warning">{{ $member->status }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Registration Date</div>
                        <div style="font-size: 14px;">{{ $member->registered_at ? $member->registered_at->format('M d, Y') : 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Next of Kin Card (Modification 4) -->
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 16px 20px; font-weight: 600; color: var(--primary-color); display: flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Next of Kin Details
                </div>
                <div style="padding: 20px;">
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Name</div>
                        <div style="font-weight: 600; font-size: 14px;">{{ $member->next_of_kin_name ?? 'Not Registered' }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Relationship</div>
                        <div style="font-size: 14px;">{{ $member->next_of_kin_relationship ?? 'N/A' }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Contact Phone</div>
                        <div style="font-size: 14px;">{{ $member->next_of_kin_contact ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Address</div>
                        <div style="font-size: 14px;">{{ $member->next_of_kin_address ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Financial Summary & Accounts -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 16px 20px; font-weight: 600; color: var(--primary-color);">Financial Summary</div>
                <div style="padding: 20px;">
                    <div class="grid grid-cols-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="stat-card" style="padding: 18px; border: 1px solid var(--border-light); border-radius: 8px; background: #faf9f8;">
                            <span class="stat-label">Total Savings Balance</span>
                            @if($member->savingsAccounts->count() > 0)
                                <span class="stat-value" style="color: #107c10; font-size: 24px;">UGX {{ number_format($member->savingsAccounts->first()->balance, 2) }}</span>
                                <div style="margin-top: 10px;">
                                    <a href="{{ route('savings.show', $member->savingsAccounts->first()) }}" style="font-size: 13px; font-weight: 600;">View Savings Account &rarr;</a>
                                </div>
                            @else
                                <span class="stat-value">UGX 0.00</span>
                                @if($member->status === 'Active')
                                    <form method="POST" action="{{ route('members.open-savings', $member) }}" style="margin-top: 10px;">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">Open Savings Account</button>
                                    </form>
                                @else
                                    <span style="font-size: 12px; color: var(--text-secondary); margin-top: 6px; display: block;">Cannot open account (Member {{ $member->status }})</span>
                                @endif
                            @endif
                        </div>

                        <div class="stat-card" style="padding: 18px; border: 1px solid var(--border-light); border-radius: 8px; background: #faf9f8;">
                            <span class="stat-label">Active Loans Balance</span>
                            @if($member->loans->where('status', 'Active')->count() > 0)
                                <span class="stat-value" style="color: #d13438; font-size: 24px;">UGX {{ number_format($member->loans->where('status', 'Active')->sum('balance'), 2) }}</span>
                                <div style="margin-top: 10px;">
                                    <span style="font-size: 12px; color: var(--text-secondary);">{{ $member->loans->where('status', 'Active')->count() }} Active Loan(s)</span>
                                </div>
                            @else
                                <span class="stat-value" style="color: #605e5c; font-size: 24px;">UGX 0.00</span>
                                <span style="font-size: 12px; margin-top: 10px; color: var(--text-secondary); display: block;">No active outstanding loans</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 16px 20px; font-weight: 600; color: var(--primary-color);">Member Loans Record</div>
                <div style="padding: 20px;">
                    @if($member->loans->count() > 0)
                        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--border-light); text-align: left; color: var(--text-secondary);">
                                    <th style="padding: 8px;">Loan #</th>
                                    <th style="padding: 8px;">Principal</th>
                                    <th style="padding: 8px;">Balance</th>
                                    <th style="padding: 8px;">Due Date</th>
                                    <th style="padding: 8px;">Status</th>
                                    <th style="padding: 8px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($member->loans as $loan)
                                    <tr style="border-bottom: 1px solid var(--border-light);">
                                        <td style="padding: 10px 8px; font-weight: 600;">#{{ $loan->id }}</td>
                                        <td style="padding: 10px 8px;">UGX {{ number_format($loan->principal_amount, 2) }}</td>
                                        <td style="padding: 10px 8px; font-weight: 600; color: {{ $loan->balance > 0 ? '#d13438' : '#107c10' }};">UGX {{ number_format($loan->balance, 2) }}</td>
                                        <td style="padding: 10px 8px;">{{ $loan->due_date ? $loan->due_date->format('M d, Y') : 'N/A' }}</td>
                                        <td style="padding: 10px 8px;">
                                            <span class="badge badge-{{ $loan->status === 'Active' ? 'success' : ($loan->status === 'Defaulted' ? 'danger' : 'info') }}">{{ $loan->status }}</span>
                                        </td>
                                        <td style="padding: 10px 8px;">
                                            <a href="{{ route('loans.show', $loan) }}" style="font-weight: 600;">Track &rarr;</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div style="text-align: center; padding: 24px; color: var(--text-secondary);">
                            No loans recorded for this member.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
