<?php

/**
 * Classe de base pour tous les contrôleurs
 */
class Controller {
    
    /**
     * Charger une vue
     */
    protected function view($viewPath, $data = []) {
        // Extraire les données pour les rendre disponibles dans la vue
        extract($data);
        
        // Construire le chemin complet de la vue
        $viewFile = __DIR__ . '/../Views/' . $viewPath . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            throw new Exception("Vue non trouvée : {$viewPath}");
        }
    }
    
    /**
     * Charger une vue avec un layout
     */
    protected function viewWithLayout($viewPath, $data = [], $layout = 'layouts/admin') {
        $data['contentView'] = $viewPath;
        $this->view($layout, $data);
    }
    
    /**
     * Rediriger vers une URL
     */
    protected function redirect($url) {
        header("Location: " . $url);
        exit();
    }
    
    /**
     * Retourner une réponse JSON
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    /**
     * Vérifier si l'utilisateur est connecté
     */
    protected function requireAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(SITE_URL . '/connexion');
        }
    }
    
    /**
     * Vérifier si l'utilisateur est admin
     */
    protected function requireAdmin() {
        $this->requireAuth();
        
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $this->redirect(SITE_URL . '/');
        }
    }
    
    /**
     * Récupérer l'utilisateur connecté
     */
    protected function getCurrentUser() {
        if (isset($_SESSION['user_id'])) {
            require_once __DIR__ . '/../Models/User.php';
            $userModel = new User();
            return $userModel->find($_SESSION['user_id']);
        }
        return null;
    }
}
