<?php

require_once __DIR__ . '/../Models/Formation.php';
require_once __DIR__ . '/../Models/Quiz.php';
require_once __DIR__ . '/../Models/Certificate.php';
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
        
        // Avis et notation
        $reviews = $this->formationModel->getReviews($formation['id']);
        $averageRating = $this->formationModel->getAverageRating($formation['id']);
        $userReview = null;
        if (isset($_SESSION['user_id'])) {
            $userReview = $this->formationModel->getUserReview($_SESSION['user_id'], $formation['id']);
        }
        
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'digita.tonyalpha80.com');
        
        $data = [
            'title' => ($formation['meta_title'] ?? $formation['title']) . ' | Formations Digita Marketing',
            'metaDescription' => $formation['meta_description'] ?? mb_strimwidth(strip_tags($formation['description'] ?? ''), 0, 155, '...'),
            'metaKeywords' => $formation['meta_keywords'] ?? '',
            'ogType' => 'website',
            'ogTitle' => $formation['meta_title'] ?? $formation['title'],
            'ogDescription' => $formation['meta_description'] ?? mb_strimwidth(strip_tags($formation['description'] ?? ''), 0, 155, '...'),
            'ogImage' => !empty($formation['image']) ? $formation['image'] : null,
            'schemaType' => 'course',
            'schemaData' => $formation,
            'breadcrumbs' => [
                ['name' => 'Accueil', 'url' => $baseUrl . '/'],
                ['name' => 'Formations', 'url' => $baseUrl . '/formations'],
                ['name' => $formation['title'], 'url' => $baseUrl . '/formations/' . $formation['slug']]
            ],
            'extraCss' => ['/assets/css/formations.css'],
            'formation' => $formation,
            'relatedFormations' => $relatedFormations,
            'isEnrolled' => $isEnrolled,
            'progress' => $progress,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'userReview' => $userReview
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
     * Landing page formation (page de vente optimisée conversion)
     */
    public function landing($slug) {
        $formation = $this->formationModel->getFullFormation($slug);
        
        if (!$formation) {
            header('HTTP/1.0 404 Not Found');
            require_once __DIR__ . '/../Views/errors/404.php';
            return;
        }
        
        $reviews = $this->formationModel->getReviews($formation['id']);
        $averageRating = $this->formationModel->getAverageRating($formation['id']);
        
        $data = [
            'title' => $formation['title'] . ' — Formation | Digita Marketing',
            'metaDescription' => $formation['meta_description'] ?? mb_strimwidth(strip_tags($formation['description'] ?? ''), 0, 155, '...'),
            'extraCss' => ['/assets/css/formations.css'],
            'formation' => $formation,
            'reviews' => $reviews,
            'averageRating' => $averageRating
        ];
        
        ViewHelper::render('payment/landing-content', $data);
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
        
        // Paywall : si formation payante, rediriger vers le checkout
        if ((float) ($formation['price'] ?? 0) > 0) {
            header('Location: /formations/checkout/' . $formation['id']);
            exit();
        }
        
        // Formation gratuite : inscrire directement
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
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $formations = $this->formationModel->getUserFormations($userId);
        
        $certificateModel = new Certificate();
        $certificates = $certificateModel->getUserCertificates($userId);
        
        $data = [
            'title' => 'Mes formations - Digita Marketing',
            'extraCss' => ['/assets/css/formations.css'],
            'formations' => $formations,
            'certificates' => $certificates
        ];
        
        ViewHelper::render('formations/my-formations-content', $data);
    }
    
    /**
     * Interface d'apprentissage - Accéder aux leçons
     */
    public function learn($slug) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = '/formations/' . $slug . '/learn';
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $formation = $this->formationModel->getFullFormation($slug);
        
        if (!$formation) {
            header('Location: /formations');
            exit();
        }
        
        if (!$this->formationModel->isEnrolled($userId, $formation['id'])) {
            $_SESSION['error_message'] = "Vous devez être inscrit à cette formation pour y accéder.";
            header('Location: /formations/' . $slug);
            exit();
        }
        
        // Progression enrichie
        $progress = $this->formationModel->getProgress($userId, $formation['id']);
        $completedLessons = $this->formationModel->getCompletedLessons($userId, $formation['id']);
        
        // Leçon actuelle
        $lessonId = isset($_GET['lesson']) ? (int)$_GET['lesson'] : null;
        
        if (!$lessonId && !empty($formation['modules'][0]['lessons'])) {
            $lessonId = $formation['modules'][0]['lessons'][0]['id'];
        }
        
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
                if ($index > 0) $previousLesson = $allLessons[$index - 1];
                if ($index < count($allLessons) - 1) $nextLesson = $allLessons[$index + 1];
                break;
            }
        }
        
        // Quiz du module de la leçon actuelle
        $quizModel = new Quiz();
        $moduleQuiz = null;
        if ($currentLesson) {
            $moduleQuiz = $quizModel->getByModuleId($currentLesson['module_id']);
            if ($moduleQuiz) {
                $moduleQuiz['user_passed'] = $quizModel->hasPassed($userId, $moduleQuiz['id']);
                $moduleQuiz['attempt_count'] = $quizModel->getAttemptCount($userId, $moduleQuiz['id']);
            }
        }
        
        // Vérifier si la formation est terminée (100%)
        $isComplete = $progress && $progress['percentage'] >= 100;
        $certificate = null;
        if ($isComplete) {
            $certModel = new Certificate();
            $certificate = $certModel->getByUserAndFormation($userId, $formation['id']);
        }
        
        $data = [
            'title' => $formation['title'] . ' - Apprentissage',
            'formation' => $formation,
            'currentLesson' => $currentLesson,
            'previousLesson' => $previousLesson,
            'nextLesson' => $nextLesson,
            'allLessons' => $allLessons,
            'progress' => $progress,
            'completedLessons' => $completedLessons,
            'moduleQuiz' => $moduleQuiz,
            'isComplete' => $isComplete,
            'certificate' => $certificate
        ];
        
        ViewHelper::render('formations/learn-content', $data, 'learn');
    }
    
    /**
     * Marquer une leçon comme complétée (AJAX)
     */
    public function completeLesson() {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'error' => 'Non connecté']);
            exit();
        }
        
        $lessonId = (int)($_POST['lesson_id'] ?? 0);
        $formationId = (int)($_POST['formation_id'] ?? 0);
        
        if (!$lessonId || !$formationId) {
            echo json_encode(['success' => false, 'error' => 'Paramètres manquants']);
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $result = $this->formationModel->completeLesson($userId, $lessonId, $formationId);
        $progress = $this->formationModel->getProgress($userId, $formationId);
        
        echo json_encode([
            'success' => $result,
            'progress' => $progress
        ]);
        exit();
    }
    
    /**
     * Afficher un quiz
     */
    public function quiz($quizId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $quizModel = new Quiz();
        $quiz = $quizModel->getById($quizId);
        
        if (!$quiz) {
            header('HTTP/1.0 404 Not Found');
            require_once __DIR__ . '/../Views/errors/404.php';
            return;
        }
        
        $userId = $_SESSION['user_id'];
        
        // Vérifier l'inscription à la formation
        if (!$this->formationModel->isEnrolled($userId, $quiz['formation_id'])) {
            header('Location: /formations');
            exit();
        }
        
        $questions = $quizModel->getQuestions($quizId);
        $attemptCount = $quizModel->getAttemptCount($userId, $quizId);
        $bestAttempt = $quizModel->getBestAttempt($userId, $quizId);
        $canAttempt = $quiz['max_attempts'] == 0 || $attemptCount < $quiz['max_attempts'];
        
        // Récupérer la formation pour le breadcrumb
        $formation = $this->formationModel->getById($quiz['formation_id']);
        
        $data = [
            'title' => $quiz['title'] . ' - Quiz',
            'quiz' => $quiz,
            'questions' => $questions,
            'attemptCount' => $attemptCount,
            'bestAttempt' => $bestAttempt,
            'canAttempt' => $canAttempt,
            'formation' => $formation
        ];
        
        ViewHelper::render('formations/quiz-content', $data);
    }
    
    /**
     * Soumettre les réponses d'un quiz (POST)
     */
    public function submitQuiz($quizId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $quizModel = new Quiz();
        $quiz = $quizModel->getById($quizId);
        
        if (!$quiz) {
            header('Location: /formations');
            exit();
        }
        
        // Démarrer la tentative
        $attemptId = $quizModel->startAttempt($userId, $quizId);
        if (!$attemptId) {
            $_SESSION['error_message'] = 'Nombre maximum de tentatives atteint.';
            header('Location: /formations/quiz/' . $quizId);
            exit();
        }
        
        // Collecter les réponses
        $answers = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'question_') === 0) {
                $questionId = (int)str_replace('question_', '', $key);
                $answers[$questionId] = $value;
            }
        }
        
        // Soumettre et obtenir les résultats
        $results = $quizModel->submitAttempt($attemptId, $answers);
        
        $_SESSION['quiz_results'] = $results;
        $_SESSION['quiz_results']['quiz'] = $quiz;
        
        header('Location: /formations/quiz/' . $quizId . '/results');
        exit();
    }
    
    /**
     * Afficher les résultats d'un quiz
     */
    public function quizResults($quizId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $results = $_SESSION['quiz_results'] ?? null;
        unset($_SESSION['quiz_results']);
        
        $quizModel = new Quiz();
        $quiz = $quizModel->getById($quizId);
        $userId = $_SESSION['user_id'];
        
        if (!$results) {
            // Afficher la meilleure tentative
            $bestAttempt = $quizModel->getBestAttempt($userId, $quizId);
            $results = $bestAttempt ? [
                'score' => $bestAttempt['score'],
                'max_score' => $bestAttempt['max_score'],
                'percentage' => $bestAttempt['percentage'],
                'passed' => $bestAttempt['passed'],
                'results' => json_decode($bestAttempt['answers_json'], true)
            ] : null;
        }
        
        $formation = $this->formationModel->getById($quiz['formation_id']);
        
        $data = [
            'title' => 'Résultats - ' . $quiz['title'],
            'quiz' => $quiz,
            'results' => $results,
            'formation' => $formation
        ];
        
        ViewHelper::render('formations/quiz-results-content', $data);
    }
    
    /**
     * Soumettre un avis sur une formation (POST)
     */
    public function review($formationId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $formation = $this->formationModel->getById($formationId);
        
        if (!$formation) {
            header('Location: /formations');
            exit();
        }
        
        if (!$this->formationModel->isEnrolled($userId, $formationId)) {
            $_SESSION['error_message'] = 'Vous devez être inscrit pour laisser un avis.';
            header('Location: /formations/' . $formation['slug']);
            exit();
        }
        
        $data = [
            'rating' => max(1, min(5, (int)($_POST['rating'] ?? 5))),
            'title' => trim($_POST['title'] ?? ''),
            'comment' => trim($_POST['comment'] ?? '')
        ];
        
        if ($this->formationModel->addReview($userId, $formationId, $data)) {
            $_SESSION['success_message'] = 'Merci pour votre avis ! Il sera publié après modération.';
        } else {
            $_SESSION['error_message'] = 'Erreur lors de l\'envoi de votre avis.';
        }
        
        header('Location: /formations/' . $formation['slug']);
        exit();
    }
    
    /**
     * Générer/afficher un certificat
     */
    public function certificate($formationId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $formation = $this->formationModel->getById($formationId);
        
        if (!$formation) {
            header('Location: /formations');
            exit();
        }
        
        // Vérifier que la formation est complétée
        $progress = $this->formationModel->getProgress($userId, $formationId);
        if (!$progress || $progress['percentage'] < 100) {
            $_SESSION['error_message'] = 'Vous devez terminer la formation pour obtenir votre certificat.';
            header('Location: /formations/' . $formation['slug'] . '/learn');
            exit();
        }
        
        $certModel = new Certificate();
        $certificate = $certModel->generate($userId, $formationId);
        
        // Récupérer les infos utilisateur
        require_once __DIR__ . '/../Models/User.php';
        $userModel = new User();
        $user = $userModel->find($userId);
        
        $data = [
            'title' => 'Certificat - ' . $formation['title'],
            'certificate' => $certificate,
            'formation' => $formation,
            'user' => $user
        ];
        
        ViewHelper::render('formations/certificate-content', $data);
    }
    
    /**
     * Vérification publique d'un certificat
     */
    public function verifyCertificate() {
        $number = trim($_GET['number'] ?? '');
        
        $certModel = new Certificate();
        $certificate = !empty($number) ? $certModel->verify($number) : null;
        
        $data = [
            'title' => 'Vérification de certificat - Digita Marketing',
            'certificate' => $certificate,
            'searchNumber' => $number
        ];
        
        ViewHelper::render('formations/verify-certificate-content', $data);
    }
}
