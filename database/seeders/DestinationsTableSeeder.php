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
            'description'    => 'A beautifully restored Provençal farmhouse surrounded by lavender fields and olive groves, with a private heated pool and panoramic views over Gordes village.',
            'content'        => "Nestled in the heart of the Luberon, Mas des Oliviers is a lovingly restored 18th-century mas (farmhouse) offering the quintessential Provençal experience. Stone walls, terracotta floors, and exposed oak beams sit alongside modern comforts: a fully equipped kitchen, Wi-Fi, and air conditioning throughout.\n\nOutside, the private heated pool overlooks rolling lavender fields with the honey-stone village of Gordes perched on the hillside beyond. The shaded terrace is perfect for alfresco dining, while the walled garden provides a peaceful retreat.\n\nThe property sleeps up to 6 guests across 3 bedrooms and is ideal for families or groups of friends seeking an authentic French countryside escape. The weekly Gordes market, Roussillon ochre cliffs, and Sénanque Abbey are all within easy reach.",
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
            'description'    => 'A charming stone cottage in the medieval town of Sarlat, with a rose-filled walled garden, exposed stone walls, and easy walking access to the market square.',
            'content'        => "La Roseraie is a picture-perfect stone cottage at the edge of Sarlat-la-Canéda, one of the best-preserved medieval towns in France. The cottage blends rustic character — stone walls, beamed ceilings, and original fireplaces — with contemporary comforts including a modern bathroom, fast Wi-Fi, and a fully equipped kitchen.\n\nThe highlight is the private walled garden, overflowing with roses and lavender in summer, with a wrought-iron table and chairs for breakfast in the shade. A 10-minute walk through cobbled lanes brings you to Sarlat's famous Saturday market, renowned for foie gras, truffles, and local wines.\n\nPerfect for a couple or a small family, La Roseraie sleeps 4 across 2 bedrooms and is an ideal base for exploring the Dordogne Valley, Beynac Castle, and the prehistoric caves of Les Eyzies.",
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
            'description'    => 'A spectacular ski-in/ski-out chalet in Méribel with a private hot tub, sauna, cinema room, and stunning panoramic views of the Three Valleys.',
            'content'        => "Chalet Aurore is the ultimate alpine luxury retreat, positioned directly on the Méribel ski slopes with true ski-in/ski-out access to the Three Valleys — the world's largest connected ski area. The chalet accommodates up to 10 guests in 5 beautifully appointed bedrooms, each with its own en-suite bathroom.\n\nThe living space is dominated by a floor-to-ceiling glass wall framing uninterrupted mountain views, with a log fire at the centre. After a day on the slopes, guests can unwind in the outdoor hot tub, the wood-panelled sauna, or the private cinema room. A fully equipped boot room, ski storage, and underground parking make this the perfect ski chalet.\n\nIn summer, the chalet transforms into a hiking and mountain biking base, with the valley's wildflower meadows, via ferrata routes, and alpine lakes on the doorstep. Daily housekeeping and a welcome hamper of local produce are included.",
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
            'description'    => 'A stunning Haussmann apartment on the prestigious Avenue Kléber, steps from the Eiffel Tower, with period features and a private balcony with iconic Paris views.',
            'content'        => "The Trocadéro Residence is a masterfully renovated Haussmann-era apartment on one of the 16th arrondissement's most coveted addresses. High ceilings with original plasterwork cornices, chevron parquet floors, and a marble fireplace create an atmosphere of timeless Parisian elegance, updated with contemporary furnishings and every modern convenience.\n\nThe private balcony offers a direct view of the Eiffel Tower — spectacular at night when the iron lady sparkles. The apartment sleeps 4 across 2 bedrooms, with 2 bathrooms, a fully equipped gourmet kitchen, and fast fibre Wi-Fi. The Trocadéro gardens, Palais de Chaillot, Musée d'Orsay, and the Champs-Élysées are all within a short walk.\n\nA dedicated concierge service is available to arrange restaurant reservations, private tours, transport, and theatre tickets — the perfect complement to a luxury Parisian stay.",
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
            'description'    => 'An exquisite Riviera villa perched above Saint-Tropez with a 20-metre infinity pool, panoramic sea views, and direct access to a private beach cove.',
            'content'        => "Villa Bellevue is a statement of Riviera luxury: a contemporary villa cascading down the hillside above Saint-Tropez, with every room offering sweeping views of the Golfe de Saint-Tropez and the Massif des Maures beyond. The 20-metre infinity pool appears to merge with the sea on the horizon, while the vast sun terrace is furnished with premium loungers, an outdoor kitchen, and a dining area for 12.\n\nThe villa sleeps up to 8 guests across 4 bedrooms, each with its own sea-view terrace and en-suite bathroom. The interior blends Provençal warmth — terracotta, linen, pale wood — with high-specification modern design. A private path leads to a secluded beach cove accessible only to villa guests.\n\nA weekly maid service, pool maintenance, and a property manager are included. The villa is a 15-minute drive from Saint-Tropez's famous port, beaches, and restaurants — or guests may prefer to arrive by private speedboat from Sainte-Maxime.",
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
            'description'    => 'A magnificent 18th-century domaine on a working wine estate near Saumur, with a large private pool, expansive grounds, and a cellar stocked with estate wines.',
            'content'        => "Domaine Saint-Vincent is a grand 18th-century manor house set within a working Loire Valley wine estate, producing renowned Saumur-Champigny reds. The domaine has been lovingly restored to offer self-catering luxury on a grand scale: six bedrooms with antique furnishings, five bathrooms, a professional kitchen, a formal dining room, a games room, and a vaulted wine cellar stocked with estate vintages for guests.\n\nThe 20-metre heated outdoor pool is surrounded by manicured lawns, an orchard, a potager garden, and views over the estate's vineyards to the Loire. The grounds include a boules court, children's play area, and a covered outdoor dining terrace. With space for 12 guests, this is the perfect venue for a family reunion, wedding party, or milestone birthday celebration.\n\nThe estate manager lives on site and can arrange private wine tastings, vineyard tours, cooking classes with a local chef, and guided cycling along the Loire à Vélo cycling route — one of France's most scenic long-distance rides.",
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
