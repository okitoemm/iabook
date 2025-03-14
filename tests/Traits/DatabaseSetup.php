<?php

namespace Tests\Traits;

use Illuminate\Support\Facades\DB;

trait DatabaseSetup
{
    protected function setupDatabase()
    {
        // Créer les tables nécessaires pour les tests
        DB::statement("
            CREATE TABLE IF NOT EXISTS `users` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `email` varchar(255) NOT NULL UNIQUE,
                `google_id` varchar(255) NULL,
                `avatar` varchar(255) NULL,
                `role` varchar(50) NULL,
                `phone` varchar(255) NULL,
                `city` varchar(255) NULL,
                `postal_code` varchar(10) NULL,
                `password` varchar(255) NOT NULL,
                `remember_token` varchar(100) NULL,
                `email_verified_at` timestamp NULL,
                `created_at` timestamp NULL,
                `updated_at` timestamp NULL,
                `deleted_at` timestamp NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Autres tables nécessaires...
    }
}
