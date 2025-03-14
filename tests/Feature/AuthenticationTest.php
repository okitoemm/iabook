<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

class AuthenticationTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Démarrer une transaction pour pouvoir rollback après chaque test
        DB::beginTransaction();
    }

    protected function tearDown(): void
    {
        // Rollback de la transaction pour nettoyer les données de test
        DB::rollBack();
        
        parent::tearDown();
    }

    public function test_client_can_register()
    {
        $userData = [
            'name' => 'Test Client',
            'email' => 'client@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'city' => 'Paris',
            'postal_code' => '75000',
            'terms' => true
        ];

        $response = $this->post(route('register.client.post'), $userData);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'client@test.com',
            'role' => 'client'
        ]);
    }

    public function test_artisan_can_register()
    {
        $artisanData = [
            'name' => 'Test Artisan',
            'email' => 'artisan@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'phone' => '0123456789',
            'business_name' => 'Test Enterprise',
            'siret' => '12345678901234',
            'specialty' => 'Plomberie',
            'description' => 'Une description détaillée de mon activité qui fait plus de 100 caractères et contient au moins 20 mots pour respecter les critères de validation mis en place.',
            'experience_years' => 5,
            'hourly_rate' => 50,
            'service_area' => 'Paris',
            'terms' => true
        ];

        $response = $this->post(route('register.artisan.post'), $artisanData);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'artisan@test.com',
            'role' => 'artisan'
        ]);
        $this->assertDatabaseHas('artisans', [
            'business_name' => 'Test Enterprise',
            'siret' => '12345678901234'
        ]);
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'client'
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect(route('client.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_artisan_is_redirected_to_artisan_dashboard()
    {
        $user = User::factory()->create([
            'email' => 'artisan@example.com',
            'password' => bcrypt('password123'),
            'role' => 'artisan'
        ]);

        Artisan::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->post(route('login'), [
            'email' => 'artisan@example.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect(route('artisan.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password'
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $response = $this->post(route('logout'));
        
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
