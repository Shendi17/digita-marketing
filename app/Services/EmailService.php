<?php

/**
 * Service d'envoi d'emails
 * Gère l'envoi d'emails avec templates
 */
class EmailService {
    
    private $from;
    private $fromName;
    
    public function __construct() {
        $this->from = 'noreply@digita-marketing.com';
        $this->fromName = 'Digita Marketing';
    }
    
    /**
     * Envoyer un email simple
     */
    public function send($to, $subject, $message, $isHtml = true) {
        $headers = $this->getHeaders($isHtml);
        
        return mail($to, $subject, $message, $headers);
    }
    
    /**
     * Envoyer un email de bienvenue
     */
    public function sendWelcome($to, $name) {
        $subject = 'Bienvenue chez Digita Marketing';
        $message = $this->getWelcomeTemplate($name);
        
        return $this->send($to, $subject, $message);
    }
    
    /**
     * Envoyer une notification de nouveau message
     */
    public function sendNewContactNotification($adminEmail, $contactData) {
        $subject = 'Nouveau message de contact';
        $message = $this->getContactNotificationTemplate($contactData);
        
        return $this->send($adminEmail, $subject, $message);
    }
    
    /**
     * Envoyer une confirmation de commande
     */
    public function sendOrderConfirmation($to, $orderId) {
        $subject = 'Confirmation de commande #' . $orderId;
        $message = $this->getOrderConfirmationTemplate($orderId);
        
        return $this->send($to, $subject, $message);
    }
    
    /**
     * Envoyer un email de panier abandonné
     */
    public function sendAbandonedCart($to, $cartItems) {
        $subject = 'Votre panier vous attend chez Digita Marketing';
        $message = $this->getAbandonedCartTemplate($cartItems);
        
        return $this->send($to, $subject, $message);
    }
    
    /**
     * Envoyer une confirmation d'abonnement newsletter
     */
    public function sendNewsletterConfirmation($to) {
        $subject = 'Confirmation d\'abonnement à la newsletter';
        $message = $this->getNewsletterConfirmationTemplate();
        
        return $this->send($to, $subject, $message);
    }
    
    /**
     * Obtenir les headers d'email
     */
    private function getHeaders($isHtml = true) {
        $headers = [];
        $headers[] = "From: {$this->fromName} <{$this->from}>";
        $headers[] = "Reply-To: {$this->from}";
        $headers[] = "X-Mailer: PHP/" . phpversion();
        
        if ($isHtml) {
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Type: text/html; charset=UTF-8";
        }
        
        return implode("\r\n", $headers);
    }
    
    /**
     * Template email de bienvenue
     */
    private function getWelcomeTemplate($name) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
                .content { padding: 30px; background: #f8f9fa; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Bienvenue chez Digita Marketing !</h1>
                </div>
                <div class='content'>
                    <p>Bonjour " . htmlspecialchars($name) . ",</p>
                    <p>Merci de nous avoir contactés. Nous avons bien reçu votre message et nous vous répondrons dans les plus brefs délais.</p>
                    <p>Notre équipe est à votre disposition pour répondre à toutes vos questions.</p>
                    <p>Cordialement,<br>L'équipe Digita Marketing</p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Digita Marketing. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
    
    /**
     * Template notification nouveau contact
     */
    private function getContactNotificationTemplate($data) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #667eea; color: white; padding: 20px; }
                .content { padding: 20px; background: white; border: 1px solid #ddd; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #667eea; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Nouveau message de contact</h2>
                </div>
                <div class='content'>
                    <div class='field'>
                        <span class='label'>Nom:</span> " . htmlspecialchars($data['name']) . "
                    </div>
                    <div class='field'>
                        <span class='label'>Email:</span> " . htmlspecialchars($data['email']) . "
                    </div>
                    <div class='field'>
                        <span class='label'>Téléphone:</span> " . htmlspecialchars($data['phone'] ?? 'Non renseigné') . "
                    </div>
                    <div class='field'>
                        <span class='label'>Sujet:</span> " . htmlspecialchars($data['subject']) . "
                    </div>
                    <div class='field'>
                        <span class='label'>Message:</span><br>
                        " . nl2br(htmlspecialchars($data['message'])) . "
                    </div>
                </div>
            </div>
        </body>
        </html>
        ";
    }
    
    /**
     * Envoyer un email de bienvenue formation (post-achat)
     */
    public function sendFormationWelcome($to, $formationTitle, $userName = '') {
        $subject = 'Bienvenue dans votre formation : ' . $formationTitle;
        $message = $this->getFormationWelcomeTemplate($formationTitle, $userName);
        $sent = $this->send($to, $subject, $message);
        $this->logEmail($to, $subject, $sent ? 'sent' : 'failed');
        return $sent;
    }
    
    /**
     * Envoyer un email de suivi de progression
     */
    public function sendProgressReminder($to, $formationTitle, $progress, $userName = '') {
        $subject = 'Votre progression dans : ' . $formationTitle;
        $message = $this->getProgressReminderTemplate($formationTitle, $progress, $userName);
        $sent = $this->send($to, $subject, $message);
        $this->logEmail($to, $subject, $sent ? 'sent' : 'failed');
        return $sent;
    }
    
    /**
     * Envoyer un email de certificat disponible
     */
    public function sendCertificateReady($to, $formationTitle, $certificateUrl, $userName = '') {
        $subject = 'Votre certificat est prêt : ' . $formationTitle;
        $message = $this->getCertificateReadyTemplate($formationTitle, $certificateUrl, $userName);
        $sent = $this->send($to, $subject, $message);
        $this->logEmail($to, $subject, $sent ? 'sent' : 'failed');
        return $sent;
    }
    
    /**
     * Traiter les séquences email en attente (appelé par cron)
     */
    public function processEmailSequences() {
        require_once __DIR__ . '/../Models/Model.php';
        require_once __DIR__ . '/../../includes/Database.php';
        $db = Database::getInstance();
        
        // Récupérer les séquences actives de type purchase
        $sequences = $db->fetchAll(
            "SELECT * FROM email_sequences WHERE is_active = 1 AND trigger_event = 'purchase'"
        );
        
        foreach ($sequences as $seq) {
            // Trouver les commandes payées il y a exactement delay_days jours
            // qui n'ont pas encore reçu cet email
            $targetDate = date('Y-m-d', strtotime("-{$seq['delay_days']} days"));
            
            $orders = $db->fetchAll(
                "SELECT o.*, u.email, u.username 
                 FROM orders o
                 JOIN users u ON o.user_id = u.id
                 WHERE o.status = 'paid' 
                 AND DATE(o.updated_at) = ?
                 AND o.id NOT IN (
                     SELECT DISTINCT SUBSTRING_INDEX(el.subject, '#', -1) 
                     FROM email_logs el 
                     WHERE el.sequence_id = ?
                 )",
                [$targetDate, $seq['id']]
            );
            
            foreach ($orders as $order) {
                $subject = str_replace('{formation}', $order['items_summary'] ?? 'votre formation', $seq['subject']);
                $body = str_replace(
                    ['{username}', '{formation}'],
                    [$order['username'] ?? 'Apprenant', $order['items_summary'] ?? 'votre formation'],
                    $seq['body']
                );
                
                $htmlBody = $this->wrapInTemplate($subject, $body);
                $sent = $this->send($order['email'], $subject, $htmlBody);
                $this->logEmail($order['email'], $subject . ' #' . $order['id'], $sent ? 'sent' : 'failed', $order['user_id'], $seq['id']);
            }
        }
    }
    
    /**
     * Logger un email envoyé
     */
    private function logEmail($to, $subject, $status, $userId = null, $sequenceId = null) {
        try {
            require_once __DIR__ . '/../../includes/Database.php';
            $db = Database::getInstance();
            $db->query(
                "INSERT INTO email_logs (user_id, sequence_id, email_to, subject, status) VALUES (?, ?, ?, ?, ?)",
                [$userId, $sequenceId, $to, $subject, $status]
            );
        } catch (Exception $e) {
            error_log('Erreur log email: ' . $e->getMessage());
        }
    }
    
    /**
     * Wrapper HTML pour les emails
     */
    private function wrapInTemplate($title, $bodyContent) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
                .content { padding: 30px; background: #f8f9fa; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
                .btn { display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>" . htmlspecialchars($title) . "</h1>
                </div>
                <div class='content'>
                    " . nl2br(htmlspecialchars($bodyContent)) . "
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Digita Marketing. Tous droits réservés.</p>
                    <p><a href='https://digita.tonyalpha80.com'>digita.tonyalpha80.com</a></p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    /**
     * Template bienvenue formation
     */
    private function getFormationWelcomeTemplate($formationTitle, $userName) {
        $name = $userName ?: 'Apprenant';
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
                .content { padding: 30px; background: #f8f9fa; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
                .btn { display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Bienvenue dans votre formation !</h1>
                </div>
                <div class='content'>
                    <p>Bonjour " . htmlspecialchars($name) . ",</p>
                    <p>Félicitations ! Vous avez maintenant accès à la formation <strong>" . htmlspecialchars($formationTitle) . "</strong>.</p>
                    <p>Votre formation est disponible immédiatement dans votre espace apprenant. Commencez dès maintenant !</p>
                    <p style='text-align: center; margin: 30px 0;'>
                        <a href='https://digita.tonyalpha80.com/mes-formations' class='btn'>Accéder à ma formation</a>
                    </p>
                    <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
                    <p>Bonne formation !<br>L'équipe Digita Marketing</p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Digita Marketing. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    /**
     * Template rappel de progression
     */
    private function getProgressReminderTemplate($formationTitle, $progress, $userName) {
        $name = $userName ?: 'Apprenant';
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
                .content { padding: 30px; background: #f8f9fa; }
                .progress-bar { background: #e9ecef; border-radius: 10px; height: 20px; overflow: hidden; }
                .progress-fill { background: #667eea; height: 100%; border-radius: 10px; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
                .btn { display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Continuez votre formation !</h1>
                </div>
                <div class='content'>
                    <p>Bonjour " . htmlspecialchars($name) . ",</p>
                    <p>Vous avez progressé de <strong>" . $progress . "%</strong> dans la formation <strong>" . htmlspecialchars($formationTitle) . "</strong>.</p>
                    <div class='progress-bar'>
                        <div class='progress-fill' style='width: " . $progress . "%;'></div>
                    </div>
                    <p style='text-align: center; margin: 30px 0;'>
                        <a href='https://digita.tonyalpha80.com/mes-formations' class='btn'>Continuer ma formation</a>
                    </p>
                    <p>Chaque leçon vous rapproche de votre certificat !</p>
                    <p>À bientôt,<br>L'équipe Digita Marketing</p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Digita Marketing. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    /**
     * Template certificat prêt
     */
    private function getCertificateReadyTemplate($formationTitle, $certificateUrl, $userName) {
        $name = $userName ?: 'Apprenant';
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
                .content { padding: 30px; background: #f8f9fa; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
                .btn { display: inline-block; padding: 12px 24px; background: #f59e0b; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Votre certificat est prêt !</h1>
                </div>
                <div class='content'>
                    <p>Bonjour " . htmlspecialchars($name) . ",</p>
                    <p>Félicitations ! Vous avez terminé la formation <strong>" . htmlspecialchars($formationTitle) . "</strong> avec succès.</p>
                    <p>Votre certificat de complétion est maintenant disponible.</p>
                    <p style='text-align: center; margin: 30px 0;'>
                        <a href='" . htmlspecialchars($certificateUrl) . "' class='btn'>Télécharger mon certificat</a>
                    </p>
                    <p>Partagez votre réussite sur LinkedIn et les réseaux sociaux !</p>
                    <p>Bravo et à bientôt pour de nouvelles formations,<br>L'équipe Digita Marketing</p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Digita Marketing. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    /**
     * Template confirmation de commande (enrichi)
     */
    private function getOrderConfirmationTemplate($orderId) {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
                .content { padding: 30px; background: #f8f9fa; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
                .btn { display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Commande confirmée !</h1>
                </div>
                <div class='content'>
                    <p>Votre commande <strong>#" . $orderId . "</strong> a été confirmée avec succès.</p>
                    <p>Votre formation est maintenant accessible depuis votre espace apprenant.</p>
                    <p style='text-align: center; margin: 30px 0;'>
                        <a href='https://digita.tonyalpha80.com/mes-formations' class='btn'>Accéder à mes formations</a>
                    </p>
                    <p>Votre facture est disponible dans votre espace commandes.</p>
                    <p>Merci pour votre confiance !<br>L'équipe Digita Marketing</p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " Digita Marketing. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>";
    }
    
    /**
     * Template confirmation newsletter
     */
    private function getNewsletterConfirmationTemplate() {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 30px; text-align: center; }
                .content { padding: 30px; background: #f8f9fa; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>✓ Abonnement confirmé !</h1>
                </div>
                <div class='content'>
                    <p>Merci de vous être abonné à notre newsletter !</p>
                    <p>Vous recevrez désormais nos dernières actualités, offres et conseils directement dans votre boîte mail.</p>
                    <p>À très bientôt,<br>L'équipe Digita Marketing</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
}
