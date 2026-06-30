<?php

namespace Database\Seeders;

use App\Blog;
use App\Category;
use Illuminate\Database\Seeder;

class BlogsTableSeeder extends Seeder
{
    public function run()
    {
        $regional  = Category::create(['name' => 'Regional Guides']);
        $tips      = Category::create(['name' => 'Property Tips']);
        $foodwine  = Category::create(['name' => 'Food & Wine']);
        $family    = Category::create(['name' => 'Family Holidays']);
        $practical = Category::create(['name' => 'Travel Advice']);

        Blog::create([
            'title'       => "Discovering Provence: A First-Timer's Guide",
            'description' => "Lavender fields, hilltop villages, and world-class markets — everything you need to know before visiting Provence.",
            'content'     => "Provence is one of France's most iconic regions. From the purple lavender fields of the Valensole Plateau to the ochre cliffs of Roussillon and the medieval hilltop villages of the Luberon, every corner offers something extraordinary.\n\nThe best time to visit is June to mid-July for lavender in bloom, or September for the grape harvest. The Gordes Saturday market is one of the best in France — arrive early for fresh goat's cheese, lavender honey, and tapenade. Hire a car: the region's best spots reward the spontaneous traveller on winding country roads.",
            'category_id' => $regional->id,
            'image'       => 'destinations/camera.jpg',
        ]);

        Blog::create([
            'title'       => 'How to Choose the Right French Holiday Property',
            'description' => 'Cottage, villa, chalet, or apartment? Our experts share what to look for when booking your French holiday home.',
            'content'     => "With hundreds of properties across France, choosing the right one can feel overwhelming. For families with young children, look for a private pool with safety fencing, a garden, and a ground-floor bedroom. For couples, a beautifully renovated gite in a village is often more characterful than a large villa.\n\nAlways check the kitchen specification: self-catering holidays live and die by the kitchen. A property with a dishwasher, decent oven, and outdoor BBQ makes a huge difference. And don't overlook the location relative to the nearest supermarket.",
            'category_id' => $tips->id,
            'image'       => 'destinations/camera.jpg',
        ]);

        Blog::create([
            'title'       => "The Loire Valley: France's Garden and Wine Country",
            'description' => "Chateaux, cycling routes, and Muscadet — why the Loire Valley deserves a place on every France itinerary.",
            'content'     => "The Loire Valley is often called the 'Garden of France', and its 300 kilometres of river scenery, Renaissance chateaux, and gentle cycling paths make it one of the country's most rewarding regions.\n\nThe Loire a Velo cycling route links Blois, Amboise, Saumur, and Angers — distances are flat and manageable for families. Wine lovers should seek out Saumur-Champigny for elegant reds, Vouvray for honeyed whites, and Muscadet near Nantes for crisp, mineral seafood wines.",
            'category_id' => $foodwine->id,
            'image'       => 'destinations/food.jpg',
        ]);

        Blog::create([
            'title'       => 'Best French Holiday Properties for Families with Children',
            'description' => 'Our top tips for choosing a family-friendly property in France, from pool safety to proximity to activities.',
            'content'     => "France is one of Europe's great family holiday destinations — long summers, excellent food, and a culture that genuinely welcomes children.\n\nLook for properties with a private fenced pool (essential for peace of mind with toddlers), a large garden, and a games room for rainy days. For younger children, the Dordogne is hard to beat: gentle rivers for canoeing, sandy beaches, and a relaxed pace. Older children often love the Alps in summer — mountain biking and luge tracks keep teenagers busy all week.",
            'category_id' => $family->id,
            'image'       => 'destinations/friends.jpg',
        ]);

        Blog::create([
            'title'       => 'Driving in France: Everything UK Travellers Need to Know',
            'description' => 'From the right-hand rule to priority roads and tolls — our practical guide to driving in France.',
            'content'     => "Driving is by far the best way to explore rural France, and the roads are generally excellent. Carry the essentials: a high-visibility jacket, warning triangle, breathalyser (mandatory), and a GB sticker. Speed limits are 130 km/h on motorways, 80 km/h on rural roads, and 50 km/h in towns.\n\nFrench motorways are toll roads — most accept UK debit and credit cards. Fuel stations in rural areas can be sparse on Sundays: fill up on Saturday. In France, priority is given to traffic joining from the right unless signed otherwise — this catches many UK drivers out at roundabouts.",
            'category_id' => $practical->id,
            'image'       => 'destinations/camera.jpg',
        ]);

        Blog::create([
            'title'       => "The Cote d'Azur Beyond Saint-Tropez",
            'description' => 'Step off the beaten track and discover quieter coves, artisan villages, and local markets along the Riviera.',
            'content'     => "Saint-Tropez and Cannes attract the headlines, but the Cote d'Azur has a quieter, more authentic side. The perched village of Eze offers medieval lanes and views across to Monaco. The Corniche des Maures passes deserted beaches accessible only on foot.\n\nFor accommodation, seek properties above the coastal strip: you'll pay less, enjoy cooler temperatures, and wake up to sea views without the noise of the port below.",
            'category_id' => $regional->id,
            'image'       => 'destinations/camera.jpg',
        ]);
    }
}
