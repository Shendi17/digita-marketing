<?php
/**
 * Script de debug avancé pour identifier l'erreur exacte
 * Accès: https://digita.tonyalpha80.com/debug.php
 */

// Activer TOUS les messages d'erreur
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Debug Digita</title>";
echo "<style>body{font-family:Arial;padding:20px;background:#f5f5f5;}";
echo ".success{background:#d4edda;border:1px solid #c3e6cb;padding:10px;margin:10px 0;border-radius:5px;}";
echo ".error{background:#f8d7da;border:1px solid #f5c6cb;padding:10px;margin:10px 0;border-radius:5px;}";
echo ".info{background:#d1ecf1;border:1px solid #bee5eb;padding:10px;margin:10px 0;border-radius:5px;}";
echo "pre{background:#fff;padding:10px;border:1px solid #ddd;overflow:auto;max-height:300px;}";
echo "</style></head><body>";

echo "<h1>🔍 Debug Avancé - Digita Marketing</h1>";

// Test 1: Charger le fichier de config
echo "<div class='info'><h2>1. Test chargement includes/config.php</h2>";
try {
    $configPath = __DIR__ . '/../includes/config.php';
    if (file_exists($configPath)) {
        echo "✅ Fichier config.php trouvé<br>";
        require_once $configPath;
        echo "✅ Config chargé sans erreur<br>";
    } else {
        echo "❌ Fichier config.php non trouvé à: $configPath<br>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Erreur: " . $e->getMessage() . "</div>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
echo "</div>";

// Test 2: Vérifier les constantes
echo "<div class='info'><h2>2. Constantes définies</h2>";
$constants = ['APP_ENV', 'APP_DEBUG', 'APP_URL', 'DB_HOST', 'DB_NAME', 'DB_USER'];
foreach ($constants as $const) {
    if (defined($const)) {
        $value = constant($const);
        // Masquer les mots de passe
        if (strpos($const, 'PASS') !== false || strpos($const, 'KEY') !== false) {
            $value = '***MASQUÉ***';
        }
        echo "✅ $const = $value<br>";
    } else {
        echo "❌ $const non défini<br>";
    }
}
echo "</div>";

// Test 3: Connexion BDD
echo "<div class='info'><h2>3. Test connexion base de données</h2>";
try {
    if (defined('DB_HOST') && defined('DB_NAME') && defined('DB_USER') && defined('DB_PASS')) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "✅ Connexion BDD réussie<br>";
        
        // Test requête
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "✅ Table users: " . $result['count'] . " utilisateurs<br>";
    } else {
        echo "❌ Constantes BDD non définies<br>";
    }
} catch (PDOException $e) {
    echo "<div class='error'>❌ Erreur BDD: " . $e->getMessage() . "</div>";
}
echo "</div>";

// Test 4: Charger Database.php
echo "<div class='info'><h2>4. Test classe Database</h2>";
try {
    $dbPath = __DIR__ . '/../includes/Database.php';
    if (file_exists($dbPath)) {
        echo "✅ Fichier Database.php trouvé<br>";
        require_once $dbPath;
        echo "✅ Database.php chargé<br>";
        
        $db = Database::getInstance();
        echo "✅ Instance Database créée<br>";
        
        $conn = $db->getConnection();
        echo "✅ Connexion obtenue<br>";
    } else {
        echo "❌ Database.php non trouvé<br>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Erreur Database: " . $e->getMessage() . "</div>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
echo "</div>";

// Test 5: Simuler le chargement d'une page admin
echo "<div class='info'><h2>5. Test simulation page admin</h2>";
try {
    // Simuler une session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    echo "✅ Session démarrée<br>";
    
    // Charger le contrôleur admin
    $adminControllerPath = __DIR__ . '/../app/Controllers/AdminController.php';
    if (file_exists($adminControllerPath)) {
        echo "✅ AdminController.php trouvé<br>";
        require_once $adminControllerPath;
        echo "✅ AdminController chargé<br>";
    } else {
        echo "❌ AdminController.php non trouvé<br>";
    }
} catch (Exception $e) {
    echo "<div class='error'>❌ Erreur AdminController: " . $e->getMessage() . "</div>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
echo "</div>";

// Test 6: Vérifier les dossiers logs
echo "<div class='info'><h2>6. Vérification dossiers logs</h2>";
$logsPath = __DIR__ . '/../logs';
if (is_dir($logsPath)) {
    echo "✅ Dossier logs existe<br>";
    echo "Permissions: " . substr(sprintf('%o', fileperms($logsPath)), -4) . "<br>";
    echo "Writable: " . (is_writable($logsPath) ? 'Oui' : 'Non') . "<br>";
    
    // Lister les fichiers de log
    $logFiles = glob($logsPath . '/*.log');
    if (count($logFiles) > 0) {
        echo "<h3>Fichiers de log:</h3>";
        foreach ($logFiles as $logFile) {
            $size = filesize($logFile);
            $name = basename($logFile);
            echo "📄 $name ($size octets)<br>";
            
            if ($size > 0 && $size < 50000) {
                echo "<h4>Contenu de $name (dernières lignes):</h4>";
                $lines = file($logFile);
                $lastLines = array_slice($lines, -20);
                echo "<pre>" . htmlspecialchars(implode('', $lastLines)) . "</pre>";
            }
        }
    } else {
        echo "ℹ️ Aucun fichier de log<br>";
    }
} else {
    echo "❌ Dossier logs n'existe pas<br>";
}
echo "</div>";

// Test 7: Tester l'error handler
echo "<div class='info'><h2>7. Test gestionnaire d'erreurs</h2>";
$errorHandlerPath = __DIR__ . '/../includes/error_handler.php';
if (file_exists($errorHandlerPath)) {
    echo "✅ error_handler.php existe<br>";
    echo "Contenu:<br>";
    echo "<pre>" . htmlspecialchars(file_get_contents($errorHandlerPath)) . "</pre>";
} else {
    echo "❌ error_handler.php non trouvé<br>";
}
echo "</div>";

// Test 8: Afficher phpinfo
echo "<div class='info'><h2>8. Configuration PHP</h2>";
echo "Version: " . phpversion() . "<br>";
echo "Extensions chargées:<br>";
$extensions = get_loaded_extensions();
sort($extensions);
echo "<pre>" . implode(', ', $extensions) . "</pre>";
echo "</div>";

echo "<hr>";
echo "<div class='success'><h2>✅ Debug terminé</h2>";
echo "<p>Si vous voyez ce message, PHP fonctionne correctement.</p>";
echo "<p>L'erreur vient probablement d'un problème de chargement de fichier ou de configuration.</p>";
echo "</div>";

echo "</body></html>";
