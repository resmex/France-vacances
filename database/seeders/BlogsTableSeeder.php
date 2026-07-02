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
            'description' => "Learn about Provence and some places you can visit during your holiday.",
            'content'     => "Provence is a popular region in the south of France. It is known for its villages, local markets and lavender fields.\n\nMany visitors enjoy walking around small towns, trying local food and visiting nearby attractions. Renting a car can make travelling around the region easier.",
            'category_id' => $regional->id,
            'image'       => 'destinations/camera.jpg',
        ]);

        Blog::create([
            'title'       => 'How to Choose the Right French Holiday Property',
            'description' => 'Tips to help you choose the right holiday property in France.',
            'content'     => "France has many types of holiday homes, including cottages, villas, apartments and chalets. Choose a property that matches your budget and the number of people travelling with you.\n\nIt is also helpful to check the location, available facilities and nearby shops before making a booking.",
            'category_id' => $tips->id,
            'image'       => 'destinations/camera.jpg',
        ]);

        Blog::create([
            'title'       => "The Loire Valley: France's Garden and Wine Country",
            'description' => "A short guide to the Loire Valley, its rivers, old buildings and local wine.",
            'content'     => "The Loire Valley is a region in central France with a long river, old castles and quiet countryside. It is a good place for cycling because many paths are flat and easy to follow.\n\nThe area also makes different types of wine, from red to white. Visitors can stop at small wine shops or vineyards to try local wine during their trip.",
            'category_id' => $foodwine->id,
            'image'       => 'destinations/food.jpg',
        ]);

        Blog::create([
            'title'       => 'Best French Holiday Properties for Families with Children',
            'description' => 'Some simple tips for choosing a family holiday home in France.',
            'content'     => "France is a common holiday choice for families because of the warm summers and family-friendly places to stay. When picking a property, look for a safe pool area, a garden and enough space for everyone.\n\nThe Dordogne is a calm area with rivers and beaches, which works well for young children. The Alps can be a good choice in summer for older children who enjoy outdoor activities like biking.",
            'category_id' => $family->id,
            'image'       => 'destinations/friends.jpg',
        ]);

        Blog::create([
            'title'       => 'Driving in France: Everything UK Travellers Need to Know',
            'description' => 'A simple guide to driving in France for visitors from the UK.',
            'content'     => "Driving is a common way to travel around France, and most roads are in good condition. Before your trip, check that you have a warning triangle, a high-visibility jacket and a breathalyser in the car, since these are required by law.\n\nSpeed limits are usually 130 km/h on motorways, 80 km/h on smaller roads and 50 km/h in towns. Most motorways charge a toll, and UK cards are normally accepted. Drivers should also remember that traffic coming from the right often has priority at junctions.",
            'category_id' => $practical->id,
            'image'       => 'destinations/camera.jpg',
        ]);

        Blog::create([
            'title'       => "The Cote d'Azur Beyond Saint-Tropez",
            'description' => 'A look at some quieter places to visit along the Cote d\'Azur.',
            'content'     => "Saint-Tropez and Cannes are well known, but the Cote d'Azur has other areas too. The village of Eze has old narrow streets and looks out over the coast towards Monaco.\n\nSome properties are located a little away from the coast. These are often cheaper and quieter, and they can still offer a view of the sea.",
            'category_id' => $regional->id,
            'image'       => 'destinations/camera.jpg',
        ]);
    }
}
