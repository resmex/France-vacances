<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Destinations;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        // All properties with booking aggregates
        $properties = Destinations::withCount('bookings')
            ->with('category')
            ->orderByDesc('bookings_count')
            ->get()
            ->map(function ($dest) {
                $dest->bookings_revenue = Booking::where('destination_id', $dest->id)
                    ->confirmed()
                    ->sum('total_price');
                $dest->pending_count = Booking::where('destination_id', $dest->id)
                    ->pending()
                    ->count();
                return $dest;
            });

        // Upcoming confirmed bookings (next 90 days)
        $upcomingBookings = Booking::confirmed()
            ->upcoming()
            ->with('user', 'destination')
            ->orderBy('check_in_date')
            ->limit(10)
            ->get();

        // Owner-level revenue totals
        $stats = [
            'total_properties'   => $properties->count(),
            'active_bookings'    => Booking::confirmed()->count(),
            'pending_bookings'   => Booking::pending()->count(),
            'total_revenue'      => Booking::confirmed()->sum('total_price'),
            'this_month_revenue' => Booking::confirmed()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total_price'),
            'avg_nightly_rate'   => $properties->avg('price_per_night'),
        ];

        // Top property by revenue
        $topProperty = $properties->sortByDesc('bookings_revenue')->first();

        // Occupancy by property type
        $typeRevenue = $properties->groupBy('property_type')->map(function ($group) {
            return [
                'count'   => $group->count(),
                'revenue' => $group->sum('bookings_revenue'),
            ];
        });

        return view('owner.dashboard', compact(
            'properties', 'upcomingBookings', 'stats', 'topProperty', 'typeRevenue'
        ));
    }
}
