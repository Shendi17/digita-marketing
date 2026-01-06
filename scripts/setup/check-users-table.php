<?php
require_once __DIR__ . '/../../app/Config/Environment.php';
Environment::load(__DIR__ . '/../../.env');

$pdo = new PDO(
    'mysql:host=' . Environment::get('DB_HOST') . ';dbname=' . Environment::get('DB_NAME'),
    Environment::get('DB_USER'),
    Environment::get('DB_PASS')
);

echo "Structure de la table users:\n";
$stmt = $pdo->query('SHOW COLUMNS FROM users');
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "- {$row['Field']} ({$row['Type']})\n";
}
