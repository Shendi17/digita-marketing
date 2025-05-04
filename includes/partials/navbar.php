<?php
// Détection plus robuste de la page d'accueil
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/');
$homeUris = ['', '/', '/index.php', '/digita-marketing', '/digita-marketing/index.php'];
$navbarBg = in_array($uri, $homeUris) ? 'bg-white' : 'bg-white'; // Toujours blanc pour la navigation fixe
?>
<nav class="navbar navbar-expand-lg navbar-light <?= $navbarBg ?> fixed-top shadow-sm" style="top:0;z-index:1100;">
  <div class="container-fluid px-5">
    <a class="navbar-brand d-flex align-items-center" href="/digita-marketing/#hero">
      <img src="/digita-marketing/assets/images/logo.png" alt="Digita Logo" width="256.6" height="59.3" class="me-2">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="#logos">Logos</a></li>
        <li class="nav-item"><a class="nav-link" href="#videos">Vidéos</a></li>
        <li class="nav-item"><a class="nav-link" href="#tunnel">Tunnel De Vente</a></li>
        <li class="nav-item"><a class="nav-link" href="#vitrine">Site Vitrine</a></li>
        <li class="nav-item"><a class="nav-link" href="#ecommerce">Site E-Commerce</a></li>
        <li class="nav-item"><a class="nav-link" href="#management">Management Social</a></li>
        <li class="nav-item"><a class="nav-link" href="#seo">SEO</a></li>
        <li class="nav-item"><a class="nav-link" href="#publicite">Publicité</a></li>
        <li class="nav-item"><a class="nav-link" href="#projet">Projet personnalisé</a></li>
        <li class="nav-item"><a class="nav-link" href="#ia">IA</a></li>
      </ul>
      <!-- Bouton menu latéral agence -->
      <button class="btn btn-outline-dark ms-3 d-flex align-items-center" style="border-radius:50%;width:44px;height:44px;" onclick="ouvrirSidebarAgence()" title="Menu Agence">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#d4af37" viewBox="0 0 24 24"><rect width="24" height="4" y="4" rx="2"/><rect width="24" height="4" y="10" rx="2"/><rect width="24" height="4" y="16" rx="2"/></svg>
      </button>
    </div>
  </div>
</nav>
