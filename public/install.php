<?php
/**
 * Script d'installation pour exécuter les migrations SQL en production
 * À exécuter UNE SEULE FOIS après le premier déploiement
 * Accès: https://digita.tonyalpha80.com/install.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Installation Digita</title>";
echo "<style>body{font-family:Arial;padding:20px;background:#f5f5f5;max-width:1200px;margin:0 auto;}";
echo ".success{background:#d4edda;border:1px solid #c3e6cb;padding:15px;margin:10px 0;border-radius:5px;}";
echo ".error{background:#f8d7da;border:1px solid #f5c6cb;padding:15px;margin:10px 0;border-radius:5px;}";
echo ".info{background:#d1ecf1;border:1px solid #bee5eb;padding:15px;margin:10px 0;border-radius:5px;}";
echo ".warning{background:#fff3cd;border:1px solid #ffeaa7;padding:15px;margin:10px 0;border-radius:5px;}";
echo "pre{background:#fff;padding:10px;border:1px solid #ddd;overflow:auto;max-height:400px;}";
echo "h1{color:#333;} h2{color:#555;border-bottom:2px solid #007bff;padding-bottom:10px;}";
echo "</style></head><body>";

echo "<h1>🚀 Installation Digita Marketing</h1>";

// Charger la config
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/Database.php';

echo "<div class='info'><strong>ℹ️ Information:</strong> Ce script va exécuter toutes les migrations SQL nécessaires.</div>";

try {
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    
    echo "<div class='success'>✅ Connexion à la base de données réussie</div>";
    
    // Liste des fichiers de migration
    $migrationFiles = [
        'sprint2_migration.sql',
        'sprint3_migration.sql',
        'sprint4_migration.sql',
        'sprint5_migration.sql'
    ];
    
    $executed = 0;
    $skipped = 0;
    $errors = 0;
    
    echo "<h2>📋 Exécution des Migrations</h2>";
    
    foreach ($migrationFiles as $file) {
        $filepath = __DIR__ . '/../database/' . $file;
        
        echo "<div class='info'><strong>Migration:</strong> $file</div>";
        
        if (!file_exists($filepath)) {
            echo "<div class='warning'>⚠️ Fichier non trouvé: $file</div>";
            $skipped++;
            continue;
        }
        
        // Lire le fichier SQL
        $sql = file_get_contents($filepath);
        
        // Séparer les requêtes
        $queries = array_filter(
            array_map('trim', explode(';', $sql)),
            function($query) {
                return !empty($query) && strpos($query, '--') !== 0;
            }
        );
        
        echo "<pre>Nombre de requêtes: " . count($queries) . "</pre>";
        
        foreach ($queries as $query) {
            if (empty(trim($query))) continue;
            
            try {
                $pdo->exec($query);
                echo "<div style='color:green;font-size:12px;'>✓ Requête exécutée</div>";
                $executed++;
            } catch (PDOException $e) {
                // Ignorer les erreurs "table already exists" ou "duplicate column"
                if (strpos($e->getMessage(), 'already exists') !== false || 
                    strpos($e->getMessage(), 'Duplicate column') !== false) {
                    echo "<div style='color:orange;font-size:12px;'>⚠️ Déjà existant (ignoré)</div>";
                    $skipped++;
                } else {
                    echo "<div class='error'>❌ Erreur: " . $e->getMessage() . "</div>";
                    echo "<pre>" . htmlspecialchars(substr($query, 0, 200)) . "...</pre>";
                    $errors++;
                }
            }
        }
    }
    
    echo "<hr>";
    echo "<h2>📊 Résumé de l'Installation</h2>";
    echo "<div class='info'>";
    echo "<p><strong>Requêtes exécutées:</strong> $executed</p>";
    echo "<p><strong>Requêtes ignorées:</strong> $skipped</p>";
    echo "<p><strong>Erreurs:</strong> $errors</p>";
    echo "</div>";
    
    // Vérifier les tables créées
    echo "<h2>✅ Vérification des Tables</h2>";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "<div class='success'>";
    echo "<p><strong>Nombre de tables:</strong> " . count($tables) . "</p>";
    echo "<details><summary>Voir la liste des tables</summary><pre>";
    echo implode("\n", $tables);
    echo "</pre></details>";
    echo "</div>";
    
    // Vérifier les tables critiques
    $criticalTables = [
        'users', 'blog_articles', 'formations', 'modules', 'lessons',
        'lesson_completions', 'quizzes', 'certificates', 'orders',
        'invoices', 'client_projects', 'chatbot_conversations'
    ];
    
    echo "<h2>🔍 Tables Critiques</h2>";
    $allPresent = true;
    foreach ($criticalTables as $table) {
        if (in_array($table, $tables)) {
            echo "<div style='color:green;'>✅ $table</div>";
        } else {
            echo "<div style='color:red;'>❌ $table manquante</div>";
            $allPresent = false;
        }
    }
    
    if ($allPresent && $errors === 0) {
        echo "<hr>";
        echo "<div class='success'>";
        echo "<h2 style='color:#155724;margin:0;'>✅ Installation Terminée avec Succès !</h2>";
        echo "<p style='margin:15px 0;'>La base de données est maintenant prête.</p>";
        echo "<h3>Prochaines étapes:</h3>";
        echo "<ol>";
        echo "<li><strong>Supprimez ce fichier</strong> (install.php) pour des raisons de sécurité</li>";
        echo "<li>Testez le site: <a href='/'>Page d'accueil</a></li>";
        echo "<li>Accédez à l'admin: <a href='/admin/dashboard'>Dashboard Admin</a></li>";
        echo "<li>Supprimez aussi: setup.php, diagnostic.php, debug.php</li>";
        echo "</ol>";
        echo "</div>";
    } else {
        echo "<hr>";
        echo "<div class='warning'>";
        echo "<h2 style='color:#856404;'>⚠️ Installation Terminée avec Avertissements</h2>";
        echo "<p>Certaines tables sont manquantes ou des erreurs se sont produites.</p>";
        echo "<p>Vérifiez les logs ci-dessus et contactez le support si nécessaire.</p>";
        echo "</div>";
    }
    
} catch (Exception $e) {
    echo "<div class='error'>";
    echo "<h2>❌ Erreur Critique</h2>";
    echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Fichier:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Ligne:</strong> " . $e->getLine() . "</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><small>Script exécuté le " . date('Y-m-d H:i:s') . "</small></p>";
echo "</body></html>";
