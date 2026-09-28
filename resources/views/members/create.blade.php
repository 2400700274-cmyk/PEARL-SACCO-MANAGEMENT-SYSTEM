@extends('components.layouts.app')

@section('title', 'Register Member')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
        <div>
            <a href="{{ route('members.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 4px; margin-bottom: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                Back to Directory
            </a>
            <h1 style="margin: 0; font-size: 28px; color: var(--text-primary);">Register New Member</h1>
        </div>
    </div>

    <div class="card" style="max-width: 900px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 20px 24px;">
            <h2 style="margin: 0; font-size: 16px; color: var(--primary-color);">Member Profile Details</h2>
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
                <div style="flex: 1; min-width: 300px;">
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus placeholder="Enter member's full name">
                        @error('name')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">National ID Number (NIN)</label>
                            <input type="text" name="nin" value="{{ old('nin') }}" class="form-control" required placeholder="e.g. CM9201...">
                            @error('nin')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact" value="{{ old('contact') }}" class="form-control" required placeholder="e.g. +256 700 000000">
                            @error('contact')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 32px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="Suspended" {{ old('status') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                            @error('status')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Registration Date</label>
                            <input type="date" name="registered_at" value="{{ old('registered_at', date('Y-m-d')) }}" class="form-control" required>
                            @error('registered_at')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px; border-top: 1px solid var(--border-light); padding-top: 24px;">
                        <button type="submit" class="btn btn-primary" style="padding: 10px 28px; font-weight: 500;">Register Member</button>
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
    </script>
@endsection
