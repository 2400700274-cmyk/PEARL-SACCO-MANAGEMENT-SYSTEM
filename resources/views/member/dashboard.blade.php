@extends('components.layouts.app')

@section('title', 'Member Dashboard - ' . $member->name)

@section('content')
    <!-- Top Welcome Banner & Member Identity -->
    <div style="background: linear-gradient(135deg, #004578 0%, #0078d4 100%); color: white; padding: 24px; border-radius: 12px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(0, 120, 212, 0.15);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; gap: 16px; align-items: center;">
                @if($member->passport_photo_path)
                    <img src="{{ Storage::url($member->passport_photo_path) }}" alt="{{ $member->name }}" style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255, 255, 255, 0.8);">
                @else
                    <div style="width: 72px; height: 72px; border-radius: 50%; background: rgba(255, 255, 255, 0.2); color: white; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; border: 3px solid rgba(255, 255, 255, 0.5);">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <h1 style="margin: 0; font-size: 24px; font-weight: 700; color: white;">{{ $member->name }}</h1>
                        @if($member->status === 'Active')
                            <span class="badge" style="background-color: #107c10; color: white; font-weight: 600; font-size: 11px;">Active Member</span>
                        @elseif($member->status === 'Suspended')
                            <span class="badge" style="background-color: #d83b01; color: white; font-weight: 600; font-size: 11px;">Suspended</span>
                        @else
                            <span class="badge" style="background-color: #797775; color: white; font-weight: 600; font-size: 11px;">{{ $member->status }}</span>
                        @endif
                    </div>
                    <div style="margin-top: 6px; font-size: 13px; opacity: 0.9; display: flex; gap: 16px; flex-wrap: wrap;">
                        <span><strong>Member No:</strong> {{ $member->member_number }}</span>
                        <span><strong>NIN:</strong> {{ $member->nin }}</span>
                        <span><strong>Contact:</strong> {{ $member->contact }}</span>
                        <span><strong>Joined:</strong> {{ $member->registered_at ? $member->registered_at->format('M d, Y') : 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Next of Kin Quick Trigger (Requirement MD-009) -->
            <button type="button" class="btn btn-secondary" onclick="document.getElementById('next-of-kin-modal').style.display='flex';" style="background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3); backdrop-filter: blur(4px);">
                Next of Kin Details
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #dff6dd; color: var(--success-color); padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #c8e6c9; font-weight: 500;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background-color: #fde7e9; color: var(--danger-color); padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #f8c9ce; font-weight: 500;">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background-color: #fde7e9; color: var(--danger-color); padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; border: 1px solid #f8c9ce;">
            <strong style="display: block; margin-bottom: 6px;">Please correct the errors below:</strong>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-3" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 24px;">
        <!-- Total Savings Balance -->
        <div class="card" style="padding: 20px; border-left: 5px solid #107c10;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 13px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase;">Total Savings Balance</span>
                <span style="background: #e6f7e6; color: #107c10; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">Withdrawable</span>
            </div>
            <div style="font-size: 26px; font-weight: 700; color: #107c10;">
                UGX {{ number_format($totalSavings, 2) }}
            </div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 6px;">
                {{ $member->savingsAccounts->count() }} registered savings ledger account(s)
            </div>
        </div>

        <!-- Active Loan Balance -->
        <div class="card" style="padding: 20px; border-left: 5px solid #d83b01;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 13px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase;">Active Loan Balance</span>
                <span style="background: #fde7e9; color: #d83b01; padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">Arrears / Balance</span>
            </div>
            <div style="font-size: 26px; font-weight: 700; color: #d83b01;">
                UGX {{ number_format($activeLoanBalance, 2) }}
            </div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 6px;">
                {{ $activeLoans->where('status', 'Active')->count() }} active credit facility running
            </div>
        </div>

        <!-- Available Loan Limit -->
        <div class="card" style="padding: 20px; border-left: 5px solid var(--primary-color);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <span style="font-size: 13px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase;">Available Loan Limit</span>
                <span style="background: #e1effa; color: var(--primary-color); padding: 4px 8px; border-radius: 20px; font-size: 11px; font-weight: 600;">3x Multiplier</span>
            </div>
            <div style="font-size: 26px; font-weight: 700; color: var(--primary-color);">
                UGX {{ number_format($availableLoanLimit, 2) }}
            </div>
            <div style="font-size: 12px; color: var(--text-secondary); margin-top: 6px;">
                Calculated as 3x active savings minus active liabilities
            </div>
        </div>
    </div>

    <!-- Quick Access Buttons Bar -->
    <div class="card" style="padding: 16px 20px; margin-bottom: 24px; background: #faf9f8;">
        <div style="font-size: 12px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 12px;">Quick Access Services</div>
        <div style="display: flex; flex-wrap: wrap; gap: 12px;">
            <button type="button" class="btn btn-primary" onclick="switchTab('apply-loan')" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                Apply for Loan
            </button>

            <button type="button" class="btn btn-secondary" onclick="switchTab('savings')" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                View Savings
            </button>

            <a href="{{ route('member.savings.statement', ['member_id' => $member->id, 'format' => 'print']) }}" target="_blank" class="btn btn-secondary" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download Statement
            </a>

            <button type="button" class="btn btn-secondary" onclick="switchTab('schedule')" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                View Repayment Schedule
            </button>

            <button type="button" class="btn btn-secondary" onclick="switchTab('security')" style="display: inline-flex; align-items: center; gap: 8px; margin-left: auto;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                Change Password
            </button>
        </div>
    </div>

    <!-- Tabbed Navigation Header -->
    <div style="border-bottom: 2px solid var(--border-light); margin-bottom: 24px; display: flex; gap: 8px; overflow-x: auto;">
        <button type="button" id="tab-btn-savings" onclick="switchTab('savings')" class="tab-button active-tab">
            💰 Savings & Transactions
        </button>
        <button type="button" id="tab-btn-loans" onclick="switchTab('loans')" class="tab-button">
            📊 My Loans & History
        </button>
        <button type="button" id="tab-btn-schedule" onclick="switchTab('schedule')" class="tab-button">
            📅 Repayment Schedule & Penalties
        </button>
        <button type="button" id="tab-btn-apply-loan" onclick="switchTab('apply-loan')" class="tab-button">
            📝 Apply for Loan Online
        </button>
        <button type="button" id="tab-btn-security" onclick="switchTab('security')" class="tab-button">
            🔒 Account & Security
        </button>
    </div>

    <!-- ==================== TAB 1: SAVINGS & TRANSACTIONS (Requirement MD-014) ==================== -->
    <div id="tab-content-savings" class="tab-pane active-pane">
        <!-- Date Filter & Actions Card -->
        <div class="card" style="padding: 20px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h3 style="margin: 0; font-size: 16px; color: var(--primary-color);">Filter Savings Records by Date Range</h3>
                    <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">Requirement MD-014: Filter transactions and download customized statements</div>
                </div>

                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('member.savings.statement', ['member_id' => $member->id, 'from_date' => request('from_date'), 'to_date' => request('to_date'), 'format' => 'csv']) }}" class="btn btn-secondary" style="font-size: 13px;">
                        Export CSV
                    </a>
                    <a href="{{ route('member.savings.statement', ['member_id' => $member->id, 'from_date' => request('from_date'), 'to_date' => request('to_date'), 'format' => 'print']) }}" target="_blank" class="btn btn-secondary" style="font-size: 13px;">
                        Print / PDF Statement
                    </a>
                </div>
            </div>

            <form method="GET" action="{{ route('member.dashboard') }}" style="margin-top: 16px; display: flex; flex-wrap: wrap; gap: 14px; align-items: flex-end;">
                <input type="hidden" name="member_id" value="{{ $member->id }}">
                <div style="flex: 1; min-width: 180px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">From Date</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>

                <div style="flex: 1; min-width: 180px;">
                    <label style="display: block; font-size: 12px; font-weight: 600; color: var(--text-secondary); margin-bottom: 4px;">To Date</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px;">
                </div>

                <div style="display: flex; gap: 8px;">
                    <button type="submit" class="btn btn-primary" style="padding: 9px 18px;">Apply Filter</button>
                    @if(request('from_date') || request('to_date'))
                        <a href="{{ route('member.dashboard', ['member_id' => $member->id]) }}" class="btn btn-secondary" style="padding: 9px 14px;">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Transactions Ledger Table -->
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <span>Savings Transaction History</span>
                <span style="font-size: 12px; color: var(--text-secondary);">Showing {{ $transactions->total() }} transaction(s)</span>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Transaction Type</th>
                            <th>Amount (UGX)</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                            <tr>
                                <td>{{ $tx->transaction_date ? $tx->transaction_date->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    @if(strtolower($tx->type) === 'deposit' || strtolower($tx->type) === 'credit')
                                        <span class="badge" style="background-color: #dff6dd; color: #107c10; font-weight: 600;">Deposit</span>
                                    @else
                                        <span class="badge" style="background-color: #fde7e9; color: #d83b01; font-weight: 600;">Withdrawal</span>
                                    @endif
                                </td>
                                <td style="font-weight: 700; color: {{ strtolower($tx->type) === 'deposit' ? '#107c10' : '#d83b01' }};">
                                    {{ strtolower($tx->type) === 'deposit' ? '+' : '-' }} {{ number_format($tx->amount, 2) }}
                                </td>
                                <td>{{ $tx->description ?? 'Counter transaction' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 24px; color: var(--text-secondary);">
                                    No savings transactions found for the selected period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div style="padding: 16px; border-top: 1px solid var(--border-light);">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- ==================== TAB 2: MY LOANS & HISTORY (Requirements MD-021, MD-024) ==================== -->
    <div id="tab-content-loans" class="tab-pane" style="display: none;">
        <div class="card" style="margin-bottom: 24px;">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <span>Active & Pending Loan Applications (Requirement MD-021, MD-024)</span>
                <button type="button" class="btn btn-primary" onclick="switchTab('apply-loan')" style="font-size: 13px;">+ New Application</button>
            </div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Loan ID</th>
                            <th>Loan Type</th>
                            <th>Loan Amount (UGX)</th>
                            <th>Interest Rate</th>
                            <th>Amount Paid</th>
                            <th>Outstanding Balance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeLoans as $loan)
                            <tr>
                                <td style="font-weight: 600;">LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $loan->loan_type ?? 'Agricultural Loan' }}</td>
                                <td>UGX {{ number_format($loan->principal_amount, 2) }}</td>
                                <td>{{ $loan->interest_rate }}%</td>
                                <td style="color: #107c10; font-weight: 600;">UGX {{ number_format($loan->amount_paid, 2) }}</td>
                                <td style="color: #d83b01; font-weight: 700;">UGX {{ number_format($loan->balance, 2) }}</td>
                                <td>
                                    @if($loan->status === 'Active')
                                        <span class="badge badge-success">Active</span>
                                        @if($loan->is_overdue)
                                            <span class="badge badge-danger" style="display: block; margin-top: 4px; font-size: 10px;">Overdue ({{ $loan->days_overdue }}d)</span>
                                        @endif
                                    @elseif($loan->status === 'Pending')
                                        <span class="badge badge-warning" style="background: #fff4ce; color: #795500;">Pending Review</span>
                                    @else
                                        <span class="badge badge-info">{{ $loan->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 6px;">
                                        <a href="{{ route('member.dashboard', ['member_id' => $member->id, 'loan_id' => $loan->id]) }}#schedule-section" onclick="switchTab('schedule')" class="btn btn-secondary" style="font-size: 11px; padding: 4px 8px;">
                                            Schedule
                                        </a>
                                        <a href="{{ route('member.loans.statement', ['loan' => $loan->id, 'member_id' => $member->id, 'format' => 'print']) }}" target="_blank" class="btn btn-secondary" style="font-size: 11px; padding: 4px 8px;">
                                            Statement
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 24px; color: var(--text-secondary);">
                                    You currently have no active or pending loan applications.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Completed Loans Table -->
        <div class="card">
            <div class="card-header">Completed & Fully Settled Loans</div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Loan ID</th>
                            <th>Loan Type</th>
                            <th>Principal Amount</th>
                            <th>Total Repaid</th>
                            <th>Maturity Date</th>
                            <th>Status</th>
                            <th>Statement</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($completedLoans as $loan)
                            <tr>
                                <td>LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $loan->loan_type ?? 'Agricultural Loan' }}</td>
                                <td>UGX {{ number_format($loan->principal_amount, 2) }}</td>
                                <td style="color: #107c10; font-weight: 600;">UGX {{ number_format($loan->total_payable, 2) }}</td>
                                <td>{{ $loan->due_date ? $loan->due_date->format('M d, Y') : 'N/A' }}</td>
                                <td><span class="badge badge-success">Completed</span></td>
                                <td>
                                    <a href="{{ route('member.loans.statement', ['loan' => $loan->id, 'member_id' => $member->id, 'format' => 'print']) }}" target="_blank" class="btn btn-secondary" style="font-size: 11px; padding: 4px 8px;">
                                        Download Statement
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 20px; color: var(--text-secondary);">
                                    No completed historical loans recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ==================== TAB 3: REPAYMENT SCHEDULE & PENALTIES (MD-026, MD-027, MD-028) ==================== -->
    <div id="tab-content-schedule" class="tab-pane" style="display: none;">
        @if($activeLoanForSchedule)
            <!-- Penalty Warning Banner if Overdue (Requirement MD-027) -->
            @if($activeLoanForSchedule->penalty_amount > 0 || $activeLoanForSchedule->is_overdue)
                <div style="background-color: #fde7e9; border-left: 5px solid #d83b01; padding: 16px 20px; border-radius: 8px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <div style="color: #d83b01; font-weight: 700; font-size: 16px;">Overdue Loan Warning (Requirement MD-027)</div>
                        <div style="color: #605e5c; font-size: 13px; margin-top: 4px;">
                            This loan has accrued late penalty surcharges of <strong>UGX {{ number_format($activeLoanForSchedule->penalty_amount, 2) }}</strong>.
                            @if($activeLoanForSchedule->days_overdue > 0)
                                Overdue by <strong>{{ $activeLoanForSchedule->days_overdue }} day(s)</strong> past scheduled maturity date ({{ $activeLoanForSchedule->due_date ? $activeLoanForSchedule->due_date->format('M d, Y') : 'N/A' }}).
                            @endif
                        </div>
                    </div>
                    <span class="badge badge-danger" style="font-size: 13px; padding: 6px 14px;">Overdue Penalty Applied</span>
                </div>
            @endif

            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <span>Repayment Schedule for LN-{{ str_pad($activeLoanForSchedule->id, 5, '0', STR_PAD_LEFT) }}</span>
                        <span style="font-size: 13px; color: var(--text-secondary); margin-left: 8px;">({{ $activeLoanForSchedule->loan_type ?? 'Agricultural Loan' }})</span>
                    </div>

                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('member.loans.statement', ['loan' => $activeLoanForSchedule->id, 'member_id' => $member->id, 'format' => 'csv']) }}" class="btn btn-secondary" style="font-size: 13px;">
                            Export Schedule CSV
                        </a>
                        <a href="{{ route('member.loans.statement', ['loan' => $activeLoanForSchedule->id, 'member_id' => $member->id, 'format' => 'print']) }}" target="_blank" class="btn btn-secondary" style="font-size: 13px;">
                            Download Repayment Statement (MD-028)
                        </a>
                    </div>
                </div>

                <!-- Schedule Table (Requirement MD-026) -->
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Installment #</th>
                                <th>Due Date</th>
                                <th>Installment Amount</th>
                                <th>Amount Paid</th>
                                <th>Remaining Balance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeLoanForSchedule->repayment_schedule as $item)
                                <tr>
                                    <td style="font-weight: 600;">Installment {{ $item['installment_number'] }}</td>
                                    <td>{{ $item['due_date']->format('M d, Y') }}</td>
                                    <td>UGX {{ number_format($item['installment_amount'], 2) }}</td>
                                    <td style="color: #107c10; font-weight: 600;">UGX {{ number_format($item['amount_paid'], 2) }}</td>
                                    <td style="color: #d83b01; font-weight: 600;">UGX {{ number_format($item['remaining_balance'], 2) }}</td>
                                    <td>
                                        @if($item['status'] === 'Paid')
                                            <span class="badge badge-success">Paid</span>
                                        @elseif($item['status'] === 'Partially Paid')
                                            <span class="badge badge-warning" style="background: #fff4ce; color: #795500;">Partially Paid</span>
                                        @elseif($item['status'] === 'Overdue')
                                            <span class="badge badge-danger">Overdue</span>
                                        @else
                                            <span class="badge badge-info">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="card" style="padding: 40px; text-align: center; color: var(--text-secondary);">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 16px auto; opacity: 0.5;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                <div style="font-size: 16px; font-weight: 600; color: var(--text-primary); margin-bottom: 6px;">No Active Repayment Schedule</div>
                <div>You do not have any active loans with a running repayment schedule. Once your loan application is approved and disbursed, its monthly schedule will appear here.</div>
                <button type="button" class="btn btn-primary" onclick="switchTab('apply-loan')" style="margin-top: 16px;">Apply for a Loan</button>
            </div>
        @endif
    </div>

    <!-- ==================== TAB 4: APPLY FOR LOAN ONLINE (Requirement MD-020) ==================== -->
    <div id="tab-content-apply-loan" class="tab-pane" style="display: none;">
        <div class="card" style="max-width: 800px; margin: 0 auto; padding: 24px;">
            <div style="border-bottom: 1px solid var(--border-light); padding-bottom: 16px; margin-bottom: 20px;">
                <h2 style="margin: 0; font-size: 18px; color: var(--primary-color);">Online Loan Application Form</h2>
                <div style="font-size: 13px; color: var(--text-secondary); margin-top: 4px;">Requirement MD-020: Submit your credit request directly from your member portal</div>
            </div>

            <div style="background: #e1effa; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; color: #004578; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <strong>Your Available Credit Limit:</strong> UGX {{ number_format($availableLoanLimit, 2) }}
                    <span style="display: block; font-size: 11px; margin-top: 2px;">(Based on 3x your active savings balance of UGX {{ number_format($totalSavings, 2) }})</span>
                </div>
                <span class="badge badge-info" style="font-size: 11px;">Standard 10% Flat Rate</span>
            </div>

            <form method="POST" action="{{ route('member.loans.apply') }}">
                @csrf
                <input type="hidden" name="member_id" value="{{ $member->id }}">

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 16px;">
                    <!-- Loan Type (MD-020) -->
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Loan Type <span style="color: red;">*</span></label>
                        <select name="loan_type" class="form-control" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px;">
                            <option value="Agricultural Crop Production Loan">Agricultural Crop Production Loan</option>
                            <option value="Livestock & Animal Husbandry Loan">Livestock & Animal Husbandry Loan</option>
                            <option value="Farm Inputs & Machinery Loan">Farm Inputs & Machinery Loan</option>
                            <option value="Emergency Agricultural Loan">Emergency Agricultural Loan</option>
                            <option value="Commercial Agro-Business Loan">Commercial Agro-Business Loan</option>
                        </select>
                    </div>

                    <!-- Requested Amount (MD-020) -->
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Requested Amount (UGX) <span style="color: red;">*</span></label>
                        <input type="number" name="requested_amount" min="1000" max="{{ max(1000, $availableLoanLimit) }}" placeholder="e.g. 500000" class="form-control" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px;" oninput="updateLoanEstimate(this.value, document.getElementById('period_input').value)">
                        <small style="font-size: 11px; color: var(--text-secondary);">Max eligible: UGX {{ number_format($availableLoanLimit, 2) }}</small>
                    </div>
                </div>

                <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 16px;">
                    <!-- Repayment Period (MD-020) -->
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Repayment Period (Months) <span style="color: red;">*</span></label>
                        <select name="duration_months" id="period_input" class="form-control" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px;" onchange="updateLoanEstimate(document.getElementsByName('requested_amount')[0].value, this.value)">
                            <option value="3">3 Months</option>
                            <option value="6" selected>6 Months</option>
                            <option value="12">12 Months (1 Year)</option>
                            <option value="18">18 Months</option>
                            <option value="24">24 Months (2 Years)</option>
                            <option value="36">36 Months (3 Years)</option>
                        </select>
                    </div>

                    <!-- Instant Repayment Estimator -->
                    <div style="background: #faf9f8; border: 1px solid var(--border-light); padding: 12px 16px; border-radius: 8px;">
                        <span style="font-size: 12px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase;">Estimated Monthly Payment</span>
                        <div id="estimate_display" style="font-size: 18px; font-weight: 700; color: var(--primary-color); margin-top: 4px;">
                            UGX 0.00 / month
                        </div>
                        <div style="font-size: 11px; color: var(--text-secondary);">Includes 10% flat interest rate</div>
                    </div>
                </div>

                <!-- Loan Purpose (MD-020) -->
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Loan Purpose <span style="color: red;">*</span></label>
                    <textarea name="loan_purpose" rows="3" placeholder="Describe the planned agricultural or commercial purpose for this loan facility (e.g. buying seeds, irrigation equipment, dairy cows)..." class="form-control" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px;"></textarea>
                </div>

                <div style="border-top: 1px solid var(--border-light); padding-top: 16px; margin-top: 16px;">
                    <div style="font-size: 13px; font-weight: 700; color: var(--text-secondary); margin-bottom: 12px;">Security & Guarantor Details (Optional / Pledged)</div>
                    <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Pledged Collateral Asset</label>
                            <input type="text" name="collateral_description" placeholder="e.g. 2 Dairy Cows, Land Agreement" class="form-control" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Estimated Asset Value (UGX)</label>
                            <input type="number" name="collateral_value" placeholder="e.g. 1500000" class="form-control" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px;">
                        </div>
                    </div>

                    <div class="grid" style="grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-bottom: 24px;">
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Guarantor Name</label>
                            <input type="text" name="guarantor_name" placeholder="Full legal name" class="form-control" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Guarantor Contact</label>
                            <input type="text" name="guarantor_contact" placeholder="+256 7..." class="form-control" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px;">Guarantor NIN</label>
                            <input type="text" name="guarantor_nin" placeholder="14-char NIRA NIN" class="form-control" style="width: 100%; padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 6px;">
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" class="btn btn-secondary" onclick="switchTab('savings')">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-weight: 600;">Submit Loan Application</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== TAB 5: ACCOUNT SECURITY & PASSWORD ==================== -->
    <div id="tab-content-security" class="tab-pane" style="display: none;">
        <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 24px;">
            <!-- Password Change Form -->
            <div class="card" style="padding: 24px;">
                <h3 style="margin: 0 0 16px 0; font-size: 16px; color: var(--primary-color);">Change Account Password</h3>
                <form method="POST" action="{{ route('member.password.update') }}">
                    @csrf
                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Current Password <span style="color: red;">*</span></label>
                        <input type="password" name="current_password" required class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px;">
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">New Password <span style="color: red;">*</span></label>
                        <input type="password" name="new_password" required minlength="8" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px;">
                        <small style="font-size: 11px; color: var(--text-secondary);">Minimum 8 characters</small>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Confirm New Password <span style="color: red;">*</span></label>
                        <input type="password" name="new_password_confirmation" required minlength="8" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px;">
                    </div>

                    <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">Update Password</button>
                </form>
            </div>

            <!-- Next of Kin Information Card (Requirement MD-009) -->
            <div class="card" style="padding: 24px;">
                <h3 style="margin: 0 0 16px 0; font-size: 16px; color: var(--primary-color);">Next of Kin Records (Requirement MD-009)</h3>
                <div style="font-size: 13px; color: var(--text-secondary); margin-bottom: 16px;">
                    Designated beneficiary and primary emergency contact registered on file.
                </div>

                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">
                        <span style="font-weight: 600; color: var(--text-secondary);">Full Name:</span>
                        <span style="font-weight: 700; color: var(--text-primary);">{{ $member->next_of_kin_name ?? 'Not recorded' }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">
                        <span style="font-weight: 600; color: var(--text-secondary);">Relationship:</span>
                        <span style="font-weight: 600; color: var(--text-primary);">{{ $member->next_of_kin_relationship ?? 'Not recorded' }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">
                        <span style="font-weight: 600; color: var(--text-secondary);">Contact Number:</span>
                        <span style="font-weight: 600; color: var(--text-primary);">{{ $member->next_of_kin_contact ?? 'Not recorded' }}</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; padding-bottom: 8px;">
                        <span style="font-weight: 600; color: var(--text-secondary);">Physical Address:</span>
                        <span style="font-weight: 600; color: var(--text-primary);">{{ $member->next_of_kin_address ?? 'Not recorded' }}</span>
                    </div>
                </div>

                <div style="margin-top: 20px; padding: 12px; background: #faf9f8; border-radius: 6px; font-size: 12px; color: var(--text-secondary);">
                    <em>To update your registered next-of-kin records, please present valid identification at any Kulima Agri SACCO branch office.</em>
                </div>
            </div>
        </div>
    </div>

    <!-- Next-of-Kin Quick Modal (Requirement MD-009) -->
    <div id="next-of-kin-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: white; border-radius: 12px; max-width: 500px; width: 100%; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid var(--border-light); padding-bottom: 12px;">
                <h3 style="margin: 0; font-size: 18px; color: var(--primary-color);">Registered Next of Kin Details</h3>
                <button type="button" onclick="document.getElementById('next-of-kin-modal').style.display='none';" style="background: none; border: none; font-size: 20px; cursor: pointer; color: var(--text-secondary);">&times;</button>
            </div>

            <div style="display: flex; flex-direction: column; gap: 12px; font-size: 14px;">
                <div><strong>Full Name:</strong> {{ $member->next_of_kin_name ?? 'N/A' }}</div>
                <div><strong>Relationship:</strong> {{ $member->next_of_kin_relationship ?? 'N/A' }}</div>
                <div><strong>Contact Number:</strong> {{ $member->next_of_kin_contact ?? 'N/A' }}</div>
                <div><strong>Physical Address:</strong> {{ $member->next_of_kin_address ?? 'N/A' }}</div>
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                <button type="button" class="btn btn-primary" onclick="document.getElementById('next-of-kin-modal').style.display='none';">Close</button>
            </div>
        </div>
    </div>

    <style>
        .tab-button {
            background: none;
            border: none;
            padding: 12px 18px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease;
            white-space: nowrap;
        }
        .tab-button:hover {
            color: var(--primary-color);
        }
        .active-tab {
            color: var(--primary-color) !important;
            border-bottom: 3px solid var(--primary-color) !important;
        }
    </style>

    <script>
        function switchTab(tabName) {
            // Hide all tab panes
            const panes = document.querySelectorAll('.tab-pane');
            panes.forEach(pane => pane.style.display = 'none');

            // Deactivate all tab buttons
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(btn => btn.classList.remove('active-tab'));

            // Show selected tab pane & activate button
            const selectedPane = document.getElementById('tab-content-' + tabName);
            if (selectedPane) {
                selectedPane.style.display = 'block';
            }

            const selectedBtn = document.getElementById('tab-btn-' + tabName);
            if (selectedBtn) {
                selectedBtn.classList.add('active-tab');
            }

            // Update URL hash without full reload
            if (history.pushState) {
                history.pushState(null, null, '#' + tabName);
            }
        }

        function updateLoanEstimate(amount, months) {
            const principal = parseFloat(amount) || 0;
            const period = parseInt(months) || 6;
            const interest = principal * 0.10; // 10% standard
            const total = principal + interest;
            const monthly = period > 0 ? (total / period) : 0;

            document.getElementById('estimate_display').innerText = 
                'UGX ' + monthly.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' / month';
        }

        // On page load, respect URL hash
        window.addEventListener('DOMContentLoaded', () => {
            const hash = window.location.hash.replace('#', '');
            if (['savings', 'loans', 'schedule', 'apply-loan', 'security'].includes(hash)) {
                switchTab(hash);
            }
        });
    </script>
@endsection
