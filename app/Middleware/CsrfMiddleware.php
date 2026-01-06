<?php

/**
 * Middleware de protection CSRF
 * Génère et valide les tokens CSRF pour les formulaires
 */
class CsrfMiddleware {
    
    private static $tokenName = '_csrf_token';
    private static $tokenLength = 32;
    
    /**
     * Générer un nouveau token CSRF
     */
    public static function generateToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $token = bin2hex(random_bytes(self::$tokenLength));
        $_SESSION[self::$tokenName] = $token;
        
        return $token;
    }
    
    /**
     * Récupérer le token actuel
     */
    public static function getToken() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION[self::$tokenName])) {
            return self::generateToken();
        }
        
        return $_SESSION[self::$tokenName];
    }
    
    /**
     * Valider le token CSRF
     */
    public static function validateToken($token) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION[self::$tokenName])) {
            return false;
        }
        
        return hash_equals($_SESSION[self::$tokenName], $token);
    }
    
    /**
     * Vérifier la requête POST/PUT/DELETE
     */
    public static function check() {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        
        // Vérifier uniquement pour les méthodes modifiant les données
        if (!in_array($method, ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            return true;
        }
        
        $token = $_POST[self::$tokenName] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
        
        if (!$token || !self::validateToken($token)) {
            http_response_code(403);
            die(json_encode([
                'error' => 'Token CSRF invalide ou manquant',
                'code' => 'CSRF_TOKEN_INVALID'
            ]));
        }
        
        return true;
    }
    
    /**
     * Générer le champ input hidden pour les formulaires
     */
    public static function field() {
        $token = self::getToken();
        return '<input type="hidden" name="' . self::$tokenName . '" value="' . htmlspecialchars($token) . '">';
    }
    
    /**
     * Générer le meta tag pour AJAX
     */
    public static function metaTag() {
        $token = self::getToken();
        return '<meta name="csrf-token" content="' . htmlspecialchars($token) . '">';
    }
}
