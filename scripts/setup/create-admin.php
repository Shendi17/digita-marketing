#!/usr/bin/env php
<?php
/**
 * Script pour créer un compte administrateur
 * Usage: php scripts/setup/create-admin.php
 */

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   DIGITA MARKETING - Création Compte Admin                ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

// Charger l'environnement
require_once __DIR__ . '/../../app/Config/Environment.php';

try {
    Environment::load(__DIR__ . '/../../.env');
} catch (Exception $e) {
    die("❌ Erreur chargement .env: " . $e->getMessage() . "\n");
}

// Connexion à la base de données
$dbHost = Environment::get('DB_HOST', 'localhost');
$dbName = Environment::get('DB_NAME', 'digita_marketing');
$dbUser = Environment::get('DB_USER', 'root');
$dbPass = Environment::get('DB_PASS', '');

try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Connexion base de données OK\n\n";
} catch (PDOException $e) {
    die("❌ Erreur connexion BDD: " . $e->getMessage() . "\n");
}

// Credentials admin
$email = 'admin@digita.com';
$password = 'admin123';
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

echo "📋 Création du compte admin:\n";
echo "   Email: {$email}\n";
echo "   Password: {$password}\n\n";

// Vérifier si l'utilisateur existe déjà
$stmt = $pdo->prepare("SELECT id, role FROM users WHERE email = ?");
$stmt->execute([$email]);
$existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existingUser) {
    echo "⚠️  Utilisateur existe déjà (ID: {$existingUser['id']})\n";
    
    // Mettre à jour le mot de passe et le rôle
    $stmt = $pdo->prepare("UPDATE users SET password = ?, role = 'admin' WHERE email = ?");
    $stmt->execute([$hashedPassword, $email]);
    
    echo "✓ Mot de passe et rôle mis à jour\n";
} else {
    // Créer le nouvel utilisateur
    $stmt = $pdo->prepare("
        INSERT INTO users (email, password, role, created_at) 
        VALUES (?, ?, 'admin', NOW())
    ");
    $stmt->execute([$email, $hashedPassword]);
    
    echo "✓ Compte admin créé avec succès (ID: {$pdo->lastInsertId()})\n";
}

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   ✅ COMPTE ADMIN PRÊT                                     ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

echo "🔐 Identifiants de connexion:\n";
echo "   Email:    {$email}\n";
echo "   Password: {$password}\n";
echo "\n";

echo "🚀 Accéder au site:\n";
echo "   Frontend: " . Environment::get('SITE_URL', 'http://localhost') . "\n";
echo "   Connexion: " . Environment::get('SITE_URL', 'http://localhost') . "/connexion\n";
echo "   Admin: " . Environment::get('SITE_URL', 'http://localhost') . "/admin/dashboard\n";
echo "\n";

echo "✨ Vous pouvez maintenant vous connecter!\n";
echo "\n";
