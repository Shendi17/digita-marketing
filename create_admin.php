<?php
// Script à lancer UNE FOIS puis à supprimer pour des raisons de sécurité !
require_once __DIR__ . '/includes/Database.php';

$db = Database::getInstance();

// Création de la table users si elle n'existe pas
$db->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(32) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);");

// Ajout du champ role si la table existe déjà sans ce champ
try {
    $db->query("ALTER TABLE users ADD COLUMN role VARCHAR(32) NOT NULL DEFAULT 'user';");
} catch (Exception $e) {
    // Ignore si déjà présent
}

$email = 'admin@digita.com';
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);
$role = 'admin';

// Vérifie si l'utilisateur existe déjà
$user = $db->fetch('SELECT * FROM users WHERE email = ?', [$email]);
if ($user) {
    echo "L'utilisateur admin existe déjà.";
} else {
    $db->query('INSERT INTO users (email, password, role) VALUES (?, ?, ?)', [$email, $hash, $role]);
    echo "Utilisateur admin créé avec succès.";
}
