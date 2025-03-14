<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User as SocialiteUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\Traits\DatabaseSetup;
use Mockery;

class GoogleAuthFlowTest extends TestCase
{
    use RefreshDatabase, DatabaseSetup;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configurer la base de test
        $this->setupDatabase();
        
        // Mock Socialite
        $this->mockSocialite();

        // S'assurer que les routes sont définies pour les tests avec le namespace complet
        if (!Route::has('role.store')) {
            Route::post('/select-role', [
                \App\Http\Controllers\Auth\RoleSelectionController::class, 
                'store'
            ])->name('role.store');
        }
    }

    protected function mockSocialite()
    {
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('123456789')
            ->shouldReceive('getName')->andReturn('Test User')
            ->shouldReceive('getEmail')->andReturn('test@example.com')
            ->shouldReceive('getAvatar')->andReturn('https://example.com/avatar.jpg');

        $provider = Mockery::mock(GoogleProvider::class);
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);
    }

    /** @test */
    public function google_callback_creates_new_user_and_redirects_to_role_selection()
    {
        $response = $this->get('/auth/google/callback');

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'google_id' => '123456789',
            'role' => null // Le rôle devrait être null initialement
        ]);

        $response->assertRedirect(route('role.select'));
    }

    public function test_google_callback_creates_new_user()
    {
        \Log::info('Starting test');
        
        $response = $this->get('/auth/google/callback');
        
        \Log::info('Response', [
            'status' => $response->status(),
            'redirectTo' => $response->headers->get('Location')
        ]);
        
        $user = User::where('email', 'test@example.com')->first();
        
        $this->assertNotNull($user, 'User should be created');
        $this->assertEquals('test@example.com', $user->email);
        $this->assertEquals('123456789', $user->google_id);
        $this->assertNull($user->role, 'Role should be null initially');
        
        $response->assertRedirect(route('role.select'));
    }

    /** @test */
    public function user_can_select_role_after_google_auth()
    {
        \Log::info('Starting role selection test');
        
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'google_id' => '123456789',
            'password' => 'password'
        ]);

        $this->actingAs($user);

        \Log::info('User before role update', ['user' => $user->toArray()]);

        $response = $this->withoutMiddleware()
            ->post(route('role.store'), [
                'role' => 'client'
            ]);

        // Forcer le rafraîchissement depuis la base de données
        $user = $user->fresh();
        \Log::info('User after role update', ['user' => $user->toArray()]);

        $this->assertEquals('client', $user->role, 'Le rôle n\'a pas été mis à jour');
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'client'
        ]);

        $response->assertRedirect(route('client.complete-profile'));
    }

    /** @test */
    public function selecting_artisan_role_redirects_to_artisan_profile_completion()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'google_id' => '123456789',
            'password' => 'password'
        ]);

        $this->actingAs($user);

        \Log::info('Starting artisan role update test');
        
        $response = $this->withoutMiddleware()
            ->post(route('role.store'), [
                'role' => 'artisan'
            ]);

        // Forcer le rafraîchissement depuis la base de données
        $user = $user->fresh();
        \Log::info('User after artisan role update', ['user' => $user->toArray()]);

        $this->assertEquals('artisan', $user->role, 'Le rôle artisan n\'a pas été mis à jour');
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'artisan'
        ]);

        $response->assertRedirect(route('artisan.complete-profile'));
    }

    /** @test */
    public function existing_user_with_role_skips_role_selection()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'google_id' => '123456789',
            'password' => 'password',
            'role' => 'client'
        ]);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('client.dashboard'));
    }

    public function test_user_can_select_role()
    {
        // Créer et authentifier l'utilisateur
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'google_id' => '123456789',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        // Faire la requête pour mettre à jour le rôle
        $response = $this->withSession(['_token' => csrf_token()])
            ->post(route('role.store'), [
                'role' => 'client',
                '_token' => csrf_token(),
            ]);

        // Rafraîchir l'utilisateur depuis la base de données
        $user->refresh();

        // Vérifications
        $this->assertEquals('client', $user->role, 'Le rôle n\'a pas été correctement mis à jour');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => 'client'
        ]);
        $response->assertRedirect(route('client.complete-profile'));
    }
}
