@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="admin-welcome" style="background:#312e81;">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2><i class="fas fa-server me-2" style="color:#a5b4fc;"></i> IT &amp; Infrastructure Portal</h2>
            <p>System health, technology stack, and deployment information for the France Vacances platform.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <span class="date-badge">
                <i class="fas fa-clock me-1"></i>{{ now()->format('d M Y, H:i') }} UTC
            </span>
        </div>
    </div>
</div>

<!-- Health Checks -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-heart-pulse me-2"></i>System Health</h5>
                <span style="font-size:.75rem;color:var(--admin-text-soft);">Checked at {{ now()->format('H:i:s') }}</span>
            </div>
            <div class="admin-card-body">
                <div class="row g-3">
                    @foreach($health as $name => $check)
                    @php
                        $colour = match($check['status']) {
                            'ok'   => '#22c55e',
                            'warn' => '#f59e0b',
                            default=> '#ef4444',
                        };
                        $icon = match($check['status']) {
                            'ok'   => 'fas fa-check-circle',
                            'warn' => 'fas fa-exclamation-triangle',
                            default=> 'fas fa-times-circle',
                        };
                    @endphp
                    <div class="col-md-4 col-lg">
                        <div style="background:var(--admin-surface);border:1px solid {{ $colour }}30;border-radius:10px;padding:14px 16px;display:flex;align-items:center;gap:12px;">
                            <i class="{{ $icon }}" style="color:{{ $colour }};font-size:1.2rem;flex-shrink:0;"></i>
                            <div>
                                <div style="font-weight:700;font-size:.82rem;text-transform:capitalize;">{{ str_replace('_', ' ', $name) }}</div>
                                <div style="font-size:.72rem;color:var(--admin-text-soft);">{{ $check['label'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left column -->
    <div class="col-lg-8">

        <!-- Tech Stack -->
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5><i class="fas fa-layer-group me-2"></i>Technology Stack</h5>
            </div>
            <div class="admin-card-body">
                <div class="row g-3">
                    @foreach($stack as $tech)
                    <div class="col-md-6 col-lg-4">
                        <div style="background:var(--admin-surface);border:1px solid var(--admin-border);border-radius:10px;padding:14px;display:flex;align-items:center;gap:10px;height:100%;">
                            <div style="width:36px;height:36px;border-radius:8px;background:var(--admin-primary)18;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="{{ $tech['icon'] }}" style="color:var(--admin-primary);font-size:.95rem;"></i>
                            </div>
                            <div class="min-w-0">
                                <div style="font-weight:700;font-size:.82rem;" class="text-truncate">{{ $tech['name'] }}</div>
                                <div style="font-size:.7rem;color:var(--admin-primary);font-family:monospace;">{{ $tech['version'] }}</div>
                                <div style="font-size:.68rem;color:var(--admin-text-soft);">{{ $tech['role'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Database Table Counts -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-database me-2"></i>Database Record Counts</h5>
                <span class="badge-cat" style="font-size:.7rem;">{{ strtoupper($dbStats['driver']) }} · {{ $dbStats['database'] }}</span>
            </div>
            <div class="admin-card-body p-0">
                <table class="admin-table mb-0">
                    <thead>
                        <tr>
                            <th>Table</th>
                            <th class="text-center">Rows</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $tableInfo = [
                            'users'        => 'Registered platform users (customers + admins)',
                            'destinations' => 'Holiday properties (including soft-deleted)',
                            'bookings'     => 'Property booking records',
                            'payments'     => 'Simulated payment transactions',
                            'categories'   => 'French regions / property categories',
                            'tags'         => 'Property feature tags',
                            'reviews'      => 'Guest property reviews',
                            'wishlists'    => 'Saved property entries',
                        ];
                        @endphp
                        @foreach($tableCounts as $table => $count)
                        <tr>
                            <td><code style="font-size:.78rem;">{{ $table }}</code></td>
                            <td class="text-center">
                                <span class="badge bg-primary" style="font-size:.72rem;">{{ $count }}</span>
                            </td>
                            <td style="font-size:.78rem;color:var(--admin-text-soft);">{{ $tableInfo[$table] ?? '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right column -->
    <div class="col-lg-4">
        <!-- System Info -->
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5><i class="fas fa-microchip me-2"></i>System Info</h5>
            </div>
            <div class="admin-card-body">
                @foreach([
                    ['PHP Version',     $system['php_version']],
                    ['Laravel',         $system['laravel_version']],
                    ['Environment',     $system['environment']],
                    ['Debug Mode',      $system['debug_mode']],
                    ['Timezone',        $system['timezone']],
                    ['Locale',          $system['locale']],
                    ['App URL',         $system['app_url']],
                ] as [$label, $value])
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <small class="text-muted">{{ $label }}</small>
                    <code style="font-size:.75rem;background:var(--admin-surface);padding:2px 6px;border-radius:4px;max-width:55%;text-align:right;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        {{ $value }}
                    </code>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Database Config -->
        <div class="admin-card mb-4">
            <div class="admin-card-header">
                <h5><i class="fas fa-database me-2"></i>Database</h5>
            </div>
            <div class="admin-card-body">
                @foreach([
                    ['Driver',   $dbStats['driver']],
                    ['Host',     $dbStats['host']],
                    ['Database', $dbStats['database']],
                    ['Charset',  $dbStats['charset']],
                ] as [$label, $value])
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <small class="text-muted">{{ $label }}</small>
                    <code style="font-size:.75rem;background:var(--admin-surface);padding:2px 6px;border-radius:4px;">{{ $value }}</code>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Deployment Config -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h5><i class="fas fa-rocket me-2"></i>Deployment</h5>
            </div>
            <div class="admin-card-body">
                @foreach([
                    ['Platform',     $deployment['platform']],
                    ['PHP SAPI',     $deployment['php_sapi']],
                    ['OS Family',    $deployment['os']],
                    ['Storage',      $deployment['storage_driver']],
                    ['Session',      $deployment['session_driver']],
                    ['Cache',        $deployment['cache_driver']],
                    ['Queue',        $deployment['queue_driver']],
                    ['Mail',         $deployment['mail_driver']],
                ] as [$label, $value])
                <div class="d-flex justify-content-between align-items-start py-2 border-bottom">
                    <small class="text-muted flex-shrink-0 me-2">{{ $label }}</small>
                    <code style="font-size:.72rem;background:var(--admin-surface);padding:2px 6px;border-radius:4px;text-align:right;word-break:break-all;">{{ $value }}</code>
                </div>
                @endforeach

                <div class="mt-3 p-3 rounded" style="background:#f8f5ef;border:1px solid #e5e7eb;">
                    <div style="font-size:.72rem;color:var(--admin-text-soft);font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;">
                        <i class="fas fa-info-circle me-1"></i>Case Study Note
                    </div>
                    <p style="font-size:.75rem;margin:0;color:#374151;">
                        France Vacances is deployed on <strong>Railway</strong> using <code>nixpacks.toml</code>
                        for zero-config PHP builds. The local dev environment uses XAMPP with Apache + MySQL.
                        All payments are simulated — no real gateway is integrated.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
