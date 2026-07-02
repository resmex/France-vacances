@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0" style="font-weight:600;">Users</h5>
    <div style="font-size:.82rem;color:var(--admin-text-muted);">
        {{ $users->count() }} user{{ $users->count() === 1 ? '' : 's' }}
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="users-page-card">
    @if ($users->count() > 0)
    <table class="users-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            @php
                $roleLabels = [
                    'admin'    => 'Admin',
                    'owner'    => 'Owner',
                    'finance'  => 'Finance',
                    'it'       => 'IT',
                    'customer' => 'Customer',
                ];
                $roleText = $roleLabels[$user->role] ?? ucfirst($user->role);
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <span class="users-avatar-sm">
                            @if($user->profile_photo)
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                            @else
                            <i class="fas fa-user"></i>
                            @endif
                        </span>
                        {{ $user->name }}
                        @if($user->id === auth()->id())
                        <span style="color:var(--admin-text-muted);">(You)</span>
                        @endif
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $roleText }}</td>
                <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}</td>
                <td>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('users.assign-role', $user->id) }}" method="POST" class="d-flex align-items-center gap-2">
                        @csrf
                        <select name="role" class="users-role-select">
                            @foreach([
                                'customer' => 'Customer',
                                'owner'    => 'Property Owner',
                                'finance'  => 'Finance',
                                'it'       => 'IT / Technical',
                                'admin'    => 'Administrator',
                            ] as $val => $label)
                            <option value="{{ $val }}" {{ $user->role === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="users-btn-save" title="Save">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                    @else
                    <span style="font-size:.8rem;color:var(--admin-text-muted);">Cannot change own role</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="admin-empty">
        <i class="fas fa-users"></i>
        <h5>No Users Yet</h5>
    </div>
    @endif
</div>

@endsection
