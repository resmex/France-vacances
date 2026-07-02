@extends('layouts.front')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home-search.css') }}?v={{ filemtime(public_path('css/home-search.css')) }}">
@endpush

@section('page')
@include('partials.navbar')

<!-- Hero -->
<section class="tt-hero" style="background-image:url('{{ asset('images/bg_1.jpg') }}');">
	<div class="container tt-hero-content">
		<div class="row align-items-center">
			<div class="col-lg-8">
				<h1 class="tt-hero-title">
					Find a Holiday Home <span class="accent">in France</span>
				</h1>

				<p class="tt-hero-text">
					France Vacances helps you find and book holiday homes in France.
					Choose from cottages, villas, chalets and apartments across six French regions.
				</p>

				<div class="tt-hero-actions">
					<a href="{{ route('packages') }}" class="btn-tt-accent">
						View Properties <i class="fas fa-arrow-right"></i>
					</a>
					<a href="{{ route('contact') }}" class="btn-tt-outline-white">
						Contact Us <i class="fas fa-phone"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Search Bar -->
<section class="tt-booking-section">
	<div class="container">
		<div class="tt-search-bar tt-booking-bar">
			<form action="{{ route('packages') }}" method="GET">
				<div class="tt-booking-row">
					<div class="tt-booking-field">
						<div class="tt-booking-icon"><i class="fas fa-map-marker-alt"></i></div>
						<div>
							<label>Where</label>
							<input type="text" name="search" placeholder="Provence, France" value="{{ request('search') }}">
						</div>
					</div>
					<div class="tt-booking-divider"></div>
					<div class="tt-booking-field">
						<div class="tt-booking-icon"><i class="fas fa-calendar-alt"></i></div>
						<div>
							<label>Check in &mdash; out</label>
							<input type="text" name="dates" placeholder="12 Jul &mdash; 19 Jul" value="{{ request('dates') }}">
						</div>
					</div>
					<div class="tt-booking-divider"></div>
					<div class="tt-booking-field">
						<div class="tt-booking-icon"><i class="fas fa-user-friends"></i></div>
						<div>
							<label>Guests</label>
							<input type="text" name="guests" placeholder="4 adults &middot; 2 children" value="{{ request('guests') }}">
						</div>
					</div>
					<button type="submit" class="tt-booking-search-btn">
						<i class="fas fa-search"></i> Search
					</button>
				</div>
			</form>
		</div>
	</div>
</section>

<!-- Featured Properties -->
<section class="tt-section">
	<div class="container">
		<div class="tt-section-header text-center">
			<h2 class="tt-title">Holiday <span class="accent">Properties</span></h2>
			<p class="tt-subtitle">
				Some of the holiday homes we list in France.
			</p>
		</div>

		<div class="tt-dest-grid">
			@forelse ($featuredProperties as $destination)
			<article class="tt-dest-card">
				<div class="tt-dest-card-img">
					<img src="{{ $destination->image_url }}"
						 alt="{{ $destination->title }}" loading="lazy">
					<span class="badge-cat">{{ $destination->property_type_label }}</span>
				</div>
				<div class="tt-dest-card-body">
					<div class="tt-dest-card-meta">
						<span><i class="fas fa-map-marker-alt"></i> {{ $destination->location ?? $destination->region_label }}</span>
						<span><i class="fas fa-bed"></i> {{ $destination->bedrooms_label }}</span>
					</div>
					<h3 class="tt-dest-card-title">
						<a href="{{ route('desti.show', $destination->id) }}">{{ $destination->title }}</a>
					</h3>
					<p class="tt-dest-card-desc">{{ Str::limit($destination->description, 100) }}</p>
					<div class="d-flex align-items-center gap-2 mb-2" style="font-size:.83rem;color:var(--tt-dark-soft);">
						<i class="fas fa-star" style="color:var(--tt-accent);font-size:.75rem;"></i>
						<span>{{ $destination->display_rating ? number_format($destination->display_rating, 2) : 'New' }}</span>
						<span style="color:#ccc;">·</span>
						<i class="fas fa-users" style="font-size:.75rem;"></i>
						<span>{{ $destination->max_guests_label }}</span>
					</div>
					<div class="tt-dest-card-footer">
						<div>
							<div class="tt-dest-price-label">From</div>
							<div class="tt-dest-price-value">{{ $destination->price_display }}</div>
						</div>
						<a href="{{ route('desti.show', $destination->id) }}" class="tt-dest-card-link">
							View Details <i class="fas fa-arrow-right"></i>
						</a>
					</div>
					@include('partials.wishlist-save-button', ['destination' => $destination])
				</div>
			</article>
			@empty
			<div class="col-12 text-center py-5 text-muted">
				<i class="fas fa-home fa-3x mb-3" style="color:var(--tt-accent);"></i>
				<p>No properties yet. <a href="{{ route('packages') }}">View all listings</a>.</p>
			</div>
			@endforelse
		</div>

		<div class="text-center mt-5">
			<a href="{{ route('packages') }}" class="btn-tt-primary">
				View All Properties
			</a>
		</div>
	</div>
</section>

<!-- Browse by Region -->
<section class="tt-section tt-section-light">
	<div class="container">
		<div class="tt-section-header text-center">
			<h2 class="tt-title">Browse by <span class="accent">Region</span></h2>
			<p class="tt-subtitle">France Vacances lists holiday homes in six regions.</p>
		</div>
		@php
			$regionIcons = [
				'Provence'      => 'fas fa-sun',
				'Côte d\'Azur'  => 'fas fa-water',
				'Dordogne'      => 'fas fa-tree',
				'French Alps'   => 'fas fa-mountain',
				'Paris'         => 'fas fa-landmark',
				'Loire Valley'  => 'fas fa-wine-glass-alt',
			];
			$mainRegions = $regions->whereIn('name', array_keys($regionIcons));
		@endphp
		<div class="tt-cat-grid">
			@foreach($mainRegions as $region)
			<a href="{{ route('regions.show', urlencode($region->name)) }}" class="tt-cat-card text-decoration-none">
				<div class="icon"><i class="{{ $regionIcons[$region->name] ?? 'fas fa-map-marker-alt' }}"></i></div>
				<h5>{{ $region->name }}</h5>
				@if($region->destinations_count)
					<small class="mt-1 d-block" style="color:var(--tt-accent);font-weight:600;">{{ $region->destinations_count }} {{ Str::plural('property', $region->destinations_count) }}</small>
				@else
					<small class="mt-1 d-block text-muted">0 properties</small>
				@endif
			</a>
			@endforeach
		</div>
	</div>
</section>

<!-- Why Choose Us -->
<section class="tt-section">
	<div class="container">
		<div class="row align-items-center g-5">
			<div class="col-lg-6">
				<div class="tt-features-img">
					<img src="{{ asset('images/about.jpg') }}" alt="French Holiday Property">
				</div>
			</div>

			<div class="col-lg-6">
				<div class="tt-section-header">
					<h2 class="tt-title">Why Choose <span class="accent">France Vacances</span></h2>
					<p class="tt-subtitle">
						We check every property before listing it, and every booking is protected.
					</p>
				</div>

				<div class="tt-feature-item">
					<div class="tt-feature-icon"><i class="fas fa-check-circle"></i></div>
					<div>
						<h4>Checked Properties</h4>
						<p>Our team visits and checks every property before it appears on our website.</p>
					</div>
				</div>
				<div class="tt-feature-item">
					<div class="tt-feature-icon"><i class="fas fa-shield-alt"></i></div>
					<div>
						<h4>Safe Bookings</h4>
						<p>Your money is safe when you book with us.</p>
					</div>
				</div>
				<div class="tt-feature-item">
					<div class="tt-feature-icon"><i class="fas fa-headset"></i></div>
					<div>
						<h4>Support Team</h4>
						<p>Our team is available Monday to Friday, 9AM to 5:30PM GMT.</p>
					</div>
				</div>
				<div class="tt-feature-item">
					<div class="tt-feature-icon"><i class="fas fa-star"></i></div>
					<div>
						<h4>Clear Pricing</h4>
						<p>No hidden fees. The price you see is the price you pay.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
