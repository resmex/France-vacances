<?php

namespace App\Http\Controllers;

use App\Category;
use App\Destinations;
use App\Http\Requests\Destinations\CreateDestinationsRequest;
use App\Http\Requests\Destinations\UpdateDestinationsRequest;
use App\Tag;

class DestinationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verifyCategoriesCount')->only(['create', 'store']);
    }

    public function index()
    {
        return view('destinations.index', ['destinations' => Destinations::with('category')->orderByDesc('created_at')->get()]);
    }

    public function create()
    {
        return view('destinations.create', [
            'categories' => Category::orderBy('name')->get(),
            'tags'       => Tag::orderBy('name')->get(),
        ]);
    }

    public function store(CreateDestinationsRequest $request)
    {
        $image = $request->image->store('destinations');

        $destination = Destinations::create([
            'title'           => $request->title,
            'description'     => $request->description,
            'content'         => $request->content,
            'image'           => $image,
            'published_at'    => $request->published_at,
            'category_id'     => $request->category,
            // France Vacances fields
            'property_type'   => $request->property_type,
            'location'        => $request->location,
            'region'          => $request->region,
            'price_per_night' => $request->price_per_night,
            'bedrooms'        => $request->bedrooms,
            'bathrooms'       => $request->bathrooms,
            'max_guests'      => $request->max_guests,
            'amenities'       => $this->parseAmenities($request->amenities),
            'featured'        => $request->boolean('featured'),
            'rating_cached'   => $request->rating_cached,
            // Legacy fields (kept for backwards-compat)
            'pricing'         => $request->pricing,
            'duration'        => $request->duration,
            'group_size'      => $request->group_size,
            'tour_type'       => $request->tour_type,
        ]);

        if ($request->tags) {
            $destination->tags()->attach($request->tags);
        }

        session()->flash('success', 'Property created successfully.');

        return redirect(route('destinations.index'));
    }

    public function show($id)
    {
        //
    }

    public function edit(Destinations $destination)
    {
        return view('destinations.create', [
            'destinations' => $destination,
            'categories'   => Category::orderBy('name')->get(),
            'tags'         => Tag::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateDestinationsRequest $request, Destinations $destination)
    {
        $data = [
            'title'           => $request->title,
            'description'     => $request->description,
            'content'         => $request->content,
            'published_at'    => $request->published_at,
            'category_id'     => $request->category,
            // France Vacances fields
            'property_type'   => $request->property_type,
            'location'        => $request->location,
            'region'          => $request->region,
            'price_per_night' => $request->price_per_night,
            'bedrooms'        => $request->bedrooms,
            'bathrooms'       => $request->bathrooms,
            'max_guests'      => $request->max_guests,
            'amenities'       => $this->parseAmenities($request->amenities),
            'featured'        => $request->boolean('featured'),
            'rating_cached'   => $request->rating_cached,
            // Legacy
            'pricing'         => $request->pricing,
            'duration'        => $request->duration,
            'group_size'      => $request->group_size,
            'tour_type'       => $request->tour_type,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->image->store('destinations');
            $destination->deleteImage();
        }

        if ($request->tags) {
            $destination->tags()->sync($request->tags);
        }

        $destination->update($data);

        session()->flash('success', 'Property updated successfully.');

        return redirect(route('destinations.index'));
    }

    public function destroy($id)
    {
        $destination = Destinations::withTrashed()->where('id', $id)->firstOrFail();

        if ($destination->trashed()) {
            $destination->deleteImage();
            $destination->forceDelete();
        } else {
            $destination->delete();
        }

        session()->flash('success', 'Property deleted successfully.');

        return redirect(route('destinations.index'));
    }

    public function trashed()
    {
        return view('destinations.index', ['destinations' => Destinations::onlyTrashed()->get()]);
    }

    public function restore($id)
    {
        Destinations::withTrashed()->where('id', $id)->firstOrFail()->restore();

        session()->flash('success', 'Property restored successfully.');

        return redirect()->back();
    }

    /**
     * Convert comma-separated amenity string to JSON-encodable array.
     */
    private function parseAmenities(?string $raw): ?array
    {
        if (! $raw) return null;
        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }
}
