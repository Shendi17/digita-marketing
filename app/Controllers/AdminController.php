<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Contact.php';
require_once __DIR__ . '/../Models/Newsletter.php';

/**
 * Contrôleur Admin
 * Gère toutes les actions de l'administration
 */
class AdminController extends Controller {
    
    private $userModel;
    private $contactModel;
    private $newsletterModel;
    
    public function __construct() {
        $this->requireAdmin();
        $this->userModel = new User();
        $this->contactModel = new Contact();
        $this->newsletterModel = new Newsletter();
    }
    
    /**
     * Page dashboard
     */
    public function dashboard() {
        // Récupérer les statistiques
        $contactStats = $this->contactModel->getStats();
        $newsletterStats = $this->newsletterModel->getStats();
        $userStats = $this->userModel->getStats();
        
        // Récupérer les données récentes
        $recentContacts = $this->contactModel->getRecent(5);
        $recentNewsletters = $this->newsletterModel->getRecent(5);
        $newMessages = $this->contactModel->getNew();
        
        // Calculer des métriques
        $stats = [
            'contacts' => [
                'total' => $contactStats['total'],
                'new' => $contactStats['new'],
                'today' => $contactStats['today'],
                'this_week' => $contactStats['this_week'],
                'this_month' => $contactStats['this_month']
            ],
            'newsletters' => [
                'total' => $newsletterStats['total'],
                'active' => $newsletterStats['active'],
                'today' => $newsletterStats['today'],
                'this_week' => $newsletterStats['this_week'],
                'this_month' => $newsletterStats['this_month']
            ],
            'users' => $userStats,
            'conversion_rate' => $contactStats['total'] > 0 
                ? round(($newsletterStats['active'] / $contactStats['total']) * 100, 1) 
                : 0
        ];
        
        // Préparer les données pour la vue
        $data = [
            'pageTitle' => 'Dashboard',
            'stats' => $stats,
            'recentContacts' => $recentContacts,
            'recentNewsletters' => $recentNewsletters,
            'newMessages' => $newMessages,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/dashboard', $data);
    }
    
    /**
     * Page de gestion des contacts
     */
    public function contacts() {
        $contacts = $this->contactModel->all('created_at DESC');
        $stats = $this->contactModel->getStats();
        
        $data = [
            'pageTitle' => 'Messages de contact',
            'contacts' => $contacts,
            'stats' => $stats,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/contacts', $data);
    }
    
    /**
     * Marquer un message comme lu
     */
    public function markContactAsRead($id) {
        $this->contactModel->markAsRead($id);
        $this->redirect('/admin/contacts');
    }
    
    /**
     * Marquer un message comme répondu
     */
    public function markContactAsReplied($id) {
        $this->contactModel->markAsReplied($id);
        $this->redirect('/admin/contacts');
    }
    
    /**
     * Page de gestion des newsletters
     */
    public function newsletters() {
        $newsletters = $this->newsletterModel->all('created_at DESC');
        $stats = $this->newsletterModel->getStats();
        
        $data = [
            'pageTitle' => 'Abonnés newsletter',
            'newsletters' => $newsletters,
            'stats' => $stats,
            'currentUser' => $this->getCurrentUser()
        ];
        
        $this->viewWithLayout('admin/newsletters', $data);
    }
    
    /**
     * Exporter les emails de la newsletter
     */
    public function exportNewsletters() {
        $emails = $this->newsletterModel->exportEmails();
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="newsletter_emails_' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Email', 'Date']);
        
        foreach ($this->newsletterModel->getActive() as $subscriber) {
            fputcsv($output, [$subscriber['email'], $subscriber['created_at']]);
        }
        
        fclose($output);
        exit();
    }
    
    /**
     * Page de gestion des webhooks
     */
    public function webhooks() {
        // Charger la configuration des webhooks depuis un fichier ou la DB
        $webhooks = [
            'contact_url' => '',
            'contact_enabled' => false,
            'newsletter_url' => '',
            'newsletter_enabled' => false,
            'system_url' => '',
            'system_enabled' => false
        ];
        
        // TODO: Charger depuis la base de données ou un fichier de config
        
        $data = [
            'pageTitle' => 'Webhooks',
            'webhooks' => $webhooks,
            'currentUser' => $_SESSION
        ];
        
        $this->viewWithLayout('admin/webhooks', $data);
    }
    
    /**
     * Sauvegarder la configuration des webhooks
     */
    public function saveWebhooks() {
        // TODO: Sauvegarder dans la base de données
        $this->redirect('/admin/webhooks');
    }
    
    /**
     * Tester un webhook
     */
    public function testWebhook($type) {
        header('Content-Type: application/json');
        
        // TODO: Envoyer un webhook de test
        echo json_encode([
            'success' => true,
            'message' => 'Webhook de test envoyé'
        ]);
        exit();
    }
    
    /**
     * Page de gestion des campagnes
     */
    public function campaigns() {
        // Données factices pour la démo
        $campaigns = [
            [
                'id' => 1,
                'name' => 'Newsletter Octobre 2025',
                'description' => 'Newsletter mensuelle avec les dernières actualités',
                'type' => 'newsletter',
                'recipients' => 150,
                'sent' => 150,
                'opened' => 98,
                'clicked' => 45,
                'open_rate' => 65,
                'click_rate' => 30,
                'status' => 'completed',
                'created_at' => '2025-10-01 10:00:00'
            ],
            [
                'id' => 2,
                'name' => 'Promotion Spéciale',
                'description' => 'Offre limitée sur nos services',
                'type' => 'promotion',
                'recipients' => 200,
                'sent' => 200,
                'opened' => 145,
                'clicked' => 78,
                'open_rate' => 72,
                'click_rate' => 39,
                'status' => 'active',
                'created_at' => '2025-10-15 14:30:00'
            ],
            [
                'id' => 3,
                'name' => 'Nouvelle Campagne',
                'description' => 'En cours de préparation',
                'type' => 'newsletter',
                'recipients' => 0,
                'sent' => 0,
                'opened' => 0,
                'clicked' => 0,
                'open_rate' => 0,
                'click_rate' => 0,
                'status' => 'draft',
                'created_at' => '2025-10-25 09:00:00'
            ]
        ];
        
        $stats = [
            'total' => count($campaigns),
            'active' => count(array_filter($campaigns, fn($c) => $c['status'] === 'active')),
            'draft' => count(array_filter($campaigns, fn($c) => $c['status'] === 'draft')),
            'open_rate' => 68
        ];
        
        $data = [
            'pageTitle' => 'Campagnes Marketing',
            'campaigns' => $campaigns,
            'stats' => $stats,
            'currentUser' => $_SESSION
        ];
        
        $this->viewWithLayout('admin/campaigns', $data);
    }
    
    /**
     * Créer une nouvelle campagne
     */
    public function newCampaign() {
        // TODO: Afficher le formulaire de création
        $this->redirect('/admin/campaigns');
    }
    
    /**
     * Supprimer une campagne
     */
    public function deleteCampaign($id) {
        header('Content-Type: application/json');
        
        // TODO: Supprimer de la base de données
        echo json_encode([
            'success' => true,
            'message' => 'Campagne supprimée'
        ]);
        exit();
    }
    
    /**
     * Déconnexion
     */
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        $this->redirect('/connexion');
    }
}
