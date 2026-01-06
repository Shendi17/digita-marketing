<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';
require_once __DIR__ . '/../Middleware/RateLimitMiddleware.php';

/**
 * Contrôleur d'authentification
 * Gère la connexion, inscription et déconnexion
 */
class AuthController extends Controller {
    
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    /**
     * Afficher le formulaire de connexion
     */
    public function showLogin() {
        if ($this->isAuthenticated()) {
            $this->redirect('/admin/dashboard');
        }
        
        $this->view('auth/login', [
            'pageTitle' => 'Connexion - Digita Marketing',
            'error' => $_SESSION['login_error'] ?? null
        ]);
        
        unset($_SESSION['login_error']);
    }
    
    /**
     * Traiter la connexion
     */
    public function login() {
        // Vérifier CSRF
        CsrfMiddleware::check();
        
        // Vérifier rate limiting
        RateLimitMiddleware::check('login');
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = 'Tous les champs sont obligatoires.';
            $this->redirect('/connexion');
        }
        
        // Récupérer l'utilisateur
        require_once __DIR__ . '/../../includes/Database.php';
        $db = Database::getInstance();
        $user = $db->fetch('SELECT * FROM users WHERE email = ?', [$email]);
        
        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'] ?? 'user';
            
            // Réinitialiser le rate limit
            RateLimitMiddleware::reset('login');
            
            $this->redirect('/admin/dashboard');
        } else {
            $_SESSION['login_error'] = 'Identifiants incorrects.';
            $this->redirect('/connexion');
        }
    }
    
    /**
     * Afficher le formulaire d'inscription
     */
    public function showRegister() {
        if ($this->isAuthenticated()) {
            $this->redirect('/admin/dashboard');
        }
        
        $this->view('auth/register', [
            'pageTitle' => 'Inscription - Digita Marketing',
            'error' => $_SESSION['register_error'] ?? null
        ]);
        
        unset($_SESSION['register_error']);
    }
    
    /**
     * Traiter l'inscription
     */
    public function register() {
        // Vérifier CSRF
        CsrfMiddleware::check();
        
        // Vérifier rate limiting
        RateLimitMiddleware::check('register');
        
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        
        // Validation
        if (empty($email) || empty($password) || empty($password2)) {
            $_SESSION['register_error'] = 'Tous les champs sont obligatoires.';
            $this->redirect('/inscription');
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_error'] = 'Adresse email invalide.';
            $this->redirect('/inscription');
        }
        
        if ($password !== $password2) {
            $_SESSION['register_error'] = 'Les mots de passe ne correspondent pas.';
            $this->redirect('/inscription');
        }
        
        if (strlen($password) < 8) {
            $_SESSION['register_error'] = 'Le mot de passe doit contenir au moins 8 caractères.';
            $this->redirect('/inscription');
        }
        
        // Vérifier si l'email existe déjà
        require_once __DIR__ . '/../../includes/Database.php';
        $db = Database::getInstance();
        $existingUser = $db->fetch('SELECT * FROM users WHERE email = ?', [$email]);
        
        if ($existingUser) {
            $_SESSION['register_error'] = 'Cet email est déjà utilisé.';
            $this->redirect('/inscription');
        }
        
        // Créer l'utilisateur
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $db->query('INSERT INTO users (email, password, role) VALUES (?, ?, ?)', [$email, $hash, 'user']);
        
        // Connexion automatique
        $user = $db->fetch('SELECT * FROM users WHERE email = ?', [$email]);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        
        $this->redirect('/admin/dashboard');
    }
    
    /**
     * Déconnexion
     */
    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('/');
    }
    
    /**
     * Vérifier si l'utilisateur est authentifié
     */
    private function isAuthenticated() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }
}
