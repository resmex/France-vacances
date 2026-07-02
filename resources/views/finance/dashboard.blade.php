@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="admin-welcome" style="background:#065f46;">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2><i class="fas fa-sterling-sign me-2" style="color:#34d399;"></i> Finance Portal</h2>
            <p>Revenue analytics, payment records, and financial performance for France Vacances.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <span class="date-badge">
                <i class="fas fa-calendar-day me-1"></i>{{ now()->format('l, j M Y') }}
            </span>
        </div>
    </div>
</div>

<!-- Revenue KPIs -->
<div class="row g-3 mb-4">
    @php
    $mom = $stats['lastMonthRev'] > 0
        ? round((($stats['thisMonthRev'] - $stats['lastMonthRev']) / $stats['lastMonthRev']) * 100, 1)
        : null;
    $kpis = [
        ['icon'=>'fas fa-sterling-sign', 'color'=>'green',  'value'=>'£'.number_format($stats['totalRevenue']),     'label'=>'Total Revenue',         'sub'=>'All confirmed payments'],
        ['icon'=>'fas fa-calendar-alt',  'color'=>'blue',   'value'=>'£'.number_format($stats['thisMonthRev']),      'label'=>'This Month',            'sub'=>$mom !== null ? ($mom >= 0 ? '+' : '').$mom.'% vs last month' : 'No prior month'],
        ['icon'=>'fas fa-calendar-week', 'color'=>'cyan',   'value'=>'£'.number_format($stats['thisWeekRev']),       'label'=>'This Week',             'sub'=>'Mon – today'],
        ['icon'=>'fas fa-clock',         'color'=>'amber',  'value'=>'£'.number_format($stats['pendingValue']),      'label'=>'Pending Value',         'sub'=>'Awaiting payment'],
        ['icon'=>'fas fa-receipt',       'color'=>'rose',   'value'=>number_format($stats['totalBookings']),         'label'=>'Total Bookings',        'sub'=>$stats['confirmedCount'].' confirmed'],
        ['icon'=>'fas fa-calculator',    'color'=>'blue',   'value'=>'£'.number_format($stats['avgBookingValue']),   'label'=>'Avg Booking Value',     'sub'=>'Confirmed bookings'],
    ];
    @endphp
    @foreach($kpis as $k)
    <div class="col-xl-2 col-md-4 col-6">
        <div class="admin-stat-card">
            <div class="admin-stat-icon {{ $k['color'] }}"><i class="{{ $k['icon'] }}"></i></div>
            <div class="admin-stat-info">
                <h3>{{ $k['value'] }}</h3>
                <small>{{ $k['label'] }}</small>
                @if(!empty($k['sub']))
                <div style="font-size:.65rem;color:var(--admin-text-soft);margin-top:2px;">{{ $k['sub'] }}</div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-4">
    <!-- Monthly Revenue Chart (bar table) -->
    <div class="col-lg-8">
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5><i class="fas fa-chart-bar me-2"></i>Monthly Revenue — Last 12 Months</h5>
            </div>
            <div class="admin-card-body">
                @if($monthlyRevenue->sum('revenue') > 0)
                <div style="display:flex;align-items:flex-end;gap:6px;height:160px;padding-bottom:4px;">
                    @foreach($monthlyRevenue as $month)
                    @php
                        $pct = $monthlyMax > 0 ? ($month['revenue'] / $monthlyMax) * 100 : 0;
                        $isCurrentMonth = $month['label'] === now()->format('M Y');
                    @endphp
                    <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;">
                        <div style="font-size:.55rem;color:var(--admin-text-soft);writing-mode:vertical-rl;transform:rotate(180deg);">
                            £{{ number_format($month['revenue']) }}
                        </div>
                        <div style="
                            flex:1;width:100%;
                            background:{{ $isCurrentMonth ? 'var(--admin-accent)' : 'var(--admin-primary)' }};
                            border-radius:4px 4px 0 0;
                            min-height:4px;
                            height:{{ max(4, $pct) }}%;
                            opacity:{{ $pct > 0 ? 1 : 0.15 }};
                            transition:.3s;
                            align-self:flex-end;
                        " title="{{ $month['label'] }}: £{{ number_format($month['revenue']) }}"></div>
                        <div style="font-size:.55rem;color:var(--admin-text-soft);white-space:nowrap;">
                            {{ $month['label'] }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="admin-empty py-4">
                    <i class="fas fa-chart-bar"></i>
                    <p>No confirmed payments recorded yet.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Recent Payments Table -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-receipt me-2"></i>Recent Payments</h5>
                <a href="{{ route('payments.index') }}" class="btn-admin-sm btn-admin-edit">View All</a>
            </div>
            <div class="admin-card-body p-0">
                @if($recentPayments->count() > 0)
                <table class="admin-table mb-0">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Guest</th>
                            <th>Property</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th class="text-end">Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentPayments as $payment)
                        <tr>
                            <td>
                                <code style="font-size:.72rem;background:var(--admin-surface);padding:2px 6px;border-radius:4px;">
                                    {{ $payment->reference ?? 'FV-'.$payment->id }}
                                </code>
                            </td>
                            <td style="font-size:.82rem;">{{ $payment->booking->user->name ?? '—' }}</td>
                            <td style="font-size:.82rem;">{{ Str::limit($payment->booking->destination->title ?? '—', 20) }}</td>
                            <td>
                                <span class="badge-cat" style="font-size:.65rem;">
                                    {{ ucfirst($payment->method ?? 'card') }}
                                </span>
                            </td>
                            <td style="font-size:.75rem;color:var(--admin-text-soft);">
                                {{ $payment->created_at->format('d M Y') }}
                            </td>
                            <td class="text-end" style="font-weight:700;color:var(--admin-primary);font-size:.85rem;">
                                £{{ number_format($payment->amount / 100, 2) }}
                            </td>
                            <td>
                                <span class="badge bg-{{ $payment->status === 'completed' ? 'success' : 'warning' }}" style="font-size:.65rem;">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="admin-empty">
                    <i class="fas fa-receipt"></i>
                    <p>No payments recorded yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right column -->
    <div class="col-lg-4">
        <!-- Revenue by Property Type -->
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5><i class="fas fa-home me-2"></i>Revenue by Type</h5>
            </div>
            <div class="admin-card-body">
                @if($byType->count() > 0)
                @php $typeTotal = $byType->sum('revenue') ?: 1; @endphp
                @foreach($byType as $row)
                @php $pct = round(($row->revenue / $typeTotal) * 100); @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:.82rem;font-weight:600;">{{ $row->property_type ?: 'Unspecified' }}</span>
                        <span style="font-size:.82rem;font-weight:700;color:var(--admin-primary);">
                            £{{ number_format($row->revenue) }}
                        </span>
                    </div>
                    <div style="background:#e5e7eb;border-radius:50px;height:6px;">
                        <div style="width:{{ $pct }}%;background:var(--admin-primary);border-radius:50px;height:6px;transition:.4s;"></div>
                    </div>
                    <small class="text-muted">{{ $row->count }} {{ Str::plural('booking', $row->count) }} &middot; {{ $pct }}%</small>
                </div>
                @endforeach
                @else
                <p class="text-muted text-center py-3" style="font-size:.85rem;">No booking data yet.</p>
                @endif
            </div>
        </div>

        <!-- Revenue by Region -->
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5><i class="fas fa-map-marker-alt me-2"></i>Revenue by Region</h5>
            </div>
            <div class="admin-card-body">
                @if($byRegion->count() > 0)
                @foreach($byRegion as $row)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <div style="font-size:.82rem;font-weight:600;">{{ $row->region }}</div>
                        <small class="text-muted">{{ $row->count }} {{ Str::plural('booking', $row->count) }}</small>
                    </div>
                    <div style="font-weight:700;color:var(--admin-primary);font-size:.85rem;">
                        £{{ number_format($row->revenue) }}
                    </div>
                </div>
                @endforeach
                @else
                <p class="text-muted text-center py-3" style="font-size:.85rem;">No booking data yet.</p>
                @endif
            </div>
        </div>

        <!-- Top Properties -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-trophy me-2" style="color:var(--admin-accent);"></i>Top Properties</h5>
            </div>
            <div class="admin-card-body">
                @if($topProperties->count() > 0)
                @foreach($topProperties as $i => $prop)
                <div class="d-flex align-items-center gap-2 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div style="width:22px;height:22px;border-radius:50%;background:var(--admin-primary);color:#fff;font-size:.65rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        {{ $i + 1 }}
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div style="font-size:.82rem;font-weight:600;" class="text-truncate">{{ $prop->title }}</div>
                        <small class="text-muted">{{ $prop->bookings }} {{ Str::plural('booking', $prop->bookings) }}</small>
                    </div>
                    <div style="font-weight:700;color:var(--admin-primary);font-size:.82rem;flex-shrink:0;">
                        £{{ number_format($prop->revenue) }}
                    </div>
                </div>
                @endforeach
                @else
                <p class="text-muted text-center py-3" style="font-size:.85rem;">No revenue data yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
