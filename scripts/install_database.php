<?php
/**
 * Script d'installation de la base de données
 * Exécute le fichier SQL create_blog_formations.sql
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/Database.php';

echo "🚀 Installation de la base de données...\n\n";

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    
    // Lire le fichier SQL
    $sqlFile = __DIR__ . '/../database/create_blog_formations.sql';
    
    if (!file_exists($sqlFile)) {
        die("❌ Erreur : Le fichier SQL n'existe pas : $sqlFile\n");
    }
    
    $sql = file_get_contents($sqlFile);
    
    echo "📄 Fichier SQL chargé : " . strlen($sql) . " caractères\n";
    echo "⏳ Exécution des requêtes...\n\n";
    
    // Exécuter tout le SQL en une fois
    $successCount = 0;
    $errorCount = 0;
    
    try {
        // Exécuter le SQL complet
        $pdo->exec($sql);
        echo "✅ Toutes les requêtes SQL ont été exécutées avec succès !\n";
        $successCount = 1;
    } catch (PDOException $e) {
        echo "❌ Erreur lors de l'exécution : " . $e->getMessage() . "\n";
        $errorCount = 1;
    }
    
    echo "\n";
    echo "========================================\n";
    echo "✅ Installation terminée !\n";
    echo "📊 Requêtes exécutées : {$successCount}\n";
    if ($errorCount > 0) {
        echo "⚠️  Avertissements : {$errorCount}\n";
    }
    echo "========================================\n\n";
    
    // Vérifier les tables créées
    echo "🔍 Vérification des tables...\n\n";
    
    $tables = [
        'service_categories',
        'blog_articles',
        'formations',
        'formation_modules',
        'formation_lessons',
        'formation_enrollments',
        'blog_comments',
        'tags',
        'article_tags'
    ];
    
    foreach ($tables as $table) {
        try {
            $result = $pdo->query("SELECT COUNT(*) as count FROM $table")->fetch();
            echo "✅ $table : {$result['count']} enregistrement(s)\n";
        } catch (PDOException $e) {
            echo "❌ $table : Table non trouvée\n";
        }
    }
    
    echo "\n✅ Base de données prête !\n";
    
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
    exit(1);
}
