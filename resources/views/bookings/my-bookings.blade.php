@extends('layouts.front')

@section('title', 'My Bookings — France Vacances')

@section('page')
@include('partials.navbar')

<section class="tt-page-hero tt-page-hero-sm">
	<div class="tt-page-hero-bg" style="background-image: url('{{ asset('images/place-4.jpg') }}');"></div>
	<div class="container" data-aos="fade-up">
		<h1 class="tt-page-title">My <span class="accent">Bookings</span></h1>
		<p class="tt-page-subtitle">Your booking history with France Vacances.</p>
	</div>
</section>

<section class="tt-section">
	<div class="container" style="max-width:900px;">
		@if(session('success'))
		<div class="alert alert-success border-0 mb-4">
			<i class="fas fa-check-circle me-2"></i>{{ session('success') }}
		</div>
		@endif

		@if($bookings->count() > 0)
			@foreach($bookings as $booking)
			<div class="tt-sidebar-card mb-4" data-aos="fade-up">
				<div class="row g-0">
					<div class="col-md-3">
						<img src="{{ $booking->destination->image_url ?? asset('images/destination-1.jpg') }}"
							 alt="{{ $booking->destination->title ?? 'Property' }}"
							 class="img-fluid rounded-start-3 h-100" style="object-fit:cover;min-height:160px;">
					</div>
					<div class="col-md-9 p-4">
						<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
							<div>
								<span class="badge bg-{{ $booking->status_badge }} mb-1">{{ ucfirst($booking->status) }}</span>
								<h5 class="mb-0 fw-bold">{{ $booking->destination->title ?? 'Property' }}</h5>
								<small class="text-muted">
									<i class="fas fa-map-marker-alt me-1" style="color:var(--tt-accent);"></i>
									{{ $booking->destination->location ?? ($booking->destination->region_label ?? 'France') }}
								</small>
							</div>
							<div class="text-end">
								<div style="font-size:.75rem;color:var(--tt-dark-soft);">Total Paid</div>
								<div class="fw-bold" style="font-size:1.2rem;color:var(--tt-primary);">{{ $booking->total_display }}</div>
							</div>
						</div>

						<div class="row g-2 mt-2">
							<div class="col-6 col-md-3">
								<div style="font-size:.7rem;text-transform:uppercase;letter-spacing:.05em;color:var(--tt-dark-soft);">Check-in</div>
								<div class="fw-semibold small">{{ optional($booking->check_in_date ?? $booking->travel_date)->format('d M Y') ?? '—' }}</div>
							</div>
							<div class="col-6 col-md-3">
								<div style="font-size:.7rem;text-transform:uppercase;letter-spacing:.05em;color:var(--tt-dark-soft);">Check-out</div>
								<div class="fw-semibold small">{{ optional($booking->check_out_date)->format('d M Y') ?? '—' }}</div>
							</div>
							<div class="col-6 col-md-3">
								<div style="font-size:.7rem;text-transform:uppercase;letter-spacing:.05em;color:var(--tt-dark-soft);">Duration</div>
								<div class="fw-semibold small">{{ $booking->nights_label }}</div>
							</div>
							<div class="col-6 col-md-3">
								<div style="font-size:.7rem;text-transform:uppercase;letter-spacing:.05em;color:var(--tt-dark-soft);">Guests</div>
								<div class="fw-semibold small">{{ $booking->guests }} {{ Str::plural('guest', $booking->guests) }}</div>
							</div>
						</div>

						<div class="mt-3 d-flex flex-wrap gap-2 align-items-center">
							@if($booking->isPending())
							<a href="{{ route('payment.checkout', $booking->id) }}" class="btn-tt-primary py-1 px-3" style="font-size:.85rem;">
								<i class="fas fa-credit-card me-1"></i> Complete Payment
							</a>
							@elseif($booking->isConfirmed() && $booking->payment)
							<span class="badge bg-success py-2 px-3">
								<i class="fas fa-check me-1"></i> Ref: {{ $booking->payment->reference }}
							</span>
							@endif
							<a href="{{ route('desti.show', $booking->destination_id) }}" class="btn-tt-outline py-1 px-3" style="font-size:.85rem;">
								<i class="fas fa-eye me-1"></i> View Property
							</a>
							<small class="text-muted ms-auto">Booked {{ $booking->created_at->diffForHumans() }}</small>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			<div class="d-flex justify-content-center mt-4">
				{{ $bookings->links('pagination::bootstrap-4') }}
			</div>
		@else
		<div class="tt-empty-state" data-aos="fade-up">
			<div class="icon"><i class="fas fa-calendar-alt"></i></div>
			<h3>No Bookings Yet</h3>
			<p>You haven't made any bookings yet. Browse our holiday properties and plan your perfect French escape.</p>
			<a href="{{ route('packages') }}" class="btn-tt-primary">Browse Properties</a>
		</div>
		@endif
	</div>
</section>

@include('partials.footer')
@endsection
