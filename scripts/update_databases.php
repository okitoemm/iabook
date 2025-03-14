<?php

$databases = [
    'artisan_btp',        // Production
    'artisan_btp_testing' // Tests
];

$host = '127.0.0.1';
$user = 'root';
$pass = 'Abcdefgh1';

$sql = file_get_contents(__DIR__ . '/../database/sql/add_google_auth.sql');

foreach ($databases as $dbName) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "Mise à jour de la base $dbName...\n";
        
        // Exécuter les requêtes SQL
        $pdo->exec($sql);
        
        echo "Base $dbName mise à jour avec succès!\n";
        
    } catch (PDOException $e) {
        die("Erreur sur $dbName: " . $e->getMessage() . "\n");
    }
}
