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
            'metaDescription' => 'Découvrez nos articles sur le marketing digital, l\'automatisation, l\'IA et les stratégies de croissance. Conseils d\'experts pour développer votre activité.',
            'metaKeywords' => 'blog marketing digital, conseils SEO, automatisation, intelligence artificielle, stratégie digitale',
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
        
        // Tunnel de conversion : formation associée à la catégorie
        $relatedFormation = null;
        if (!empty($article['category_id'])) {
            require_once __DIR__ . '/../Models/Formation.php';
            $formationModel = new Formation();
            $formations = $formationModel->getRelated(0, $article['category_id'], 1);
            if (!empty($formations)) {
                $relatedFormation = $formations[0];
            }
        }
        
        // SEO Couche 3 : Temps de lecture + Table des matières + FAQ
        $readingTime = Article::estimateReadingTime($article['content'] ?? '');
        $tocData = Article::generateTableOfContents($article['content'] ?? '');
        $tableOfContents = $tocData['toc'];
        $article['content'] = $tocData['content']; // contenu avec ancres
        $faqSchema = Article::extractFAQ($article['content'] ?? '');
        
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'digita.tonyalpha80.com');
        
        $breadcrumbs = [
            ['name' => 'Accueil', 'url' => $baseUrl . '/'],
            ['name' => 'Blog', 'url' => $baseUrl . '/blog']
        ];
        if (!empty($article['category_name'])) {
            $breadcrumbs[] = ['name' => $article['category_name'], 'url' => $baseUrl . '/blog/categorie/' . $article['category_slug']];
        }
        $breadcrumbs[] = ['name' => $article['title'], 'url' => $baseUrl . '/blog/' . $article['slug']];
        
        $data = [
            'title' => (($article['meta_title'] ?? '') ?: $article['title']) . ' | Digita Marketing',
            'metaDescription' => ($article['meta_description'] ?? '') ?: mb_strimwidth(strip_tags($article['content']), 0, 155, '...'),
            'metaKeywords' => $article['meta_keywords'] ?? '',
            'ogType' => 'article',
            'ogTitle' => ($article['meta_title'] ?? '') ?: $article['title'],
            'ogDescription' => ($article['meta_description'] ?? '') ?: mb_strimwidth(strip_tags($article['content']), 0, 155, '...'),
            'ogImage' => !empty($article['featured_image']) ? $article['featured_image'] : null,
            'schemaType' => 'article',
            'schemaData' => $article,
            'breadcrumbs' => $breadcrumbs,
            'extraCss' => ['/assets/css/blog-layout.css'],
            'article' => $article,
            'readingTime' => $readingTime,
            'tableOfContents' => $tableOfContents,
            'faqSchema' => $faqSchema,
            'relatedFormation' => $relatedFormation,
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
