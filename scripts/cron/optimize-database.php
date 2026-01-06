<?php
/**
 * Script d'optimisation de la base de données
 * À exécuter hebdomadairement via CRON: 0 3 * * 0
 */

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/Database.php';

$db = Database::getInstance();

echo "Début de l'optimisation de la base de données...\n\n";

// Récupérer toutes les tables
$tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

foreach ($tables as $table) {
    echo "Optimisation de {$table}... ";
    
    // Analyser la table
    $db->query("ANALYZE TABLE {$table}");
    
    // Optimiser la table
    $result = $db->query("OPTIMIZE TABLE {$table}")->fetch();
    
    if ($result['Msg_type'] === 'status' && $result['Msg_text'] === 'OK') {
        echo "✓\n";
    } else {
        echo "✗ ({$result['Msg_text']})\n";
    }
}

echo "\n✓ Optimisation terminée\n";

// Statistiques
$stats = $db->fetch("
    SELECT 
        COUNT(*) as total_tables,
        SUM(data_length + index_length) / 1024 / 1024 as total_size_mb
    FROM information_schema.TABLES
    WHERE table_schema = ?
", [DB_NAME]);

echo "\nStatistiques:\n";
echo "- Tables: {$stats['total_tables']}\n";
echo "- Taille totale: " . round($stats['total_size_mb'], 2) . " MB\n";
