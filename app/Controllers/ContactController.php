<?php

require_once __DIR__ . '/../Helpers/ViewHelper.php';
require_once __DIR__ . '/../Models/Contact.php';
require_once __DIR__ . '/../Services/EmailService.php';

class ContactController {
    
    /**
     * Page Contact
     */
    public function index() {
        $data = [
            'title' => 'Contact - Digita Marketing',
            'extraCss' => ['/assets/css/contact.css']
        ];
        
        ViewHelper::render('contact/index-content', $data);
    }

    /**
     * API : Soumettre une demande d'audit stratégique
     */
    public function submitAudit() {
        header('Content-Type: application/json');

        // Récupération des données POST
        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $website = $_POST['website'] ?? 'Non précisé';

        if (!$name || !$email) {
            echo json_encode(['success' => false, 'message' => 'Veuillez remplir les champs obligatoires.']);
            return;
        }

        try {
            // 1. Sauvegarde en Base de Données (Modèle Contact)
            $contactModel = new Contact();
            $subject = "Demande d'Audit Stratégique - " . $name;
            $message = "Une nouvelle demande d'audit a été soumise.\n\n";
            $message .= "Nom : " . $name . "\n";
            $message .= "Email : " . $email . "\n";
            $message .= "Site Web : " . $website . "\n";
            
            $contactModel->createMessage($name, $email, '', $subject, $message);

            // 2. Notification SMTP (Standard pour le moment)
            $emailService = new EmailService();
            $adminEmail = defined('ADMIN_EMAIL') ? ADMIN_EMAIL : 'admin@digita.fr';
            
            $notifData = [
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
                'phone' => 'N/A'
            ];
            
            // Envoi à l'admin
            $emailService->sendNewContactNotification($adminEmail, $notifData);

            // 3. Email de confirmation au client (Premium Experience)
            $emailService->sendWelcome($email, $name);

            // Note : Ici on pourra ajouter plus tard des appels API vers CRM ou Webox
            // handleFutureIntegrations($notifData);

            echo json_encode([
                'success' => true, 
                'message' => 'Votre demande a été prise en compte. Un consultant vous contactera prochainement.'
            ]);

        } catch (Exception $e) {
            error_log("Erreur Audit Submission: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Une erreur technique est survenue.']);
        }
    }
}
