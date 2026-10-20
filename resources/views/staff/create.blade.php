@extends('components.layouts.app')

@section('title', 'Allocate Staff Account')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div>
            <a href="{{ route('staff.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Back to Staff Directory
            </a>
            <h1 style="margin: 0; font-size: 26px; color: var(--text-primary);">Allocate New Staff Account</h1>
        </div>
    </div>

    <div class="card" style="max-width: 900px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 20px 24px;">
            <h2 style="margin: 0; font-size: 16px; color: var(--primary-color);">Staff Profile, Role Allocation & Credentials</h2>
        </div>
        
        <form method="POST" action="{{ route('staff.store') }}" enctype="multipart/form-data" style="padding: 24px;">
            @csrf
            
            <div style="display: flex; gap: 40px; flex-wrap: wrap;">
                
                <!-- Left Column: Photo Upload -->
                <div style="width: 200px; display: flex; flex-direction: column; align-items: center;">
                    <div style="width: 150px; height: 150px; border-radius: 50%; overflow: hidden; background-color: var(--bg-color); border: 2px dashed var(--border-color); display: flex; align-items: center; justify-content: center; margin-bottom: 16px; position: relative; cursor: pointer;" onclick="document.getElementById('photo-input').click()">
                        <img id="photo-preview" src="#" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                        <div id="photo-placeholder" style="text-align: center; color: var(--text-secondary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <div style="font-size: 12px; font-weight: 500;">Click to upload</div>
                        </div>
                    </div>
                    <input type="file" id="photo-input" name="photo" class="form-control" accept="image/*" style="display: none;" onchange="previewImage(this, 'photo-preview', 'photo-placeholder')">
                    @error('photo')<span style="color: var(--danger-color); font-size: 12px; text-align: center;">{{ $message }}</span>@enderror
                    <p style="font-size: 12px; color: var(--text-secondary); text-align: center;">Allowed formats: JPG, PNG. Max size: 2MB.</p>
                </div>

                <!-- Right Column: Form Fields -->
                <div style="flex: 1; min-width: 320px;">
                    <div class="form-group" style="margin-bottom: 18px;">
                        <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Staff Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus placeholder="e.g. Dennis Mugisha">
                        @error('name')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Uganda National ID (NIN)</label>
                            <input type="text" id="nin" name="nin" value="{{ old('nin') }}" maxlength="14" class="form-control" required placeholder="CM90012345ABCD" style="text-transform: uppercase;">
                            <span style="font-size: 11px; color: var(--text-secondary); margin-top: 4px; display: block;">14 characters Uganda NIRA format</span>
                            @error('nin')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Staff Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required placeholder="staff@example.com">
                            <div id="email-feedback" style="display: none; font-size: 12px; margin-top: 4px; font-weight: 500;"></div>
                            @error('email')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 22px;">
                        <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Allocated Operational Role</label>
                        <select name="role_id" class="form-control" required>
                            <option value="">-- Select Role Allocation --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }} &mdash; {{ $role->description }}
                                </option>
                            @endforeach
                        </select>
                        <span style="font-size: 12px; color: var(--primary-color); margin-top: 5px; display: block;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -1px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                            The staff member's allocated role will be actively displayed across their topbar, profile, and dashboard whenever they login.
                        </span>
                        @error('role_id')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 24px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Initial Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Min. 8 characters">
                            @error('password')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>
                        
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; display: block; margin-bottom: 6px;">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Repeat password">
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px; border-top: 1px solid var(--border-light); padding-top: 20px;">
                        <button type="submit" class="btn btn-primary" style="padding: 10px 28px; font-weight: 600;">Allocate Staff Member</button>
                        <a href="{{ route('staff.index') }}" class="btn btn-secondary" style="padding: 10px 24px;">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(input, previewId, placeholderId) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
                placeholder.style.display = 'block';
            }
        }

        document.getElementById('nin').addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        });

        // Real-time email domain and uniqueness validation
        const emailInput = document.getElementById('email');
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
