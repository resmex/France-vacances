@extends('layouts.front')

@section('title', 'Blog - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero">
	<div class="tt-page-hero-bg" style="background-image: url('{{ asset('images/place-3.jpg') }}');"></div>
	<div class="container" data-aos="fade-up">
		<h1 class="tt-page-title">France <span class="accent">Travel Blog</span></h1>
		<p class="tt-page-subtitle">
			Guides, tips and ideas to help you plan a holiday in France.
		</p>
	</div>
</section>

<!-- Blog Listing -->
<section class="tt-section">
	<div class="container">
		<div class="tt-section-header text-center" data-aos="fade-up">
			<div class="tt-pretitle">Latest from Our Blog</div>
			<h2 class="tt-title">Stories &amp; <span class="accent">Travel Guides</span></h2>
			<p class="tt-subtitle">Travel guides and helpful tips from the France Vacances team.</p>
		</div>

		<div class="tt-blog-grid">
			@foreach ($blogs as $blog)
			<article class="tt-blog-card" data-aos="fade-up" data-aos-delay="{{ ($loop->iteration % 3) * 100 }}">
				<div class="tt-blog-card-img">
					<img src="{{ asset('images/place-' . (($loop->iteration % 4) + 1) . '.jpg') }}" alt="{{ $blog->title }}" loading="lazy">
					<span class="badge-cat">{{ $blog->category->name ?? 'France' }}</span>
					<span class="badge-read"><i class="fas fa-clock me-1"></i>5 min</span>
				</div>
				<div class="tt-blog-card-body">
					<div class="tt-blog-card-meta">
						<span><i class="fas fa-calendar-alt"></i> {{ $blog->created_at ? $blog->created_at->format('M d, Y') : 'Recent' }}</span>
						<span><i class="fas fa-user"></i> France Vacances Team</span>
					</div>
					<h3 class="tt-blog-card-title">
						<a href="#">{{ $blog->title }}</a>
					</h3>
					<p class="tt-blog-card-desc">
						{{ Str::limit($blog->description ?? 'Discover wonderful holiday properties and travel tips to inspire your perfect French getaway.', 150) }}
					</p>
					<a href="#" class="tt-blog-card-link">Read More <i class="fas fa-arrow-right"></i></a>
				</div>
			</article>
			@endforeach
		</div>

		<div class="tt-pagination mt-5 d-flex justify-content-center" data-aos="fade-up">
			{{ $blogs->links('pagination::bootstrap-4') }}
		</div>
	</div>
</section>

<!-- Newsletter -->
<section class="tt-newsletter" data-aos="zoom-in">
	<div class="container">
		<div class="tt-newsletter-inner text-center">
			<div style="font-size:2rem;margin-bottom:1rem;">🗞️</div>
			<h2>Get France Holiday Ideas by Email</h2>
			<p>Sign up for monthly guides, property news and travel tips from France Vacances.</p>
			<form class="tt-newsletter-form justify-content-center" method="POST" action="#">
				@csrf
				<input type="email" placeholder="Enter your email address" required>
				<button type="submit" class="btn-tt-primary">Subscribe <i class="fas fa-paper-plane ms-1"></i></button>
			</form>
			<small class="text-muted mt-2 d-block" style="color:rgba(255,255,255,.4)!important;">No spam. Unsubscribe at any time.</small>
		</div>
	</div>
</section>

<!-- Blog Categories -->
<section class="tt-section tt-section-light">
	<div class="container">
		<div class="tt-section-header text-center" data-aos="fade-up">
			<div class="tt-pretitle">Browse by Topic</div>
			<h2 class="tt-title">Popular <span class="accent">Guides</span></h2>
		</div>
		<div class="tt-cat-grid" data-aos="fade-up">
			<div class="tt-cat-card">
				<div class="icon"><i class="fas fa-map-marked-alt"></i></div>
				<h5>Regional Guides</h5>
				<span class="count">Discover France</span>
			</div>
			<div class="tt-cat-card">
				<div class="icon"><i class="fas fa-home"></i></div>
				<h5>Property Tips</h5>
				<span class="count">Choose the Right Stay</span>
			</div>
			<div class="tt-cat-card">
				<div class="icon"><i class="fas fa-utensils"></i></div>
				<h5>Food &amp; Wine</h5>
				<span class="count">French Cuisine</span>
			</div>
			<div class="tt-cat-card">
				<div class="icon"><i class="fas fa-child"></i></div>
				<h5>Family Holidays</h5>
				<span class="count">Kids Love France</span>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
