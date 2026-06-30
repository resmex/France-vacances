@props([
    'title' => 'France Vacances - Holiday Homes in France',
    'description' => 'Find and book holiday homes in France with France Vacances. Cottages, villas, chalets and apartments in Provence, Côte d\'Azur, Dordogne, the French Alps and more.',
    'image' => asset('images/og-image.jpg'),
    'type' => 'website',
    'url' => url()->current(),
])

<!-- Primary Meta Tags -->
<title>{{ $title }}</title>
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $description }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:site_name" content="France Vacances">
<meta property="og:locale" content="en_GB">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $url }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">

<!-- Additional SEO -->
<meta name="robots" content="index, follow">
<meta name="author" content="France Vacances">
<link rel="canonical" href="{{ $url }}">

<!-- JSON-LD Structured Data -->
@if($type === 'website')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "TravelAgency",
    "name": "France Vacances",
    "description": "{{ $description }}",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('images/logo.png') }}",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "12 Regent Street",
        "addressLocality": "London",
        "addressRegion": "England",
        "postalCode": "W1B 5JG",
        "addressCountry": "GB"
    },
    "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+44-20-7946-0123",
        "contactType": "customer service"
    },
    "sameAs": [
        "https://facebook.com/francevacances",
        "https://twitter.com/francevacances",
        "https://instagram.com/francevacances"
    ]
}
</script>
@endif
