-- =====================================================
-- SPRINT 4 : Projets Clients & Espace Client
-- Migration SQL
-- =====================================================

-- Table des projets clients
CREATE TABLE IF NOT EXISTS client_projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    project_type ENUM('website','ecommerce','landing','app','seo','marketing') NOT NULL DEFAULT 'website',
    title VARCHAR(255) NOT NULL,
    brief TEXT NOT NULL,
    brief_data JSON,
    status ENUM('draft','pending','generating','review','revision','approved','delivered','completed','cancelled') DEFAULT 'draft',
    priority ENUM('low','normal','high','urgent') DEFAULT 'normal',
    webox_project_id VARCHAR(100) NULL,
    preview_url VARCHAR(500) NULL,
    production_url VARCHAR(500) NULL,
    price DECIMAL(10,2) DEFAULT 0.00,
    paid TINYINT(1) DEFAULT 0,
    payment_id INT NULL,
    admin_notes TEXT NULL,
    estimated_days INT DEFAULT 7,
    started_at TIMESTAMP NULL,
    delivered_at TIMESTAMP NULL,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_client (client_id),
    INDEX idx_status (status),
    INDEX idx_type (project_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des messages projet (messagerie client/admin)
CREATE TABLE IF NOT EXISTS project_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    is_read TINYINT(1) DEFAULT 0,
    attachment VARCHAR(500) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES client_projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_project (project_id),
    INDEX idx_unread (is_read, project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des fichiers projet
CREATE TABLE IF NOT EXISTS project_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    user_id INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    filepath VARCHAR(500) NOT NULL,
    filetype VARCHAR(50),
    filesize INT DEFAULT 0,
    description VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES client_projects(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_project_files (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des tâches projet (pipeline interne admin)
CREATE TABLE IF NOT EXISTS project_tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    status ENUM('todo','in_progress','done') DEFAULT 'todo',
    assigned_to INT NULL,
    sort_order INT DEFAULT 0,
    due_date DATE NULL,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES client_projects(id) ON DELETE CASCADE,
    INDEX idx_project_tasks (project_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table historique des changements de statut
CREATE TABLE IF NOT EXISTS project_status_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    old_status VARCHAR(20),
    new_status VARCHAR(20) NOT NULL,
    changed_by INT NOT NULL,
    note TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES client_projects(id) ON DELETE CASCADE,
    INDEX idx_project_history (project_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Ajout du rôle 'client' dans la table users si pas déjà présent
-- ALTER TABLE users MODIFY COLUMN role ENUM('user','admin','client') DEFAULT 'user';
