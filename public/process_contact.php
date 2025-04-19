<?php
require_once '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $name = secure($_POST['name']);
    $email = secure($_POST['email']);
    $phone = secure($_POST['phone']);
    $subject = secure($_POST['subject']);
    $message = secure($_POST['message']);
    
    // Validation des données
    $errors = array();
    
    if (empty($name)) {
        $errors[] = "Le nom est requis";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide";
    }
    
    if (empty($subject)) {
        $errors[] = "Le sujet est requis";
    }
    
    if (empty($message)) {
        $errors[] = "Le message est requis";
    }
    
    // Si pas d'erreurs, procéder à l'envoi
    if (empty($errors)) {
        // Préparation du message
        $to = ADMIN_EMAIL;
        $email_subject = "Nouveau message de contact - $subject";
        
        $email_body = "Vous avez reçu un nouveau message depuis le formulaire de contact.\n\n".
            "Détails :\n\n".
            "Nom: $name\n".
            "Email: $email\n".
            "Téléphone: $phone\n".
            "Sujet: $subject\n".
            "Message:\n$message\n";
        
        $headers = "From: $email\n";
        $headers .= "Reply-To: $email\n";
        
        // Envoi de l'email
        try {
            mail($to, $email_subject, $email_body, $headers);
            
            // Enregistrement dans la base de données
            $db = connectDB();
            $stmt = $db->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $subject, $message]);
            
            // Redirection avec message de succès
            header("Location: " . SITE_URL . "?page=contact&status=success");
            exit();
            
        } catch (Exception $e) {
            header("Location: " . SITE_URL . "?page=contact&status=error");
            exit();
        }
    } else {
        // Redirection avec erreurs
        $error_string = implode(",", $errors);
        header("Location: " . SITE_URL . "?page=contact&status=error&messages=" . urlencode($error_string));
        exit();
    }
} else {
    // Si accès direct au script
    header("Location: " . SITE_URL);
    exit();
}
