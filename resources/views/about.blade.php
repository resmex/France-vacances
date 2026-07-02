@extends('layouts.front')

@section('title', 'About Us - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero" style="background-image:url('{{ asset('images/about.jpg') }}');">
	<div class="container">
		<h1 class="tt-page-title">About <span class="accent">France Vacances</span></h1>
		<p class="tt-page-subtitle">
			France Vacances helps you find and book holiday homes in France.
		</p>
	</div>
</section>

<!-- Our Story -->
<section class="tt-section">
	<div class="container">
		<div class="row align-items-center g-5">
			<div class="col-lg-6">
				<h2 class="tt-title mb-3">Our <span class="accent">Story</span></h2>
				<p>
					France Vacances was started by a small team who wanted to make it easy to
					find and book holiday homes in France.
				</p>
				<p>
					We list cottages, villas, chalets and apartments in Provence,
					the Côte d'Azur, Dordogne, Loire Valley, the French Alps and Paris.
					Our team checks every property before it is listed. You can contact
					our support team if you need help with a booking.
				</p>
			</div>
			<div class="col-lg-6">
				<div class="tt-about-images">
					<img src="{{ asset('images/about.jpg') }}" alt="French Holiday Property" class="img-fluid rounded-3">
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Mission & Vision -->
<section class="tt-section tt-section-light">
	<div class="container">
		<div class="row g-4">
			<div class="col-lg-6">
				<div class="tt-mission-card">
					<div class="icon"><i class="fas fa-bullseye"></i></div>
					<h3>Our Mission</h3>
					<p>
						To make it easy to find and book a holiday home in France.
						We want every booking to be simple and clear.
					</p>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="tt-mission-card">
					<div class="icon"><i class="fas fa-eye"></i></div>
					<h3>Our Vision</h3>
					<p>
						To be a trusted place to book holiday homes in France, known for
						fair prices and good customer care.
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
