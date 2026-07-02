@extends('layouts.front')

@section('title', 'Security Case Study — France Vacances')

@push('styles')
<style>
.cs-code { background:#0f172a; color:#e2e8f0; border-radius:10px; padding:1.25rem 1.5rem; font-family:'Courier New',monospace; font-size:.8rem; line-height:1.7; overflow-x:auto; margin-bottom:1rem; }
.cs-code .kw  { color:#93c5fd; }
.cs-code .fn  { color:#34d399; }
.cs-code .str { color:#fbbf24; }
.cs-code .cm  { color:#64748b; font-style:italic; }
.cs-code .cl  { color:#f9a8d4; }
.cs-section   { border-left:3px solid var(--tt-accent); padding-left:1.25rem; margin-bottom:2.5rem; }
.cs-check     { display:flex;align-items:flex-start;gap:12px;margin-bottom:.9rem; }
.cs-check-icon{ width:24px;height:24px;border-radius:50%;background:#22c55e;color:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px; }
.cs-check-icon.warn { background:#f59e0b; }
.cs-threat    { background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:.9rem 1rem;margin-bottom:.75rem; }
</style>
@endpush

@section('page')
@include('partials.navbar')

<section class="tt-page-hero tt-page-hero-sm" style="background-image:url('{{ asset('images/image_2.jpg') }}');">
    <div class="container">
        <span style="background:#22c55e;color:#fff;padding:4px 14px;border-radius:8px;font-size:.75rem;font-weight:700;text-transform:uppercase;">Chapter 02</span>
        <h1 class="tt-page-title mt-2">Security <span class="accent">Design</span></h1>
        <p class="tt-page-subtitle">Protection, access control, and threat handling across every layer of France Vacances.</p>
    </div>
</section>

<section class="tt-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">

                <!-- Security overview matrix -->
                <div class="tt-sidebar-card mb-5" style="background:var(--tt-primary);color:#fff;">
                    <h5 style="color:var(--tt-accent);margin-bottom:1.25rem;">Security Coverage Matrix</h5>
                    <div class="row g-2">
                        @foreach([
                            ['CSRF Tokens',          'All POST/PUT/DELETE forms', 'success'],
                            ['Password Hashing',     'bcrypt via Hash::make()',   'success'],
                            ['Role-based Middleware','admin + auth guards',       'success'],
                            ['Form Request Validation','15 rule sets',           'success'],
                            ['SQL Injection',        'Eloquent ORM parameterised','success'],
                            ['XSS Prevention',       'Blade {{ }} auto-escape',  'success'],
                            ['Email Verification',   'MustVerifyEmail interface', 'success'],
                            ['Real Payment Gateway', 'Not integrated (demo)',     'warn'],
                        ] as [$control, $implementation, $status])
                        <div class="col-md-6">
                            <div style="background:rgba(255,255,255,.06);border-radius:8px;padding:.6rem .9rem;display:flex;align-items:center;gap:10px;">
                                <i class="fas fa-{{ $status === 'success' ? 'check-circle' : 'exclamation-triangle' }}"
                                   style="color:{{ $status === 'success' ? '#4ade80' : '#fbbf24' }};font-size:.85rem;flex-shrink:0;"></i>
                                <div>
                                    <div style="font-size:.8rem;font-weight:600;">{{ $control }}</div>
                                    <div style="font-size:.68rem;opacity:.6;">{{ $implementation }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- CSRF -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">1. CSRF Protection</h2>
                    <p>Every HTML form in France Vacances includes a <strong>CSRF token</strong> via Laravel's <code>@csrf</code> directive. The <code>VerifyCsrfToken</code> middleware validates the token on all state-changing requests, preventing cross-site request forgery attacks.</p>

                    <div class="cs-code">
<span class="cm">&lt;!-- Every form includes the CSRF token --&gt;</span>
&lt;<span class="kw">form</span> action="{{ '{{' }} route('bookings.store', $destination->id) {{ '}}' }}" method="POST"&gt;
    @csrf
    &lt;<span class="kw">input</span> type="date" name="check_in_date" required&gt;
    ...
&lt;/<span class="kw">form</span>&gt;

<span class="cm">// AJAX requests include the token via header</span>
<span class="fn">fetch</span>(url, {
    method: <span class="str">'POST'</span>,
    headers: { <span class="str">'X-CSRF-TOKEN'</span>: document.<span class="fn">querySelector</span>(<span class="str">'meta[name="csrf-token"]'</span>).content }
});
                    </div>

                    <div class="cs-check">
                        <div class="cs-check-icon"><i class="fas fa-check" style="font-size:.6rem;"></i></div>
                        <div style="font-size:.85rem;">The CSRF token is regenerated on each login and stored in the session. The <code>meta</code> tag in the front layout makes it available to AJAX requests (e.g. the wishlist toggle).</div>
                    </div>
                </div>

                <!-- Password Hashing -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">2. Password Hashing</h2>
                    <p>Passwords are <strong>never stored in plain text</strong>. Laravel's <code>Hash::make()</code> uses bcrypt with a work factor of 12 by default, making brute-force attacks computationally expensive.</p>

                    <div class="cs-code">
<span class="cm">// CustomerController — password change</span>
<span class="kw">if</span> (! <span class="cl">Hash</span>::<span class="fn">check</span>($request->current_password, <span class="cl">Auth</span>::<span class="fn">user</span>()->password)) {
    <span class="kw">return</span> <span class="fn">back</span>()-><span class="fn">withErrors</span>([
        <span class="str">'current_password'</span> => <span class="str">'The current password is incorrect.'</span>
    ]);
}

<span class="cl">Auth</span>::<span class="fn">user</span>()-><span class="fn">update</span>([
    <span class="str">'password'</span> => <span class="cl">Hash</span>::<span class="fn">make</span>($request->password)
]);
                    </div>

                    <div class="cs-check">
                        <div class="cs-check-icon"><i class="fas fa-check" style="font-size:.6rem;"></i></div>
                        <div style="font-size:.85rem;">The <code>Hash::check()</code> method uses a constant-time comparison to prevent timing attacks during password verification.</div>
                    </div>
                </div>

                <!-- Role-Based Access Control -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">3. Role-Based Access Control</h2>
                    <p>France Vacances uses a <strong>two-tier role system</strong> stored as an <code>enum</code> column on the users table. The <code>admin</code> middleware guards all admin-only routes.</p>

                    <div class="row g-3 mb-4">
                        @foreach([
                            ['Customer', 'auth',       '#3b82f6', 'Browse, book, review, wishlist, manage own bookings and profile'],
                            ['Admin',    'auth, admin', '#082B4C', 'All of the above + CRUD for all entities, view all bookings/payments/reports, manage users'],
                        ] as [$role, $middleware, $colour, $access])
                        <div class="col-md-6">
                            <div style="border:1px solid {{ $colour }}30;border-radius:10px;padding:1rem;height:100%;">
                                <div style="font-weight:700;color:{{ $colour }};margin-bottom:.4rem;">{{ $role }}</div>
                                <code style="font-size:.72rem;background:{{ $colour }}12;color:{{ $colour }};padding:2px 8px;border-radius:4px;display:block;margin-bottom:.6rem;">{{ $middleware }}</code>
                                <p style="font-size:.78rem;color:var(--tt-dark-soft);margin:0;">{{ $access }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="cs-code">
<span class="cm">// Custom admin middleware — app/Http/Middleware/IsAdmin.php</span>
<span class="kw">public function</span> <span class="fn">handle</span>(<span class="cl">Request</span> $request, <span class="cl">Closure</span> $next)
{
    <span class="kw">if</span> (! <span class="cl">Auth</span>::<span class="fn">check</span>() || ! <span class="cl">Auth</span>::<span class="fn">user</span>()-><span class="fn">isAdmin</span>()) {
        <span class="kw">return</span> <span class="fn">redirect</span>(<span class="str">'/'</span>)-><span class="fn">with</span>(<span class="str">'error'</span>, <span class="str">'Unauthorised.'</span>);
    }
    <span class="kw">return</span> <span class="fn">$next</span>($request);
}

<span class="cm">// User model helper</span>
<span class="kw">public function</span> <span class="fn">isAdmin</span>(): <span class="kw">bool</span>
{
    <span class="kw">return</span> $this->role === <span class="str">'admin'</span>;
}
                    </div>

                    <div class="cs-check">
                        <div class="cs-check-icon"><i class="fas fa-check" style="font-size:.6rem;"></i></div>
                        <div style="font-size:.85rem;">The <code>BookingController::store()</code> additionally checks that a booking belongs to the authenticated user before allowing payment access — preventing horizontal privilege escalation.</div>
                    </div>
                </div>

                <!-- Input Validation -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">4. Input Validation via Form Requests</h2>
                    <p>All user inputs are validated using <strong>Laravel Form Request</strong> classes before reaching the controller. This ensures invalid or malicious data never reaches the database layer.</p>

                    <div class="cs-code">
<span class="cm">// BookingController::store() — date validation</span>
$request-><span class="fn">validate</span>([
    <span class="str">'check_in_date'</span>  => [<span class="str">'required'</span>, <span class="str">'date'</span>, <span class="str">'after_or_equal:today'</span>],
    <span class="str">'check_out_date'</span> => [<span class="str">'required'</span>, <span class="str">'date'</span>, <span class="str">'after:check_in_date'</span>],
    <span class="str">'guests'</span>         => [<span class="str">'required'</span>, <span class="str">'integer'</span>, <span class="str">'min:1'</span>],
]);

<span class="cm">// PaymentController::process() — card format validation only</span>
$request-><span class="fn">validate</span>([
    <span class="str">'card_number'</span> => [<span class="str">'required'</span>, <span class="str">'digits:16'</span>],
    <span class="str">'expiry'</span>      => [<span class="str">'required'</span>, <span class="str">'regex:/^\d{2}\/\d{2}$/'</span>],
    <span class="str">'cvv'</span>         => [<span class="str">'required'</span>, <span class="str">'digits_between:3,4'</span>],
]);
<span class="cm">// No real card processing — is_simulated flag always set to true</span>
                    </div>
                </div>

                <!-- SQL Injection Prevention -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">5. SQL Injection Prevention</h2>
                    <p>The Eloquent ORM and Laravel's query builder use <strong>PDO parameterised statements</strong> for all queries. Raw SQL is avoided; when needed, <code>DB::select()</code> uses bound parameters.</p>

                    <div class="cs-code">
<span class="cm">// Safe — Eloquent uses parameterised queries internally</span>
<span class="cl">Destinations</span>::<span class="fn">where</span>(<span class="str">'title'</span>, <span class="str">'like'</span>, <span class="str">"%{$search}%"</span>)-><span class="fn">get</span>();

<span class="cm">// Safe — raw query with bound parameter</span>
<span class="cl">DB</span>::<span class="fn">select</span>(<span class="str">'SELECT VERSION() as v'</span>); <span class="cm">// no user input involved</span>

<span class="cm">// NEVER done — would be vulnerable</span>
<span class="cm">// DB::select("SELECT * FROM users WHERE email = '$email'");</span>
                    </div>
                </div>

                <!-- XSS Prevention -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">6. XSS Prevention</h2>
                    <p>Blade's <strong>double-brace syntax</strong> <code>{{ }}</code> automatically HTML-encodes output. Unescaped output (<code>{!! !!}</code>) is only used for trusted HTML — admin-generated rich text content from the Trix editor.</p>

                    <div class="cs-code">
<span class="cm">&lt;!-- Safe — auto-escaped --&gt;</span>
&lt;h3&gt;{{ '{{' }} $destination->title {{ '}}' }}&lt;/h3&gt;
&lt;p&gt;{{ '{{' }} $review->comment {{ '}}' }}&lt;/p&gt;

<span class="cm">&lt;!-- Trusted admin content only --&gt;</span>
&lt;div class="property-body"&gt;
    {!! $destination->content !!}
&lt;/div&gt;
                    </div>

                    <div class="cs-check">
                        <div class="cs-check-icon warn"><i class="fas fa-exclamation" style="font-size:.6rem;"></i></div>
                        <div style="font-size:.85rem;">The <code>{!! !!}</code> directive is intentionally restricted to <code>$destination->content</code> and <code>$blog->content</code> — both of which are only writeable by authenticated admin users via the Trix rich-text editor.</div>
                    </div>
                </div>

                <!-- Email Verification -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">7. Email Verification</h2>
                    <p>The <code>User</code> model implements Laravel's <code>MustVerifyEmail</code> interface. Unverified users are redirected to the verification notice page and cannot access protected routes.</p>

                    <div class="cs-code">
<span class="kw">class</span> <span class="cl">User</span> <span class="kw">extends</span> <span class="cl">Authenticatable</span>
    <span class="kw">implements</span> <span class="cl">MustVerifyEmail</span>
{
    <span class="cm">// Verification routes registered via:</span>
    <span class="cm">// Auth::routes(['verify' => true]);</span>
}
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="tt-sidebar-card" style="position:sticky;top:90px;">
                    <h6 class="fw-bold mb-3" style="color:var(--tt-primary);font-size:.85rem;text-transform:uppercase;letter-spacing:.06em;">Contents</h6>
                    @foreach([
                        '1. CSRF Protection',
                        '2. Password Hashing',
                        '3. Role-Based Access',
                        '4. Input Validation',
                        '5. SQL Injection Prevention',
                        '6. XSS Prevention',
                        '7. Email Verification',
                    ] as $item)
                    <div style="display:flex;align-items:center;gap:8px;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:.85rem;color:var(--tt-dark);">
                        <i class="fas fa-chevron-right" style="color:var(--tt-accent);font-size:.65rem;"></i>
                        {{ $item }}
                    </div>
                    @endforeach

                    <div class="mt-4 p-3 rounded" style="background:var(--tt-cream);border:1px solid #e5e7eb;">
                        <div style="font-size:.72rem;color:var(--tt-dark-soft);font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem;">
                            <i class="fas fa-info-circle me-1" style="color:var(--tt-accent);"></i>Demo Note
                        </div>
                        <p style="font-size:.75rem;margin:0;">Payment processing is intentionally simulated. No real card data is collected or transmitted. The <code>is_simulated</code> flag is always <code>true</code>.</p>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <h6 class="fw-bold mb-3" style="color:var(--tt-primary);font-size:.85rem;text-transform:uppercase;letter-spacing:.06em;">Other Chapters</h6>
                        <a href="{{ route('case-study.system-integration') }}" class="btn-tt-outline w-100 d-block text-center mb-2" style="font-size:.82rem;">
                            <i class="fas fa-sitemap me-2"></i>System Integration
                        </a>
                        <a href="{{ route('case-study.infrastructure') }}" class="btn-tt-outline w-100 d-block text-center" style="font-size:.82rem;">
                            <i class="fas fa-server me-2"></i>Infrastructure
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
            <a href="{{ route('case-study.system-integration') }}" class="btn-tt-outline">
                <i class="fas fa-arrow-left me-2"></i>Chapter 01: System Integration
            </a>
            <a href="{{ route('case-study.infrastructure') }}" class="btn-tt-primary">
                Chapter 03: Infrastructure <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection
