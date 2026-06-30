<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Destinations;
use App\Payment;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ItController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        // ── System Info ──────────────────────────────────────────────────────
        $system = [
            'php_version'     => phpversion(),
            'laravel_version' => app()->version(),
            'environment'     => app()->environment(),
            'debug_mode'      => config('app.debug') ? 'ON' : 'OFF',
            'app_url'         => config('app.url'),
            'timezone'        => config('app.timezone'),
            'locale'          => config('app.locale'),
        ];

        // ── Database Info ─────────────────────────────────────────────────────
        $dbDriver = config('database.default');
        $dbConfig = config("database.connections.{$dbDriver}");

        $dbStats = [
            'driver'      => strtoupper($dbDriver),
            'host'        => $dbConfig['host'] ?? 'localhost',
            'database'    => $dbConfig['database'] ?? '—',
            'charset'     => $dbConfig['charset']  ?? '—',
        ];

        // Row counts per table
        $tableCounts = $this->safeTableCounts();

        // ── Health Checks ─────────────────────────────────────────────────────
        $health = [
            'database'   => $this->checkDb(),
            'storage'    => $this->checkStorage(),
            'mail'       => $this->checkMail(),
            'queue'      => $this->checkQueue(),
            'cache'      => $this->checkCache(),
        ];

        // ── Tech Stack ────────────────────────────────────────────────────────
        $stack = [
            ['name' => 'Laravel',             'version' => app()->version(),   'role' => 'PHP Framework',     'icon' => 'fab fa-laravel'],
            ['name' => 'PHP',                 'version' => phpversion(),        'role' => 'Server Language',   'icon' => 'fab fa-php'],
            ['name' => 'MySQL',               'version' => $this->mysqlVersion(),'role' => 'Database',         'icon' => 'fas fa-database'],
            ['name' => 'Bootstrap 5.3',       'version' => '5.3.2',            'role' => 'CSS Framework',     'icon' => 'fab fa-bootstrap'],
            ['name' => 'Font Awesome 6',      'version' => '6.5.1',            'role' => 'Icons',             'icon' => 'fab fa-font-awesome'],
            ['name' => 'Google Fonts',        'version' => 'Inter / Playfair', 'role' => 'Typography',        'icon' => 'fab fa-google'],
            ['name' => 'AOS',                 'version' => '2.3.4',            'role' => 'Scroll Animations', 'icon' => 'fas fa-magic'],
            ['name' => 'Trix Editor',         'version' => '1.2.3',            'role' => 'Rich Text Editor',  'icon' => 'fas fa-pen-nib'],
            ['name' => 'Select2',             'version' => '4.1.0-beta',       'role' => 'Dropdown UI',       'icon' => 'fas fa-list'],
            ['name' => 'Flatpickr',           'version' => '4.x',              'role' => 'Date Picker',       'icon' => 'fas fa-calendar'],
            ['name' => 'Laravel Mix (Vite)',   'version' => 'Mix 6',            'role' => 'Asset Bundler',     'icon' => 'fas fa-box'],
            ['name' => 'ABTA Protection',     'version' => 'Simulated',        'role' => 'Trade Body',        'icon' => 'fas fa-shield-halved'],
        ];

        // ── Deployment Info ───────────────────────────────────────────────────
        $deployment = [
            'platform'       => 'Railway (cloud) / XAMPP (local)',
            'web_server'     => 'Apache / Nginx',
            'php_sapi'       => php_sapi_name(),
            'os'             => PHP_OS_FAMILY,
            'storage_driver' => config('filesystems.default'),
            'session_driver' => config('session.driver'),
            'cache_driver'   => config('cache.default'),
            'queue_driver'   => config('queue.default'),
            'mail_driver'    => config('mail.default'),
        ];

        return view('it.dashboard', compact(
            'system', 'dbStats', 'tableCounts', 'health', 'stack', 'deployment'
        ));
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function checkDb(): array
    {
        try {
            DB::connection()->getPdo();
            return ['status' => 'ok', 'label' => 'Connected'];
        } catch (\Exception $e) {
            return ['status' => 'fail', 'label' => 'Connection failed'];
        }
    }

    private function checkStorage(): array
    {
        $path = storage_path('app');
        if (is_writable($path)) {
            return ['status' => 'ok', 'label' => 'Writable'];
        }
        return ['status' => 'fail', 'label' => 'Not writable'];
    }

    private function checkMail(): array
    {
        $driver = config('mail.default', 'smtp');
        if ($driver === 'log') {
            return ['status' => 'warn', 'label' => 'Log driver (dev)'];
        }
        $host = config('mail.mailers.smtp.host', '');
        if (empty($host)) {
            return ['status' => 'warn', 'label' => 'Not configured'];
        }
        return ['status' => 'ok', 'label' => ucfirst($driver)];
    }

    private function checkQueue(): array
    {
        $driver = config('queue.default', 'sync');
        return ['status' => 'ok', 'label' => ucfirst($driver) . ' driver'];
    }

    private function checkCache(): array
    {
        try {
            cache()->put('_it_health', true, 5);
            $ok = cache()->get('_it_health');
            return $ok
                ? ['status' => 'ok',   'label' => ucfirst(config('cache.default')) . ' driver']
                : ['status' => 'warn', 'label' => 'Cache miss'];
        } catch (\Exception $e) {
            return ['status' => 'fail', 'label' => 'Cache failed'];
        }
    }

    private function mysqlVersion(): string
    {
        try {
            $row = DB::select('SELECT VERSION() as v');
            return $row[0]->v ?? '—';
        } catch (\Exception $e) {
            return '—';
        }
    }

    private function safeTableCounts(): array
    {
        $tables = [
            'users'        => fn() => User::count(),
            'destinations' => fn() => Destinations::withTrashed()->count(),
            'bookings'     => fn() => Booking::count(),
            'payments'     => fn() => Payment::count(),
            'categories'   => fn() => \App\Category::count(),
            'tags'         => fn() => \App\Tag::count(),
            'reviews'      => fn() => \App\Review::count(),
            'wishlists'    => fn() => \App\Wishlist::count(),
        ];

        $result = [];
        foreach ($tables as $name => $fn) {
            try {
                $result[$name] = $fn();
            } catch (\Exception $e) {
                $result[$name] = '—';
            }
        }
        return $result;
    }
}
