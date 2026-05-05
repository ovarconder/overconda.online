-- Orders table — captures Stripe checkout data
-- This is populated by the Stripe webhook handler (api/checkout/webhook)
CREATE TABLE IF NOT EXISTS ovcd_orders (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL COMMENT 'Stripe Checkout Session ID',
    customer_email VARCHAR(255) NULL,
    customer_name VARCHAR(255) NULL,
    plan VARCHAR(64) NOT NULL COMMENT 'personal | pro | agency',
    license_type VARCHAR(64) NOT NULL COMMENT 'subscription | lifetime | founder',
    amount INT UNSIGNED NOT NULL COMMENT 'Amount in cents (USD)',
    currency VARCHAR(8) NOT NULL DEFAULT 'usd',
    status VARCHAR(32) NOT NULL DEFAULT 'pending' COMMENT 'pending | completed | refunded',
    stripe_event_id VARCHAR(255) NULL,
    raw_response JSON NULL COMMENT 'Full Stripe event payload',
    license_key VARCHAR(255) NULL COMMENT 'Generated license key for this order',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uk_session_id (session_id),
    INDEX idx_customer_email (customer_email),
    INDEX idx_plan (plan),
    INDEX idx_license_type (license_type),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
