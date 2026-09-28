@extends('components.layouts.app')

@section('title', 'System Reports')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1>System Reports</h1>
            <div style="font-size: 12px; color: var(--text-secondary);">Financial summaries and high-level SACCO performance</div>
        </div>
        <div>
            <a href="{{ route('reports.export.pdf') }}" class="btn btn-secondary" style="margin-right: 8px;">Export to PDF</a>
            <a href="{{ route('reports.export.excel') }}" class="btn btn-secondary">Export to Excel (CSV)</a>
        </div>
    </div>

    <div class="grid grid-cols-4" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 24px;">
        <div class="card" style="padding: 20px;">
            <div style="font-size: 12px; color: var(--text-secondary); margin-bottom: 8px;">Total Members</div>
            <div style="font-size: 24px; font-weight: 700; color: var(--text-primary);">{{ $metrics['total_members'] }}</div>
            <div style="font-size: 12px; margin-top: 8px; color: var(--success-color);">{{ $metrics['active_members'] }} Active</div>
        </div>
        
        <div class="card" style="padding: 20px;">
            <div style="font-size: 12px; color: var(--text-secondary); margin-bottom: 8px;">Total Savings (UGX)</div>
            <div style="font-size: 24px; font-weight: 700; color: var(--primary-color);">{{ number_format($metrics['total_savings'], 0) }}</div>
        </div>

        <div class="card" style="padding: 20px;">
            <div style="font-size: 12px; color: var(--text-secondary); margin-bottom: 8px;">Outstanding Loans (UGX)</div>
            <div style="font-size: 24px; font-weight: 700; color: var(--danger-color);">{{ number_format($metrics['outstanding_loan_balance'], 0) }}</div>
            <div style="font-size: 12px; margin-top: 8px; color: var(--text-secondary);">Total Disbursed: {{ number_format($metrics['total_loans_disbursed'], 0) }}</div>
        </div>

        <div class="card" style="padding: 20px;">
            <div style="font-size: 12px; color: var(--text-secondary); margin-bottom: 8px;">Total Repayments (UGX)</div>
            <div style="font-size: 24px; font-weight: 700; color: var(--success-color);">{{ number_format($metrics['total_repayments'], 0) }}</div>
        </div>
    </div>

    <div class="grid" style="grid-template-columns: 1fr 1fr; gap: 24px;">
        <div class="card">
            <div class="card-header">Savings vs Outstanding Loans Comparison</div>
            <div style="height: 300px; display: flex; align-items: center; justify-content: center; padding: 16px;">
                @if(empty($chartData['data']))
                    <div style="text-align: center; color: var(--text-secondary);">No loan data available for chart.</div>
                @else
                    <canvas id="loanChart"></canvas>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">Recent Loan Activity</div>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Loan ID</th>
                            <th>Member</th>
                            <th>Amount (UGX)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLoans as $loan)
                            <tr>
                                <td>LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $loan->member->name }}</td>
                                <td>{{ number_format($loan->principal_amount, 0) }}</td>
                                <td>
                                    @if($loan->status === 'Active')
                                        <span class="badge badge-success">{{ $loan->status }}</span>
                                    @elseif($loan->status === 'Pending')
                                        <span class="badge badge-warning" style="background: #fff4ce; color: #795500;">{{ $loan->status }}</span>
                                    @else
                                        <span class="badge badge-info">{{ $loan->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 16px; color: var(--text-secondary);">No loans recorded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @if(!empty($chartData['data']))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('loanChart');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($chartData['labels']) !!},
                    datasets: [{
                        label: 'Amount (UGX)',
                        data: {!! json_encode($chartData['data']) !!},
                        backgroundColor: [
                            '#107C10', // Success green for savings
                            '#D83B01', // Warning/Danger red for loans
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        </script>
    @endif
@endsection
