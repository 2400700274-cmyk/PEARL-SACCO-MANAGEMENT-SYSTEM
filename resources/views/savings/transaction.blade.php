@extends('components.layouts.app')

@section('title', 'Record Transaction')

@section('content')
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('savings.show', $saving) }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to Account</a>
        <h1 style="margin: 0;">Record Transaction</h1>
    </div>

    <div class="card" style="max-width: 600px;">
        <div class="card-header">Transaction Details</div>
        
        <div style="margin-bottom: 24px; padding: 12px; background: var(--bg-color); border-radius: 4px; border: 1px solid var(--border-color);">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: var(--text-secondary); font-size: 13px;">Account</span>
                <span style="font-weight: 600;">SAV-{{ str_pad($saving->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: var(--text-secondary); font-size: 13px;">Member</span>
                <span style="font-weight: 600;">{{ $saving->member->name }}</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: var(--text-secondary); font-size: 13px;">Current Balance</span>
                <span style="font-weight: 600; color: var(--primary-color);">UGX {{ number_format($saving->balance, 2) }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('savings.transaction.store', $saving) }}">
            @csrf
            
            <div class="grid grid-cols-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label">Transaction Type</label>
                    <select name="type" class="form-control" required style="background: white;">
                        <option value="Deposit" {{ old('type') == 'Deposit' ? 'selected' : '' }}>Deposit</option>
                        <option value="Withdrawal" {{ old('type') == 'Withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                    </select>
                    @error('type')<span class="error-message">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Date</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" class="form-control" required>
                    @error('transaction_date')<span class="error-message">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label">Amount (UGX)</label>
                <input type="number" step="0.01" min="1" name="amount" value="{{ old('amount') }}" class="form-control" required placeholder="e.g. 50000">
                @error('amount')<span class="error-message">{{ $message }}</span>@enderror
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label">Description (Optional)</label>
                <input type="text" name="description" value="{{ old('description') }}" class="form-control" placeholder="e.g. Monthly contribution">
                @error('description')<span class="error-message">{{ $message }}</span>@enderror
            </div>

            <div style="display: flex; gap: 12px; border-top: 1px solid var(--border-light); padding-top: 16px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 24px;">Process Transaction</button>
                <a href="{{ route('savings.show', $saving) }}" class="btn btn-secondary" style="padding: 8px 24px;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
