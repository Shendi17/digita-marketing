#!/usr/bin/env php
<?php
/**
 * Script de test système DIGITA Marketing
 * Vérifie que tous les composants fonctionnent correctement
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   DIGITA MARKETING - Tests Système                        ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

$rootDir = realpath(__DIR__ . '/../..');
chdir($rootDir);

$errors = 0;
$warnings = 0;
$success = 0;

// ============================================
// TEST 1: Environnement
// ============================================
echo "🔍 TEST 1/8: Environnement PHP\n";
echo str_repeat("-", 60) . "\n";

if (version_compare(phpversion(), '8.2.0', '>=')) {
    echo "✓ PHP " . phpversion() . "\n";
    $success++;
} else {
    echo "✗ PHP version insuffisante: " . phpversion() . "\n";
    $errors++;
}

$extensions = ['pdo', 'pdo_mysql', 'mysqli', 'curl', 'mbstring', 'json', 'gd'];
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✓ Extension {$ext}\n";
        $success++;
    } else {
        echo "✗ Extension manquante: {$ext}\n";
        $errors++;
    }
}

echo "\n";

// ============================================
// TEST 2: Fichiers de configuration
// ============================================
echo "⚙️  TEST 2/8: Configuration\n";
echo str_repeat("-", 60) . "\n";

if (file_exists('.env')) {
    echo "✓ Fichier .env existe\n";
    $success++;
    
    require_once 'app/Config/Environment.php';
    try {
        Environment::load('.env');
        echo "✓ Variables .env chargées\n";
        $success++;
    } catch (Exception $e) {
        echo "✗ Erreur chargement .env: " . $e->getMessage() . "\n";
        $errors++;
    }
} else {
    echo "✗ Fichier .env manquant\n";
    $errors++;
}

if (file_exists('config/config.php')) {
    echo "✓ config/config.php existe\n";
    $success++;
} else {
    echo "✗ config/config.php manquant\n";
    $errors++;
}

echo "\n";

// ============================================
// TEST 3: Base de données
// ============================================
echo "🗄️  TEST 3/8: Connexion Base de Données\n";
echo str_repeat("-", 60) . "\n";

try {
    $dbHost = Environment::get('DB_HOST', 'localhost');
    $dbName = Environment::get('DB_NAME', 'digita_marketing');
    $dbUser = Environment::get('DB_USER', 'root');
    $dbPass = Environment::get('DB_PASS', '');
    
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Connexion MySQL réussie\n";
    echo "✓ Base de données: {$dbName}\n";
    $success += 2;
    
    // Vérifier les tables principales
    $tables = ['users', 'contact_messages', 'newsletter_subscribers', 'formations', 'blog_articles', 'orders'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '{$table}'");
        if ($stmt->rowCount() > 0) {
            echo "✓ Table {$table} existe\n";
            $success++;
        } else {
            echo "⚠ Table {$table} manquante\n";
            $warnings++;
        }
    }
    
} catch (PDOException $e) {
    echo "✗ Erreur connexion BDD: " . $e->getMessage() . "\n";
    $errors++;
}

echo "\n";

// ============================================
// TEST 4: Dossiers et permissions
// ============================================
echo "📂 TEST 4/8: Dossiers et Permissions\n";
echo str_repeat("-", 60) . "\n";

$directories = [
    'cache' => true,
    'logs' => true,
    'backups' => true,
    'public/assets' => false,
    'vendor' => false
];

foreach ($directories as $dir => $writable) {
    if (is_dir($dir)) {
        echo "✓ Dossier {$dir} existe";
        if ($writable && is_writable($dir)) {
            echo " (écriture OK)\n";
            $success++;
        } elseif ($writable) {
            echo " (⚠ pas d'écriture)\n";
            $warnings++;
        } else {
            echo "\n";
            $success++;
        }
    } else {
        echo "✗ Dossier {$dir} manquant\n";
        $errors++;
    }
}

echo "\n";

// ============================================
// TEST 5: Middleware et Services
// ============================================
echo "🛡️  TEST 5/8: Middleware et Services\n";
echo str_repeat("-", 60) . "\n";

$components = [
    'app/Config/Environment.php',
    'app/Middleware/CsrfMiddleware.php',
    'app/Middleware/RateLimitMiddleware.php',
    'app/Services/PaymentService.php',
    'app/Services/EmailService.php',
    'app/Services/AnalyticsService.php',
    'app/Services/AIService.php'
];

foreach ($components as $component) {
    if (file_exists($component)) {
        echo "✓ {$component}\n";
        $success++;
    } else {
        echo "✗ {$component} manquant\n";
        $errors++;
    }
}

echo "\n";

// ============================================
// TEST 6: Scripts CRON
// ============================================
echo "⏰ TEST 6/8: Scripts CRON\n";
echo str_repeat("-", 60) . "\n";

$cronScripts = [
    'scripts/cron/backup-database.php',
    'scripts/cron/clear-cache.php',
    'scripts/cron/optimize-database.php',
    'scripts/cron/generate-sitemap.php',
    'scripts/cron/send-newsletter.php'
];

foreach ($cronScripts as $script) {
    if (file_exists($script)) {
        echo "✓ {$script}\n";
        $success++;
    } else {
        echo "✗ {$script} manquant\n";
        $errors++;
    }
}

echo "\n";

// ============================================
// TEST 7: PWA
// ============================================
echo "📱 TEST 7/8: Progressive Web App\n";
echo str_repeat("-", 60) . "\n";

if (file_exists('public/manifest.json')) {
    echo "✓ manifest.json existe\n";
    $success++;
    
    $manifest = json_decode(file_get_contents('public/manifest.json'), true);
    if ($manifest && isset($manifest['name'])) {
        echo "✓ manifest.json valide\n";
        $success++;
    } else {
        echo "⚠ manifest.json invalide\n";
        $warnings++;
    }
} else {
    echo "✗ manifest.json manquant\n";
    $errors++;
}

if (file_exists('public/service-worker.js')) {
    echo "✓ service-worker.js existe\n";
    $success++;
} else {
    echo "✗ service-worker.js manquant\n";
    $errors++;
}

echo "\n";

// ============================================
// TEST 8: Documentation
// ============================================
echo "📚 TEST 8/8: Documentation\n";
echo str_repeat("-", 60) . "\n";

$docs = [
    'README.md',
    'INSTALLATION.md',
    'DEPLOYMENT.md',
    'FEATURES.md',
    'CRON_SETUP.md',
    'RECAP_MODIFICATIONS.md'
];

foreach ($docs as $doc) {
    if (file_exists($doc)) {
        echo "✓ {$doc}\n";
        $success++;
    } else {
        echo "⚠ {$doc} manquant\n";
        $warnings++;
    }
}

echo "\n";

// ============================================
// RÉSUMÉ
// ============================================
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   RÉSUMÉ DES TESTS                                         ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

echo "✅ Succès:        {$success}\n";
echo "⚠️  Avertissements: {$warnings}\n";
echo "❌ Erreurs:       {$errors}\n";
echo "\n";

if ($errors === 0 && $warnings === 0) {
    echo "🎉 TOUS LES TESTS PASSÉS! DIGITA est prêt pour la production.\n";
    exit(0);
} elseif ($errors === 0) {
    echo "✓ Tests OK avec quelques avertissements mineurs.\n";
    exit(0);
} else {
    echo "⚠️  Des erreurs ont été détectées. Veuillez les corriger avant le déploiement.\n";
    exit(1);
}
