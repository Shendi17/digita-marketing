<?php
require_once __DIR__ . '/../includes/header.php';
?>
<!-- HERO avec fond premium et effet particules/lignes -->
<section id="hero" class="d-flex flex-column justify-content-center align-items-center hero-bg position-relative scroll-offset" style="min-height: 100vh; background: #fff; overflow:hidden;">
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/hero-template-particles.php'; ?>
  </div>
</section>

<!-- SECTION LOGOS (harmonisée, moderne, cartes)-->
<section id="logos" class="scroll-offset py-5 position-relative bg-white" style="background: linear-gradient(135deg, #f7f7f7 0%, #fff 100%); overflow:hidden;">
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/logos.php'; ?>
  </div>
</section>

<!-- SECTION VIDEOS -->
<section id="videos" class="scroll-offset py-5 position-relative bg-white parallax" style="background-image:url('/digita-marketing/assets/images/hero-bg.svg'); background-position:center 80px;overflow:hidden;">
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/services/videos.php'; ?>
  </div>
</section>

<!-- SECTION TUNNEL DE VENTE -->
<section id="tunnel" class="scroll-offset py-5 position-relative bg-alt" style="background:linear-gradient(120deg, #f7f7f7 60%, #2563eb11 100%);overflow:hidden;">
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/services/tunnel.php'; ?>
  </div>
</section>

<!-- SECTION VITRINE -->
<section id="vitrine" class="scroll-offset py-5 position-relative bg-white parallax" style="background-image:url('/digita-marketing/assets/images/hero-bg.svg'); background-position:center 180px;overflow:hidden;">
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/services/vitrine.php'; ?>
  </div>
</section>

<!-- SECTION ECOMMERCE -->
<section id="ecommerce" class="scroll-offset py-5 position-relative bg-alt" style="background:linear-gradient(120deg, #f7f7f7 60%, #FFD70011 100%);overflow:hidden;">
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/services/ecommerce.php'; ?>
  </div>
</section>

<!-- SECTION MANAGEMENT SOCIAL -->
<section id="management" class="scroll-offset py-5 position-relative bg-white parallax" style="background-image:url('/digita-marketing/assets/images/hero-bg.svg'); background-position:center 280px;overflow:hidden;">
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/services/management.php'; ?>
  </div>
</section>

<!-- SECTION SEO -->
<section id="seo" class="scroll-offset py-5 position-relative bg-alt" style="background:linear-gradient(120deg, #f7f7f7 60%, #2563eb11 100%);overflow:hidden;">
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/seo.php'; ?>
  </div>
</section>

<!-- SECTION PUBLICITE -->
<section id="publicite" class="scroll-offset py-5 position-relative bg-white parallax" style="background-image:url('/digita-marketing/assets/images/hero-bg.svg'); background-position:center 320px;overflow:hidden;">
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/services/publicite.php'; ?>
  </div>
</section>

<!-- SECTION PROJET PERSONNALISÉ -->
<section id="projet" class="scroll-offset py-5 position-relative bg-alt" style="background:linear-gradient(120deg, #f7f7f7 60%, #FFD70011 100%);overflow:hidden;">
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/projet.php'; ?>
  </div>
</section>

<!-- SECTION IA -->
<section id="ia" class="scroll-offset py-5 position-relative bg-white parallax" style="background-image:url('/digita-marketing/assets/images/hero-bg.svg'); background-position:center 380px;overflow:hidden;">
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/services/ia.php'; ?>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
<!-- Initialisation AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 700, once: true });</script>
<!-- Force l'inclusion du JS animé en toute fin de page -->
<script src="/digita-marketing/assets/js/main.js"></script>
</body>
</html>
