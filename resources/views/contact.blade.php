@extends('layouts.front')

@section('title', 'Contact Us - France Vacances')

@section('page')
@include('partials.navbar')

<!-- Page Hero -->
<section class="tt-page-hero">
	<div class="tt-page-hero-bg" style="background-image: url('{{ asset('images/place-2.jpg') }}');"></div>
	<div class="container" data-aos="fade-up">
		<h1 class="tt-page-title">Contact <span class="accent">Us</span></h1>
		<p class="tt-page-subtitle">Our team is ready to help you find a holiday home in France.</p>
	</div>
</section>

<!-- Contact Info Cards -->
<section class="tt-section-sm">
	<div class="container">
		<div class="row g-4" data-aos="fade-up">
			<div class="col-md-6 col-lg-3">
				<div class="tt-contact-card text-center">
					<div class="icon"><i class="fas fa-map-marker-alt"></i></div>
					<h5>Our Office</h5>
					<p>12 Regent Street<br>London, W1B 5JG, UK</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="tt-contact-card text-center">
					<div class="icon"><i class="fas fa-phone"></i></div>
					<h5>Call Us</h5>
					<p><a href="tel:+442079460123">+44 20 7946 0123</a><br>Mon–Fri: 9AM–5:30PM GMT</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="tt-contact-card text-center">
					<div class="icon"><i class="fas fa-envelope"></i></div>
					<h5>Email Us</h5>
					<p><a href="mailto:info@francevacances.co.uk">info@francevacances.co.uk</a><br>We reply within 24 hours</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-3">
				<div class="tt-contact-card text-center">
					<div class="icon"><i class="fas fa-comments"></i></div>
					<h5>Live Chat</h5>
					<p>Available Mon–Fri<br>9AM–5PM GMT</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Contact Form & Map -->
<section class="tt-section">
	<div class="container">
		<div class="row g-5">
			<!-- Form -->
			<div class="col-lg-6" data-aos="fade-right">
				<div class="tt-pretitle">Send us a Message</div>
				<h2 class="tt-title mb-3">Plan Your <span class="accent">French Holiday</span></h2>
				<p class="mb-4">Tell us what you're looking for and our specialists will be in touch within one working day.</p>

				@if(Session::has('success'))
				<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>{{ Session::get('success') }}</div>
				@endif

				<form method="POST" action="{{ route('contact.store') }}" class="tt-form">
					@csrf
					<div class="tt-form-group">
						<label class="tt-label"><i class="fas fa-user me-1"></i> Full Name *</label>
						<input type="text" name="name" class="tt-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
							   placeholder="Enter your full name" value="{{ old('name') }}" required>
						@if ($errors->has('name'))
							<div class="tt-error">{{ $errors->first('name') }}</div>
						@endif
					</div>
					<div class="tt-form-group">
						<label class="tt-label"><i class="fas fa-envelope me-1"></i> Email Address *</label>
						<input type="email" name="email" class="tt-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
							   placeholder="Enter your email address" value="{{ old('email') }}" required>
						@if ($errors->has('email'))
							<div class="tt-error">{{ $errors->first('email') }}</div>
						@endif
					</div>
					<div class="tt-form-group">
						<label class="tt-label"><i class="fas fa-tag me-1"></i> Subject *</label>
						<input type="text" name="subject" class="tt-input {{ $errors->has('subject') ? 'is-invalid' : '' }}"
							   placeholder="e.g. Enquiry about Provence villa" value="{{ old('subject') }}" required>
						@if ($errors->has('subject'))
							<div class="tt-error">{{ $errors->first('subject') }}</div>
						@endif
					</div>
					<div class="tt-form-group">
						<label class="tt-label"><i class="fas fa-comment me-1"></i> Message *</label>
						<textarea name="message" class="tt-textarea {{ $errors->has('message') ? 'is-invalid' : '' }}"
								  rows="6" placeholder="Tell us about your ideal property, travel dates, number of guests..." required>{{ old('message') }}</textarea>
						@if ($errors->has('message'))
							<div class="tt-error">{{ $errors->first('message') }}</div>
						@endif
					</div>
					<button type="submit" class="btn-tt-primary w-100">
						Send Message <i class="fas fa-paper-plane ms-1"></i>
					</button>
				</form>
			</div>

			<!-- Map & Quick Info -->
			<div class="col-lg-6" data-aos="fade-left">
				<div class="tt-map-wrapper mb-4">
					<iframe
						src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2482.89!2d-0.1434!3d51.5079!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zRegent+Street+London!5e0!3m2!1sen!2suk!4v1"
						width="100%" height="350" style="border:0;border-radius:var(--tt-radius);display:block;" allowfullscreen="" loading="lazy">
					</iframe>
				</div>
				<div class="row g-3">
					<div class="col-md-4">
						<div class="tt-contact-card text-center p-3">
							<i class="fas fa-subway fa-lg mb-2" style="color:var(--tt-primary);"></i>
							<h6>Easy to Find</h6>
							<small>Piccadilly Circus station</small>
						</div>
					</div>
					<div class="col-md-4">
						<div class="tt-contact-card text-center p-3">
							<i class="fas fa-parking fa-lg mb-2" style="color:var(--tt-primary);"></i>
							<h6>Parking Nearby</h6>
							<small>NCP Brewer St</small>
						</div>
					</div>
					<div class="col-md-4">
						<div class="tt-contact-card text-center p-3">
							<i class="fas fa-coffee fa-lg mb-2" style="color:var(--tt-primary);"></i>
							<h6>Walk-ins Welcome</h6>
							<small>Mon–Fri 9AM–5PM</small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- FAQ -->
<section class="tt-section tt-section-light">
	<div class="container">
		<div class="tt-section-header text-center" data-aos="fade-up">
			<div class="tt-pretitle">Got Questions?</div>
			<h2 class="tt-title">Frequently Asked <span class="accent">Questions</span></h2>
		</div>
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="accordion tt-accordion" id="faqAccordion" data-aos="fade-up">
					<div class="accordion-item">
						<h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">How far in advance should I book my French holiday property?</button></h2>
						<div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
							<div class="accordion-body">We recommend booking at least 3–6 months in advance, especially for peak summer (July–August) and school holidays. However, we also have a last-minute availability section for bookings within 8 weeks.</div>
						</div>
					</div>
					<div class="accordion-item">
						<h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">What's included in the property rental price?</button></h2>
						<div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
							<div class="accordion-body">Most properties include linen, towels, Wi-Fi and use of all facilities shown in the listing. Additional charges such as electricity or cleaning fees are clearly listed on each property page before you book.</div>
						</div>
					</div>
					<div class="accordion-item">
						<h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">Can I bring pets to the property?</button></h2>
						<div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
							<div class="accordion-body">Many of our properties are pet-friendly. You can filter by "Pet Friendly" on the properties page, or contact us and we'll find the perfect property for you and your four-legged friends.</div>
						</div>
					</div>
					<div class="accordion-item">
						<h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">What payment methods do you accept?</button></h2>
						<div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
							<div class="accordion-body">We accept all major credit and debit cards, bank transfers, and PayPal. A deposit of 25% is required to confirm your booking, with the balance due 8 weeks before arrival. All payments are in GBP.</div>
						</div>
					</div>
					<div class="accordion-item">
						<h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">What is your cancellation policy?</button></h2>
						<div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
							<div class="accordion-body">Our standard policy allows free cancellation up to 8 weeks before arrival with a full deposit refund. Cancellations within 8 weeks are subject to our standard terms. We strongly recommend travel insurance.</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@include('partials.footer')
@endsection
