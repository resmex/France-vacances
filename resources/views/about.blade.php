@extends('layouts.front')

@section('title', 'About Us - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero">
	<div class="tt-page-hero-bg" style="background-image: url('{{ asset('images/about.jpg') }}');"></div>
	<div class="container" data-aos="fade-up">
		<h1 class="tt-page-title">About <span class="accent">France Vacances</span></h1>
		<p class="tt-page-subtitle">
			France Vacances helps customers find and book holiday homes in France.
		</p>
	</div>
</section>

<!-- Our Story -->
<section class="tt-section">
	<div class="container">
		<div class="row align-items-center g-5">
			<div class="col-lg-6" data-aos="fade-right">
				<div class="tt-pretitle">Our Story</div>
				<h2 class="tt-title mb-3">Born in the UK, <span class="accent">Passionate About France</span></h2>
				<p>
					France Vacances was founded in 2009 by a group of UK-based travel specialists who shared
					a deep love for France and a frustration with impersonal, overpriced holiday rental platforms.
					We set out to build something different — a trusted, personal service that matches UK families
					and couples with genuinely special properties across every French region.
				</p>
				<p>
					Today we list cottages, villas, chalets and apartments in Provence,
					the Côte d'Azur, Dordogne, Loire Valley, the French Alps and Paris.
					Our team visits every property before listing it. Every booking is ABTA protected.
					Customers can contact our UK-based support team at any time.
				</p>
				<div class="tt-stats-row mt-4">
					<div class="tt-stat-item">
						<div class="tt-stat-number">15+</div>
						<div class="tt-stat-label">Years Experience</div>
					</div>
					<div class="tt-stat-item">
						<div class="tt-stat-number">5,200+</div>
						<div class="tt-stat-label">Happy Guests</div>
					</div>
					<div class="tt-stat-item">
						<div class="tt-stat-number">600+</div>
						<div class="tt-stat-label">Properties Listed</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6" data-aos="fade-left">
				<div class="tt-about-images">
					<img src="{{ asset('images/about.jpg') }}" alt="French Holiday Property" class="img-fluid rounded-3 shadow">
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Mission & Vision -->
<section class="tt-section tt-section-light">
	<div class="container">
		<div class="row g-4">
			<div class="col-lg-6" data-aos="fade-up">
				<div class="tt-mission-card">
					<div class="icon"><i class="fas fa-bullseye"></i></div>
					<h3>Our Mission</h3>
					<p>
						To make it easy for UK travellers to find and book a great holiday home in France.
						We want every booking to be simple, clear and stress-free.
					</p>
				</div>
			</div>
			<div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
				<div class="tt-mission-card">
					<div class="icon"><i class="fas fa-eye"></i></div>
					<h3>Our Vision</h3>
					<p>
						To be the UK's most trusted company for booking holiday homes in France.
						We want to be known for honest pricing, good customer care and deep knowledge of France.
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Why Choose Us -->
<section class="tt-section">
	<div class="container">
		<div class="tt-section-header text-center" data-aos="fade-up">
			<div class="tt-pretitle">What Makes Us Different</div>
			<h2 class="tt-title">Why Choose <span class="accent">France Vacances</span></h2>
			<p class="tt-subtitle">We're not just a booking platform — we're a team of France enthusiasts who care deeply about your holiday.</p>
		</div>
		<div class="row g-4">
			<div class="col-md-6 col-lg-4" data-aos="fade-up">
				<div class="tt-feature-card">
					<div class="icon"><i class="fas fa-check-double"></i></div>
					<h4>Every Property Checked</h4>
					<p>Our team visits each property before listing it on our site. No surprises when you arrive.</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
				<div class="tt-feature-card">
					<div class="icon"><i class="fas fa-shield-alt"></i></div>
					<h4>ABTA Protected</h4>
					<p>Every booking is fully ABTA protected. Your money is safe and you have full financial protection on every reservation.</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
				<div class="tt-feature-card">
					<div class="icon"><i class="fas fa-headset"></i></div>
					<h4>UK-Based Team</h4>
					<p>Our friendly, knowledgeable team is based in London and available Monday to Friday 9AM–5:30PM GMT.</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
				<div class="tt-feature-card">
					<div class="icon"><i class="fas fa-coins"></i></div>
					<h4>Transparent Pricing</h4>
					<p>No hidden fees, no surprises. Our prices include everything — what you see is exactly what you pay.</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
				<div class="tt-feature-card">
					<div class="icon"><i class="fas fa-map-marked-alt"></i></div>
					<h4>Knowledge of France</h4>
					<p>We know France well. Our team can help you find the right region and the right property for your holiday.</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
				<div class="tt-feature-card">
					<div class="icon"><i class="fas fa-undo-alt"></i></div>
					<h4>Flexible Cancellation</h4>
					<p>Life happens. Our flexible cancellation policies give you peace of mind when booking your French holiday.</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Values -->
<section class="tt-section tt-section-light">
	<div class="container">
		<div class="tt-section-header text-center" data-aos="fade-up">
			<div class="tt-pretitle">What We Stand For</div>
			<h2 class="tt-title">Our Core <span class="accent">Values</span></h2>
		</div>
		<div class="row g-4 justify-content-center">
			<div class="col-md-4" data-aos="zoom-in">
				<div class="tt-value-card text-center">
					<div class="icon"><i class="fas fa-heart"></i></div>
					<h4>Passion for France</h4>
					<p>We love France and enjoy helping customers find great places to stay there.</p>
				</div>
			</div>
			<div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
				<div class="tt-value-card text-center">
					<div class="icon"><i class="fas fa-handshake"></i></div>
					<h4>Honest Service</h4>
					<p>We believe in straightforward, transparent advice — no upselling, no hidden charges, just honest help.</p>
				</div>
			</div>
			<div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
				<div class="tt-value-card text-center">
					<div class="icon"><i class="fas fa-users"></i></div>
					<h4>Guest First</h4>
					<p>Your holiday experience is everything. We go above and beyond to make sure every stay is exceptional.</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Stats Banner -->
<section class="tt-stats-banner" data-aos="fade-up">
	<div class="container">
		<h2 class="text-center text-white mb-2">Your French Holiday in <span class="accent">Safe Hands</span></h2>
		<p class="text-center text-white-50 mb-5">Used by thousands of UK families and couples every year.</p>
		<div class="row g-4 text-center">
			<div class="col-6 col-md-3">
				<div class="tt-stat-banner-item">
					<i class="fas fa-home fa-2x mb-2"></i>
					<div class="number">600+</div>
					<div class="label">Properties</div>
				</div>
			</div>
			<div class="col-6 col-md-3">
				<div class="tt-stat-banner-item">
					<i class="fas fa-smile fa-2x mb-2"></i>
					<div class="number">5,200+</div>
					<div class="label">Happy Guests</div>
				</div>
			</div>
			<div class="col-6 col-md-3">
				<div class="tt-stat-banner-item">
					<i class="fas fa-map-marked-alt fa-2x mb-2"></i>
					<div class="number">6</div>
					<div class="label">French Regions</div>
				</div>
			</div>
			<div class="col-6 col-md-3">
				<div class="tt-stat-banner-item">
					<i class="fas fa-award fa-2x mb-2"></i>
					<div class="number">4.9/5</div>
					<div class="label">Average Rating</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- CTA -->
<section class="tt-cta" data-aos="zoom-in">
	<div class="container text-center">
		<i class="fas fa-key fa-3x mb-3" style="color: var(--tt-accent);"></i>
		<h2>Ready to Find Your French Holiday Home?</h2>
		<p>Browse our full list of holiday homes in France — cottages, villas, chalets and apartments.</p>
		<div class="d-flex gap-3 justify-content-center flex-wrap">
			<a href="{{ route('packages') }}" class="btn-tt-white"><i class="fas fa-th-large me-2"></i> Browse Properties</a>
			<a href="{{ route('contact') }}" class="btn-tt-outline-white"><i class="fas fa-phone me-2"></i> Speak to Us</a>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
