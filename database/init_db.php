<?php
require_once __DIR__ . '/../config/config.php';

try {
    // Connexion à MySQL sans sélectionner la base de données
    $pdo = new PDO(
        "mysql:host=" . DB_HOST,
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Création de la base de données si elle n'existe pas
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Base de données créée ou déjà existante.\n";

    // Sélection de la base de données
    $pdo->exec("USE " . DB_NAME);

    // Lecture et exécution du fichier SQL
    $sql = file_get_contents(__DIR__ . '/init.sql');
    $pdo->exec($sql);
    echo "Tables créées et données insérées avec succès.\n";

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage() . "\n");
}
