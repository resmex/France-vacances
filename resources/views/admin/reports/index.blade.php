@extends('layouts.app')

@section('content')
<h5 class="mb-4 fw-bold"><i class="fas fa-chart-bar me-2" style="color:var(--admin-primary)"></i>Reports &amp; Analytics</h5>

<!-- KPI Row -->
<div class="row g-3 mb-4">
    @foreach([
        ['icon'=>'fas fa-calendar-check','color'=>'green', 'value'=>$stats['total_bookings'],  'label'=>'Total Bookings'],
        ['icon'=>'fas fa-check-circle',  'color'=>'cyan',  'value'=>$stats['confirmed'],        'label'=>'Confirmed'],
        ['icon'=>'fas fa-clock',         'color'=>'amber', 'value'=>$stats['pending'],          'label'=>'Pending'],
        ['icon'=>'fas fa-pound-sign',    'color'=>'blue',  'value'=>'£'.number_format($stats['total_revenue']), 'label'=>'Revenue (GBP)'],
        ['icon'=>'fas fa-home',          'color'=>'rose',  'value'=>$stats['total_properties'], 'label'=>'Properties'],
        ['icon'=>'fas fa-users',         'color'=>'cyan',  'value'=>$stats['total_guests'],     'label'=>'Registered Guests'],
    ] as $kpi)
    <div class="col-lg-2 col-md-4 col-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon {{ $kpi['color'] }}"><i class="{{ $kpi['icon'] }}"></i></div>
            <div class="admin-stat-info">
                <h3>{{ $kpi['value'] }}</h3>
                <small>{{ $kpi['label'] }}</small>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">
    <!-- Top Properties -->
    <div class="col-lg-5">
        <div class="admin-card">
            <div class="admin-card-header"><h5><i class="fas fa-trophy"></i> Top Properties by Bookings</h5></div>
            <div class="admin-card-body">
                @forelse($topProperties as $p)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2 align-items-center">
                        <img src="{{ $p->image_url }}" class="img-thumb" alt="{{ $p->title }}" style="width:40px;height:40px;border-radius:6px;object-fit:cover;">
                        <div>
                            <div class="fw-semibold" style="font-size:.85rem;">{{ Str::limit($p->title, 25) }}</div>
                            <small class="text-muted">{{ $p->region ?? '—' }}</small>
                        </div>
                    </div>
                    <span class="badge" style="background:var(--admin-primary);color:#fff;">{{ $p->bookings_count }} {{ Str::plural('booking', $p->bookings_count) }}</span>
                </div>
                @empty
                <p class="text-muted small">No bookings yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Booking Status Breakdown -->
    <div class="col-lg-3">
        <div class="admin-card">
            <div class="admin-card-header"><h5><i class="fas fa-pie-chart"></i> By Status</h5></div>
            <div class="admin-card-body">
                @php
                    $statusColors = ['confirmed'=>'success','pending'=>'warning','cancelled'=>'danger','completed'=>'info'];
                @endphp
                @forelse($byStatus as $status => $count)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-{{ $statusColors[$status] ?? 'secondary' }}">{{ ucfirst($status) }}</span>
                    <strong>{{ $count }}</strong>
                </div>
                @empty
                <p class="text-muted small">No data yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-clock-rotate-left"></i> Recent Bookings</h5>
                <a href="{{ route('bookings.index') }}" class="btn-admin-sm btn-admin-edit">View All</a>
            </div>
            <div class="admin-card-body">
                @forelse($recentBookings as $b)
                <div class="admin-recent-item">
                    <div>
                        <h6 style="font-size:.82rem;">{{ $b->user->name ?? '—' }}</h6>
                        <small class="text-muted">{{ Str::limit($b->destination->title ?? '—', 22) }} · {{ $b->total_display }}</small>
                    </div>
                    <span class="badge bg-{{ $b->status_badge }}">{{ ucfirst($b->status) }}</span>
                </div>
                @empty
                <p class="text-muted small">No bookings yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
