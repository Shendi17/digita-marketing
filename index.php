<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/Router.php';

$router = new Router();

// Page d'accueil
$router->get('/', function() {
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    require_once __DIR__ . '/includes/hero.php';
    require_once __DIR__ . '/includes/services.php';
    require_once __DIR__ . '/includes/about.php';
    require_once __DIR__ . '/includes/portfolio.php';
    require_once __DIR__ . '/includes/team.php';
    require_once __DIR__ . '/includes/contact.php';
    require_once __DIR__ . '/includes/footer.php';
});

// Page À propos
$router->get('/a-propos', function() {
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    require_once __DIR__ . '/pages/about.php';
    require_once __DIR__ . '/includes/footer.php';
});

// Page Services
$router->get('/services', function() {
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    require_once __DIR__ . '/pages/services.php';
    require_once __DIR__ . '/includes/footer.php';
});

// Page Portfolio
$router->get('/portfolio', function() {
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    require_once __DIR__ . '/pages/portfolio.php';
    require_once __DIR__ . '/includes/footer.php';
});

// Page Équipe
$router->get('/equipe', function() {
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    require_once __DIR__ . '/pages/team.php';
    require_once __DIR__ . '/includes/footer.php';
});

// Page Contact
$router->get('/contact', function() {
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    require_once __DIR__ . '/pages/contact.php';
    require_once __DIR__ . '/includes/footer.php';
});

// Page Support
$router->get('/support', function() {
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    require_once __DIR__ . '/pages/support.php';
    require_once __DIR__ . '/includes/footer.php';
});

// Page Tarifs
$router->get('/tarifs', function() {
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    require_once __DIR__ . '/pages/tarifs.php';
    require_once __DIR__ . '/includes/footer.php';
});

// Page Blog
$router->get('/blog', function() {
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    require_once __DIR__ . '/pages/blog.php';
    require_once __DIR__ . '/includes/footer.php';
});

// Page Boutique
$router->get('/boutique', function() {
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    require_once __DIR__ . '/pages/boutique.php';
    require_once __DIR__ . '/includes/footer.php';
});

// Page Solution
$router->get('/solution', function() {
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    require_once __DIR__ . '/pages/solution.php';
    require_once __DIR__ . '/includes/footer.php';
});

// Page 404
$router->setNotFound(function() {
    http_response_code(404);
    require_once __DIR__ . '/includes/header.php';
    require_once __DIR__ . '/includes/navbar.php';
    echo '<div class="container py-5">
            <h1>Page non trouvée</h1>
            <p>La page que vous recherchez n\'existe pas.</p>
            <a href="' . SITE_URL . '" class="btn btn-primary">Retour à l\'accueil</a>
          </div>';
    require_once __DIR__ . '/includes/footer.php';
});

// Résolution de la route
$router->resolve();