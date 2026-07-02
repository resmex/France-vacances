@extends('layouts.front')

@section('title', $destinations->title . ' - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero" style="background-image:url('{{ asset('images/destination-1.jpg') }}');">
	<div class="container">
		<h1 class="tt-page-title">{{ $destinations->title }}</h1>
		<p class="tt-page-subtitle">{{ $destinations->description }}</p>
	</div>
</section>

<!-- Property Detail -->
<section class="tt-section">
	<div class="container">
		<div class="row g-4">
			<!-- Main Content -->
			<div class="col-lg-8">
				<!-- Gallery Image -->
				<div class="tt-detail-gallery mb-4">
					<img src="{{ $destinations->image_url }}"
						 alt="{{ $destinations->title }}" class="img-fluid rounded-3 w-100" loading="lazy">
					<span class="tt-detail-badge"><i class="fas fa-map-marker-alt me-1"></i> {{ $destinations->location ?? $destinations->region_label }}</span>
				</div>

				<!-- Content Card -->
				<div class="tt-detail-content">
					<h2>About This Property</h2>
					<p class="lead">{{ $destinations->description }}</p>
					<h4>Property Description</h4>
					<p>{{ $destinations->content }}</p>
				</div>

			</div>

			<!-- Sidebar -->
			<div class="col-lg-4">
				<!-- Pricing Card -->
				<div class="tt-sidebar-card mb-4" style="position:sticky;top:90px;">
					<div class="text-center mb-4">
						<div class="tt-price-label">Starting From</div>
						<div class="tt-price-amount">{{ $destinations->price_display }}</div>
						<small class="text-muted">prices vary by season</small>
					</div>
					<div class="tt-info-list">
						<div class="tt-info-row">
							<div class="tt-info-icon"><i class="fas fa-bed"></i></div>
							<div>
								<div class="tt-info-label">Bedrooms</div>
								<div class="tt-info-value">{{ $destinations->bedrooms_label }}</div>
							</div>
						</div>
						<div class="tt-info-row">
							<div class="tt-info-icon"><i class="fas fa-bath"></i></div>
							<div>
								<div class="tt-info-label">Bathrooms</div>
								<div class="tt-info-value">{{ $destinations->bathrooms ?? '–' }}</div>
							</div>
						</div>
						<div class="tt-info-row">
							<div class="tt-info-icon"><i class="fas fa-users"></i></div>
							<div>
								<div class="tt-info-label">Max Guests</div>
								<div class="tt-info-value">{{ $destinations->max_guests_label }}</div>
							</div>
						</div>
						<div class="tt-info-row">
							<div class="tt-info-icon"><i class="fas fa-home"></i></div>
							<div>
								<div class="tt-info-label">Property Type</div>
								<div class="tt-info-value">{{ $destinations->property_type_label }}</div>
							</div>
						</div>
						<div class="tt-info-row">
							<div class="tt-info-icon"><i class="fas fa-map-marker-alt"></i></div>
							<div>
								<div class="tt-info-label">Region</div>
								<div class="tt-info-value">{{ $destinations->region_label }}</div>
							</div>
						</div>
						<div class="tt-info-row">
							<div class="tt-info-icon"><i class="fas fa-star"></i></div>
							<div>
								<div class="tt-info-label">Guest Rating</div>
								<div class="tt-info-value">
									@php $rating = $destinations->display_rating; @endphp
									@if($rating)
										{{ number_format($rating, 2) }}/5
										@if($destinations->reviews_count > 0)
											({{ $destinations->reviews_count }} {{ Str::plural('review', $destinations->reviews_count) }})
										@endif
									@else
										New Property
									@endif
								</div>
							</div>
						</div>
					</div>

					<div class="mt-3">
						@include('partials.wishlist-save-button', ['destination' => $destinations])
					</div>

					@auth
					<form action="{{ route('bookings.store', $destinations->id) }}" method="POST" class="mt-4" id="booking-form">
						@csrf
						<div class="mb-3">
							<label class="form-label small fw-semibold">Check-in Date</label>
							<input type="date" name="check_in_date" id="check_in_date" class="tt-input" required min="{{ date('Y-m-d') }}">
						</div>
						<div class="mb-3">
							<label class="form-label small fw-semibold">Check-out Date</label>
							<input type="date" name="check_out_date" id="check_out_date" class="tt-input" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
						</div>
						<div class="mb-3">
							<label class="form-label small fw-semibold">Number of Guests</label>
							<select name="guests" class="tt-select" required>
								@for($i = 1; $i <= ($destinations->max_guests ?? 12); $i++)
									<option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}</option>
								@endfor
							</select>
						</div>
						<div id="booking-summary" class="p-3 rounded mb-3" style="background:var(--tt-cream);display:none;">
							<div class="d-flex justify-content-between">
								<small>Nights</small>
								<small id="nights-count">—</small>
							</div>
							<div class="d-flex justify-content-between fw-semibold mt-1">
								<small>Total Estimate</small>
								<small id="total-estimate">—</small>
							</div>
						</div>
						<button type="submit" class="btn-tt-primary w-100">
							<i class="fas fa-calendar-check me-2"></i>Book This Property
						</button>
					</form>
					@else
					<a href="{{ route('login') }}" class="btn-tt-primary w-100 mt-4 text-center d-block">
						<i class="fas fa-sign-in-alt me-2"></i>Login to Book
					</a>
					@endauth
				</div>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')

@push('scripts')
<script>
(function() {
    const pricePerNight = {{ $destinations->price_per_night ?? $destinations->price ?? 0 }};
    const checkIn  = document.getElementById('check_in_date');
    const checkOut = document.getElementById('check_out_date');
    const summary  = document.getElementById('booking-summary');
    const nightsEl = document.getElementById('nights-count');
    const totalEl  = document.getElementById('total-estimate');

    function update() {
        if (!checkIn || !checkOut || !checkIn.value || !checkOut.value) return;
        const d1    = new Date(checkIn.value);
        const d2    = new Date(checkOut.value);
        const nights = Math.round((d2 - d1) / 86400000);
        if (nights < 1) { summary.style.display = 'none'; return; }
        const total = nights * pricePerNight;
        nightsEl.textContent = nights + ' night' + (nights > 1 ? 's' : '');
        totalEl.textContent  = '£' + total.toLocaleString('en-GB');
        summary.style.display = 'block';
        // Ensure check-out is always after check-in
        checkOut.min = checkIn.value;
    }

    if (checkIn) {
        checkIn.addEventListener('change', function() {
            const next = new Date(this.value);
            next.setDate(next.getDate() + 1);
            checkOut.min = next.toISOString().split('T')[0];
            if (checkOut.value && new Date(checkOut.value) <= new Date(this.value)) {
                checkOut.value = next.toISOString().split('T')[0];
            }
            update();
        });
    }
    if (checkOut) checkOut.addEventListener('change', update);
})();
</script>
@endpush
@endsection
