@extends('components.layouts.app')

@section('title', 'Record Repayment')

@section('content')
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('loans.show', $loan) }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to Loan</a>
        <h1 style="margin: 0;">Record Loan Repayment</h1>
    </div>

    <div class="card" style="max-width: 600px;">
        <div class="card-header">Repayment Details</div>
        
        <div style="margin-bottom: 24px; padding: 12px; background: var(--bg-color); border-radius: 4px; border: 1px solid var(--border-color);">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: var(--text-secondary); font-size: 13px;">Loan ID</span>
                <span style="font-weight: 600;">LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: var(--text-secondary); font-size: 13px;">Member</span>
                <span style="font-weight: 600;">{{ $loan->member->name }}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: var(--text-secondary); font-size: 13px;">Outstanding Balance</span>
                <span style="font-weight: 600; color: var(--danger-color);">UGX {{ number_format($loan->balance, 2) }}</span>
            </div>
        </div>
        
        <form method="POST" action="{{ route('loans.repayments.store', $loan) }}">
            @csrf
            
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600;">Payment Date</label>
                <input type="date" name="paid_at" value="{{ old('paid_at', date('Y-m-d')) }}" class="form-control" style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;" required>
                @error('paid_at')<span style="color: var(--danger-color); font-size: 12px;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600;">Amount Paid (UGX)</label>
                <input type="number" step="0.01" min="1" max="{{ $loan->balance }}" name="amount" value="{{ old('amount') }}" class="form-control" style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;" required placeholder="Maximum: {{ $loan->balance }}">
                @error('amount')<span style="color: var(--danger-color); font-size: 12px;">{{ $message }}</span>@enderror
            </div>

            <div style="display: flex; gap: 12px; border-top: 1px solid var(--border-light); padding-top: 16px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 24px; background-color: var(--success-color); border-color: var(--success-color);">Process Repayment</button>
                <a href="{{ route('loans.show', $loan) }}" class="btn btn-secondary" style="padding: 8px 24px;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
