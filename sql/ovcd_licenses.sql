-- Table for plugin activation / domain lock (OVCD 404 Slimmer etc.)
-- Run this on the same DB as licenses if you use the /api/v1/activate flow.

CREATE TABLE IF NOT EXISTS ovcd_licenses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    license_key VARCHAR(255) NOT NULL,
    product_id VARCHAR(128) NOT NULL DEFAULT '404-slimmer',
    domain_registered VARCHAR(512) NULL COMMENT 'Domain locked to this license',
    license_type VARCHAR(64) NOT NULL DEFAULT 'standard',
    activated_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uk_license_product (license_key, product_id),
    INDEX idx_license_key (license_key),
    INDEX idx_product_id (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
