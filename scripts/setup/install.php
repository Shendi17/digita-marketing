#!/usr/bin/env php
<?php
/**
 * Script d'installation automatique DIGITA Marketing
 * Exécute toutes les étapes nécessaires pour la mise en production
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   DIGITA MARKETING - Installation Automatique             ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

// Vérifier que nous sommes à la racine du projet
if (!file_exists(__DIR__ . '/../../composer.json')) {
    die("❌ Erreur: Ce script doit être exécuté depuis le dossier scripts/setup/\n");
}

$rootDir = realpath(__DIR__ . '/../..');
chdir($rootDir);

echo "📁 Répertoire projet: {$rootDir}\n\n";

// ============================================
// ÉTAPE 1: Vérifier les prérequis
// ============================================
echo "🔍 ÉTAPE 1/6: Vérification des prérequis...\n";
echo str_repeat("-", 60) . "\n";

// Vérifier PHP version
$phpVersion = phpversion();
if (version_compare($phpVersion, '8.2.0', '<')) {
    die("❌ PHP 8.2+ requis. Version actuelle: {$phpVersion}\n");
}
echo "✓ PHP {$phpVersion}\n";

// Vérifier extensions PHP
$requiredExtensions = ['pdo', 'pdo_mysql', 'mysqli', 'curl', 'mbstring', 'json'];
foreach ($requiredExtensions as $ext) {
    if (!extension_loaded($ext)) {
        die("❌ Extension PHP manquante: {$ext}\n");
    }
    echo "✓ Extension {$ext}\n";
}

// Vérifier Composer
exec('composer --version 2>&1', $output, $returnVar);
if ($returnVar !== 0) {
    die("❌ Composer non installé\n");
}
echo "✓ Composer installé\n";

echo "\n";

// ============================================
// ÉTAPE 2: Créer le fichier .env
// ============================================
echo "⚙️  ÉTAPE 2/6: Configuration .env...\n";
echo str_repeat("-", 60) . "\n";

if (!file_exists('.env')) {
    if (file_exists('.env.example')) {
        copy('.env.example', '.env');
        echo "✓ Fichier .env créé depuis .env.example\n";
        echo "⚠️  IMPORTANT: Éditer .env avec vos credentials avant de continuer!\n";
        echo "   Appuyez sur ENTRÉE une fois .env configuré...\n";
        fgets(STDIN);
    } else {
        die("❌ Fichier .env.example introuvable\n");
    }
} else {
    echo "✓ Fichier .env existe déjà\n";
}

// Charger .env
require_once __DIR__ . '/../../app/Config/Environment.php';
try {
    Environment::load($rootDir . '/.env');
    echo "✓ Variables d'environnement chargées\n";
} catch (Exception $e) {
    die("❌ Erreur chargement .env: " . $e->getMessage() . "\n");
}

echo "\n";

// ============================================
// ÉTAPE 3: Installer les dépendances
// ============================================
echo "📦 ÉTAPE 3/6: Installation des dépendances...\n";
echo str_repeat("-", 60) . "\n";

if (!file_exists('vendor/autoload.php')) {
    echo "Installation des dépendances Composer...\n";
    exec('composer install --no-dev --optimize-autoloader 2>&1', $output, $returnVar);
    if ($returnVar !== 0) {
        die("❌ Erreur installation Composer\n");
    }
    echo "✓ Dépendances installées\n";
} else {
    echo "✓ Dépendances déjà installées\n";
}

echo "\n";

// ============================================
// ÉTAPE 4: Créer les dossiers nécessaires
// ============================================
echo "📂 ÉTAPE 4/6: Création des dossiers...\n";
echo str_repeat("-", 60) . "\n";

$directories = [
    'cache',
    'logs',
    'backups',
    'backups/database',
    'public/assets/uploads',
    'public/assets/images/icons'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
        echo "✓ Créé: {$dir}\n";
    } else {
        echo "✓ Existe: {$dir}\n";
    }
}

// Permissions
chmod('cache', 0775);
chmod('logs', 0775);
chmod('backups', 0775);
echo "✓ Permissions configurées\n";

echo "\n";

// ============================================
// ÉTAPE 5: Exécuter les migrations SQL
// ============================================
echo "🗄️  ÉTAPE 5/6: Exécution des migrations SQL...\n";
echo str_repeat("-", 60) . "\n";

// Connexion à la base de données
$dbHost = Environment::get('DB_HOST', 'localhost');
$dbName = Environment::get('DB_NAME', 'digita_marketing');
$dbUser = Environment::get('DB_USER', 'root');
$dbPass = Environment::get('DB_PASS', '');

try {
    $pdo = new PDO("mysql:host={$dbHost};charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer la base de données si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Base de données '{$dbName}' prête\n";
    
    // Se connecter à la base
    $pdo->exec("USE `{$dbName}`");
    
    // Exécuter les migrations dans l'ordre
    $migrations = [
        'database/digita.sql',
        'database/init.sql',
        'database/create_blog_formations.sql',
        'database/migrations/create_orders_tables.sql',
        'database/migrations/add_missing_indexes.sql'
    ];
    
    foreach ($migrations as $migration) {
        if (file_exists($migration)) {
            echo "Exécution: {$migration}... ";
            $sql = file_get_contents($migration);
            
            // Exécuter chaque requête séparément
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    try {
                        $pdo->exec($statement);
                    } catch (PDOException $e) {
                        // Ignorer les erreurs "table exists" et "duplicate key"
                        if (strpos($e->getMessage(), 'already exists') === false && 
                            strpos($e->getMessage(), 'Duplicate') === false) {
                            echo "⚠️  " . $e->getMessage() . "\n";
                        }
                    }
                }
            }
            echo "✓\n";
        } else {
            echo "⚠️  Migration non trouvée: {$migration}\n";
        }
    }
    
    echo "✓ Toutes les migrations exécutées\n";
    
} catch (PDOException $e) {
    die("❌ Erreur base de données: " . $e->getMessage() . "\n");
}

echo "\n";

// ============================================
// ÉTAPE 6: Configuration finale
// ============================================
echo "🎯 ÉTAPE 6/6: Configuration finale...\n";
echo str_repeat("-", 60) . "\n";

// Créer un fichier de log vide
if (!file_exists('logs/error.log')) {
    touch('logs/error.log');
    echo "✓ Fichier error.log créé\n";
}

if (!file_exists('logs/exception.log')) {
    touch('logs/exception.log');
    echo "✓ Fichier exception.log créé\n";
}

// Générer le sitemap initial
if (file_exists('scripts/cron/generate-sitemap.php')) {
    echo "Génération du sitemap... ";
    include 'scripts/cron/generate-sitemap.php';
}

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   ✅ INSTALLATION TERMINÉE AVEC SUCCÈS                     ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

echo "📋 PROCHAINES ÉTAPES:\n";
echo "\n";
echo "1. 🔐 Créer un compte admin:\n";
echo "   - Accéder à: " . Environment::get('APP_URL', 'http://localhost') . "/inscription\n";
echo "   - Puis exécuter en BDD:\n";
echo "     UPDATE users SET role = 'admin' WHERE email = 'votre-email@domaine.com';\n";
echo "\n";
echo "2. ⏰ Configurer les tâches CRON (voir CRON_SETUP.md)\n";
echo "\n";
echo "3. 🔑 Configurer les API keys dans .env:\n";
echo "   - STRIPE_PUBLIC_KEY / STRIPE_SECRET_KEY\n";
echo "   - GA_TRACKING_ID / FB_PIXEL_ID\n";
echo "   - OPENAI_API_KEY (optionnel)\n";
echo "\n";
echo "4. 📧 Tester l'envoi d'emails (formulaire contact)\n";
echo "\n";
echo "5. 🚀 Accéder au site:\n";
echo "   - Frontend: " . Environment::get('APP_URL', 'http://localhost') . "\n";
echo "   - Admin: " . Environment::get('APP_URL', 'http://localhost') . "/admin/dashboard\n";
echo "\n";

echo "📚 Documentation complète dans:\n";
echo "   - INSTALLATION.md\n";
echo "   - DEPLOYMENT.md\n";
echo "   - FEATURES.md\n";
echo "\n";

echo "✨ DIGITA Marketing est prêt pour la production!\n";
echo "\n";
