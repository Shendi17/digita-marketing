<?php
/**
 * Script de backup automatique de la base de données
 * À exécuter quotidiennement via CRON: 0 3 * * *
 */

require_once __DIR__ . '/../../config/config.php';

$backupDir = __DIR__ . '/../../backups/database';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

$date = date('Y-m-d_H-i-s');
$backupFile = $backupDir . '/backup_' . $date . '.sql';

// Détection automatique de mysqldump
$mysqldumpPaths = [
    'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe',
    'C:\\xampp\\mysql\\bin\\mysqldump.exe',
    'C:\\laragon\\bin\\mysql\\mysql-8.0.30\\bin\\mysqldump.exe',
    'mysqldump' // Fallback si dans PATH
];

$mysqldump = null;
foreach ($mysqldumpPaths as $path) {
    if (file_exists($path) || $path === 'mysqldump') {
        $mysqldump = $path;
        break;
    }
}

if (!$mysqldump) {
    die("✗ mysqldump non trouvé\n");
}

// Commande mysqldump
$passwordArg = DB_PASS ? '--password=' . DB_PASS : '';
$command = sprintf(
    '"%s" --user=%s %s --host=%s %s > "%s"',
    $mysqldump,
    DB_USER,
    $passwordArg,
    DB_HOST,
    DB_NAME,
    $backupFile
);

exec($command, $output, $returnVar);

if ($returnVar === 0) {
    echo "✓ Backup créé: {$backupFile}\n";
    
    // Compresser le backup
    exec("gzip {$backupFile}");
    echo "✓ Backup compressé: {$backupFile}.gz\n";
    
    // Supprimer les backups de plus de 30 jours
    $files = glob($backupDir . '/backup_*.sql.gz');
    $now = time();
    
    foreach ($files as $file) {
        if ($now - filemtime($file) >= 30 * 24 * 3600) {
            unlink($file);
            echo "✓ Ancien backup supprimé: " . basename($file) . "\n";
        }
    }
    
    // Optionnel: Upload vers cloud (AWS S3, Backblaze, etc.)
    // uploadToCloud($backupFile . '.gz');
    
} else {
    echo "✗ Erreur lors du backup\n";
    error_log("Erreur backup database: " . implode("\n", $output));
}
