<?php
// Environnement ('development' ou 'production')
define('ENVIRONMENT', 'development');

// Informations de la base de données
if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
if (!defined('DB_NAME')) define('DB_NAME', 'digita_marketing');
if (!defined('DB_USER')) define('DB_USER', 'root');
if (!defined('DB_PASS')) define('DB_PASS', '');

// Configuration du site
define('SITE_URL', '');

// Configuration du cache
define('CACHE_TIME', 3600); // 1 heure

// Configuration des logs
define('LOG_ERRORS', true);
define('ERROR_LOG_PATH', __DIR__ . '/../logs/error.log');
define('EXCEPTION_LOG_PATH', __DIR__ . '/../logs/exception.log');

// Activation de l'affichage des erreurs en développement
if (ENVIRONMENT === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Inclusion des fichiers essentiels
require_once __DIR__ . '/../includes/error_handler.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Cache.php';