<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    protected $unsplashCategories = [
        'plomberie' => ['bathroom', 'plumbing', 'sink', 'shower'],
        'electricite' => ['electrical', 'wiring', 'lighting', 'socket'],
        'maconnerie' => ['construction', 'bricks', 'concrete', 'wall'],
        'peinture' => ['painting', 'wall', 'renovation', 'interior']
    ];

    public function run()
    {
        $categories = [
            'plomberie' => [
                'Installation chauffe-eau',
                'Réparation fuite',
                'Rénovation salle de bain',
                'Débouchage canalisation'
            ],
            'electricite' => [
                'Installation climatisation',
                'Mise aux normes tableau électrique',
                'Installation prises',
                'Dépannage électrique urgent'
            ],
            'maconnerie' => [
                'Construction mur',
                'Rénovation façade',
                'Création terrasse',
                'Agrandissement maison'
            ],
            'peinture' => [
                'Peinture appartement complet',
                'Ravalement façade',
                'Pose papier peint',
                'Traitement humidité'
            ]
        ];

        $cities = ['Paris', 'Lyon', 'Marseille', 'Bordeaux', 'Lille', 'Toulouse'];
        $verification_methods = ['phone', 'email', 'onsite'];
        $budget_types = ['fixed', 'hourly', 'estimate'];
        $status = ['open', 'assigned', 'in_progress', 'completed'];

        // Créer d'abord un client qui postera les projets
        $client = User::firstOrCreate(
            ['email' => 'client@test.com'],
            [
                'name' => 'Client Test',
                'password' => bcrypt('password'),
                'role' => 'client'
            ]
        );

        // Créer 15 projets
        foreach(range(1, 15) as $i) {
            $category = array_rand($categories);
            $titles = $categories[$category];
            
            Project::create([
                'client_id' => $client->id,
                'title' => $titles[array_rand($titles)],
                'description' => "Description détaillée du projet numéro $i. Ce projet nécessite une expertise en $category.",
                'category' => $category,
                'budget' => rand(500, 5000),
                'budget_type' => ['fixed', 'hourly', 'estimate'][array_rand([0,1,2])],
                'city' => $cities[array_rand($cities)],
                'postal_code' => rand(10000, 99999),
                'address' => "Adresse du projet $i",
                'urgent' => (bool)rand(0, 1),
                'status' => 'open',
                'created_at' => now()->subDays(rand(0, 30))
            ]);
        }

        // Créer 50 projets variés
        for ($i = 0; $i < 50; $i++) {
            $category = array_rand($categories);
            $titles = $categories[$category];

            // Générer 1 à 4 images pour chaque projet
            $imageCount = rand(1, 4);
            $images = [];
            $unsplashTerms = $this->unsplashCategories[$category];
            
            for ($j = 0; $j < $imageCount; $j++) {
                $term = $unsplashTerms[array_rand($unsplashTerms)];
                $width = 800;
                $height = 600;
                $images[] = "https://source.unsplash.com/{$width}x{$height}/?{$term}";
            }

            Project::create([
                'client_id' => User::where('role', 'client')->inRandomOrder()->first()->id,
                'title' => $titles[array_rand($titles)],
                'description' => fake()->paragraphs(3, true),
                'category' => $category,
                'budget' => fake()->numberBetween(500, 10000),
                'budget_type' => $budget_types[array_rand($budget_types)],
                'city' => $cities[array_rand($cities)],
                'postal_code' => fake()->numberBetween(10000, 99999),
                'address' => fake()->address,
                'urgent' => fake()->boolean(20),
                'verification_method' => $verification_methods[array_rand($verification_methods)],
                'availability_days' => json_encode(array_rand(array_flip(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']), 3)),
                'availability_hours' => json_encode(array_rand(array_flip(['morning', 'afternoon', 'evening']), 2)),
                'status' => $status[array_rand($status)],
                'photos' => json_encode($images),
                'before_photos' => json_encode(array_slice($images, 0, 2)),
                'inspiration_photos' => json_encode(array_slice($images, 2))
            ]);
        }
    }
}
