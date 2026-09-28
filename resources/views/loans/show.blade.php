@extends('components.layouts.app')

@section('title', 'Loan Details')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('loans.index') }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to Directory</a>
            <h1 style="margin: 0;">Loan Profile: LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</h1>
        </div>
        
        @if($loan->status === 'Pending' && auth()->user()->hasPermission('approve-loans'))
            <form method="POST" action="{{ route('loans.approve', $loan) }}">
                @csrf
                <button type="submit" class="btn btn-primary" style="background-color: var(--success-color); border-color: var(--success-color);">Approve Loan</button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div style="background-color: #dff6dd; color: var(--success-color); padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; border: 1px solid #c8e6c9;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background-color: #fde7e9; color: var(--danger-color); padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; border: 1px solid #f8c9ce;">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid" style="grid-template-columns: 1fr 2fr; gap: 24px;">
        <!-- Left: Loan Summary -->
        <div class="card">
            <div class="card-header">Loan Details</div>
            
            <div style="margin-bottom: 16px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Member</div>
                <div style="font-weight: 600;"><a href="{{ route('members.show', $loan->member) }}">{{ $loan->member->name }} ({{ $loan->member->member_number }})</a></div>
            </div>
            
            <div style="margin-bottom: 16px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Status</div>
                <div>
                    @if($loan->status === 'Active')
                        <span class="badge badge-success">{{ $loan->status }}</span>
                    @elseif($loan->status === 'Pending')
                        <span class="badge badge-warning" style="background: #fff4ce; color: #795500;">{{ $loan->status }}</span>
                    @else
                        <span class="badge badge-info">{{ $loan->status }}</span>
                    @endif
                </div>
            </div>
            
            <div style="margin-bottom: 16px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Principal Amount</div>
                <div style="font-size: 18px; font-weight: 600;">UGX {{ number_format($loan->principal_amount, 2) }}</div>
            </div>
            
            <div class="grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <div style="font-size: 12px; color: var(--text-secondary);">Interest Rate</div>
                    <div style="font-weight: 600;">{{ number_format($loan->interest_rate, 2) }}% (Flat)</div>
                </div>
                <div>
                    <div style="font-size: 12px; color: var(--text-secondary);">Duration</div>
                    <div style="font-weight: 600;">{{ $loan->duration_months }} Months</div>
                </div>
            </div>
            
            <div style="margin-bottom: 16px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Total Payable (Principal + Interest)</div>
                <div style="font-size: 14px; font-weight: 600; color: var(--text-primary);">UGX {{ number_format($loan->total_payable, 2) }}</div>
            </div>

            <div style="margin-bottom: 24px;">
                <div style="font-size: 12px; color: var(--text-secondary);">Outstanding Balance</div>
                <div style="font-size: 24px; font-weight: 600; color: var(--primary-color);">UGX {{ number_format($loan->balance, 2) }}</div>
            </div>
            
            @if($loan->approved_at)
                <div style="margin-bottom: 16px; border-top: 1px solid var(--border-light); padding-top: 16px;">
                    <div style="font-size: 12px; color: var(--text-secondary);">Approval Date</div>
                    <div>{{ $loan->approved_at->format('M d, Y H:i') }}</div>
                </div>
            @endif
        </div>

        <!-- Right: Repayments Ledger -->
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <span>Repayment Schedule / History</span>
                @if($loan->status === 'Active')
                    <a href="{{ route('loans.repayments.create', $loan) }}" class="btn btn-secondary" style="font-size: 12px; padding: 4px 8px;">Record Repayment</a>
                @endif
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount (UGX)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loan->repayments as $repayment)
                            <tr>
                                <td>{{ $repayment->paid_at->format('M d, Y') }}</td>
                                <td style="font-weight: 600; color: var(--success-color);">{{ number_format($repayment->amount, 2) }}</td>
                                <td><span class="badge badge-success">{{ $repayment->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 32px; color: var(--text-secondary);">
                                    No repayments recorded yet.<br>
                                    <span style="font-size: 12px;">Repayment module is scheduled for future implementation.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
