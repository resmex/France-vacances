@extends('layouts.front')

@section('title', 'Infrastructure Case Study — France Vacances')

@push('styles')
<style>
.cs-code { background:#0f172a; color:#e2e8f0; border-radius:10px; padding:1.25rem 1.5rem; font-family:'Courier New',monospace; font-size:.8rem; line-height:1.7; overflow-x:auto; margin-bottom:1rem; }
.cs-code .kw  { color:#93c5fd; }
.cs-code .fn  { color:#34d399; }
.cs-code .str { color:#fbbf24; }
.cs-code .cm  { color:#64748b; font-style:italic; }
.cs-code .cl  { color:#f9a8d4; }
.cs-section   { border-left:3px solid var(--tt-accent); padding-left:1.25rem; margin-bottom:2.5rem; }
.cs-env-row   { display:flex;justify-content:space-between;align-items:center;padding:.6rem 0;border-bottom:1px solid #f0f0f0;font-size:.82rem; }
.cs-env-key   { font-family:monospace;color:var(--tt-primary);font-size:.78rem; }
.cs-env-val   { font-family:monospace;background:#f8f5ef;padding:2px 8px;border-radius:4px;font-size:.75rem;color:#374151; }
.cs-pipeline-step { background:var(--tt-cream);border:1px solid #e5e7eb;border-radius:10px;padding:1rem;position:relative; }
.cs-pipeline-arrow { text-align:center;color:var(--tt-accent);font-size:1.2rem;margin:.4rem 0; }
</style>
@endpush

@section('page')
@include('partials.navbar')

<section class="tt-page-hero tt-page-hero-sm" style="background-image:url('{{ asset('images/image_3.jpg') }}');">
    <div class="container">
        <span style="background:#818cf8;color:#fff;padding:4px 14px;border-radius:8px;font-size:.75rem;font-weight:700;text-transform:uppercase;">Chapter 03</span>
        <h1 class="tt-page-title mt-2">Infrastructure &amp; <span class="accent">Deployment</span></h1>
        <p class="tt-page-subtitle">From local XAMPP development to Railway cloud hosting.</p>
    </div>
</section>

<section class="tt-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">

                <!-- Two environments -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">Two Environments</h2>
                    <p>France Vacances runs in two distinct environments — a local development stack and a cloud production platform:</p>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div style="border:1px solid #082B4C30;border-radius:12px;padding:1.5rem;height:100%;">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:1rem;">
                                    <div style="width:40px;height:40px;border-radius:10px;background:#082B4C;display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-laptop-code" style="color:var(--tt-accent);"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight:700;color:var(--tt-primary);">Local — XAMPP</div>
                                        <div style="font-size:.72rem;color:var(--tt-dark-soft);">Windows 11 / macOS / Linux</div>
                                    </div>
                                </div>
                                @foreach(['Apache 2.4', 'PHP 8.2+', 'MySQL 8.0', 'phpMyAdmin', 'Composer', 'Node.js + npm (Mix)'] as $item)
                                <div style="display:flex;align-items:center;gap:8px;font-size:.82rem;margin-bottom:.35rem;">
                                    <i class="fas fa-circle" style="color:var(--tt-accent);font-size:.35rem;"></i>{{ $item }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="border:1px solid #6d28d930;border-radius:12px;padding:1.5rem;height:100%;">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:1rem;">
                                    <div style="width:40px;height:40px;border-radius:10px;background:#1e1b4b;display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-cloud" style="color:#a5b4fc;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight:700;color:#1e1b4b;">Production — Railway</div>
                                        <div style="font-size:.72rem;color:var(--tt-dark-soft);">Cloud PaaS, auto-deploy from GitHub</div>
                                    </div>
                                </div>
                                @foreach(['Railway PaaS platform', 'nixpacks auto-build', 'MySQL plugin (Railway)', 'Nginx (auto-configured)', 'PHP 8.2 runtime', 'GitHub → Railway CI/CD'] as $item)
                                <div style="display:flex;align-items:center;gap:8px;font-size:.82rem;margin-bottom:.35rem;">
                                    <i class="fas fa-circle" style="color:#818cf8;font-size:.35rem;"></i>{{ $item }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- nixpacks -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">nixpacks.toml — Zero-Config Build</h2>
                    <p>Railway uses <strong>nixpacks</strong> to detect and build the application automatically. A <code>nixpacks.toml</code> file overrides defaults where needed to ensure PHP extensions and build steps run correctly.</p>

                    <div class="cs-code">
<span class="cm"># nixpacks.toml</span>
[phases.setup]
nixPkgs = [<span class="str">"php82"</span>, <span class="str">"php82Extensions.pdo"</span>, <span class="str">"php82Extensions.pdo_mysql"</span>,
           <span class="str">"php82Extensions.mbstring"</span>, <span class="str">"php82Extensions.tokenizer"</span>,
           <span class="str">"php82Extensions.xml"</span>, <span class="str">"php82Extensions.ctype"</span>,
           <span class="str">"php82Extensions.fileinfo"</span>, <span class="str">"php82Extensions.gd"</span>,
           <span class="str">"nodejs_18"</span>, <span class="str">"nodePackages.npm"</span>]

[phases.install]
cmds = [
    <span class="str">"composer install --no-dev --optimize-autoloader"</span>,
    <span class="str">"npm ci"</span>,
    <span class="str">"npm run production"</span>,
]

[phases.build]
cmds = [
    <span class="str">"php artisan config:cache"</span>,
    <span class="str">"php artisan route:cache"</span>,
    <span class="str">"php artisan view:cache"</span>,
]

[start]
cmd = <span class="str">"php artisan serve --host=0.0.0.0 --port=$PORT"</span>
                    </div>

                    <p style="font-size:.85rem;color:var(--tt-dark-soft);">
                        The build compiles assets with Laravel Mix (<code>npm run production</code>), caches routes and views for production performance, and starts the PHP development server bound to Railway's dynamic <code>$PORT</code>.
                    </p>
                </div>

                <!-- CI/CD Pipeline -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">CI/CD Pipeline</h2>
                    <p>Code changes push through a three-stage pipeline from developer machine to live production:</p>

                    <div class="mb-4">
                        @foreach([
                            ['fas fa-code-branch', '#082B4C', 'Developer', 'Code written locally on XAMPP. Laravel Mix builds CSS/JS. PHP unit and feature tests run via <code>php artisan test</code>.'],
                            ['fab fa-github',      '#1f2937', 'GitHub',    'Push to <code>main</code> branch triggers Railway\'s webhook. Pull requests can be reviewed before merge. GitHub Actions optionally runs PHPUnit tests on push.'],
                            ['fas fa-train',       '#7c3aed', 'Railway',   'nixpacks detects a PHP project, runs the install and build phases, then deploys the new release. Previous deployment is kept for instant rollback. Zero-downtime re-deploy.'],
                            ['fas fa-globe',       '#065f46', 'Live',      'Railway assigns a public HTTPS URL. MySQL database persists between deploys. Environment variables set in the Railway dashboard — never committed to Git.'],
                        ] as [$icon, $colour, $stage, $desc])
                        <div class="cs-pipeline-step mb-0">
                            <div class="d-flex align-items-center gap-3 mb-1">
                                <div style="width:32px;height:32px;border-radius:8px;background:{{ $colour }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="{{ $icon }}" style="color:#fff;font-size:.85rem;"></i>
                                </div>
                                <strong style="font-size:.9rem;color:{{ $colour }};">{{ $stage }}</strong>
                            </div>
                            <p style="font-size:.82rem;color:var(--tt-dark-soft);margin:0;padding-left:44px;">{!! $desc !!}</p>
                        </div>
                        @if(!$loop->last)
                        <div class="cs-pipeline-arrow"><i class="fas fa-arrow-down"></i></div>
                        @endif
                        @endforeach
                    </div>
                </div>

                <!-- Environment Variables -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">Environment Variables</h2>
                    <p>All environment-specific configuration is stored in <code>.env</code> (local) or Railway environment variables (production). The <code>.env</code> file is <strong>never committed to Git</strong> — only <code>.env.example</code> is versioned.</p>

                    <div class="cs-code">
<span class="cm"># .env.example — committed (safe template)</span>
APP_NAME=<span class="str">"France Vacances"</span>
APP_ENV=<span class="kw">local</span>
APP_DEBUG=<span class="kw">true</span>
APP_URL=http://localhost

DB_CONNECTION=<span class="kw">mysql</span>
DB_HOST=<span class="str">127.0.0.1</span>
DB_PORT=<span class="str">3306</span>
DB_DATABASE=<span class="str">tours_travel</span>
DB_USERNAME=<span class="str">root</span>
DB_PASSWORD=

MAIL_MAILER=<span class="kw">log</span>          <span class="cm"># log driver in dev, SMTP in prod</span>
FILESYSTEM_DISK=<span class="kw">public</span>

SESSION_DRIVER=<span class="kw">file</span>
QUEUE_CONNECTION=<span class="kw">sync</span>
CACHE_STORE=<span class="kw">file</span>
                    </div>

                    <div style="background:#fef9c3;border:1px solid #fde68a;border-radius:8px;padding:.9rem 1rem;font-size:.82rem;margin-top:.75rem;">
                        <i class="fas fa-exclamation-triangle me-2" style="color:#d97706;"></i>
                        <strong>Production note:</strong> On Railway, <code>APP_KEY</code>, <code>DB_*</code> credentials, and <code>MAIL_*</code> settings are set as environment variables in the Railway dashboard — never hard-coded.
                    </div>
                </div>

                <!-- Database migrations -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">Database & Migrations</h2>
                    <p>France Vacances uses <strong>17 migrations</strong> to version-control the database schema. The Railway MySQL plugin provides a managed database with automatic backups.</p>

                    <div class="row g-2 mb-4">
                        @foreach([
                            ['2014_10_12', 'create_users_table',             'Core user authentication'],
                            ['2019_08_19', 'create_failed_jobs_table',       'Queue failure tracking'],
                            ['2019_12_14', 'create_personal_access_tokens',  'Sanctum API tokens'],
                            ['2020_xx_xx', 'create_destinations_table',      'Property listings core'],
                            ['2020_xx_xx', 'create_categories_table',        'Region/category grouping'],
                            ['2020_xx_xx', 'create_tags + pivot tables',     'Tagging system'],
                            ['2020_xx_xx', 'create_blogs_table',             'Blog posts'],
                            ['2020_xx_xx', 'create_reviews_table',           'Guest reviews'],
                            ['2020_xx_xx', 'create_wishlists_table',         'Saved properties'],
                            ['2020_xx_xx', 'create_bookings_table',          'Booking records'],
                            ['2020_xx_xx', 'create_payments_table',          'Payment records'],
                            ['2026_06_28', 'add_availability_fields',        'Check-in/out dates on bookings'],
                            ['2026_06_28', 'create_payments (FV columns)',   'Reference, method, is_simulated'],
                            ['2026_06_30', 'add_france_vacances_fields',     'property_type, bedrooms, amenities JSON…'],
                        ] as [$date, $migration, $desc])
                        <div class="col-12">
                            <div style="background:var(--tt-cream);border:1px solid #e5e7eb;border-radius:6px;padding:.55rem 1rem;display:flex;align-items:center;gap:12px;">
                                <code style="font-size:.68rem;color:var(--tt-dark-soft);flex-shrink:0;white-space:nowrap;">{{ $date }}</code>
                                <code style="font-size:.72rem;color:var(--tt-primary);">{{ $migration }}</code>
                                <span style="font-size:.72rem;color:var(--tt-dark-soft);margin-left:auto;">{{ $desc }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="cs-code">
<span class="cm"># Deploy commands (run on Railway or manually)</span>
php artisan <span class="fn">migrate</span> --force       <span class="cm"># run pending migrations</span>
php artisan <span class="fn">db:seed</span>               <span class="cm"># seed France Vacances properties</span>
php artisan <span class="fn">storage:link</span>          <span class="cm"># link public/storage → storage/app/public</span>
php artisan <span class="fn">config:cache</span>          <span class="cm"># cache env config for performance</span>
php artisan <span class="fn">route:cache</span>           <span class="cm"># cache route list for performance</span>
                    </div>
                </div>

                <!-- File Storage -->
                <div class="cs-section">
                    <h2 class="fw-bold mb-3" style="color:var(--tt-primary);">File Storage</h2>
                    <p>Property images are stored using Laravel's <strong>public disk</strong> (<code>storage/app/public/destinations/</code>). The <code>php artisan storage:link</code> command creates a symlink from <code>public/storage</code> to <code>storage/app/public</code>, making uploads accessible via the web.</p>

                    <div class="cs-code">
<span class="cm">// DestinationsController — store image on upload</span>
$image = $request->image-><span class="fn">store</span>(<span class="str">'destinations'</span>);
<span class="cm">// Stored at: storage/app/public/destinations/filename.jpg</span>
<span class="cm">// Public URL: /storage/destinations/filename.jpg</span>

<span class="cm">// Destinations model — image_url accessor</span>
<span class="kw">public function</span> <span class="fn">getImageUrlAttribute</span>(): <span class="cl">string</span>
{
    <span class="kw">return</span> $this->image
        ? <span class="fn">asset</span>(<span class="str">'storage/'</span> . $this->image)
        : <span class="fn">asset</span>(<span class="str">'images/destination-1.jpg'</span>); <span class="cm">// fallback</span>
}
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="tt-sidebar-card mb-4" style="position:sticky;top:90px;">
                    <h6 class="fw-bold mb-3" style="color:var(--tt-primary);font-size:.85rem;text-transform:uppercase;letter-spacing:.06em;">Contents</h6>
                    @foreach([
                        'Two Environments',
                        'nixpacks.toml Build',
                        'CI/CD Pipeline',
                        'Environment Variables',
                        'Database & Migrations',
                        'File Storage',
                    ] as $item)
                    <div style="display:flex;align-items:center;gap:8px;padding:8px 0;border-bottom:1px solid #f0f0f0;font-size:.85rem;color:var(--tt-dark);">
                        <i class="fas fa-chevron-right" style="color:var(--tt-accent);font-size:.65rem;"></i>
                        {{ $item }}
                    </div>
                    @endforeach

                    <!-- System summary card -->
                    <div class="mt-4 p-3 rounded" style="background:var(--tt-primary);">
                        <div style="color:var(--tt-accent);font-weight:700;font-size:.78rem;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.75rem;">
                            <i class="fas fa-server me-1"></i>Live Stack
                        </div>
                        @foreach([
                            ['Platform',  'Railway PaaS'],
                            ['Language',  'PHP 8.2+'],
                            ['Framework', 'Laravel 11'],
                            ['Database',  'MySQL 8'],
                            ['Build',     'nixpacks'],
                            ['Assets',    'Laravel Mix'],
                            ['Storage',   'Public disk'],
                        ] as [$k, $v])
                        <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid rgba(255,255,255,.1);font-size:.78rem;">
                            <span style="color:rgba(255,255,255,.55);">{{ $k }}</span>
                            <span style="color:#fff;font-weight:600;">{{ $v }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <h6 class="fw-bold mb-3" style="color:var(--tt-primary);font-size:.85rem;text-transform:uppercase;letter-spacing:.06em;">Other Chapters</h6>
                        <a href="{{ route('case-study.system-integration') }}" class="btn-tt-outline w-100 d-block text-center mb-2" style="font-size:.82rem;">
                            <i class="fas fa-sitemap me-2"></i>System Integration
                        </a>
                        <a href="{{ route('case-study.security') }}" class="btn-tt-outline w-100 d-block text-center" style="font-size:.82rem;">
                            <i class="fas fa-shield-halved me-2"></i>Security
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
            <a href="{{ route('case-study.security') }}" class="btn-tt-outline">
                <i class="fas fa-arrow-left me-2"></i>Chapter 02: Security
            </a>
            <a href="{{ route('case-study.index') }}" class="btn-tt-primary">
                Back to Case Study Index <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

@include('partials.footer')
@endsection
