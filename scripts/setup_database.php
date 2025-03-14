<?php

$dbName = $argv[1] ?? 'artisan_btp'; // Premier argument en ligne de commande
$host = '127.0.0.1';
$user = 'root';
$pass = 'Abcdefgh1';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ajouter les colonnes Google Auth
    $queries = [
        "ALTER TABLE users 
         ADD COLUMN IF NOT EXISTS google_id VARCHAR(255) NULL AFTER email,
         ADD COLUMN IF NOT EXISTS avatar VARCHAR(255) NULL AFTER google_id,
         ADD COLUMN IF NOT EXISTS email_verified_at TIMESTAMP NULL AFTER avatar",

        "ALTER TABLE users
         ADD COLUMN IF NOT EXISTS role VARCHAR(50) NULL AFTER remember_token,
         ADD COLUMN IF NOT EXISTS deleted_at TIMESTAMP NULL"
    ];

    foreach ($queries as $query) {
        $pdo->exec($query);
        echo "Requête exécutée avec succès: " . substr($query, 0, 50) . "...\n";
    }

    echo "Configuration de la base de données terminée!\n";

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage() . "\n");
}
