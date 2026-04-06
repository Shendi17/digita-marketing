<?php
/**
 * Script de setup pour créer les dossiers manquants en production
 * À exécuter une seule fois après le premier déploiement
 * Accès: https://digita.tonyalpha80.com/setup.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 Setup Digita Marketing</h1>";
echo "<hr>";

$baseDir = __DIR__ . '/..';
$created = [];
$errors = [];

// Dossiers à créer
$directories = [
    'logs' => 0755,
    'cache' => 0755,
    'public/uploads' => 0755,
    'public/uploads/articles' => 0755,
    'public/uploads/formations' => 0755,
    'public/uploads/media' => 0755,
    'backups' => 0755,
    'backups/database' => 0755
];

echo "<h2>Création des dossiers manquants</h2>";

foreach ($directories as $dir => $permissions) {
    $path = $baseDir . '/' . $dir;
    
    if (!is_dir($path)) {
        if (mkdir($path, $permissions, true)) {
            $created[] = $dir;
            echo "✅ Créé: $dir (permissions: " . decoct($permissions) . ")<br>";
        } else {
            $errors[] = "Impossible de créer: $dir";
            echo "❌ Erreur: $dir<br>";
        }
    } else {
        echo "ℹ️ Existe déjà: $dir<br>";
    }
}

echo "<hr>";

// Créer les fichiers .gitkeep dans les dossiers vides
echo "<h2>Création des fichiers .gitkeep</h2>";

$gitkeepDirs = ['logs', 'cache', 'backups/database'];
foreach ($gitkeepDirs as $dir) {
    $path = $baseDir . '/' . $dir . '/.gitkeep';
    if (!file_exists($path)) {
        if (file_put_contents($path, '') !== false) {
            echo "✅ Créé: $dir/.gitkeep<br>";
        } else {
            echo "❌ Erreur: $dir/.gitkeep<br>";
        }
    }
}

echo "<hr>";

// Créer un fichier .htaccess pour protéger les logs
echo "<h2>Protection des dossiers sensibles</h2>";

$htaccessContent = "Order deny,allow\nDeny from all";
$protectedDirs = ['logs', 'cache', 'backups'];

foreach ($protectedDirs as $dir) {
    $path = $baseDir . '/' . $dir . '/.htaccess';
    if (!file_exists($path)) {
        if (file_put_contents($path, $htaccessContent) !== false) {
            echo "✅ Protégé: $dir/.htaccess<br>";
        } else {
            echo "❌ Erreur: $dir/.htaccess<br>";
        }
    }
}

echo "<hr>";

// Vérifier les permissions
echo "<h2>Vérification des permissions</h2>";

$checkDirs = array_merge(array_keys($directories), ['app', 'includes', 'config']);
foreach ($checkDirs as $dir) {
    $path = $baseDir . '/' . $dir;
    if (is_dir($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        $writable = is_writable($path) ? '✅' : '❌';
        echo "$writable $dir: $perms<br>";
    }
}

echo "<hr>";

// Résumé
echo "<h2>📊 Résumé</h2>";
echo "<p><strong>Dossiers créés:</strong> " . count($created) . "</p>";
if (count($created) > 0) {
    echo "<ul>";
    foreach ($created as $dir) {
        echo "<li>$dir</li>";
    }
    echo "</ul>";
}

if (count($errors) > 0) {
    echo "<p style='color:red;'><strong>Erreurs:</strong></p>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li style='color:red;'>$error</li>";
    }
    echo "</ul>";
}

echo "<hr>";

if (count($errors) === 0) {
    echo "<div style='background:#d4edda;border:1px solid #c3e6cb;padding:15px;border-radius:5px;'>";
    echo "<h3 style='color:#155724;margin:0;'>✅ Setup terminé avec succès !</h3>";
    echo "<p style='color:#155724;margin:10px 0 0 0;'>Vous pouvez maintenant:</p>";
    echo "<ol style='color:#155724;'>";
    echo "<li>Supprimer ce fichier (setup.php) pour des raisons de sécurité</li>";
    echo "<li>Tester le site: <a href='/'>Page d'accueil</a></li>";
    echo "<li>Accéder à l'admin: <a href='/admin/dashboard'>Dashboard Admin</a></li>";
    echo "</ol>";
    echo "</div>";
} else {
    echo "<div style='background:#f8d7da;border:1px solid #f5c6cb;padding:15px;border-radius:5px;'>";
    echo "<h3 style='color:#721c24;margin:0;'>⚠️ Setup terminé avec des erreurs</h3>";
    echo "<p style='color:#721c24;margin:10px 0 0 0;'>Vérifiez les permissions du serveur.</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><small>Script exécuté le " . date('Y-m-d H:i:s') . "</small></p>";
