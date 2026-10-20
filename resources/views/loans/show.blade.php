@extends('components.layouts.app')

@section('title', 'Loan Tracking - LN-' . str_pad($loan->id, 5, '0', STR_PAD_LEFT))

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('loans.index') }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to Loans</a>
            <h1 style="margin: 0; font-size: 24px;">Loan Tracking: LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</h1>
        </div>
        
        <div style="display: flex; gap: 10px;">
            @if($loan->status === 'Pending' && auth()->user()->hasPermission('approve-loans'))
                <form method="POST" action="{{ route('loans.approve', $loan) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="background-color: var(--success-color); border-color: var(--success-color); font-weight: 600;">Disburse & Activate Loan</button>
                </form>
            @endif

            @if($loan->status === 'Active')
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('penalty-modal').style.display='flex';" style="font-weight: 600; color: #d83b01; border-color: #d83b01;">
                    + Apply Late Penalty
                </button>
                <form method="POST" action="{{ route('loans.flag-default', $loan) }}" onsubmit="return confirm('WARNING: Flagging this loan as Defaulted will automatically SUSPEND member {{ $loan->member->name }} and restrict all their savings and loan privileges as a recovery security measure. Proceed?');">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="color: var(--danger-color); border-color: var(--danger-color);">Flag Default</button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #dff6dd; color: var(--success-color); padding: 14px 18px; border-radius: 6px; margin-bottom: 24px; border: 1px solid #c8e6c9; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background-color: #fde7e9; color: var(--danger-color); padding: 14px 18px; border-radius: 6px; margin-bottom: 24px; border: 1px solid #f8c9ce; font-weight: 500;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Feature: Loan Progress & Maturity Tracker (Modification 6) -->
    <div class="card" style="margin-bottom: 24px; padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <div>
                <span style="font-size: 13px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase;">Repayment Progress Tracker</span>
                <div style="font-size: 20px; font-weight: 700; color: var(--primary-color);">
                    {{ $loan->progress_percent }}% Repaid
                    <span style="font-size: 14px; font-weight: 500; color: var(--text-secondary);">
                        (UGX {{ number_format($loan->amount_paid, 2) }} of UGX {{ number_format($loan->effective_total, 2) }})
                    </span>
                </div>
            </div>
            <div style="text-align: right;">
                @if($loan->is_overdue)
                    <span class="badge badge-danger" style="font-size: 13px; padding: 6px 12px;">
                        OVERDUE BY {{ $loan->days_overdue }} DAY(S)
                    </span>
                @elseif($loan->status === 'Active')
                    <span class="badge badge-success" style="font-size: 13px; padding: 6px 12px;">
                        ON SCHEDULE • Due {{ $loan->due_date ? $loan->due_date->format('M d, Y') : 'N/A' }}
                    </span>
                @else
                    <span class="badge badge-info" style="font-size: 13px; padding: 6px 12px;">
                        Status: {{ $loan->status }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Progress bar -->
        <div style="width: 100%; height: 16px; background: #edebe9; border-radius: 8px; overflow: hidden; position: relative;">
            <div style="width: {{ $loan->progress_percent }}%; height: 100%; background: linear-gradient(90deg, #0078d4 0%, #107c10 100%); transition: width 0.4s ease;"></div>
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 10px; font-size: 12px; color: var(--text-secondary);">
            <span>Disbursed: {{ $loan->approved_at ? $loan->approved_at->format('M d, Y') : 'Pending Disbursement' }}</span>
            <span>Maturity / Due Date: {{ $loan->due_date ? $loan->due_date->format('M d, Y') : 'Pending' }}</span>
        </div>
    </div>

    <div class="grid" style="grid-template-columns: 1fr 2fr; gap: 24px;">
        <!-- Left: Loan & Security Details -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 16px 20px; font-weight: 600; color: var(--primary-color);">Financial Breakdown</div>
                
                <div style="padding: 20px;">
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Borrower Member</div>
                        <div style="font-weight: 600;">
                            <a href="{{ route('members.show', $loan->member) }}">{{ $loan->member->name }}</a>
                            <span style="font-size: 12px; color: var(--text-secondary);">({{ $loan->member->member_number }})</span>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Principal Amount</div>
                        <div style="font-size: 18px; font-weight: 700;">UGX {{ number_format($loan->principal_amount, 2) }}</div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px;">
                        <div>
                            <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Interest Rate</div>
                            <div style="font-weight: 600;">{{ number_format($loan->interest_rate, 2) }}% (Flat)</div>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Duration</div>
                            <div style="font-weight: 600;">{{ $loan->duration_months }} Months</div>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Base Total Payable</div>
                        <div style="font-size: 14px; font-weight: 600;">UGX {{ number_format($loan->total_payable, 2) }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Late Penalty Fees Applied</div>
                        <div style="font-size: 15px; font-weight: 700; color: {{ $loan->penalty_amount > 0 ? '#d83b01' : 'var(--text-secondary)' }};">
                            UGX {{ number_format($loan->penalty_amount ?? 0, 2) }}
                        </div>
                    </div>

                    <div style="border-top: 1px solid var(--border-light); padding-top: 14px; margin-top: 14px;">
                        <div style="font-size: 12px; color: var(--text-secondary); text-transform: uppercase; font-weight: 600;">Current Remaining Balance</div>
                        <div style="font-size: 26px; font-weight: 800; color: {{ $loan->balance > 0 ? '#d13438' : '#107c10' }};">
                            UGX {{ number_format($loan->balance, 2) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Measures Card (Collateral & Guarantor) -->
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 16px 20px; font-weight: 600; color: var(--primary-color); display: flex; align-items: center; gap: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    Security & Collateral Safeguards
                </div>
                <div style="padding: 20px;">
                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Pledged Collateral</div>
                        <div style="font-weight: 600; font-size: 13px;">{{ $loan->collateral_description ?? 'Standard Member Savings Lien' }}</div>
                        @if($loan->collateral_value)
                            <div style="font-size: 12px; color: var(--primary-color);">Valuation: UGX {{ number_format($loan->collateral_value, 2) }}</div>
                        @endif
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Guarantor Full Name</div>
                        <div style="font-weight: 600; font-size: 13px;">{{ $loan->guarantor_name ?? 'N/A' }}</div>
                    </div>

                    <div style="margin-bottom: 14px;">
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Guarantor Telephone</div>
                        <div style="font-size: 13px;">{{ $loan->guarantor_contact ?? 'N/A' }}</div>
                    </div>

                    <div>
                        <div style="font-size: 11px; color: var(--text-secondary); text-transform: uppercase;">Guarantor Uganda NIN</div>
                        <div style="font-size: 13px; font-family: monospace; font-weight: 600;">{{ $loan->guarantor_nin ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Repayment Ledger -->
        <div class="card">
            <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 600; color: var(--primary-color);">Repayment Transactions & Ledger</span>
                @if($loan->status === 'Active' && $loan->balance > 0)
                    <a href="{{ route('loans.repayments.create', $loan) }}" class="btn btn-primary" style="font-size: 12px; padding: 6px 14px;">
                        + Record Repayment
                    </a>
                @endif
            </div>
            
            <div class="table-container" style="padding: 12px;">
                <table>
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border-light); text-align: left;">
                            <th>Receipt Date</th>
                            <th>Amount (UGX)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loan->repayments as $repayment)
                            <tr style="border-bottom: 1px solid var(--border-light);">
                                <td style="padding: 12px 8px;">{{ $repayment->paid_at->format('M d, Y') }}</td>
                                <td style="padding: 12px 8px; font-weight: 700; color: var(--success-color);">
                                    UGX {{ number_format($repayment->amount, 2) }}
                                </td>
                                <td style="padding: 12px 8px;">
                                    <span class="badge badge-success">{{ $repayment->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 40px; color: var(--text-secondary);">
                                    No repayments recorded for this credit facility yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Apply Penalty Modal Dialog -->
    <div id="penalty-modal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div class="card" style="width: 100%; max-width: 480px; padding: 28px; background: white; border-radius: 12px;">
            <h2 style="margin: 0 0 16px; font-size: 18px; color: var(--danger-color);">Apply Late Penalty Fee</h2>
            <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 20px;">
                Apply a late penalty charge to Loan LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}. This will be added to the total payable and outstanding loan balance.
            </p>

            <form method="POST" action="{{ route('loans.apply-penalty', $loan) }}">
                @csrf
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Penalty Calculation Type</label>
                    <select name="penalty_type" class="form-control" required style="width: 100%;">
                        <option value="fixed">Fixed Amount (UGX)</option>
                        <option value="percentage">Percentage of Current Balance (%)</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Penalty Value (UGX or %)</label>
                    <input type="number" step="0.01" min="1" name="penalty_value" class="form-control" required placeholder="e.g. 20000 or 5" style="width: 100%;">
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Reason / Notes</label>
                    <input type="text" name="notes" class="form-control" placeholder="e.g. Overdue installment 30+ days" style="width: 100%;">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('penalty-modal').style.display='none';">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background: var(--danger-color); border-color: var(--danger-color);">Apply Penalty</button>
                </div>
            </form>
        </div>
    </div>
@endsection
