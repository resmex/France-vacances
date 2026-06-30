@extends('layouts.front')

@section('title', 'System Integration Case Study — France Vacances')

@push('styles')
<style>
.cs-code { background:#0f172a; color:#e2e8f0; border-radius:10px; padding:1.25rem 1.5rem; font-family:'Courier New',monospace; font-size:.8rem; line-height:1.7; overflow-x:auto; margin-bottom:1rem; }
.cs-code .kw  { color:#93c5fd; }
.cs-code .fn  { color:#34d399; }
.cs-code .str { color:#fbbf24; }
.cs-code .cm  { color:#64748b; font-style:italic; }
.cs-code .cl  { color:#f9a8d4; }
.cs-section   { border-left:3px solid var(--tt-accent); padding-left:1.25rem; margin-bottom:2.5rem; }
.cs-badge     { background:var(--tt-primary);color:#fff;padding:3px 10px;border-radius:50px;font-size:.72rem;font-weight:600; }
.cs-flow-step { display:flex;align-items:flex-start;gap:16px;margin-bottom:1.25rem; }
.cs-flow-num  { width:32px;height:32px;border-radius:50%;background:var(--tt-primary);color:#fff;font-weight:700;font-size:.8rem;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.cs-entity    { background:var(--tt-cream);border:1px solid #e5e7eb;border-radius:8px;padding:.75rem 1rem;margin-bottom:.5rem; }
</style>
@endpush

@section('page')
@include('partials.navbar')

<section class="tt-page-hero tt-page-hero-sm">
    <div class="tt-page-hero-bg" style="background-image:url('{{ asset('images/place-2.jpg') }}');"></div>
    <div class="container" data-aos="fade-up">
        <span style="background:var(--tt-accent);color:var(--tt-dark);padding:4px 14px;border-radius:50px;font-size:.75rem;font-weight:700;text-transform:uppercase;">Chapter 01</span>
        <h1 class="tt-page-title mt-2">System <span class="accent">Integration</span></h1>
        <p class="tt-page-subtitle">Architecture, data flow, and how every layer of France Vacances connects.</p>
    </div>
</section>

<section class="tt-section">
    <div class="container">
        <div class="row g-5">
            <!-- Main content -->
            <div class="col-lg-8">

                <!-- MVC Architecture -->
                <div class="cs-section" data-aos="fade-up">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">MVC Architecture</h2>
                    <p>France Vacances follows Laravel's Model-View-Controller pattern. Each layer has a single responsibility:</p>

                    <div class="row g-3 mb-4">
                        @foreach([
                            ['M', '#082B4C', 'Models (Eloquent ORM)', 'Destinations, Booking, Payment, User, Review, Wishlist — each maps to a database table with relationships, accessors, and query scopes.'],
                            ['V', '#065f46', 'Views (Blade Templates)', 'layouts.front for public pages, layouts.app for admin. Partials for navbar, footer, and error messages. Components for SEO and flash messages.'],
                            ['C', '#1e1b4b', 'Controllers', '15 controllers handle routing logic: WelcomeController (public), BookingController, PaymentController, CustomerController, OwnerController, FinanceController, ItController.'],
                        ] as [$letter, $colour, $title, $desc])
                        <div class="col-md-4">
                            <div style="border:1px solid {{ $colour }}30;border-radius:12px;padding:1.25rem;height:100%;">
                                <div style="width:36px;height:36px;border-radius:8px;background:{{ $colour }};color:#fff;font-weight:800;font-size:1rem;display:flex;align-items:center;justify-content:center;margin-bottom:.75rem;font-family:'Playfair Display',serif;">{{ $letter }}</div>
                                <h6 style="color:{{ $colour }};font-weight:700;margin-bottom:.5rem;">{{ $title }}</h6>
                                <p style="font-size:.82rem;color:var(--tt-dark-soft);margin:0;">{{ $desc }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="cs-code">
<span class="cm">// Eloquent model accessor — converts DB value to display format</span>
<span class="kw">public function</span> <span class="fn">getPriceDisplayAttribute</span>(): <span class="cl">string</span>
{
    <span class="kw">if</span> ($this->price_per_night) {
        <span class="kw">return</span> <span class="str">'£'</span> . number_format($this->price_per_night) . <span class="str">'/night'</span>;
    }
    <span class="kw">return</span> $this->pricing ?? <span class="str">'POA'</span>; <span class="cm">// legacy fallback</span>
}

<span class="cm">// Query scope — chainable filter</span>
<span class="kw">public function</span> <span class="fn">scopeFeatured</span>($query)
{
    <span class="kw">return</span> $query-><span class="fn">where</span>(<span class="str">'featured'</span>, <span class="kw">true</span>);
}
                    </div>
                </div>

                <!-- Database Schema -->
                <div class="cs-section" data-aos="fade-up">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">Database Schema</h2>
                    <p>The platform uses <strong>MySQL 8</strong> with 17 migrations. Key entities and their relationships:</p>

                    <div class="row g-2 mb-4">
                        @foreach([
                            ['users',        'id, name, email, role (enum: customer|admin), about, password'],
                            ['destinations', 'id, title, description, content, image, property_type, location, region, category_id, price_per_night, bedrooms, bathrooms, max_guests, amenities (JSON), featured, rating_cached, deleted_at'],
                            ['categories',   'id, name — maps to French regions (Provence, Dordogne, etc.)'],
                            ['bookings',     'id, user_id, destination_id, check_in_date, check_out_date, nights, guests, total_price, status (pending|confirmed|cancelled|completed), notes'],
                            ['payments',     'id, booking_id, reference (FV-YYYYMMDD-XXXXXX), method, status, amount, currency, is_simulated'],
                            ['reviews',      'id, user_id, destination_id, rating (1-5), comment'],
                            ['wishlists',    'id, user_id, destination_id — pivot for user↔destination many-to-many'],
                            ['tags',         'id, name — attached to destinations via destination_tag pivot'],
                        ] as [$table, $fields])
                        <div class="col-12">
                            <div class="cs-entity">
                                <div class="d-flex align-items-start gap-2">
                                    <code style="background:var(--tt-primary);color:var(--tt-accent);padding:2px 8px;border-radius:4px;font-size:.75rem;white-space:nowrap;flex-shrink:0;">{{ $table }}</code>
                                    <span style="font-size:.78rem;color:var(--tt-dark-soft);">{{ $fields }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="cs-code">
<span class="cm">// Relationships on Booking model</span>
<span class="kw">public function</span> <span class="fn">user</span>(): <span class="cl">BelongsTo</span>
{
    <span class="kw">return</span> $this-><span class="fn">belongsTo</span>(<span class="cl">User</span>::<span class="kw">class</span>);
}

<span class="kw">public function</span> <span class="fn">destination</span>(): <span class="cl">BelongsTo</span>
{
    <span class="kw">return</span> $this-><span class="fn">belongsTo</span>(<span class="cl">Destinations</span>::<span class="kw">class</span>, <span class="str">'destination_id'</span>);
}

<span class="kw">public function</span> <span class="fn">payment</span>(): <span class="cl">HasOne</span>
{
    <span class="kw">return</span> $this-><span class="fn">hasOne</span>(<span class="cl">Payment</span>::<span class="kw">class</span>);
}
                    </div>
                </div>

                <!-- Booking Flow -->
                <div class="cs-section" data-aos="fade-up">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">Booking Flow</h2>
                    <p>The end-to-end booking journey from homepage to confirmation email:</p>

                    @foreach([
                        ['Browse', 'Customer visits <code>/packages</code>. WelcomeController applies search, type, region, and price-range filters using Eloquent query scopes. Results paginated (9/page).'],
                        ['Property Detail', 'Customer visits <code>/packages/destinations/{id}</code>. PostController loads the Destination with reviews, amenities JSON, and all model accessors. A live price calculator runs in JS (nights × price_per_night).'],
                        ['Book', 'Customer submits the booking form. BookingController::store() validates dates (check_out after check_in, both ≥ today), calculates nights via Carbon::diffInDays, creates a pending Booking, redirects to payment.'],
                        ['Simulated Payment', 'PaymentController::checkout() shows the card form. process() validates card format only (16 digits, Luhn not checked), generates reference FV-YYYYMMDD-XXXXXX, creates Payment with is_simulated=true, marks booking confirmed.'],
                        ['Confirmation', 'Redirect to <code>/booking/confirmation/{booking}</code>. BookingConfirmationMail dispatched via try/catch — failure is logged but does not break the user flow. Confirmation page shows full booking summary.'],
                    ] as $i => [$step, $detail])
                    <div class="cs-flow-step">
                        <div class="cs-flow-num">{{ $i + 1 }}</div>
                        <div>
                            <div class="fw-bold mb-1">{{ $step }}</div>
                            <p style="font-size:.85rem;color:var(--tt-dark-soft);margin:0;">{!! $detail !!}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- REST API -->
                <div class="cs-section" data-aos="fade-up">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">REST API</h2>
                    <p>A public JSON API is available at <code>/api/v1/</code> for headless or third-party integrations:</p>

                    <div class="row g-2 mb-4">
                        @foreach([
                            ['GET', '/api/v1/destinations',          'Paginated property list with filters (search, type, region)'],
                            ['GET', '/api/v1/destinations/featured',  'Featured properties ordered by cached rating'],
                            ['GET', '/api/v1/destinations/search',    'Search by keyword, returns JSON array'],
                            ['GET', '/api/v1/destinations/{id}',      'Single property detail with amenities and category'],
                        ] as [$method, $path, $desc])
                        <div class="col-12">
                            <div style="background:var(--tt-cream);border:1px solid #e5e7eb;border-radius:8px;padding:.75rem 1rem;display:flex;align-items:center;gap:12px;">
                                <code style="background:var(--tt-primary);color:var(--tt-accent);padding:2px 8px;border-radius:4px;font-size:.72rem;flex-shrink:0;">{{ $method }}</code>
                                <code style="font-size:.78rem;color:var(--tt-dark);flex-shrink:0;">{{ $path }}</code>
                                <span style="font-size:.78rem;color:var(--tt-dark-soft);">{{ $desc }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="cs-code">
<span class="cm">// DestinationApiController — public, no auth required</span>
<span class="kw">public function</span> <span class="fn">index</span>(<span class="cl">Request</span> $request): <span class="cl">JsonResponse</span>
{
    $destinations = <span class="cl">Destinations</span>::<span class="fn">with</span>(<span class="str">'category'</span>)
        -><span class="fn">when</span>($request->search, <span class="kw">fn</span>($q) =>
            $q-><span class="fn">where</span>(<span class="str">'title'</span>, <span class="str">'like'</span>, <span class="str">"%{$request->search}%"</span>))
        -><span class="fn">when</span>($request->type, <span class="kw">fn</span>($q) =>
            $q-><span class="fn">ofType</span>($request->type))
        -><span class="fn">paginate</span>(12);

    <span class="kw">return</span> <span class="fn">response</span>()-><span class="fn">json</span>($destinations);
}
                    </div>
                </div>

                <!-- Email System -->
                <div class="cs-section" data-aos="fade-up">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">Email Notifications</h2>
                    <p>Laravel's <strong>Mailable</strong> class handles booking confirmation emails with inline-CSS HTML templates for maximum email client compatibility.</p>
                    <div class="cs-code">
<span class="cm">// BookingConfirmationMail — best-effort dispatch</span>
<span class="kw">try</span> {
    <span class="cl">Mail</span>::<span class="fn">to</span>($booking->user->email)
        -><span class="fn">send</span>(<span class="kw">new</span> <span class="cl">BookingConfirmationMail</span>($booking));
} <span class="kw">catch</span> (<span class="cl">\Exception</span> $e) {
    <span class="cm">// Log the failure but don't break the confirmation flow</span>
    <span class="cl">Log</span>::<span class="fn">warning</span>(<span class="str">'Booking email failed: '</span> . $e-><span class="fn">getMessage</span>());
}
                    </div>
                    <p style="font-size:.85rem;color:var(--tt-dark-soft);">
                        The email includes the booking reference, property details, check-in/out dates, total paid, and a "What Happens Next" guide. A footnote clarifies the system is a demonstration with no real payment.
                    </p>
                </div>

            </div>

            <!-- Sidebar TOC -->
            <div class="col-lg-4">
                <div class="tt-sidebar-card" style="position:sticky;top:90px;" data-aos="fade-left">
                    <h6 class="fw-bold mb-3" style="color:var(--tt-primary);font-size:.85rem;text-transform:uppercase;letter-spacing:.06em;">Contents</h6>
                    @foreach([
                        ['MVC Architecture', '#'],
                        ['Database Schema', '#'],
                        ['Booking Flow', '#'],
                        ['REST API', '#'],
                        ['Email Notifications', '#'],
                    ] as [$item, $href])
                    <a href="{{ $href }}" style="display:flex;align-items:center;gap:8px;padding:8px 0;border-bottom:1px solid #f0f0f0;color:var(--tt-dark);font-size:.85rem;text-decoration:none;">
                        <i class="fas fa-chevron-right" style="color:var(--tt-accent);font-size:.65rem;"></i>
                        {{ $item }}
                    </a>
                    @endforeach

                    <div class="mt-4 pt-3 border-top">
                        <h6 class="fw-bold mb-3" style="color:var(--tt-primary);font-size:.85rem;text-transform:uppercase;letter-spacing:.06em;">Other Chapters</h6>
                        <a href="{{ route('case-study.security') }}" class="btn-tt-outline w-100 d-block text-center mb-2" style="font-size:.82rem;">
                            <i class="fas fa-shield-halved me-2"></i>Security
                        </a>
                        <a href="{{ route('case-study.infrastructure') }}" class="btn-tt-outline w-100 d-block text-center" style="font-size:.82rem;">
                            <i class="fas fa-server me-2"></i>Infrastructure
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
            <a href="{{ route('case-study.index') }}" class="btn-tt-outline">
                <i class="fas fa-arrow-left me-2"></i>Case Study Index
            </a>
            <a href="{{ route('case-study.security') }}" class="btn-tt-primary">
                Chapter 02: Security <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection
