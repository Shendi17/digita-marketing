<?php

require_once __DIR__ . '/../../includes/Database.php';

class Article {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Récupérer tous les articles publiés
     */
    public function getAllPublished($limit = null, $offset = 0) {
        $sql = 'SELECT a.*, c.name as category_name, c.slug as category_slug, c.icon as category_icon
                FROM blog_articles a
                LEFT JOIN service_categories c ON a.category_id = c.id
                WHERE a.status = "published"
                ORDER BY a.published_at DESC';
        
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Récupérer un article par son slug
     */
    public function getBySlug($slug) {
        $article = $this->db->fetch(
            'SELECT a.*, c.name as category_name, c.slug as category_slug, c.icon as category_icon
             FROM blog_articles a
             LEFT JOIN service_categories c ON a.category_id = c.id
             WHERE a.slug = ? AND a.status = "published"',
            [$slug]
        );
        
        if ($article) {
            // Incrémenter les vues
            $this->incrementViews($article['id']);
        }
        
        return $article;
    }
    
    /**
     * Récupérer les articles par catégorie
     */
    public function getByCategory($categorySlug, $limit = null) {
        $sql = 'SELECT a.*, c.name as category_name, c.slug as category_slug, c.icon as category_icon
                FROM blog_articles a
                LEFT JOIN service_categories c ON a.category_id = c.id
                WHERE c.slug = ? AND a.status = "published"
                ORDER BY a.published_at DESC';
        
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit;
        }
        
        return $this->db->query($sql, [$categorySlug])->fetchAll();
    }
    
    /**
     * Rechercher des articles
     */
    public function search($query, $limit = 20) {
        return $this->db->query(
            'SELECT a.*, c.name as category_name, c.slug as category_slug
             FROM blog_articles a
             LEFT JOIN service_categories c ON a.category_id = c.id
             WHERE (a.title LIKE ? OR a.content LIKE ? OR a.service_name LIKE ?)
             AND a.status = "published"
             ORDER BY a.published_at DESC
             LIMIT ?',
            ["%$query%", "%$query%", "%$query%", $limit]
        )->fetchAll();
    }
    
    /**
     * Récupérer les articles populaires
     */
    public function getPopular($limit = 5) {
        return $this->db->query(
            'SELECT a.*, c.name as category_name, c.slug as category_slug
             FROM blog_articles a
             LEFT JOIN service_categories c ON a.category_id = c.id
             WHERE a.status = "published"
             ORDER BY a.views DESC
             LIMIT ?',
            [$limit]
        )->fetchAll();
    }
    
    /**
     * Récupérer les articles récents
     */
    public function getRecent($limit = 5) {
        return $this->db->query(
            'SELECT a.*, c.name as category_name, c.slug as category_slug
             FROM blog_articles a
             LEFT JOIN service_categories c ON a.category_id = c.id
             WHERE a.status = "published"
             ORDER BY a.published_at DESC
             LIMIT ?',
            [$limit]
        )->fetchAll();
    }
    
    /**
     * Récupérer les articles liés
     */
    public function getRelated($articleId, $categoryId, $limit = 3) {
        return $this->db->query(
            'SELECT a.*, c.name as category_name, c.slug as category_slug
             FROM blog_articles a
             LEFT JOIN service_categories c ON a.category_id = c.id
             WHERE a.id != ? AND a.category_id = ? AND a.status = "published"
             ORDER BY RAND()
             LIMIT ?',
            [$articleId, $categoryId, $limit]
        )->fetchAll();
    }
    
    /**
     * Incrémenter le nombre de vues
     */
    private function incrementViews($articleId) {
        $this->db->query(
            'UPDATE blog_articles SET views = views + 1 WHERE id = ?',
            [$articleId]
        );
    }
    
    /**
     * Compter le nombre total d'articles
     */
    public function count($categorySlug = null) {
        if ($categorySlug) {
            return $this->db->fetch(
                'SELECT COUNT(*) as total FROM blog_articles a
                 LEFT JOIN service_categories c ON a.category_id = c.id
                 WHERE c.slug = ? AND a.status = "published"',
                [$categorySlug]
            )['total'];
        }
        
        return $this->db->fetch(
            'SELECT COUNT(*) as total FROM blog_articles WHERE status = "published"'
        )['total'];
    }
    
    /**
     * Récupérer toutes les catégories avec le nombre d'articles
     */
    public function getCategories() {
        return $this->db->query(
            'SELECT c.*, COUNT(a.id) as article_count
             FROM service_categories c
             LEFT JOIN blog_articles a ON c.id = a.category_id AND a.status = "published"
             GROUP BY c.id
             HAVING article_count > 0
             ORDER BY c.name'
        )->fetchAll();
    }
}
