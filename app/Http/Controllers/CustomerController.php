<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Destinations;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * GET /account — Customer dashboard hub.
     */
    public function dashboard()
    {
        $user = Auth::user();

        $stats = [
            'bookings'  => Booking::where('user_id', $user->id)->count(),
            'confirmed' => Booking::where('user_id', $user->id)->confirmed()->count(),
            'wishlist'  => $user->wishlist()->count(),
            'reviews'   => $user->reviews()->count(),
        ];

        $nextBooking = Booking::where('user_id', $user->id)
            ->confirmed()
            ->upcoming()
            ->with('destination')
            ->orderBy('check_in_date')
            ->first();

        $recentBookings = Booking::where('user_id', $user->id)
            ->with('destination', 'payment')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        $savedProperties = $user->wishlistedDestinations()
            ->with('category')
            ->orderByDesc('wishlists.created_at')
            ->limit(3)
            ->get();

        return view('customer.dashboard', compact(
            'user', 'stats', 'nextBooking', 'recentBookings', 'savedProperties'
        ));
    }

    /**
     * GET /account/profile — Show customer profile edit form.
     */
    public function profile()
    {
        return view('customer.profile', ['user' => Auth::user()]);
    }

    /**
     * PUT /account/profile — Update customer profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:100'],
            'about'         => ['nullable', 'string', 'max:500'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $validated['profile_photo'] = $request->file('profile_photo')
                ->store('profile_photos', 'public');
        } else {
            unset($validated['profile_photo']);
        }

        $user->update($validated);

        return back()->with('success', 'Your profile has been updated.');
    }

    /**
     * PUT /account/password — Change customer password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }
}
