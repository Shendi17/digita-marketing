<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Project.php';
require_once __DIR__ . '/../Models/ProjectMessage.php';
require_once __DIR__ . '/../Helpers/ViewHelper.php';

/**
 * Contrôleur Projets (côté client)
 * Gère le brief, le dashboard client, la messagerie et les fichiers
 */
class ProjectController extends Controller {
    
    private $projectModel;
    
    public function __construct() {
        $this->projectModel = new Project();
    }
    
    /**
     * Formulaire de brief client (étape 1)
     */
    public function briefForm() {
        $data = [
            'title' => 'Créer votre projet — Digita Marketing',
            'metaDescription' => 'Décrivez votre projet et recevez un devis automatique pour la création de votre site web, e-commerce ou landing page.',
            'projectTypes' => Project::$types
        ];
        
        ViewHelper::render('projects/brief-form-content', $data);
    }
    
    /**
     * Soumettre le brief (POST)
     */
    public function submitBrief() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /projets/brief');
            exit();
        }
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = '/projets/brief';
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        
        // Validation
        $projectType = $_POST['project_type'] ?? '';
        $title = trim($_POST['title'] ?? '');
        $brief = trim($_POST['brief'] ?? '');
        
        if (empty($projectType) || empty($title) || empty($brief)) {
            $_SESSION['error_message'] = 'Veuillez remplir tous les champs obligatoires.';
            header('Location: /projets/brief');
            exit();
        }
        
        // Données du brief détaillé
        $briefData = [
            'business_name' => trim($_POST['business_name'] ?? ''),
            'business_type' => trim($_POST['business_type'] ?? ''),
            'target_audience' => trim($_POST['target_audience'] ?? ''),
            'style' => $_POST['style'] ?? 'modern',
            'colors' => array_filter(explode(',', $_POST['colors'] ?? '')),
            'pages' => (int)($_POST['pages'] ?? 5),
            'features' => $_POST['features'] ?? [],
            'content_tone' => $_POST['content_tone'] ?? 'professionnel',
            'existing_url' => trim($_POST['existing_url'] ?? ''),
            'competitors' => trim($_POST['competitors'] ?? ''),
            'deadline' => $_POST['deadline'] ?? '',
            'budget' => $_POST['budget'] ?? '',
            'urgent' => !empty($_POST['urgent'])
        ];
        
        // Calcul du devis automatique
        $price = Project::calculateQuote($projectType, $briefData);
        
        // Estimation des jours
        $estimatedDays = [
            'website' => 7,
            'ecommerce' => 14,
            'landing' => 3,
            'app' => 21,
            'seo' => 5,
            'marketing' => 7
        ];
        
        $projectId = $this->projectModel->createFromBrief($userId, [
            'project_type' => $projectType,
            'title' => $title,
            'brief' => $brief,
            'brief_data' => $briefData,
            'price' => $price,
            'estimated_days' => $estimatedDays[$projectType] ?? 7,
            'priority' => !empty($briefData['urgent']) ? 'high' : 'normal'
        ]);
        
        if ($projectId) {
            $_SESSION['success_message'] = 'Votre projet a été soumis avec succès ! Notre équipe va l\'examiner rapidement.';
            header('Location: /espace-client/projet/' . $projectId);
        } else {
            $_SESSION['error_message'] = 'Erreur lors de la création du projet.';
            header('Location: /projets/brief');
        }
        exit();
    }
    
    /**
     * Calcul de devis en AJAX
     */
    public function ajaxQuote() {
        header('Content-Type: application/json');
        
        $projectType = $_POST['project_type'] ?? $_GET['project_type'] ?? 'website';
        $briefData = [
            'pages' => (int)($_POST['pages'] ?? $_GET['pages'] ?? 5),
            'multilingual' => !empty($_POST['multilingual'] ?? $_GET['multilingual'] ?? false),
            'urgent' => !empty($_POST['urgent'] ?? $_GET['urgent'] ?? false)
        ];
        
        $price = Project::calculateQuote($projectType, $briefData);
        
        echo json_encode([
            'success' => true,
            'price' => $price,
            'formatted' => number_format($price, 2, ',', ' ') . ' €'
        ]);
        exit();
    }
    
    /**
     * Dashboard client (espace client)
     */
    public function dashboard() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = '/espace-client';
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        $projects = $this->projectModel->getClientProjects($userId);
        
        $messageModel = new ProjectMessage();
        $unreadMessages = $messageModel->countUnreadForClient($userId);
        
        // Statistiques client
        $activeProjects = array_filter($projects, function($p) {
            return !in_array($p['status'], ['completed', 'cancelled', 'draft']);
        });
        $completedProjects = array_filter($projects, function($p) {
            return $p['status'] === 'completed';
        });
        
        $data = [
            'title' => 'Espace Client — Digita Marketing',
            'projects' => $projects,
            'activeProjects' => $activeProjects,
            'completedProjects' => $completedProjects,
            'unreadMessages' => $unreadMessages,
            'statuses' => Project::$statuses,
            'types' => Project::$types
        ];
        
        ViewHelper::render('projects/client-dashboard-content', $data);
    }
    
    /**
     * Détail d'un projet client
     */
    public function show($projectId) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = '/espace-client/projet/' . $projectId;
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        
        if (!$this->projectModel->belongsToClient($projectId, $userId)) {
            $_SESSION['error_message'] = 'Projet introuvable.';
            header('Location: /espace-client');
            exit();
        }
        
        $project = $this->projectModel->getFullProject($projectId);
        
        if (!$project) {
            header('Location: /espace-client');
            exit();
        }
        
        // Marquer les messages admin comme lus
        $this->projectModel->markMessagesRead($projectId, false);
        
        $data = [
            'title' => $project['title'] . ' — Espace Client',
            'project' => $project,
            'statuses' => Project::$statuses,
            'types' => Project::$types
        ];
        
        ViewHelper::render('projects/client-project-content', $data);
    }
    
    /**
     * Envoyer un message (POST)
     */
    public function sendMessage($projectId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /connexion');
            exit();
        }
        
        $userId = $_SESSION['user_id'];
        
        if (!$this->projectModel->belongsToClient($projectId, $userId)) {
            $_SESSION['error_message'] = 'Projet introuvable.';
            header('Location: /espace-client');
            exit();
        }
        
        $message = trim($_POST['message'] ?? '');
        if (empty($message)) {
            $_SESSION['error_message'] = 'Le message ne peut pas être vide.';
            header('Location: /espace-client/projet/' . $projectId);
            exit();
        }
        
        // Upload de fichier joint si présent
        $attachment = null;
        if (!empty($_FILES['attachment']['name'])) {
            $attachment = $this->handleFileUpload($projectId, $userId);
        }
        
        $this->projectModel->addMessage($projectId, $userId, $message, false, $attachment);
        
        $_SESSION['success_message'] = 'Message envoyé.';
        header('Location: /espace-client/projet/' . $projectId . '#messages');
        exit();
    }
    
    /**
     * Upload de fichier projet
     */
    private function handleFileUpload($projectId, $userId) {
        $uploadDir = __DIR__ . '/../../public/uploads/projects/' . $projectId . '/';
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $file = $_FILES['attachment'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'txt'];
        
        if (!in_array($ext, $allowed)) {
            return null;
        }
        
        if ($file['size'] > 10 * 1024 * 1024) {
            return null;
        }
        
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file['name']);
        $filepath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $this->projectModel->addFile($projectId, $userId, [
                'filename' => $file['name'],
                'filepath' => '/uploads/projects/' . $projectId . '/' . $filename,
                'filetype' => $ext,
                'filesize' => $file['size']
            ]);
            return '/uploads/projects/' . $projectId . '/' . $filename;
        }
        
        return null;
    }
}
