-- Ajouter la colonne si elle n'existe pas
ALTER TABLE artisans ADD COLUMN IF NOT EXISTS status VARCHAR(50) DEFAULT 'pending' AFTER user_id;

-- Mettre à jour les enregistrements existants en utilisant la clé primaire
UPDATE artisans a
INNER JOIN (SELECT id FROM artisans WHERE status IS NULL) b
ON a.id = b.id
SET a.status = 'pending';
