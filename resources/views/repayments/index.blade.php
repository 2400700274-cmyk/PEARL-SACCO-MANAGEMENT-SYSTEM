@extends('components.layouts.app')

@section('title', 'Repayments')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1>Repayments Directory</h1>
            <div style="font-size: 12px; color: var(--text-secondary);">History of all loan repayments across the SACCO</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <span>Repayment Ledger</span>
            <div>
                <input type="text" placeholder="Search repayments..." style="padding: 6px 12px; border: 1px solid var(--border-color); border-radius: 2px;">
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Receipt No.</th>
                        <th>Date</th>
                        <th>Member Name</th>
                        <th>Loan ID</th>
                        <th>Amount Paid (UGX)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($repayments as $repayment)
                        <tr>
                            <td style="font-weight: 600; color: var(--text-secondary);">RCPT-{{ str_pad($repayment->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $repayment->paid_at->format('M d, Y') }}</td>
                            <td><a href="{{ route('members.show', $repayment->loan->member) }}">{{ $repayment->loan->member->name }}</a></td>
                            <td><a href="{{ route('loans.show', $repayment->loan) }}">LN-{{ str_pad($repayment->loan_id, 5, '0', STR_PAD_LEFT) }}</a></td>
                            <td style="font-weight: 600; color: var(--success-color);">{{ number_format($repayment->amount, 2) }}</td>
                            <td><span class="badge badge-success">{{ $repayment->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 32px; color: var(--text-secondary);">
                                <div style="margin-bottom: 8px; font-size: 24px;">💸</div>
                                No repayments recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($repayments->hasPages())
            <div style="padding: 16px; border-top: 1px solid var(--border-light);">
                {{ $repayments->links() }}
            </div>
        @endif
    </div>
@endsection
