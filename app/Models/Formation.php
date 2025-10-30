<?php

require_once __DIR__ . '/../../includes/Database.php';

class Formation {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Récupérer toutes les formations publiées
     */
    public function getAllPublished($limit = null, $offset = 0) {
        $sql = 'SELECT f.*, c.name as category_name, c.slug as category_slug, c.icon as category_icon
                FROM formations f
                LEFT JOIN service_categories c ON f.category_id = c.id
                WHERE f.status = "published"
                ORDER BY f.created_at DESC';
        
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    /**
     * Récupérer une formation par son slug
     */
    public function getBySlug($slug) {
        return $this->db->fetch(
            'SELECT f.*, c.name as category_name, c.slug as category_slug, c.icon as category_icon
             FROM formations f
             LEFT JOIN service_categories c ON f.category_id = c.id
             WHERE f.slug = ? AND f.status = "published"',
            [$slug]
        );
    }
    
    /**
     * Récupérer les modules d'une formation
     */
    public function getModules($formationId) {
        return $this->db->query(
            'SELECT * FROM formation_modules
             WHERE formation_id = ?
             ORDER BY order_num',
            [$formationId]
        )->fetchAll();
    }
    
    /**
     * Récupérer les leçons d'un module
     */
    public function getLessons($moduleId) {
        return $this->db->query(
            'SELECT * FROM formation_lessons
             WHERE module_id = ?
             ORDER BY order_num',
            [$moduleId]
        )->fetchAll();
    }
    
    /**
     * Récupérer une formation complète avec modules et leçons
     */
    public function getFullFormation($slug) {
        $formation = $this->getBySlug($slug);
        
        if (!$formation) {
            return null;
        }
        
        $modules = $this->getModules($formation['id']);
        
        foreach ($modules as &$module) {
            $module['lessons'] = $this->getLessons($module['id']);
        }
        
        $formation['modules'] = $modules;
        
        return $formation;
    }
    
    /**
     * Récupérer les formations par catégorie
     */
    public function getByCategory($categorySlug, $limit = null) {
        $sql = 'SELECT f.*, c.name as category_name, c.slug as category_slug, c.icon as category_icon
                FROM formations f
                LEFT JOIN service_categories c ON f.category_id = c.id
                WHERE c.slug = ? AND f.status = "published"
                ORDER BY f.created_at DESC';
        
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit;
        }
        
        return $this->db->query($sql, [$categorySlug])->fetchAll();
    }
    
    /**
     * Récupérer les formations par niveau
     */
    public function getByLevel($level, $limit = null) {
        $sql = 'SELECT f.*, c.name as category_name, c.slug as category_slug
                FROM formations f
                LEFT JOIN service_categories c ON f.category_id = c.id
                WHERE f.level = ? AND f.status = "published"
                ORDER BY f.created_at DESC';
        
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit;
        }
        
        return $this->db->query($sql, [$level])->fetchAll();
    }
    
    /**
     * Rechercher des formations
     */
    public function search($query, $limit = 20) {
        return $this->db->query(
            'SELECT f.*, c.name as category_name, c.slug as category_slug
             FROM formations f
             LEFT JOIN service_categories c ON f.category_id = c.id
             WHERE (f.title LIKE ? OR f.description LIKE ? OR f.service_name LIKE ?)
             AND f.status = "published"
             ORDER BY f.created_at DESC
             LIMIT ?',
            ["%$query%", "%$query%", "%$query%", $limit]
        )->fetchAll();
    }
    
    /**
     * Récupérer les formations populaires
     */
    public function getPopular($limit = 6) {
        return $this->db->query(
            'SELECT f.*, c.name as category_name, c.slug as category_slug
             FROM formations f
             LEFT JOIN service_categories c ON f.category_id = c.id
             WHERE f.status = "published"
             ORDER BY f.enrolled_count DESC, f.rating DESC
             LIMIT ?',
            [$limit]
        )->fetchAll();
    }
    
    /**
     * Récupérer les formations récentes
     */
    public function getRecent($limit = 6) {
        return $this->db->query(
            'SELECT f.*, c.name as category_name, c.slug as category_slug
             FROM formations f
             LEFT JOIN service_categories c ON f.category_id = c.id
             WHERE f.status = "published"
             ORDER BY f.created_at DESC
             LIMIT ?',
            [$limit]
        )->fetchAll();
    }
    
    /**
     * Récupérer les formations liées
     */
    public function getRelated($formationId, $categoryId, $limit = 3) {
        return $this->db->query(
            'SELECT f.*, c.name as category_name, c.slug as category_slug
             FROM formations f
             LEFT JOIN service_categories c ON f.category_id = c.id
             WHERE f.id != ? AND f.category_id = ? AND f.status = "published"
             ORDER BY RAND()
             LIMIT ?',
            [$formationId, $categoryId, $limit]
        )->fetchAll();
    }
    
    /**
     * Inscrire un utilisateur à une formation
     */
    public function enroll($userId, $formationId) {
        try {
            $this->db->query(
                'INSERT INTO formation_enrollments (user_id, formation_id) VALUES (?, ?)',
                [$userId, $formationId]
            );
            
            // Incrémenter le compteur d'inscriptions
            $this->db->query(
                'UPDATE formations SET enrolled_count = enrolled_count + 1 WHERE id = ?',
                [$formationId]
            );
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Vérifier si un utilisateur est inscrit à une formation
     */
    public function isEnrolled($userId, $formationId) {
        $result = $this->db->fetch(
            'SELECT id FROM formation_enrollments WHERE user_id = ? AND formation_id = ?',
            [$userId, $formationId]
        );
        
        return !empty($result);
    }
    
    /**
     * Récupérer la progression d'un utilisateur
     */
    public function getProgress($userId, $formationId) {
        return $this->db->fetch(
            'SELECT * FROM formation_enrollments WHERE user_id = ? AND formation_id = ?',
            [$userId, $formationId]
        );
    }
    
    /**
     * Compter le nombre total de formations
     */
    public function count($categorySlug = null) {
        if ($categorySlug) {
            return $this->db->fetch(
                'SELECT COUNT(*) as total FROM formations f
                 LEFT JOIN service_categories c ON f.category_id = c.id
                 WHERE c.slug = ? AND f.status = "published"',
                [$categorySlug]
            )['total'];
        }
        
        return $this->db->fetch(
            'SELECT COUNT(*) as total FROM formations WHERE status = "published"'
        )['total'];
    }
    
    /**
     * Récupérer toutes les catégories avec le nombre de formations
     */
    public function getCategories() {
        return $this->db->query(
            'SELECT c.*, COUNT(f.id) as formation_count
             FROM service_categories c
             LEFT JOIN formations f ON c.id = f.category_id AND f.status = "published"
             GROUP BY c.id
             HAVING formation_count > 0
             ORDER BY c.name'
        )->fetchAll();
    }
}
