-- Migration Intelligence Memory (Sprint 6)
-- Table pour stocker le contexte business extrait par les agents au fil des conversations

CREATE TABLE IF NOT EXISTS client_context (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    user_id INT NULL,
    
    -- Informations Business extraites
    business_sector VARCHAR(255) NULL,
    business_goals TEXT NULL,
    target_audience TEXT NULL,
    estimated_budget VARCHAR(100) NULL,
    current_pain_points TEXT NULL,
    competitors TEXT NULL,
    
    -- Profiling Agent
    preferred_expertise VARCHAR(50) DEFAULT 'strategic',
    lead_score INT DEFAULT 0,
    
    -- Métadonnées
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX (session_id),
    INDEX (user_id)
);
