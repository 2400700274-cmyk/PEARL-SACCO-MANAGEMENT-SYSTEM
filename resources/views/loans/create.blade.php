@extends('components.layouts.app')

@section('title', 'New Loan Application')

@section('content')
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('loans.index') }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to Loans</a>
        <h1 style="margin: 0; font-size: 24px;">New Loan Application</h1>
    </div>

    <div class="card" style="max-width: 800px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 18px 24px;">
            <h2 style="margin: 0; font-size: 16px; color: var(--primary-color);">Credit Application & Security Collateral</h2>
        </div>
        
        <form method="POST" action="{{ route('loans.store') }}" style="padding: 24px;">
            @csrf
            
            <div style="font-weight: 700; font-size: 13px; color: var(--primary-color); border-bottom: 1px solid var(--border-light); padding-bottom: 6px; margin-bottom: 16px; text-transform: uppercase;">
                1. Member & Loan Terms
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Select Active Member</label>
                <select name="member_id" class="form-control" required autofocus>
                    <option value="">-- Choose Eligible Active Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->member_number }} - {{ $member->name }} (Active Savings: UGX {{ number_format($member->savingsAccounts->where('status', 'Active')->sum('balance'), 0) }})
                        </option>
                    @endforeach
                </select>
                <span style="font-size: 11px; color: var(--text-secondary); margin-top: 4px; display: block;">Policy: Suspended and inactive members are excluded from loan eligibility.</span>
                @error('member_id')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Requested Principal Amount (UGX)</label>
                <input type="number" step="0.01" min="1000" name="principal_amount" value="{{ old('principal_amount') }}" class="form-control" required placeholder="e.g. 500000">
                @error('principal_amount')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                <p style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">Eligibility: Maximum credit is 3x member's active savings balance.</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Interest Rate (%)</label>
                    <input type="number" step="0.01" min="0" max="100" name="interest_rate" value="{{ old('interest_rate', '10.0') }}" class="form-control" required placeholder="e.g. 10">
                    @error('interest_rate')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>
                
                <div class="form-group" style="margin-bottom: 0;">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Duration (Months)</label>
                    <input type="number" step="1" min="1" max="120" name="duration_months" value="{{ old('duration_months', '6') }}" class="form-control" required placeholder="e.g. 6">
                    @error('duration_months')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="font-weight: 700; font-size: 13px; color: var(--primary-color); border-bottom: 1px solid var(--border-light); padding-bottom: 6px; margin-bottom: 16px; margin-top: 24px; text-transform: uppercase;">
                2. Security & Collateral Measures (Anti-Default Safeguards)
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Collateral Description / Asset Pledged</label>
                    <input type="text" name="collateral_description" value="{{ old('collateral_description') }}" class="form-control" required placeholder="e.g. Land Title / Dairy Cattle / Motorcycle Logbook / Produce">
                    @error('collateral_description')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Collateral Estimated Value (UGX)</label>
                    <input type="number" step="0.01" min="0" name="collateral_value" value="{{ old('collateral_value') }}" class="form-control" required placeholder="e.g. 1500000">
                    @error('collateral_value')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Guarantor Full Name</label>
                    <input type="text" name="guarantor_name" value="{{ old('guarantor_name') }}" class="form-control" required placeholder="e.g. Patrick Ssemakula">
                    @error('guarantor_name')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Guarantor Telephone</label>
                    <input type="text" name="guarantor_contact" value="{{ old('guarantor_contact') }}" class="form-control" required placeholder="+256 700 000 000">
                    @error('guarantor_contact')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Guarantor Uganda National ID (NIN)</label>
                <input type="text" id="guarantor_nin" name="guarantor_nin" value="{{ old('guarantor_nin') }}" maxlength="14" class="form-control" required placeholder="CM90012345ABCD" style="text-transform: uppercase;">
                <span style="font-size: 11px; color: var(--text-secondary); margin-top: 4px; display: block;">Mandatory 14 characters Uganda NIRA NIN format</span>
                @error('guarantor_nin')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
            </div>

            <div style="display: flex; gap: 12px; border-top: 1px solid var(--border-light); padding-top: 20px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 28px; font-weight: 600;">Submit Credit Application</button>
                <a href="{{ route('loans.index') }}" class="btn btn-secondary" style="padding: 10px 24px;">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('guarantor_nin').addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        });
    </script>
@endsection
