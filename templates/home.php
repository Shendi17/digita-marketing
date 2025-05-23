<?php
// Page d'accueil Digita Marketing - version refactorisée
$pageTitle = 'Accueil';
$extraCss = ['/digita-marketing/assets/css/home.css'];
ob_start();
?>
<!-- HERO avec fond premium et effet particules/lignes -->
<section id="hero" class="d-flex flex-column justify-content-center align-items-center hero-bg position-relative scroll-offset p-0 m-0" style="width:100vw;max-width:100vw;">
  <?php require_once __DIR__ . '/../includes/partials/hero-template-particles.php'; ?>
</section>

<!-- SUPPRESSION du séparateur SVG, ajout simple d'espace -->
<div style="height: 48px; width: 100vw;"></div>

<!-- SECTION LOGOS (harmonisée, moderne, cartes)-->
<section id="logos" class="scroll-offset py-5 position-relative bg-white">
  <div class="container position-relative">
    <?php require_once __DIR__ . '/../includes/partials/logos.php'; ?>
  </div>
</section>

<!-- SECTION VIDEOS -->
<section id="videos" class="scroll-offset py-5 position-relative bg-white parallax">
  <div class="container position-relative">
    <?php require_once __DIR__ . '/../includes/partials/services/videos.php'; ?>
  </div>
</section>

<!-- SECTION TUNNEL DE VENTE -->
<section id="tunnel" class="scroll-offset py-5 position-relative bg-alt">
  <div class="container position-relative">
    <?php require_once __DIR__ . '/../includes/partials/services/tunnel.php'; ?>
  </div>
</section>

<!-- SECTION VITRINE -->
<section id="vitrine" class="scroll-offset py-5 position-relative bg-white parallax">
  <div class="container position-relative">
    <?php require_once __DIR__ . '/../includes/partials/services/vitrine.php'; ?>
  </div>
</section>

<!-- SECTION ECOMMERCE -->
<section id="ecommerce" class="scroll-offset py-5 position-relative bg-alt">
  <div class="container position-relative">
    <?php require_once __DIR__ . '/../includes/partials/services/ecommerce.php'; ?>
  </div>
</section>

<!-- SECTION MANAGEMENT SOCIAL -->
<section id="management" class="scroll-offset py-5 position-relative bg-white parallax">
  <div class="container position-relative">
    <?php require_once __DIR__ . '/../includes/partials/services/management.php'; ?>
  </div>
</section>

<!-- SECTION SEO -->
<section id="seo" class="scroll-offset py-5 position-relative bg-alt">
  <div class="container position-relative">
    <?php require_once __DIR__ . '/../includes/partials/seo.php'; ?>
  </div>
</section>

<!-- SECTION PUBLICITE -->
<section id="publicite" class="scroll-offset py-5 position-relative bg-white parallax">
  <div class="container position-relative">
    <?php require_once __DIR__ . '/../includes/partials/services/publicite.php'; ?>
  </div>
</section>

<!-- SECTION PROJET PERSONNALISÉ -->
<section id="projet" class="scroll-offset py-5 position-relative bg-alt">
  <div class="container position-relative">
    <?php require_once __DIR__ . '/../includes/partials/projet.php'; ?>
  </div>
</section>

<!-- SECTION IA -->
<section id="ia" class="scroll-offset py-5 position-relative bg-white parallax">
  <div class="container position-relative">
    <?php require_once __DIR__ . '/../includes/partials/services/ia.php'; ?>
  </div>
</section>

<?php // JS Spécifique home (sera injecté dynamiquement si besoin)
$extraJs = [
    'https://unpkg.com/aos@2.3.1/dist/aos.js',
    '/digita-marketing/assets/js/main.js'
];
?>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
