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
     * Récupérer la progression d'un utilisateur (enrichie)
     */
    public function getProgress($userId, $formationId) {
        $enrollment = $this->db->fetch(
            'SELECT * FROM formation_enrollments WHERE user_id = ? AND formation_id = ?',
            [$userId, $formationId]
        );
        
        if (!$enrollment) return null;
        
        // Compter les leçons totales et complétées
        $totalLessons = $this->db->fetch(
            'SELECT COUNT(*) as total FROM formation_lessons fl
             JOIN formation_modules fm ON fl.module_id = fm.id
             WHERE fm.formation_id = ?',
            [$formationId]
        )['total'];
        
        $completedLessons = $this->db->fetch(
            'SELECT COUNT(*) as total FROM lesson_completions
             WHERE user_id = ? AND formation_id = ?',
            [$userId, $formationId]
        )['total'];
        
        $enrollment['total_lessons'] = (int)$totalLessons;
        $enrollment['completed_lessons'] = (int)$completedLessons;
        $enrollment['percentage'] = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
        
        return $enrollment;
    }
    
    /**
     * Marquer une leçon comme complétée
     */
    public function completeLesson($userId, $lessonId, $formationId) {
        try {
            $this->db->query(
                'INSERT IGNORE INTO lesson_completions (user_id, lesson_id, formation_id) VALUES (?, ?, ?)',
                [$userId, $lessonId, $formationId]
            );
            
            // Mettre à jour le pourcentage dans formation_enrollments
            $progress = $this->getProgress($userId, $formationId);
            if ($progress) {
                $this->db->query(
                    'UPDATE formation_enrollments SET progress = ? WHERE user_id = ? AND formation_id = ?',
                    [$progress['percentage'], $userId, $formationId]
                );
            }
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Vérifier si une leçon est complétée
     */
    public function isLessonCompleted($userId, $lessonId) {
        $result = $this->db->fetch(
            'SELECT id FROM lesson_completions WHERE user_id = ? AND lesson_id = ?',
            [$userId, $lessonId]
        );
        return !empty($result);
    }
    
    /**
     * Récupérer les leçons complétées d'une formation pour un utilisateur
     */
    public function getCompletedLessons($userId, $formationId) {
        return $this->db->query(
            'SELECT lesson_id FROM lesson_completions WHERE user_id = ? AND formation_id = ?',
            [$userId, $formationId]
        )->fetchAll(\PDO::FETCH_COLUMN);
    }
    
    /**
     * Récupérer les formations d'un utilisateur avec progression
     */
    public function getUserFormations($userId) {
        $formations = $this->db->query(
            'SELECT f.*, fe.progress, fe.completed, fe.enrolled_at, fe.completed_at,
                    c.name as category_name, c.slug as category_slug
             FROM formations f
             JOIN formation_enrollments fe ON f.id = fe.formation_id
             LEFT JOIN service_categories c ON f.category_id = c.id
             WHERE fe.user_id = ?
             ORDER BY fe.enrolled_at DESC',
            [$userId]
        )->fetchAll();
        
        // Enrichir avec le vrai pourcentage
        foreach ($formations as &$formation) {
            $progress = $this->getProgress($userId, $formation['id']);
            if ($progress) {
                $formation['percentage'] = $progress['percentage'];
                $formation['total_lessons'] = $progress['total_lessons'];
                $formation['completed_lessons'] = $progress['completed_lessons'];
            }
        }
        
        return $formations;
    }
    
    /**
     * Récupérer une leçon par son ID
     */
    public function getLessonById($lessonId) {
        return $this->db->fetch(
            'SELECT fl.*, fm.formation_id, fm.title as module_title, fm.order_num as module_order
             FROM formation_lessons fl
             JOIN formation_modules fm ON fl.module_id = fm.id
             WHERE fl.id = ?',
            [$lessonId]
        );
    }
    
    /**
     * Récupérer la leçon suivante
     */
    public function getNextLesson($lessonId) {
        $current = $this->getLessonById($lessonId);
        if (!$current) return null;
        
        // Chercher dans le même module
        $next = $this->db->fetch(
            'SELECT fl.* FROM formation_lessons fl
             WHERE fl.module_id = ? AND fl.order_num > ?
             ORDER BY fl.order_num LIMIT 1',
            [$current['module_id'], $current['order_num']]
        );
        
        if ($next) return $next;
        
        // Sinon, première leçon du module suivant
        $nextModule = $this->db->fetch(
            'SELECT fm.id FROM formation_modules fm
             WHERE fm.formation_id = ? AND fm.order_num > ?
             ORDER BY fm.order_num LIMIT 1',
            [$current['formation_id'], $current['module_order']]
        );
        
        if ($nextModule) {
            return $this->db->fetch(
                'SELECT * FROM formation_lessons WHERE module_id = ? ORDER BY order_num LIMIT 1',
                [$nextModule['id']]
            );
        }
        
        return null;
    }
    
    /**
     * Récupérer la leçon précédente
     */
    public function getPreviousLesson($lessonId) {
        $current = $this->getLessonById($lessonId);
        if (!$current) return null;
        
        // Chercher dans le même module
        $prev = $this->db->fetch(
            'SELECT fl.* FROM formation_lessons fl
             WHERE fl.module_id = ? AND fl.order_num < ?
             ORDER BY fl.order_num DESC LIMIT 1',
            [$current['module_id'], $current['order_num']]
        );
        
        if ($prev) return $prev;
        
        // Sinon, dernière leçon du module précédent
        $prevModule = $this->db->fetch(
            'SELECT fm.id FROM formation_modules fm
             WHERE fm.formation_id = ? AND fm.order_num < ?
             ORDER BY fm.order_num DESC LIMIT 1',
            [$current['formation_id'], $current['module_order']]
        );
        
        if ($prevModule) {
            return $this->db->fetch(
                'SELECT * FROM formation_lessons WHERE module_id = ? ORDER BY order_num DESC LIMIT 1',
                [$prevModule['id']]
            );
        }
        
        return null;
    }
    
    // ==================== AVIS ET NOTATION ====================
    
    /**
     * Ajouter un avis
     */
    public function addReview($userId, $formationId, $data) {
        try {
            $this->db->query(
                'INSERT INTO formation_reviews (user_id, formation_id, rating, title, comment)
                 VALUES (?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE rating = VALUES(rating), title = VALUES(title), 
                 comment = VALUES(comment), status = "pending"',
                [$userId, $formationId, $data['rating'], $data['title'] ?? null, $data['comment'] ?? null]
            );
            
            // Recalculer la note moyenne
            $this->updateAverageRating($formationId);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Récupérer les avis approuvés d'une formation
     */
    public function getReviews($formationId, $limit = 10) {
        return $this->db->query(
            'SELECT fr.*, u.username
             FROM formation_reviews fr
             JOIN users u ON fr.user_id = u.id
             WHERE fr.formation_id = ? AND fr.status = "approved"
             ORDER BY fr.created_at DESC
             LIMIT ?',
            [$formationId, $limit]
        )->fetchAll();
    }
    
    /**
     * Récupérer l'avis d'un utilisateur pour une formation
     */
    public function getUserReview($userId, $formationId) {
        return $this->db->fetch(
            'SELECT * FROM formation_reviews WHERE user_id = ? AND formation_id = ?',
            [$userId, $formationId]
        );
    }
    
    /**
     * Récupérer la note moyenne et le nombre d'avis d'une formation
     */
    public function getAverageRating($formationId) {
        return $this->db->fetch(
            'SELECT COALESCE(AVG(rating), 0) as average, COUNT(*) as count
             FROM formation_reviews
             WHERE formation_id = ? AND status = "approved"',
            [$formationId]
        );
    }
    
    /**
     * Mettre à jour la note moyenne d'une formation
     */
    private function updateAverageRating($formationId) {
        $result = $this->db->fetch(
            'SELECT AVG(rating) as avg_rating FROM formation_reviews 
             WHERE formation_id = ? AND status = "approved"',
            [$formationId]
        );
        
        $avgRating = $result['avg_rating'] ? round($result['avg_rating'], 2) : 0;
        $this->db->query(
            'UPDATE formations SET rating = ? WHERE id = ?',
            [$avgRating, $formationId]
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
    
    // ==================== MÉTHODES ADMIN CRUD ====================
    
    /**
     * Récupérer toutes les formations (tous statuts) pour l'admin
     */
    public function getAll($limit = null, $offset = 0, $status = null, $categoryId = null, $search = null) {
        $sql = 'SELECT f.*, c.name as category_name, c.slug as category_slug
                FROM formations f
                LEFT JOIN service_categories c ON f.category_id = c.id
                WHERE 1=1';
        $params = [];
        
        if ($status) {
            $sql .= ' AND f.status = ?';
            $params[] = $status;
        }
        if ($categoryId) {
            $sql .= ' AND f.category_id = ?';
            $params[] = $categoryId;
        }
        if ($search) {
            $sql .= ' AND (f.title LIKE ? OR f.description LIKE ?)';
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        $sql .= ' ORDER BY f.created_at DESC';
        
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;
        }
        
        return $this->db->query($sql, $params)->fetchAll();
    }
    
    /**
     * Compter les formations admin (tous statuts)
     */
    public function countAll($status = null, $categoryId = null, $search = null) {
        $sql = 'SELECT COUNT(*) as total FROM formations f WHERE 1=1';
        $params = [];
        
        if ($status) {
            $sql .= ' AND f.status = ?';
            $params[] = $status;
        }
        if ($categoryId) {
            $sql .= ' AND f.category_id = ?';
            $params[] = $categoryId;
        }
        if ($search) {
            $sql .= ' AND (f.title LIKE ? OR f.description LIKE ?)';
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        return $this->db->fetch($sql, $params)['total'];
    }
    
    /**
     * Récupérer une formation par son ID (admin, tous statuts)
     */
    public function getById($id) {
        return $this->db->fetch(
            'SELECT f.*, c.name as category_name, c.slug as category_slug
             FROM formations f
             LEFT JOIN service_categories c ON f.category_id = c.id
             WHERE f.id = ?',
            [$id]
        );
    }
    
    /**
     * Récupérer une formation complète par ID (admin)
     */
    public function getFullFormationById($id) {
        $formation = $this->getById($id);
        
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
     * Créer une formation
     */
    public function create($data) {
        $sql = 'INSERT INTO formations (title, slug, description, category_id, service_name, level, duration,
                price, image, meta_title, meta_description, meta_keywords, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())';
        
        $this->db->query($sql, [
            $data['title'],
            $data['slug'],
            $data['description'] ?? '',
            $data['category_id'] ?: null,
            $data['service_name'] ?? '',
            $data['level'] ?? 'debutant',
            $data['duration'] ?? '',
            $data['price'] ?? 0,
            $data['image'] ?? '',
            $data['meta_title'] ?? $data['title'],
            $data['meta_description'] ?? '',
            $data['meta_keywords'] ?? '',
            $data['status'] ?? 'draft'
        ]);
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Mettre à jour une formation
     */
    public function update($id, $data) {
        $sql = 'UPDATE formations SET 
                title = ?, slug = ?, description = ?, category_id = ?, service_name = ?,
                level = ?, duration = ?, price = ?, image = ?,
                meta_title = ?, meta_description = ?, meta_keywords = ?, status = ?, updated_at = NOW()
                WHERE id = ?';
        
        $this->db->query($sql, [
            $data['title'],
            $data['slug'],
            $data['description'] ?? '',
            $data['category_id'] ?: null,
            $data['service_name'] ?? '',
            $data['level'] ?? 'debutant',
            $data['duration'] ?? '',
            $data['price'] ?? 0,
            $data['image'] ?? '',
            $data['meta_title'] ?? $data['title'],
            $data['meta_description'] ?? '',
            $data['meta_keywords'] ?? '',
            $data['status'] ?? 'draft',
            $id
        ]);
        
        return true;
    }
    
    /**
     * Supprimer une formation et ses modules/leçons
     */
    public function delete($id) {
        // Supprimer les leçons des modules
        $modules = $this->getModules($id);
        foreach ($modules as $module) {
            $this->db->query('DELETE FROM formation_lessons WHERE module_id = ?', [$module['id']]);
        }
        // Supprimer les modules
        $this->db->query('DELETE FROM formation_modules WHERE formation_id = ?', [$id]);
        // Supprimer les inscriptions
        $this->db->query('DELETE FROM formation_enrollments WHERE formation_id = ?', [$id]);
        // Supprimer la formation
        $this->db->query('DELETE FROM formations WHERE id = ?', [$id]);
        return true;
    }
    
    /**
     * Récupérer toutes les catégories (admin, même sans formations)
     */
    public function getAllCategories() {
        return $this->db->query(
            'SELECT c.*, COUNT(f.id) as formation_count
             FROM service_categories c
             LEFT JOIN formations f ON c.id = f.category_id
             GROUP BY c.id
             ORDER BY c.name'
        )->fetchAll();
    }
    
    /**
     * Générer un slug unique pour formation
     */
    public function generateSlug($title, $excludeId = null) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[àáâãäå]/', 'a', $slug);
        $slug = preg_replace('/[èéêë]/', 'e', $slug);
        $slug = preg_replace('/[ìíîï]/', 'i', $slug);
        $slug = preg_replace('/[òóôõö]/', 'o', $slug);
        $slug = preg_replace('/[ùúûü]/', 'u', $slug);
        $slug = preg_replace('/[ç]/', 'c', $slug);
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        $baseSlug = $slug;
        $counter = 1;
        
        while (true) {
            $sql = 'SELECT id FROM formations WHERE slug = ?';
            $params = [$slug];
            
            if ($excludeId) {
                $sql .= ' AND id != ?';
                $params[] = $excludeId;
            }
            
            $existing = $this->db->fetch($sql, $params);
            
            if (!$existing) {
                break;
            }
            
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
    
    /**
     * Statistiques formations pour le dashboard admin
     */
    public function getFormationStats() {
        $total = $this->db->fetch('SELECT COUNT(*) as total FROM formations')['total'];
        $published = $this->db->fetch('SELECT COUNT(*) as total FROM formations WHERE status = "published"')['total'];
        $draft = $this->db->fetch('SELECT COUNT(*) as total FROM formations WHERE status = "draft"')['total'];
        $totalEnrolled = $this->db->fetch('SELECT COALESCE(SUM(enrolled_count), 0) as total FROM formations')['total'];
        $totalModules = $this->db->fetch('SELECT COUNT(*) as total FROM formation_modules')['total'];
        $totalLessons = $this->db->fetch('SELECT COUNT(*) as total FROM formation_lessons')['total'];
        
        return [
            'total' => $total,
            'published' => $published,
            'draft' => $draft,
            'total_enrolled' => $totalEnrolled,
            'total_modules' => $totalModules,
            'total_lessons' => $totalLessons
        ];
    }
}
