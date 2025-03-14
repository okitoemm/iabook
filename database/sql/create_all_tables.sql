-- Table users
CREATE TABLE IF NOT EXISTS users (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    google_id VARCHAR(255) NULL,
    avatar VARCHAR(255) NULL,
    role VARCHAR(50) NULL,
    phone VARCHAR(255) NULL,
    city VARCHAR(255) NULL,
    postal_code VARCHAR(10) NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    email_verified_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table artisans
CREATE TABLE IF NOT EXISTS artisans (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    business_name VARCHAR(255) NOT NULL,
    siret VARCHAR(14) NOT NULL UNIQUE,
    specialty VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    experience_years INT NOT NULL,
    hourly_rate DECIMAL(8, 2) NOT NULL,
    service_area VARCHAR(255) NOT NULL,
    is_verified BOOLEAN DEFAULT FALSE,
    rating_average DECIMAL(3, 2) DEFAULT 0.00,
    total_reviews INT DEFAULT 0,
    payment_methods JSON NULL,
    certifications JSON NULL,
    insurances JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table projects
CREATE TABLE IF NOT EXISTS projects (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    client_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(255) NOT NULL,
    budget DECIMAL(10, 2) NULL,
    budget_type VARCHAR(50) NOT NULL,
    city VARCHAR(255) NOT NULL,
    postal_code VARCHAR(10) NOT NULL,
    address TEXT NOT NULL,
    urgent BOOLEAN DEFAULT FALSE,
    verification_method VARCHAR(50) NOT NULL,
    availability_days JSON NOT NULL,
    availability_hours JSON NOT NULL,
    status VARCHAR(50) DEFAULT 'open',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (client_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table messages
CREATE TABLE IF NOT EXISTS messages (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    sender_id BIGINT UNSIGNED NOT NULL,
    receiver_id BIGINT UNSIGNED NOT NULL,
    project_id BIGINT UNSIGNED NULL,
    content TEXT NOT NULL,
    estimated_price DECIMAL(10, 2) NULL,
    estimated_days INT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table reviews
CREATE TABLE IF NOT EXISTS reviews (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    artisan_id BIGINT UNSIGNED NOT NULL,
    client_id BIGINT UNSIGNED NOT NULL,
    project_id BIGINT UNSIGNED NOT NULL,
    rating INT NOT NULL,
    comment TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (artisan_id) REFERENCES artisans(id),
    FOREIGN KEY (client_id) REFERENCES users(id),
    FOREIGN KEY (project_id) REFERENCES projects(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table project_files
CREATE TABLE IF NOT EXISTS project_files (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    project_id BIGINT UNSIGNED NOT NULL,
    type ENUM('photo', 'video', 'document') NOT NULL,
    path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
