-- ============================================
-- DIGITA MARKETING - Données de production OVH
-- Fichier complet : structure + données
-- À exécuter dans phpMyAdmin sur la BDD OVH
-- ============================================

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- ============================================
-- 1. STRUCTURE DES TABLES
-- ============================================

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('new', 'read', 'replied') DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'editor', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS content (
    id INT PRIMARY KEY AUTO_INCREMENT,
    page VARCHAR(50) NOT NULL,
    section VARCHAR(50) NOT NULL,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT,
    icone VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS team_members (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    poste VARCHAR(100) NOT NULL,
    photo VARCHAR(255) NOT NULL,
    ordre INT DEFAULT 0,
    active TINYINT(1) DEFAULT 1,
    linkedin VARCHAR(255),
    twitter VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS service_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    icon VARCHAR(50),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS formations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    article_slug VARCHAR(255) NULL,
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
    INDEX idx_article_slug (article_slug),
    INDEX idx_category (category_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS article_tags (
    article_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (article_id, tag_id),
    FOREIGN KEY (article_id) REFERENCES blog_articles(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    stripe_session_id VARCHAR(255),
    amount DECIMAL(10, 2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'EUR',
    status ENUM('pending', 'paid', 'cancelled', 'refunded') DEFAULT 'pending',
    customer_email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    category_id INT,
    stock INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    transaction_id VARCHAR(255),
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 2. ADMIN : tonyalpha80@gmail.com / admin123
-- ============================================

INSERT INTO users (username, password, email, role) VALUES
('admin', '$2y$10$Ndv3vaaCPOrsyVQ.cZugFu1zz82J571qSfDIXznkb.zBQB2KXUlNu', 'tonyalpha80@gmail.com', 'admin');

-- ============================================
-- 3. CONTENT + EQUIPE
-- ============================================

INSERT INTO content (page, section, titre, contenu) VALUES
('about', 'histoire', 'Notre Histoire', 'Fondee en 2015 par une equipe de passionnes du digital, DIGITA s''est rapidement imposee comme un acteur majeur du marketing digital en France.');

INSERT INTO content (page, section, titre, contenu, icone) VALUES
('about', 'valeurs', 'Innovation', 'Toujours a la pointe des dernieres tendances digitales', 'fa-lightbulb'),
('about', 'valeurs', 'Engagement', 'Des resultats concrets pour nos clients', 'fa-handshake'),
('about', 'valeurs', 'Collaboration', 'Un travail d''equipe pour des solutions optimales', 'fa-users'),
('about', 'valeurs', 'Excellence', 'La qualite au coeur de nos services', 'fa-chart-line');

INSERT INTO team_members (nom, poste, photo, ordre, linkedin, twitter) VALUES
('Thomas Martin', 'CEO & Fondateur', 'thomas-martin.jpg', 1, 'https://linkedin.com/in/thomasmartin', 'https://twitter.com/thomasmartin'),
('Sophie Dubois', 'Directrice Marketing', 'sophie-dubois.jpg', 2, 'https://linkedin.com/in/sophiedubois', 'https://twitter.com/sophiedubois'),
('Lucas Bernard', 'Directeur Technique', 'lucas-bernard.jpg', 3, 'https://linkedin.com/in/lucasbernard', 'https://twitter.com/lucasbernard'),
('Emma Laurent', 'Directrice Artistique', 'emma-laurent.jpg', 4, 'https://linkedin.com/in/emmalaurent', 'https://twitter.com/emmalaurent'),
('Marie Petit', 'Chef de Projet Digital', 'marie-petit.jpg', 5, 'https://linkedin.com/in/mariepetit', 'https://twitter.com/mariepetit'),
('Antoine Durand', 'Expert SEO', 'antoine-durand.jpg', 6, 'https://linkedin.com/in/antoinedurand', 'https://twitter.com/antoinedurand'),
('Julie Moreau', 'Social Media Manager', 'julie-moreau.jpg', 7, 'https://linkedin.com/in/juliemoreau', 'https://twitter.com/juliemoreau'),
('Pierre Leroy', 'Developpeur Full-Stack', 'pierre-leroy.jpg', 8, 'https://linkedin.com/in/pierreleroy', 'https://twitter.com/pierreleroy');

-- ============================================
-- 4. CATEGORIES (IDs 1-18)
-- ============================================

INSERT INTO service_categories (name, slug, icon, description) VALUES
('Reseaux Sociaux', 'reseaux-sociaux', '📱', 'Community management et publicite sur les reseaux sociaux'),
('Design Graphique', 'design-graphique', '🎨', 'Identite visuelle et creation graphique'),
('Production Video', 'production-video', '🎬', 'Videos promotionnelles et multimedia'),
('Creation Web', 'creation-web', '💻', 'Sites web et applications'),
('SEO', 'seo', '📈', 'Referencement naturel et optimisation'),
('Publicite en Ligne', 'publicite-en-ligne', '💰', 'Google Ads et publicite display'),
('Email Marketing', 'email-marketing', '✉️', 'Campagnes email et automation'),
('Analytics', 'analytics', '📊', 'Analyse de donnees et reporting'),
('Strategie Digitale', 'strategie-digitale', '🎯', 'Conseil et strategie marketing'),
('Redaction', 'redaction', '📝', 'Content marketing et copywriting'),
('Intelligence Artificielle', 'intelligence-artificielle', '🤖', 'IA, chatbots et automatisation'),
('E-commerce', 'e-commerce', '🛒', 'Boutiques en ligne et marketplaces'),
('Applications Mobiles', 'applications-mobiles', '📱', 'Developpement mobile iOS et Android'),
('Formation', 'formation', '🎓', 'Formations et accompagnement'),
('Securite', 'securite', '🔐', 'Securite web et maintenance'),
('Evenementiel', 'evenementiel', '🎪', 'Evenements digitaux et webinaires'),
('Marketing d''Influence', 'marketing-influence', '🎮', 'Campagnes avec influenceurs'),
('CRM', 'crm', '📞', 'Relation client et CRM');

-- ============================================
-- 5. TAGS
-- ============================================

INSERT INTO tags (name, slug) VALUES
('SEO', 'seo'), ('Marketing Digital', 'marketing-digital'), ('Reseaux Sociaux', 'reseaux-sociaux'),
('E-commerce', 'e-commerce'), ('Design', 'design'), ('Google Ads', 'google-ads'),
('Email Marketing', 'email-marketing'), ('Intelligence Artificielle', 'intelligence-artificielle'),
('Strategie', 'strategie'), ('Conversion', 'conversion'), ('Analytics', 'analytics'),
('Content Marketing', 'content-marketing'), ('Video', 'video'), ('Mobile', 'mobile'),
('Securite', 'securite'), ('CRM', 'crm'), ('Influence', 'influence'), ('Evenementiel', 'evenementiel');

-- ============================================
-- 6. ARTICLES DE BLOG (2-3 par categorie, 18 categories)
-- ============================================

-- Cat 1 : Reseaux Sociaux
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Strategie Social Media efficace en 2025', 'strategie-social-media-2025', 1, 'Reseaux Sociaux',
'Les meilleures pratiques pour developper votre presence sur les reseaux sociaux.',
'<h2>Introduction</h2><p>Les reseaux sociaux sont devenus incontournables pour toute entreprise souhaitant developper sa visibilite en ligne. En 2025, les algorithmes evoluent constamment.</p><h2>1. Definir ses objectifs</h2><p>Avant de publier, definissez clairement vos objectifs : notoriete, engagement, conversion, fidelisation.</p><h2>2. Connaitre son audience</h2><p>Utilisez les outils analytics de chaque plateforme pour comprendre votre audience.</p><h2>3. Calendrier editorial</h2><p>Planifiez vos publications avec un mix : educatif (40%), divertissant (30%), promotionnel (20%), inspirant (10%).</p><h2>4. Mesurer et optimiser</h2><p>Analysez vos KPIs chaque semaine : taux d''engagement, portee, clics, conversions.</p>',
'/assets/images/blog/social-media-strategy.jpg', 245, 'published', '2025-01-15 10:00:00'),

('Templates reseaux sociaux : guide complet', 'templates-reseaux-sociaux', 1, 'Reseaux Sociaux',
'Les meilleurs templates pour vos publications sur Instagram, Facebook, LinkedIn et TikTok.',
'<h2>Pourquoi utiliser des templates ?</h2><p>Les templates maintiennent une coherence visuelle tout en gagnant du temps.</p><h2>Templates Instagram</h2><p>Formats carres (1080x1080) ou verticaux (1080x1350). Couleurs coherentes avec votre charte graphique.</p><h2>Templates Facebook</h2><p>Images horizontales (1200x630). Pensez aux carrousels pour raconter une histoire.</p><h2>Templates LinkedIn</h2><p>Contenu professionnel avec des templates sobres, donnees chiffrees et infographies.</p><h2>Outils</h2><p>Canva, Figma, Adobe Express sont d''excellents outils pour creer vos templates.</p>',
'/assets/images/blog/templates-social.jpg', 189, 'published', '2025-02-01 09:00:00'),

('Stories Instagram et Facebook : maximiser l''engagement', 'stories-instagram-facebook', 1, 'Reseaux Sociaux',
'Creez des stories captivantes qui generent de l''engagement et des conversions.',
'<h2>Le pouvoir des Stories</h2><p>Les stories sont consultees par plus de 500 millions d''utilisateurs chaque jour sur Instagram.</p><h2>Bonnes pratiques</h2><p>Utilisez des stickers interactifs (sondages, questions, quiz), ajoutez des sous-titres, publiez regulierement.</p><h2>Stories pour la conversion</h2><p>Utilisez le sticker lien, creez des sequences narratives, et utilisez les highlights pour organiser votre contenu.</p>',
'/assets/images/blog/stories-engagement.jpg', 156, 'published', '2025-02-10 11:00:00');

-- Cat 2 : Design Graphique
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Tendances design graphique 2025', 'tendances-design-2025', 2, 'Design Graphique',
'Les tendances visuelles qui dominent le paysage du design graphique cette annee.',
'<h2>Le design en 2025</h2><p>Le design graphique evolue rapidement, influence par la technologie et la culture.</p><h2>1. Minimalisme audacieux</h2><p>Designs epures avec typographies fortes et couleurs vives.</p><h2>2. IA generative</h2><p>Midjourney et DALL-E transforment le processus creatif.</p><h2>3. Motion design</h2><p>Animations subtiles et micro-interactions enrichissent l''experience utilisateur.</p><h2>4. Design inclusif</h2><p>Accessibilite : contrastes suffisants, tailles adaptees, alternatives textuelles.</p>',
'/assets/images/blog/design-trends-2025.jpg', 312, 'published', '2025-01-20 14:00:00'),

('Bannieres publicitaires : visuels qui convertissent', 'bannieres-publicitaires', 2, 'Design Graphique',
'Guide pratique pour concevoir des bannieres publicitaires performantes.',
'<h2>L''art de la banniere</h2><p>Une banniere efficace doit capter l''attention en moins de 2 secondes.</p><h2>Formats essentiels</h2><p>Leaderboard (728x90), Rectangle (300x250), Skyscraper (160x600).</p><h2>Principes</h2><p>Un message clair, un visuel impactant, un CTA visible. Maximum 3 elements par banniere.</p><h2>Tests A/B</h2><p>Testez differentes versions : couleurs du CTA, texte, images. Mesurez les taux de clics.</p>',
'/assets/images/blog/bannieres-pub.jpg', 178, 'published', '2025-01-25 10:00:00'),

('Infographies digitales : raconter avec des donnees', 'infographies-digitales', 2, 'Design Graphique',
'Comment creer des infographies percutantes qui simplifient les donnees complexes.',
'<h2>Le pouvoir des infographies</h2><p>Les infographies sont partagees 3 fois plus que tout autre contenu sur les reseaux sociaux.</p><h2>Structure</h2><p>Titre accrocheur, introduction courte, donnees organisees, conclusion avec CTA.</p><h2>Outils</h2><p>Canva, Piktochart, Venngage, Infogram pour creer des infographies professionnelles.</p>',
'/assets/images/blog/infographies.jpg', 134, 'published', '2025-02-05 09:30:00');

-- Cat 3 : Production Video
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Video marketing : pourquoi c''est indispensable en 2025', 'video-marketing-2025', 3, 'Production Video',
'La video represente 82% du trafic internet. Voici comment en tirer parti pour votre entreprise.',
'<h2>La video domine le web</h2><p>En 2025, la video represente 82% du trafic internet mondial. Les consommateurs preferent regarder une video plutot que lire un texte.</p><h2>Types de videos</h2><p>Tutoriels, temoignages clients, presentations produits, lives, shorts/reels. Chaque format a son utilite.</p><h2>Production accessible</h2><p>Un smartphone recent suffit pour demarrer. L''authenticite prime sur la perfection technique.</p><h2>Distribution</h2><p>YouTube, TikTok, Instagram Reels, LinkedIn Video : adaptez le format a chaque plateforme.</p>',
'/assets/images/blog/video-marketing.jpg', 287, 'published', '2025-01-14 10:00:00'),

('Miniatures YouTube : l''art du clic', 'miniatures-youtube', 3, 'Production Video',
'Comment creer des miniatures YouTube qui maximisent votre taux de clics.',
'<h2>L''importance de la miniature</h2><p>90% des videos les plus performantes sur YouTube ont une miniature personnalisee. C''est le premier element que voit le spectateur.</p><h2>Regles d''or</h2><p>Visage expressif, texte court et lisible, couleurs contrastees, resolution 1280x720 minimum.</p><h2>Outils</h2><p>Canva, Photoshop, Figma. Testez differentes versions avec les analytics YouTube.</p>',
'/assets/images/blog/miniatures-youtube.jpg', 198, 'published', '2025-02-02 09:00:00');

-- Cat 4 : Creation Web
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Creer un site web performant en 2025', 'creer-site-web-performant-2025', 4, 'Creation Web',
'Les technologies et bonnes pratiques pour un site web rapide, accessible et bien reference.',
'<h2>Les fondamentaux</h2><p>Un site web performant repose sur trois piliers : vitesse, accessibilite et SEO.</p><h2>Technologies</h2><p>HTML5, CSS3, JavaScript moderne. Frameworks : React, Vue.js, Next.js pour les SPA. PHP, Laravel pour le backend.</p><h2>Performance</h2><p>Core Web Vitals : LCP < 2.5s, FID < 100ms, CLS < 0.1. Optimisez images, minifiez le code, utilisez un CDN.</p><h2>Mobile First</h2><p>60% du trafic est mobile. Concevez d''abord pour mobile, puis adaptez pour desktop.</p>',
'/assets/images/blog/site-web-performant.jpg', 356, 'published', '2025-01-08 10:00:00'),

('UX Design : les principes pour convertir', 'ux-design-principes-conversion', 4, 'Creation Web',
'Les principes UX essentiels pour transformer vos visiteurs en clients.',
'<h2>L''UX au service de la conversion</h2><p>Un bon design UX peut augmenter les conversions de 200%. L''experience utilisateur est un investissement rentable.</p><h2>Principes cles</h2><p>Hierarchie visuelle claire, navigation intuitive, temps de chargement rapide, formulaires simplifies.</p><h2>Tests utilisateurs</h2><p>Testez avec de vrais utilisateurs. Les heatmaps et les enregistrements de sessions revelent les points de friction.</p><h2>Accessibilite</h2><p>WCAG 2.1 : contrastes, navigation clavier, lecteurs d''ecran. L''accessibilite beneficie a tous.</p>',
'/assets/images/blog/ux-design.jpg', 234, 'published', '2025-01-22 14:00:00');

-- Cat 5 : SEO
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Guide SEO 2025 : optimiser son referencement naturel', 'guide-seo-2025', 5, 'SEO',
'Le guide complet pour ameliorer votre positionnement sur Google en 2025.',
'<h2>Le SEO en 2025</h2><p>Le referencement naturel reste le levier d''acquisition le plus rentable a long terme.</p><h2>1. Contenu de qualite</h2><p>Google privilegie le contenu expert, utile et original. Creez des articles approfondis.</p><h2>2. Optimisation technique</h2><p>Vitesse, mobile-first, structure des URLs, balisage schema.org.</p><h2>3. Backlinks</h2><p>Privilegiez la qualite a la quantite. Un lien d''un site autoritaire vaut plus que 100 liens faibles.</p><h2>4. Experience utilisateur</h2><p>Core Web Vitals sont des facteurs de classement. Optimisez vitesse et interactivite.</p>',
'/assets/images/blog/seo-guide-2025.jpg', 456, 'published', '2025-01-10 08:00:00'),

('SEO local : dominer les recherches de proximite', 'seo-local-guide', 5, 'SEO',
'Comment optimiser votre presence pour les recherches locales et Google Maps.',
'<h2>Le SEO local</h2><p>46% des recherches Google ont une intention locale. Le SEO local est crucial pour les commerces physiques.</p><h2>Google Business Profile</h2><p>Optimisez votre fiche : photos, horaires, categories, posts reguliers, reponses aux avis.</p><h2>Citations locales</h2><p>Inscrivez-vous sur les annuaires locaux avec des informations NAP coherentes (Nom, Adresse, Telephone).</p><h2>Avis clients</h2><p>Encouragez les avis positifs. Repondez a tous les avis, positifs comme negatifs.</p>',
'/assets/images/blog/seo-local.jpg', 278, 'published', '2025-02-06 10:00:00');

-- Cat 6 : Publicite en Ligne
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Google Ads : optimiser ses campagnes en 2025', 'google-ads-optimisation-2025', 6, 'Publicite en Ligne',
'Les meilleures strategies pour maximiser le ROI de vos campagnes Google Ads.',
'<h2>Google Ads en 2025</h2><p>Avec l''integration de l''IA, Google Ads offre des opportunites inedites.</p><h2>Performance Max</h2><p>Campagnes IA sur tous les canaux : Search, Display, YouTube, Gmail, Maps.</p><h2>Encheres automatiques</h2><p>Target CPA, Target ROAS pour optimiser. Laissez l''algorithme apprendre 2 semaines minimum.</p><h2>Quality Score</h2><p>Alignez mots-cles, annonces et pages de destination. Un QS eleve reduit votre CPC.</p>',
'/assets/images/blog/google-ads-2025.jpg', 289, 'published', '2025-01-22 10:00:00'),

('Facebook Ads : guide complet pour debutants', 'facebook-ads-guide-debutants', 6, 'Publicite en Ligne',
'Lancez vos premieres campagnes Facebook et Instagram Ads avec ce guide pas a pas.',
'<h2>Pourquoi Facebook Ads ?</h2><p>3 milliards d''utilisateurs actifs, un ciblage ultra-precis et des formats publicitaires varies.</p><h2>Structure de campagne</h2><p>Campagne > Ensemble de publicites > Publicites. Chaque niveau a ses parametres specifiques.</p><h2>Ciblage</h2><p>Audiences personnalisees, similaires, par centres d''interet. Le retargeting est votre meilleur allie.</p><h2>Formats</h2><p>Image, video, carrousel, collection, stories. Testez plusieurs formats pour trouver le plus performant.</p>',
'/assets/images/blog/facebook-ads.jpg', 234, 'published', '2025-02-08 11:00:00');

-- Cat 7 : Email Marketing
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Email Marketing : campagnes qui convertissent', 'email-marketing-conversion', 7, 'Email Marketing',
'Guide complet pour creer des emails marketing performants.',
'<h2>L''email marketing en 2025</h2><p>L''email reste le canal avec le meilleur ROI : 42 euros pour chaque euro investi.</p><h2>Segmentation</h2><p>Segmentez par comportement, demographie et engagement. Les emails segmentes generent 760% de revenus en plus.</p><h2>Objet</h2><p>Court (40-60 caracteres), personnalise et creant de la curiosite.</p><h2>Automation</h2><p>Sequences automatisees : bienvenue, abandon de panier, post-achat, reactivation.</p>',
'/assets/images/blog/email-marketing.jpg', 201, 'published', '2025-02-12 08:30:00'),

('Newsletter : fideliser votre audience', 'newsletter-fidelisation', 7, 'Email Marketing',
'Comment creer une newsletter qui fidelize vos abonnes et genere du trafic regulier.',
'<h2>La newsletter en 2025</h2><p>La newsletter reste un outil puissant pour maintenir le lien avec votre audience.</p><h2>Frequence</h2><p>Hebdomadaire ou bi-mensuelle. La regularite est plus importante que la frequence.</p><h2>Contenu</h2><p>Mix de contenu exclusif, actualites du secteur, conseils pratiques et offres speciales.</p><h2>Croissance</h2><p>Lead magnets, pop-ups intelligents, landing pages dediees pour faire grossir votre liste.</p>',
'/assets/images/blog/newsletter.jpg', 167, 'published', '2025-01-28 09:00:00');

-- Cat 8 : Analytics
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Google Analytics 4 : guide complet', 'google-analytics-4-guide', 8, 'Analytics',
'Maitrisez Google Analytics 4 pour prendre des decisions basees sur les donnees.',
'<h2>GA4 en 2025</h2><p>Google Analytics 4 est devenu la norme. Son approche basee sur les evenements offre plus de flexibilite.</p><h2>Configuration</h2><p>Installez GA4 via Google Tag Manager. Configurez les evenements personnalises et les conversions.</p><h2>Rapports essentiels</h2><p>Acquisition, engagement, monetisation, retention. Creez des rapports personnalises pour vos KPIs.</p><h2>Explorations</h2><p>Utilisez les explorations pour des analyses avancees : entonnoirs, parcours, cohortes.</p>',
'/assets/images/blog/ga4-guide.jpg', 345, 'published', '2025-01-12 10:00:00'),

('KPIs marketing : les metriques qui comptent', 'kpis-marketing-metriques', 8, 'Analytics',
'Identifiez les KPIs essentiels pour mesurer l''efficacite de vos actions marketing.',
'<h2>Choisir les bons KPIs</h2><p>Trop de metriques tuent la metrique. Concentrez-vous sur les indicateurs qui impactent votre business.</p><h2>Acquisition</h2><p>CPA (Cout par Acquisition), CAC (Cout d''Acquisition Client), taux de conversion par canal.</p><h2>Engagement</h2><p>Taux d''engagement, temps passe sur le site, pages par session, taux de rebond.</p><h2>Revenue</h2><p>ROAS, LTV (Lifetime Value), panier moyen, taux de retention.</p>',
'/assets/images/blog/kpis-marketing.jpg', 213, 'published', '2025-02-04 14:00:00');

-- Cat 9 : Strategie Digitale
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Construire sa strategie digitale de A a Z', 'strategie-digitale-complete', 9, 'Strategie Digitale',
'Methodologie complete pour elaborer une strategie digitale performante.',
'<h2>Pourquoi une strategie ?</h2><p>Sans strategie, vos actions manquent de coherence. Une strategie aligne vos efforts sur vos objectifs business.</p><h2>Audit</h2><p>Analysez votre presence actuelle : site web, reseaux sociaux, SEO, publicite.</p><h2>Personas</h2><p>Creez des profils detailles de vos clients ideaux : demographie, comportements, motivations.</p><h2>Plan d''action</h2><p>Canaux prioritaires, budget, calendrier et KPIs. Revoyez chaque trimestre.</p>',
'/assets/images/blog/strategie-digitale.jpg', 367, 'published', '2025-01-08 10:00:00'),

('Budget marketing digital : comment le repartir', 'budget-marketing-digital', 9, 'Strategie Digitale',
'Guide pour allouer efficacement votre budget marketing entre les differents canaux.',
'<h2>Repartition du budget</h2><p>Il n''existe pas de repartition universelle. Tout depend de vos objectifs, votre secteur et votre maturite digitale.</p><h2>Regle des 70/20/10</h2><p>70% sur ce qui fonctionne, 20% sur l''optimisation, 10% sur l''experimentation.</p><h2>Par canal</h2><p>SEO (20-30%), Publicite (25-35%), Contenu (15-20%), Social Media (10-15%), Email (5-10%).</p><h2>Mesurer le ROI</h2><p>Attribuez chaque euro depense a un resultat mesurable. Utilisez des modeles d''attribution multi-touch.</p>',
'/assets/images/blog/budget-marketing.jpg', 198, 'published', '2025-02-11 10:00:00');

-- Cat 10 : Redaction
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Copywriting : ecrire pour convertir', 'copywriting-ecrire-convertir', 10, 'Redaction',
'Les techniques de copywriting pour transformer vos lecteurs en clients.',
'<h2>Le copywriting</h2><p>Le copywriting est l''art d''ecrire pour persuader. Chaque mot compte quand l''objectif est la conversion.</p><h2>Formule AIDA</h2><p>Attention, Interet, Desir, Action. Structurez vos textes selon cette formule eprouvee.</p><h2>Titres magnetiques</h2><p>80% des gens lisent le titre, 20% lisent la suite. Investissez du temps dans vos titres.</p><h2>CTA efficaces</h2><p>Verbes d''action, urgence, benefice clair. "Obtenez votre guide gratuit" > "Cliquez ici".</p>',
'/assets/images/blog/copywriting.jpg', 234, 'published', '2025-01-16 10:00:00'),

('Content Marketing : strategie de contenu gagnante', 'content-marketing-strategie', 10, 'Redaction',
'Comment creer une strategie de contenu qui attire, engage et convertit.',
'<h2>Le content marketing</h2><p>Le content marketing coute 62% moins cher que le marketing traditionnel et genere 3 fois plus de leads.</p><h2>Piliers de contenu</h2><p>Definissez 3 a 5 themes principaux autour desquels creer tout votre contenu.</p><h2>Formats</h2><p>Articles de blog, videos, podcasts, infographies, ebooks, webinaires. Diversifiez vos formats.</p><h2>Distribution</h2><p>Creez une fois, distribuez partout. Recyclez votre contenu en plusieurs formats.</p>',
'/assets/images/blog/content-marketing.jpg', 189, 'published', '2025-02-07 09:00:00');

-- Cat 11 : Intelligence Artificielle
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('L''IA au service du marketing digital', 'ia-marketing-digital', 11, 'Intelligence Artificielle',
'Comment l''intelligence artificielle revolutionne le marketing digital.',
'<h2>La revolution IA</h2><p>L''IA transforme profondement le marketing digital. De la creation de contenu a l''analyse predictive.</p><h2>Chatbots</h2><p>Les chatbots IA gerent 80% des demandes clients courantes, 24h/24.</p><h2>Personnalisation</h2><p>L''IA personnalise l''experience de chaque visiteur : recommandations, contenu dynamique, emails.</p><h2>Creation de contenu</h2><p>ChatGPT, Jasper, Copy.ai accelerent la creation. Utilisez-les comme assistants.</p>',
'/assets/images/blog/ia-marketing.jpg', 412, 'published', '2025-01-05 10:00:00'),

('ChatGPT pour le marketing : guide pratique', 'chatgpt-marketing-guide', 11, 'Intelligence Artificielle',
'Utilisez ChatGPT pour booster votre productivite marketing au quotidien.',
'<h2>ChatGPT au quotidien</h2><p>ChatGPT peut vous aider dans presque toutes vos taches marketing : redaction, brainstorming, analyse, code.</p><h2>Prompts efficaces</h2><p>Soyez precis dans vos demandes. Donnez du contexte, un role, un format de sortie attendu.</p><h2>Cas d''usage</h2><p>Redaction d''emails, creation de posts sociaux, analyse de donnees, generation d''idees, SEO.</p><h2>Limites</h2><p>Verifiez toujours les faits. L''IA peut halluciner. Gardez votre touche humaine et votre expertise.</p>',
'/assets/images/blog/chatgpt-marketing.jpg', 389, 'published', '2025-02-01 10:00:00');

-- Cat 12 : E-commerce
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Cross-selling et upselling : booster vos ventes', 'cross-selling-upselling', 12, 'E-commerce',
'Strategies eprouvees pour augmenter le panier moyen de vos clients.',
'<h2>Augmentez votre CA</h2><p>Le cross-selling et l''upselling augmentent vos revenus de 10 a 30%.</p><h2>Cross-selling</h2><p>Proposez des produits complementaires : "Les clients ayant achete X ont aussi achete Y".</p><h2>Upselling</h2><p>Montrez la valeur ajoutee de la version superieure avec des tableaux comparatifs.</p><h2>Automatisation</h2><p>Algorithmes de recommandation pour personnaliser les suggestions.</p>',
'/assets/images/blog/cross-selling.jpg', 267, 'published', '2025-01-18 12:00:00'),

('Optimisation des fiches produits e-commerce', 'optimisation-fiches-produits', 12, 'E-commerce',
'Comment creer des fiches produits qui convertissent.',
'<h2>La fiche produit parfaite</h2><p>Une fiche optimisee peut doubler votre taux de conversion.</p><h2>Photos</h2><p>Minimum 5 photos : vue principale, details, mise en situation, zoom, packaging. La video augmente les conversions de 80%.</p><h2>Description</h2><p>Benefices en premier, caracteristiques ensuite. Bullet points pour la lisibilite.</p><h2>Avis clients</h2><p>Encouragez les avis avec des emails post-achat et des incentives.</p>',
'/assets/images/blog/fiches-produits.jpg', 198, 'published', '2025-02-08 10:00:00'),

('Abandon de panier : strategies de recuperation', 'abandon-panier', 12, 'E-commerce',
'70% des paniers sont abandonnes. Recuperez ces ventes perdues.',
'<h2>Le fleau de l''abandon</h2><p>70% des paniers e-commerce sont abandonnes chaque annee.</p><h2>Causes</h2><p>Frais de livraison inattendus (48%), creation de compte obligatoire (24%), processus trop long (18%).</p><h2>Recuperation</h2><p>Email de relance automatique (1h, 24h, 72h), retargeting, pop-up d''intention de sortie.</p><h2>Optimiser le checkout</h2><p>Guest checkout, auto-completion, multiples moyens de paiement, indicateur de progression.</p>',
'/assets/images/blog/abandon-panier.jpg', 223, 'published', '2025-01-28 11:00:00');

-- Cat 13 : Applications Mobiles
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Developpement mobile : natif vs cross-platform', 'developpement-mobile-natif-cross-platform', 13, 'Applications Mobiles',
'Natif, React Native ou Flutter ? Choisissez la bonne approche pour votre application.',
'<h2>Le choix technologique</h2><p>Le choix entre natif et cross-platform depend de votre budget, vos delais et vos besoins techniques.</p><h2>Natif (Swift/Kotlin)</h2><p>Performances optimales, acces complet aux APIs. Mais double developpement et cout eleve.</p><h2>React Native</h2><p>Code partage entre iOS et Android. Ecosysteme JavaScript. Ideal pour les MVPs et apps business.</p><h2>Flutter</h2><p>Framework Google avec Dart. Performances proches du natif. UI personnalisable et coherente.</p>',
'/assets/images/blog/dev-mobile.jpg', 267, 'published', '2025-01-19 10:00:00'),

('ASO : optimiser la visibilite de votre app', 'aso-optimisation-app-store', 13, 'Applications Mobiles',
'L''App Store Optimization pour augmenter les telechargements de votre application.',
'<h2>L''ASO en 2025</h2><p>L''ASO est le SEO des app stores. 65% des telechargements proviennent de recherches dans les stores.</p><h2>Titre et sous-titre</h2><p>Incluez vos mots-cles principaux dans le titre. 30 caracteres max sur iOS.</p><h2>Screenshots et video</h2><p>Les 3 premiers screenshots sont cruciaux. Montrez les fonctionnalites cles avec du texte explicatif.</p><h2>Avis et notes</h2><p>Demandez des avis au bon moment (apres une action positive). Repondez aux avis negatifs.</p>',
'/assets/images/blog/aso-app.jpg', 178, 'published', '2025-02-03 09:00:00');

-- Cat 14 : Formation
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Formation continue en marketing digital : pourquoi c''est essentiel', 'formation-continue-marketing-digital', 14, 'Formation',
'Le marketing digital evolue vite. La formation continue est la cle pour rester competitif.',
'<h2>Un secteur en evolution permanente</h2><p>Les outils, algorithmes et tendances changent chaque annee. Se former regulierement est indispensable.</p><h2>Formats de formation</h2><p>En ligne (MOOC, webinaires), en presentiel, certifications (Google, Meta, HubSpot), coaching individuel.</p><h2>Competences prioritaires</h2><p>IA et automatisation, analyse de donnees, video marketing, SEO avance.</p><h2>ROI de la formation</h2><p>Les entreprises qui investissent dans la formation ont 24% de marges beneficiaires superieures.</p>',
'/assets/images/blog/formation-continue.jpg', 156, 'published', '2025-01-24 10:00:00'),

('Creer et vendre des formations en ligne', 'creer-vendre-formations-en-ligne', 14, 'Formation',
'Guide complet pour creer, heberger et commercialiser vos formations en ligne.',
'<h2>Le marche de la formation en ligne</h2><p>Le e-learning represente un marche de 400 milliards de dollars en 2025. C''est le moment de se lancer.</p><h2>Creer votre formation</h2><p>Definissez votre expertise, structurez en modules, creez du contenu video et des exercices pratiques.</p><h2>Plateformes</h2><p>Teachable, Thinkific, Podia, ou votre propre site avec LMS. Chaque option a ses avantages.</p><h2>Marketing</h2><p>Webinaires gratuits, lead magnets, temoignages, garantie satisfait ou rembourse.</p>',
'/assets/images/blog/creer-formations.jpg', 189, 'published', '2025-02-09 11:00:00');

-- Cat 15 : Securite
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Securite web : proteger votre site et vos donnees', 'securite-web-proteger-site', 15, 'Securite',
'Les bonnes pratiques de securite web pour proteger votre entreprise et vos clients.',
'<h2>La securite n''est pas optionnelle</h2><p>43% des cyberattaques ciblent les PME. La securite web est un enjeu business majeur.</p><h2>HTTPS et SSL</h2><p>Un certificat SSL est obligatoire. Il protege les donnees en transit et ameliore le SEO.</p><h2>Mises a jour</h2><p>Mettez a jour CMS, plugins et dependances regulierement. Les failles connues sont les plus exploitees.</p><h2>Sauvegardes</h2><p>Sauvegardez quotidiennement. Testez vos restaurations. Stockez hors site (cloud).</p>',
'/assets/images/blog/securite-web.jpg', 234, 'published', '2025-01-11 10:00:00'),

('RGPD et conformite : guide pratique', 'rgpd-conformite-guide', 15, 'Securite',
'Mettez votre site en conformite RGPD : cookies, donnees personnelles, consentement.',
'<h2>Le RGPD en pratique</h2><p>Le RGPD impose des obligations strictes sur la collecte et le traitement des donnees personnelles.</p><h2>Consentement cookies</h2><p>Banniere de consentement conforme, refus aussi simple que l''acceptation, pas de cookies avant consentement.</p><h2>Politique de confidentialite</h2><p>Claire, accessible, detaillant les donnees collectees, leur usage et les droits des utilisateurs.</p><h2>Droits des utilisateurs</h2><p>Acces, rectification, suppression, portabilite. Mettez en place des processus pour repondre aux demandes.</p>',
'/assets/images/blog/rgpd-guide.jpg', 312, 'published', '2025-02-06 14:00:00');

-- Cat 16 : Evenementiel
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Webinaires : generer des leads qualifies', 'webinaires-generer-leads', 16, 'Evenementiel',
'Comment organiser des webinaires qui attirent et convertissent votre audience cible.',
'<h2>Le webinaire comme outil marketing</h2><p>Les webinaires generent en moyenne 500 a 1000 leads par session. C''est l''un des formats les plus efficaces en B2B.</p><h2>Preparation</h2><p>Choisissez un sujet qui resout un probleme precis. Creez une landing page dediee avec un formulaire d''inscription.</p><h2>Animation</h2><p>Duree ideale : 45-60 minutes. Alternez presentation, demos et Q&A. Gardez l''audience engagee.</p><h2>Suivi</h2><p>Envoyez le replay, des ressources complementaires et une offre speciale aux participants.</p>',
'/assets/images/blog/webinaires.jpg', 178, 'published', '2025-01-26 10:00:00'),

('Evenements digitaux : creer des experiences memorables', 'evenements-digitaux-experiences', 16, 'Evenementiel',
'Organisez des evenements digitaux qui marquent les esprits et renforcent votre marque.',
'<h2>L''evenementiel digital</h2><p>Les evenements digitaux touchent une audience mondiale sans contraintes geographiques.</p><h2>Formats</h2><p>Conferences en ligne, ateliers interactifs, salons virtuels, lancements de produits en live.</p><h2>Outils</h2><p>Zoom, Hopin, Livestorm, StreamYard. Choisissez selon vos besoins d''interactivite.</p><h2>Engagement</h2><p>Sondages en direct, chat, networking rooms, gamification pour maintenir l''attention.</p>',
'/assets/images/blog/evenements-digitaux.jpg', 145, 'published', '2025-02-10 09:00:00');

-- Cat 17 : Marketing d'Influence
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('Marketing d''influence : guide complet 2025', 'marketing-influence-guide-2025', 17, 'Marketing d''Influence',
'Comment collaborer avec des influenceurs pour booster votre marque.',
'<h2>L''influence en 2025</h2><p>Le marketing d''influence represente un marche de 21 milliards de dollars. Les micro-influenceurs dominent.</p><h2>Choisir ses influenceurs</h2><p>Taux d''engagement > nombre d''abonnes. Verifiez l''authenticite de l''audience et l''alignement avec vos valeurs.</p><h2>Types de collaborations</h2><p>Posts sponsorises, unboxing, takeover, ambassadeur, affiliation. Adaptez selon vos objectifs.</p><h2>Mesurer le ROI</h2><p>Codes promo uniques, liens traces, mentions de marque. Calculez le cout par engagement et par conversion.</p>',
'/assets/images/blog/marketing-influence.jpg', 298, 'published', '2025-01-17 10:00:00'),

('Micro-influenceurs : le pouvoir de l''authenticite', 'micro-influenceurs-authenticite', 17, 'Marketing d''Influence',
'Pourquoi les micro-influenceurs generent plus d''engagement que les mega-influenceurs.',
'<h2>Micro vs Macro</h2><p>Les micro-influenceurs (10K-100K abonnes) ont un taux d''engagement 60% superieur aux macro-influenceurs.</p><h2>Authenticite</h2><p>Leur audience est plus engagee car la relation est plus personnelle et authentique.</p><h2>Budget accessible</h2><p>200 a 2000 euros par post. Vous pouvez collaborer avec plusieurs micro-influenceurs pour le prix d''un macro.</p><h2>Trouver les bons profils</h2><p>Plateformes : Influence4You, Kolsquare, Hivency. Ou recherche manuelle par hashtags.</p>',
'/assets/images/blog/micro-influenceurs.jpg', 212, 'published', '2025-02-05 11:00:00');

-- Cat 18 : CRM
INSERT INTO blog_articles (title, slug, category_id, service_name, excerpt, content, image_url, views, status, published_at) VALUES
('CRM : choisir et implementer le bon outil', 'crm-choisir-implementer', 18, 'CRM',
'Guide pour choisir le CRM adapte a votre entreprise et reussir son implementation.',
'<h2>Pourquoi un CRM ?</h2><p>Un CRM augmente les ventes de 29%, la productivite de 34% et la satisfaction client de 42%.</p><h2>Criteres de choix</h2><p>Taille de l''equipe, budget, fonctionnalites, integrations, facilite d''utilisation.</p><h2>Solutions populaires</h2><p>HubSpot (gratuit pour debuter), Salesforce (entreprises), Pipedrive (PME), Zoho (polyvalent).</p><h2>Implementation</h2><p>Definissez vos processus avant de configurer l''outil. Formez vos equipes. Migrez les donnees progressivement.</p>',
'/assets/images/blog/crm-guide.jpg', 256, 'published', '2025-01-13 10:00:00'),

('Automatisation CRM : gagner du temps et des clients', 'automatisation-crm-guide', 18, 'CRM',
'Automatisez vos processus commerciaux pour ne plus jamais perdre un prospect.',
'<h2>L''automatisation CRM</h2><p>Les entreprises qui automatisent leur CRM convertissent 53% de leads en plus.</p><h2>Workflows essentiels</h2><p>Lead scoring automatique, attribution des leads, relances programmees, notifications d''activite.</p><h2>Nurturing</h2><p>Sequences d''emails automatiques basees sur le comportement : telechargement, visite de page, ouverture d''email.</p><h2>Reporting</h2><p>Tableaux de bord automatises : pipeline, previsions, performances par commercial.</p>',
'/assets/images/blog/automatisation-crm.jpg', 189, 'published', '2025-02-09 10:00:00');

-- ============================================
-- 7. FORMATIONS (2 par categorie, 18 categories = 36 formations)
-- ============================================

-- Cat 1 : Reseaux Sociaux
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Community Management', 'formation-community-management', 1, 'Reseaux Sociaux',
'Apprenez a gerer et developper des communautes sur les reseaux sociaux. Strategie editoriale, creation de contenu, analyse des performances.',
'debutant', 20, 299.00, '/assets/images/formations/community-management.jpg', 'published', 45, 4.70),
('Formation Stories & Reels', 'formation-stories-reels', 1, 'Reseaux Sociaux',
'Maitrisez les stories Instagram, Facebook et les Reels pour maximiser l''engagement et les conversions.',
'intermediaire', 10, 149.00, '/assets/images/formations/stories-reels.jpg', 'published', 32, 4.50);

-- Cat 2 : Design Graphique
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Design Graphique Web', 'formation-design-graphique-web', 2, 'Design Graphique',
'Maitrisez les fondamentaux du design graphique applique au marketing digital et au web.',
'debutant', 30, 399.00, '/assets/images/formations/design-web.jpg', 'published', 38, 4.80),
('Formation Infographies & Bannieres', 'formation-infographies-bannieres', 2, 'Design Graphique',
'Creez des infographies percutantes et des bannieres publicitaires qui convertissent.',
'intermediaire', 12, 179.00, '/assets/images/formations/infographies-bannieres.jpg', 'published', 22, 4.40);

-- Cat 3 : Production Video
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Video Marketing', 'formation-video-marketing', 3, 'Production Video',
'Produisez des videos professionnelles pour votre marketing : tournage, montage, diffusion multi-plateforme.',
'debutant', 25, 349.00, '/assets/images/formations/video-marketing.jpg', 'published', 41, 4.70),
('Formation Miniatures & Montage YouTube', 'formation-miniatures-montage-youtube', 3, 'Production Video',
'Creez des miniatures YouTube percutantes et maitrisez le montage video pour le web.',
'intermediaire', 10, 149.00, '/assets/images/formations/miniatures-youtube.jpg', 'published', 35, 4.50);

-- Cat 4 : Creation Web
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Creation de Sites Web', 'formation-creation-sites-web', 4, 'Creation Web',
'Apprenez a creer des sites web modernes, rapides et bien references de A a Z.',
'debutant', 40, 499.00, '/assets/images/formations/creation-web.jpg', 'published', 56, 4.90),
('Formation UX Design & Conversion', 'formation-ux-design-conversion', 4, 'Creation Web',
'Les principes UX essentiels pour concevoir des interfaces qui convertissent vos visiteurs en clients.',
'intermediaire', 15, 249.00, '/assets/images/formations/ux-design.jpg', 'published', 33, 4.60);

-- Cat 5 : SEO
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation SEO Complete', 'formation-seo-complete', 5, 'SEO',
'Du debutant a l''expert : maitrisez toutes les techniques de referencement naturel pour Google.',
'debutant', 40, 499.00, '/assets/images/formations/seo-complete.jpg', 'published', 67, 4.90),
('Formation SEO Local', 'formation-seo-local', 5, 'SEO',
'Dominez les recherches locales et Google Maps pour attirer des clients de proximite.',
'intermediaire', 10, 149.00, '/assets/images/formations/seo-local.jpg', 'published', 24, 4.50);

-- Cat 6 : Publicite en Ligne
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Google Ads Avancee', 'formation-google-ads-avancee', 6, 'Publicite en Ligne',
'Maitrisez Google Ads : Search, Display, Shopping, YouTube, Performance Max.',
'avance', 25, 449.00, '/assets/images/formations/google-ads.jpg', 'published', 53, 4.80),
('Formation Facebook & Instagram Ads', 'formation-facebook-instagram-ads', 6, 'Publicite en Ligne',
'Lancez et optimisez vos campagnes publicitaires sur Meta (Facebook et Instagram).',
'intermediaire', 18, 299.00, '/assets/images/formations/facebook-ads.jpg', 'published', 44, 4.70);

-- Cat 7 : Email Marketing
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Email Marketing & Automation', 'formation-email-marketing-automation', 7, 'Email Marketing',
'Creez des campagnes email performantes et mettez en place des sequences d''automation.',
'intermediaire', 15, 249.00, '/assets/images/formations/email-marketing.jpg', 'published', 35, 4.60),
('Formation Newsletter Professionnelle', 'formation-newsletter-professionnelle', 7, 'Email Marketing',
'Creez et developpez une newsletter qui fidelize votre audience et genere du business.',
'debutant', 8, 129.00, '/assets/images/formations/newsletter.jpg', 'published', 27, 4.40);

-- Cat 8 : Analytics
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Google Analytics 4', 'formation-google-analytics-4', 8, 'Analytics',
'Maitrisez GA4 pour analyser votre trafic et prendre des decisions basees sur les donnees.',
'intermediaire', 15, 249.00, '/assets/images/formations/ga4.jpg', 'published', 39, 4.70),
('Formation Data Marketing & KPIs', 'formation-data-marketing-kpis', 8, 'Analytics',
'Definissez, mesurez et optimisez vos KPIs marketing pour maximiser votre ROI.',
'avance', 12, 199.00, '/assets/images/formations/data-marketing.jpg', 'published', 21, 4.50);

-- Cat 9 : Strategie Digitale
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Strategie Digitale Complete', 'formation-strategie-digitale', 9, 'Strategie Digitale',
'Elaborez une strategie digitale performante : audit, personas, plan d''action, KPIs, budget.',
'intermediaire', 20, 349.00, '/assets/images/formations/strategie-digitale.jpg', 'published', 29, 4.70),
('Formation Budget & ROI Marketing', 'formation-budget-roi-marketing', 9, 'Strategie Digitale',
'Allouez votre budget marketing et mesurez le retour sur investissement de chaque canal.',
'avance', 10, 199.00, '/assets/images/formations/budget-roi.jpg', 'published', 18, 4.40);

-- Cat 10 : Redaction
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Copywriting & Persuasion', 'formation-copywriting-persuasion', 10, 'Redaction',
'Maitrisez l''art du copywriting pour ecrire des textes qui vendent et convertissent.',
'intermediaire', 15, 249.00, '/assets/images/formations/copywriting.jpg', 'published', 36, 4.70),
('Formation Content Marketing', 'formation-content-marketing', 10, 'Redaction',
'Creez une strategie de contenu qui attire, engage et convertit votre audience cible.',
'debutant', 12, 199.00, '/assets/images/formations/content-marketing.jpg', 'published', 28, 4.50);

-- Cat 11 : Intelligence Artificielle
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation IA pour le Marketing', 'formation-ia-marketing', 11, 'Intelligence Artificielle',
'Exploitez l''intelligence artificielle pour booster votre marketing : ChatGPT, automatisation, personnalisation.',
'debutant', 12, 199.00, '/assets/images/formations/ia-marketing.jpg', 'published', 58, 4.80),
('Formation ChatGPT & Prompting Avance', 'formation-chatgpt-prompting', 11, 'Intelligence Artificielle',
'Devenez expert en prompting pour tirer le maximum de ChatGPT dans votre travail quotidien.',
'intermediaire', 8, 149.00, '/assets/images/formations/chatgpt.jpg', 'published', 47, 4.60);

-- Cat 12 : E-commerce
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation E-commerce Complete', 'formation-ecommerce-complete', 12, 'E-commerce',
'Lancez et developpez votre boutique en ligne : de la creation a l''optimisation des ventes.',
'debutant', 30, 399.00, '/assets/images/formations/ecommerce.jpg', 'published', 48, 4.80),
('Formation Optimisation Fiches Produits', 'formation-optimisation-fiches-produits', 12, 'E-commerce',
'Creez des fiches produits qui convertissent : photos, descriptions, SEO, avis clients.',
'intermediaire', 10, 149.00, '/assets/images/formations/fiches-produits.jpg', 'published', 31, 4.60);

-- Cat 13 : Applications Mobiles
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Developpement Mobile', 'formation-developpement-mobile', 13, 'Applications Mobiles',
'Creez des applications mobiles avec React Native ou Flutter : du prototype au deploiement.',
'intermediaire', 35, 449.00, '/assets/images/formations/dev-mobile.jpg', 'published', 34, 4.70),
('Formation ASO (App Store Optimization)', 'formation-aso-app-store', 13, 'Applications Mobiles',
'Optimisez la visibilite de votre application sur l''App Store et Google Play.',
'debutant', 8, 129.00, '/assets/images/formations/aso.jpg', 'published', 19, 4.30);

-- Cat 14 : Formation
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Creer & Vendre des Formations', 'formation-creer-vendre-formations', 14, 'Formation',
'Apprenez a creer, heberger et commercialiser vos propres formations en ligne.',
'intermediaire', 15, 249.00, '/assets/images/formations/creer-formations.jpg', 'published', 23, 4.60),
('Formation Pedagogie Digitale', 'formation-pedagogie-digitale', 14, 'Formation',
'Les techniques pedagogiques pour creer des formations en ligne engageantes et efficaces.',
'debutant', 10, 179.00, '/assets/images/formations/pedagogie.jpg', 'published', 17, 4.40);

-- Cat 15 : Securite
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Securite Web', 'formation-securite-web', 15, 'Securite',
'Protegez votre site web et les donnees de vos clients contre les cybermenaces.',
'intermediaire', 15, 249.00, '/assets/images/formations/securite-web.jpg', 'published', 26, 4.60),
('Formation RGPD & Conformite', 'formation-rgpd-conformite', 15, 'Securite',
'Mettez votre entreprise en conformite RGPD : obligations, processus, outils.',
'debutant', 8, 149.00, '/assets/images/formations/rgpd.jpg', 'published', 31, 4.50);

-- Cat 16 : Evenementiel
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Webinaires & Events Digitaux', 'formation-webinaires-events', 16, 'Evenementiel',
'Organisez des webinaires et evenements digitaux qui generent des leads et renforcent votre marque.',
'debutant', 10, 179.00, '/assets/images/formations/webinaires.jpg', 'published', 22, 4.50),
('Formation Live Streaming', 'formation-live-streaming', 16, 'Evenementiel',
'Maitrisez le live streaming pour vos evenements, lancements et interactions avec votre audience.',
'intermediaire', 8, 149.00, '/assets/images/formations/live-streaming.jpg', 'published', 16, 4.30);

-- Cat 17 : Marketing d'Influence
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation Marketing d''Influence', 'formation-marketing-influence', 17, 'Marketing d''Influence',
'Collaborez avec des influenceurs pour booster votre marque : strategie, negociation, mesure du ROI.',
'intermediaire', 12, 199.00, '/assets/images/formations/marketing-influence.jpg', 'published', 29, 4.60),
('Formation Micro-Influenceurs', 'formation-micro-influenceurs', 17, 'Marketing d''Influence',
'Exploitez le pouvoir des micro-influenceurs pour des campagnes authentiques et rentables.',
'debutant', 8, 129.00, '/assets/images/formations/micro-influenceurs.jpg', 'published', 21, 4.40);

-- Cat 18 : CRM
INSERT INTO formations (title, slug, category_id, service_name, description, level, duration_hours, price, image_url, status, enrolled_count, rating) VALUES
('Formation CRM & Gestion Client', 'formation-crm-gestion-client', 18, 'CRM',
'Choisissez, implementez et exploitez un CRM pour developper vos ventes et fideliser vos clients.',
'debutant', 15, 249.00, '/assets/images/formations/crm.jpg', 'published', 27, 4.60),
('Formation Automatisation CRM', 'formation-automatisation-crm', 18, 'CRM',
'Automatisez vos processus commerciaux : lead scoring, nurturing, relances, reporting.',
'intermediaire', 10, 179.00, '/assets/images/formations/automatisation-crm.jpg', 'published', 20, 4.50);

-- ============================================
-- 8. MODULES ET LECONS (pour 6 formations principales)
-- ============================================

-- Modules pour Formation Community Management (ID 1)
INSERT INTO formation_modules (formation_id, title, description, order_num, duration_minutes) VALUES
(1, 'Introduction au Community Management', 'Les bases du metier et les competences cles', 1, 120),
(1, 'Strategie Editoriale', 'Definir sa ligne editoriale et son calendrier de publications', 2, 180),
(1, 'Creation de Contenu', 'Creer du contenu engageant pour chaque plateforme', 3, 180),
(1, 'Gestion de Communaute', 'Animer, moderer et fideliser sa communaute', 4, 150),
(1, 'Analytics & Reporting', 'Mesurer et analyser ses performances', 5, 120);

-- Lecons pour Module 1 (Introduction CM)
INSERT INTO formation_lessons (module_id, title, content, order_num, duration_minutes, is_free) VALUES
(1, 'Qu''est-ce que le Community Management ?', '<p>Le community management est l''art de gerer et animer une communaute en ligne autour d''une marque.</p>', 1, 30, TRUE),
(1, 'Les plateformes essentielles', '<p>Instagram, Facebook, LinkedIn, TikTok, X : chaque plateforme a ses specificites.</p>', 2, 30, TRUE),
(1, 'Les outils du Community Manager', '<p>Hootsuite, Buffer, Later, Canva, Notion : votre boite a outils complete.</p>', 3, 30, FALSE),
(1, 'Definir ses objectifs SMART', '<p>Des objectifs Specifiques, Mesurables, Atteignables, Realistes et Temporels.</p>', 4, 30, FALSE);

-- Lecons pour Module 2 (Strategie Editoriale)
INSERT INTO formation_lessons (module_id, title, content, order_num, duration_minutes, is_free) VALUES
(2, 'Creer sa ligne editoriale', '<p>Definissez votre ton, vos themes et votre identite visuelle.</p>', 1, 45, FALSE),
(2, 'Le calendrier editorial', '<p>Planifiez vos publications sur 1 mois avec un mix de contenus equilibre.</p>', 2, 45, FALSE),
(2, 'Les meilleurs horaires de publication', '<p>Quand publier sur chaque plateforme pour maximiser la portee.</p>', 3, 45, FALSE),
(2, 'Veille concurrentielle', '<p>Analysez ce que font vos concurrents pour vous differencier.</p>', 4, 45, FALSE);

-- Modules pour Formation SEO Complete (ID 9)
INSERT INTO formation_modules (formation_id, title, description, order_num, duration_minutes) VALUES
(9, 'Les Fondamentaux du SEO', 'Comprendre le fonctionnement des moteurs de recherche', 1, 180),
(9, 'SEO On-Page', 'Optimiser le contenu et la structure de vos pages', 2, 240),
(9, 'SEO Technique', 'Vitesse, mobile, crawl, indexation', 3, 240),
(9, 'Netlinking', 'Strategie de backlinks et autorite de domaine', 4, 180),
(9, 'SEO Avance & IA', 'Techniques avancees et impact de l''IA sur le SEO', 5, 120);

-- Lecons pour Module 6 (Fondamentaux SEO)
INSERT INTO formation_lessons (module_id, title, content, order_num, duration_minutes, is_free) VALUES
(6, 'Comment fonctionne Google', '<p>Crawl, indexation, classement : comprendre le fonctionnement de Google.</p>', 1, 30, TRUE),
(6, 'Les facteurs de classement', '<p>Les 200+ facteurs que Google utilise pour classer les pages.</p>', 2, 30, TRUE),
(6, 'Recherche de mots-cles', '<p>Trouvez les mots-cles strategiques avec les bons outils.</p>', 3, 45, FALSE),
(6, 'Intention de recherche', '<p>Informationnelle, navigationnelle, transactionnelle : alignez votre contenu.</p>', 4, 30, FALSE),
(6, 'Audit SEO initial', '<p>Realisez un audit complet de votre site en 10 etapes.</p>', 5, 45, FALSE);

-- Lecons pour Module 7 (SEO On-Page)
INSERT INTO formation_lessons (module_id, title, content, order_num, duration_minutes, is_free) VALUES
(7, 'Balises Title et Meta Description', '<p>Optimisez vos balises pour maximiser le CTR dans les resultats de recherche.</p>', 1, 30, FALSE),
(7, 'Structure des URLs', '<p>URLs courtes, descriptives et optimisees pour le SEO.</p>', 2, 30, FALSE),
(7, 'Balisage Hn et structure de contenu', '<p>Hierarchie des titres H1-H6 pour une structure claire.</p>', 3, 30, FALSE),
(7, 'Optimisation des images', '<p>Alt text, compression, format WebP, lazy loading.</p>', 4, 30, FALSE),
(7, 'Maillage interne', '<p>Liez vos pages entre elles pour distribuer le jus SEO.</p>', 5, 30, FALSE);

-- Modules pour Formation Google Ads (ID 11)
INSERT INTO formation_modules (formation_id, title, description, order_num, duration_minutes) VALUES
(11, 'Introduction a Google Ads', 'Comprendre l''ecosysteme publicitaire Google', 1, 120),
(11, 'Campagnes Search', 'Creer et optimiser des campagnes sur le reseau de recherche', 2, 180),
(11, 'Campagnes Display & Video', 'Publicite visuelle sur le reseau Display et YouTube', 3, 180),
(11, 'Performance Max & Shopping', 'Campagnes IA et e-commerce', 4, 150),
(11, 'Optimisation & Reporting', 'Analyser et optimiser vos campagnes', 5, 120);

-- Lecons pour Module 11 (Intro Google Ads)
INSERT INTO formation_lessons (module_id, title, content, order_num, duration_minutes, is_free) VALUES
(11, 'L''ecosysteme Google Ads', '<p>Search, Display, YouTube, Shopping, Maps : tous les reseaux publicitaires Google.</p>', 1, 30, TRUE),
(11, 'Creer son compte Google Ads', '<p>Configuration du compte, facturation, parametres essentiels.</p>', 2, 30, TRUE),
(11, 'Structure de campagne', '<p>Campagne > Groupe d''annonces > Annonces > Mots-cles.</p>', 3, 30, FALSE),
(11, 'Les types d''encheres', '<p>CPC manuel, CPC optimise, CPA cible, ROAS cible.</p>', 4, 30, FALSE);

-- Modules pour Formation IA Marketing (ID 21)
INSERT INTO formation_modules (formation_id, title, description, order_num, duration_minutes) VALUES
(21, 'Introduction a l''IA Marketing', 'Comprendre l''IA et ses applications en marketing', 1, 120),
(21, 'ChatGPT pour le Marketing', 'Utiliser ChatGPT au quotidien pour vos taches marketing', 2, 150),
(21, 'Automatisation avec l''IA', 'Chatbots, personnalisation et workflows automatises', 3, 150),
(21, 'IA et Creation de Contenu', 'Generer du contenu avec l''IA : texte, image, video', 4, 120);

-- Lecons pour Module 16 (Intro IA Marketing)
INSERT INTO formation_lessons (module_id, title, content, order_num, duration_minutes, is_free) VALUES
(16, 'Qu''est-ce que l''IA ?', '<p>Les bases de l''intelligence artificielle expliquees simplement.</p>', 1, 30, TRUE),
(16, 'L''IA dans le marketing digital', '<p>Personnalisation, prediction, automatisation, creation de contenu.</p>', 2, 30, TRUE),
(16, 'Les outils IA essentiels', '<p>ChatGPT, Midjourney, Jasper, Copy.ai, Synthesia et plus.</p>', 3, 30, FALSE),
(16, 'Ethique et limites de l''IA', '<p>Hallucinations, biais, droits d''auteur : les limites a connaitre.</p>', 4, 30, FALSE);

-- Modules pour Formation E-commerce (ID 23)
INSERT INTO formation_modules (formation_id, title, description, order_num, duration_minutes) VALUES
(23, 'Lancer sa Boutique en Ligne', 'Choisir sa plateforme et configurer sa boutique', 1, 180),
(23, 'Catalogue & Fiches Produits', 'Creer un catalogue attractif et des fiches qui convertissent', 2, 180),
(23, 'Marketing E-commerce', 'Attirer du trafic et convertir les visiteurs', 3, 180),
(23, 'Logistique & Service Client', 'Gerer les commandes, livraisons et le SAV', 4, 150);

-- Lecons pour Module 20 (Lancer sa Boutique)
INSERT INTO formation_lessons (module_id, title, content, order_num, duration_minutes, is_free) VALUES
(20, 'Choisir sa plateforme e-commerce', '<p>Shopify, WooCommerce, PrestaShop, Magento : comparatif complet.</p>', 1, 45, TRUE),
(20, 'Configurer sa boutique', '<p>Design, navigation, categories, moyens de paiement, livraison.</p>', 2, 45, FALSE),
(20, 'Les mentions legales obligatoires', '<p>CGV, politique de retour, RGPD : tout ce qui est obligatoire.</p>', 3, 45, FALSE),
(20, 'Lancer son premier produit', '<p>De la photo produit a la mise en ligne : guide pas a pas.</p>', 4, 45, FALSE);

-- Modules pour Formation Securite Web (ID 29)
INSERT INTO formation_modules (formation_id, title, description, order_num, duration_minutes) VALUES
(29, 'Les Menaces Web', 'Comprendre les principales cybermenaces', 1, 120),
(29, 'Protection de votre Site', 'Securiser votre site web et votre serveur', 2, 180),
(29, 'RGPD & Donnees Personnelles', 'Conformite et protection des donnees', 3, 150),
(29, 'Plan de Continuite', 'Sauvegardes, restauration et plan de crise', 4, 120);

-- Lecons pour Module 24 (Menaces Web)
INSERT INTO formation_lessons (module_id, title, content, order_num, duration_minutes, is_free) VALUES
(24, 'Les types de cyberattaques', '<p>Phishing, XSS, injection SQL, DDoS, ransomware : les menaces courantes.</p>', 1, 30, TRUE),
(24, 'Vulnerabilites courantes', '<p>Mots de passe faibles, plugins obsoletes, configurations par defaut.</p>', 2, 30, TRUE),
(24, 'Evaluer son niveau de securite', '<p>Audit de securite : les outils et methodes pour tester votre site.</p>', 3, 30, FALSE),
(24, 'Les certificats SSL/TLS', '<p>HTTPS, Let''s Encrypt, types de certificats et installation.</p>', 4, 30, FALSE);

-- ============================================
-- 9. INDEXES SUPPLEMENTAIRES
-- ============================================

ALTER TABLE formations ADD INDEX idx_level (level);
ALTER TABLE blog_articles ADD INDEX idx_published_at (published_at);
ALTER TABLE users ADD INDEX idx_email (email);
ALTER TABLE contact_messages ADD INDEX idx_status (status);
ALTER TABLE newsletter_subscribers ADD INDEX idx_status (status);
