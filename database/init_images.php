<?php
require_once __DIR__ . '/../config/config.php';

// Création du dossier images si nécessaire
$team_image_dir = __DIR__ . '/../public/assets/images/team';
if (!is_dir($team_image_dir)) {
    mkdir($team_image_dir, 0777, true);
}

// Liste des membres de l'équipe
$team_members = [
    'thomas-martin.jpg',
    'sophie-dubois.jpg',
    'lucas-bernard.jpg',
    'emma-laurent.jpg',
    'marie-petit.jpg',
    'antoine-durand.jpg',
    'julie-moreau.jpg',
    'pierre-leroy.jpg'
];

// Téléchargement des images placeholder
foreach ($team_members as $image) {
    $target_path = $team_image_dir . '/' . $image;
    if (!file_exists($target_path)) {
        // Utilisation de placeholder.com pour générer des images
        $placeholder_url = "https://via.placeholder.com/400x400.jpg/007bff/ffffff?text=" . 
                          pathinfo($image, PATHINFO_FILENAME);
        
        if ($image_content = @file_get_contents($placeholder_url)) {
            file_put_contents($target_path, $image_content);
            echo "Image créée : $image\n";
        } else {
            echo "Erreur lors de la création de l'image : $image\n";
        }
    } else {
        echo "L'image existe déjà : $image\n";
    }
}
