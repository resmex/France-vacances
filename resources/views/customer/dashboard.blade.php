@extends('layouts.front')

@section('title', 'My Account — France Vacances')

@section('page')
@include('partials.navbar')

<section class="tt-section tt-dash-page">
	<div class="container">
		@if(session('success'))
		<div class="alert alert-success border-0 mb-4 rounded-3">
			<i class="fas fa-check-circle me-2"></i>{{ session('success') }}
		</div>
		@endif

		<div class="row g-4">
			<!-- Left column: sidebar + account summary (sticky) -->
			<div class="col-lg-3">
				<div class="tt-dash-sticky">
					<div class="tt-dash-sidebar mb-4">
						<div class="tt-dash-nav-group">Main</div>
						<a href="{{ route('account.dashboard') }}" class="tt-dash-nav-item {{ request()->routeIs('account.dashboard') ? 'active' : '' }}">
							<i class="fas fa-gauge-high"></i> Dashboard
						</a>

						<div class="tt-dash-nav-group">My Bookings</div>
						<a href="{{ route('bookings.my') }}" class="tt-dash-nav-item {{ request()->routeIs('bookings.my') ? 'active' : '' }}">
							<i class="fas fa-calendar-check"></i> My Bookings
						</a>
						<a href="{{ route('wishlist.index') }}" class="tt-dash-nav-item {{ request()->routeIs('wishlist.index') ? 'active' : '' }}">
							<i class="fas fa-heart"></i> Saved Properties
						</a>

						<div class="tt-dash-nav-group">Account</div>
						<a href="{{ route('account.profile') }}" class="tt-dash-nav-item {{ request()->routeIs('account.profile') ? 'active' : '' }}">
							<i class="fas fa-user-cog"></i> Account Settings
						</a>
						<a href="{{ route('contact') }}" class="tt-dash-nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
							<i class="fas fa-headset"></i> Contact Support
						</a>

						<div class="tt-dash-nav-divider"></div>
						<a href="{{ url('/') }}" class="tt-dash-nav-item">
							<i class="fas fa-arrow-left"></i> Back to Website
						</a>
					</div>

					{{-- Account Summary --}}
					<div class="tt-dash-box">
						<div class="tt-dash-box-header">
							<h5>Account Summary</h5>
						</div>
						<div class="tt-dash-box-body">
							<table class="tt-dash-table tt-dash-table-plain">
								<tbody>
									<tr>
										<td>Name</td>
										<td>{{ $user->name }}</td>
									</tr>
									<tr>
										<td>Email</td>
										<td>{{ $user->email }}</td>
									</tr>
									<tr>
										<td>Member since</td>
										<td>{{ $user->created_at->format('M Y') }}</td>
									</tr>
									<tr>
										<td>Saved properties</td>
										<td>{{ $stats['wishlist'] }}</td>
									</tr>
									<tr>
										<td>Bookings</td>
										<td>{{ $stats['bookings'] }}</td>
									</tr>
								</tbody>
							</table>
							<a href="{{ route('account.profile') }}" class="btn-tt-outline w-100 text-center d-block mt-3">
								Edit Profile
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- Main content -->
			<div class="col-lg-9">

				{{-- Welcome --}}
				<div class="tt-dash-welcome">
					<h2>Welcome, {{ $user->name }}</h2>
					<p>Manage your bookings, saved properties and account from this page.</p>
				</div>

				{{-- Summary cards --}}
				<div class="row g-3 mb-4">
					<div class="col-6 col-md-3">
						<div class="tt-dash-stat">
							<div class="num">{{ $stats['bookings'] }}</div>
							<div class="lbl">Total Bookings</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="tt-dash-stat">
							<div class="num">{{ $stats['confirmed'] }}</div>
							<div class="lbl">Confirmed Bookings</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="tt-dash-stat">
							<div class="num">{{ $stats['wishlist'] }}</div>
							<div class="lbl">Saved Properties</div>
						</div>
					</div>
					<div class="col-6 col-md-3">
						<div class="tt-dash-stat">
							<div class="num">{{ $stats['reviews'] }}</div>
							<div class="lbl">Reviews</div>
						</div>
					</div>
				</div>

				{{-- Recent Bookings --}}
				<div class="tt-dash-box mb-4">
					<div class="tt-dash-box-header">
						<h5>Recent Bookings</h5>
						<a href="{{ route('bookings.my') }}">View All</a>
					</div>
					<div class="table-responsive">
						<table class="tt-dash-table">
							<thead>
								<tr>
									<th>Property</th>
									<th>Check-in</th>
									<th>Nights</th>
									<th>Total</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($recentBookings as $booking)
								<tr>
									<td>{{ Str::limit($booking->destination->title ?? 'Property', 30) }}</td>
									<td>{{ optional($booking->check_in_date ?? ($booking->travel_date ?? null))->format('d M Y') ?? '—' }}</td>
									<td>{{ $booking->nights_label }}</td>
									<td>{{ $booking->total_display }}</td>
									<td>{{ ucfirst($booking->status) }}</td>
									<td><a href="{{ route('booking.confirmation', $booking->id) }}">View</a></td>
								</tr>
								@empty
								<tr>
									<td colspan="6" class="text-muted">No bookings found.</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>

				{{-- Saved Properties --}}
				<div class="tt-dash-box mb-4">
					<div class="tt-dash-box-header">
						<h5>Saved Properties</h5>
						<a href="{{ route('wishlist.index') }}">View All</a>
					</div>
					<div class="table-responsive">
						<table class="tt-dash-table">
							<thead>
								<tr>
									<th>Property</th>
									<th>Region</th>
									<th>Price</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@forelse($savedProperties as $prop)
								<tr>
									<td>{{ Str::limit($prop->title, 30) }}</td>
									<td>{{ $prop->category->name ?? $prop->region_label ?? '—' }}</td>
									<td>{{ $prop->price_display }}</td>
									<td><a href="{{ route('desti.show', $prop->id) }}">View</a></td>
								</tr>
								@empty
								<tr>
									<td colspan="4" class="text-muted">No saved properties found.</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>

				{{-- Recent Reviews --}}
				@php
					$recentReviews = $user->reviews()->with('destination')->latest()->take(5)->get();
				@endphp
				<div class="tt-dash-box">
					<div class="tt-dash-box-header">
						<h5>Recent Reviews</h5>
					</div>
					<div class="table-responsive">
						<table class="tt-dash-table">
							<thead>
								<tr>
									<th>Property</th>
									<th>Rating</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								@forelse($recentReviews as $review)
								<tr>
									<td>{{ Str::limit($review->destination->title ?? 'Property', 30) }}</td>
									<td>{{ $review->rating }}/5</td>
									<td>{{ $review->created_at->format('d M Y') }}</td>
								</tr>
								@empty
								<tr>
									<td colspan="3" class="text-muted">No reviews yet.</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
