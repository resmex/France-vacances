<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Booking;
use App\Category;
use App\Destinations;
use App\Payment;
use App\Tag;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Non-admin users are redirected to their role-appropriate dashboard
        $user = auth()->user();
        if (! $user->isAdmin()) {
            return redirect()->route($user->dashboardRoute());
        }

        $stats = [
            'destinations'    => Destinations::count(),
            'categories'      => Category::count(),
            'blogs'           => Blog::count(),
            'users'           => User::count(),
            'bookings_total'  => Booking::count(),
            'bookings_pending'=> Booking::pending()->count(),
            'revenue'         => Payment::where('status', 'completed')->sum('amount'),
            'confirmed'       => Booking::confirmed()->count(),
        ];

        $recentDestinations = Destinations::latest()->take(5)->get();
        $recentBookings     = Booking::with('user', 'destination')->latest()->take(6)->get();
        $recentBlogs        = Blog::latest()->take(3)->get();
        $latestUsers        = User::latest()->take(5)->get();

        return view('home', compact('stats', 'recentDestinations', 'recentBookings', 'recentBlogs', 'latestUsers'));
    }
}
