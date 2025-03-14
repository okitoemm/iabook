
-- Ajouter les colonnes pour l'authentification Google à la table users
ALTER TABLE users 
ADD COLUMN google_id VARCHAR(255) NULL AFTER email,
ADD COLUMN avatar VARCHAR(255) NULL AFTER google_id,
ADD COLUMN email_verified_at TIMESTAMP NULL AFTER avatar;

-- Ajouter les colonnes pour le rôle et le softdelete si elles n'existent pas
ALTER TABLE users
ADD COLUMN role VARCHAR(50) NULL AFTER remember_token,
ADD COLUMN deleted_at TIMESTAMP NULL;

-- Créer les tables nécessaires pour l'authentification
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) NOT NULL PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INT NOT NULL
);

-- Créer l'index pour les sessions
CREATE INDEX sessions_user_id_index ON sessions(user_id);
CREATE INDEX sessions_last_activity_index ON sessions(last_activity);
