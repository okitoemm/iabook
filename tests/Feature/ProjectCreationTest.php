<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class ProjectCreationTest extends TestCase
{
    use RefreshDatabase;

    protected $client;

    public function setUp(): void
    {
        parent::setUp();
        
        // Force using testing database
        config(['database.default' => 'testing']);
        
        // Désactiver la vérification des clés étrangères
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Nettoyer les tables dans le bon ordre
        \DB::table('projects')->truncate();
        \DB::table('users')->truncate();
        
        // Réactiver la vérification des clés étrangères
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Créer un client de test
        $this->client = User::factory()->create([
            'role' => 'client',
            'name' => 'Test Client',
            'email' => 'client@test.com',
            'password' => bcrypt('password')
        ]);

        Storage::fake('public');
    }

    public function tearDown(): void
    {
        // Nettoyer après chaque test
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \DB::table('projects')->truncate();
        \DB::table('users')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        parent::tearDown();
    }

    public function test_client_can_access_project_creation_page()
    {
        $response = $this->actingAs($this->client)
            ->get(route('projects.create'));

        $response->assertStatus(200);
        $response->assertViewIs('projects.create');
    }

    public function test_client_can_create_project()
    {
        Storage::fake('public');

        $projectData = [
            'formData' => json_encode([
                'title' => 'Rénovation salle de bain',
                'description' => 'Je souhaite rénover entièrement ma salle de bain de 6m².',
                'category' => 'plumbing',
                'budget' => 5000,
                'budget_type' => 'fixed',
                'city' => 'Paris',
                'postal_code' => '75001',
                'address' => '1 rue de la Paix',
                'urgent' => true,
                'verification_method' => 'phone',
                'availability_days' => ['monday', 'tuesday'],
                'availability_hours' => ['morning', 'afternoon']
            ])
        ];

        // Create and add photos to request
        $projectData['photos'] = [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.jpg')
        ];

        // Add video
        $projectData['video'] = UploadedFile::fake()->create('video.mp4', 1024);

        $response = $this->actingAs($this->client)
            ->post(route('projects.store'), $projectData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Projet créé avec succès'
            ]);

        $project = Project::latest()->first();
        
        // Verify project was created with correct data
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'client_id' => $this->client->id,
            'title' => 'Rénovation salle de bain',
            'city' => 'Paris',
            'urgent' => true
        ]);

        // Verify photos
        if (is_string($project->photos)) {
            $storedPhotos = json_decode($project->photos, true);
        } else {
            $storedPhotos = $project->photos;
        }
        
        $this->assertCount(2, $storedPhotos);
        foreach ($storedPhotos as $photo) {
            Storage::disk('public')->assertExists($photo);
        }

        // Verify video
        if ($project->video_path) {
            Storage::disk('public')->assertExists($project->video_path);
        }
    }

    public function test_non_client_cannot_create_project()
    {
        $artisan = User::factory()->create([
            'role' => 'artisan'
        ]);

        $response = $this->actingAs($artisan)
            ->post(route('projects.store'), [
                'formData' => json_encode([
                    'title' => 'Test Project',
                    'description' => 'Test Description'
                ])
            ]);

        $response->assertStatus(403);
    }

    public function test_client_cannot_create_project_with_invalid_data()
    {
        $response = $this->actingAs($this->client)
            ->post(route('projects.store'), [
                'formData' => json_encode([
                    'title' => '', // Titre vide
                    'description' => 'Test'
                ])
            ]);

        $response->assertStatus(500);
    }

    public function test_client_cannot_upload_invalid_files()
    {
        $projectData = [
            'formData' => json_encode([
                'title' => 'Test Project',
                'description' => 'Test Description'
            ]),
            'photos' => [
                UploadedFile::fake()->create('document.pdf', 1024), // Mauvais type de fichier
            ]
        ];

        $response = $this->actingAs($this->client)
            ->post(route('projects.store'), $projectData);

        $response->assertStatus(500);
    }
}
