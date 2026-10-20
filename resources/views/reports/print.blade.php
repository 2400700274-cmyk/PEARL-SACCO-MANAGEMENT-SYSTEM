<!DOCTYPE html>
<html>
<head>
    <title>SACCO Report - {{ date('Y-m-d') }}</title>
    <style>
        body { font-family: sans-serif; color: #333; padding: 20px; }
        h1 { color: #0078D4; margin-bottom: 5px; }
        .subtitle { color: #666; margin-bottom: 30px; font-size: 14px; }
        .metrics { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .metrics th, .metrics td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .metrics th { background-color: #f3f2f1; width: 40%; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 10px; text-align: left; border: 1px solid #ddd; }
        .table th { background-color: #f3f2f1; }
        .no-print { margin-bottom: 20px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" style="padding: 10px 20px; background: #0078D4; color: white; border: none; border-radius: 4px; cursor: pointer;">Click to Print / Save as PDF</button>
        <a href="{{ route('reports.index') }}" style="margin-left: 10px; text-decoration: none; color: #0078D4;">Back to Reports</a>
    </div>

    <h1>{{ \App\Models\Setting::getValue('sacco_name', 'Pearl SACCO Management System') }} System Report</h1>
    <div class="subtitle">Generated on: {{ date('F j, Y, g:i a') }}</div>
    
    <h2>Key Metrics</h2>
    <table class="metrics">
        <tr><th>Total Members</th><td>{{ $metrics['total_members'] }} ({{ $metrics['active_members'] }} Active)</td></tr>
        <tr><th>Total Savings (UGX)</th><td>{{ number_format($metrics['total_savings'], 2) }}</td></tr>
        <tr><th>Outstanding Loans (UGX)</th><td>{{ number_format($metrics['outstanding_loan_balance'], 2) }}</td></tr>
        <tr><th>Total Repayments (UGX)</th><td>{{ number_format($metrics['total_repayments'], 2) }}</td></tr>
    </table>

    <h2>Recent Loans</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Member</th>
                <th>Principal (UGX)</th>
                <th>Balance (UGX)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentLoans as $loan)
                <tr>
                    <td>LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $loan->member->name }}</td>
                    <td>{{ number_format($loan->principal_amount, 2) }}</td>
                    <td>{{ number_format($loan->balance, 2) }}</td>
                    <td>{{ $loan->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // Auto trigger print dialog on load
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
