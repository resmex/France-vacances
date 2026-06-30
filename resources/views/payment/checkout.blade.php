@extends('layouts.front')

@section('title', 'Secure Payment — France Vacances')

@section('page')
@include('partials.navbar')

<section class="tt-page-hero tt-page-hero-sm">
	<div class="tt-page-hero-bg" style="background-image: url('{{ $booking->destination->image_url }}');"></div>
	<div class="container" data-aos="fade-up">
		<h1 class="tt-page-title">Complete Your <span class="accent">Booking</span></h1>
	</div>
</section>

<section class="tt-section">
	<div class="container" style="max-width:960px;">
		@if(session('success'))
		<div class="alert alert-success border-0 mb-4">
			<i class="fas fa-check-circle me-2"></i>{{ session('success') }}
		</div>
		@endif

		<div class="row g-4">
			<!-- Payment Form -->
			<div class="col-lg-7">
				<div class="tt-sidebar-card" data-aos="fade-up">
					<div class="d-flex align-items-center gap-3 mb-4">
						<div class="tt-info-icon"><i class="fas fa-lock"></i></div>
						<div>
							<h4 class="mb-0">Secure Payment</h4>
							<small class="text-muted">Your payment details are encrypted and secure</small>
						</div>
					</div>

					{{-- SIMULATED PAYMENT NOTICE --}}
					<div class="alert border-0 mb-4" style="background:var(--tt-accent-light);border-left:4px solid var(--tt-accent)!important;">
						<div class="d-flex gap-2">
							<i class="fas fa-info-circle mt-1" style="color:var(--tt-accent);"></i>
							<div>
								<strong>Demo System</strong><br>
								<small>This is a simulated payment. Enter any 16-digit card number (e.g. <code>4242424242424242</code>). No real charges are made.</small>
							</div>
						</div>
					</div>

					<form action="{{ route('payment.process', $booking->id) }}" method="POST" id="payment-form">
						@csrf

						<div class="mb-3">
							<label class="form-label small fw-semibold">Name on Card</label>
							<input type="text" name="name_on_card" class="tt-input @error('name_on_card') is-invalid @enderror"
								   placeholder="e.g. James Hargreaves" value="{{ old('name_on_card', Auth::user()->name) }}" required>
							@error('name_on_card')<div class="invalid-feedback">{{ $message }}</div>@enderror
						</div>

						<div class="mb-3">
							<label class="form-label small fw-semibold">Card Number</label>
							<div class="position-relative">
								<input type="text" name="card_number" id="card_number"
									   class="tt-input @error('card_number') is-invalid @enderror"
									   placeholder="0000 0000 0000 0000"
									   maxlength="19" autocomplete="cc-number" required>
								<span style="position:absolute;right:1rem;top:50%;transform:translateY(-50%);color:#aaa;">
									<i class="fab fa-cc-visa me-1"></i><i class="fab fa-cc-mastercard"></i>
								</span>
							</div>
							@error('card_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
						</div>

						<div class="row g-3 mb-3">
							<div class="col-6">
								<label class="form-label small fw-semibold">Expiry Date</label>
								<input type="text" name="expiry" class="tt-input @error('expiry') is-invalid @enderror"
									   placeholder="MM/YY" maxlength="5" autocomplete="cc-exp" required>
								@error('expiry')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
							<div class="col-6">
								<label class="form-label small fw-semibold">CVV</label>
								<input type="text" name="cvv" class="tt-input @error('cvv') is-invalid @enderror"
									   placeholder="123" maxlength="4" autocomplete="cc-csc" required>
								@error('cvv')<div class="invalid-feedback">{{ $message }}</div>@enderror
							</div>
						</div>

						<button type="submit" class="btn-tt-primary w-100 py-3" id="pay-btn" style="font-size:1.05rem;">
							<i class="fas fa-lock me-2"></i>
							Pay {{ $booking->total_display }} — Confirm Booking
						</button>

						<p class="text-center mt-3 mb-0" style="font-size:.8rem;color:var(--tt-dark-soft);">
							<i class="fas fa-shield-alt me-1" style="color:var(--tt-accent);"></i>
							ABTA Protected &nbsp;·&nbsp;
							<i class="fas fa-lock me-1"></i> 256-bit SSL &nbsp;·&nbsp;
							Free cancellation up to 8 weeks before arrival
						</p>
					</form>
				</div>
			</div>

			<!-- Booking Summary -->
			<div class="col-lg-5">
				<div class="tt-sidebar-card" data-aos="fade-left" style="position:sticky;top:90px;">
					<h5 class="mb-3">Booking Summary</h5>
					<img src="{{ $booking->destination->image_url }}"
						 alt="{{ $booking->destination->title }}"
						 class="img-fluid rounded-2 mb-3 w-100" style="object-fit:cover;height:150px;">

					<h6 class="fw-bold">{{ $booking->destination->title }}</h6>
					<p class="text-muted small mb-3">
						<i class="fas fa-map-marker-alt me-1" style="color:var(--tt-accent);"></i>
						{{ $booking->destination->location ?? $booking->destination->region_label }}
					</p>

					<div class="tt-info-list">
						<div class="tt-info-row">
							<div class="tt-info-icon"><i class="fas fa-calendar-check"></i></div>
							<div>
								<div class="tt-info-label">Check-in</div>
								<div class="tt-info-value">{{ $booking->check_in_date->format('D, d M Y') }}</div>
							</div>
						</div>
						<div class="tt-info-row">
							<div class="tt-info-icon"><i class="fas fa-calendar-times"></i></div>
							<div>
								<div class="tt-info-label">Check-out</div>
								<div class="tt-info-value">{{ $booking->check_out_date->format('D, d M Y') }}</div>
							</div>
						</div>
						<div class="tt-info-row">
							<div class="tt-info-icon"><i class="fas fa-moon"></i></div>
							<div>
								<div class="tt-info-label">Duration</div>
								<div class="tt-info-value">{{ $booking->nights_label }}</div>
							</div>
						</div>
						<div class="tt-info-row">
							<div class="tt-info-icon"><i class="fas fa-users"></i></div>
							<div>
								<div class="tt-info-label">Guests</div>
								<div class="tt-info-value">{{ $booking->guests }} {{ Str::plural('guest', $booking->guests) }}</div>
							</div>
						</div>
					</div>

					<div class="mt-3 pt-3 border-top">
						@php
							$pricePerNight = $booking->destination->price_per_night ?? 0;
						@endphp
						<div class="d-flex justify-content-between mb-2 small">
							<span>£{{ number_format($pricePerNight) }} × {{ $booking->nights }} nights</span>
							<span>{{ $booking->total_display }}</span>
						</div>
						<div class="d-flex justify-content-between fw-bold" style="font-size:1.1rem;">
							<span>Total</span>
							<span style="color:var(--tt-primary);">{{ $booking->total_display }}</span>
						</div>
						<small class="text-muted d-block mt-1">All prices in GBP. No hidden fees.</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')

@push('scripts')
<script>
// Auto-format card number with spaces
const cardInput = document.getElementById('card_number');
if (cardInput) {
    cardInput.addEventListener('input', function() {
        let v = this.value.replace(/\D/g, '').substring(0, 16);
        this.value = v.replace(/(.{4})/g, '$1 ').trim();
    });
}
// Auto-format expiry
document.querySelector('[name="expiry"]')?.addEventListener('input', function() {
    let v = this.value.replace(/\D/g, '').substring(0, 4);
    if (v.length >= 2) v = v.slice(0,2) + '/' + v.slice(2);
    this.value = v;
});
// Strip spaces from card number before submit
document.getElementById('payment-form')?.addEventListener('submit', function() {
    if (cardInput) cardInput.value = cardInput.value.replace(/\s/g, '');
    document.getElementById('pay-btn').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing…';
    document.getElementById('pay-btn').disabled = true;
});
</script>
@endpush
@endsection
