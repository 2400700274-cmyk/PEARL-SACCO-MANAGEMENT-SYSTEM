@extends('components.layouts.app')

@section('title', 'Edit Member')

@section('content')
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('members.index') }}" style="color: var(--text-secondary); text-decoration: none;">&larr; Back to Directory</a>
        <h1 style="margin: 0;">Edit Member: {{ $member->member_number }}</h1>
    </div>

    <div class="card" style="max-width: 600px;">
        <div class="card-header">Update Member Details</div>
        
        <form method="POST" action="{{ route('members.update', $member) }}">
            @csrf
            @method('PUT')
            
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600;">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $member->name) }}" class="form-control" style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;" required>
                @error('name')<span style="color: var(--danger-color); font-size: 12px;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600;">Contact Number</label>
                <input type="text" name="contact" value="{{ old('contact', $member->contact) }}" class="form-control" style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;" required>
                @error('contact')<span style="color: var(--danger-color); font-size: 12px;">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px;">
                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600;">Status</label>
                    <select name="status" class="form-control" style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px; background: white;" required>
                        <option value="Active" {{ old('status', $member->status) == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $member->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Suspended" {{ old('status', $member->status) == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('status')<span style="color: var(--danger-color); font-size: 12px;">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 6px; font-weight: 600;">Registration Date</label>
                    <input type="date" name="registered_at" value="{{ old('registered_at', $member->registered_at->format('Y-m-d')) }}" class="form-control" style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;" required>
                    @error('registered_at')<span style="color: var(--danger-color); font-size: 12px;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--border-light); padding-top: 16px;">
                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn btn-primary" style="padding: 8px 24px;">Update Member</button>
                    <a href="{{ route('members.index') }}" class="btn btn-secondary" style="padding: 8px 24px;">Cancel</a>
                </div>
                
                <button type="button" class="btn btn-secondary" style="color: var(--danger-color); border-color: var(--danger-color);" onclick="if(confirm('Are you sure you want to delete this member?')) document.getElementById('delete-form').submit();">
                    Delete
                </button>
            </div>
        </form>

        <form id="delete-form" method="POST" action="{{ route('members.destroy', $member) }}" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
@endsection
