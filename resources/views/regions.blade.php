@extends('layouts.front')

@section('title', $region->name . ' Holiday Properties - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero">
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
	<div class="tt-page-hero-bg" style="background-image: url('{{ asset('images/' . $heroBg) }}');"></div>
	<div class="container" data-aos="fade-up">
		<h1 class="tt-page-title">Holiday Properties in <span class="accent">{{ $region->name }}</span></h1>
		<p class="tt-page-subtitle">
			@php
				$regionDesc = [
					'Provence'     => 'Lavender fields, hilltop villages, and sun-drenched countryside — Provence at its finest.',
					"Côte d'Azur"  => 'Glamorous Riviera coastline, turquoise seas, and world-class dining.',
					'Dordogne'     => 'Medieval castles, prehistoric caves, and the most beautiful river valley in France.',
					'French Alps'  => 'Ski-in/ski-out chalets, alpine meadows, and the world\'s greatest ski area.',
					'Paris'        => 'The City of Light — iconic apartments steps from the Eiffel Tower and beyond.',
					'Loire Valley' => 'Châteaux, vineyards, and gentle cycling through the Garden of France.',
				][$region->name] ?? 'Discover beautiful holiday properties in ' . $region->name . ', France.';
			@endphp
			{{ $regionDesc }}
		</p>
	</div>
</section>

<!-- Region Navigation -->
<section class="tt-section-sm" style="background:var(--tt-cream);">
	<div class="container">
		<div class="d-flex flex-wrap gap-2 justify-content-center" data-aos="fade-up">
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
		<div class="tt-section-header text-center" data-aos="fade-up">
			<h2 class="tt-title">{{ $properties->total() }} {{ Str::plural('Property', $properties->total()) }} in <span class="accent">{{ $region->name }}</span></h2>
			<p class="tt-subtitle">Sorted by guest rating — highest rated first.</p>
		</div>

		@if($properties->count() > 0)
		<div class="tt-dest-grid">
			@foreach($properties as $property)
			<article class="tt-dest-card" data-aos="fade-up" data-aos-delay="{{ ($loop->iteration % 3) * 100 }}">
				<div class="tt-dest-card-img">
					<img src="{{ $property->image_url }}" alt="{{ $property->title }}" loading="lazy">
					<span class="badge-cat">{{ $property->property_type_label }}</span>
					@if($property->featured)
					<span style="position:absolute;top:.6rem;left:.6rem;background:var(--tt-accent);color:var(--tt-dark);font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:50px;">
						⭐ Top Pick
					</span>
					@endif
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
							View Property <i class="fas fa-arrow-right"></i>
						</a>
					</div>
				</div>
			</article>
			@endforeach
		</div>

		<div class="tt-pagination mt-5 d-flex justify-content-center" data-aos="fade-up">
			{{ $properties->links('pagination::bootstrap-4') }}
		</div>
		@else
		<div class="tt-empty-state" data-aos="fade-up">
			<div class="icon"><i class="fas fa-home"></i></div>
			<h3>No Properties Listed Yet</h3>
			<p>We're working on adding properties in {{ $region->name }}. Browse our other regions in the meantime.</p>
			<a href="{{ route('packages') }}" class="btn-tt-primary">View All Properties</a>
		</div>
		@endif
	</div>
</section>

<!-- Other Regions -->
<section class="tt-section tt-section-light">
	<div class="container">
		<div class="tt-section-header text-center" data-aos="fade-up">
			<div class="tt-pretitle">Explore More</div>
			<h2 class="tt-title">Other <span class="accent">Regions</span></h2>
		</div>
		@php
			$regionMeta = [
				'Provence'      => ['icon' => 'fas fa-sun',           'tag' => 'Lavender &amp; Wine'],
				"Côte d'Azur"   => ['icon' => 'fas fa-water',         'tag' => 'Riviera Glamour'],
				'Dordogne'      => ['icon' => 'fas fa-tree',           'tag' => 'Castles &amp; Caves'],
				'French Alps'   => ['icon' => 'fas fa-mountain',       'tag' => 'Ski &amp; Summer'],
				'Paris'         => ['icon' => 'fas fa-landmark',       'tag' => 'City of Light'],
				'Loire Valley'  => ['icon' => 'fas fa-wine-glass-alt', 'tag' => 'Gardens &amp; Châteaux'],
			];
		@endphp
		<div class="tt-cat-grid" data-aos="fade-up">
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
