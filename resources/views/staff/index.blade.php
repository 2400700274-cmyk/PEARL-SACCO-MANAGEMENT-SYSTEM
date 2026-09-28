@extends('components.layouts.app')

@section('title', 'Staff Directory')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 style="margin: 0;">Staff Directory</h1>
        <a href="{{ route('staff.create') }}" class="btn btn-primary">+ New Staff Account</a>
    </div>

    @if(session('success'))
        <div style="background-color: #dff6dd; color: var(--success-color); padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; border: 1px solid #c8e6c9;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">Manage Staff Accounts</div>
        <div class="table-container">
            <table>
                <thead>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $user)
                        <tr>
                            <td>
                                @if($user->profile_photo_path)
                                    <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <div style="width: 36px; height: 36px; border-radius: 50%; background-color: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                            </td>
                            <td style="font-weight: 600;">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge badge-info">{{ $user->role->name ?? 'Unknown' }}</span></td>
                            <td>
                                @if($user->status === 'Active')
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">{{ $user->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" style="color: var(--primary-color); text-decoration: none; margin-right: 12px;">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 24px; color: var(--text-secondary);">No staff accounts found. Create one to get started.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
