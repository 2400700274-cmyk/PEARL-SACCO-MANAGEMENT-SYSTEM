@extends('components.layouts.app')

@section('title', 'New Loan Application')

@section('content')
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('loans.index') }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to Directory</a>
        <h1 style="margin: 0;">New Loan Application</h1>
    </div>

    <div class="card" style="max-width: 600px;">
        <div class="card-header">Application Details</div>
        
        <form method="POST" action="{{ route('loans.store') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Select Member</label>
                <select name="member_id" class="form-control" required autofocus>
                    <option value="">-- Choose Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->member_number }} - {{ $member->name }}
                        </option>
                    @endforeach
                </select>
                @error('member_id')<span style="color: var(--danger-color); font-size: 12px;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Requested Principal Amount (UGX)</label>
                <input type="number" step="0.01" min="1000" name="principal_amount" value="{{ old('principal_amount') }}" class="form-control" required placeholder="e.g. 500000">
                @error('principal_amount')<span style="color: var(--danger-color); font-size: 12px;">{{ $message }}</span>@enderror
                <p style="font-size: 12px; color: var(--text-secondary); margin-top: 6px;">Eligibility: Maximum loan is 3x member's savings balance.</p>
            </div>

            <div class="grid grid-cols-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Interest Rate (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="interest_rate" value="{{ old('interest_rate', '10.0') }}" class="form-control" required placeholder="e.g. 10">
                    @error('interest_rate')<span style="color: var(--danger-color); font-size: 12px;">{{ $message }}</span>@enderror
                </div>
                
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label">Duration (Months)</label>
                    <input type="number" step="1" min="1" max="120" name="duration_months" value="{{ old('duration_months', '6') }}" class="form-control" required placeholder="e.g. 6">
                    @error('duration_months')<span style="color: var(--danger-color); font-size: 12px;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: flex; gap: 12px; border-top: 1px solid var(--border-light); padding-top: 16px;">
                <button type="submit" class="btn btn-primary" style="padding: 8px 24px;">Submit Application</button>
                <a href="{{ route('loans.index') }}" class="btn btn-secondary" style="padding: 8px 24px;">Cancel</a>
            </div>
        </form>
    </div>
@endsection
