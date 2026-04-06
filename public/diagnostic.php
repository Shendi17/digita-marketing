<?php
// Script de diagnostic pour identifier les problèmes en production
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Diagnostic Digita Marketing</h1>";
echo "<hr>";

// 1. Vérifier PHP
echo "<h2>1. Version PHP</h2>";
echo "Version: " . phpversion() . "<br>";
echo "SAPI: " . php_sapi_name() . "<br>";
echo "<hr>";

// 2. Vérifier les chemins
echo "<h2>2. Chemins</h2>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "__DIR__: " . __DIR__ . "<br>";
echo "__FILE__: " . __FILE__ . "<br>";
echo "<hr>";

// 3. Vérifier la structure des dossiers
echo "<h2>3. Structure des dossiers</h2>";
$dirs = ['../app', '../includes', '../config', '../database', '../logs', '../cache'];
foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (is_dir($path)) {
        echo "✅ $dir existe<br>";
        echo "   Permissions: " . substr(sprintf('%o', fileperms($path)), -4) . "<br>";
    } else {
        echo "❌ $dir n'existe pas<br>";
    }
}
echo "<hr>";

// 4. Vérifier le fichier .env
echo "<h2>4. Fichier .env</h2>";
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    echo "✅ .env existe<br>";
    echo "   Permissions: " . substr(sprintf('%o', fileperms($envPath)), -4) . "<br>";
    echo "   Taille: " . filesize($envPath) . " octets<br>";
    echo "   Lisible: " . (is_readable($envPath) ? 'Oui' : 'Non') . "<br>";
} else {
    echo "❌ .env n'existe pas à: $envPath<br>";
}
echo "<hr>";

// 5. Vérifier les fichiers critiques
echo "<h2>5. Fichiers critiques</h2>";
$files = [
    '../includes/Database.php',
    '../includes/Router.php',
    '../config/database.php',
    '../app/Controllers/AdminController.php'
];
foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        echo "✅ $file existe<br>";
    } else {
        echo "❌ $file n'existe pas<br>";
    }
}
echo "<hr>";

// 6. Tester le chargement de .env
echo "<h2>6. Test chargement .env</h2>";
if (file_exists($envPath)) {
    try {
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        echo "Nombre de lignes: " . count($lines) . "<br>";
        echo "Variables détectées:<br>";
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                if ($key) {
                    echo "  - $key: " . (strlen($value) > 0 ? '✅ défini' : '❌ vide') . "<br>";
                }
            }
        }
    } catch (Exception $e) {
        echo "❌ Erreur: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Impossible de tester, .env n'existe pas<br>";
}
echo "<hr>";

// 7. Tester la connexion BDD
echo "<h2>7. Test connexion base de données</h2>";
if (file_exists($envPath)) {
    $env = [];
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $env[trim($key)] = trim($value);
        }
    }
    
    if (isset($env['DB_HOST']) && isset($env['DB_NAME']) && isset($env['DB_USER'])) {
        echo "Configuration BDD trouvée:<br>";
        echo "  Host: " . $env['DB_HOST'] . "<br>";
        echo "  Database: " . $env['DB_NAME'] . "<br>";
        echo "  User: " . $env['DB_USER'] . "<br>";
        
        try {
            $dsn = "mysql:host={$env['DB_HOST']};dbname={$env['DB_NAME']};charset=utf8mb4";
            $pdo = new PDO($dsn, $env['DB_USER'], $env['DB_PASS'] ?? '');
            echo "✅ Connexion BDD réussie<br>";
            
            // Tester une requête
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "✅ Table users accessible (" . $result['count'] . " utilisateurs)<br>";
        } catch (PDOException $e) {
            echo "❌ Erreur connexion BDD: " . $e->getMessage() . "<br>";
        }
    } else {
        echo "❌ Configuration BDD incomplète dans .env<br>";
    }
} else {
    echo "❌ Impossible de tester, .env n'existe pas<br>";
}
echo "<hr>";

// 8. Vérifier les logs
echo "<h2>8. Logs d'erreurs</h2>";
$logFiles = [
    '../logs/error.log',
    '../logs/exception.log',
    '../logs/php_errors.log'
];
foreach ($logFiles as $logFile) {
    $path = __DIR__ . '/' . $logFile;
    if (file_exists($path)) {
        $size = filesize($path);
        echo "📄 $logFile: $size octets<br>";
        if ($size > 0 && $size < 10000) {
            echo "<pre style='background:#f5f5f5;padding:10px;max-height:200px;overflow:auto;'>";
            echo htmlspecialchars(file_get_contents($path));
            echo "</pre>";
        } elseif ($size >= 10000) {
            echo "<pre style='background:#f5f5f5;padding:10px;max-height:200px;overflow:auto;'>";
            echo htmlspecialchars(substr(file_get_contents($path), -5000));
            echo "</pre>";
        }
    } else {
        echo "❌ $logFile n'existe pas<br>";
    }
}
echo "<hr>";

// 9. Extensions PHP
echo "<h2>9. Extensions PHP requises</h2>";
$requiredExtensions = ['pdo', 'pdo_mysql', 'mbstring', 'json', 'curl'];
foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext<br>";
    } else {
        echo "❌ $ext manquante<br>";
    }
}
echo "<hr>";

echo "<h2>✅ Diagnostic terminé</h2>";
echo "<p>Accédez à ce fichier via: https://digita.tonyalpha80.com/diagnostic.php</p>";
