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