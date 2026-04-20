<?php
// Configuration et démarrage de session (seulement si pas encore active)
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_strict_mode', 1);
    session_start();
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/Router.php';

$router = new Router();

// Page d'accueil
$router->get('/', function() {
    require_once __DIR__ . '/../templates/home.php';
});

// ========== BLOG ==========
// Liste des articles
$router->get('/blog', function() {
    require_once __DIR__ . '/../app/Controllers/BlogController.php';
    $controller = new BlogController();
    $controller->index();
});

// Recherche d'articles
$router->get('/blog/search', function() {
    require_once __DIR__ . '/../app/Controllers/BlogController.php';
    $controller = new BlogController();
    $controller->search();
});

// Articles par catégorie
$router->get('/blog/categorie/:slug', function($slug) {
    require_once __DIR__ . '/../app/Controllers/BlogController.php';
    $controller = new BlogController();
    $controller->category($slug);
});

// Détail d'un article
$router->get('/blog/:slug', function($slug) {
    require_once __DIR__ . '/../app/Controllers/BlogController.php';
    $controller = new BlogController();
    $controller->show($slug);
});

// ========== FORMATIONS ==========
// Liste des formations
$router->get('/formations', function() {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->index();
});

// Recherche de formations
$router->get('/formations/search', function() {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->search();
});

// Mes formations (utilisateur connecté)
$router->get('/mes-formations', function() {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->myFormations();
});

// Formations par catégorie
$router->get('/formations/categorie/:slug', function($slug) {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->category($slug);
});

// Inscription à une formation
$router->post('/formations/:slug/inscription', function($slug) {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->enroll($slug);
});

// Interface d'apprentissage (doit être avant /formations/:slug)
$router->get('/formations/:slug/learn', function($slug) {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->learn($slug);
});

// Marquer une leçon comme complétée (AJAX)
$router->post('/formations/complete-lesson', function() {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->completeLesson();
});

// Quiz
$router->get('/formations/quiz/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->quiz($id);
});

// Soumettre un quiz
$router->post('/formations/quiz/:id/submit', function($id) {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->submitQuiz($id);
});

// Résultats d'un quiz
$router->get('/formations/quiz/:id/results', function($id) {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->quizResults($id);
});

// Soumettre un avis
$router->post('/formations/:id/review', function($id) {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->review($id);
});

// Certificat
$router->get('/formations/:id/certificate', function($id) {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->certificate($id);
});

// Vérification publique de certificat
$router->get('/certificat/verifier', function() {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->verifyCertificate();
});

// Landing page formation (page de vente)
$router->get('/formations/:slug/landing', function($slug) {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->landing($slug);
});

// ==================== PAIEMENT ====================

// Checkout formation
$router->get('/formations/checkout/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/PaymentController.php';
    $controller = new PaymentController();
    $controller->checkout($id);
});

// Traitement du paiement (création session Stripe)
$router->post('/formations/checkout/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/PaymentController.php';
    $controller = new PaymentController();
    $controller->processCheckout($id);
});

// Succès paiement
$router->get('/paiement/succes', function() {
    require_once __DIR__ . '/../app/Controllers/PaymentController.php';
    $controller = new PaymentController();
    $controller->success();
});

// Annulation paiement
$router->get('/paiement/annulation', function() {
    require_once __DIR__ . '/../app/Controllers/PaymentController.php';
    $controller = new PaymentController();
    $controller->cancel();
});

// Webhook Stripe
$router->post('/webhook/stripe', function() {
    require_once __DIR__ . '/../app/Controllers/PaymentController.php';
    $controller = new PaymentController();
    $controller->webhook();
});

// Validation code promo (AJAX)
$router->post('/api/validate-promo', function() {
    require_once __DIR__ . '/../app/Controllers/PaymentController.php';
    $controller = new PaymentController();
    $controller->validatePromo();
});

// Mes commandes
$router->get('/mes-commandes', function() {
    require_once __DIR__ . '/../app/Controllers/PaymentController.php';
    $controller = new PaymentController();
    $controller->myOrders();
});

// Détail commande
$router->get('/mes-commandes/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/PaymentController.php';
    $controller = new PaymentController();
    $controller->orderDetail($id);
});

// Facture
$router->get('/facture/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/PaymentController.php';
    $controller = new PaymentController();
    $controller->invoice($id);
});

// ==================== API CONVERSION & AUDIT ====================

// Soumettre une demande d'audit stratégique
$router->post('/api/audit-request', function() {
    require_once __DIR__ . '/../app/Controllers/ContactController.php';
    $controller = new ContactController();
    $controller->submitAudit();
});

// ==================== PROJETS CLIENTS ====================

// Formulaire de brief
$router->get('/projets/brief', function() {
    require_once __DIR__ . '/../app/Controllers/ProjectController.php';
    $controller = new ProjectController();
    $controller->briefForm();
});

// Soumettre le brief
$router->post('/projets/brief', function() {
    require_once __DIR__ . '/../app/Controllers/ProjectController.php';
    $controller = new ProjectController();
    $controller->submitBrief();
});

// Calcul devis AJAX
$router->post('/api/project-quote', function() {
    require_once __DIR__ . '/../app/Controllers/ProjectController.php';
    $controller = new ProjectController();
    $controller->ajaxQuote();
});

// Espace client (dashboard)
$router->get('/espace-client', function() {
    require_once __DIR__ . '/../app/Controllers/ProjectController.php';
    $controller = new ProjectController();
    $controller->dashboard();
});

// Détail projet client
$router->get('/espace-client/projet/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/ProjectController.php';
    $controller = new ProjectController();
    $controller->show($id);
});

// Envoyer un message client
$router->post('/espace-client/projet/:id/message', function($id) {
    require_once __DIR__ . '/../app/Controllers/ProjectController.php';
    $controller = new ProjectController();
    $controller->sendMessage($id);
});

// Webhook Webox → Digita
$router->post('/webhook/webox', function() {
    require_once __DIR__ . '/../app/Controllers/AdminProjectController.php';
    $controller = new AdminProjectController();
    $controller->webhookWebox();
});

// ==================== CHATBOT IA ====================

// Envoyer un message chatbot (AJAX)
$router->post('/api/chatbot/message', function() {
    require_once __DIR__ . '/../app/Controllers/ChatbotController.php';
    $controller = new ChatbotController();
    $controller->sendMessage();
});

// Historique chatbot (AJAX)
$router->get('/api/chatbot/history', function() {
    require_once __DIR__ . '/../app/Controllers/ChatbotController.php';
    $controller = new ChatbotController();
    $controller->getHistory();
});

// Qualifier un lead (AJAX)
$router->post('/api/chatbot/qualify', function() {
    require_once __DIR__ . '/../app/Controllers/ChatbotController.php';
    $controller = new ChatbotController();
    $controller->qualifyLead();
});

// Prendre un RDV (AJAX)
$router->post('/api/chatbot/appointment', function() {
    require_once __DIR__ . '/../app/Controllers/ChatbotController.php';
    $controller = new ChatbotController();
    $controller->bookAppointment();
});

// Créneaux disponibles (AJAX)
$router->get('/api/chatbot/slots', function() {
    require_once __DIR__ . '/../app/Controllers/ChatbotController.php';
    $controller = new ChatbotController();
    $controller->availableSlots();
});

// ==================== OUTILS GRATUITS ====================

// Page index outils
$router->get('/outils', function() {
    require_once __DIR__ . '/../app/Controllers/ToolsController.php';
    $controller = new ToolsController();
    $controller->index();
});

// Audit SEO gratuit
$router->get('/outils/audit-seo', function() {
    require_once __DIR__ . '/../app/Controllers/ToolsController.php';
    $controller = new ToolsController();
    $controller->seoAudit();
});

$router->post('/outils/audit-seo', function() {
    require_once __DIR__ . '/../app/Controllers/ToolsController.php';
    $controller = new ToolsController();
    $controller->seoAudit();
});

// Générateur meta descriptions
$router->get('/outils/meta-generator', function() {
    require_once __DIR__ . '/../app/Controllers/ToolsController.php';
    $controller = new ToolsController();
    $controller->metaGenerator();
});

$router->post('/outils/meta-generator', function() {
    require_once __DIR__ . '/../app/Controllers/ToolsController.php';
    $controller = new ToolsController();
    $controller->metaGenerator();
});

// Calculateur ROI
$router->get('/outils/roi-calculator', function() {
    require_once __DIR__ . '/../app/Controllers/ToolsController.php';
    $controller = new ToolsController();
    $controller->roiCalculator();
});

$router->post('/outils/roi-calculator', function() {
    require_once __DIR__ . '/../app/Controllers/ToolsController.php';
    $controller = new ToolsController();
    $controller->roiCalculator();
});

// ROI AJAX
$router->post('/api/roi-calculate', function() {
    require_once __DIR__ . '/../app/Controllers/ToolsController.php';
    $controller = new ToolsController();
    $controller->ajaxRoi();
});

// Calendrier éditorial
$router->get('/outils/calendrier-editorial', function() {
    require_once __DIR__ . '/../app/Controllers/ToolsController.php';
    $controller = new ToolsController();
    $controller->editorialCalendar();
});

$router->post('/outils/calendrier-editorial', function() {
    require_once __DIR__ . '/../app/Controllers/ToolsController.php';
    $controller = new ToolsController();
    $controller->editorialCalendar();
});

// ==================== ANALYTICS API ====================

// Tracker page view (AJAX)
$router->post('/api/analytics/pageview', function() {
    require_once __DIR__ . '/../app/Controllers/AnalyticsController.php';
    $controller = new AnalyticsController();
    $controller->trackPageView();
});

// Tracker conversion (AJAX)
$router->post('/api/analytics/conversion', function() {
    require_once __DIR__ . '/../app/Controllers/AnalyticsController.php';
    $controller = new AnalyticsController();
    $controller->trackConversion();
});

// Détail d'une formation
$router->get('/formations/:slug', function($slug) {
    require_once __DIR__ . '/../app/Controllers/FormationController.php';
    $controller = new FormationController();
    $controller->show($slug);
});

// Page Boutique
$router->get('/boutique', function() {
    require_once __DIR__ . '/../app/Controllers/BoutiqueController.php';
    $controller = new BoutiqueController();
    $controller->index();
});

// Page Solutions
$router->get('/solutions', function() {
    require_once __DIR__ . '/../app/Controllers/SolutionController.php';
    $controller = new SolutionController();
    $controller->index();
});

// Page Solution (redirection vers /solutions)
$router->get('/solution', function() {
    header('Location: /solutions');
    exit;
});

// Page À propos
$router->get('/a-propos', function() {
    require_once __DIR__ . '/../app/Controllers/AboutController.php';
    $controller = new AboutController();
    $controller->index();
});

// Page Services
$router->get('/services', function() {
    require_once __DIR__ . '/../app/Controllers/ServicesController.php';
    $controller = new ServicesController();
    $controller->index();
});

// Page Catalogue
$router->get('/catalogue', function() {
    require_once __DIR__ . '/../app/Controllers/CatalogueController.php';
    $controller = new CatalogueController();
    $controller->index();
});

// Page Portfolio
$router->get('/portfolio', function() {
    require_once __DIR__ . '/../templates/portfolio.php';
});

// Page Équipe
$router->get('/equipe', function() {
    require_once __DIR__ . '/../templates/team.php';
});

// Page Contact
$router->get('/contact', function() {
    require_once __DIR__ . '/../app/Controllers/ContactController.php';
    $controller = new ContactController();
    $controller->index();
});

// Page Support
$router->get('/support', function() {
    require_once __DIR__ . '/../app/Controllers/SupportController.php';
    $controller = new SupportController();
    $controller->index();
});

// Page Tarifs
$router->get('/tarifs', function() {
    require_once __DIR__ . '/../app/Controllers/TarifsController.php';
    $controller = new TarifsController();
    $controller->index();
});

// Page Outils
$router->get('/outils', function() {
    require_once __DIR__ . '/../app/Controllers/OutilsController.php';
    $controller = new OutilsController();
    $controller->index();
});

// Page Formation (redirection vers /formations)
$router->get('/formation', function() {
    header('Location: /formations');
    exit();
});

// ==================== PAGES LÉGALES ====================

// Mentions légales
$router->get('/mentions-legales', function() {
    require_once __DIR__ . '/../app/Controllers/LegalController.php';
    $controller = new LegalController();
    $controller->mentionsLegales();
});

// Politique de confidentialité
$router->get('/politique-confidentialite', function() {
    require_once __DIR__ . '/../app/Controllers/LegalController.php';
    $controller = new LegalController();
    $controller->politiqueConfidentialite();
});

// Conditions générales (CGU/CGV)
$router->get('/conditions-generales', function() {
    require_once __DIR__ . '/../app/Controllers/LegalController.php';
    $controller = new LegalController();
    $controller->conditionsGenerales();
});

// Politique des cookies
$router->get('/cookies', function() {
    require_once __DIR__ . '/../app/Controllers/LegalController.php';
    $controller = new LegalController();
    $controller->cookies();
});

// Page Connexion
$router->get('/connexion', function() {
    require_once __DIR__ . '/../app/Controllers/AuthController.php';
    $controller = new AuthController();
    $controller->showLogin();
});

$router->post('/connexion', function() {
    require_once __DIR__ . '/../app/Controllers/AuthController.php';
    $controller = new AuthController();
    $controller->login();
});

// Page Inscription
$router->get('/inscription', function() {
    require_once __DIR__ . '/../app/Controllers/AuthController.php';
    $controller = new AuthController();
    $controller->showRegister();
});

$router->post('/inscription', function() {
    require_once __DIR__ . '/../app/Controllers/AuthController.php';
    $controller = new AuthController();
    $controller->register();
});

// ========================================
// ROUTES ADMIN (Architecture MVC)
// ========================================

// Dashboard Admin
$router->get('/admin/dashboard', function() {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->dashboard();
});

// Gestion des contacts
$router->get('/admin/contacts', function() {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->contacts();
});

// Marquer un contact comme lu
$router->get('/admin/contacts/read', function() {
    $id = $_GET['id'] ?? null;
    if ($id) {
        require_once __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->markContactAsRead($id);
    }
});

// Marquer un contact comme répondu
$router->get('/admin/contacts/replied', function() {
    $id = $_GET['id'] ?? null;
    if ($id) {
        require_once __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->markContactAsReplied($id);
    }
});

// Gestion des newsletters
$router->get('/admin/newsletters', function() {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->newsletters();
});

// Exporter les newsletters
$router->get('/admin/newsletters/export', function() {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->exportNewsletters();
});

// Déconnexion
$router->get('/admin/logout', function() {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->logout();
});

// Gestion des webhooks
$router->get('/admin/webhooks', function() {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->webhooks();
});

$router->post('/admin/webhooks/save', function() {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->saveWebhooks();
});

$router->post('/admin/webhooks/test/:type', function($type) {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->testWebhook($type);
});

// ========== ADMIN ARTICLES ==========
// Liste des articles
$router->get('/admin/articles', function() {
    require_once __DIR__ . '/../app/Controllers/AdminArticleController.php';
    $controller = new AdminArticleController();
    $controller->index();
});

// Créer un article (formulaire)
$router->get('/admin/articles/new', function() {
    require_once __DIR__ . '/../app/Controllers/AdminArticleController.php';
    $controller = new AdminArticleController();
    $controller->create();
});

// Sauvegarder un nouvel article
$router->post('/admin/articles/store', function() {
    require_once __DIR__ . '/../app/Controllers/AdminArticleController.php';
    $controller = new AdminArticleController();
    $controller->store();
});

// Éditer un article (formulaire)
$router->get('/admin/articles/edit/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminArticleController.php';
    $controller = new AdminArticleController();
    $controller->edit($id);
});

// Mettre à jour un article
$router->post('/admin/articles/update/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminArticleController.php';
    $controller = new AdminArticleController();
    $controller->update($id);
});

// Supprimer un article
$router->post('/admin/articles/delete/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminArticleController.php';
    $controller = new AdminArticleController();
    $controller->delete($id);
});

// Upload d'image (AJAX pour TinyMCE)
$router->post('/admin/articles/upload-image', function() {
    require_once __DIR__ . '/../app/Controllers/AdminArticleController.php';
    $controller = new AdminArticleController();
    $controller->uploadImage();
});

// ========== ADMIN FORMATIONS ==========
// Liste des formations
$router->get('/admin/formations', function() {
    require_once __DIR__ . '/../app/Controllers/AdminFormationController.php';
    $controller = new AdminFormationController();
    $controller->index();
});

// Créer une formation (formulaire)
$router->get('/admin/formations/new', function() {
    require_once __DIR__ . '/../app/Controllers/AdminFormationController.php';
    $controller = new AdminFormationController();
    $controller->create();
});

// Sauvegarder une nouvelle formation
$router->post('/admin/formations/store', function() {
    require_once __DIR__ . '/../app/Controllers/AdminFormationController.php';
    $controller = new AdminFormationController();
    $controller->store();
});

// Éditer une formation (formulaire)
$router->get('/admin/formations/edit/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminFormationController.php';
    $controller = new AdminFormationController();
    $controller->edit($id);
});

// Mettre à jour une formation
$router->post('/admin/formations/update/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminFormationController.php';
    $controller = new AdminFormationController();
    $controller->update($id);
});

// Supprimer une formation
$router->post('/admin/formations/delete/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminFormationController.php';
    $controller = new AdminFormationController();
    $controller->delete($id);
});

// ========== ADMIN MÉDIAS ==========
// Bibliothèque de médias
$router->get('/admin/media', function() {
    require_once __DIR__ . '/../app/Controllers/AdminMediaController.php';
    $controller = new AdminMediaController();
    $controller->index();
});

// Upload de média
$router->post('/admin/media/upload', function() {
    require_once __DIR__ . '/../app/Controllers/AdminMediaController.php';
    $controller = new AdminMediaController();
    $controller->upload();
});

// Supprimer un média
$router->post('/admin/media/delete', function() {
    require_once __DIR__ . '/../app/Controllers/AdminMediaController.php';
    $controller = new AdminMediaController();
    $controller->delete();
});

// ========== ADMIN ANALYTICS ==========
$router->get('/admin/analytics', function() {
    require_once __DIR__ . '/../app/Controllers/AnalyticsController.php';
    $controller = new AnalyticsController();
    $controller->index();
});

// ========== ADMIN PROJETS ==========
// Liste / Pipeline Kanban
$router->get('/admin/projects', function() {
    require_once __DIR__ . '/../app/Controllers/AdminProjectController.php';
    $controller = new AdminProjectController();
    $controller->index();
});

// Détail projet admin
$router->get('/admin/projects/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminProjectController.php';
    $controller = new AdminProjectController();
    $controller->show($id);
});

// Mettre à jour le statut
$router->post('/admin/projects/:id/status', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminProjectController.php';
    $controller = new AdminProjectController();
    $controller->updateStatus($id);
});

// Envoyer un message admin
$router->post('/admin/projects/:id/message', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminProjectController.php';
    $controller = new AdminProjectController();
    $controller->sendMessage($id);
});

// Notes admin
$router->post('/admin/projects/:id/note', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminProjectController.php';
    $controller = new AdminProjectController();
    $controller->addNote($id);
});

// Lancer génération Webox
$router->post('/admin/projects/:id/generate', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminProjectController.php';
    $controller = new AdminProjectController();
    $controller->generateWebox($id);
});

// Ajouter une tâche
$router->post('/admin/projects/:id/task', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminProjectController.php';
    $controller = new AdminProjectController();
    $controller->addTask($id);
});

// Mettre à jour une tâche (AJAX)
$router->post('/admin/projects/task/update', function() {
    require_once __DIR__ . '/../app/Controllers/AdminProjectController.php';
    $controller = new AdminProjectController();
    $controller->updateTask();
});

// Mettre à jour le prix
$router->post('/admin/projects/:id/price', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminProjectController.php';
    $controller = new AdminProjectController();
    $controller->updatePrice($id);
});

// Gestion des campagnes
$router->get('/admin/campaigns', function() {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->campaigns();
});

$router->get('/admin/campaigns/new', function() {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->newCampaign();
});

$router->post('/admin/campaigns/delete/:id', function($id) {
    require_once __DIR__ . '/../app/Controllers/AdminController.php';
    $controller = new AdminController();
    $controller->deleteCampaign($id);
});

// Page 404
$router->setNotFound(function() {
    http_response_code(404);
    echo 'Page non trouvée';
});

// Résolution de la route
$router->resolve();