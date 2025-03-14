<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PrepareTestDatabase extends Command
{
    protected $signature = 'test:prepare';
    protected $description = 'Prépare la base de données de test';

    public function handle()
    {
        $dbName = config('database.connections.testing.database');
        
        try {
            DB::statement("CREATE DATABASE IF NOT EXISTS $dbName");
            $this->info("Base de test '$dbName' créée ou existante.");

            // Utiliser la nouvelle base
            config(['database.default' => 'testing']);
            DB::purge('testing');
            DB::reconnect('testing');

            // Exécuter les requêtes SQL pour créer les tables
            DB::unprepared(file_get_contents(database_path('sql/create_all_tables.sql')));
            
            $this->info('Tables de test créées avec succès.');
            
        } catch (\Exception $e) {
            $this->error("Erreur: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
