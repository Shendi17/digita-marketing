-- Création des tables pour articles de blog et formations

-- Table des catégories de services
CREATE TABLE IF NOT EXISTS service_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    icon VARCHAR(50),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des articles de blog
CREATE TABLE IF NOT EXISTS blog_articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category_id INT,
    service_name VARCHAR(255) NOT NULL,
    excerpt TEXT,
    content LONGTEXT NOT NULL,
    image_url VARCHAR(500),
    author_id INT,
    views INT DEFAULT 0,
    status ENUM('draft', 'published', 'archived') DEFAULT 'published',
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES service_categories(id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_category (category_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des formations
CREATE TABLE IF NOT EXISTS formations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category_id INT,
    service_name VARCHAR(255) NOT NULL,
    description TEXT,
    level ENUM('debutant', 'intermediaire', 'avance') DEFAULT 'debutant',
    duration_hours INT DEFAULT 0,
    price DECIMAL(10,2) DEFAULT 0.00,
    image_url VARCHAR(500),
    video_intro_url VARCHAR(500),
    status ENUM('draft', 'published', 'archived') DEFAULT 'published',
    enrolled_count INT DEFAULT 0,
    rating DECIMAL(3,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES service_categories(id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_category (category_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des modules de formation
CREATE TABLE IF NOT EXISTS formation_modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    formation_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    order_num INT DEFAULT 0,
    duration_minutes INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE CASCADE,
    INDEX idx_formation (formation_id),
    INDEX idx_order (order_num)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des leçons de formation
CREATE TABLE IF NOT EXISTS formation_lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    module_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT,
    video_url VARCHAR(500),
    resources TEXT,
    order_num INT DEFAULT 0,
    duration_minutes INT DEFAULT 0,
    is_free BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (module_id) REFERENCES formation_modules(id) ON DELETE CASCADE,
    INDEX idx_module (module_id),
    INDEX idx_order (order_num)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des inscriptions aux formations
CREATE TABLE IF NOT EXISTS formation_enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    formation_id INT NOT NULL,
    progress INT DEFAULT 0,
    completed BOOLEAN DEFAULT FALSE,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (formation_id) REFERENCES formations(id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (user_id, formation_id),
    INDEX idx_user (user_id),
    INDEX idx_formation (formation_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des commentaires d'articles
CREATE TABLE IF NOT EXISTS blog_comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    user_id INT,
    author_name VARCHAR(100),
    author_email VARCHAR(255),
    content TEXT NOT NULL,
    status ENUM('pending', 'approved', 'spam') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES blog_articles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_article (article_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des tags
CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table de liaison articles-tags
CREATE TABLE IF NOT EXISTS article_tags (
    article_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (article_id, tag_id),
    FOREIGN KEY (article_id) REFERENCES blog_articles(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion des catégories principales
INSERT INTO service_categories (name, slug, icon, description) VALUES
('Réseaux Sociaux', 'reseaux-sociaux', '📱', 'Community management et publicité sur les réseaux sociaux'),
('Design Graphique', 'design-graphique', '🎨', 'Identité visuelle et création graphique'),
('Production Vidéo', 'production-video', '🎬', 'Vidéos promotionnelles et multimédia'),
('Création Web', 'creation-web', '💻', 'Sites web et applications'),
('SEO', 'seo', '📈', 'Référencement naturel et optimisation'),
('Publicité en Ligne', 'publicite-en-ligne', '💰', 'Google Ads et publicité display'),
('Email Marketing', 'email-marketing', '✉️', 'Campagnes email et automation'),
('Analytics', 'analytics', '📊', 'Analyse de données et reporting'),
('Stratégie Digitale', 'strategie-digitale', '🎯', 'Conseil et stratégie marketing'),
('Rédaction', 'redaction', '📝', 'Content marketing et copywriting'),
('Intelligence Artificielle', 'intelligence-artificielle', '🤖', 'IA, chatbots et automatisation'),
('E-commerce', 'e-commerce', '🛒', 'Boutiques en ligne et marketplaces'),
('Applications Mobiles', 'applications-mobiles', '📱', 'Développement mobile iOS et Android'),
('Formation', 'formation', '🎓', 'Formations et accompagnement'),
('Sécurité', 'securite', '🔐', 'Sécurité web et maintenance'),
('Événementiel', 'evenementiel', '🎪', 'Événements digitaux et webinaires'),
('Marketing d\'Influence', 'marketing-influence', '🎮', 'Campagnes avec influenceurs'),
('CRM', 'crm', '📞', 'Relation client et CRM');
