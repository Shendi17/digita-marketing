-- Suppression des tables si elles existent
DROP TABLE IF EXISTS content;
DROP TABLE IF EXISTS team_members;

-- Création de la table content
CREATE TABLE content (
    id INT PRIMARY KEY AUTO_INCREMENT,
    page VARCHAR(50) NOT NULL,
    section VARCHAR(50) NOT NULL,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT,
    icone VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table team_members
CREATE TABLE team_members (
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

-- Insertion des données pour la section Histoire
INSERT INTO content (page, section, titre, contenu) VALUES
('about', 'histoire', 'Notre Histoire', 'Fondée en 2015 par une équipe de passionnés du digital, DIGITA s''est rapidement imposée comme un acteur majeur du marketing digital en France. Notre approche innovante et notre engagement envers l''excellence nous ont permis de construire des relations durables avec nos clients. Aujourd''hui, nous sommes fiers de compter plus de 200 projets réussis et une équipe de 25 experts dévoués.');

-- Insertion des données pour la section Valeurs
INSERT INTO content (page, section, titre, contenu, icone) VALUES
('about', 'valeurs', 'Innovation', 'Toujours à la pointe des dernières tendances digitales', 'fa-lightbulb'),
('about', 'valeurs', 'Engagement', 'Des résultats concrets pour nos clients', 'fa-handshake'),
('about', 'valeurs', 'Collaboration', 'Un travail d''équipe pour des solutions optimales', 'fa-users'),
('about', 'valeurs', 'Excellence', 'La qualité au cœur de nos services', 'fa-chart-line');

-- Insertion des données pour l'équipe
INSERT INTO team_members (nom, poste, photo, ordre, linkedin, twitter) VALUES
('Thomas Martin', 'CEO & Fondateur', 'thomas-martin.jpg', 1, 'https://linkedin.com/in/thomasmartin', 'https://twitter.com/thomasmartin'),
('Sophie Dubois', 'Directrice Marketing', 'sophie-dubois.jpg', 2, 'https://linkedin.com/in/sophiedubois', 'https://twitter.com/sophiedubois'),
('Lucas Bernard', 'Directeur Technique', 'lucas-bernard.jpg', 3, 'https://linkedin.com/in/lucasbernard', 'https://twitter.com/lucasbernard'),
('Emma Laurent', 'Directrice Artistique', 'emma-laurent.jpg', 4, 'https://linkedin.com/in/emmalaurent', 'https://twitter.com/emmalaurent'),
('Marie Petit', 'Chef de Projet Digital', 'marie-petit.jpg', 5, 'https://linkedin.com/in/mariepetit', 'https://twitter.com/mariepetit'),
('Antoine Durand', 'Expert SEO', 'antoine-durand.jpg', 6, 'https://linkedin.com/in/antoinedurand', 'https://twitter.com/antoinedurand'),
('Julie Moreau', 'Social Media Manager', 'julie-moreau.jpg', 7, 'https://linkedin.com/in/juliemoreau', 'https://twitter.com/juliemoreau'),
('Pierre Leroy', 'Développeur Full-Stack', 'pierre-leroy.jpg', 8, 'https://linkedin.com/in/pierreleroy', 'https://twitter.com/pierreleroy');
