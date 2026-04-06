-- =====================================================
-- SPRINT 3 : Monétisation & Tunnel de Vente
-- Migration SQL - Tables complémentaires
-- =====================================================

-- Ajout colonne product_type et formation_id sur order_items
-- pour lier les achats aux formations
ALTER TABLE order_items 
    ADD COLUMN product_type ENUM('formation', 'pack', 'consulting', 'subscription') DEFAULT 'formation' AFTER product_id,
    ADD COLUMN product_name VARCHAR(255) DEFAULT NULL AFTER product_type;

-- Ajout colonnes Stripe sur orders
ALTER TABLE orders
    ADD COLUMN stripe_payment_intent VARCHAR(255) DEFAULT NULL AFTER stripe_session_id,
    ADD COLUMN invoice_number VARCHAR(50) DEFAULT NULL AFTER customer_email,
    ADD COLUMN billing_name VARCHAR(255) DEFAULT NULL AFTER invoice_number,
    ADD COLUMN billing_address TEXT DEFAULT NULL AFTER billing_name,
    ADD COLUMN notes TEXT DEFAULT NULL AFTER billing_address;

-- Table des factures
CREATE TABLE IF NOT EXISTS invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    user_id INT NOT NULL,
    invoice_number VARCHAR(50) NOT NULL UNIQUE,
    amount_ht DECIMAL(10, 2) NOT NULL,
    tax_rate DECIMAL(5, 2) DEFAULT 0.00,
    tax_amount DECIMAL(10, 2) DEFAULT 0.00,
    amount_ttc DECIMAL(10, 2) NOT NULL,
    billing_name VARCHAR(255),
    billing_email VARCHAR(255),
    billing_address TEXT,
    billing_company VARCHAR(255) DEFAULT NULL,
    billing_siret VARCHAR(20) DEFAULT NULL,
    status ENUM('draft', 'sent', 'paid', 'cancelled') DEFAULT 'draft',
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_invoice_number (invoice_number),
    INDEX idx_user_id (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des séquences email automatiques
CREATE TABLE IF NOT EXISTS email_sequences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    trigger_event ENUM('purchase', 'enrollment', 'completion', 'abandoned_cart', 'welcome') NOT NULL,
    delay_days INT DEFAULT 0,
    subject VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_trigger (trigger_event),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des logs d'emails envoyés
CREATE TABLE IF NOT EXISTS email_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL,
    sequence_id INT DEFAULT NULL,
    email_to VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    status ENUM('sent', 'failed', 'opened', 'clicked') DEFAULT 'sent',
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    opened_at TIMESTAMP NULL,
    error_message TEXT DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (sequence_id) REFERENCES email_sequences(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_sent_at (sent_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des codes promo
CREATE TABLE IF NOT EXISTS promo_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    discount_type ENUM('percent', 'fixed') NOT NULL DEFAULT 'percent',
    discount_value DECIMAL(10, 2) NOT NULL,
    max_uses INT DEFAULT NULL,
    used_count INT DEFAULT 0,
    valid_from TIMESTAMP NULL,
    valid_until TIMESTAMP NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_code (code),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ajout colonne promo_code_id sur orders
ALTER TABLE orders
    ADD COLUMN promo_code_id INT DEFAULT NULL AFTER notes,
    ADD COLUMN discount_amount DECIMAL(10, 2) DEFAULT 0.00 AFTER promo_code_id;

-- Insertion des séquences email par défaut
INSERT INTO email_sequences (name, trigger_event, delay_days, subject, body) VALUES
('Bienvenue post-achat', 'purchase', 0, 'Bienvenue dans votre formation !', 'Félicitations pour votre achat ! Votre formation est maintenant accessible depuis votre espace apprenant.'),
('Suivi J+1', 'purchase', 1, 'Avez-vous commencé votre formation ?', 'Nous espérons que vous avez bien commencé votre formation. N''hésitez pas à nous contacter si vous avez des questions.'),
('Relance J+3', 'purchase', 3, 'Votre progression dans la formation', 'Comment avancez-vous dans votre formation ? Continuez à apprendre pour obtenir votre certificat !'),
('Motivation J+7', 'purchase', 7, 'Une semaine déjà ! Continuez sur votre lancée', 'Cela fait une semaine que vous avez accès à votre formation. Continuez votre progression !'),
('Certificat J+30', 'completion', 0, 'Félicitations ! Votre certificat est prêt', 'Vous avez terminé votre formation avec succès. Téléchargez votre certificat depuis votre espace apprenant.'),
('Panier abandonné', 'abandoned_cart', 1, 'Votre formation vous attend !', 'Vous avez commencé une inscription mais ne l''avez pas finalisée. Votre formation est toujours disponible.');
