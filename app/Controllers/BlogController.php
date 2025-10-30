<?php

require_once __DIR__ . '/../Models/Article.php';
require_once __DIR__ . '/../Helpers/ViewHelper.php';

class BlogController {
    private $articleModel;
    
    public function __construct() {
        $this->articleModel = new Article();
    }
    
    /**
     * Page d'accueil du blog - Liste des articles
     */
    public function index() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        $articles = $this->articleModel->getAllPublished($perPage, $offset);
        $totalArticles = $this->articleModel->count();
        $totalPages = ceil($totalArticles / $perPage);
        
        $categories = $this->articleModel->getCategories();
        $popularArticles = $this->articleModel->getPopular(5);
        $recentArticles = $this->articleModel->getRecent(5);
        
        // Utilisation du nouveau système MVC avec layout
        $data = [
            'title' => 'Blog - Actualités & Conseils | Digita Marketing',
            'extraCss' => ['/assets/css/blog-layout.css'],
            'totalArticles' => $totalArticles,
            'articles' => $articles,
            'popularArticles' => $popularArticles,
            'recentArticles' => $recentArticles,
            'categories' => $categories,
            'currentPage' => $page,
            'totalPages' => $totalPages
        ];
        
        ViewHelper::render('blog/index-content', $data);
    }
    
    /**
     * Afficher un article complet
     */
    public function show($slug) {
        $article = $this->articleModel->getBySlug($slug);
        
        if (!$article) {
            header('HTTP/1.0 404 Not Found');
            require_once __DIR__ . '/../Views/errors/404.php';
            return;
        }
        
        // Articles liés
        $relatedArticles = $this->articleModel->getRelated(
            $article['id'],
            $article['category_id'],
            3
        );
        
        // Articles populaires
        $popularArticles = $this->articleModel->getPopular(5);
        
        $data = [
            'title' => $article['title'] . ' - Blog Digita Marketing',
            'extraCss' => ['/assets/css/blog-layout.css'],
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'popularArticles' => $popularArticles
        ];
        
        ViewHelper::render('blog/show-content', $data);
    }
    
    /**
     * Articles par catégorie
     */
    public function category($categorySlug) {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        $articles = $this->articleModel->getByCategory($categorySlug, $perPage);
        $totalArticles = $this->articleModel->count($categorySlug);
        $totalPages = ceil($totalArticles / $perPage);
        
        $categories = $this->articleModel->getCategories();
        $category = null;
        
        // Récupérer les infos de la catégorie
        $db = Database::getInstance();
        $category = $db->fetch(
            'SELECT * FROM service_categories WHERE slug = ?',
            [$categorySlug]
        );
        
        if (!$category) {
            header('HTTP/1.0 404 Not Found');
            require_once __DIR__ . '/../Views/errors/404.php';
            return;
        }
        
        $data = [
            'title' => $category['name'] . ' - Blog Digita Marketing',
            'extraCss' => ['/assets/css/blog-layout.css'],
            'category' => $category,
            'articles' => $articles,
            'totalArticles' => $totalArticles,
            'page' => $page,
            'totalPages' => $totalPages,
            'categories' => $categories
        ];
        
        ViewHelper::render('blog/category-content', $data);
    }
    
    /**
     * Recherche d'articles
     */
    public function search() {
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (empty($query)) {
            header('Location: /blog');
            exit();
        }
        
        $articles = $this->articleModel->search($query, 50);
        $categories = $this->articleModel->getCategories();
        $popularArticles = $this->articleModel->getPopular(5);
        
        require_once __DIR__ . '/../Views/blog/search.php';
    }
}
