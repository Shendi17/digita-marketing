<?php

/**
 * Middleware de limitation de taux (Rate Limiting)
 * Protège contre les abus et attaques par force brute
 */
class RateLimitMiddleware {
    
    private static $limits = [
        'login' => ['max' => 5, 'window' => 900],      // 5 tentatives / 15 min
        'register' => ['max' => 3, 'window' => 3600],  // 3 inscriptions / 1h
        'contact' => ['max' => 10, 'window' => 3600],  // 10 messages / 1h
        'api' => ['max' => 100, 'window' => 60],       // 100 requêtes / 1 min
        'default' => ['max' => 60, 'window' => 60]     // 60 requêtes / 1 min
    ];
    
    /**
     * Vérifier la limite de taux
     */
    public static function check($action = 'default', $identifier = null) {
        if ($identifier === null) {
            $identifier = self::getIdentifier();
        }
        
        $limit = self::$limits[$action] ?? self::$limits['default'];
        $key = "rate_limit_{$action}_{$identifier}";
        
        // Récupérer les tentatives depuis la session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $now = time();
        $attempts = $_SESSION[$key] ?? [];
        
        // Nettoyer les anciennes tentatives
        $attempts = array_filter($attempts, function($timestamp) use ($now, $limit) {
            return ($now - $timestamp) < $limit['window'];
        });
        
        // Vérifier si la limite est dépassée
        if (count($attempts) >= $limit['max']) {
            $oldestAttempt = min($attempts);
            $retryAfter = $limit['window'] - ($now - $oldestAttempt);
            
            http_response_code(429);
            header('Retry-After: ' . $retryAfter);
            
            die(json_encode([
                'error' => 'Trop de tentatives. Veuillez réessayer plus tard.',
                'retry_after' => $retryAfter,
                'code' => 'RATE_LIMIT_EXCEEDED'
            ]));
        }
        
        // Ajouter la tentative actuelle
        $attempts[] = $now;
        $_SESSION[$key] = $attempts;
        
        return true;
    }
    
    /**
     * Réinitialiser le compteur pour un utilisateur
     */
    public static function reset($action = 'default', $identifier = null) {
        if ($identifier === null) {
            $identifier = self::getIdentifier();
        }
        
        $key = "rate_limit_{$action}_{$identifier}";
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        unset($_SESSION[$key]);
    }
    
    /**
     * Obtenir l'identifiant unique (IP + User Agent)
     */
    private static function getIdentifier() {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
        
        return md5($ip . $userAgent);
    }
    
    /**
     * Obtenir le nombre de tentatives restantes
     */
    public static function remaining($action = 'default', $identifier = null) {
        if ($identifier === null) {
            $identifier = self::getIdentifier();
        }
        
        $limit = self::$limits[$action] ?? self::$limits['default'];
        $key = "rate_limit_{$action}_{$identifier}";
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $now = time();
        $attempts = $_SESSION[$key] ?? [];
        
        // Nettoyer les anciennes tentatives
        $attempts = array_filter($attempts, function($timestamp) use ($now, $limit) {
            return ($now - $timestamp) < $limit['window'];
        });
        
        return max(0, $limit['max'] - count($attempts));
    }
    
    /**
     * Configurer une limite personnalisée
     */
    public static function setLimit($action, $max, $window) {
        self::$limits[$action] = ['max' => $max, 'window' => $window];
    }
}
