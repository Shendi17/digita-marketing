<?php

/**
 * Configuration de l'application
 * Constantes et paramètres globaux
 */
class AppConfig {
    
    // Informations de l'application
    const APP_NAME = 'Digita Marketing';
    const APP_VERSION = '2.1.0';
    const APP_DESCRIPTION = 'Agence de marketing digital';
    
    // Pagination
    const ITEMS_PER_PAGE = 20;
    const ADMIN_ITEMS_PER_PAGE = 50;
    
    // Upload de fichiers
    const MAX_UPLOAD_SIZE = 5242880; // 5 MB
    const ALLOWED_IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    const ALLOWED_DOCUMENT_TYPES = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    
    // Sécurité
    const PASSWORD_MIN_LENGTH = 8;
    const SESSION_LIFETIME = 3600; // 1 heure
    const MAX_LOGIN_ATTEMPTS = 5;
    const LOGIN_LOCKOUT_TIME = 900; // 15 minutes
    
    // Email
    const ADMIN_EMAIL = 'admin@digita-marketing.com';
    const NOREPLY_EMAIL = 'noreply@digita-marketing.com';
    const SUPPORT_EMAIL = 'support@digita-marketing.com';
    
    // Réseaux sociaux
    const SOCIAL_FACEBOOK = 'https://facebook.com/digitamarketing';
    const SOCIAL_TWITTER = 'https://twitter.com/digitamarketing';
    const SOCIAL_LINKEDIN = 'https://linkedin.com/company/digitamarketing';
    const SOCIAL_INSTAGRAM = 'https://instagram.com/digitamarketing';
    
    // API
    const API_VERSION = 'v1';
    const API_RATE_LIMIT = 100; // Requêtes par heure
    
    // Cache
    const CACHE_ENABLED = true;
    const CACHE_LIFETIME = 3600; // 1 heure
    
    // Logs
    const LOG_LEVEL = 'debug'; // debug, info, warning, error
    const LOG_MAX_FILES = 30; // Nombre de jours de logs à conserver
    
    // Formats de date
    const DATE_FORMAT = 'd/m/Y';
    const DATETIME_FORMAT = 'd/m/Y H:i';
    const TIME_FORMAT = 'H:i';
    
    // Langues disponibles
    const AVAILABLE_LANGUAGES = ['fr', 'en'];
    const DEFAULT_LANGUAGE = 'fr';
    
    // Timezone
    const TIMEZONE = 'Europe/Paris';
    
    // Maintenance
    const MAINTENANCE_MODE = false;
    const MAINTENANCE_MESSAGE = 'Site en maintenance. Nous revenons bientôt !';
    
    /**
     * Obtenir toutes les configurations sous forme de tableau
     */
    public static function getAll() {
        $reflection = new ReflectionClass(__CLASS__);
        return $reflection->getConstants();
    }
    
    /**
     * Obtenir une configuration spécifique
     */
    public static function get($key, $default = null) {
        return defined("self::$key") ? constant("self::$key") : $default;
    }
    
    /**
     * Vérifier si une configuration existe
     */
    public static function has($key) {
        return defined("self::$key");
    }
}
