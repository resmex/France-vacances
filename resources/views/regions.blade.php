@extends('layouts.front')

@section('title', $region->name . ' Holiday Properties - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero" style="background-image:url('{{ asset('images/place-3.jpg') }}');">
	@php
		$heroBg = [
			'Provence'     => 'place-1.jpg',
			"Côte d'Azur"  => 'place-2.jpg',
			'Dordogne'     => 'place-3.jpg',
			'French Alps'  => 'place-4.jpg',
			'Paris'        => 'place-5.jpg',
			'Loire Valley' => 'place-6.jpg',
		][$region->name] ?? 'place-1.jpg';
	@endphp
	<div class="container">
		<h1 class="tt-page-title">Holiday Properties in <span class="accent">{{ $region->name }}</span></h1>
		<p class="tt-page-subtitle">
			@php
				$regionDesc = [
					'Provence'     => 'Lavender fields, hilltop villages and countryside.',
					"Côte d'Azur"  => 'Coastline, beaches and good local food.',
					'Dordogne'     => 'Old castles, caves and a river valley.',
					'French Alps'  => 'Ski chalets and mountain views.',
					'Paris'        => 'Apartments near the main sights of the city.',
					'Loire Valley' => 'Châteaux, vineyards and cycling routes.',
				][$region->name] ?? 'Holiday homes in ' . $region->name . ', France.';
			@endphp
			{{ $regionDesc }}
		</p>
	</div>
</section>

<!-- Region Navigation -->
<section class="tt-section-sm" style="background:var(--tt-cream);">
	<div class="container">
		<div class="d-flex flex-wrap gap-2 justify-content-center">
			@foreach($allRegions as $r)
			<a href="{{ route('regions.show', urlencode($r->name)) }}"
			   class="{{ $r->id === $region->id ? 'btn-tt-primary' : 'btn-tt-outline' }} px-3 py-2"
			   style="border-radius:50px;font-size:.85rem;">
				{{ $r->name }}
				@if($r->destinations_count)
					<span class="ms-1 opacity-75">({{ $r->destinations_count }})</span>
				@endif
			</a>
			@endforeach
		</div>
	</div>
</section>

<!-- Properties in This Region -->
<section class="tt-section">
	<div class="container">
		<div class="tt-section-header text-center">
			<h2 class="tt-title">{{ $properties->total() }} {{ Str::plural('Property', $properties->total()) }} in <span class="accent">{{ $region->name }}</span></h2>
			<p class="tt-subtitle">Sorted by guest rating, highest first.</p>
		</div>

		@if($properties->count() > 0)
		<div class="tt-dest-grid">
			@foreach($properties as $property)
			<article class="tt-dest-card">
				<div class="tt-dest-card-img">
					<img src="{{ $property->image_url }}" alt="{{ $property->title }}" loading="lazy">
					<span class="badge-cat">{{ $property->property_type_label }}</span>
				</div>
				<div class="tt-dest-card-body">
					<div class="tt-dest-card-meta">
						<span><i class="fas fa-map-marker-alt"></i> {{ $property->location ?? $region->name }}</span>
						<span><i class="fas fa-bed"></i> {{ $property->bedrooms_label }}</span>
					</div>
					<h3 class="tt-dest-card-title">
						<a href="{{ route('desti.show', $property->id) }}">{{ $property->title }}</a>
					</h3>
					<p class="tt-dest-card-desc">{{ Str::limit($property->description, 110) }}</p>
					<div class="d-flex align-items-center gap-2 mb-2" style="font-size:.83rem;color:var(--tt-dark-soft);">
						<i class="fas fa-star" style="color:var(--tt-accent);font-size:.75rem;"></i>
						<span>{{ $property->display_rating ? number_format($property->display_rating, 2) : 'New' }}</span>
						<span style="color:#ccc;">·</span>
						<i class="fas fa-users" style="font-size:.75rem;"></i>
						<span>{{ $property->max_guests_label }}</span>
					</div>
					<div class="tt-dest-card-footer">
						<div>
							<div class="tt-dest-price-label">From</div>
							<div class="tt-dest-price-value">{{ $property->price_display }}</div>
						</div>
						<a href="{{ route('desti.show', $property->id) }}" class="tt-dest-card-link">
							View Details <i class="fas fa-arrow-right"></i>
						</a>
					</div>
				</div>
			</article>
			@endforeach
		</div>

		<div class="tt-pagination mt-5 d-flex justify-content-center">
			{{ $properties->links('pagination::bootstrap-4') }}
		</div>
		@else
		<div class="tt-empty-state">
			<div class="icon"><i class="fas fa-home"></i></div>
			<h3>No Properties Listed Yet</h3>
			<p>We are still adding properties in {{ $region->name }}. Try our other regions.</p>
			<a href="{{ route('packages') }}" class="btn-tt-primary">View All Properties</a>
		</div>
		@endif
	</div>
</section>

<!-- Other Regions -->
<section class="tt-section tt-section-light">
	<div class="container">
		<div class="tt-section-header text-center">
			<h2 class="tt-title">Other <span class="accent">Regions</span></h2>
		</div>
		@php
			$regionMeta = [
				'Provence'      => ['icon' => 'fas fa-sun',           'tag' => 'Lavender and vineyards'],
				"Côte d'Azur"   => ['icon' => 'fas fa-water',         'tag' => 'Coast and beaches'],
				'Dordogne'      => ['icon' => 'fas fa-tree',           'tag' => 'Castles and caves'],
				'French Alps'   => ['icon' => 'fas fa-mountain',       'tag' => 'Mountains'],
				'Paris'         => ['icon' => 'fas fa-landmark',       'tag' => 'City'],
				'Loire Valley'  => ['icon' => 'fas fa-wine-glass-alt', 'tag' => 'Gardens and châteaux'],
			];
		@endphp
		<div class="tt-cat-grid">
			@foreach($allRegions->where('id', '!=', $region->id)->take(5) as $r)
			@php $meta = $regionMeta[$r->name] ?? ['icon' => 'fas fa-map-marker-alt', 'tag' => 'France']; @endphp
			<a href="{{ route('regions.show', urlencode($r->name)) }}" class="tt-cat-card text-decoration-none">
				<div class="icon"><i class="{{ $meta['icon'] }}"></i></div>
				<h5>{{ $r->name }}</h5>
				<span class="count">{!! $meta['tag'] !!}</span>
				@if($r->destinations_count)
					<small class="mt-1 d-block" style="color:var(--tt-accent);font-weight:600;">{{ $r->destinations_count }} {{ Str::plural('property', $r->destinations_count) }}</small>
				@endif
			</a>
			@endforeach
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
