@extends('layouts.front')

@section('title', 'Blog - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero" style="background-image:url('{{ asset('images/place-1.jpg') }}');">
	<div class="container">
		<h1 class="tt-page-title">France <span class="accent">Travel Blog</span></h1>
		<p class="tt-page-subtitle">
			Guides, tips and ideas to help you plan a holiday in France.
		</p>
	</div>
</section>

<!-- Blog Listing -->
<section class="tt-section">
	<div class="container">
		<div class="tt-section-header text-center">
			<h2 class="tt-title">Stories &amp; <span class="accent">Travel Guides</span></h2>
			<p class="tt-subtitle">Travel guides and tips from the France Vacances team.</p>
		</div>

		<div class="tt-blog-grid">
			@foreach ($blogs as $blog)
			<article class="tt-blog-card">
				@php
					$blogThumbs = ['place-1.jpg', 'place-2.jpg', 'place-3.jpg', 'place-4.jpg', 'image_5.jpg', 'image_6.jpg'];
					$thumb = $blogThumbs[($loop->iteration - 1) % count($blogThumbs)];
				@endphp
				<div class="tt-blog-card-img">
					<img src="{{ asset('images/' . $thumb) }}" alt="{{ $blog->title }}" loading="lazy">
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
						{{ Str::limit($blog->description ?? 'Tips and ideas for a holiday in France.', 150) }}
					</p>
					<a href="#" class="tt-blog-card-link">Read More <i class="fas fa-arrow-right"></i></a>
				</div>
			</article>
			@endforeach
		</div>

		<div class="tt-pagination mt-5 d-flex justify-content-center">
			{{ $blogs->links('pagination::bootstrap-4') }}
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
