@extends('layouts.front')

@section('page')
@include('partials.navbar')

<!-- Hero -->
<section class="tt-hero">
	<div class="tt-hero-bg"></div>
	<div class="container tt-hero-content">
		<div class="row align-items-center">
			<div class="col-lg-7" data-aos="fade-right">
				<div class="tt-badge">
					<span>🇫🇷</span>
					<span>UK Holiday Company for France</span>
				</div>

				<h1 class="tt-hero-title">
					Find a Holiday Home <span class="accent">in France</span>
				</h1>

				<p class="tt-hero-text">
					France Vacances helps you find and book holiday homes in France.
					Choose from cottages, villas, chalets and apartments across six French regions.
				</p>

				<div class="tt-hero-actions">
					<a href="{{ route('packages') }}" class="btn-tt-accent">
						Browse Properties <i class="fas fa-arrow-right"></i>
					</a>
					<a href="{{ route('contact') }}" class="btn-tt-outline-white">
						Speak to Our Team <i class="fas fa-phone"></i>
					</a>
				</div>

				<div class="tt-trust-row">
					<div class="tt-trust-item">
						<div class="tt-trust-icon"><i class="fas fa-shield-alt"></i></div>
						<div>
							<div class="tt-trust-value">Safe Booking</div>
							<div class="tt-trust-label">ABTA Protected</div>
						</div>
					</div>
					<div class="tt-trust-item">
						<div class="tt-trust-icon"><i class="fas fa-star"></i></div>
						<div>
							<div class="tt-trust-value">4.9/5</div>
							<div class="tt-trust-label">5,200+ Guest Reviews</div>
						</div>
					</div>
					<div class="tt-trust-item">
						<div class="tt-trust-icon"><i class="fas fa-award"></i></div>
						<div>
							<div class="tt-trust-value">15+ Years</div>
							<div class="tt-trust-label">Experience in France</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-5 d-none d-lg-block" data-aos="fade-left" data-aos-delay="200">
				<div class="tt-hero-card">
					<img src="{{ asset('images/place-1.jpg') }}" alt="Provence Villa with Pool" loading="eager">
					<div class="tt-hero-card-body">
						<span class="card-badge">Most Popular</span>
						<h4>Provence Villa with Private Pool</h4>
						<div class="tt-hero-card-meta">
							<span><i class="fas fa-bed"></i> 4 Bedrooms</span>
							<span><i class="fas fa-users"></i> Sleeps 8</span>
						</div>
						<div class="tt-hero-card-footer">
							<div>
								<div class="price-from">From</div>
								<div class="price-value">£285/night</div>
							</div>
							<a href="{{ route('packages') }}" class="tt-hero-card-link">
								View Details <i class="fas fa-arrow-right"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="tt-hero-scroll">
		<span>Scroll to Explore</span>
		<i class="fas fa-chevron-down"></i>
	</div>
</section>

<!-- Search Bar -->
<section class="tt-section-sm" style="background:var(--tt-cream);">
	<div class="container">
		<div class="tt-search-bar" data-aos="fade-up">
			<form action="{{ route('packages') }}" method="GET">
				<div class="row g-3 align-items-end">
					<div class="col-lg-3">
						<div class="tt-form-group">
							<label><i class="fas fa-map-marker-alt"></i> Region</label>
							<select class="tt-select" name="category">
								<option value="">All Regions</option>
								@foreach($regions as $region)
									<option value="{{ $region->id }}">{{ $region->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="tt-form-group">
							<label><i class="fas fa-home"></i> Property Type</label>
							<select class="tt-select" name="type">
								<option value="">Any Type</option>
								<option value="Cottage">Cottage / Gîte</option>
								<option value="Villa">Villa</option>
								<option value="Chalet">Chalet</option>
								<option value="Apartment">Apartment</option>
							</select>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="tt-form-group">
							<label><i class="fas fa-search"></i> Search</label>
							<input type="text" class="tt-input" name="search" placeholder="Property name or location" value="{{ request('search') }}">
						</div>
					</div>
					<div class="col-lg-3">
						<button type="submit" class="btn-tt-primary w-100">
							Search Properties <i class="fas fa-arrow-right"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

<!-- Featured Properties -->
<section class="tt-section">
	<div class="container">
		<div class="tt-section-header text-center" data-aos="fade-up">
			<div class="tt-pretitle">Our Properties</div>
			<h2 class="tt-title">Featured <span class="accent">Holiday Properties</span></h2>
			<p class="tt-subtitle">
				Browse our most popular holiday homes across France, chosen for quality and location.
			</p>
		</div>

		<div class="tt-dest-grid">
			@forelse ($featuredProperties as $destination)
			<article class="tt-dest-card" data-aos="fade-up" data-aos-delay="{{ ($loop->iteration % 3) * 100 }}">
				<div class="tt-dest-card-img">
					<img src="{{ $destination->image_url }}"
						 alt="{{ $destination->title }}" loading="lazy">
					<span class="badge-cat">{{ $destination->property_type_label }}</span>
					<button class="btn-fav" aria-label="Save to wishlist">
						<i class="far fa-heart"></i>
					</button>
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
							View Property <i class="fas fa-arrow-right"></i>
						</a>
					</div>
				</div>
			</article>
			@empty
			<div class="col-12 text-center py-5 text-muted">
				<i class="fas fa-home fa-3x mb-3" style="color:var(--tt-accent);"></i>
				<p>Properties coming soon. <a href="{{ route('packages') }}">Browse all listings</a>.</p>
			</div>
			@endforelse
		</div>

		<div class="text-center mt-5" data-aos="fade-up">
			<a href="{{ route('packages') }}" class="btn-tt-primary">
				View All Properties <i class="fas fa-th-large"></i>
			</a>
		</div>
	</div>
</section>

<!-- Browse by Region -->
<section class="tt-section tt-section-light">
	<div class="container">
		<div class="tt-section-header text-center" data-aos="fade-up">
			<div class="tt-pretitle">Explore France</div>
			<h2 class="tt-title">Browse by <span class="accent">Region</span></h2>
			<p class="tt-subtitle">Find your perfect holiday in one of France's most beautiful and diverse regions.</p>
		</div>
		@php
			$regionMeta = [
				'Provence'      => ['icon' => 'fas fa-sun',          'tag' => 'Lavender &amp; Wine'],
				'Côte d\'Azur'  => ['icon' => 'fas fa-water',        'tag' => 'Riviera Glamour'],
				'Dordogne'      => ['icon' => 'fas fa-tree',          'tag' => 'Castles &amp; Caves'],
				'French Alps'   => ['icon' => 'fas fa-mountain',      'tag' => 'Ski &amp; Summer'],
				'Paris'         => ['icon' => 'fas fa-landmark',      'tag' => 'City of Light'],
				'Loire Valley'  => ['icon' => 'fas fa-wine-glass-alt','tag' => 'Gardens &amp; Châteaux'],
			];
		@endphp
		<div class="tt-cat-grid" data-aos="fade-up">
			@foreach($regions as $region)
			@php $meta = $regionMeta[$region->name] ?? ['icon' => 'fas fa-map-marker-alt', 'tag' => 'France']; @endphp
			<a href="{{ route('regions.show', urlencode($region->name)) }}" class="tt-cat-card text-decoration-none">
				<div class="icon"><i class="{{ $meta['icon'] }}"></i></div>
				<h5>{{ $region->name }}</h5>
				<span class="count">{!! $meta['tag'] !!}</span>
				@if($region->destinations_count)
					<small class="mt-1 d-block" style="color:var(--tt-accent);font-weight:600;">{{ $region->destinations_count }} {{ Str::plural('property', $region->destinations_count) }}</small>
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
			<div class="col-lg-6" data-aos="fade-right">
				<div class="tt-features-img">
					<img src="{{ asset('images/about.jpg') }}" alt="French Holiday Property">
					<div class="overlay-stat">
						<div class="icon"><i class="fas fa-users"></i></div>
						<div>
							<div class="number">5,200+</div>
							<div class="label">Happy Guests</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-6" data-aos="fade-left">
				<div class="tt-section-header">
					<div class="tt-pretitle">Why France Vacances</div>
					<h2 class="tt-title">A Company You Can <span class="accent">Trust</span></h2>
					<p class="tt-subtitle">
						France Vacances has helped UK families and couples book holidays in France for over 15 years.
						We check every property before listing it, and every booking is ABTA protected.
					</p>
				</div>

				<div class="tt-feature-item">
					<div class="tt-feature-icon"><i class="fas fa-check-circle"></i></div>
					<div>
						<h4>All Properties Checked</h4>
						<p>Our team visits and checks every property before it appears on our website. No surprises on arrival.</p>
					</div>
				</div>
				<div class="tt-feature-item">
					<div class="tt-feature-icon"><i class="fas fa-shield-alt"></i></div>
					<div>
						<h4>Safe Bookings</h4>
						<p>All bookings are ABTA protected. Your money is safe when you book with us.</p>
					</div>
				</div>
				<div class="tt-feature-item">
					<div class="tt-feature-icon"><i class="fas fa-headset"></i></div>
					<div>
						<h4>UK Support Team</h4>
						<p>Our team is based in London and available Monday to Friday, 9AM to 5:30PM GMT.</p>
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

<!-- Testimonials -->
<section class="tt-section tt-section-light">
	<div class="container">
		<div class="tt-section-header text-center" data-aos="fade-up">
			<div class="tt-pretitle">Guest Reviews</div>
			<h2 class="tt-title">What Our <span class="accent">Guests Say</span></h2>
		</div>

		<div class="tt-testimonials-grid">
			<div class="tt-testimonial-card" data-aos="fade-up" data-aos-delay="100">
				<div class="tt-testimonial-stars">
					<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
				</div>
				<p class="tt-testimonial-text">
					"The Provence cottage was absolutely stunning — lavender fields, a private pool and total peace.
					France Vacances made the whole booking effortless and their team was incredibly helpful."
				</p>
				<div class="tt-testimonial-author">
					<img src="{{ asset('images/person_1.jpg') }}" alt="Sarah M" class="tt-testimonial-avatar">
					<div>
						<div class="tt-testimonial-name">Sarah Mitchell</div>
						<div class="tt-testimonial-location">Hampshire, UK</div>
					</div>
				</div>
			</div>

			<div class="tt-testimonial-card" data-aos="fade-up" data-aos-delay="200">
				<div class="tt-testimonial-stars">
					<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
				</div>
				<p class="tt-testimonial-text">
					"We booked the Alpine chalet for a ski holiday and it was beyond our expectations.
					The ski storage, hot tub and mountain views were incredible. Will definitely book again."
				</p>
				<div class="tt-testimonial-author">
					<img src="{{ asset('images/person_2.jpg') }}" alt="James K" class="tt-testimonial-avatar">
					<div>
						<div class="tt-testimonial-name">James &amp; Claire Kowalski</div>
						<div class="tt-testimonial-location">Edinburgh, UK</div>
					</div>
				</div>
			</div>

			<div class="tt-testimonial-card" data-aos="fade-up" data-aos-delay="300">
				<div class="tt-testimonial-stars">
					<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
				</div>
				<p class="tt-testimonial-text">
					"The Dordogne cottage was a fairy-tale for our family holiday. Stone walls, a big garden and
					a river view — perfect. France Vacances' local knowledge really showed."
				</p>
				<div class="tt-testimonial-author">
					<img src="{{ asset('images/person_3.jpg') }}" alt="Emma B" class="tt-testimonial-avatar">
					<div>
						<div class="tt-testimonial-name">Emma Birch</div>
						<div class="tt-testimonial-location">Bristol, UK</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Newsletter -->
<section class="tt-newsletter" data-aos="fade-up">
	<div class="container">
		<div class="tt-newsletter-inner text-center">
			<div style="font-size:2rem;margin-bottom:1rem;">✉️</div>
			<h2>Get Holiday Ideas by Email</h2>
			<p>Sign up for property news, travel tips and special offers from France Vacances.</p>
			<form class="tt-newsletter-form justify-content-center" method="POST" action="#">
				@csrf
				<input type="email" placeholder="Enter your email address" required>
				<button type="submit" class="btn-tt-primary">Subscribe <i class="fas fa-paper-plane ms-1"></i></button>
			</form>
			<small class="text-muted mt-2 d-block" style="color:rgba(255,255,255,.4)!important;">No spam. Unsubscribe at any time.</small>
		</div>
	</div>
</section>

<!-- CTA -->
<section class="tt-cta">
	<div class="container" data-aos="zoom-in">
		<div class="icon-lg"><i class="fas fa-key"></i></div>
		<h2>Find Your Next Holiday Home in France</h2>
		<p>
			Browse houses, villas, chalets and apartments across Provence, Côte d'Azur,
			the Dordogne, French Alps, Loire Valley and Paris.
		</p>
		<div class="tt-cta-actions">
			<a href="{{ route('packages') }}" class="btn-tt-white">
				Browse Properties <i class="fas fa-th-large"></i>
			</a>
			<a href="{{ route('contact') }}" class="btn-tt-outline-white">
				Contact Our Team <i class="fas fa-phone"></i>
			</a>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
