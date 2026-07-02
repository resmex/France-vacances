@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold">Bookings</h5>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('bookings.index') }}"
           class="btn-admin-sm {{ !request('status') ? 'btn-admin-accent' : 'btn-admin-edit' }}">
            All <span class="badge bg-secondary ms-1">{{ $counts['all'] }}</span>
        </a>
        <a href="{{ route('bookings.index', ['status'=>'pending']) }}"
           class="btn-admin-sm {{ request('status')=='pending' ? 'btn-admin-accent' : 'btn-admin-edit' }}">
            Pending <span class="badge bg-secondary ms-1">{{ $counts['pending'] }}</span>
        </a>
        <a href="{{ route('bookings.index', ['status'=>'confirmed']) }}"
           class="btn-admin-sm {{ request('status')=='confirmed' ? 'btn-admin-accent' : 'btn-admin-edit' }}">
            Confirmed <span class="badge bg-secondary ms-1">{{ $counts['confirmed'] }}</span>
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        @if($bookings->count())
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Guest</th>
                    <th>Property</th>
                    <th>Check-in</th>
                    <th>Nights</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>
                        {{ $b->user->name ?? '—' }}<br>
                        <small class="text-muted">{{ $b->user->email ?? '' }}</small>
                    </td>
                    <td>{{ Str::limit($b->destination->title ?? '—', 28) }}</td>
                    <td>{{ optional($b->check_in_date ?? $b->travel_date)->format('d M Y') ?? '—' }}</td>
                    <td>{{ $b->nights ?? '—' }}</td>
                    <td>{{ $b->total_display }}</td>
                    <td>{{ ucfirst($b->status) }}</td>
                    <td class="text-end">
                        <a href="{{ route('bookings.show', $b->id) }}" class="btn-admin-sm btn-admin-edit">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">{{ $bookings->links('pagination::bootstrap-4') }}</div>
        @else
        <div class="admin-empty p-5 text-center">
            <i class="fas fa-calendar-alt fa-2x mb-2 opacity-25"></i>
            <p class="text-muted">No bookings yet</p>
        </div>
        @endif
    </div>
</div>
@endsection
