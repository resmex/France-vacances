<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use App\Destinations;
use App\Tag;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            // Redirect search to the properties listing page
            return redirect()->route('packages', ['search' => $search]);
        }

        $featuredProperties = Destinations::published()
            ->featured()
            ->with('category')
            ->orderByDesc('rating_cached')
            ->limit(6)
            ->get();

        $regions = Category::withCount('destinations')->get();

        return view('welcome', [
            'featuredProperties' => $featuredProperties,
            'regions'            => $regions,
            'tags'               => Tag::all(),
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function packages(Request $request)
    {
        $query = Destinations::published()->with('category');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%")
                  ->orWhere('region', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($categoryId = $request->query('category')) {
            $query->where('category_id', $categoryId);
        }

        if ($type = $request->query('type')) {
            $query->where('property_type', $type);
        }

        if ($priceRange = $request->query('price_range')) {
            [$min, $max] = match ($priceRange) {
                '0-200'    => [0, 200],
                '200-500'  => [200, 500],
                '500-1000' => [500, 1000],
                '1000+'    => [1000, 99999],
                default    => [0, 99999],
            };
            $query->whereBetween('price_per_night', [$min, $max]);
        }

        $destinations = $query->orderByDesc('featured')
            ->orderByDesc('rating_cached')
            ->paginate(9);

        return view('packages', [
            'destinations' => $destinations,
            'categories'   => Category::all(),
            'tags'         => Tag::all(),
        ]);
    }

    public function regionShow(Request $request, string $region)
    {
        $category = Category::where('name', $region)->firstOrFail();

        $properties = Destinations::published()
            ->where('category_id', $category->id)
            ->with('category')
            ->orderByDesc('rating_cached')
            ->paginate(9);

        $allRegions = Category::withCount('destinations')->get();

        return view('regions', [
            'region'     => $category,
            'properties' => $properties,
            'allRegions' => $allRegions,
            'tags'       => Tag::all(),
        ]);
    }

    public function blog()
    {
        return view('blog', [
            'blogs'      => Blog::paginate(6),
            'tags'       => Tag::all(),
            'categories' => Category::all(),
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'categories' => Category::all(),
            'tags'       => Tag::all(),
        ]);
    }

    public function cart()
    {
        return view('cart', [
            'destinations' => Destinations::published()->first(),
            'tags'         => Tag::all(),
            'categories'   => Category::all(),
        ]);
    }

    public function checkout()
    {
        return view('checkout', [
            'destinations' => Destinations::published()->first(),
        ]);
    }
}
