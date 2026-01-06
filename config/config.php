<?php
// Charger les variables d'environnement
require_once __DIR__ . '/../app/Config/Environment.php';
Environment::load(__DIR__ . '/../.env');

// Environnement ('development' ou 'production')
if (!defined('ENVIRONMENT')) define('ENVIRONMENT', Environment::get('APP_ENV', 'development'));
if (!defined('APP_DEBUG')) define('APP_DEBUG', Environment::get('APP_DEBUG', 'true') === 'true');
if (!defined('APP_URL')) define('APP_URL', Environment::get('APP_URL', 'http://localhost'));

// Informations de la base de données
if (!defined('DB_HOST')) define('DB_HOST', Environment::get('DB_HOST', 'localhost'));
if (!defined('DB_NAME')) define('DB_NAME', Environment::get('DB_NAME', 'digita_marketing'));
if (!defined('DB_USER')) define('DB_USER', Environment::get('DB_USER', 'root'));
if (!defined('DB_PASS')) define('DB_PASS', Environment::get('DB_PASS', ''));

// Configuration du site
if (!defined('SITE_URL')) define('SITE_URL', Environment::get('APP_URL', ''));

// Configuration email
if (!defined('MAIL_HOST')) define('MAIL_HOST', Environment::get('MAIL_HOST', 'smtp.gmail.com'));
if (!defined('MAIL_PORT')) define('MAIL_PORT', Environment::get('MAIL_PORT', '587'));
if (!defined('MAIL_USERNAME')) define('MAIL_USERNAME', Environment::get('MAIL_USERNAME', ''));
if (!defined('MAIL_PASSWORD')) define('MAIL_PASSWORD', Environment::get('MAIL_PASSWORD', ''));
if (!defined('ADMIN_EMAIL')) define('ADMIN_EMAIL', Environment::get('ADMIN_EMAIL', 'admin@digita.fr'));

// Configuration du cache
define('CACHE_TIME', 3600); // 1 heure

// Configuration des logs
define('LOG_ERRORS', true);
define('ERROR_LOG_PATH', __DIR__ . '/../logs/error.log');
define('EXCEPTION_LOG_PATH', __DIR__ . '/../logs/exception.log');

// Activation de l'affichage des erreurs en développement
if (ENVIRONMENT === 'development' && APP_DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
}

// Inclusion des fichiers essentiels
require_once __DIR__ . '/../includes/error_handler.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Cache.php';