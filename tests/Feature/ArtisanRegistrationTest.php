<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

class ArtisanRegistrationTest extends TestCase
{
    use WithFaker;

    protected $validData = [];

    public function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();

        $this->validData = [
            'name' => 'Test Artisan',
            'email' => 'test@artisan.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'phone' => '0123456789',
            'business_name' => 'Test Business',
            'siret' => '12345678901234',
            'specialty' => 'Plomberie',
            'experience_years' => 5,
            'hourly_rate' => 50,
            'service_area' => 'Paris',
            'description' => 'Une description détaillée de plus de 100 caractères qui parle de mon activité et de mes compétences en tant qu\'artisan professionnel. Je suis spécialisé dans plusieurs domaines.',
            'terms' => 'on'
        ];
    }

    public function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }

    public function test_registration_form_can_be_rendered()
    {
        $response = $this->get('/register/artisan');
        $response->assertStatus(200);
    }

    public function test_new_artisans_can_register_with_valid_data()
    {
        $response = $this->post('/register/artisan', $this->validData);

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('users', ['email' => 'test@artisan.com']);
        $this->assertDatabaseHas('artisans', ['siret' => '12345678901234']);
    }

    public function test_registration_requires_all_fields()
    {
        $response = $this->withoutExceptionHandling()
            ->withSession(['_token' => csrf_token()])
            ->post('/register/artisan', []);

        $response->assertSessionHasErrors([
            'name' => 'Votre nom est requis pour créer un compte.',
            'email' => 'L\'adresse email est obligatoire.',
            'password' => 'Le mot de passe est obligatoire.',
            'phone' => 'Le numéro de téléphone est nécessaire pour être contacté par les clients.',
            'business_name' => 'Le nom de votre entreprise est obligatoire.',
            'siret' => 'Le numéro SIRET est obligatoire pour exercer en tant qu\'artisan.',
            'specialty' => 'Veuillez indiquer votre spécialité principale.',
            'description' => 'Une description de votre activité est nécessaire.',
            'experience_years' => 'Indiquez vos années d\'expérience.',
            'hourly_rate' => 'Veuillez indiquer votre taux horaire.',
            'service_area' => 'Veuillez préciser votre zone d\'intervention.',
            'terms' => 'Vous devez accepter les conditions générales pour continuer.'
        ]);
    }

    public function test_registration_validates_password_requirements()
    {
        // Test sans majuscule
        $invalidData = array_merge($this->validData, [
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => 'on'
        ]);

        $response = $this->withSession(['_token' => csrf_token()])
            ->post('/register/artisan', $invalidData);

        $response->assertSessionHasErrors([
            'password' => 'Le mot de passe doit contenir au moins une lettre majuscule.'
        ]);

        // Test sans minuscule
        $invalidData['password'] = $invalidData['password_confirmation'] = 'PASSWORD123';
        $response = $this->withSession(['_token' => csrf_token()])
            ->post('/register/artisan', $invalidData);

        $response->assertSessionHasErrors([
            'password' => 'Le mot de passe doit contenir au moins une lettre minuscule.'
        ]);

        // Test sans chiffre
        $invalidData['password'] = $invalidData['password_confirmation'] = 'PasswordOnly';
        $response = $this->withSession(['_token' => csrf_token()])
            ->post('/register/artisan', $invalidData);

        $response->assertSessionHasErrors([
            'password' => 'Le mot de passe doit contenir au moins un chiffre.'
        ]);
    }

    public function test_registration_validates_siret_format()
    {
        // Test SIRET trop court
        $response = $this->post('/register/artisan', array_merge(
            $this->validData,
            ['siret' => '123456789']
        ));
        $response->assertSessionHasErrors('siret');

        // Test SIRET trop long
        $response = $this->post('/register/artisan', array_merge(
            $this->validData,
            ['siret' => '123456789012345']
        ));
        $response->assertSessionHasErrors('siret');

        // Test SIRET avec des lettres
        $response = $this->post('/register/artisan', array_merge(
            $this->validData,
            ['siret' => '1234567890123A']
        ));
        $response->assertSessionHasErrors('siret');
    }

    public function test_registration_prevents_duplicate_email()
    {
        User::factory()->create(['email' => 'test@artisan.com']);
        $response = $this->post('/register/artisan', $this->validData);
        $response->assertSessionHasErrors('email');
    }

    public function test_registration_prevents_duplicate_siret()
    {
        $user = User::factory()->create(['role' => 'artisan']);
        Artisan::factory()->create([
            'user_id' => $user->id,
            'siret' => '12345678901234'
        ]);

        $response = $this->post('/register/artisan', $this->validData);
        $response->assertSessionHasErrors('siret');
    }

    public function test_description_minimum_length()
    {
        $response = $this->post('/register/artisan', array_merge(
            $this->validData,
            ['description' => 'Trop court']
        ));
        $response->assertSessionHasErrors('description');
    }

    public function test_terms_must_be_accepted()
    {
        $dataWithoutTerms = $this->validData;
        unset($dataWithoutTerms['terms']);

        $response = $this->withSession(['_token' => csrf_token()])
            ->from('/register/artisan')
            ->post('/register/artisan', $dataWithoutTerms);

        $response->assertSessionHasErrors([
            'terms' => 'Vous devez accepter les conditions générales pour continuer.'
        ]);
    }
}
