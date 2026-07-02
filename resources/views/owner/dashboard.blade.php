@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="admin-welcome">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2><i class="fas fa-key me-2" style="color:var(--admin-accent);"></i> Owner Portal</h2>
            <p>Property performance, upcoming arrivals and revenue overview for all France Vacances properties.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <span class="date-badge">
                <i class="fas fa-calendar-day me-1"></i>{{ now()->format('l, j M Y') }}
            </span>
        </div>
    </div>
</div>

<!-- KPI Row -->
<div class="row g-3 mb-4">
    @php
    $kpis = [
        ['icon'=>'fas fa-home',         'color'=>'blue',  'value'=>$stats['total_properties'],                     'label'=>'Properties'],
        ['icon'=>'fas fa-check-circle', 'color'=>'green', 'value'=>$stats['active_bookings'],                      'label'=>'Confirmed Bookings'],
        ['icon'=>'fas fa-clock',        'color'=>'amber', 'value'=>$stats['pending_bookings'],                     'label'=>'Pending'],
        ['icon'=>'fas fa-sterling-sign','color'=>'cyan',  'value'=>'£'.number_format($stats['total_revenue']),     'label'=>'Total Revenue'],
        ['icon'=>'fas fa-calendar-check','color'=>'rose', 'value'=>'£'.number_format($stats['this_month_revenue']),'label'=>'This Month'],
        ['icon'=>'fas fa-star',         'color'=>'amber', 'value'=>$stats['avg_nightly_rate'] ? '£'.number_format($stats['avg_nightly_rate']) : '—', 'label'=>'Avg Nightly Rate'],
    ];
    @endphp
    @foreach($kpis as $k)
    <div class="col-xl-2 col-md-4 col-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon {{ $k['color'] }}"><i class="{{ $k['icon'] }}"></i></div>
            <div class="admin-stat-info">
                <h3>{{ $k['value'] }}</h3>
                <small>{{ $k['label'] }}</small>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">
    <!-- Property Performance Table -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-home me-2"></i>Property Performance</h5>
                <a href="{{ route('destinations.index') }}" class="btn-admin-sm btn-admin-edit">Manage</a>
            </div>
            <div class="admin-card-body p-0">
                @if($properties->count() > 0)
                <table class="admin-table mb-0">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Type</th>
                            <th>Price/Night</th>
                            <th class="text-center">Bookings</th>
                            <th class="text-center">Pending</th>
                            <th class="text-end">Revenue</th>
                            <th class="text-center">Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($properties as $prop)
                        <tr>
                            <td>
                                <strong style="font-size:.85rem;">{{ $prop->title }}</strong>
                                <div style="font-size:.72rem;color:var(--admin-text-soft);">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $prop->location ?? $prop->category->name ?? '—' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge-cat" style="font-size:.7rem;">{{ $prop->property_type_label }}</span>
                            </td>
                            <td style="font-weight:600;font-size:.85rem;color:var(--admin-primary);">
                                {{ $prop->price_display }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary" style="font-size:.72rem;">{{ $prop->bookings_count }}</span>
                            </td>
                            <td class="text-center">
                                @if($prop->pending_count > 0)
                                <span class="badge bg-warning text-dark" style="font-size:.72rem;">{{ $prop->pending_count }}</span>
                                @else
                                <span class="text-muted" style="font-size:.75rem;">—</span>
                                @endif
                            </td>
                            <td class="text-end" style="font-weight:700;color:var(--admin-primary);font-size:.85rem;">
                                £{{ number_format($prop->bookings_revenue) }}
                            </td>
                            <td class="text-center">
                                @if($prop->display_rating)
                                <span style="font-size:.82rem;font-weight:600;">
                                    <i class="fas fa-star" style="color:var(--admin-accent);font-size:.7rem;"></i>
                                    {{ number_format($prop->display_rating, 2) }}
                                </span>
                                @else
                                <span class="text-muted" style="font-size:.75rem;">New</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="admin-empty">
                    <i class="fas fa-home"></i>
                    <p>No properties yet.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Upcoming Bookings -->
        <div class="admin-card mt-4">
            <div class="admin-card-header">
                <h5><i class="fas fa-plane-departure me-2"></i>Upcoming Arrivals</h5>
                <a href="{{ route('bookings.index') }}" class="btn-admin-sm btn-admin-edit">All Bookings</a>
            </div>
            <div class="admin-card-body p-0">
                @if($upcomingBookings->count() > 0)
                <table class="admin-table mb-0">
                    <thead>
                        <tr>
                            <th>Guest</th>
                            <th>Property</th>
                            <th>Check-in</th>
                            <th>Nights</th>
                            <th>Guests</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingBookings as $b)
                        <tr>
                            <td>
                                <strong style="font-size:.82rem;">{{ $b->user->name ?? '—' }}</strong>
                                <div style="font-size:.7rem;color:var(--admin-text-soft);">{{ $b->user->email ?? '' }}</div>
                            </td>
                            <td style="font-size:.82rem;">{{ Str::limit($b->destination->title ?? '—', 24) }}</td>
                            <td style="font-size:.82rem;font-weight:600;">
                                {{ $b->check_in_date?->format('d M Y') ?? '—' }}
                            </td>
                            <td class="text-center" style="font-size:.82rem;">{{ $b->nights_label }}</td>
                            <td class="text-center" style="font-size:.82rem;">{{ $b->guests }}</td>
                            <td class="text-end" style="font-weight:700;font-size:.82rem;color:var(--admin-primary);">
                                {{ $b->total_display }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="admin-empty">
                    <i class="fas fa-plane-departure"></i>
                    <p>No upcoming arrivals in the next 90 days.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right column -->
    <div class="col-lg-4">
        <!-- Top Performer -->
        @if($topProperty)
        <div class="admin-card mb-4" style="border-top:3px solid var(--admin-accent);">
            <div class="admin-card-header">
                <h5><i class="fas fa-trophy me-2" style="color:var(--admin-accent);"></i>Top Performer</h5>
            </div>
            <div class="admin-card-body text-center">
                <div style="font-size:2rem;margin-bottom:.5rem;">🏆</div>
                <h5 class="fw-bold mb-1">{{ $topProperty->title }}</h5>
                <div class="badge-cat mb-3">{{ $topProperty->property_type_label }}</div>
                <div class="d-flex justify-content-around">
                    <div class="text-center">
                        <div style="font-size:1.4rem;font-weight:700;color:var(--admin-primary);">
                            {{ $topProperty->bookings_count }}
                        </div>
                        <small class="text-muted">Bookings</small>
                    </div>
                    <div class="text-center">
                        <div style="font-size:1.4rem;font-weight:700;color:#22c55e;">
                            £{{ number_format($topProperty->bookings_revenue) }}
                        </div>
                        <small class="text-muted">Revenue</small>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Revenue by Property Type -->
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5><i class="fas fa-chart-pie me-2"></i>Revenue by Type</h5>
            </div>
            <div class="admin-card-body">
                @if($typeRevenue->isEmpty())
                <p class="text-muted text-center py-3" style="font-size:.85rem;">No booking data yet.</p>
                @else
                @foreach($typeRevenue as $type => $data)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div style="font-size:.85rem;font-weight:600;">{{ $type ?: 'Unspecified' }}</div>
                        <small class="text-muted">{{ $data['count'] }} {{ Str::plural('booking', $data['count']) }}</small>
                    </div>
                    <div style="font-weight:700;color:var(--admin-primary);">
                        £{{ number_format($data['revenue']) }}
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>

        <!-- Quick Links -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="admin-card-body d-grid gap-2">
                <a href="{{ route('destinations.create') }}" class="admin-quick-btn">
                    <i class="fas fa-plus" style="color:var(--admin-primary);"></i> Add Property
                </a>
                <a href="{{ route('bookings.index') }}" class="admin-quick-btn">
                    <i class="fas fa-calendar-alt" style="color:var(--admin-primary);"></i> All Bookings
                </a>
                <a href="{{ route('finance.dashboard') }}" class="admin-quick-btn">
                    <i class="fas fa-sterling-sign" style="color:#22c55e;"></i> Finance Portal
                </a>
                <a href="{{ route('reports.index') }}" class="admin-quick-btn">
                    <i class="fas fa-chart-bar" style="color:var(--admin-accent);"></i> Reports
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
