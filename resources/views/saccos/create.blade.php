@extends('components.layouts.app')

@section('title', 'Register New SACCO - Pearl SACCO Management System')

@section('content')
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('saccos.index') }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to SACCOs Directory</a>
        <h1 style="margin: 0; font-size: 24px;">Register New SACCO Society</h1>
    </div>

    <div class="card" style="max-width: 860px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 18px 24px;">
            <h2 style="margin: 0; font-size: 16px; color: var(--primary-color);">SACCO Provisioning & Administrator Assignment</h2>
        </div>

        <form method="POST" action="{{ route('saccos.store') }}" style="padding: 24px;">
            @csrf

            <div style="font-weight: 700; font-size: 13px; color: var(--primary-color); border-bottom: 1px solid var(--border-light); padding-bottom: 6px; margin-bottom: 16px; text-transform: uppercase;">
                1. SACCO Organization Information
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">SACCO Cooperative Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required placeholder="e.g. Arua Farmers & Traders SACCO" autofocus>
                @error('name')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Registration / Certificate Number</label>
                    <input type="text" name="registration_number" value="{{ old('registration_number') }}" class="form-control" placeholder="e.g. COOP/2026/0921">
                    @error('registration_number')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Official Phone Contact</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="+256 700 000 000">
                    @error('phone')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Headquarters Address</label>
                <textarea name="address" rows="2" class="form-control" required placeholder="Physical address, Town, District">{{ old('address') }}</textarea>
                @error('address')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
            </div>

            <div style="font-weight: 700; font-size: 13px; color: var(--primary-color); border-bottom: 1px solid var(--border-light); padding-bottom: 6px; margin-bottom: 16px; text-transform: uppercase;">
                2. Designate SACCO Administrator
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Administrator Full Name</label>
                <input type="text" name="admin_name" value="{{ old('admin_name') }}" class="form-control" required placeholder="e.g. David Kasule">
                @error('admin_name')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Admin Uganda National ID (NIN)</label>
                    <input type="text" id="admin_nin" name="admin_nin" value="{{ old('admin_nin') }}" maxlength="14" class="form-control" placeholder="CM90012345ABCD" style="text-transform: uppercase;">
                    <span style="font-size: 11px; color: var(--text-secondary); margin-top: 4px; display: block;">14 characters Uganda NIRA format</span>
                    @error('admin_nin')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Administrator Email Address</label>
                    <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email') }}" class="form-control" required placeholder="admin@sacco.org">
                    <div id="email-feedback" style="display: none; font-size: 12px; margin-top: 4px; font-weight: 500;"></div>
                    @error('admin_email')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div class="form-group">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Initial Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Min. 8 characters">
                    @error('password')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Repeat password">
                </div>
            </div>

            <div style="display: flex; gap: 12px; border-top: 1px solid var(--border-light); padding-top: 20px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 28px; font-weight: 600;">Activate & Provision SACCO</button>
                <a href="{{ route('saccos.index') }}" class="btn btn-secondary" style="padding: 10px 24px;">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('admin_nin').addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        });

        const emailInput = document.getElementById('admin_email');
        const feedback = document.getElementById('email-feedback');
        let debounceTimer = null;

        emailInput.addEventListener('input', function() {
            const val = emailInput.value.trim();
            clearTimeout(debounceTimer);

            if (val.length === 0 || !val.includes('@') || !val.includes('.')) {
                feedback.style.display = 'none';
                return;
            }

            feedback.style.display = 'block';
            feedback.style.color = '#0078d4';
            feedback.textContent = 'Verifying email domain...';

            debounceTimer = setTimeout(() => {
                fetch('{{ route("api.check-email") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: val, context: 'staff' })
                })
                .then(res => res.json())
                .then(data => {
                    feedback.style.display = 'block';
                    feedback.style.color = data.valid ? '#107c10' : '#d13438';
                    feedback.textContent = data.message;
                })
                .catch(() => {
                    feedback.style.display = 'none';
                });
            }, 400);
        });
    </script>
@endsection
