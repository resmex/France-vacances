<?php

namespace App\Http\Controllers;

use App\Destinations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wishlisted = auth()->user()
            ->wishlistedDestinations()
            ->with('category')
            ->paginate(12);

        return view('wishlist.index', compact('wishlisted'));
    }

    public function toggle(Request $request, Destinations $destination): JsonResponse
    {
        $isWishlisted = auth()->user()->toggleWishlist($destination);

        return response()->json([
            'wishlisted' => $isWishlisted,
            'message' => $isWishlisted ? 'Property saved.' : 'Property removed from saved properties.',
        ]);
    }

    public function store(Destinations $destination)
    {
        if (! auth()->user()->hasWishlisted($destination)) {
            auth()->user()->wishlist()->create([
                'destination_id' => $destination->id,
            ]);
            session()->flash('success', 'Property saved.');
        }

        return redirect()->back();
    }

    public function destroy(Destinations $destination)
    {
        auth()->user()->wishlist()
            ->where('destination_id', $destination->id)
            ->delete();

        session()->flash('success', 'Property removed from saved properties.');

        return redirect()->back();
    }
}
