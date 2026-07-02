@extends('layouts.front')

@section('title', 'Checkout - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero tt-page-hero-sm">
	<div class="container">
		<h1 class="tt-page-title">Checkout</h1>
	</div>
</section>

<!-- Checkout Content -->
<section class="tt-section">
	<div class="container">
		<div class="row g-5">
			<!-- Billing Info -->
			<div class="col-lg-7">
				<div class="tt-sidebar-card">
					<h4 class="mb-1"><i class="fas fa-user me-2"></i> Personal Information</h4>
					<p class="text-muted mb-4">Fill in your details to complete the booking</p>

					<form id="checkout_form" method="POST" action="{{ route('checkout.store') }}" class="tt-form">
						@csrf
						<div class="row g-3">
							<div class="col-md-6">
								<div class="tt-form-group">
									<label class="tt-label">First Name *</label>
									<input type="text" name="firstname"
										   class="tt-input {{ $errors->has('firstname') ? 'is-invalid' : '' }}"
										   placeholder="John" required>
									@if ($errors->has('firstname'))
										<div class="tt-error">{{ $errors->first('firstname') }}</div>
									@endif
								</div>
							</div>
							<div class="col-md-6">
								<div class="tt-form-group">
									<label class="tt-label">Last Name *</label>
									<input type="text" name="lastname"
										   class="tt-input {{ $errors->has('lastname') ? 'is-invalid' : '' }}"
										   placeholder="Doe" required>
									@if ($errors->has('lastname'))
										<div class="tt-error">{{ $errors->first('lastname') }}</div>
									@endif
								</div>
							</div>
						</div>
						<div class="tt-form-group">
							<label class="tt-label">Phone Number *</label>
							<input type="tel" name="phone"
								   class="tt-input {{ $errors->has('phone') ? 'is-invalid' : '' }}"
								   placeholder="+44 7XXX XXXXXX" required>
							@if ($errors->has('phone'))
								<div class="tt-error">{{ $errors->first('phone') }}</div>
							@endif
						</div>
						<div class="tt-form-group">
							<label class="tt-label">Email Address *</label>
							<input type="email" name="email"
								   class="tt-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
								   placeholder="you@example.com" required>
							@if ($errors->has('email'))
								<div class="tt-error">{{ $errors->first('email') }}</div>
							@endif
						</div>
					</form>
				</div>
			</div>

			<!-- Order Summary -->
			<div class="col-lg-5">
				<div class="tt-sidebar-card">
					<h4 class="mb-1"><i class="fas fa-home me-2"></i> Your Property</h4>
					<p class="text-muted mb-4">Booking summary</p>

					<div class="d-flex justify-content-between align-items-center py-3 border-bottom">
						<strong>Property</strong>
						<strong>Price/night</strong>
					</div>

					<div class="d-flex justify-content-between align-items-center py-3 border-bottom">
						<span>{{ $destinations->title }}</span>
						<span>{{ $destinations->pricing }}</span>
					</div>
					<div class="d-flex justify-content-between align-items-center py-3 border-bottom">
						<span>Subtotal</span>
						<span>{{ $destinations->pricing }}</span>
					</div>
					<div class="d-flex justify-content-between align-items-center py-3 mb-4">
						<strong class="fs-5">Total</strong>
						<strong class="fs-5" style="color:var(--tt-primary);">{{ $destinations->pricing }}</strong>
					</div>

					<div class="alert alert-info py-2 px-3 mb-3" style="font-size:.83rem;">
						<i class="fas fa-info-circle me-1"></i>
						To book, browse our properties and select <strong>Book Now</strong> on any listing.
					</div>

					<a href="{{ route('packages') }}" class="btn-tt-primary w-100 text-center d-block">
						<i class="fas fa-search me-2"></i> View Properties
					</a>

					<div class="text-center mt-3">
						<small class="text-muted"><i class="fas fa-shield-alt me-1"></i> Payments are fully simulated — no real card required</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection