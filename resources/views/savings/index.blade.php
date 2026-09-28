@extends('components.layouts.app')

@section('title', 'Savings Accounts')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1>Savings Accounts</h1>
            <div style="font-size: 12px; color: var(--text-secondary);">Manage member savings and balances</div>
        </div>
    </div>

    @if(session('success'))
        <div style="background-color: #dff6dd; color: var(--success-color); padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; border: 1px solid #c8e6c9;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <span>Savings Directory</span>
            <div>
                <input type="text" placeholder="Search accounts..." style="padding: 6px 12px; border: 1px solid var(--border-color); border-radius: 2px;">
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Account ID</th>
                        <th>Member No.</th>
                        <th>Member Name</th>
                        <th>Status</th>
                        <th>Current Balance (UGX)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                        <tr>
                            <td style="font-weight: 600;">SAV-{{ str_pad($account->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $account->member->member_number }}</td>
                            <td>{{ $account->member->name }}</td>
                            <td>
                                @if($account->status === 'Active')
                                    <span class="badge badge-success">{{ $account->status }}</span>
                                @else
                                    <span class="badge badge-warning">{{ $account->status }}</span>
                                @endif
                            </td>
                            <td style="font-weight: 600;">{{ number_format($account->balance, 2) }}</td>
                            <td>
                                <a href="{{ route('savings.show', $account) }}" class="btn btn-secondary" style="padding: 4px 8px; font-size: 12px;">View</a>
                                <a href="{{ route('savings.transaction', $account) }}" class="btn btn-primary" style="padding: 4px 8px; font-size: 12px;">Transact</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 32px; color: var(--text-secondary);">
                                <div style="margin-bottom: 8px; font-size: 24px;">💰</div>
                                No savings accounts found.<br>
                                <span style="font-size: 13px;">Savings accounts are automatically created when members are registered.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($accounts->hasPages())
            <div style="padding: 16px; border-top: 1px solid var(--border-light);">
                {{ $accounts->links() }}
            </div>
        @endif
    </div>
@endsection
