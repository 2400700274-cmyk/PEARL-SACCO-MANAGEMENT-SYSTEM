@extends('components.layouts.app')

@section('title', 'Register Member')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div>
            <a href="{{ route('members.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Back to Directory
            </a>
            <h1 style="margin: 0; font-size: 26px; color: var(--text-primary);">Register New Member</h1>
        </div>
    </div>

    <div class="card" style="max-width: 960px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 20px 24px;">
            <h2 style="margin: 0; font-size: 16px; color: var(--primary-color);">Member Profile & Next of Kin Information</h2>
        </div>
        
        <form method="POST" action="{{ route('members.store') }}" enctype="multipart/form-data" style="padding: 24px;">
            @csrf
            
            <div style="display: flex; gap: 40px; flex-wrap: wrap;">
                
                <!-- Left Column: Photo Upload -->
                <div style="width: 200px; display: flex; flex-direction: column; align-items: center;">
                    <div style="width: 160px; height: 160px; border-radius: 50%; overflow: hidden; background-color: var(--bg-color); border: 2px dashed var(--border-color); display: flex; align-items: center; justify-content: center; margin-bottom: 16px; position: relative; cursor: pointer;" onclick="document.getElementById('photo-input').click()">
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
                    <!-- Section 1: Member Primary Info -->
                    <div style="font-weight: 700; font-size: 14px; color: var(--primary-color); border-bottom: 1px solid var(--border-light); padding-bottom: 6px; margin-bottom: 16px; text-transform: uppercase;">
                        1. Primary Identification
                    </div>

                    <div class="form-group" style="margin-bottom: 18px;">
                        <label class="form-label" style="font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus placeholder="e.g. John Mukasa">
                        @error('name')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Uganda National ID (NIN)</label>
                            <input type="text" id="nin" name="nin" value="{{ old('nin') }}" maxlength="14" class="form-control" required placeholder="CM90012345ABCD" style="text-transform: uppercase;">
                            <span style="font-size: 11px; color: var(--text-secondary); margin-top: 4px; display: block;">14 characters Uganda NIRA format (e.g. CM/CF...)</span>
                            @error('nin')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Primary Phone / Email Contact</label>
                            <input type="text" name="contact" value="{{ old('contact') }}" class="form-control" required placeholder="+256 700 000000 or email@domain.com">
                            @error('contact')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 24px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Account Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>Active (Eligible for Savings & Loans)</option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive (Restricted)</option>
                                <option value="Suspended" {{ old('status') == 'Suspended' ? 'selected' : '' }}>Suspended (Restricted)</option>
                            </select>
                            <span style="font-size: 11px; color: var(--text-secondary); margin-top: 4px; display: block;">Note: Inactive and Suspended members cannot borrow or transact savings.</span>
                            @error('status')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Registration Date</label>
                            <input type="date" name="registered_at" value="{{ old('registered_at', date('Y-m-d')) }}" class="form-control" required>
                            @error('registered_at')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <!-- Section 2: Next of Kin Information (Modification 4) -->
                    <div style="font-weight: 700; font-size: 14px; color: var(--primary-color); border-bottom: 1px solid var(--border-light); padding-bottom: 6px; margin-bottom: 16px; margin-top: 28px; text-transform: uppercase;">
                        2. Next of Kin Information (Mandatory)
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Next of Kin Full Name</label>
                            <input type="text" name="next_of_kin_name" value="{{ old('next_of_kin_name') }}" class="form-control" required placeholder="e.g. Grace Mukasa">
                            @error('next_of_kin_name')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Next of Kin Contact / Telephone</label>
                            <input type="text" name="next_of_kin_contact" value="{{ old('next_of_kin_contact') }}" class="form-control" required placeholder="e.g. +256 772 000000">
                            @error('next_of_kin_contact')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 24px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Relationship to Member</label>
                            <select name="next_of_kin_relationship" class="form-control" required>
                                <option value="">-- Select Relationship --</option>
                                <option value="Spouse" {{ old('next_of_kin_relationship') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                <option value="Parent" {{ old('next_of_kin_relationship') == 'Parent' ? 'selected' : '' }}>Parent</option>
                                <option value="Child" {{ old('next_of_kin_relationship') == 'Child' ? 'selected' : '' }}>Child</option>
                                <option value="Sibling" {{ old('next_of_kin_relationship') == 'Sibling' ? 'selected' : '' }}>Sibling (Brother/Sister)</option>
                                <option value="Relative" {{ old('next_of_kin_relationship') == 'Relative' ? 'selected' : '' }}>Extended Relative</option>
                                <option value="Other" {{ old('next_of_kin_relationship') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('next_of_kin_relationship')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" style="font-weight: 600; font-size: 13px; margin-bottom: 6px; display: block;">Residential Address</label>
                            <input type="text" name="next_of_kin_address" value="{{ old('next_of_kin_address') }}" class="form-control" placeholder="Village / Town, District">
                            @error('next_of_kin_address')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px; border-top: 1px solid var(--border-light); padding-top: 24px;">
                        <button type="submit" class="btn btn-primary" style="padding: 10px 28px; font-weight: 600;">Register Member</button>
                        <a href="{{ route('members.index') }}" class="btn btn-secondary" style="padding: 10px 28px; font-weight: 500;">Cancel</a>
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
    </script>
@endsection
