<?php

/**
 * Gestionnaire de variables d'environnement
 * Charge et gère les variables depuis le fichier .env
 */
class Environment {
    
    private static $loaded = false;
    private static $vars = [];
    
    /**
     * Charger les variables d'environnement depuis .env
     */
    public static function load($path = null) {
        if (self::$loaded) {
            return;
        }
        
        if ($path === null) {
            $path = __DIR__ . '/../../.env';
        }
        
        if (!file_exists($path)) {
            throw new Exception("Fichier .env introuvable: {$path}");
        }
        
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            // Ignorer les commentaires
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            
            // Parser la ligne KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                // Retirer les guillemets si présents
                $value = trim($value, '"\'');
                
                // Stocker dans $_ENV, $_SERVER et notre tableau
                $_ENV[$key] = $value;
                $_SERVER[$key] = $value;
                self::$vars[$key] = $value;
                
                // Définir comme constante si pas déjà définie
                if (!defined($key)) {
                    define($key, $value);
                }
            }
        }
        
        self::$loaded = true;
    }
    
    /**
     * Récupérer une variable d'environnement
     */
    public static function get($key, $default = null) {
        if (isset(self::$vars[$key])) {
            return self::$vars[$key];
        }
        
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }
        
        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }
        
        return $default;
    }
    
    /**
     * Vérifier si une variable existe
     */
    public static function has($key) {
        return isset(self::$vars[$key]) || isset($_ENV[$key]) || isset($_SERVER[$key]);
    }
    
    /**
     * Définir une variable d'environnement
     */
    public static function set($key, $value) {
        self::$vars[$key] = $value;
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}
