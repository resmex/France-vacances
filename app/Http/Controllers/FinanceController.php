<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Destinations;
use App\Payment;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        // High-level revenue stats
        $totalRevenue    = Payment::where('status', 'completed')->sum('amount');
        $thisMonthRev    = Payment::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at',  now()->year)
            ->sum('amount');
        $lastMonthRev    = Payment::where('status', 'completed')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at',  now()->subMonth()->year)
            ->sum('amount');
        $thisWeekRev     = Payment::where('status', 'completed')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('amount');

        $pendingValue    = Booking::pending()->sum('total_price');
        $avgBookingValue = Booking::confirmed()->avg('total_price') ?? 0;
        $totalBookings   = Booking::count();
        $confirmedCount  = Booking::confirmed()->count();

        // Monthly revenue — last 12 months
        $monthlyRevenue = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $rev  = Payment::where('status', 'completed')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at',  $date->year)
                ->sum('amount');
            $monthlyRevenue->push([
                'label'   => $date->format('M Y'),
                'revenue' => (float) $rev,
            ]);
        }
        $monthlyMax = $monthlyRevenue->max('revenue') ?: 1;

        // Revenue by property type
        $byType = Booking::confirmed()
            ->join('destinations', 'bookings.destination_id', '=', 'destinations.id')
            ->select('destinations.property_type',
                     DB::raw('SUM(bookings.total_price) as revenue'),
                     DB::raw('COUNT(*) as count'))
            ->groupBy('destinations.property_type')
            ->orderByDesc('revenue')
            ->get();

        // Revenue by region (category)
        $byRegion = Booking::confirmed()
            ->join('destinations', 'bookings.destination_id', '=', 'destinations.id')
            ->join('categories', 'destinations.category_id', '=', 'categories.id')
            ->select('categories.name as region',
                     DB::raw('SUM(bookings.total_price) as revenue'),
                     DB::raw('COUNT(*) as count'))
            ->groupBy('categories.name')
            ->orderByDesc('revenue')
            ->get();

        // Top 5 properties by revenue
        $topProperties = Booking::confirmed()
            ->join('destinations', 'bookings.destination_id', '=', 'destinations.id')
            ->select('destinations.title', 'destinations.property_type',
                     DB::raw('SUM(bookings.total_price) as revenue'),
                     DB::raw('COUNT(*) as bookings'))
            ->groupBy('destinations.id', 'destinations.title', 'destinations.property_type')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        // Recent payments
        $recentPayments = Payment::with('booking.destination', 'booking.user')
            ->latest()
            ->limit(10)
            ->get();

        $stats = compact(
            'totalRevenue', 'thisMonthRev', 'lastMonthRev',
            'thisWeekRev', 'pendingValue', 'avgBookingValue',
            'totalBookings', 'confirmedCount'
        );

        return view('finance.dashboard', compact(
            'stats', 'monthlyRevenue', 'monthlyMax',
            'byType', 'byRegion', 'topProperties', 'recentPayments'
        ));
    }
}
