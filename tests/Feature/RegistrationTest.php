<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Artisan;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_client_can_register()
    {
        $response = $this->post('/register/client', [
            'name' => 'Test Client',
            'email' => 'client@test.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'city' => 'Paris',
            'postal_code' => '75001',
            'terms' => true
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('users', [
            'email' => 'client@test.com',
            'role' => 'client'
        ]);
    }

    public function test_artisan_can_register()
    {
        $response = $this->post('/register/artisan', [
            'name' => 'Test Artisan',
            'email' => 'artisan@test.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'phone' => '0612345678',
            'business_name' => 'Test Enterprise',
            'siret' => '12345678901234',
            'specialty' => 'plombier',
            'description' => 'Description de test qui fait plus de 100 caractères pour satisfaire la validation. Je suis un plombier professionnel avec 10 ans d\'expérience.',
            'experience_years' => 10,
            'hourly_rate' => 50,
            'service_area' => 'Paris',
            'terms' => true
        ]);

        $response->assertRedirect('/login');
        
        // Vérifier l'utilisateur
        $this->assertDatabaseHas('users', [
            'email' => 'artisan@test.com',
            'role' => 'artisan'
        ]);

        // Vérifier le profil artisan
        $user = User::where('email', 'artisan@test.com')->first();
        $this->assertDatabaseHas('artisans', [
            'user_id' => $user->id,
            'siret' => '12345678901234',
            'is_verified' => false
        ]);
    }

    public function test_registration_validation()
    {
        // Test client avec données invalides
        $response = $this->post('/register/client', [
            'email' => 'not-an-email',
            'password' => '123', // trop court
        ]);
        $response->assertSessionHasErrors(['email', 'password', 'name']);

        // Test artisan avec SIRET invalide uniquement
        $response = $this->post('/register/artisan', [
            'name' => 'Test Artisan',
            'email' => 'artisan@test.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'phone' => '0612345678',
            'business_name' => 'Test Enterprise',
            'specialty' => 'plombier',
            'description' => str_repeat('a', 100),
            'experience_years' => 10,
            'hourly_rate' => 50,
            'service_area' => 'Paris',
            'siret' => '123', // SIRET invalide car moins de 14 caractères
            'terms' => true
        ]);
        
        $response->assertStatus(302); // Redirection après erreur
        $response->assertSessionHasErrors(['siret' => 'The siret field must be 14 characters.']);
    }
}
