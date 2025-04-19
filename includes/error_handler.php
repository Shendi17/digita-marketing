<?php
// Définition du gestionnaire d'erreurs personnalisé
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $error_message = date('Y-m-d H:i:s') . " - Erreur [$errno] : $errstr dans $errfile à la ligne $errline\n";
    
    // Log l'erreur dans un fichier
    error_log($error_message, 3, __DIR__ . '/../logs/error.log');
    
    // En mode production, afficher un message d'erreur générique
    if (!defined('ENVIRONMENT') || ENVIRONMENT !== 'development') {
        echo "Une erreur est survenue. Veuillez réessayer plus tard.";
        exit;
    }
    
    // En mode développement, afficher les détails de l'erreur
    echo "<div style='border: 1px solid red; padding: 10px; margin: 10px;'>";
    echo "<h2>Erreur détectée :</h2>";
    echo "<p><strong>Type :</strong> [$errno] $errstr</p>";
    echo "<p><strong>Fichier :</strong> $errfile</p>";
    echo "<p><strong>Ligne :</strong> $errline</p>";
    echo "</div>";
}

// Définition du gestionnaire d'exceptions
function customExceptionHandler($exception) {
    $error_message = date('Y-m-d H:i:s') . " - Exception : " . $exception->getMessage() . 
                    " dans " . $exception->getFile() . " à la ligne " . $exception->getLine() . "\n";
    
    error_log($error_message, 3, __DIR__ . '/../logs/exception.log');
    
    if (!defined('ENVIRONMENT') || ENVIRONMENT !== 'development') {
        echo "Une erreur est survenue. Veuillez réessayer plus tard.";
        exit;
    }
    
    echo "<div style='border: 1px solid red; padding: 10px; margin: 10px;'>";
    echo "<h2>Exception non gérée :</h2>";
    echo "<p><strong>Message :</strong> " . $exception->getMessage() . "</p>";
    echo "<p><strong>Fichier :</strong> " . $exception->getFile() . "</p>";
    echo "<p><strong>Ligne :</strong> " . $exception->getLine() . "</p>";
    echo "</div>";
}

// Enregistrement des gestionnaires
set_error_handler("customErrorHandler");
set_exception_handler("customExceptionHandler");

// Assurer que les erreurs sont bien loggées
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/php_errors.log');
