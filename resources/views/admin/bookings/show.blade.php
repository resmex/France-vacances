@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold">
        <i class="fas fa-calendar-alt me-2" style="color:var(--admin-primary)"></i>
        Booking #{{ $booking->id }}
    </h5>
    <a href="{{ route('bookings.index') }}" class="btn-admin-sm btn-admin-edit">
        <i class="fas fa-arrow-left me-1"></i> All Bookings
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <!-- Booking details -->
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5><i class="fas fa-info-circle"></i> Booking Details</h5>
                <span class="badge bg-{{ $booking->status_badge }}">{{ ucfirst($booking->status) }}</span>
            </div>
            <div class="admin-card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label small text-muted">Guest</label>
                        <div class="fw-semibold">{{ $booking->user->name ?? '—' }}</div>
                        <small class="text-muted">{{ $booking->user->email ?? '' }}</small>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small text-muted">Property</label>
                        <div class="fw-semibold">{{ $booking->destination->title ?? '—' }}</div>
                        <small class="text-muted">{{ $booking->destination->location ?? '' }}</small>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label small text-muted">Check-in</label>
                        <div class="fw-semibold">{{ optional($booking->check_in_date ?? $booking->travel_date)->format('d M Y') }}</div>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label small text-muted">Check-out</label>
                        <div class="fw-semibold">{{ optional($booking->check_out_date)->format('d M Y') ?? '—' }}</div>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label small text-muted">Nights</label>
                        <div class="fw-semibold">{{ $booking->nights_label }}</div>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label small text-muted">Guests</label>
                        <div class="fw-semibold">{{ $booking->guests }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small text-muted">Total</label>
                        <div class="fw-bold" style="font-size:1.2rem;color:var(--admin-primary);">{{ $booking->total_display }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small text-muted">Booked</label>
                        <div class="fw-semibold">{{ $booking->created_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment -->
        @if($booking->payment)
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5><i class="fas fa-receipt"></i> Payment</h5>
                <span class="badge bg-success">{{ ucfirst($booking->payment->status) }}</span>
            </div>
            <div class="admin-card-body">
                <div class="row g-3">
                    <div class="col-sm-4">
                        <label class="form-label small text-muted">Reference</label>
                        <div class="fw-semibold font-monospace">{{ $booking->payment->reference }}</div>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label small text-muted">Amount</label>
                        <div class="fw-bold">{{ $booking->payment->amount_display }}</div>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label small text-muted">Method</label>
                        <div class="fw-semibold">
                            {{ ucfirst($booking->payment->method) }}
                            @if($booking->payment->is_simulated)
                            <span class="badge bg-secondary ms-1" style="font-size:.65rem;">simulated</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Status Update -->
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="admin-card-header"><h5><i class="fas fa-edit"></i> Update Status</h5></div>
            <div class="admin-card-body">
                <form action="{{ route('bookings.status', $booking->id) }}" method="POST">
                    @csrf @method('PUT')
                    <select name="status" class="form-select mb-3">
                        @foreach(['pending','confirmed','cancelled','completed'] as $s)
                        <option value="{{ $s }}" {{ $booking->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-admin-accent w-100">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
