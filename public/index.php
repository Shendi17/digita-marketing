<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/digita-marketing/connexion') {
    require_once __DIR__ . '/../connexion.php';
    exit;
}
echo '<div style="background:lime;padding:8px;font-weight:bold;">DASHBOARD.PHP INCLUS !</div>';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/Router.php';

$router = new Router();

// Page d'accueil
$router->get('/', function() {
    require_once __DIR__ . '/../templates/home.php';
});

// Page Blog
$router->get('/blog', function() {
    require_once __DIR__ . '/../templates/blog.php';
});
// Page Boutique
$router->get('/boutique', function() {
    require_once __DIR__ . '/../templates/boutique.php';
});

// Page Solution
$router->get('/solution', function() {
    require_once __DIR__ . '/../templates/solution.php';
});

// Page À propos
$router->get('/a-propos', function() {
    require_once __DIR__ . '/../templates/about.php';
});

// Page Services
$router->get('/services', function() {
    require_once __DIR__ . '/../templates/services.php';
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
    require_once __DIR__ . '/../templates/contact.php';
});

// Page Support
$router->get('/support', function() {
    require_once __DIR__ . '/../templates/support.php';
});

// Page Tarifs
$router->get('/tarifs', function() {
    require_once __DIR__ . '/../templates/tarifs.php';
});

// Page Connexion
$router->get('/connexion', function() {
    require_once __DIR__ . '/../connexion.php';
});

// Page Inscription
$router->get('/inscription', function() {
    require_once __DIR__ . '/../inscription.php';
});

// Page Dashboard Admin
$router->get('/admin/dashboard', function() {
    require_once __DIR__ . '/../public/admin/dashboard.php';
});

// Page 404
$router->setNotFound(function() {
    http_response_code(404);
    echo 'Page non trouvée';
});

// Résolution de la route
$router->resolve();