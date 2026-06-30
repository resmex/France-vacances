<?php

namespace App\Http\Controllers;

use App\Destinations;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Destinations $destination)
    {
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            // Accept 'body' (public form) or 'comment' (admin/API)
            'body'    => 'nullable|string|max:1000',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Normalise to the 'comment' column
        $comment = $validated['body'] ?? $validated['comment'] ?? null;

        $existingReview = Review::where('user_id', auth()->id())
            ->where('destination_id', $destination->id)
            ->first();

        if ($existingReview) {
            $existingReview->update(['rating' => $validated['rating'], 'comment' => $comment]);
            $message = 'Review updated successfully';
        } else {
            Review::create([
                'user_id'        => auth()->id(),
                'destination_id' => $destination->id,
                'rating'         => $validated['rating'],
                'comment'        => $comment,
            ]);
            $message = 'Review submitted successfully';
        }

        session()->flash('success', $message);

        return redirect()->back();
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            abort(403);
        }

        $review->delete();

        session()->flash('success', 'Review deleted successfully');

        return redirect()->back();
    }
}
