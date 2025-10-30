-- ============================================
-- Migration : Ajouter article_slug aux formations
-- Date : 30 Octobre 2025
-- Description : Permet de lier une formation à un article de blog
-- ============================================

-- 1. Ajouter la colonne article_slug
ALTER TABLE formations 
ADD COLUMN article_slug VARCHAR(255) NULL 
COMMENT 'Slug de l\'article de blog associé'
AFTER slug;

-- 2. Ajouter un index pour optimiser les recherches
CREATE INDEX idx_article_slug ON formations(article_slug);

-- 3. Lier les formations existantes aux articles correspondants
-- (Basé sur les slugs similaires)

-- Formation Cross-selling et upselling
UPDATE formations 
SET article_slug = 'cross-selling-upselling' 
WHERE slug = 'formation-cross-selling-upselling'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug = 'cross-selling-upselling');

-- Formation Templates réseaux sociaux
UPDATE formations 
SET article_slug = 'templates-reseaux-sociaux' 
WHERE slug = 'formation-templates-reseaux-sociaux'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug = 'templates-reseaux-sociaux');

-- Formation Optimisation des fiches produits
UPDATE formations 
SET article_slug = 'optimisation-fiches-produits' 
WHERE slug LIKE '%optimisation%fiches%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%optimisation%fiches%');

-- Formation Abandon de panier
UPDATE formations 
SET article_slug = 'abandon-panier' 
WHERE slug LIKE '%abandon%panier%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%abandon%panier%');

-- Formation Codes promo et réductions
UPDATE formations 
SET article_slug = 'codes-promo-reductions' 
WHERE slug LIKE '%codes%promo%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%codes%promo%');

-- Formation Vente sur Amazon
UPDATE formations 
SET article_slug = 'vente-amazon' 
WHERE slug LIKE '%amazon%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%amazon%');

-- Formation Vente sur eBay
UPDATE formations 
SET article_slug = 'vente-ebay' 
WHERE slug LIKE '%ebay%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%ebay%');

-- Formation Vente sur Etsy
UPDATE formations 
SET article_slug = 'vente-etsy' 
WHERE slug LIKE '%etsy%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%etsy%');

-- Formation Vente sur Cdiscount
UPDATE formations 
SET article_slug = 'vente-cdiscount' 
WHERE slug LIKE '%cdiscount%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%cdiscount%');

-- Formation Bannières publicitaires
UPDATE formations 
SET article_slug = 'bannieres-publicitaires' 
WHERE slug LIKE '%banniere%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%banniere%');

-- Formation Couvertures Facebook/LinkedIn
UPDATE formations 
SET article_slug = 'couvertures-facebook-linkedin' 
WHERE slug LIKE '%couverture%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%couverture%');

-- Formation Animations et GIFs
UPDATE formations 
SET article_slug = 'animations-gifs' 
WHERE slug LIKE '%animation%gif%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%animation%gif%');

-- Formation Infographies digitales
UPDATE formations 
SET article_slug = 'infographies-digitales' 
WHERE slug LIKE '%infographie%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%infographie%');

-- Formation Stories Instagram/Facebook
UPDATE formations 
SET article_slug = 'stories-instagram-facebook' 
WHERE slug LIKE '%stories%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%stories%');

-- Formation Miniatures YouTube
UPDATE formations 
SET article_slug = 'miniatures-youtube' 
WHERE slug LIKE '%miniature%youtube%'
AND EXISTS (SELECT 1 FROM blog_articles WHERE slug LIKE '%miniature%youtube%');

-- 4. Vérifier les liens créés
SELECT 
    f.id,
    f.title AS formation_titre,
    f.slug AS formation_slug,
    f.article_slug,
    a.title AS article_titre,
    CASE 
        WHEN a.slug IS NOT NULL THEN '✅ Lié'
        WHEN f.article_slug IS NOT NULL THEN '❌ Article introuvable'
        ELSE '⚪ Pas de lien'
    END AS statut
FROM formations f
LEFT JOIN blog_articles a ON a.slug = f.article_slug
ORDER BY f.category_id, f.title;

-- 5. Statistiques
SELECT 
    COUNT(*) AS total_formations,
    SUM(CASE WHEN article_slug IS NOT NULL THEN 1 ELSE 0 END) AS avec_article,
    SUM(CASE WHEN article_slug IS NULL THEN 1 ELSE 0 END) AS sans_article,
    ROUND(SUM(CASE WHEN article_slug IS NOT NULL THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) AS pourcentage_lie
FROM formations;
