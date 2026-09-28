<aside class="sidebar">
    <div style="padding: 16px; border-bottom: 1px solid var(--border-color); font-weight: 600; color: var(--primary-color);">
        {{ \App\Models\Setting::getValue('sacco_name', 'Kulima Agri-SACCO') }}
    </div>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'active' : '' }}">
                Members
            </a>
        </li>
        <li>
            <a href="{{ route('savings.index') }}" class="{{ request()->routeIs('savings.*') ? 'active' : '' }}">
                Savings
            </a>
        </li>
        <li>
            <a href="{{ route('loans.index') }}" class="{{ request()->routeIs('loans.*') ? 'active' : '' }}">
                Loans
            </a>
        </li>
        <li>
            <a href="{{ route('repayments.index') }}" class="{{ request()->routeIs('repayments.*') || request()->routeIs('loans.repayments.*') ? 'active' : '' }}">
                Repayments
            </a>
        </li>
        <li>
            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                Reports
            </a>
        </li>
    </ul>
    <div style="padding: 16px; border-top: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 12px;">
        @if(auth()->user()->hasPermission('manage-settings'))
            <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}" style="color: {{ request()->routeIs('settings.*') ? 'var(--primary-color)' : 'var(--text-secondary)' }}; font-size: 13px; font-weight: {{ request()->routeIs('settings.*') ? '600' : '400' }}; display: block; text-decoration: none;">Settings</a>
        @endif
        @if(auth()->user()->hasPermission('manage-staff'))
            <a href="{{ route('staff.index') }}" class="{{ request()->routeIs('staff.*') ? 'active' : '' }}" style="color: {{ request()->routeIs('staff.*') ? 'var(--primary-color)' : 'var(--text-secondary)' }}; font-size: 13px; font-weight: {{ request()->routeIs('staff.*') ? '600' : '400' }}; display: block; text-decoration: none;">Staff Directory</a>
        @endif
    </div>
</aside>
