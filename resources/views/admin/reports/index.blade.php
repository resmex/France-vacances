@extends('layouts.app')

@section('content')
<h5 class="mb-4 fw-bold">Reports</h5>

<!-- Summary -->
<div class="admin-card mb-4">
    <div class="admin-card-body p-0">
        <table class="admin-table mb-0">
            <thead>
                <tr>
                    <th>Total Bookings</th>
                    <th>Confirmed</th>
                    <th>Pending</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $stats['total_bookings'] }}</td>
                    <td>{{ $stats['confirmed'] }}</td>
                    <td>{{ $stats['pending'] }}</td>
                    <td>£{{ number_format($stats['total_revenue']) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Bookings by Status -->
<div class="admin-card mb-4">
    <div class="admin-card-header"><h5>Bookings by Status</h5></div>
    <div class="admin-card-body p-0">
        <table class="admin-table mb-0">
            <thead>
                <tr>
                    <th>Status</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($byStatus as $status => $count)
                <tr>
                    <td>{{ ucfirst($status) }}</td>
                    <td class="text-end">{{ $count }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-muted">No data yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Top Properties -->
<div class="admin-card mb-4">
    <div class="admin-card-header"><h5>Top Properties</h5></div>
    <div class="admin-card-body p-0">
        <table class="admin-table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Property Name</th>
                    <th>Region</th>
                    <th class="text-end">Bookings</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topProperties as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ Str::limit($p->title, 25) }}</td>
                    <td>{{ $p->region ?? '—' }}</td>
                    <td class="text-end">{{ $p->bookings_count }}</td>
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

<!-- Recent Bookings -->
<div class="admin-card">
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
                @forelse($recentBookings as $b)
                <tr>
                    <td>{{ $b->user->name ?? '—' }}</td>
                    <td>{{ Str::limit($b->destination->title ?? '—', 30) }}</td>
                    <td>{{ $b->total_display }}</td>
                    <td>{{ ucfirst($b->status) }}</td>
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
@endsection
