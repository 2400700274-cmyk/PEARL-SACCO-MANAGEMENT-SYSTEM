<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Savings Statement - {{ $member->member_number }}</title>
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
            margin-top: 16px;
            font-size: 13px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px 12px;
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
            <a href="{{ route('member.dashboard', ['member_id' => $member->id]) }}" class="btn btn-outline">&larr; Back to Dashboard</a>
            <div>
                <a href="{{ route('member.savings.statement', ['member_id' => $member->id, 'from_date' => $fromDate, 'to_date' => $toDate, 'format' => 'csv']) }}" class="btn btn-outline" style="margin-right: 8px;">Download CSV</a>
                <button onclick="window.print()" class="btn">Print / Save as PDF</button>
            </div>
        </div>

        <div class="header">
            <div>
                <h1 class="sacco-name">{{ \App\Models\Setting::getValue('sacco_name', 'Kulima Agri SACCO Management System') }}</h1>
                <div class="statement-title">Member Savings Account Statement</div>
                <div style="font-size: 12px; color: #666; margin-top: 4px;">Requirement MD-014: Official Transaction Record</div>
            </div>
            <div style="text-align: right; font-size: 12px; color: #666;">
                <div><strong>Issued On:</strong> {{ date('F j, Y, g:i a') }}</div>
                <div><strong>Period:</strong> {{ $fromDate ?? 'Earliest' }} &mdash; {{ $toDate ?? 'Latest' }}</div>
            </div>
        </div>

        <div class="grid-2">
            <div class="info-box">
                <div style="font-weight: bold; margin-bottom: 6px; color: #0078d4;">MEMBER DETAILS</div>
                <div><strong>Full Name:</strong> {{ $member->name }}</div>
                <div><strong>Membership Number:</strong> {{ $member->member_number }}</div>
                <div><strong>NIN:</strong> {{ $member->nin }}</div>
                <div><strong>Registered Contact:</strong> {{ $member->contact }}</div>
            </div>

            <div class="info-box">
                <div style="font-weight: bold; margin-bottom: 6px; color: #107c10;">ACCOUNT SUMMARY</div>
                <div><strong>Total Active Savings:</strong> UGX {{ number_format($member->total_savings_balance, 2) }}</div>
                <div><strong>Active Loan Liability:</strong> UGX {{ number_format($member->active_loan_balance, 2) }}</div>
                <div><strong>Net Available Loan Limit:</strong> UGX {{ number_format($member->available_loan_limit, 2) }}</div>
                <div><strong>Account Status:</strong> {{ $member->status }}</div>
            </div>
        </div>

        <h3 style="font-size: 15px; margin-bottom: 8px;">Transaction Activity ({{ $transactions->count() }} Records)</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th class="text-right">Amount (UGX)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                    <tr>
                        <td>{{ $tx->transaction_date ? $tx->transaction_date->format('M d, Y') : 'N/A' }}</td>
                        <td>
                            @if(strtolower($tx->type) === 'deposit' || strtolower($tx->type) === 'credit')
                                <span style="color: #107c10; font-weight: bold;">Deposit</span>
                            @else
                                <span style="color: #d83b01; font-weight: bold;">Withdrawal</span>
                            @endif
                        </td>
                        <td>{{ $tx->description ?? 'Counter transaction' }}</td>
                        <td class="text-right" style="font-weight: bold; color: {{ strtolower($tx->type) === 'deposit' ? '#107c10' : '#d83b01' }};">
                            {{ strtolower($tx->type) === 'deposit' ? '+' : '-' }} {{ number_format($tx->amount, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 24px; color: #666;">
                            No savings transactions recorded within this date range.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top: 36px; border-top: 1px solid #ddd; padding-top: 16px; font-size: 11px; color: #888; display: flex; justify-content: space-between;">
            <span>Generated electronically from Kulima Agri SACCO Member Portal.</span>
            <span>Page 1 of 1</span>
        </div>
    </div>
</body>
</html>
