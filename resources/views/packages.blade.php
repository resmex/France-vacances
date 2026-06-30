@extends('layouts.front')

@section('title', 'Holiday Properties - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero">
	<div class="tt-page-hero-bg" style="background-image: url('{{ asset('images/place-4.jpg') }}');"></div>
	<div class="container" data-aos="fade-up">
		<h1 class="tt-page-title">Holiday Homes <span class="accent">in France</span></h1>
		<p class="tt-page-subtitle">
			Find cottages, villas, chalets and apartments in France.
		</p>
	</div>
</section>

<!-- Search & Filter -->
<section class="tt-section-sm" style="background:var(--tt-cream);">
	<div class="container">
		<div class="tt-search-bar" data-aos="fade-up">
			<form action="{{ route('packages') }}" method="GET">
				<div class="row g-3 align-items-end">
					<div class="col-lg-4">
						<div class="tt-form-group">
							<label><i class="fas fa-search"></i> Search Properties</label>
							<input type="text" class="tt-input" name="search"
								   placeholder="Property name or location" value="{{ request('search') }}">
						</div>
					</div>
					<div class="col-lg-3">
						<div class="tt-form-group">
							<label><i class="fas fa-map-marker-alt"></i> Region</label>
							<select class="tt-select" name="category">
								<option value="">All Regions</option>
								@foreach($categories as $category)
									<option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
										{{ $category->name }}
									</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="tt-form-group">
							<label><i class="fas fa-home"></i> Property Type</label>
							<select class="tt-select" name="type">
								<option value="">Any Type</option>
								<option value="Cottage" {{ request('type') == 'Cottage' ? 'selected' : '' }}>Cottage / Gîte</option>
								<option value="Villa" {{ request('type') == 'Villa' ? 'selected' : '' }}>Villa</option>
								<option value="Chalet" {{ request('type') == 'Chalet' ? 'selected' : '' }}>Chalet</option>
								<option value="Apartment" {{ request('type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
							</select>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="tt-form-group">
							<label><i class="fas fa-pound-sign"></i> Budget / Night</label>
							<select class="tt-select" name="price_range">
								<option value="">Any Budget</option>
								<option value="0-200" {{ request('price_range') == '0-200' ? 'selected' : '' }}>Under £200</option>
								<option value="200-500" {{ request('price_range') == '200-500' ? 'selected' : '' }}>£200–£500</option>
								<option value="500-1000" {{ request('price_range') == '500-1000' ? 'selected' : '' }}>£500–£1,000</option>
								<option value="1000+" {{ request('price_range') == '1000+' ? 'selected' : '' }}>Over £1,000</option>
							</select>
						</div>
					</div>
					<div class="col-lg-1">
						<button type="submit" class="btn-tt-primary w-100">
							Search <i class="fas fa-arrow-right"></i>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>

<!-- Properties Listing -->
<section class="tt-section">
	<div class="container">
		<div class="tt-section-header text-center" data-aos="fade-up">
			<h2 class="tt-title">
				@if(request('search'))
					Results for "<span class="accent">{{ request('search') }}</span>"
				@else
					All <span class="accent">Holiday Properties</span>
				@endif
			</h2>
			<p class="tt-subtitle">
				@if($destinations->count() > 0)
					Showing {{ $destinations->count() }} properties across France
				@else
					No properties found matching your criteria
				@endif
			</p>
		</div>

		@if($destinations->count() > 0)
		<div class="tt-dest-grid">
			@foreach ($destinations as $destination)
			<article class="tt-dest-card" data-aos="fade-up" data-aos-delay="{{ ($loop->iteration % 3) * 100 }}">
				<div class="tt-dest-card-img">
					<img src="{{ $destination->image_url }}"
						 alt="{{ $destination->title }}" loading="lazy">
					<span class="badge-cat">{{ $destination->category->name ?? 'Cottage' }}</span>
					@auth
					<button class="btn-fav wishlist-toggle"
							data-id="{{ $destination->id }}"
							data-url="{{ route('wishlist.toggle', $destination->id) }}"
							aria-label="Save to wishlist">
						<i class="{{ auth()->user()->hasWishlisted($destination) ? 'fas' : 'far' }} fa-heart"
						   style="{{ auth()->user()->hasWishlisted($destination) ? 'color:#ef4444' : '' }}"></i>
					</button>
					@else
					<a href="{{ route('login') }}" class="btn-fav" title="Sign in to save">
						<i class="far fa-heart"></i>
					</a>
					@endauth
				</div>
				<div class="tt-dest-card-body">
					<div class="tt-dest-card-meta">
						<span><i class="fas fa-map-marker-alt"></i> {{ $destination->location ?? ($destination->category->name ?? 'France') }}</span>
						<span><i class="fas fa-bed"></i> {{ $destination->bedrooms_label }}</span>
					</div>
					<h3 class="tt-dest-card-title">
						<a href="{{ route('desti.show', $destination->id) }}">{{ $destination->title }}</a>
					</h3>
					<p class="tt-dest-card-desc">{{ Str::limit($destination->description, 110) }}</p>
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
			@endforeach
		</div>

		<div class="tt-pagination mt-5 d-flex justify-content-center" data-aos="fade-up">
			{{ $destinations->appends(request()->query())->links('pagination::bootstrap-4') }}
		</div>
		@else
		<div class="tt-empty-state" data-aos="fade-up">
			<div class="icon"><i class="fas fa-search"></i></div>
			<h3>No Properties Found</h3>
			<p>We couldn't find any properties matching your search. Try adjusting your filters or browse all properties.</p>
			<a href="{{ route('packages') }}" class="btn-tt-primary">View All Properties</a>
		</div>
		@endif
	</div>
</section>

<!-- Browse by Property Type -->
<section class="tt-section tt-section-light">
	<div class="container">
		<div class="tt-section-header text-center" data-aos="fade-up">
			<div class="tt-pretitle">Explore by Type</div>
			<h2 class="tt-title">What Kind of <span class="accent">Property?</span></h2>
		</div>
		<div class="tt-cat-grid" data-aos="fade-up">
			<div class="tt-cat-card">
				<div class="icon"><i class="fas fa-home"></i></div>
				<h5>Cottages &amp; Gîtes</h5>
				<span class="count">Traditional &amp; Charming</span>
			</div>
			<div class="tt-cat-card">
				<div class="icon"><i class="fas fa-swimming-pool"></i></div>
				<h5>Villas with Pools</h5>
				<span class="count">Luxury &amp; Space</span>
			</div>
			<div class="tt-cat-card">
				<div class="icon"><i class="fas fa-mountain"></i></div>
				<h5>Alpine Chalets</h5>
				<span class="count">Ski &amp; Summer</span>
			</div>
			<div class="tt-cat-card">
				<div class="icon"><i class="fas fa-city"></i></div>
				<h5>City Apartments</h5>
				<span class="count">Urban Breaks</span>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')

@push('scripts')
<script>
document.querySelectorAll('.wishlist-toggle').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const url  = this.dataset.url;
        const icon = this.querySelector('i');
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.wishlisted) {
                icon.classList.replace('far', 'fas');
                icon.style.color = '#ef4444';
            } else {
                icon.classList.replace('fas', 'far');
                icon.style.color = '';
            }
        })
        .catch(() => {
            window.location = '{{ route("login") }}';
        });
    });
});
</script>
@endpush
@endsection
