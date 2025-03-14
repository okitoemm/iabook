<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ApplicationFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configuration de la base de test
        config(['database.default' => 'testing']);
        
        // Nettoyage des tables
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \DB::table('projects')->truncate();
        \DB::table('messages')->truncate();
        \DB::table('artisans')->truncate();
        \DB::table('users')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /** @test */
    public function test_complete_user_flow()
    {
        // Désactiver la vérification CSRF pour tous les tests
        $this->withoutMiddleware();

        // 1. Test Client Registration
        $this->test_client_registration();

        // 2. Test Artisan Registration
        $this->test_artisan_registration();

        // 3. Test Project Creation
        $this->test_client_can_create_project();
    }

    protected function test_client_registration()
    {
        $clientData = [
            'name' => 'Client Test',
            'email' => 'client@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'city' => 'Paris',
            'postal_code' => '75001',
            'terms' => true
        ];

        $response = $this->post(route('register.client.post'), $clientData);
        
        if ($response->status() !== 302) {
            $this->fail('Client registration failed with status: ' . $response->status() . 
                       ' and content: ' . $response->content());
        }

        $this->assertDatabaseHas('users', [
            'email' => 'client@test.com',
            'role' => 'client'
        ]);
    }

    protected function test_artisan_registration()
    {
        $artisanData = [
            'name' => 'Artisan Test',
            'email' => 'artisan@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'phone' => '0123456789',
            'business_name' => 'Artisan SARL',
            'siret' => '12345678901234',
            'specialty' => 'Plomberie',
            'description' => 'Artisan plombier professionnel avec plus de 10 ans d\'expérience. Spécialisé dans la rénovation et le dépannage.',
            'experience_years' => 10,
            'hourly_rate' => 50,
            'service_area' => 'Paris et environs',
            'terms' => true
        ];

        $response = $this->post(route('register.artisan.post'), $artisanData);
        
        if ($response->status() !== 302) {
            \Log::error('Artisan registration failed', [
                'response_status' => $response->status(),
                'response_content' => $response->content()
            ]);
            $this->fail('Artisan registration failed with status: ' . $response->status() . 
                       ' and content: ' . $response->content());
        }

        // Vérifier l'utilisateur et son profil artisan
        $this->assertDatabaseHas('users', [
            'email' => 'artisan@test.com',
            'role' => 'artisan'
        ]);

        $user = User::where('email', 'artisan@test.com')->first();
        $this->assertNotNull($user, 'User not created');

        $this->assertDatabaseHas('artisans', [
            'user_id' => $user->id,
            'business_name' => 'Artisan SARL',
            'siret' => '12345678901234'
        ]);
    }

    protected function test_client_can_create_project()
    {
        $client = User::where('email', 'client@test.com')->first();
        if (!$client) {
            $this->fail('Client not found in database');
        }

        Storage::fake('public');

        $projectData = [
            'formData' => json_encode([
                'title' => 'Rénovation salle de bain',
                'description' => 'Rénovation complète d\'une salle de bain de 6m²',
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
            ]),
            'photos' => [
                UploadedFile::fake()->image('photo1.jpg'),
                UploadedFile::fake()->image('photo2.jpg')
            ],
            'video' => UploadedFile::fake()->create('video.mp4', 1024)
        ];

        $response = $this->actingAs($client)->post(route('projects.store'), $projectData);
        
        if ($response->status() !== 200) {
            $this->fail('Project creation failed with status: ' . $response->status() . 
                       ' and content: ' . $response->content());
        }

        $this->assertDatabaseHas('projects', [
            'title' => 'Rénovation salle de bain',
            'city' => 'Paris',
            'client_id' => $client->id
        ]);
    }
}
