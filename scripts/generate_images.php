<?php

// Chemin vers le dossier des images
$imagesPath = __DIR__ . '/../public/assets/images';

// Créer le dossier s'il n'existe pas
if (!file_exists($imagesPath)) {
    mkdir($imagesPath, 0777, true);
}

// Fonction pour créer une image avec un dégradé
function createGradientImage($width, $height, $filename, $startColor, $endColor) {
    $image = imagecreatetruecolor($width, $height);
    
    // Convertir les couleurs hexadécimales en RGB
    $startRGB = sscanf($startColor, "#%02x%02x%02x");
    $endRGB = sscanf($endColor, "#%02x%02x%02x");
    
    // Créer le dégradé
    for($x = 0; $x < $width; $x++) {
        $ratio = $x / $width;
        $r = $startRGB[0] + ($endRGB[0] - $startRGB[0]) * $ratio;
        $g = $startRGB[1] + ($endRGB[1] - $startRGB[1]) * $ratio;
        $b = $startRGB[2] + ($endRGB[2] - $startRGB[2]) * $ratio;
        
        $color = imagecolorallocate($image, $r, $g, $b);
        imageline($image, $x, 0, $x, $height, $color);
    }
    
    // Sauvegarder l'image
    imagejpeg($image, $filename, 90);
    imagedestroy($image);
}

// Créer l'image de fond pour le hero
createGradientImage(1920, 1080, $imagesPath . '/hero-bg.jpg', '#007bff', '#00e1ff');

// Créer l'image de fond pour les statistiques
createGradientImage(1920, 400, $imagesPath . '/stats-bg.jpg', '#0056b3', '#17a2b8');

echo "Images générées avec succès !\n";
