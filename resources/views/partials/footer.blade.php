<!-- Footer -->
<footer class="tt-footer-simple">
	<div class="container text-center">
		<p class="tt-footer-copy">France Vacances &copy; {{ date('Y') }}</p>
		<nav class="tt-footer-nav">
			<a href="{{ url('/') }}">Home</a>
			<a href="{{ route('packages') }}">Properties</a>
			<a href="{{ route('about') }}">About</a>
			<a href="{{ route('contact') }}">Contact</a>
			<a href="#">Privacy</a>
			<a href="#">Terms</a>
		</nav>
		<p class="tt-footer-contact">
			<a href="mailto:info@francevacances.co.uk">info@francevacances.co.uk</a>
			<span>|</span>
			<a href="tel:+442079460123">+44 20 7946 0123</a>
		</p>
	</div>
</footer>
