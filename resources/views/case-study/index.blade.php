@extends('layouts.front')

@section('title', 'Case Study — France Vacances Technical Documentation')

@section('page')
@include('partials.navbar')

<section class="tt-page-hero" style="background-image:url('{{ asset('images/bg_3.jpg') }}');">
    <div class="container">
        <h1 class="tt-page-title">France Vacances<br><span class="accent">System Documentation</span></h1>
        <p class="tt-page-subtitle">
            A case study of the France Vacances holiday booking platform, covering
            system architecture, security design, and hosting infrastructure.
        </p>
    </div>
</section>

<!-- Overview -->
<section class="tt-section">
    <div class="container">
        <div class="row g-4 align-items-center mb-5">
            <div class="col-lg-6">
                <h2 class="tt-title">A Full-Stack Laravel 11<br><span class="accent">Holiday Platform</span></h2>
                <p class="tt-body-text">
                    France Vacances is a fully functional self-catering holiday rental system built on
                    <strong>Laravel 11</strong> with PHP 8.2+. It demonstrates real-world patterns including
                    multi-role authentication, simulated payment processing, RESTful APIs, and cloud deployment.
                </p>
                <p class="tt-body-text">
                    The platform manages <strong>6 French holiday properties</strong> across Provence,
                    Côte d'Azur, Dordogne, French Alps, Loire Valley, and Paris — with full booking,
                    review, and wishlist functionality for customers.
                </p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    @foreach(['Laravel 11', 'PHP 8.2', 'MySQL 8', 'Bootstrap 5.3', 'Railway', 'REST API'] as $tag)
                    <span style="background:var(--tt-cream);border:1px solid #e5e7eb;padding:4px 12px;border-radius:50px;font-size:.78rem;font-weight:600;color:var(--tt-dark);">
                        {{ $tag }}
                    </span>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tt-sidebar-card" style="background:var(--tt-primary);color:#fff;">
                    <h5 style="color:var(--tt-accent);margin-bottom:1.25rem;font-family:'Playfair Display',serif;">Platform at a Glance</h5>
                    @foreach([
                        ['fas fa-home',          '6 Holiday Properties',          'Across 6 French regions'],
                        ['fas fa-user-shield',   'Multi-role Auth',               'Admin, Customer, Owner, Finance, IT'],
                        ['fas fa-calendar-alt',  'Full Booking Flow',             'Search → Detail → Book → Pay → Confirm'],
                        ['fas fa-credit-card',   'Simulated Payments',            'No real gateway — demo safe'],
                        ['fas fa-code',          'REST API',                      '/api/v1/destinations with JSON'],
                        ['fas fa-cloud',         'Cloud Deployed',                'Railway with nixpacks auto-build'],
                        ['fas fa-shield-halved', 'Security',                     'CSRF, XSS, bcrypt, FormRequests'],
                        ['fas fa-heart',         'Wishlist & Reviews',           'Customer engagement features'],
                    ] as [$icon, $title, $sub])
                    <div class="d-flex align-items-center gap-3 py-2 border-bottom border-white border-opacity-10">
                        <i class="{{ $icon }}" style="color:var(--tt-accent);width:18px;flex-shrink:0;"></i>
                        <div>
                            <div style="font-weight:600;font-size:.87rem;">{{ $title }}</div>
                            <div style="font-size:.72rem;opacity:.65;">{{ $sub }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Three Case Study Cards -->
        <div class="tt-section-header text-center mb-4">
            <h2 class="tt-title">Case Study <span class="accent">Chapters</span></h2>
        </div>

        <div class="row g-4">
            @php
            $chapters = [
                [
                    'route'   => 'case-study.system-integration',
                    'icon'    => 'fas fa-sitemap',
                    'colour'  => '#082B4C',
                    'number'  => '01',
                    'title'   => 'System Integration',
                    'sub'     => 'Architecture & Data Flow',
                    'desc'    => 'How the MVC layers connect — Eloquent models, controllers, Blade views, and the REST API. Includes the booking flow, search engine, email notifications, and database schema.',
                    'topics'  => ['MVC Architecture', 'Database Schema', 'Booking Flow', 'REST API', 'Email Notifications', 'Search & Filters'],
                ],
                [
                    'route'   => 'case-study.security',
                    'icon'    => 'fas fa-shield-halved',
                    'colour'  => '#065f46',
                    'number'  => '02',
                    'title'   => 'Security',
                    'sub'     => 'Protection & Access Control',
                    'desc'    => 'Security layers built into the platform — from CSRF tokens and bcrypt hashing to role-based middleware, Form Request validation, Eloquent SQL injection prevention, and Blade XSS escaping.',
                    'topics'  => ['CSRF Protection', 'bcrypt Hashing', 'Role-Based Access', 'Form Requests', 'SQL Injection Prevention', 'XSS Escaping'],
                ],
                [
                    'route'   => 'case-study.infrastructure',
                    'icon'    => 'fas fa-server',
                    'colour'  => '#1e1b4b',
                    'number'  => '03',
                    'title'   => 'Infrastructure',
                    'sub'     => 'Deployment & Hosting',
                    'desc'    => 'Local XAMPP development environment versus Railway cloud deployment. Covers nixpacks zero-config builds, environment variable management, MySQL configuration, and the CI/CD pipeline.',
                    'topics'  => ['XAMPP Local Dev', 'Railway Cloud', 'nixpacks Build', 'MySQL Config', 'Environment Vars', 'CI/CD Pipeline'],
                ],
            ];
            @endphp

            @foreach($chapters as $ch)
            <div class="col-lg-4">
                <div class="tt-sidebar-card h-100" style="border-top:4px solid {{ $ch['colour'] }};padding:2rem;">
                    <div style="display:flex;align-items:center;gap:14px;margin-bottom:1.5rem;">
                        <div style="width:52px;height:52px;border-radius:14px;background:{{ $ch['colour'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="{{ $ch['icon'] }}" style="color:var(--tt-accent);font-size:1.3rem;"></i>
                        </div>
                        <div>
                            <div style="font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:{{ $ch['colour'] }};opacity:.6;">Chapter {{ $ch['number'] }}</div>
                            <h4 style="margin:0;font-weight:700;color:var(--tt-dark);">{{ $ch['title'] }}</h4>
                            <div style="font-size:.78rem;color:var(--tt-dark-soft);">{{ $ch['sub'] }}</div>
                        </div>
                    </div>
                    <p style="color:var(--tt-dark-soft);font-size:.88rem;line-height:1.65;margin-bottom:1.5rem;">{{ $ch['desc'] }}</p>
                    <div class="d-flex flex-wrap gap-1 mb-4">
                        @foreach($ch['topics'] as $topic)
                        <span style="background:{{ $ch['colour'] }}12;color:{{ $ch['colour'] }};border:1px solid {{ $ch['colour'] }}30;padding:3px 10px;border-radius:50px;font-size:.7rem;font-weight:600;">
                            {{ $topic }}
                        </span>
                        @endforeach
                    </div>
                    <a href="{{ route($ch['route']) }}" class="btn-tt-primary w-100 text-center d-block">
                        Read Chapter {{ $ch['number'] }} <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@include('partials.footer')
@endsection
