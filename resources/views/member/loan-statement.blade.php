<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Statement - LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 24px;
            background: #f8f9fa;
        }
        .container {
            max-width: 850px;
            margin: 0 auto;
            background: #fff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #0078d4;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }
        .sacco-name {
            font-size: 22px;
            font-weight: bold;
            color: #0078d4;
            margin: 0 0 4px 0;
        }
        .statement-title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            color: #666;
            margin: 0;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }
        .info-box {
            background: #f3f2f1;
            padding: 14px 18px;
            border-radius: 6px;
            font-size: 13px;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 13px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f3f2f1;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .no-print {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn {
            background: #0078d4;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
        }
        .btn-outline {
            background: #edebe9;
            color: #333;
        }
        @media print {
            body { background: none; padding: 0; }
            .container { box-shadow: none; padding: 0; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="no-print">
            <a href="{{ route('member.dashboard', ['member_id' => $loan->member_id]) }}" class="btn btn-outline">&larr; Back to Dashboard</a>
            <div>
                <a href="{{ route('member.loans.statement', ['loan' => $loan->id, 'member_id' => $loan->member_id, 'format' => 'csv']) }}" class="btn btn-outline" style="margin-right: 8px;">Download CSV</a>
                <button onclick="window.print()" class="btn">Print / Save as PDF</button>
            </div>
        </div>

        <div class="header">
            <div>
                <h1 class="sacco-name">{{ \App\Models\Setting::getValue('sacco_name', 'Kulima Agri SACCO Management System') }}</h1>
                <div class="statement-title">Official Loan Repayment Statement</div>
                <div style="font-size: 12px; color: #666; margin-top: 4px;">Requirement MD-028: Amortization & Payment History</div>
            </div>
            <div style="text-align: right; font-size: 12px; color: #666;">
                <div><strong>Loan Reference:</strong> LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</div>
                <div><strong>Generated On:</strong> {{ date('F j, Y, g:i a') }}</div>
            </div>
        </div>

        <!-- Overdue Penalty Warning if applicable (MD-027) -->
        @if($loan->penalty_amount > 0 || $loan->is_overdue)
            <div style="background-color: #fde7e9; border: 1px solid #f8c9ce; border-left: 5px solid #d83b01; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 13px; color: #d83b01;">
                <strong>OVERDUE PENALTY NOTICE (Requirement MD-027):</strong> 
                This loan has accumulated <strong>UGX {{ number_format($loan->penalty_amount, 2) }}</strong> in overdue penalties.
                @if($loan->days_overdue > 0)
                    Maturity date elapsed by {{ $loan->days_overdue }} day(s).
                @endif
            </div>
        @endif

        <div class="grid-2">
            <div class="info-box">
                <div style="font-weight: bold; margin-bottom: 6px; color: #0078d4;">BORROWER INFORMATION</div>
                <div><strong>Full Name:</strong> {{ $loan->member->name }}</div>
                <div><strong>Membership Number:</strong> {{ $loan->member->member_number }}</div>
                <div><strong>NIN:</strong> {{ $loan->member->nin }}</div>
                <div><strong>Contact:</strong> {{ $loan->member->contact }}</div>
            </div>

            <div class="info-box">
                <div style="font-weight: bold; margin-bottom: 6px; color: #0078d4;">CREDIT FACILITY SUMMARY</div>
                <div><strong>Loan Type:</strong> {{ $loan->loan_type ?? 'Agricultural Loan' }}</div>
                <div><strong>Principal Disbursed:</strong> UGX {{ number_format($loan->principal_amount, 2) }}</div>
                <div><strong>Interest Rate:</strong> {{ $loan->interest_rate }}% ({{ $loan->duration_months }} Months)</div>
                <div><strong>Total Liability:</strong> UGX {{ number_format($loan->effective_total, 2) }}</div>
                <div><strong>Total Amount Paid:</strong> <span style="color: #107c10; font-weight: bold;">UGX {{ number_format($loan->amount_paid, 2) }}</span></div>
                <div><strong>Outstanding Balance:</strong> <span style="color: #d83b01; font-weight: bold;">UGX {{ number_format($loan->balance, 2) }}</span></div>
                <div><strong>Status:</strong> <strong>{{ $loan->status }}</strong></div>
            </div>
        </div>

        <!-- Repayment Schedule (Requirement MD-026) -->
        <h3 style="font-size: 15px; margin: 24px 0 8px 0; color: #0078d4;">Scheduled Installments (Requirement MD-026)</h3>
        <table>
            <thead>
                <tr>
                    <th>Installment #</th>
                    <th>Due Date</th>
                    <th class="text-right">Installment Amount</th>
                    <th class="text-right">Amount Paid</th>
                    <th class="text-right">Remaining Balance</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loan->repayment_schedule as $sch)
                    <tr>
                        <td>Installment {{ $sch['installment_number'] }}</td>
                        <td>{{ $sch['due_date']->format('M d, Y') }}</td>
                        <td class="text-right">UGX {{ number_format($sch['installment_amount'], 2) }}</td>
                        <td class="text-right" style="color: #107c10; font-weight: bold;">UGX {{ number_format($sch['amount_paid'], 2) }}</td>
                        <td class="text-right" style="color: #d83b01; font-weight: bold;">UGX {{ number_format($sch['remaining_balance'], 2) }}</td>
                        <td>
                            @if($sch['status'] === 'Paid')
                                <span style="color: #107c10; font-weight: bold;">Paid</span>
                            @elseif($sch['status'] === 'Partially Paid')
                                <span style="color: #d83b01; font-weight: bold;">Partially Paid</span>
                            @elseif($sch['status'] === 'Overdue')
                                <span style="color: #d83b01; font-weight: bold;">Overdue</span>
                            @else
                                <span style="color: #666;">Pending</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Actual Repayments Posted -->
        <h3 style="font-size: 15px; margin: 24px 0 8px 0; color: #0078d4;">Actual Repayments Received ({{ $loan->repayments->count() }})</h3>
        <table>
            <thead>
                <tr>
                    <th>Receipt No</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th class="text-right">Amount (UGX)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loan->repayments as $rep)
                    <tr>
                        <td>RP-{{ str_pad($rep->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $rep->paid_at ? $rep->paid_at->format('M d, Y, g:i a') : 'N/A' }}</td>
                        <td><span style="color: #107c10; font-weight: bold;">{{ $rep->status }}</span></td>
                        <td class="text-right" style="font-weight: bold; color: #107c10;">+ UGX {{ number_format($rep->amount, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 18px; color: #666;">
                            No installment repayments have been posted for this loan yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 36px; border-top: 1px solid #ddd; padding-top: 16px; font-size: 11px; color: #888; display: flex; justify-content: space-between;">
            <span>Kulima Agri SACCO Electronic Credit Statement &mdash; Verified and Certified.</span>
            <span>Page 1 of 1</span>
        </div>
    </div>
</body>
</html>
