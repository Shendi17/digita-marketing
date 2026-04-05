<?php
/**
 * Script CRON : Traitement des séquences email automatiques
 * À exécuter quotidiennement via cron :
 * 0 9 * * * php /path/to/scripts/cron/process-email-sequences.php
 */

// Empêcher l'exécution via navigateur
if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('Accès interdit');
}

require_once __DIR__ . '/../../app/Services/EmailService.php';

echo "[" . date('Y-m-d H:i:s') . "] Début du traitement des séquences email...\n";

try {
    $emailService = new EmailService();
    $emailService->processEmailSequences();
    echo "[" . date('Y-m-d H:i:s') . "] Séquences email traitées avec succès.\n";
} catch (Exception $e) {
    echo "[" . date('Y-m-d H:i:s') . "] ERREUR : " . $e->getMessage() . "\n";
    error_log('Cron email sequences error: ' . $e->getMessage());
}

echo "[" . date('Y-m-d H:i:s') . "] Fin du traitement.\n";
