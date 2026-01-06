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
