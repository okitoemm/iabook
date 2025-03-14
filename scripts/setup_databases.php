<?php

$databases = [
    'artisan_btp',        // Production
    'artisan_btp_testing' // Tests
];

$host = '127.0.0.1';
$user = 'root';
$pass = 'Abcdefgh1';

$sql = file_get_contents(__DIR__ . '/../database/sql/create_all_tables.sql');

foreach ($databases as $dbName) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "Configuration de $dbName...\n";
        
        // Exécuter les requêtes SQL
        $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
        foreach (explode(';', $sql) as $query) {
            if (trim($query)) {
                $pdo->exec($query);
                echo ".";
            }
        }
        $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
        
        echo "\nBase $dbName configurée avec succès!\n";
        
    } catch (PDOException $e) {
        die("Erreur sur $dbName: " . $e->getMessage() . "\n");
    }
}
