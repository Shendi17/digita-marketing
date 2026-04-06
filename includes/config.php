<?php
/**
 * Fichier de configuration principal
 * Charge les variables d'environnement depuis .env
 */

// Charger les variables d'environnement
$envFile = __DIR__ . '/../.env';

if (!file_exists($envFile)) {
    die('Erreur: Fichier .env manquant. Veuillez créer le fichier .env à la racine du projet.');
}

// Lire le fichier .env
$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($lines as $line) {
    // Ignorer les commentaires
    if (strpos(trim($line), '#') === 0) {
        continue;
    }
    
    // Parser les variables
    if (strpos($line, '=') !== false) {
        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);
        
        // Définir comme constante si pas déjà définie
        if (!defined($key)) {
            define($key, $value);
        }
        
        // Aussi définir dans $_ENV pour compatibilité
        $_ENV[$key] = $value;
    }
}

// Vérifier les constantes critiques
$requiredConstants = ['APP_ENV', 'DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
foreach ($requiredConstants as $const) {
    if (!defined($const)) {
        die("Erreur: La constante $const n'est pas définie dans le fichier .env");
    }
}

// Définir des constantes supplémentaires
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', APP_ENV);
}

// Configuration des chemins
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');
define('LOGS_PATH', ROOT_PATH . '/logs');
define('CACHE_PATH', ROOT_PATH . '/cache');

// Configuration de la timezone
date_default_timezone_set('Indian/Reunion');

// Configuration des sessions
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    if (defined('SESSION_SECURE') && SESSION_SECURE === 'true') {
        ini_set('session.cookie_secure', 1);
    }
    session_start();
}
