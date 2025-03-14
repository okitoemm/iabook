-- Ajouter la colonne status
ALTER TABLE artisans 
ADD COLUMN status VARCHAR(50) DEFAULT 'pending' AFTER user_id;

-- Mettre à jour les enregistrements existants
UPDATE artisans SET status = 'pending' WHERE status IS NULL;

-- Optionnel : Ajouter un index pour améliorer les performances des requêtes sur le status
CREATE INDEX idx_artisans_status ON artisans(status);
