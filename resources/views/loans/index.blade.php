@extends('components.layouts.app')

@section('title', 'Loans Management')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1>Loans Management</h1>
            <div style="font-size: 12px; color: var(--text-secondary);">Manage loan applications, approvals, and active loans</div>
        </div>
        <a href="{{ route('loans.create') }}" class="btn btn-primary">+ New Loan Application</a>
    </div>

    @if(session('success'))
        <div style="background-color: #dff6dd; color: var(--success-color); padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; border: 1px solid #c8e6c9;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <span>Loans Directory</span>
            <div>
                <input type="text" placeholder="Search loans..." style="padding: 6px 12px; border: 1px solid var(--border-color); border-radius: 2px;">
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Loan ID</th>
                        <th>Member Name</th>
                        <th>Principal (UGX)</th>
                        <th>Total Payable</th>
                        <th>Balance (UGX)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td style="font-weight: 600;">LN-{{ str_pad($loan->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $loan->member->name }}</td>
                            <td>{{ number_format($loan->principal_amount, 2) }}</td>
                            <td>{{ number_format($loan->total_payable, 2) }}</td>
                            <td style="font-weight: 600;">{{ number_format($loan->balance, 2) }}</td>
                            <td>
                                @if($loan->status === 'Active')
                                    <span class="badge badge-success">{{ $loan->status }}</span>
                                @elseif($loan->status === 'Pending')
                                    <span class="badge badge-warning" style="background: #fff4ce; color: #795500;">{{ $loan->status }}</span>
                                @else
                                    <span class="badge badge-info">{{ $loan->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('loans.show', $loan) }}" class="btn btn-secondary" style="padding: 4px 8px; font-size: 12px;">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 32px; color: var(--text-secondary);">
                                <div style="margin-bottom: 8px; font-size: 24px;">📄</div>
                                No loans found.<br>
                                <a href="{{ route('loans.create') }}" style="font-size: 13px; margin-top: 8px; display: inline-block;">Create the first loan application</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($loans->hasPages())
            <div style="padding: 16px; border-top: 1px solid var(--border-light);">
                {{ $loans->links() }}
            </div>
        @endif
    </div>
@endsection
