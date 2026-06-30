@extends('layouts.front')

@section('title', $destinations->title . ' - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero">
	<div class="tt-page-hero-bg" style="background-image: url('{{ $destinations->image_url }}');"></div>
	<div class="container" data-aos="fade-up">
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
				<div class="tt-detail-gallery mb-4" data-aos="fade-up">
					<img src="{{ $destinations->image_url }}"
						 alt="{{ $destinations->title }}" class="img-fluid rounded-3 w-100" loading="lazy">
					<span class="tt-detail-badge"><i class="fas fa-map-marker-alt me-1"></i> {{ $destinations->location ?? $destinations->region_label }}</span>
				</div>

				<!-- Content Card -->
				<div class="tt-detail-content" data-aos="fade-up">
					<h2>About This Property</h2>
					<p class="lead">{{ $destinations->description }}</p>
					<h4>Property Description</h4>
					<p>{{ $destinations->content }}</p>
				</div>

				<!-- Amenities -->
				<div class="tt-detail-content mt-4" data-aos="fade-up">
					<h4><i class="fas fa-check-circle me-2 text-success"></i>What's Included</h4>
					<div class="row g-2 mt-2">
						@php
							$amenityList = $destinations->amenities ?? ['Wi-Fi', 'Parking', 'Fully Equipped Kitchen', 'Linen & Towels'];
						@endphp
						@foreach($amenityList as $amenity)
						<div class="col-6 col-md-4">
							<div class="d-flex align-items-center gap-2 py-1">
								<i class="fas fa-check text-success" style="font-size:.8rem;"></i>
								<small>{{ $amenity }}</small>
							</div>
						</div>
						@endforeach
					</div>
				</div>

				<!-- Booking CTA -->
				<div class="tt-detail-booking mt-4" data-aos="fade-up">
					<div class="row g-0 align-items-center rounded-3 overflow-hidden border">
						<div class="col-md-8 p-4">
							<h4>Ready to Book This Property?</h4>
							<p class="mb-3">Secure your dates now. Free cancellation up to 8 weeks before arrival.</p>
							<div class="d-flex flex-wrap gap-3">
								@auth
								<a href="#booking-form" class="btn-tt-primary">
									<i class="fas fa-calendar-check me-2"></i> Book Now
								</a>
								@else
								<a href="{{ route('login') }}" class="btn-tt-primary">
									<i class="fas fa-sign-in-alt me-2"></i> Sign In to Book
								</a>
								@endauth
								<a href="{{ route('contact') }}" class="btn-tt-outline">
									<i class="fas fa-phone me-2"></i> Ask a Question
								</a>
							</div>
						</div>
						<div class="col-md-4 text-center p-4" style="background:var(--tt-primary);color:#fff;">
							<i class="fas fa-key fa-3x mb-2"></i>
							<h5 class="mb-1 text-white">Secure Booking</h5>
							<small>ABTA Protected</small>
						</div>
					</div>
				</div>

				<!-- Reviews -->
				<div class="mt-4" data-aos="fade-up">
					<h4>Guest Reviews
						@if($destinations->reviews_count > 0)
							<span class="badge" style="background:var(--tt-accent);color:var(--tt-dark);font-size:.75rem;vertical-align:middle;">
								<i class="fas fa-star me-1"></i>{{ number_format($destinations->average_rating, 1) }}
							</span>
						@endif
					</h4>
					@if($destinations->reviews_count > 0)
						@foreach($destinations->reviews as $review)
						<div class="tt-sidebar-card mb-3">
							<div class="d-flex justify-content-between mb-2">
								<strong>{{ $review->user->name ?? 'Guest' }}</strong>
								<small class="text-muted">{{ $review->created_at->format('M Y') }}</small>
							</div>
							<div class="mb-2">
								@for($i = 1; $i <= 5; $i++)
									<i class="fas fa-star" style="color:{{ $i <= $review->rating ? 'var(--tt-accent)' : '#ddd' }};font-size:.8rem;"></i>
								@endfor
							</div>
							<p class="mb-0" style="font-size:.9rem;">{{ $review->comment ?? $review->body }}</p>
						</div>
						@endforeach
					@else
						<p class="text-muted">No reviews yet. Be the first to stay here!</p>
					@endif

					@auth
					<div class="tt-sidebar-card mt-3">
						<h6>Leave a Review</h6>
						<form action="{{ route('reviews.store', $destinations->id) }}" method="POST">
							@csrf
							<div class="mb-3">
								<label class="form-label small fw-semibold">Rating</label>
								<select name="rating" class="tt-select" required>
									<option value="5">⭐⭐⭐⭐⭐ Excellent</option>
									<option value="4">⭐⭐⭐⭐ Very Good</option>
									<option value="3">⭐⭐⭐ Good</option>
									<option value="2">⭐⭐ Fair</option>
									<option value="1">⭐ Poor</option>
								</select>
							</div>
							<div class="mb-3">
								<label class="form-label small fw-semibold">Your Review</label>
								<textarea name="body" class="tt-input" rows="3" placeholder="Share your experience..." required></textarea>
							</div>
							<button type="submit" class="btn-tt-primary">Submit Review</button>
						</form>
					</div>
					@endauth
				</div>
			</div>

			<!-- Sidebar -->
			<div class="col-lg-4">
				<!-- Pricing Card -->
				<div class="tt-sidebar-card mb-4" data-aos="fade-left" style="position:sticky;top:90px;">
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
						<i class="fas fa-sign-in-alt me-2"></i>Sign In to Book
					</a>
					@endauth
				</div>

				<!-- Need Help -->
				<div class="tt-sidebar-card text-center" data-aos="fade-left">
					<div class="tt-info-icon mx-auto mb-3"><i class="fas fa-headset"></i></div>
					<h5>Need Help?</h5>
					<p class="text-muted">Our UK team is here Mon–Fri, 9AM–5:30PM</p>
					<a href="tel:+442079460123" class="btn-tt-primary w-100 mb-2"><i class="fas fa-phone me-2"></i> +44 20 7946 0123</a>
					<a href="mailto:info@francevacances.co.uk" class="btn-tt-outline w-100"><i class="fas fa-envelope me-2"></i> Email Us</a>
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
