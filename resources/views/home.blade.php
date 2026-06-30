@extends('layouts.app')

@section('content')
<!-- Welcome Banner -->
<div class="admin-welcome">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2><i class="fas fa-house me-2"></i> Welcome back, {{ Auth::user()->name }}!</h2>
            <p>France Vacances admin panel — manage properties, bookings, and content from here.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <span class="date-badge">
                <i class="fas fa-calendar-day me-1"></i>
                {{ now()->format('l, j M Y') }}
            </span>
        </div>
    </div>
</div>

<!-- KPI Row -->
<div class="row g-3 mb-4">
    <div class="col-xl-2 col-md-4 col-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon blue"><i class="fas fa-home"></i></div>
            <div class="admin-stat-info">
                <h3>{{ $stats['destinations'] }}</h3>
                <small>Properties</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon amber"><i class="fas fa-calendar-alt"></i></div>
            <div class="admin-stat-info">
                <h3>{{ $stats['bookings_total'] }}</h3>
                <small>Total Bookings</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon rose"><i class="fas fa-clock"></i></div>
            <div class="admin-stat-info">
                <h3>{{ $stats['bookings_pending'] }}</h3>
                <small>Pending</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="admin-stat-info">
                <h3>{{ $stats['confirmed'] }}</h3>
                <small>Confirmed</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon cyan"><i class="fas fa-sterling-sign"></i></div>
            <div class="admin-stat-info">
                <h3>£{{ number_format($stats['revenue']) }}</h3>
                <small>Revenue</small>
            </div>
        </div>
    </div>
    <div class="col-xl-2 col-md-4 col-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon blue"><i class="fas fa-users"></i></div>
            <div class="admin-stat-info">
                <h3>{{ $stats['users'] }}</h3>
                <small>Users</small>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-lg-3">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5><i class="fas fa-bolt"></i> Quick Actions</h5>
            </div>
            <div class="admin-card-body d-grid gap-2">
                <a href="{{ route('destinations.create') }}" class="admin-quick-btn">
                    <i class="fas fa-plus-circle" style="color:var(--admin-primary)"></i> Add New Property
                </a>
                <a href="{{ route('blog.create') }}" class="admin-quick-btn">
                    <i class="fas fa-pen-alt" style="color:#22c55e"></i> Write Blog Post
                </a>
                <a href="{{ route('categories.create') }}" class="admin-quick-btn">
                    <i class="fas fa-folder-plus" style="color:#3b82f6"></i> New Region
                </a>
                <a href="{{ route('tags.create') }}" class="admin-quick-btn">
                    <i class="fas fa-tag" style="color:#f59e0b"></i> Add Tag
                </a>
                <hr class="my-1">
                <a href="{{ route('bookings.index') }}" class="admin-quick-btn">
                    <i class="fas fa-calendar-check" style="color:var(--admin-primary)"></i> Manage Bookings
                </a>
                <a href="{{ route('payments.index') }}" class="admin-quick-btn">
                    <i class="fas fa-receipt" style="color:#22c55e"></i> View Payments
                </a>
                <a href="{{ route('reports.index') }}" class="admin-quick-btn">
                    <i class="fas fa-chart-bar" style="color:var(--admin-accent)"></i> Reports
                </a>
                <a href="{{ route('users.index') }}" class="admin-quick-btn">
                    <i class="fas fa-users" style="color:#8b5cf6"></i> Manage Users
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="col-lg-5">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5><i class="fas fa-calendar-alt"></i> Recent Bookings</h5>
                <a href="{{ route('bookings.index') }}" class="btn-admin-sm btn-admin-edit">View All</a>
            </div>
            <div class="admin-card-body p-0">
                @if($recentBookings->count() > 0)
                <table class="admin-table mb-0">
                    <thead>
                        <tr>
                            <th>Guest</th>
                            <th>Property</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                        <tr>
                            <td>
                                <strong style="font-size:.82rem;">{{ $booking->user->name ?? '—' }}</strong>
                                <div style="font-size:.72rem;color:var(--admin-text-soft);">
                                    {{ optional($booking->check_in_date)->format('d M Y') ?? '—' }}
                                </div>
                            </td>
                            <td style="font-size:.82rem;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ Str::limit($booking->destination->title ?? '—', 22) }}
                            </td>
                            <td style="font-size:.82rem;font-weight:600;">{{ $booking->total_display }}</td>
                            <td>
                                <span class="badge bg-{{ $booking->status_badge }}" style="font-size:.7rem;">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="admin-empty">
                    <i class="fas fa-calendar-alt"></i>
                    <p>No bookings yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Properties -->
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5><i class="fas fa-home"></i> Recent Properties</h5>
                <a href="{{ route('destinations.index') }}" class="btn-admin-sm btn-admin-edit">View All</a>
            </div>
            <div class="admin-card-body">
                @forelse($recentDestinations as $dest)
                <div class="admin-recent-item">
                    <div class="flex-grow-1 min-w-0">
                        <h6 class="mb-0 text-truncate">{{ $dest->title }}</h6>
                        <small class="text-muted">
                            {{ $dest->property_type_label }} &middot; {{ $dest->price_display }}
                        </small>
                    </div>
                    <a href="{{ route('destinations.edit', $dest->id) }}" class="btn-admin-sm btn-admin-edit flex-shrink-0">
                        <i class="fas fa-pen"></i>
                    </a>
                </div>
                @empty
                <div class="admin-empty">
                    <i class="fas fa-home"></i>
                    <p>No properties yet</p>
                </div>
                @endforelse

                <div class="mt-3">
                    <a href="{{ route('destinations.create') }}" class="btn-admin-accent w-100 text-center d-block">
                        <i class="fas fa-plus me-1"></i> Add New Property
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Stats Row -->
<div class="row g-4 mt-0">
    <div class="col-md-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-folder"></i> Regions / Categories</h5>
                <a href="{{ route('categories.index') }}" class="btn-admin-sm btn-admin-edit">Manage</a>
            </div>
            <div class="admin-card-body text-center py-4">
                <div style="font-size:2.5rem;font-weight:700;color:var(--admin-primary);">{{ $stats['categories'] }}</div>
                <small class="text-muted">Active regions configured</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-newspaper"></i> Blog Posts</h5>
                <a href="{{ route('blog.index') }}" class="btn-admin-sm btn-admin-edit">Manage</a>
            </div>
            <div class="admin-card-body text-center py-4">
                <div style="font-size:2.5rem;font-weight:700;color:var(--admin-primary);">{{ $stats['blogs'] }}</div>
                <small class="text-muted">Holiday inspiration articles</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-chart-bar"></i> Platform Stats</h5>
                <a href="{{ route('reports.index') }}" class="btn-admin-sm btn-admin-edit">Full Report</a>
            </div>
            <div class="admin-card-body py-3">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <small class="text-muted">Total Properties</small>
                    <strong>{{ $stats['destinations'] }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <small class="text-muted">Confirmed Bookings</small>
                    <strong style="color:#22c55e;">{{ $stats['confirmed'] }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <small class="text-muted">Pending Bookings</small>
                    <strong style="color:#f59e0b;">{{ $stats['bookings_pending'] }}</strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <small class="text-muted">Total Revenue</small>
                    <strong style="color:var(--admin-primary);">£{{ number_format($stats['revenue']) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
