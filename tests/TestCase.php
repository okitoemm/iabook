<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Configuration de la base de test
        config(['database.default' => 'testing']);
        
        // Exécuter les migrations fraîches
        Artisan::call('migrate:fresh', [
            '--database' => 'testing',
            '--seed' => false
        ]);

        // Démarrer la session pour les tests
        Session::start();
    }
}
