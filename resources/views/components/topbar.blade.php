<header class="topbar" style="background-color: #ffffff; color: var(--text-primary); border-bottom: 1px solid var(--border-color); box-shadow: 0 1px 3px rgba(0,0,0,0.02); height: 60px; padding: 0 24px;">
    <div class="brand" style="font-size: 17px; font-weight: 700; color: var(--primary-color); display: flex; align-items: center; gap: 10px; letter-spacing: 0.3px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
        {{ strtoupper(auth()->user()->isSuperAdmin() ? 'PEARL SACCO MANAGEMENT SYSTEM' : \App\Models\Setting::getValue('sacco_name', 'Pearl SACCO Management System')) }}
    </div>
    
    <div class="user-menu" style="display: flex; align-items: center; gap: 20px;">
        <!-- Notification Bell -->
        <button class="notifications" style="background: none; border: none; cursor: pointer; color: var(--text-secondary); position: relative; padding: 4px; display: flex; align-items: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            <span style="position: absolute; top: 2px; right: 4px; width: 8px; height: 8px; background-color: var(--danger-color); border-radius: 50%; border: 2px solid white;"></span>
        </button>
        
        <!-- Divider -->
        <div style="height: 24px; width: 1px; background-color: var(--border-color);"></div>
        
        <!-- User Profile with Dynamic Role Badge -->
        <div class="user-profile" style="display: flex; align-items: center; gap: 12px;">
            @if(auth()->user()->profile_photo_path)
                <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 1px solid var(--border-light);">
            @else
                <div style="width: 36px; height: 36px; border-radius: 50%; background-color: rgba(0, 120, 212, 0.1); color: var(--primary-color); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; border: 1px solid rgba(0, 120, 212, 0.2);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
            
            <div style="display: flex; flex-direction: column; gap: 2px;">
                <span style="font-weight: 600; font-size: 13px; color: var(--text-primary); line-height: 1.2;">{{ auth()->user()->name }}</span>
                <span style="font-size: 11px; font-weight: 600; color: var(--primary-color); background: rgba(0, 120, 212, 0.08); padding: 1px 7px; border-radius: 4px; width: fit-content; line-height: 1.4; border: 1px solid rgba(0, 120, 212, 0.15);">
                    {{ auth()->user()->role?->name ?? 'Staff' }}
                </span>
            </div>
            
            <form method="POST" action="{{ route('logout') }}" style="margin: 0; margin-left: 8px;">
                @csrf
                <button type="submit" title="Logout of Pearl SACCO System" style="background: none; border: none; color: var(--text-secondary); cursor: pointer; display: flex; align-items: center; justify-content: center; padding: 6px; border-radius: 6px; transition: background 0.2s, color 0.2s;" onmouseover="this.style.backgroundColor='#f3f2f1'; this.style.color='var(--danger-color)'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--text-secondary)'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                </button>
            </form>
        </div>
    </div>
</header>
