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

// Création d'une image par défaut
function createDefaultImage($path, $text) {
    $width = 400;
    $height = 400;
    
    // Création de l'image
    $image = imagecreatetruecolor($width, $height);
    
    // Couleurs
    $bg_color = imagecolorallocate($image, 0, 123, 255);    // #007bff
    $text_color = imagecolorallocate($image, 255, 255, 255); // #ffffff
    
    // Remplir le fond
    imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);
    
    // Ajouter le texte
    $font_size = 20;
    $text = str_replace(['-', '.jpg'], [' ', ''], $text);
    $text = ucwords($text);
    
    // Centrer le texte
    $bbox = imagettfbbox($font_size, 0, 'arial', $text);
    $text_width = $bbox[2] - $bbox[0];
    $text_height = $bbox[1] - $bbox[7];
    $text_x = ($width - $text_width) / 2;
    $text_y = ($height + $text_height) / 2;
    
    // Écrire le texte
    imagettftext($image, $font_size, 0, $text_x, $text_y, $text_color, 'arial', $text);
    
    // Sauvegarder l'image
    imagejpeg($image, $path, 90);
    imagedestroy($image);
}

// Création des images
foreach ($team_members as $image) {
    $target_path = $team_image_dir . '/' . $image;
    if (!file_exists($target_path)) {
        createDefaultImage($target_path, $image);
        echo "Image créée : $image\n";
    } else {
        echo "L'image existe déjà : $image\n";
    }
}
