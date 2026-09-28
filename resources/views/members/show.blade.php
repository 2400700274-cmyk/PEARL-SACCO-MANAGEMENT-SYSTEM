@extends('components.layouts.app')

@section('title', 'Member Profile')

@section('content')
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('members.index') }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to Directory</a>
        <h1 style="margin: 0;">Member Profile: {{ $member->member_number }}</h1>
    </div>

    <div class="grid" style="grid-template-columns: 1fr 2fr; gap: 24px;">
        <!-- Left: Profile Summary -->
        <div class="card">
            <div class="card-header">Profile Details</div>
            
            <div style="text-align: center; margin-bottom: 24px;">
                @if($member->passport_photo_path)
                    <img src="{{ Storage::url($member->passport_photo_path) }}" alt="Passport Photo" style="width: 120px; height: 120px; border-radius: 8px; object-fit: cover; border: 3px solid var(--border-color); display: inline-block;">
                @else
                    <div style="width: 120px; height: 120px; border-radius: 8px; background-color: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 48px; margin: 0 auto;">
                        {{ substr($member->name, 0, 1) }}
                    </div>
                @endif
            </div>

            <div style="margin-bottom: 16px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Full Name</div>
                <div style="font-weight: 600; font-size: 16px;">{{ $member->name }}</div>
            </div>
            
            <div style="margin-bottom: 16px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Contact Number</div>
                <div>{{ $member->contact }}</div>
            </div>
            
            <div style="margin-bottom: 16px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Status</div>
                <div>
                    @if($member->status === 'Active')
                        <span class="badge badge-success">{{ $member->status }}</span>
                    @elseif($member->status === 'Suspended')
                        <span class="badge badge-warning">{{ $member->status }}</span>
                    @else
                        <span class="badge badge-info">{{ $member->status }}</span>
                    @endif
                </div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Registration Date</div>
                <div>{{ $member->registered_at->format('M d, Y') }}</div>
            </div>

            <div style="border-top: 1px solid var(--border-light); padding-top: 16px;">
                <a href="{{ route('members.edit', $member) }}" class="btn btn-secondary" style="width: 100%; text-align: center; margin-bottom: 8px;">Edit Profile</a>
            </div>
        </div>

        <!-- Right: Financial Summary -->
        <div>
            <div class="card">
                <div class="card-header">Financial Summary</div>
                <div class="grid grid-cols-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="stat-card" style="padding: 16px; border: 1px solid var(--border-light); border-radius: 4px;">
                        <span class="stat-label">Total Savings</span>
                        @if($member->savingsAccounts->count() > 0)
                            <span class="stat-value">UGX {{ number_format($member->savingsAccounts->first()->balance, 2) }}</span>
                            <a href="{{ route('savings.show', $member->savingsAccounts->first()) }}" style="font-size: 12px; margin-top: 8px;">View Savings Account &rarr;</a>
                        @else
                            <span class="stat-value">UGX 0.00</span>
                            <form method="POST" action="{{ route('members.open-savings', $member) }}" style="margin-top: 8px;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Open Savings Account</button>
                            </form>
                        @endif
                    </div>
                    <div class="stat-card" style="padding: 16px; border: 1px solid var(--border-light); border-radius: 4px;">
                        <span class="stat-label">Active Loans Balance</span>
                        @if($member->loans->count() > 0)
                            <span class="stat-value">UGX {{ number_format($member->loans->sum('balance'), 2) }}</span>
                            <a href="{{ route('loans.index') }}?search={{ $member->member_number }}" style="font-size: 12px; margin-top: 8px;">View Active Loans &rarr;</a>
                        @else
                            <span class="stat-value">UGX 0.00</span>
                            <span style="font-size: 12px; margin-top: 8px; color: var(--text-secondary);">No active loans</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">Recent Transactions</div>
                <div style="text-align: center; padding: 24px; color: var(--text-secondary);">
                    No transactions recorded yet.
                </div>
            </div>
        </div>
    </div>
@endsection
