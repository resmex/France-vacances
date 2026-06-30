@extends('layouts.front')

@section('title', 'My Account — France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero tt-page-hero-sm">
	<div class="tt-page-hero-bg" style="background-image: url('{{ asset('images/place-1.jpg') }}');"></div>
	<div class="container" data-aos="fade-up">
		<h1 class="tt-page-title">Welcome back, <span class="accent">{{ $user->name }}</span></h1>
		<p class="tt-page-subtitle">Manage your bookings, saved properties, and account settings.</p>
	</div>
</section>

<section class="tt-section">
	<div class="container">
		@if(session('success'))
		<div class="alert alert-success border-0 mb-4 rounded-3">
			<i class="fas fa-check-circle me-2"></i>{{ session('success') }}
		</div>
		@endif

		<!-- Stats Row -->
		<div class="row g-3 mb-5" data-aos="fade-up">
			@php
				$kpis = [
					['icon'=>'fas fa-calendar-alt',  'color'=>'#082B4C', 'value'=>$stats['bookings'],  'label'=>'Total Bookings'],
					['icon'=>'fas fa-check-circle',  'color'=>'#22c55e', 'value'=>$stats['confirmed'], 'label'=>'Confirmed Stays'],
					['icon'=>'fas fa-heart',         'color'=>'#ef4444', 'value'=>$stats['wishlist'],  'label'=>'Saved Properties'],
					['icon'=>'fas fa-star',          'color'=>'#D4AF37', 'value'=>$stats['reviews'],   'label'=>'Reviews Written'],
				];
			@endphp
			@foreach($kpis as $k)
			<div class="col-6 col-md-3">
				<div class="tt-sidebar-card text-center py-4">
					<div style="width:48px;height:48px;border-radius:12px;background:{{ $k['color'] }}18;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
						<i class="{{ $k['icon'] }}" style="font-size:1.2rem;color:{{ $k['color'] }};"></i>
					</div>
					<div class="fw-bold" style="font-size:1.6rem;color:var(--tt-primary);">{{ $k['value'] }}</div>
					<div style="font-size:.8rem;color:var(--tt-dark-soft);">{{ $k['label'] }}</div>
				</div>
			</div>
			@endforeach
		</div>

		<div class="row g-4">
			<!-- Left column -->
			<div class="col-lg-8">

				{{-- Next Stay Banner --}}
				@if($nextBooking)
				<div class="tt-sidebar-card mb-4" data-aos="fade-up"
					 style="border-left:4px solid var(--tt-accent);background:linear-gradient(135deg,var(--tt-cream),#fff);">
					<div class="d-flex align-items-center gap-3">
						<div style="min-width:50px;height:50px;border-radius:12px;background:var(--tt-accent);display:flex;align-items:center;justify-content:center;">
							<i class="fas fa-plane-departure" style="color:var(--tt-dark);font-size:1.2rem;"></i>
						</div>
						<div class="flex-grow-1">
							<div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;color:var(--tt-dark-soft);font-weight:600;">Your Next Stay</div>
							<h5 class="mb-0 fw-bold">{{ $nextBooking->destination->title }}</h5>
							<small class="text-muted">
								{{ $nextBooking->check_in_date?->format('D d M Y') }}
								@if($nextBooking->check_out_date)→ {{ $nextBooking->check_out_date->format('D d M Y') }}@endif
								&middot; {{ $nextBooking->nights_label }}
							</small>
						</div>
						<a href="{{ route('booking.confirmation', $nextBooking->id) }}"
						   class="btn-tt-primary py-2 px-3" style="font-size:.82rem;white-space:nowrap;">
							View Details
						</a>
					</div>
				</div>
				@endif

				{{-- Recent Bookings --}}
				<div class="tt-sidebar-card mb-4" data-aos="fade-up">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<h5 class="mb-0 fw-bold">
							<i class="fas fa-calendar-alt me-2" style="color:var(--tt-accent);"></i>Recent Bookings
						</h5>
						<a href="{{ route('bookings.my') }}" class="btn-tt-outline py-1 px-3" style="font-size:.8rem;">View All</a>
					</div>

					@forelse($recentBookings as $booking)
					<div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
						@php
							$img = $booking->destination->image_url ?? asset('images/destination-1.jpg');
						@endphp
						<img src="{{ $img }}" style="width:56px;height:56px;object-fit:cover;border-radius:10px;flex-shrink:0;"
							 alt="{{ $booking->destination->title ?? '' }}" loading="lazy">
						<div class="flex-grow-1 min-w-0">
							<div class="fw-semibold text-truncate">{{ $booking->destination->title ?? 'Property' }}</div>
							<small class="text-muted">
								{{ optional($booking->check_in_date ?? ($booking->travel_date ?? null))->format('d M Y') ?? '—' }}
								&middot; {{ $booking->nights_label }}
								&middot; {{ $booking->guests }} {{ Str::plural('guest', $booking->guests) }}
							</small>
						</div>
						<div class="text-end flex-shrink-0">
							<span class="badge bg-{{ $booking->status_badge }} d-block mb-1">{{ ucfirst($booking->status) }}</span>
							<small class="fw-bold" style="color:var(--tt-primary);">{{ $booking->total_display }}</small>
						</div>
					</div>
					@empty
					<div class="text-center py-4 text-muted">
						<i class="fas fa-calendar-alt fa-2x mb-2 opacity-25 d-block"></i>
						<p class="mb-3">No bookings yet.</p>
						<a href="{{ route('packages') }}" class="btn-tt-primary">Browse Properties</a>
					</div>
					@endforelse
				</div>

				{{-- Saved Properties --}}
				<div class="tt-sidebar-card" data-aos="fade-up">
					<div class="d-flex justify-content-between align-items-center mb-3">
						<h5 class="mb-0 fw-bold">
							<i class="fas fa-heart me-2" style="color:#ef4444;"></i>Saved Properties
						</h5>
						<a href="{{ route('wishlist.index') }}" class="btn-tt-outline py-1 px-3" style="font-size:.8rem;">View All</a>
					</div>

					@forelse($savedProperties as $prop)
					<div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
						<img src="{{ $prop->image_url }}"
							 style="width:56px;height:56px;object-fit:cover;border-radius:10px;flex-shrink:0;"
							 alt="{{ $prop->title }}" loading="lazy">
						<div class="flex-grow-1 min-w-0">
							<div class="fw-semibold text-truncate">{{ $prop->title }}</div>
							<small class="text-muted">
								<i class="fas fa-map-marker-alt me-1" style="color:var(--tt-accent);font-size:.7rem;"></i>
								{{ $prop->location ?? $prop->region_label }}
								&nbsp;&middot;&nbsp;
								<i class="fas fa-star me-1" style="color:var(--tt-accent);font-size:.7rem;"></i>
								{{ $prop->display_rating ? number_format($prop->display_rating, 2) : 'New' }}
							</small>
						</div>
						<div class="text-end flex-shrink-0">
							<div class="fw-bold" style="color:var(--tt-primary);">{{ $prop->price_display }}</div>
							<a href="{{ route('desti.show', $prop->id) }}"
							   style="font-size:.75rem;color:var(--tt-accent);">View &rarr;</a>
						</div>
					</div>
					@empty
					<div class="text-center py-4 text-muted">
						<i class="fas fa-heart fa-2x mb-2 opacity-25 d-block"></i>
						<p class="mb-3">No saved properties yet. Click ♡ on any property to save it.</p>
						<a href="{{ route('packages') }}" class="btn-tt-outline">Browse Properties</a>
					</div>
					@endforelse
				</div>
			</div>

			<!-- Right column -->
			<div class="col-lg-4">
				{{-- Account Info --}}
				<div class="tt-sidebar-card mb-4" data-aos="fade-left">
					<div class="text-center mb-4">
						<div style="width:72px;height:72px;border-radius:50%;background:var(--tt-primary);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
							<i class="fas fa-user" style="font-size:1.8rem;color:#fff;"></i>
						</div>
						<h5 class="mb-0 fw-bold">{{ $user->name }}</h5>
						<small class="text-muted">{{ $user->email }}</small>
						<div class="mt-2">
							<span class="badge" style="background:var(--tt-accent);color:var(--tt-dark);border-radius:50px;font-size:.72rem;">
								{{ ucfirst($user->role) }}
							</span>
						</div>
					</div>
					<a href="{{ route('account.profile') }}" class="btn-tt-outline w-100 text-center d-block">
						<i class="fas fa-user-edit me-2"></i>Edit Profile
					</a>
				</div>

				{{-- Quick Actions --}}
				<div class="tt-sidebar-card" data-aos="fade-left">
					<h5 class="mb-3 fw-bold">Quick Actions</h5>
					<div class="d-grid gap-2">
						<a href="{{ route('packages') }}"
						   style="display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:10px;background:var(--tt-cream);color:var(--tt-dark);text-decoration:none;font-size:.9rem;transition:.2s;">
							<i class="fas fa-search" style="color:var(--tt-primary);width:16px;"></i>Browse Properties
						</a>
						<a href="{{ route('bookings.my') }}"
						   style="display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:10px;background:var(--tt-cream);color:var(--tt-dark);text-decoration:none;font-size:.9rem;transition:.2s;">
							<i class="fas fa-calendar-alt" style="color:var(--tt-primary);width:16px;"></i>My Bookings
						</a>
						<a href="{{ route('wishlist.index') }}"
						   style="display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:10px;background:var(--tt-cream);color:var(--tt-dark);text-decoration:none;font-size:.9rem;transition:.2s;">
							<i class="fas fa-heart" style="color:#ef4444;width:16px;"></i>Saved Properties
						</a>
						<a href="{{ route('account.profile') }}"
						   style="display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:10px;background:var(--tt-cream);color:var(--tt-dark);text-decoration:none;font-size:.9rem;transition:.2s;">
							<i class="fas fa-user-cog" style="color:var(--tt-primary);width:16px;"></i>Account Settings
						</a>
						<a href="{{ route('contact') }}"
						   style="display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:10px;background:var(--tt-cream);color:var(--tt-dark);text-decoration:none;font-size:.9rem;transition:.2s;">
							<i class="fas fa-headset" style="color:var(--tt-primary);width:16px;"></i>Contact Support
						</a>
						@if(Auth::user()->isAdmin())
						<hr class="my-1">
						<a href="{{ route('home') }}"
						   style="display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:10px;background:#082B4C10;color:var(--tt-primary);text-decoration:none;font-size:.9rem;font-weight:600;">
							<i class="fas fa-shield-halved" style="color:var(--tt-accent);width:16px;"></i>Admin Dashboard
						</a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
