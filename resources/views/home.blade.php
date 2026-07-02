@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="dash-welcome">
    <h2>Welcome, {{ Auth::user()->name }}</h2>
    <p>Manage properties, bookings and customers from this page.</p>
</div>

<!-- Summary Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="dash-stat">
            <div class="num">{{ $stats['destinations'] }}</div>
            <div class="lbl">Properties</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="dash-stat">
            <div class="num">{{ $stats['bookings_total'] }}</div>
            <div class="lbl">Bookings</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="dash-stat">
            <div class="num">{{ $stats['users'] }}</div>
            <div class="lbl">Customers</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="dash-stat">
            <div class="num">£{{ number_format($stats['revenue']) }}</div>
            <div class="lbl">Revenue</div>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <h5>Recent Bookings</h5>
        <a href="{{ route('bookings.index') }}" class="btn-admin-sm btn-admin-edit">View All</a>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table mb-0">
            <thead>
                <tr>
                    <th>Guest</th>
                    <th>Property</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                <tr>
                    <td>{{ $booking->user->name ?? '—' }}</td>
                    <td>{{ Str::limit($booking->destination->title ?? '—', 30) }}</td>
                    <td>{{ $booking->total_display }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-muted">No bookings yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Properties -->
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <h5>Recent Properties</h5>
        <a href="{{ route('destinations.index') }}" class="btn-admin-sm btn-admin-edit">View All</a>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table mb-0">
            <thead>
                <tr>
                    <th>Property</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentDestinations as $dest)
                <tr>
                    <td>{{ Str::limit($dest->title, 30) }}</td>
                    <td>{{ $dest->property_type_label }}</td>
                    <td>{{ $dest->price_display }}</td>
                    <td>
                        <a href="{{ route('destinations.edit', $dest->id) }}" class="btn-admin-sm btn-admin-edit">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-muted">No properties yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Latest Users -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5>Latest Users</h5>
        <a href="{{ route('users.index') }}" class="btn-admin-sm btn-admin-edit">View All</a>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Date Registered</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestUsers as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ ucfirst($u->role) }}</td>
                    <td>{{ $u->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-muted">No users yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
