@extends('layouts.front')

@section('title', 'Saved Properties — France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero tt-page-hero-sm" style="background-image:url('{{ asset('images/destination-2.jpg') }}');">
	<div class="container">
		<h1 class="tt-page-title">Saved Properties</h1>
		<p class="tt-page-subtitle">{{ $wishlisted->total() }} {{ Str::plural('property', $wishlisted->total()) }} saved</p>
	</div>
</section>

<section class="tt-section">
	<div class="container">
		@if(session('success'))
		<div class="alert alert-success border-0 rounded-3 mb-4">
			<i class="fas fa-check-circle me-2"></i>{{ session('success') }}
		</div>
		@endif

		@if($wishlisted->isEmpty())
		<div class="text-center py-5">
			<div style="width:80px;height:80px;border-radius:50%;background:var(--tt-cream);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
				<i class="fas fa-heart fa-2x" style="color:#ef444440;"></i>
			</div>
			<h3 class="fw-bold mb-3">Your wishlist is empty</h3>
			<p class="text-muted mb-4">Browse our holiday properties and click the heart icon to save one here.</p>
			<a href="{{ route('packages') }}" class="btn-tt-primary">View Properties</a>
		</div>
		@else
		<div class="row g-4" id="wishlist-grid">
			@foreach($wishlisted as $destination)
			<div class="col-md-6 col-lg-4" id="card-{{ $destination->id }}">
				<div class="tt-property-card">
					<!-- Image -->
					<div class="tt-property-image">
						<img src="{{ $destination->image_url }}" alt="{{ $destination->title }}" loading="lazy">
						<div class="tt-property-badge">{{ $destination->property_type_label }}</div>
					</div>
					<!-- Card Body -->
					<div class="tt-property-body">
						<div class="tt-property-meta">
							<span><i class="fas fa-map-marker-alt"></i> {{ $destination->location ?? $destination->region_label }}</span>
							@if($destination->display_rating)
							<span class="tt-rating"><i class="fas fa-star"></i> {{ number_format($destination->display_rating, 2) }}</span>
							@endif
						</div>
						<h3 class="tt-property-title">
							<a href="{{ route('desti.show', $destination->id) }}">{{ $destination->title }}</a>
						</h3>
						<p class="tt-property-excerpt">{{ Str::limit($destination->description, 90) }}</p>
						<div class="tt-property-features">
							<span><i class="fas fa-bed"></i> {{ $destination->bedrooms_label }}</span>
							<span><i class="fas fa-users"></i> {{ $destination->max_guests_label }}</span>
							@if($destination->bathrooms)
							<span><i class="fas fa-bath"></i> {{ $destination->bathrooms }} bath</span>
							@endif
						</div>
						<div class="tt-property-footer">
							<div class="tt-property-price">{{ $destination->price_display }}</div>
							<a href="{{ route('desti.show', $destination->id) }}" class="btn-tt-primary py-2 px-4" style="font-size:.85rem;">
								View Details
							</a>
						</div>
						@include('partials.wishlist-save-button', ['destination' => $destination])
					</div>
				</div>
			</div>
			@endforeach
		</div>

		<!-- Pagination -->
		@if($wishlisted->hasPages())
		<div class="d-flex justify-content-center mt-5">
			{{ $wishlisted->links() }}
		</div>
		@endif

		<div class="text-center mt-4">
			<a href="{{ route('packages') }}" class="btn-tt-outline">
				<i class="fas fa-search me-2"></i>View More Properties
			</a>
		</div>
		@endif
	</div>
</section>

@include('partials.footer')
@endsection
