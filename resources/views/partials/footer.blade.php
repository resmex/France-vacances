<!-- Footer -->
<footer class="tt-footer">
	<div class="container">
		<div class="row g-4">
			<!-- Brand -->
			<div class="col-lg-4">
				<div class="d-flex align-items-center gap-2 mb-3">
					<div class="brand-icon"><i class="fas fa-house"></i></div>
					<h4 class="mb-0">France<span class="brand-accent" style="color:var(--tt-accent)">Vacances</span></h4>
				</div>
				<p class="mb-3">
					France Vacances helps customers find and book holiday homes across France.
					We list cottages, villas, chalets and apartments in Provence, the Alps, Dordogne and more.
				</p>
				<div class="social-links">
					<a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
					<a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
					<a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
					<a href="#" class="social-icon"><i class="fab fa-pinterest-p"></i></a>
				</div>
			</div>

			<!-- Quick Links -->
			<div class="col-lg-2 col-md-6">
				<h5>Quick Links</h5>
				<a href="{{ url('/') }}" class="tt-footer-link">Home</a>
				<a href="{{ route('packages') }}" class="tt-footer-link">Properties</a>
				<a href="{{ route('blog') }}" class="tt-footer-link">Blog</a>
				<a href="{{ route('about') }}" class="tt-footer-link">About Us</a>
				<a href="{{ route('contact') }}" class="tt-footer-link">Contact</a>
			</div>

			<!-- Property Types -->
			<div class="col-lg-2 col-md-6">
				<h5>Property Types</h5>
				<a href="{{ route('packages') }}?type=cottage" class="tt-footer-link">Cottages &amp; Gîtes</a>
				<a href="{{ route('packages') }}?type=villa" class="tt-footer-link">Villas with Pools</a>
				<a href="{{ route('packages') }}?type=chalet" class="tt-footer-link">Alpine Chalets</a>
				<a href="{{ route('packages') }}?type=apartment" class="tt-footer-link">City Apartments</a>
				<a href="{{ route('packages') }}?type=farmhouse" class="tt-footer-link">Farmhouses</a>
			</div>

			<!-- Case Study -->
			<div class="col-lg-1 col-md-6">
				<h5>Case Study</h5>
				<a href="{{ route('case-study.index') }}" class="tt-footer-link">Overview</a>
				<a href="{{ route('case-study.system-integration') }}" class="tt-footer-link">System Integration</a>
				<a href="{{ route('case-study.security') }}" class="tt-footer-link">Security</a>
				<a href="{{ route('case-study.infrastructure') }}" class="tt-footer-link">Infrastructure</a>
			</div>

			<!-- Contact Info -->
			<div class="col-lg-3 col-md-6">
				<h5>Contact Us</h5>
				<div class="contact-row">
					<i class="fas fa-map-marker-alt"></i>
					<span>12 Regent Street<br>London, W1B 5JG, United Kingdom</span>
				</div>
				<div class="contact-row">
					<i class="fas fa-phone"></i>
					<span>+44 20 7946 0123</span>
				</div>
				<div class="contact-row">
					<i class="fas fa-envelope"></i>
					<span>info@francevacances.co.uk</span>
				</div>
				<div class="contact-row">
					<i class="fas fa-clock"></i>
					<span>Mon–Fri: 9AM–5:30PM GMT</span>
				</div>
			</div>
		</div>

		<!-- Bottom bar -->
		<div class="tt-footer-bottom">
			<div class="row align-items-center">
				<div class="col-md-6">
					<p>&copy; {{ date('Y') }} France Vacances Ltd. All rights reserved. ABTA Protected.</p>
				</div>
				<div class="col-md-6 text-md-end">
					<a href="#" class="me-3">Privacy Policy</a>
					<a href="#" class="me-3">Terms of Service</a>
					<a href="#">Cookie Policy</a>
				</div>
			</div>
		</div>
	</div>
</footer>
