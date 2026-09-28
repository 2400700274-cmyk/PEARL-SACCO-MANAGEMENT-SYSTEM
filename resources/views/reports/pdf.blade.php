<!DOCTYPE html>
<html>
<head>
    <title>SACCO Report</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        h1 { color: #0078D4; }
        .metrics { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .metrics th, .metrics td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        .metrics th { background-color: #f3f2f1; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        .table th { background-color: #f3f2f1; }
    </style>
</head>
<body>
    <h1>Kulima Agri-SACCO System Report</h1>
    <p>Generated on: {{ date('F j, Y') }}</p>
    
    <h2>Key Metrics</h2>
    <table class="metrics">
        <tr><th>Total Members</th><td>{{ $metrics['total_members'] }}</td></tr>
        <tr><th>Active Members</th><td>{{ $metrics['active_members'] }}</td></tr>
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
</body>
</html>
