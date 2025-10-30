<?php

/**
 * Middleware d'authentification
 * Vérifie que l'utilisateur est connecté
 */
class AuthMiddleware {
    
    /**
     * Vérifier l'authentification
     */
    public static function check() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user_id'])) {
            self::redirectToLogin();
        }
        
        return true;
    }
    
    /**
     * Vérifier le rôle admin
     */
    public static function checkAdmin() {
        self::check();
        
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            self::forbidden();
        }
        
        return true;
    }
    
    /**
     * Vérifier si l'utilisateur est connecté (sans redirection)
     */
    public static function isAuthenticated() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Vérifier si l'utilisateur est admin (sans redirection)
     */
    public static function isAdmin() {
        return self::isAuthenticated() && 
               isset($_SESSION['user_role']) && 
               $_SESSION['user_role'] === 'admin';
    }
    
    /**
     * Obtenir l'ID de l'utilisateur connecté
     */
    public static function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }
    
    /**
     * Obtenir le rôle de l'utilisateur connecté
     */
    public static function getUserRole() {
        return $_SESSION['user_role'] ?? null;
    }
    
    /**
     * Rediriger vers la page de connexion
     */
    private static function redirectToLogin() {
        $siteUrl = defined('SITE_URL') ? SITE_URL : '';
        header('Location: ' . $siteUrl . '/connexion');
        exit();
    }
    
    /**
     * Afficher une erreur 403 Forbidden
     */
    private static function forbidden() {
        http_response_code(403);
        echo '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Accès refusé</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                }
                .error-container {
                    text-align: center;
                }
                h1 { font-size: 5rem; margin: 0; }
                p { font-size: 1.5rem; }
                a {
                    color: white;
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class="error-container">
                <h1>403</h1>
                <p>Accès refusé</p>
                <p>Vous n\'avez pas les permissions nécessaires.</p>
                <a href="' . (defined('SITE_URL') ? SITE_URL : '') . '">Retour à l\'accueil</a>
            </div>
        </body>
        </html>';
        exit();
    }
}
