<?php
/**
 * Script de nettoyage du cache
 * À exécuter quotidiennement via CRON: 0 2 * * *
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/Cache.php';

$cache = new Cache();
$cacheDir = __DIR__ . '/../../cache';

// Nettoyer les fichiers de cache expirés
$files = glob($cacheDir . '/*');
$now = time();
$cleaned = 0;

foreach ($files as $file) {
    if (is_file($file)) {
        // Supprimer les fichiers de plus de 24h
        if ($now - filemtime($file) >= 24 * 3600) {
            unlink($file);
            $cleaned++;
        }
    }
}

echo "✓ {$cleaned} fichiers de cache nettoyés\n";

// Nettoyer les sessions expirées
$sessionPath = session_save_path();
if ($sessionPath && is_dir($sessionPath)) {
    $sessionFiles = glob($sessionPath . '/sess_*');
    $sessionsCleaned = 0;
    
    foreach ($sessionFiles as $file) {
        if ($now - filemtime($file) >= 24 * 3600) {
            unlink($file);
            $sessionsCleaned++;
        }
    }
    
    echo "✓ {$sessionsCleaned} sessions expirées nettoyées\n";
}

// Nettoyer les logs de plus de 90 jours
$logsDir = __DIR__ . '/../../logs';
if (is_dir($logsDir)) {
    $logFiles = glob($logsDir . '/*.log');
    $logsCleaned = 0;
    
    foreach ($logFiles as $file) {
        if ($now - filemtime($file) >= 90 * 24 * 3600) {
            unlink($file);
            $logsCleaned++;
        }
    }
    
    echo "✓ {$logsCleaned} anciens logs supprimés\n";
}

echo "✓ Nettoyage terminé\n";
