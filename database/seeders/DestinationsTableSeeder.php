<?php

namespace Database\Seeders;

use App\Category;
use App\Destinations;
use App\Tag;
use Illuminate\Database\Seeder;

class DestinationsTableSeeder extends Seeder
{
    public function run()
    {
        // ── Regions (used as categories) ───────────────────────────────────────
        $provence    = Category::create(['name' => 'Provence']);
        $dordogne    = Category::create(['name' => 'Dordogne']);
        $alps        = Category::create(['name' => 'French Alps']);
        $paris       = Category::create(['name' => 'Paris']);
        $cotedazur   = Category::create(['name' => 'Côte d\'Azur']);
        $loirevalley = Category::create(['name' => 'Loire Valley']);

        // ── Tags ──────────────────────────────────────────────────────────────
        $tagPool     = Tag::create(['name' => 'Private Pool']);
        $tagVilla    = Tag::create(['name' => 'Villa']);
        $tagCottage  = Tag::create(['name' => 'Cottage']);
        $tagChalet   = Tag::create(['name' => 'Chalet']);
        $tagApart    = Tag::create(['name' => 'Apartment']);
        $tagSki      = Tag::create(['name' => 'Ski In / Ski Out']);
        $tagFamilies = Tag::create(['name' => 'Family Friendly']);
        $tagSea      = Tag::create(['name' => 'Sea View']);
        $tagLuxury   = Tag::create(['name' => 'Luxury']);
        $tagGarden   = Tag::create(['name' => 'Garden']);

        // ── Properties ────────────────────────────────────────────────────────

        // 1. Mas des Oliviers — Provence
        $p1 = Destinations::create([
            'title'          => 'Mas des Oliviers',
            'description'    => 'A comfortable farmhouse in Provence with three bedrooms, a private pool and a garden with olive trees.',
            'content'        => "Mas des Oliviers is an old farmhouse in the Luberon area of Provence. It has stone walls, wooden beams and modern comforts such as a full kitchen, Wi-Fi and air conditioning.\n\nOutside, there is a private heated pool with a view over lavender fields towards the village of Gordes. There is also a shaded terrace for eating outside and a garden with a wall around it.\n\nThe house has three bedrooms and two bathrooms, and it sleeps up to six guests. It suits families or groups of friends. The Gordes market, the Roussillon cliffs and Sénanque Abbey are all nearby.",
            'category_id'    => $provence->id,
            'image'          => 'images/destination-1.jpg',
            'published_at'   => now(),
            // Legacy string fields
            'pricing'        => '£285',
            'duration'       => '3 Bedrooms',
            'group_size'     => 'Sleeps 6',
            'tour_type'      => 'Cottage',
            // New France Vacances fields
            'property_type'  => 'Cottage',
            'location'       => 'Gordes, Provence',
            'region'         => 'Provence',
            'bedrooms'       => 3,
            'bathrooms'      => 2,
            'max_guests'     => 6,
            'price_per_night' => 285.00,
            'rating_cached'  => 4.94,
            'featured'       => true,
            'amenities'      => [
                'Private Heated Pool', 'Wi-Fi', 'Air Conditioning',
                'Fully Equipped Kitchen', 'Dishwasher', 'BBQ', 'Garden',
                'Terrace', 'Parking', 'Pet Friendly',
            ],
        ]);

        // 2. La Roseraie — Dordogne
        $p2 = Destinations::create([
            'title'          => 'La Roseraie',
            'description'    => 'A stone cottage in the old town of Sarlat, with two bedrooms and a small walled garden full of roses.',
            'content'        => "La Roseraie is a stone cottage at the edge of Sarlat-la-Canéda, an old town in the Dordogne. It has stone walls, a beamed ceiling and a fireplace, along with a modern bathroom, Wi-Fi and a full kitchen.\n\nThe cottage has a small walled garden with roses and lavender, and an outside table where guests can eat breakfast. It is a ten-minute walk through the old streets to Sarlat's Saturday market.\n\nWith two bedrooms and space for four guests, it suits a couple or a small family. It is also a good base for visiting the Dordogne Valley, Beynac Castle and the old caves near Les Eyzies.",
            'category_id'    => $dordogne->id,
            'image'          => 'images/destination-2.jpg',
            'published_at'   => now(),
            'pricing'        => '£195',
            'duration'       => '2 Bedrooms',
            'group_size'     => 'Sleeps 4',
            'tour_type'      => 'Cottage',
            'property_type'  => 'Cottage',
            'location'       => 'Sarlat, Dordogne',
            'region'         => 'Dordogne',
            'bedrooms'       => 2,
            'bathrooms'      => 1,
            'max_guests'     => 4,
            'price_per_night' => 195.00,
            'rating_cached'  => 4.88,
            'featured'       => true,
            'amenities'      => [
                'Walled Garden', 'Wi-Fi', 'Fully Equipped Kitchen',
                'Fireplace', 'Washer / Dryer', 'Parking', 'Outdoor Dining',
            ],
        ]);

        // 3. Chalet Aurore — French Alps
        $p3 = Destinations::create([
            'title'          => 'Chalet Aurore',
            'description'    => 'A ski chalet in Méribel with five bedrooms, a hot tub and easy walking access to the ski slopes.',
            'content'        => "Chalet Aurore is a large chalet in Méribel, in the French Alps. It stands right next to the ski slopes, so guests can walk to the lifts. The chalet has five bedrooms, each with its own bathroom, and a big living room with a log fire and mountain views.\n\nAfter a day of skiing, guests can use the outdoor hot tub, the sauna or the small cinema room. There is also a boot room, ski storage and underground parking.\n\nIn summer, the chalet is a good base for walking and mountain biking, with lakes and trails nearby. It sleeps up to ten guests, so it suits large families or groups of friends. Daily cleaning and a welcome basket of local food are included.",
            'category_id'    => $alps->id,
            'image'          => 'images/destination-3.jpg',
            'published_at'   => now(),
            'pricing'        => '£1,240',
            'duration'       => '5 Bedrooms',
            'group_size'     => 'Sleeps 10',
            'tour_type'      => 'Chalet',
            'property_type'  => 'Chalet',
            'location'       => 'Méribel, French Alps',
            'region'         => 'French Alps',
            'bedrooms'       => 5,
            'bathrooms'      => 4,
            'max_guests'     => 10,
            'price_per_night' => 1240.00,
            'rating_cached'  => 4.97,
            'featured'       => true,
            'amenities'      => [
                'Ski In / Ski Out', 'Hot Tub', 'Sauna', 'Cinema Room',
                'Log Fire', 'Mountain View', 'Wi-Fi', 'Boot Room',
                'Ski Storage', 'Underground Parking', 'Daily Housekeeping',
                'Welcome Hamper', 'Fully Equipped Kitchen',
            ],
        ]);

        // 4. Trocadéro Residence — Paris
        $p4 = Destinations::create([
            'title'          => 'Trocadéro Residence',
            'description'    => 'An apartment in central Paris with two bedrooms and a balcony that looks out at the Eiffel Tower.',
            'content'        => "Trocadéro Residence is an apartment in the 16th district of Paris, close to the Eiffel Tower. The building is an older Haussmann-style building with high ceilings and wooden floors.\n\nThe apartment has two bedrooms, two bathrooms and a kitchen with modern equipment. There is a small balcony where guests can see the Eiffel Tower, which is nice to look at in the evening when it is lit up.\n\nIt is a short walk to the Trocadéro gardens, the Palais de Chaillot and other museums. This apartment suits a couple or a small family visiting Paris. Staff can help with booking restaurants, tours and tickets during the stay.",
            'category_id'    => $paris->id,
            'image'          => 'images/destination-4.jpg',
            'published_at'   => now(),
            'pricing'        => '£420',
            'duration'       => '2 Bedrooms',
            'group_size'     => 'Sleeps 4',
            'tour_type'      => 'Apartment',
            'property_type'  => 'Apartment',
            'location'       => 'Paris, Île-de-France',
            'region'         => 'Paris',
            'bedrooms'       => 2,
            'bathrooms'      => 2,
            'max_guests'     => 4,
            'price_per_night' => 420.00,
            'rating_cached'  => 4.91,
            'featured'       => true,
            'amenities'      => [
                'Eiffel Tower View', 'Private Balcony', 'Wi-Fi',
                'Gourmet Kitchen', 'Air Conditioning', 'Concierge Service',
                'Washer / Dryer', 'Smart TV', 'Period Features',
            ],
        ]);

        // 5. Villa Bellevue — Côte d'Azur
        $p5 = Destinations::create([
            'title'          => 'Villa Bellevue',
            'description'    => 'A villa on a hillside near Saint-Tropez with four bedrooms, a large pool and a view of the sea.',
            'content'        => "Villa Bellevue stands on a hill above Saint-Tropez, on the Côte d'Azur. Most rooms have a view over the bay towards the hills on the other side. The pool is twenty metres long, and from the terrace it looks like it joins the sea.\n\nThe villa has four bedrooms, each with its own bathroom and a terrace with a sea view. Outside there is a sun terrace, an outdoor kitchen and a dining table for twelve people. A path from the garden leads down to a small beach that only guests can use.\n\nA cleaner and a pool service come every week, and there is someone who looks after the property. The villa sleeps up to eight guests, so it suits a group of friends or a large family. Saint-Tropez, with its port and restaurants, is about fifteen minutes away by car.",
            'category_id'    => $cotedazur->id,
            'image'          => 'images/destination-5.jpg',
            'published_at'   => now(),
            'pricing'        => '£1,850',
            'duration'       => '4 Bedrooms',
            'group_size'     => 'Sleeps 8',
            'tour_type'      => 'Villa',
            'property_type'  => 'Villa',
            'location'       => 'Saint-Tropez, Côte d\'Azur',
            'region'         => 'Côte d\'Azur',
            'bedrooms'       => 4,
            'bathrooms'      => 4,
            'max_guests'     => 8,
            'price_per_night' => 1850.00,
            'rating_cached'  => 4.96,
            'featured'       => true,
            'amenities'      => [
                'Infinity Pool', 'Sea View', 'Private Beach Access',
                'Outdoor Kitchen', 'Air Conditioning', 'Wi-Fi',
                'Weekly Maid Service', 'Pool Maintenance', 'Parking',
                'Smart Home System', 'Outdoor Dining for 12',
            ],
        ]);

        // 6. Domaine Saint-Vincent — Loire Valley
        $p6 = Destinations::create([
            'title'          => 'Domaine Saint-Vincent',
            'description'    => 'A large manor house on a wine estate near Saumur, with six bedrooms and a private pool.',
            'content'        => "Domaine Saint-Vincent is an old manor house on a wine estate in the Loire Valley, near the town of Saumur. The estate grows its own grapes and makes red wine. The house has six bedrooms, five bathrooms, a large kitchen and a dining room.\n\nOutside there is a heated pool, a lawn, a small orchard and a vegetable garden, with views over the vineyards. There is also a boules court, a play area for children and a covered outdoor dining space. There is a wine cellar with bottles from the estate for guests to try.\n\nWith room for twelve guests, the house is a good place for a family gathering or a group celebration. The person who manages the estate lives nearby and can arrange wine tasting, a tour of the vineyard, or a cooking class. The Loire cycling route also passes close by.",
            'category_id'    => $loirevalley->id,
            'image'          => 'images/destination-6.jpg',
            'published_at'   => now(),
            'pricing'        => '£760',
            'duration'       => '6 Bedrooms',
            'group_size'     => 'Sleeps 12',
            'tour_type'      => 'Villa',
            'property_type'  => 'Villa',
            'location'       => 'Saumur, Loire Valley',
            'region'         => 'Loire Valley',
            'bedrooms'       => 6,
            'bathrooms'      => 5,
            'max_guests'     => 12,
            'price_per_night' => 760.00,
            'rating_cached'  => 4.89,
            'featured'       => true,
            'amenities'      => [
                'Heated Pool', 'Wine Cellar', 'Working Vineyard', 'Garden',
                'Boules Court', 'Children\'s Play Area', 'Wi-Fi',
                'Professional Kitchen', 'Outdoor Dining', 'Games Room',
                'On-Site Estate Manager', 'Wine Tasting on Request',
            ],
        ]);

        // ── Tag assignments ────────────────────────────────────────────────────
        $p1->tags()->attach([$tagCottage->id, $tagPool->id, $tagFamilies->id, $tagGarden->id]);
        $p2->tags()->attach([$tagCottage->id, $tagGarden->id, $tagFamilies->id]);
        $p3->tags()->attach([$tagChalet->id, $tagSki->id, $tagLuxury->id, $tagFamilies->id]);
        $p4->tags()->attach([$tagApart->id, $tagLuxury->id]);
        $p5->tags()->attach([$tagVilla->id, $tagPool->id, $tagSea->id, $tagLuxury->id]);
        $p6->tags()->attach([$tagVilla->id, $tagPool->id, $tagFamilies->id, $tagGarden->id]);
    }
}
