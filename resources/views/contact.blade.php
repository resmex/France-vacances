@extends('layouts.front')

@section('title', 'Contact Us - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero" style="background-image:url('{{ asset('images/place-2.jpg') }}');">
	<div class="container">
		<h1 class="tt-page-title">Contact <span class="accent">Us</span></h1>
		<p class="tt-page-subtitle">Our team is here to help you find a holiday home in France.</p>
	</div>
</section>

<!-- Contact Form & Details -->
<section class="tt-section-sm">
	<div class="container">
		<div class="row g-5">
			<!-- Form -->
			<div class="col-lg-6">
				<h2 class="tt-title mb-3">Send Us a <span class="accent">Message</span></h2>

				@if(Session::has('success'))
				<div class="alert alert-success">{{ Session::get('success') }}</div>
				@endif

				<form method="POST" action="{{ route('contact.store') }}" class="tt-form">
					@csrf
					<div class="tt-form-group">
						<label class="tt-label">Full Name *</label>
						<input type="text" name="name" class="tt-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
							   placeholder="Enter your full name" value="{{ old('name') }}" required>
						@if ($errors->has('name'))
							<div class="tt-error">{{ $errors->first('name') }}</div>
						@endif
					</div>
					<div class="tt-form-group">
						<label class="tt-label">Email Address *</label>
						<input type="email" name="email" class="tt-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
							   placeholder="Enter your email address" value="{{ old('email') }}" required>
						@if ($errors->has('email'))
							<div class="tt-error">{{ $errors->first('email') }}</div>
						@endif
					</div>
					<div class="tt-form-group">
						<label class="tt-label">Subject *</label>
						<input type="text" name="subject" class="tt-input {{ $errors->has('subject') ? 'is-invalid' : '' }}"
							   placeholder="e.g. Enquiry about Provence villa" value="{{ old('subject') }}" required>
						@if ($errors->has('subject'))
							<div class="tt-error">{{ $errors->first('subject') }}</div>
						@endif
					</div>
					<div class="tt-form-group">
						<label class="tt-label">Message *</label>
						<textarea name="message" class="tt-textarea {{ $errors->has('message') ? 'is-invalid' : '' }}"
								  rows="6" placeholder="Tell us about your ideal property, travel dates, number of guests..." required>{{ old('message') }}</textarea>
						@if ($errors->has('message'))
							<div class="tt-error">{{ $errors->first('message') }}</div>
						@endif
					</div>
					<button type="submit" class="btn-tt-primary w-100">
						Send Message
					</button>
				</form>
			</div>

			<!-- Contact Details & Map -->
			<div class="col-lg-6">
				<h2 class="tt-title mb-3">Contact <span class="accent">Details</span></h2>
				<ul class="tt-contact-list mb-4">
					<li><strong>Office:</strong> 12 Regent Street, London, W1B 5JG, UK</li>
					<li><strong>Phone:</strong> <a href="tel:+442079460123">+44 20 7946 0123</a></li>
					<li><strong>Email:</strong> <a href="mailto:info@francevacances.co.uk">info@francevacances.co.uk</a></li>
					<li><strong>Office Hours:</strong> Mon&ndash;Fri, 9AM&ndash;5:30PM</li>
				</ul>
				<div class="tt-map-wrapper">
					<iframe
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2482.89!2d-0.1434!3d51.5079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zRegent+Street+London!5e0!3m2!1sen!2suk!4v1"
						width="100%" height="280" style="border:0;border-radius:var(--tt-radius);display:block;" allowfullscreen="" loading="lazy">
					</iframe>
				</div>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
