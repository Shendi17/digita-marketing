-- Ajout des index manquants pour optimiser les performances

-- Index sur la table formations
CREATE INDEX IF NOT EXISTS idx_formations_slug ON formations(slug);
CREATE INDEX IF NOT EXISTS idx_formations_status ON formations(status);
CREATE INDEX IF NOT EXISTS idx_formations_category_id ON formations(category_id);
CREATE INDEX IF NOT EXISTS idx_formations_created_at ON formations(created_at);

-- Index sur la table blog_articles
CREATE INDEX IF NOT EXISTS idx_articles_slug ON blog_articles(slug);
CREATE INDEX IF NOT EXISTS idx_articles_status ON blog_articles(status);
CREATE INDEX IF NOT EXISTS idx_articles_category_id ON blog_articles(category_id);
CREATE INDEX IF NOT EXISTS idx_articles_published_at ON blog_articles(published_at);

-- Index sur la table users
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_users_role ON users(role);

-- Index sur la table contact_messages
CREATE INDEX IF NOT EXISTS idx_contact_status ON contact_messages(status);
CREATE INDEX IF NOT EXISTS idx_contact_created_at ON contact_messages(created_at);

-- Index sur la table newsletter_subscribers
CREATE INDEX IF NOT EXISTS idx_newsletter_status ON newsletter_subscribers(status);
CREATE INDEX IF NOT EXISTS idx_newsletter_email ON newsletter_subscribers(email);

-- Index sur la table service_categories
CREATE INDEX IF NOT EXISTS idx_categories_slug ON service_categories(slug);
CREATE INDEX IF NOT EXISTS idx_categories_parent_id ON service_categories(parent_id);

-- Optimiser toutes les tables après ajout des index
OPTIMIZE TABLE formations;
OPTIMIZE TABLE blog_articles;
OPTIMIZE TABLE users;
OPTIMIZE TABLE contact_messages;
OPTIMIZE TABLE newsletter_subscribers;
OPTIMIZE TABLE service_categories;
