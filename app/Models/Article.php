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
    
    // ==================== MÉTHODES ADMIN CRUD ====================
    
    /**
     * Récupérer tous les articles (tous statuts) pour l'admin
     */
    public function getAll($limit = null, $offset = 0, $status = null, $categoryId = null, $search = null) {
        $sql = 'SELECT a.*, c.name as category_name, c.slug as category_slug
                FROM blog_articles a
                LEFT JOIN service_categories c ON a.category_id = c.id
                WHERE 1=1';
        $params = [];
        
        if ($status) {
            $sql .= ' AND a.status = ?';
            $params[] = $status;
        }
        if ($categoryId) {
            $sql .= ' AND a.category_id = ?';
            $params[] = $categoryId;
        }
        if ($search) {
            $sql .= ' AND (a.title LIKE ? OR a.content LIKE ?)';
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        $sql .= ' ORDER BY a.created_at DESC';
        
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;
        }
        
        return $this->db->query($sql, $params)->fetchAll();
    }
    
    /**
     * Compter les articles admin (tous statuts)
     */
    public function countAll($status = null, $categoryId = null, $search = null) {
        $sql = 'SELECT COUNT(*) as total FROM blog_articles a WHERE 1=1';
        $params = [];
        
        if ($status) {
            $sql .= ' AND a.status = ?';
            $params[] = $status;
        }
        if ($categoryId) {
            $sql .= ' AND a.category_id = ?';
            $params[] = $categoryId;
        }
        if ($search) {
            $sql .= ' AND (a.title LIKE ? OR a.content LIKE ?)';
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        return $this->db->fetch($sql, $params)['total'];
    }
    
    /**
     * Récupérer un article par son ID (admin, tous statuts)
     */
    public function getById($id) {
        return $this->db->fetch(
            'SELECT a.*, c.name as category_name, c.slug as category_slug
             FROM blog_articles a
             LEFT JOIN service_categories c ON a.category_id = c.id
             WHERE a.id = ?',
            [$id]
        );
    }
    
    /**
     * Créer un article
     */
    public function create($data) {
        $sql = 'INSERT INTO blog_articles (title, slug, content, excerpt, category_id, service_name, 
                meta_title, meta_description, meta_keywords, featured_image, status, published_at, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())';
        
        $this->db->query($sql, [
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['excerpt'] ?? '',
            $data['category_id'] ?: null,
            $data['service_name'] ?? '',
            $data['meta_title'] ?? $data['title'],
            $data['meta_description'] ?? '',
            $data['meta_keywords'] ?? '',
            $data['featured_image'] ?? '',
            $data['status'] ?? 'draft',
            $data['status'] === 'published' ? date('Y-m-d H:i:s') : null
        ]);
        
        return $this->db->lastInsertId();
    }
    
    /**
     * Mettre à jour un article
     */
    public function update($id, $data) {
        $article = $this->getById($id);
        
        $publishedAt = $article['published_at'];
        if ($data['status'] === 'published' && !$publishedAt) {
            $publishedAt = date('Y-m-d H:i:s');
        }
        
        $sql = 'UPDATE blog_articles SET 
                title = ?, slug = ?, content = ?, excerpt = ?, category_id = ?, service_name = ?,
                meta_title = ?, meta_description = ?, meta_keywords = ?, featured_image = ?, 
                status = ?, published_at = ?, updated_at = NOW()
                WHERE id = ?';
        
        $this->db->query($sql, [
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['excerpt'] ?? '',
            $data['category_id'] ?: null,
            $data['service_name'] ?? '',
            $data['meta_title'] ?? $data['title'],
            $data['meta_description'] ?? '',
            $data['meta_keywords'] ?? '',
            $data['featured_image'] ?? $article['featured_image'] ?? '',
            $data['status'] ?? 'draft',
            $publishedAt,
            $id
        ]);
        
        return true;
    }
    
    /**
     * Supprimer un article
     */
    public function delete($id) {
        $this->db->query('DELETE FROM blog_articles WHERE id = ?', [$id]);
        return true;
    }
    
    /**
     * Récupérer toutes les catégories (admin, même sans articles)
     */
    public function getAllCategories() {
        return $this->db->query(
            'SELECT c.*, COUNT(a.id) as article_count
             FROM service_categories c
             LEFT JOIN blog_articles a ON c.id = a.category_id
             GROUP BY c.id
             ORDER BY c.name'
        )->fetchAll();
    }
    
    /**
     * Générer un slug unique
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
            $sql = 'SELECT id FROM blog_articles WHERE slug = ?';
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
    
    // ==================== SEO COUCHE 3 ====================
    
    /**
     * Estimer le temps de lecture d'un article (en minutes)
     * Basé sur 200 mots/minute en français
     */
    public static function estimateReadingTime($content) {
        $text = strip_tags($content);
        $wordCount = str_word_count($text);
        $minutes = max(1, ceil($wordCount / 200));
        return $minutes;
    }
    
    /**
     * Générer une table des matières à partir des titres H2/H3 du contenu
     * Retourne un tableau structuré + le contenu modifié avec des ancres
     */
    public static function generateTableOfContents($content) {
        $toc = [];
        $modifiedContent = $content;
        
        // Trouver tous les H2 et H3
        preg_match_all('/<(h[23])[^>]*>(.*?)<\/\1>/si', $content, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
        
        if (count($matches) < 2) {
            return ['toc' => [], 'content' => $content];
        }
        
        // Parcourir en sens inverse pour ne pas décaler les offsets
        $items = [];
        foreach ($matches as $match) {
            $tag = strtolower($match[1][0]);
            $text = strip_tags($match[2][0]);
            $slug = self::slugify($text);
            
            $items[] = [
                'tag' => $tag,
                'text' => $text,
                'slug' => $slug,
                'level' => ($tag === 'h2') ? 2 : 3,
                'full_match' => $match[0][0],
                'offset' => $match[0][1]
            ];
        }
        
        // Construire la TOC
        foreach ($items as $item) {
            $toc[] = [
                'text' => $item['text'],
                'slug' => $item['slug'],
                'level' => $item['level']
            ];
        }
        
        // Ajouter les ancres dans le contenu (en sens inverse)
        for ($i = count($items) - 1; $i >= 0; $i--) {
            $item = $items[$i];
            $replacement = '<' . $item['tag'] . ' id="' . htmlspecialchars($item['slug']) . '">' . $item['text'] . '</' . $item['tag'] . '>';
            $modifiedContent = substr_replace($modifiedContent, $replacement, $item['offset'], strlen($item['full_match']));
        }
        
        return ['toc' => $toc, 'content' => $modifiedContent];
    }
    
    /**
     * Extraire les FAQ d'un article (questions/réponses)
     * Détecte les patterns : titres H2/H3 contenant "?" suivis de paragraphes
     */
    public static function extractFAQ($content) {
        $faq = [];
        
        // Pattern : H2 ou H3 contenant un "?" suivi d'un paragraphe
        preg_match_all('/<h[23][^>]*>([^<]*\?[^<]*)<\/h[23]>\s*<p>([^<]+(?:<[^\/][^>]*>[^<]*<\/[^>]+>)*[^<]*)<\/p>/si', $content, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $question = trim(strip_tags($match[1]));
            $answer = trim(strip_tags($match[2]));
            
            if (mb_strlen($question) > 10 && mb_strlen($answer) > 20) {
                $faq[] = [
                    'question' => $question,
                    'answer' => mb_strimwidth($answer, 0, 500, '...')
                ];
            }
        }
        
        return $faq;
    }
    
    /**
     * Générer un slug à partir d'un texte
     */
    private static function slugify($text) {
        $text = strtolower(trim($text));
        $text = preg_replace('/[àáâãäå]/u', 'a', $text);
        $text = preg_replace('/[èéêë]/u', 'e', $text);
        $text = preg_replace('/[ìíîï]/u', 'i', $text);
        $text = preg_replace('/[òóôõö]/u', 'o', $text);
        $text = preg_replace('/[ùúûü]/u', 'u', $text);
        $text = preg_replace('/[ç]/u', 'c', $text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');
        return $text;
    }
    
    /**
     * Statistiques articles pour le dashboard admin
     */
    public function getStats() {
        $total = $this->db->fetch('SELECT COUNT(*) as total FROM blog_articles')['total'];
        $published = $this->db->fetch('SELECT COUNT(*) as total FROM blog_articles WHERE status = "published"')['total'];
        $draft = $this->db->fetch('SELECT COUNT(*) as total FROM blog_articles WHERE status = "draft"')['total'];
        $totalViews = $this->db->fetch('SELECT COALESCE(SUM(views), 0) as total FROM blog_articles')['total'];
        
        return [
            'total' => $total,
            'published' => $published,
            'draft' => $draft,
            'total_views' => $totalViews
        ];
    }
}
