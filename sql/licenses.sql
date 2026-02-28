-- License validation table for Envato-based licensing
-- Run this SQL to create the table (MySQL/MariaDB)

CREATE TABLE IF NOT EXISTS licenses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    license_key VARCHAR(255) NOT NULL COMMENT 'License key / Envato purchase code from plugin',
    envato_item_id INT UNSIGNED NULL COMMENT 'Envato item ID from API response',
    envato_item_name VARCHAR(255) NULL,
    envato_buyer VARCHAR(255) NULL,
    supported_until DATE NULL COMMENT 'Support expiry from Envato',
    site_url VARCHAR(512) NULL COMMENT 'WordPress site URL (optional domain binding)',
    status ENUM('valid', 'invalid', 'expired', 'revoked') NOT NULL DEFAULT 'valid',
    last_validated_at DATETIME NULL,
    raw_response JSON NULL COMMENT 'Last Envato API response (for debugging)',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uk_license_key (license_key),
    INDEX idx_status (status),
    INDEX idx_last_validated (last_validated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional: audit log for each validation attempt (for compliance/debugging)
CREATE TABLE IF NOT EXISTS license_validation_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    license_key VARCHAR(255) NOT NULL,
    site_url VARCHAR(512) NULL,
    is_valid TINYINT(1) NOT NULL,
    http_code INT NULL,
    error_message VARCHAR(512) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_license_key (license_key),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
