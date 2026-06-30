<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Destinations;
use App\Payment;
use App\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings'    => Booking::count(),
            'confirmed'         => Booking::confirmed()->count(),
            'pending'           => Booking::pending()->count(),
            'total_revenue'     => Payment::where('status', 'completed')->sum('amount'),
            'total_properties'  => Destinations::count(),
            'total_guests'      => User::where('role', 'customer')->count(),
        ];

        // Bookings by status breakdown
        $byStatus = Booking::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Top properties by booking count
        $topProperties = Destinations::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->limit(5)
            ->get();

        // Recent bookings
        $recentBookings = Booking::with('user', 'destination')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact('stats', 'byStatus', 'topProperties', 'recentBookings'));
    }
}
