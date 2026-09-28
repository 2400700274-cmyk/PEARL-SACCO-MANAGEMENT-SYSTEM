@extends('components.layouts.app')

@section('title', 'Members')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1>Members</h1>
            <div style="font-size: 12px; color: var(--text-secondary);">Manage SACCO members and their profiles</div>
        </div>
        <a href="{{ route('members.create') }}" class="btn btn-primary">+ Register Member</a>
    </div>

    @if(session('success'))
        <div style="background-color: #dff6dd; color: var(--success-color); padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; border: 1px solid #c8e6c9;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <span>Member Directory</span>
            <div>
                <input type="text" placeholder="Search members..." style="padding: 6px 12px; border: 1px solid var(--border-color); border-radius: 2px;">
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Member No.</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Registration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td>
                                @if($member->passport_photo_path)
                                    <img src="{{ Storage::url($member->passport_photo_path) }}" alt="Photo" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                                @else
                                    <div style="width: 40px; height: 40px; border-radius: 4px; background-color: var(--border-color); color: var(--text-secondary); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px;">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                @endif
                            </td>
                            <td style="font-weight: 600;">{{ $member->member_number }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->contact }}</td>
                            <td>
                                @if($member->status === 'Active')
                                    <span class="badge badge-success">{{ $member->status }}</span>
                                @elseif($member->status === 'Suspended')
                                    <span class="badge badge-warning">{{ $member->status }}</span>
                                @else
                                    <span class="badge badge-info">{{ $member->status }}</span>
                                @endif
                            </td>
                            <td>{{ $member->registered_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('members.show', $member) }}" style="margin-right: 8px;">View</a>
                                <a href="{{ route('members.edit', $member) }}">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 32px; color: var(--text-secondary);">
                                <div style="margin-bottom: 8px; font-size: 24px;">👥</div>
                                No members found.<br>
                                <a href="{{ route('members.create') }}" style="font-size: 13px; margin-top: 8px; display: inline-block;">Register the first member</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($members->hasPages())
            <div style="padding: 16px; border-top: 1px solid var(--border-light);">
                {{ $members->links() }}
            </div>
        @endif
    </div>
@endsection
