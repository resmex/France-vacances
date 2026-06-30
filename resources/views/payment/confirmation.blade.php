@extends('layouts.front')

@section('title', 'Booking Confirmed — France Vacances')

@section('page')
@include('partials.navbar')

<section class="tt-section" style="min-height:70vh;display:flex;align-items:center;">
	<div class="container" style="max-width:780px;">
		<!-- Confirmation Header -->
		<div class="text-center mb-5" data-aos="fade-up">
			<div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#22c55e,#16a34a);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;box-shadow:0 8px 24px rgba(34,197,94,.35);">
				<i class="fas fa-check" style="font-size:2rem;color:#fff;"></i>
			</div>
			<h1 class="fw-bold" style="font-size:2rem;color:var(--tt-primary);">Booking Confirmed!</h1>
			<p class="lead text-muted">
				Thank you, {{ Auth::user()->name }}. Your stay at
				<strong>{{ $booking->destination->title }}</strong> is secured.
			</p>
			@if($booking->payment)
			<span class="badge py-2 px-3" style="background:var(--tt-accent);color:var(--tt-dark);font-size:.85rem;border-radius:50px;">
				Reference: {{ $booking->payment->reference }}
			</span>
			@endif
		</div>

		<!-- Booking Details Card -->
		<div class="tt-sidebar-card mb-4" data-aos="fade-up">
			<div class="row g-0">
				<div class="col-md-4">
					<img src="{{ $booking->destination->image_url }}"
						 alt="{{ $booking->destination->title }}"
						 class="img-fluid h-100 rounded-start-3" style="object-fit:cover;min-height:200px;">
				</div>
				<div class="col-md-8 p-4">
					<span class="badge mb-2" style="background:var(--tt-primary);color:#fff;border-radius:50px;font-size:.75rem;">
						{{ $booking->destination->property_type_label }}
					</span>
					<h4 class="fw-bold">{{ $booking->destination->title }}</h4>
					<p class="text-muted small mb-3">
						<i class="fas fa-map-marker-alt me-1" style="color:var(--tt-accent);"></i>
						{{ $booking->destination->location ?? $booking->destination->region_label }}
					</p>
					<div class="row g-2">
						<div class="col-6">
							<div class="p-2 rounded" style="background:var(--tt-cream);">
								<div style="font-size:.7rem;color:var(--tt-dark-soft);text-transform:uppercase;letter-spacing:.05em;">Check-in</div>
								<div class="fw-semibold">{{ $booking->check_in_date->format('D d M Y') }}</div>
							</div>
						</div>
						<div class="col-6">
							<div class="p-2 rounded" style="background:var(--tt-cream);">
								<div style="font-size:.7rem;color:var(--tt-dark-soft);text-transform:uppercase;letter-spacing:.05em;">Check-out</div>
								<div class="fw-semibold">{{ $booking->check_out_date->format('D d M Y') }}</div>
							</div>
						</div>
						<div class="col-6">
							<div class="p-2 rounded" style="background:var(--tt-cream);">
								<div style="font-size:.7rem;color:var(--tt-dark-soft);text-transform:uppercase;letter-spacing:.05em;">Duration</div>
								<div class="fw-semibold">{{ $booking->nights_label }}</div>
							</div>
						</div>
						<div class="col-6">
							<div class="p-2 rounded" style="background:var(--tt-cream);">
								<div style="font-size:.7rem;color:var(--tt-dark-soft);text-transform:uppercase;letter-spacing:.05em;">Guests</div>
								<div class="fw-semibold">{{ $booking->guests }} {{ Str::plural('Guest', $booking->guests) }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Payment Summary -->
		<div class="tt-sidebar-card mb-4" data-aos="fade-up">
			<h5 class="mb-3"><i class="fas fa-receipt me-2" style="color:var(--tt-accent);"></i>Payment Summary</h5>
			<div class="tt-info-list">
				<div class="tt-info-row">
					<div class="tt-info-icon"><i class="fas fa-pound-sign"></i></div>
					<div class="d-flex justify-content-between w-100">
						<div><div class="tt-info-label">Amount Paid</div></div>
						<div class="tt-info-value fw-bold" style="color:var(--tt-primary);">{{ $booking->total_display }}</div>
					</div>
				</div>
				<div class="tt-info-row">
					<div class="tt-info-icon"><i class="fas fa-credit-card"></i></div>
					<div class="d-flex justify-content-between w-100">
						<div><div class="tt-info-label">Payment Method</div></div>
						<div class="tt-info-value">Card (Simulated)</div>
					</div>
				</div>
				<div class="tt-info-row">
					<div class="tt-info-icon"><i class="fas fa-check-circle" style="color:#22c55e;"></i></div>
					<div class="d-flex justify-content-between w-100">
						<div><div class="tt-info-label">Status</div></div>
						<div><span class="badge bg-success">Confirmed</span></div>
					</div>
				</div>
				@if($booking->payment)
				<div class="tt-info-row">
					<div class="tt-info-icon"><i class="fas fa-hashtag"></i></div>
					<div class="d-flex justify-content-between w-100">
						<div><div class="tt-info-label">Reference</div></div>
						<div class="tt-info-value fw-mono">{{ $booking->payment->reference }}</div>
					</div>
				</div>
				@endif
			</div>
		</div>

		<!-- What Happens Next -->
		<div class="tt-sidebar-card mb-4" data-aos="fade-up">
			<h5 class="mb-3"><i class="fas fa-list-check me-2" style="color:var(--tt-accent);"></i>What Happens Next</h5>
			<div class="d-flex gap-3 mb-3">
				<div style="min-width:32px;height:32px;border-radius:50%;background:var(--tt-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;">1</div>
				<div>
					<strong>Confirmation email</strong>
					<p class="mb-0 text-muted small">A booking confirmation has been sent to {{ Auth::user()->email }}</p>
				</div>
			</div>
			<div class="d-flex gap-3 mb-3">
				<div style="min-width:32px;height:32px;border-radius:50%;background:var(--tt-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;">2</div>
				<div>
					<strong>Property information pack</strong>
					<p class="mb-0 text-muted small">We'll send arrival details, key codes, and local tips 2 weeks before your check-in.</p>
				</div>
			</div>
			<div class="d-flex gap-3">
				<div style="min-width:32px;height:32px;border-radius:50%;background:var(--tt-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;">3</div>
				<div>
					<strong>Enjoy your French holiday!</strong>
					<p class="mb-0 text-muted small">Our UK team is available Mon–Fri 9AM–5:30PM if you need anything before or during your stay.</p>
				</div>
			</div>
		</div>

		<!-- Action Buttons -->
		<div class="d-flex flex-wrap gap-3 justify-content-center" data-aos="fade-up">
			<a href="{{ route('bookings.my') }}" class="btn-tt-primary">
				<i class="fas fa-calendar-alt me-2"></i>View My Bookings
			</a>
			<a href="{{ route('packages') }}" class="btn-tt-outline">
				<i class="fas fa-search me-2"></i>Browse More Properties
			</a>
			<a href="{{ route('contact') }}" class="btn-tt-outline">
				<i class="fas fa-headset me-2"></i>Contact Us
			</a>
		</div>

		<!-- ABTA Footer -->
		<div class="text-center mt-5" data-aos="fade-up">
			<div class="d-inline-flex align-items-center gap-2 px-4 py-2 rounded-3"
				 style="background:var(--tt-cream);font-size:.85rem;color:var(--tt-dark-soft);">
				<i class="fas fa-shield-alt" style="color:var(--tt-accent);"></i>
				<span>ABTA Protected Booking — France Vacances Ltd &nbsp;·&nbsp; 12 Regent Street, London W1B 5JG</span>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
