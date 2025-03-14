<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArtisanMiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Démarrer une transaction pour pouvoir rollback après les tests
        DB::beginTransaction();
        
        // Utiliser des données existantes ou créer un nouvel artisan si nécessaire
        $this->artisanUser = User::where('role', 'artisan')->first() ?? 
            User::create([
                'name' => 'Test Artisan',
                'email' => 'test.artisan@example.com',
                'password' => bcrypt('password123'),
                'role' => 'artisan'
            ]);

        // Utiliser un client existant ou créer un nouveau
        $this->normalUser = User::where('role', 'client')->first() ?? 
            User::create([
                'name' => 'Test Client',
                'email' => 'test.client@example.com',
                'password' => bcrypt('password123'),
                'role' => 'client'
            ]);

        Log::info('Test setup completed', [
            'artisan_id' => $this->artisanUser->id,
            'client_id' => $this->normalUser->id
        ]);
    }

    protected function tearDown(): void
    {
        // Annuler toutes les modifications de la base de données
        DB::rollBack();
        parent::tearDown();
    }

    public function test_artisan_can_access_dashboard()
    {
        $response = $this->actingAs($this->artisanUser)
            ->get('/artisan/dashboard');

        $response->assertStatus(200);
        Log::info('Artisan dashboard access test completed', [
            'status' => $response->status(),
            'user_id' => $this->artisanUser->id
        ]);
    }

    public function test_non_artisan_cannot_access_dashboard()
    {
        $response = $this->actingAs($this->normalUser)
            ->get('/artisan/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_guest_cannot_access_dashboard()
    {
        $response = $this->get('/artisan/dashboard');
        $response->assertRedirect('/login');
    }
}
