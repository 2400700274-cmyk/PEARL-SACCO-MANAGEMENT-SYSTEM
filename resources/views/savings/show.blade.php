@extends('components.layouts.app')

@section('title', 'Savings Account Details')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('savings.index') }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to Directory</a>
            <h1 style="margin: 0;">Savings Account: SAV-{{ str_pad($saving->id, 5, '0', STR_PAD_LEFT) }}</h1>
        </div>
        <a href="{{ route('savings.transaction', $saving) }}" class="btn btn-primary">+ New Transaction</a>
    </div>

    @if(session('success'))
        <div style="background-color: #dff6dd; color: var(--success-color); padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; border: 1px solid #c8e6c9;">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid" style="grid-template-columns: 1fr 3fr; gap: 24px;">
        <!-- Left: Account Summary -->
        <div class="card">
            <div class="card-header">Account Summary</div>
            
            <div style="margin-bottom: 16px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Member Name</div>
                <div style="font-weight: 600;"><a href="{{ route('members.show', $saving->member) }}">{{ $saving->member->name }}</a></div>
            </div>
            
            <div style="margin-bottom: 16px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Member Number</div>
                <div>{{ $saving->member->member_number }}</div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Current Balance</div>
                <div style="font-size: 24px; font-weight: 600; color: var(--primary-color);">
                    UGX {{ number_format($saving->balance, 2) }}
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Status</div>
                <div>
                    @if($saving->status === 'Active')
                        <span class="badge badge-success">{{ $saving->status }}</span>
                    @else
                        <span class="badge badge-warning">{{ $saving->status }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Transactions Ledger -->
        <div class="card">
            <div class="card-header">Transaction History</div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Amount (UGX)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($saving->transactions as $tx)
                            <tr>
                                <td>{{ $tx->transaction_date->format('M d, Y') }}</td>
                                <td>
                                    @if($tx->type === 'Deposit')
                                        <span class="badge badge-success">Deposit</span>
                                    @else
                                        <span class="badge badge-warning">Withdrawal</span>
                                    @endif
                                </td>
                                <td>{{ $tx->description ?: '-' }}</td>
                                <td style="font-weight: 600; color: {{ $tx->type === 'Deposit' ? 'var(--success-color)' : 'var(--danger-color)' }};">
                                    {{ $tx->type === 'Deposit' ? '+' : '-' }}{{ number_format($tx->amount, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 24px; color: var(--text-secondary);">
                                    No transactions recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
