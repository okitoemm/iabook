-- Désactiver le mode safe update
SET SQL_SAFE_UPDATES = 0;

-- Vérifier si la colonne existe déjà
SET @exist := (
    SELECT COUNT(*)
    FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = 'artisan_btp'
    AND TABLE_NAME = 'artisans'
    AND COLUMN_NAME = 'status'
);

-- Ajouter la colonne uniquement si elle n'existe pas
SET @query = IF(
    @exist = 0,
    'ALTER TABLE artisans ADD COLUMN status VARCHAR(50) DEFAULT "pending" AFTER user_id',
    'SELECT "Column already exists"'
);

PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Mettre à jour les enregistrements existants
UPDATE artisans SET status = 'pending' WHERE status IS NULL;

-- Réactiver le mode safe update
SET SQL_SAFE_UPDATES = 1;
