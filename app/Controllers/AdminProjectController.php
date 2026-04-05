<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/Project.php';
require_once __DIR__ . '/../Models/ProjectMessage.php';
require_once __DIR__ . '/../Services/WeboxBridge.php';

/**
 * Contrôleur Admin Projets
 * Pipeline Kanban, gestion projets, validation, livraison
 */
class AdminProjectController extends Controller {
    
    private $projectModel;
    
    public function __construct() {
        $this->requireAdmin();
        $this->projectModel = new Project();
    }
    
    /**
     * Liste des projets / Pipeline Kanban
     */
    public function index() {
        $view = $_GET['view'] ?? 'kanban';
        $statusFilter = $_GET['status'] ?? null;
        $typeFilter = $_GET['type'] ?? null;
        
        if ($view === 'kanban') {
            $kanban = $this->projectModel->getProjectsByStatus();
        }
        
        $projects = $this->projectModel->getAllProjects($statusFilter, $typeFilter);
        $stats = $this->projectModel->getStats();
        
        $messageModel = new ProjectMessage();
        $unreadMessages = $messageModel->countUnreadForAdmin();
        
        $data = [
            'pageTitle' => 'Projets Clients',
            'projects' => $projects,
            'kanban' => $kanban ?? [],
            'stats' => $stats,
            'unreadMessages' => $unreadMessages,
            'statuses' => Project::$statuses,
            'types' => Project::$types,
            'currentView' => $view,
            'statusFilter' => $statusFilter,
            'typeFilter' => $typeFilter,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/projects/index', $data);
    }
    
    /**
     * Détail d'un projet (admin)
     */
    public function show($projectId) {
        $project = $this->projectModel->getFullProject($projectId);
        
        if (!$project) {
            $_SESSION['error_message'] = 'Projet introuvable.';
            header('Location: /admin/projects');
            exit();
        }
        
        // Marquer les messages client comme lus
        $this->projectModel->markMessagesRead($projectId, true);
        
        // Vérifier la connectivité Webox
        $weboxBridge = new WeboxBridge();
        $weboxConnected = false;
        try {
            $weboxConnected = $weboxBridge->healthCheck();
        } catch (Exception $e) {
            // Silencieux
        }
        
        $data = [
            'pageTitle' => 'Projet #' . $projectId . ' — ' . $project['title'],
            'project' => $project,
            'statuses' => Project::$statuses,
            'types' => Project::$types,
            'weboxConnected' => $weboxConnected,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/projects/show', $data);
    }
    
    /**
     * Mettre à jour le statut d'un projet (POST)
     */
    public function updateStatus($projectId) {
        $newStatus = $_POST['status'] ?? '';
        $note = trim($_POST['note'] ?? '');
        
        if (empty($newStatus) || !array_key_exists($newStatus, Project::$statuses)) {
            $_SESSION['error_message'] = 'Statut invalide.';
            header('Location: /admin/projects/' . $projectId);
            exit();
        }
        
        $adminId = $_SESSION['user_id'];
        $this->projectModel->updateStatus($projectId, $newStatus, $adminId, $note ?: null);
        
        $_SESSION['success_message'] = 'Statut mis à jour : ' . Project::$statuses[$newStatus];
        header('Location: /admin/projects/' . $projectId);
        exit();
    }
    
    /**
     * Envoyer un message admin (POST)
     */
    public function sendMessage($projectId) {
        $message = trim($_POST['message'] ?? '');
        
        if (empty($message)) {
            $_SESSION['error_message'] = 'Le message ne peut pas être vide.';
            header('Location: /admin/projects/' . $projectId);
            exit();
        }
        
        $adminId = $_SESSION['user_id'];
        $this->projectModel->addMessage($projectId, $adminId, $message, true);
        
        $_SESSION['success_message'] = 'Message envoyé au client.';
        header('Location: /admin/projects/' . $projectId . '#messages');
        exit();
    }
    
    /**
     * Ajouter une note admin au projet (POST)
     */
    public function addNote($projectId) {
        $note = trim($_POST['admin_notes'] ?? '');
        $this->projectModel->update($projectId, ['admin_notes' => $note]);
        
        $_SESSION['success_message'] = 'Notes mises à jour.';
        header('Location: /admin/projects/' . $projectId);
        exit();
    }
    
    /**
     * Lancer la génération Webox (POST)
     */
    public function generateWebox($projectId) {
        $project = $this->projectModel->getFullProject($projectId);
        
        if (!$project) {
            $_SESSION['error_message'] = 'Projet introuvable.';
            header('Location: /admin/projects');
            exit();
        }
        
        $briefData = json_decode($project['brief_data'] ?? '{}', true);
        $briefData['description'] = $project['brief'];
        $briefData['project_type'] = $project['project_type'];
        
        try {
            $weboxBridge = new WeboxBridge();
            $response = $weboxBridge->createWebsite($briefData);
            
            if (!empty($response['project_id'])) {
                $this->projectModel->linkWebox($projectId, $response['project_id'], $response['preview_url'] ?? null);
                $this->projectModel->updateStatus($projectId, 'generating', $_SESSION['user_id'], 'Génération lancée via Webox IA');
                
                $_SESSION['success_message'] = 'Génération lancée ! ID Webox : ' . $response['project_id'];
            } else {
                $_SESSION['error_message'] = 'Réponse Webox inattendue.';
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Erreur Webox : ' . $e->getMessage();
        }
        
        header('Location: /admin/projects/' . $projectId);
        exit();
    }
    
    /**
     * Ajouter une tâche au projet (POST)
     */
    public function addTask($projectId) {
        $title = trim($_POST['task_title'] ?? '');
        $description = trim($_POST['task_description'] ?? '');
        
        if (empty($title)) {
            $_SESSION['error_message'] = 'Le titre de la tâche est requis.';
            header('Location: /admin/projects/' . $projectId);
            exit();
        }
        
        $this->projectModel->addTask($projectId, $title, $description ?: null);
        
        $_SESSION['success_message'] = 'Tâche ajoutée.';
        header('Location: /admin/projects/' . $projectId . '#tasks');
        exit();
    }
    
    /**
     * Mettre à jour le statut d'une tâche (POST AJAX)
     */
    public function updateTask() {
        header('Content-Type: application/json');
        
        $taskId = $_POST['task_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        
        if (empty($taskId) || !in_array($status, ['todo', 'in_progress', 'done'])) {
            echo json_encode(['success' => false, 'error' => 'Paramètres invalides']);
            exit();
        }
        
        $this->projectModel->updateTaskStatus($taskId, $status);
        
        echo json_encode(['success' => true]);
        exit();
    }
    
    /**
     * Mettre à jour le prix (POST)
     */
    public function updatePrice($projectId) {
        $price = (float)($_POST['price'] ?? 0);
        $this->projectModel->update($projectId, ['price' => $price]);
        
        $_SESSION['success_message'] = 'Prix mis à jour : ' . number_format($price, 2) . ' €';
        header('Location: /admin/projects/' . $projectId);
        exit();
    }
    
    /**
     * Webhook Webox → Digita
     */
    public function webhookWebox() {
        $payload = json_decode(file_get_contents('php://input'), true);
        
        if (empty($payload)) {
            http_response_code(400);
            echo json_encode(['error' => 'Payload vide']);
            exit();
        }
        
        $weboxBridge = new WeboxBridge();
        $result = $weboxBridge->handleWebhook($payload);
        
        http_response_code($result ? 200 : 400);
        echo json_encode(['success' => $result]);
        exit();
    }
}
