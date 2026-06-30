<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Destinations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * POST /packages/destinations/{destination}/book
     * Create a pending booking and redirect to payment.
     */
    public function store(Request $request, Destinations $destination)
    {
        $validated = $request->validate([
            'check_in_date'  => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'guests'         => ['required', 'integer', 'min:1', 'max:' . ($destination->max_guests ?? 20)],
        ]);

        $checkIn  = \Carbon\Carbon::parse($validated['check_in_date']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out_date']);
        $nights   = $checkIn->diffInDays($checkOut);

        if ($nights < 1) {
            return back()->withErrors(['check_out_date' => 'Check-out must be at least one night after check-in.']);
        }

        $pricePerNight = $destination->price_per_night ?? $destination->price;
        $totalPrice    = $nights * $pricePerNight;

        $booking = Booking::create([
            'user_id'        => Auth::id(),
            'destination_id' => $destination->id,
            'travel_date'    => $validated['check_in_date'],
            'check_in_date'  => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'nights'         => $nights,
            'guests'         => $validated['guests'],
            'total_price'    => $totalPrice,
            'status'         => 'pending',
        ]);

        return redirect()->route('payment.checkout', $booking->id)
            ->with('success', 'Booking reserved! Please complete your payment to confirm.');
    }

    /**
     * GET /my-bookings
     * Customer's own booking history.
     */
    public function myBookings(Request $request)
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('destination', 'payment')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('bookings.my-bookings', compact('bookings'));
    }

    // ── Admin ─────────────────────────────────────────────────────────────────

    /**
     * GET /admin/bookings
     */
    public function index(Request $request)
    {
        $query = Booking::with('user', 'destination')->orderByDesc('created_at');

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(20);
        $counts   = [
            'all'       => Booking::count(),
            'pending'   => Booking::pending()->count(),
            'confirmed' => Booking::confirmed()->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'counts'));
    }

    /**
     * GET /admin/bookings/{booking}
     */
    public function show(Booking $booking)
    {
        $booking->load('user', 'destination', 'payment');
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * PUT /admin/bookings/{booking}/status
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled,completed'],
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated to ' . ucfirst($request->status) . '.');
    }
}
