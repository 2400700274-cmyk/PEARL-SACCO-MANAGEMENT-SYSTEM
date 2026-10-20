@extends('components.layouts.app')

@section('title', 'Edit Member')

@section('content')
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('members.show', $member) }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to Member Profile</a>
        <h1 style="margin: 0; font-size: 24px;">Edit Member: {{ $member->member_number }}</h1>
    </div>

    <div class="card" style="max-width: 800px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border-light); padding: 18px 24px;">
            <h2 style="margin: 0; font-size: 16px; color: var(--primary-color);">Update Member & Next of Kin Details</h2>
        </div>
        
        <form method="POST" action="{{ route('members.update', $member) }}" style="padding: 24px;">
            @csrf
            @method('PUT')

            <div style="font-weight: 700; font-size: 13px; color: var(--primary-color); border-bottom: 1px solid var(--border-light); padding-bottom: 6px; margin-bottom: 16px; text-transform: uppercase;">
                1. Member Identification
            </div>
            
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px;">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $member->name) }}" class="form-control" required>
                @error('name')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px;">Uganda National ID (NIN)</label>
                    <input type="text" id="nin" name="nin" value="{{ old('nin', $member->nin) }}" maxlength="14" class="form-control" style="text-transform: uppercase;" required>
                    <span style="font-size: 11px; color: var(--text-secondary); margin-top: 4px; display: block;">14 characters Uganda NIRA format</span>
                    @error('nin')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px;">Contact Number / Email</label>
                    <input type="text" name="contact" value="{{ old('contact', $member->contact) }}" class="form-control" required>
                    @error('contact')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px;">Account Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Active" {{ old('status', $member->status) == 'Active' ? 'selected' : '' }}>Active (Eligible for Savings & Loans)</option>
                        <option value="Inactive" {{ old('status', $member->status) == 'Inactive' ? 'selected' : '' }}>Inactive (Restricted)</option>
                        <option value="Suspended" {{ old('status', $member->status) == 'Suspended' ? 'selected' : '' }}>Suspended (Restricted)</option>
                    </select>
                    <span style="font-size: 11px; color: var(--text-secondary); margin-top: 4px; display: block;">Note: Inactive/Suspended members cannot borrow or make savings.</span>
                    @error('status')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px;">Registration Date</label>
                    <input type="date" name="registered_at" value="{{ old('registered_at', $member->registered_at ? $member->registered_at->format('Y-m-d') : date('Y-m-d')) }}" class="form-control" required>
                    @error('registered_at')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="font-weight: 700; font-size: 13px; color: var(--primary-color); border-bottom: 1px solid var(--border-light); padding-bottom: 6px; margin-bottom: 16px; margin-top: 24px; text-transform: uppercase;">
                2. Next of Kin Information
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px;">Next of Kin Name</label>
                    <input type="text" name="next_of_kin_name" value="{{ old('next_of_kin_name', $member->next_of_kin_name) }}" class="form-control" required>
                    @error('next_of_kin_name')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px;">Next of Kin Contact</label>
                    <input type="text" name="next_of_kin_contact" value="{{ old('next_of_kin_contact', $member->next_of_kin_contact) }}" class="form-control" required>
                    @error('next_of_kin_contact')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px;">Relationship</label>
                    <select name="next_of_kin_relationship" class="form-control" required>
                        <option value="">-- Select Relationship --</option>
                        <option value="Spouse" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                        <option value="Parent" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Parent' ? 'selected' : '' }}>Parent</option>
                        <option value="Child" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Child' ? 'selected' : '' }}>Child</option>
                        <option value="Sibling" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Sibling' ? 'selected' : '' }}>Sibling (Brother/Sister)</option>
                        <option value="Relative" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Relative' ? 'selected' : '' }}>Extended Relative</option>
                        <option value="Other" {{ old('next_of_kin_relationship', $member->next_of_kin_relationship) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('next_of_kin_relationship')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600; font-size: 13px;">Residential Address</label>
                    <input type="text" name="next_of_kin_address" value="{{ old('next_of_kin_address', $member->next_of_kin_address) }}" class="form-control">
                    @error('next_of_kin_address')<span style="color: var(--danger-color); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--border-light); padding-top: 20px;">
                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-weight: 600;">Save Changes</button>
                    <a href="{{ route('members.show', $member) }}" class="btn btn-secondary" style="padding: 10px 24px;">Cancel</a>
                </div>
                
                <button type="button" class="btn btn-secondary" style="color: var(--danger-color); border-color: var(--danger-color);" onclick="if(confirm('Are you sure you want to delete this member? All associated savings and loans will be affected.')) document.getElementById('delete-form').submit();">
                    Delete Member
                </button>
            </div>
        </form>

        <form id="delete-form" method="POST" action="{{ route('members.destroy', $member) }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <script>
        document.getElementById('nin').addEventListener('input', function() {
            this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        });
    </script>
@endsection
