<?php

require_once __DIR__ . '/../Models/Formation.php';
require_once __DIR__ . '/../Helpers/ViewHelper.php';

class FormationController {
    private $formationModel;
    
    public function __construct() {
        $this->formationModel = new Formation();
    }
    
    /**
     * Page d'accueil des formations - Liste
     */
    public function index() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        $formations = $this->formationModel->getAllPublished($perPage, $offset);
        $totalFormations = $this->formationModel->count();
        $totalPages = ceil($totalFormations / $perPage);
        
        $categories = $this->formationModel->getCategories();
        $popularFormations = $this->formationModel->getPopular(6);
        
        // Utilisation du nouveau système MVC avec layout
        $data = [
            'title' => 'Formations - Marketing Digital | Digita',
            'extraCss' => ['/assets/css/formations.css'],
            'totalFormations' => $totalFormations,
            'formations' => $formations,
            'popularFormations' => $popularFormations,
            'categories' => $categories,
            'page' => $page,
            'totalPages' => $totalPages
        ];
        
        ViewHelper::render('formations/index-content', $data);
    }
    
    /**
     * Afficher une formation complète avec modules et leçons
     */
    public function show($slug) {
        $formation = $this->formationModel->getFullFormation($slug);
        
        if (!$formation) {
            header('HTTP/1.0 404 Not Found');
            require_once __DIR__ . '/../Views/errors/404.php';
            return;
        }
        
        // Formations liées
        $relatedFormations = $this->formationModel->getRelated(
            $formation['id'],
            $formation['category_id'],
            3
        );
        
        // Vérifier si l'utilisateur est inscrit
        $isEnrolled = false;
        $progress = null;
        if (isset($_SESSION['user_id'])) {
            $isEnrolled = $this->formationModel->isEnrolled(
                $_SESSION['user_id'],
                $formation['id']
            );
            if ($isEnrolled) {
                $progress = $this->formationModel->getProgress(
                    $_SESSION['user_id'],
                    $formation['id']
                );
            }
        }
        
        $data = [
            'title' => $formation['title'] . ' - Formations Digita Marketing',
            'extraCss' => ['/assets/css/formations.css'],
            'formation' => $formation,
            'relatedFormations' => $relatedFormations,
            'isEnrolled' => $isEnrolled,
            'progress' => $progress
        ];
        
        ViewHelper::render('formations/show-content', $data);
    }
    
    /**
     * Formations par catégorie
     */
    public function category($categorySlug) {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        $formations = $this->formationModel->getByCategory($categorySlug, $perPage);
        $totalFormations = $this->formationModel->count($categorySlug);
        $totalPages = ceil($totalFormations / $perPage);
        
        $categories = $this->formationModel->getCategories();
        
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
            'title' => $category['name'] . ' - Formations Digita Marketing',
            'extraCss' => ['/assets/css/formations.css'],
            'category' => $category,
            'formations' => $formations,
            'categories' => $categories,
            'totalFormations' => $totalFormations,
            'page' => $page,
            'totalPages' => $totalPages
        ];
        
        ViewHelper::render('formations/category-content', $data);
    }
    
    /**
     * Recherche de formations
     */
    public function search() {
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';
        
        if (empty($query)) {
            header('Location: /formations');
            exit();
        }
        
        $formations = $this->formationModel->search($query, 50);
        $categories = $this->formationModel->getCategories();
        
        require_once __DIR__ . '/../Views/formations/search.php';
    }
    
    /**
     * S'inscrire à une formation
     */
    public function enroll($formationId) {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        
        // Vérifier que la formation existe
        $formation = $this->formationModel->getBySlug($formationId);
        if (!$formation) {
            header('HTTP/1.0 404 Not Found');
            exit();
        }
        
        // Vérifier si déjà inscrit
        if ($this->formationModel->isEnrolled($userId, $formation['id'])) {
            header('Location: /formations/' . $formation['slug']);
            exit();
        }
        
        // Inscrire l'utilisateur
        if ($this->formationModel->enroll($userId, $formation['id'])) {
            $_SESSION['success_message'] = 'Vous êtes maintenant inscrit à cette formation !';
        } else {
            $_SESSION['error_message'] = 'Erreur lors de l\'inscription.';
        }
        
        header('Location: /formations/' . $formation['slug']);
        exit();
    }
    
    /**
     * Mes formations (utilisateur connecté)
     */
    public function myFormations() {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $db = Database::getInstance();
        
        // Récupérer les formations de l'utilisateur
        $enrollments = $db->query(
            'SELECT f.*, e.progress, e.completed, e.enrolled_at, e.completed_at, c.name as category_name
             FROM formation_enrollments e
             JOIN formations f ON e.formation_id = f.id
             LEFT JOIN service_categories c ON f.category_id = c.id
             WHERE e.user_id = ?
             ORDER BY e.enrolled_at DESC',
            [$userId]
        )->fetchAll();
        
        require_once __DIR__ . '/../Views/formations/my-formations.php';
    }
    
    /**
     * Interface d'apprentissage - Accéder aux leçons
     */
    public function learn($slug) {
        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        
        // Récupérer la formation complète
        $formation = $this->formationModel->getFullFormation($slug);
        
        if (!$formation) {
            header('Location: /formations');
            exit();
        }
        
        // Vérifier que l'utilisateur est inscrit
        if (!$this->formationModel->isEnrolled($userId, $formation['id'])) {
            $_SESSION['error_message'] = "Vous devez être inscrit à cette formation pour y accéder.";
            header('Location: /formations/' . $slug);
            exit();
        }
        
        // Récupérer la progression
        $progressData = $this->formationModel->getProgress($userId, $formation['id']);
        $progress = $progressData['progress'] ?? 0;
        
        // Récupérer la leçon actuelle (depuis l'URL ou la première)
        $lessonId = isset($_GET['lesson']) ? (int)$_GET['lesson'] : null;
        
        // Si pas de leçon spécifiée, prendre la première
        if (!$lessonId && !empty($formation['modules'][0]['lessons'])) {
            $lessonId = $formation['modules'][0]['lessons'][0]['id'];
        }
        
        // Trouver la leçon actuelle et les leçons précédente/suivante
        $currentLesson = null;
        $previousLesson = null;
        $nextLesson = null;
        $allLessons = [];
        
        foreach ($formation['modules'] as $module) {
            foreach ($module['lessons'] as $lesson) {
                $allLessons[] = $lesson;
            }
        }
        
        foreach ($allLessons as $index => $lesson) {
            if ($lesson['id'] == $lessonId) {
                $currentLesson = $lesson;
                if ($index > 0) {
                    $previousLesson = $allLessons[$index - 1];
                }
                if ($index < count($allLessons) - 1) {
                    $nextLesson = $allLessons[$index + 1];
                }
                break;
            }
        }
        
        require_once __DIR__ . '/../Views/formations/learn.php';
    }
}
