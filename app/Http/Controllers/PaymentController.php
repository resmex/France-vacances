<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Mail\BookingConfirmationMail;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * GET /payment/{booking}
     * Show the simulated payment form.
     */
    public function checkout(Booking $booking)
    {
        // Only the booking owner can pay
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if(! $booking->isPending(), 404, 'This booking is no longer awaiting payment.');

        $booking->load('destination');

        return view('payment.checkout', compact('booking'));
    }

    /**
     * POST /payment/{booking}
     * Process the simulated payment — no real card processing.
     */
    public function process(Request $request, Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);
        abort_if(! $booking->isPending(), 409, 'Booking is no longer pending.');

        $request->validate([
            'name_on_card' => ['required', 'string', 'max:100'],
            'card_number'  => ['required', 'digits:16'],
            'expiry'       => ['required', 'regex:/^\d{2}\/\d{2}$/'],
            'cvv'          => ['required', 'digits_between:3,4'],
        ]);

        // Generate a unique human-readable payment reference
        $reference = 'FV-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        Payment::create([
            'booking_id'   => $booking->id,
            'payment_id'   => $reference,
            'user_email'   => Auth::user()->email,
            'amount'       => $booking->total_price,
            'currency'     => 'GBP',
            'reference'    => $reference,
            'method'       => 'card',
            'status'       => 'completed',
            'is_simulated' => true,
        ]);

        $booking->update(['status' => 'confirmed']);

        // Best-effort confirmation email — failure must not block the user
        try {
            Mail::to(Auth::user()->email)
                ->send(new BookingConfirmationMail($booking->fresh(['destination', 'payment'])));
        } catch (\Exception $e) {
            Log::warning('Booking confirmation email failed: ' . $e->getMessage());
        }

        return redirect()->route('booking.confirmation', $booking->id)
            ->with('success', 'Payment confirmed! Your booking is now secured.');
    }

    /**
     * GET /booking/confirmation/{booking}
     * Show the booking confirmation page.
     */
    public function confirmation(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load('destination', 'payment');

        return view('payment.confirmation', compact('booking'));
    }

    // ── Admin ─────────────────────────────────────────────────────────────────

    /**
     * GET /admin/payments
     */
    public function index(Request $request)
    {
        $payments = Payment::with('booking.user', 'booking.destination')
            ->orderByDesc('created_at')
            ->paginate(20);

        $totalRevenue = Payment::where('status', 'completed')->sum('amount');

        return view('admin.payments.index', compact('payments', 'totalRevenue'));
    }

    /**
     * GET /admin/payments/{payment}
     */
    public function show(Payment $payment)
    {
        $payment->load('booking.user', 'booking.destination');
        return view('admin.payments.show', compact('payment'));
    }
}
