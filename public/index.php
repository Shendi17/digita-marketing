<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/Router.php';

$router = new Router();

// Page d'accueil
$router->get('/', function() {
    require_once __DIR__ . '/../templates/home.php';
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

// Page 404
$router->setNotFound(function() {
    http_response_code(404);
    echo 'Page non trouvée';
});

// Résolution de la route
$router->resolve();