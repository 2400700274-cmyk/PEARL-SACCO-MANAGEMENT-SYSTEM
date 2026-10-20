@extends('components.layouts.app')

@section('title', 'System Settings')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1>System Settings</h1>
            <div style="font-size: 12px; color: var(--text-secondary);">Configure application preferences and SACCO details</div>
        </div>
    </div>

    <style>
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 13px;
            color: var(--text-primary);
        }
        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 120, 212, 0.1);
        }
    </style>

    @if(session('success'))
        <div style="background-color: #dff6dd; color: var(--success-color); padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; border: 1px solid #c8e6c9;">
            {{ session('success') }}
        </div>
    @endif

    @php
        $tab = request('tab', 'general');
        
        function activeStyle($current, $target) {
            if ($current === $target) {
                return 'padding: 16px; border-bottom: 1px solid var(--border-light); text-decoration: none; font-weight: 600; color: var(--primary-color); border-left: 4px solid var(--primary-color); background: #f3f2f1; display: block;';
            }
            return 'padding: 16px; border-bottom: 1px solid var(--border-light); text-decoration: none; color: var(--text-secondary); border-left: 4px solid transparent; display: block;';
        }
    @endphp

    <div class="grid" style="grid-template-columns: 1fr 3fr; gap: 24px;">
        <!-- Settings Sidebar -->
        <div class="card" style="padding: 0;">
            <div style="display: flex; flex-direction: column;">
                <a href="?tab=general" style="{{ activeStyle($tab, 'general') }}">General</a>
                <a href="?tab=account" style="{{ activeStyle($tab, 'account') }}">Account</a>
                <a href="?tab=localization" style="{{ activeStyle($tab, 'localization') }}">Localization</a>
                <a href="?tab=notifications" style="{{ activeStyle($tab, 'notifications') }}">Notifications</a>
                <a href="?tab=security" style="{{ activeStyle($tab, 'security') }}">Security</a>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="card">
            @if($tab === 'general')
                <div class="card-header">General Settings</div>
                <form method="POST" action="{{ route('settings.update') }}">
                    @csrf
                    <input type="hidden" name="tab" value="general">
                    
                    <div style="margin-bottom: 32px;">
                        <h3 style="font-size: 14px; margin-bottom: 16px; color: var(--text-primary); border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">Organization Profile</h3>
                        
                        <div class="grid grid-cols-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div class="form-group">
                                <label class="form-label">SACCO Name</label>
                                <input type="text" name="sacco_name" value="{{ \App\Models\Setting::getValue('sacco_name', 'Pearl SACCO Management System') }}" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Registration Number</label>
                                <input type="text" name="reg_number" value="{{ \App\Models\Setting::getValue('reg_number', '') }}" class="form-control" placeholder="Optional">
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 16px;">
                            <label class="form-label">Headquarters Address</label>
                            <textarea name="address" class="form-control" rows="3" required>{{ \App\Models\Setting::getValue('address', '') }}</textarea>
                        </div>
                    </div>

                    <div style="border-top: 1px solid var(--border-light); padding-top: 16px;">
                        <button type="submit" class="btn btn-primary" style="padding: 8px 24px;">Save Settings</button>
                    </div>
                </form>
                
            @elseif($tab === 'account')
                <div class="card-header">Account Settings</div>
                <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="tab" value="account">
                    
                    <div style="margin-bottom: 32px;">
                        <h3 style="font-size: 14px; margin-bottom: 16px; color: var(--text-primary); border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">Administrator Profile</h3>
                        
                        <div style="display: flex; gap: 40px; flex-wrap: wrap;">
                            <!-- Left Column: Photo Upload -->
                            <div style="width: 180px; display: flex; flex-direction: column; align-items: center;">
                                <div style="width: 140px; height: 140px; border-radius: 50%; overflow: hidden; background-color: var(--bg-color); border: 2px dashed var(--border-color); display: flex; align-items: center; justify-content: center; margin-bottom: 16px; position: relative; cursor: pointer;" onclick="document.getElementById('photo-input').click()">
                                    @if(auth()->user()->profile_photo_path)
                                        <img id="photo-preview" src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                        <div id="photo-placeholder" style="text-align: center; color: var(--text-secondary); display: none;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                            <div style="font-size: 11px; font-weight: 500;">Click to upload</div>
                                        </div>
                                    @else
                                        <img id="photo-preview" src="#" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;">
                                        <div id="photo-placeholder" style="text-align: center; color: var(--text-secondary);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                            <div style="font-size: 11px; font-weight: 500;">Click to upload</div>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" id="photo-input" name="profile_image" class="form-control" accept="image/*" style="display: none;" onchange="previewImage(this, 'photo-preview', 'photo-placeholder')">
                                @error('profile_image')<span style="color: var(--danger-color); font-size: 12px; text-align: center;">{{ $message }}</span>@enderror
                                <p style="font-size: 12px; color: var(--text-secondary); text-align: center;">Allowed formats: JPG, PNG. Max size: 2MB.</p>
                            </div>

                            <!-- Right Column: Form Fields -->
                            <div style="flex: 1; min-width: 250px;">
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label class="form-label">Your Full Name</label>
                                    <input type="text" name="admin_name" value="{{ auth()->user()->name }}" class="form-control" required>
                                </div>
                                <div class="form-group" style="margin-bottom: 20px;">
                                    <label class="form-label">Your Email Address</label>
                                    <input type="email" name="admin_email" value="{{ auth()->user()->email }}" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="border-top: 1px solid var(--border-light); padding-top: 16px;">
                        <button type="submit" class="btn btn-primary" style="padding: 8px 24px;">Save Account Settings</button>
                    </div>
                </form>

            @elseif($tab === 'localization')
                <div class="card-header">Localization Settings</div>
                <form method="POST" action="{{ route('settings.update') }}">
                    @csrf
                    <input type="hidden" name="tab" value="localization">
                    
                    <div style="margin-bottom: 32px;">
                        <h3 style="font-size: 14px; margin-bottom: 16px; color: var(--text-primary); border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">Regional Formats</h3>
                        
                        <div class="grid grid-cols-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div class="form-group">
                                <label class="form-label">Default Currency</label>
                                @php $curr = \App\Models\Setting::getValue('currency', 'UGX'); @endphp
                                <select name="currency" class="form-control" style="background: white;">
                                    <option value="UGX" {{ $curr == 'UGX' ? 'selected' : '' }}>Ugandan Shilling (UGX)</option>
                                    <option value="USD" {{ $curr == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                                    <option value="KES" {{ $curr == 'KES' ? 'selected' : '' }}>Kenyan Shilling (KES)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date Format</label>
                                @php $df = \App\Models\Setting::getValue('date_format', 'Y-m-d'); @endphp
                                <select name="date_format" class="form-control" style="background: white;">
                                    <option value="Y-m-d" {{ $df == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD (2026-09-28)</option>
                                    <option value="d/m/Y" {{ $df == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY (28/09/2026)</option>
                                    <option value="M d, Y" {{ $df == 'M d, Y' ? 'selected' : '' }}>M d, Y (Sep 28, 2026)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div class="form-group">
                                <label class="form-label">Timezone</label>
                                @php $tz = \App\Models\Setting::getValue('timezone', 'Africa/Kampala'); @endphp
                                <select name="timezone" class="form-control" style="background: white;">
                                    <option value="Africa/Kampala" {{ $tz == 'Africa/Kampala' ? 'selected' : '' }}>Africa/Kampala (EAT)</option>
                                    <option value="Africa/Nairobi" {{ $tz == 'Africa/Nairobi' ? 'selected' : '' }}>Africa/Nairobi (EAT)</option>
                                    <option value="UTC" {{ $tz == 'UTC' ? 'selected' : '' }}>UTC</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">System Language</label>
                                @php $lang = \App\Models\Setting::getValue('language', 'en'); @endphp
                                <select name="language" class="form-control" style="background: white;">
                                    <option value="en" {{ $lang == 'en' ? 'selected' : '' }}>English (US)</option>
                                    <option value="sw" {{ $lang == 'sw' ? 'selected' : '' }}>Swahili</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="border-top: 1px solid var(--border-light); padding-top: 16px;">
                        <button type="submit" class="btn btn-primary" style="padding: 8px 24px;">Save Localization</button>
                    </div>
                </form>
                
            @elseif($tab === 'notifications')
                <div class="card-header">Notification Preferences</div>
                <form method="POST" action="{{ route('settings.update') }}">
                    @csrf
                    <input type="hidden" name="tab" value="notifications">
                    
                    <div style="margin-bottom: 32px;">
                        <h3 style="font-size: 14px; margin-bottom: 16px; color: var(--text-primary); border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">Email Alerts</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="hidden" name="email_notifications" value="0">
                                <input type="checkbox" name="email_notifications" value="1" {{ \App\Models\Setting::getValue('email_notifications', '1') ? 'checked' : '' }}>
                                <span>Enable System Email Notifications</span>
                            </label>
                        </div>
                        
                        <h3 style="font-size: 14px; margin-bottom: 16px; color: var(--text-primary); border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">Triggers</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="hidden" name="notify_loan_approval" value="0">
                                <input type="checkbox" name="notify_loan_approval" value="1" {{ \App\Models\Setting::getValue('notify_loan_approval', '1') ? 'checked' : '' }}>
                                <span>Notify members when a loan is approved</span>
                            </label>
                            
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="hidden" name="notify_member_registration" value="0">
                                <input type="checkbox" name="notify_member_registration" value="1" {{ \App\Models\Setting::getValue('notify_member_registration', '1') ? 'checked' : '' }}>
                                <span>Send welcome email on new member registration</span>
                            </label>
                        </div>
                    </div>

                    <div style="border-top: 1px solid var(--border-light); padding-top: 16px;">
                        <button type="submit" class="btn btn-primary" style="padding: 8px 24px;">Save Preferences</button>
                    </div>
                </form>

            @elseif($tab === 'security')
                <div class="card-header">Security Settings</div>
                <form method="POST" action="{{ route('settings.update') }}">
                    @csrf
                    <input type="hidden" name="tab" value="security">
                    
                    <div style="margin-bottom: 32px;">
                        <h3 style="font-size: 14px; margin-bottom: 16px; color: var(--text-primary); border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">Authentication</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="hidden" name="two_factor_auth" value="0">
                                <input type="checkbox" name="two_factor_auth" value="1" {{ \App\Models\Setting::getValue('two_factor_auth', '0') ? 'checked' : '' }}>
                                <span>Require Two-Factor Authentication (2FA) for all Staff</span>
                            </label>
                        </div>
                        
                        <h3 style="font-size: 14px; margin-bottom: 16px; color: var(--text-primary); border-bottom: 1px solid var(--border-light); padding-bottom: 8px;">Policies</h3>
                        
                        <div class="grid grid-cols-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div class="form-group">
                                <label class="form-label">Session Timeout (Minutes)</label>
                                <input type="number" name="session_timeout" value="{{ \App\Models\Setting::getValue('session_timeout', '120') }}" class="form-control" min="15" max="1440">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Password Policy</label>
                                @php $policy = \App\Models\Setting::getValue('password_policy', 'standard'); @endphp
                                <select name="password_policy" class="form-control" style="background: white;">
                                    <option value="standard" {{ $policy == 'standard' ? 'selected' : '' }}>Standard (8+ chars)</option>
                                    <option value="strict" {{ $policy == 'strict' ? 'selected' : '' }}>Strict (Uppercase, Numbers, Symbols)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="border-top: 1px solid var(--border-light); padding-top: 16px;">
                        <button type="submit" class="btn btn-primary" style="padding: 8px 24px;">Save Security Settings</button>
                    </div>
                </form>
            @endif
        </div>
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
                    if (placeholder) placeholder.style.display = 'none';
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
