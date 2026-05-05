-- Paradise Pags Integration - Database Schema
-- Execute this SQL to create the required tables

CREATE DATABASE IF NOT EXISTS paradise_pags;
USE paradise_pags;

-- Settings table
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) NOT NULL UNIQUE,
    value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert API Key (replace with your actual key or update via app)
INSERT INTO settings (`key`, value) VALUES ('PARADISE_API_KEY', 'sk_b982966dd0746017ad634a7c05dafd331b3fda607cac4e81bb5ab8cf8d634581')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('KWAI_PIXEL_ID', '')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('kwai_pixel_ativo', '0')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('kwai_pixel_id', '')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('kwai_access_token', '')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('kwai_test_flag_default', 'false')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('kwai_mmpcode', 'PL')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('kwai_third_party', 'shopline')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('kwai_track_flag', 'true')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('kwai_pixel_sdk_version', '9.9.9')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('CLICK_ID_PARAM', 'clickid')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('ADMIN_USERNAME', 'admin')
ON DUPLICATE KEY UPDATE value = VALUES(value);

INSERT INTO settings (`key`, value) VALUES ('ADMIN_PASSWORD', '$2y$10$abcdefghijklmnopqrstuvwxyz1234567890')
ON DUPLICATE KEY UPDATE value = VALUES(value);

-- Transactions table
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    external_id VARCHAR(255) NOT NULL UNIQUE COMMENT 'transaction_id from Paradise',
    reference VARCHAR(255) NOT NULL COMMENT 'Our reference (REF-...)',
    amount INT NOT NULL COMMENT 'Amount in cents',
    status ENUM('pending', 'approved', 'paid', 'rejected', 'cancelled') DEFAULT 'pending',
    pix_code TEXT COMMENT 'PIX copy-paste code',
    qr_code_base64 TEXT COMMENT 'QR Code image in base64',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_external_id (external_id),
    INDEX idx_reference (reference),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;