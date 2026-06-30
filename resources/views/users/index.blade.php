@extends('layouts.app')

@section('content')

<style>
.role-badge-admin   { background:#dc2626;color:#fff; }
.role-badge-owner   { background:#1d4ed8;color:#fff; }
.role-badge-finance { background:#16a34a;color:#fff; }
.role-badge-it      { background:#7c3aed;color:#fff; }
.role-badge-customer{ background:#6b7280;color:#fff; }
.role-badge {
    display:inline-block;
    padding:3px 10px;
    border-radius:50px;
    font-size:.7rem;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.06em;
}
.role-select {
    font-size:.8rem;
    padding:4px 8px;
    border:1px solid var(--admin-border);
    border-radius:6px;
    background:#fff;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0" style="font-weight:600;">
        <i class="fas fa-users me-2" style="color:var(--admin-primary)"></i>User Management
    </h5>
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

<div class="admin-card">
    <div class="admin-card-body p-0">
        @if ($users->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:44px;"></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Assign Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                @php
                $cls = match($user->role) {
                    'admin'   => 'role-badge-admin',
                    'owner'   => 'role-badge-owner',
                    'finance' => 'role-badge-finance',
                    'it'      => 'role-badge-it',
                    default   => 'role-badge-customer',
                };
                @endphp
                <tr>
                    <td>
                        <img class="admin-user-thumb" src="{{ Gravatar::get($user->email) }}" alt="{{ $user->name }}">
                    </td>
                    <td>
                        <strong>{{ $user->name }}</strong>
                        @if($user->id === auth()->id())
                        <span style="font-size:.65rem;background:#f3f4f6;color:#6b7280;padding:1px 6px;border-radius:4px;margin-left:4px;">You</span>
                        @endif
                    </td>
                    <td style="font-size:.85rem;color:var(--admin-text-muted);">{{ $user->email }}</td>
                    <td>
                        <span class="role-badge {{ $cls }}">{{ $user->roleLabel() }}</span>
                    </td>
                    <td>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.assign-role', $user->id) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            <select name="role" class="role-select">
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
                            <button type="submit" class="btn-admin-sm btn-admin-primary" title="Apply role">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        @else
                        <span style="font-size:.78rem;color:var(--admin-text-muted);font-style:italic;">Cannot change own role</span>
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
</div>

<!-- Role reference cards -->
<div class="row g-3 mt-2">
    @foreach([
        ['admin',   'fas fa-shield-halved', '#dc2626', 'Administrator',  'Full access — all content, bookings, users, and every portal.'],
        ['owner',   'fas fa-building',      '#1d4ed8', 'Property Owner', 'Owner Portal: property performance, upcoming arrivals, revenue by type.'],
        ['finance', 'fas fa-chart-line',    '#16a34a', 'Finance',        'Finance Portal: revenue reports, payment history, monthly chart.'],
        ['it',      'fas fa-server',        '#7c3aed', 'IT / Technical', 'IT Portal: system health checks, tech stack, DB stats, deployment config.'],
        ['customer','fas fa-user',          '#6b7280', 'Customer',       'Browse, book, wishlist, review, and manage own account.'],
    ] as [$role, $icon, $colour, $label, $desc])
    <div class="col-md-4">
        <div style="background:#fff;border:1px solid var(--admin-border);border-left:3px solid {{ $colour }};border-radius:8px;padding:.85rem 1rem;display:flex;gap:10px;align-items:flex-start;">
            <i class="{{ $icon }}" style="color:{{ $colour }};margin-top:2px;font-size:.9rem;flex-shrink:0;"></i>
            <div>
                <div style="font-weight:700;font-size:.82rem;color:{{ $colour }};">{{ $label }}</div>
                <div style="font-size:.75rem;color:var(--admin-text-muted);">{{ $desc }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
