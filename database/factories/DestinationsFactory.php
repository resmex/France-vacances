<?php

namespace Database\Factories;

use App\Category;
use App\Destinations;
use Illuminate\Database\Eloquent\Factories\Factory;

class DestinationsFactory extends Factory
{
    protected $model = Destinations::class;

    public function definition(): array
    {
        $types    = ['Cottage', 'Villa', 'Chalet', 'Apartment'];
        $regions  = ['Provence', 'Dordogne', 'French Alps', 'Paris', 'Côte d\'Azur', 'Loire Valley'];
        $beds     = fake()->numberBetween(1, 6);
        $baths    = fake()->numberBetween(1, $beds);
        $guests   = $beds * 2;
        $type     = fake()->randomElement($types);
        $region   = fake()->randomElement($regions);
        $price    = fake()->numberBetween(150, 2000);

        return [
            'title'           => fake()->words(3, true),
            'description'     => fake()->sentence(14),
            'content'         => fake()->paragraphs(3, true),
            'image'           => 'images/destination-' . fake()->numberBetween(1, 6) . '.jpg',
            'pricing'         => '£' . $price,
            'category_id'     => Category::factory(),
            'published_at'    => now(),
            // Legacy string fields
            'duration'        => $beds . ' Bedrooms',
            'group_size'      => 'Sleeps ' . $guests,
            'tour_type'       => $type,
            // France Vacances fields
            'property_type'   => $type,
            'location'        => fake()->city() . ', ' . $region,
            'region'          => $region,
            'bedrooms'        => $beds,
            'bathrooms'       => $baths,
            'max_guests'      => $guests,
            'price_per_night' => $price,
            'featured'        => false,
            'amenities'       => ['Wi-Fi', 'Parking', 'Fully Equipped Kitchen'],
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'featured' => true,
        ]);
    }
}
