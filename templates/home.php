<?php
// Template de la page d'accueil
require_once __DIR__ . '/../includes/header.php';
?>

<!-- HERO avec fond premium et effet SVG -->
<section id="hero" class="d-flex flex-column justify-content-center align-items-center hero-bg position-relative scroll-offset" style="min-height: 100vh; background: linear-gradient(120deg, #232526 0%, #2563eb 100%); overflow:hidden;">
  <svg viewBox="0 0 1440 320" style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:0;opacity:0.08;pointer-events:none;"><path fill="#fff" fill-opacity="1" d="M0,96L48,101.3C96,107,192,117,288,138.7C384,160,480,192,576,181.3C672,171,768,117,864,122.7C960,128,1056,192,1152,213.3C1248,235,1344,213,1392,202.7L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/hero.php'; ?>
  </div>
</section>

<!-- SECTION LOGOS -->
<section id="logos" class="scroll-offset py-5 position-relative bg-alt" style="background: linear-gradient(135deg, #232526 0%, #FFD700 100%); overflow:hidden;">
  <svg viewBox="0 0 1440 80" style="position:absolute;top:0;left:0;width:100%;height:80px;z-index:0;opacity:0.08;pointer-events:none;"><path fill="#FFD700" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,64C672,53,768,43,864,48C960,53,1056,75,1152,69.3C1248,64,1344,32,1392,16L1440,0L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path></svg>
  <div class="container position-relative" style="z-index:1;">
    <div class="text-center">
      <div class="mx-auto mb-4" style="display:inline-block;background:rgba(255,255,255,0.9);border-radius:50%;box-shadow:0 6px 32px rgba(0,0,0,0.12);padding:2.2rem;">
        <img src="/digita-marketing/assets/images/identite/logo.png" alt="Logo Digita" style="height:110px;width:auto;filter:drop-shadow(0 6px 18px #d4af37a0);">
      </div>
      <h2 class="fw-bold d-flex align-items-center justify-content-center" style="color:#232323;letter-spacing:2px;font-size:2.4rem;gap:0.5em;">
        <i class="fas fa-crown" style="color:#FFD700;font-size:2rem;"></i>
        DIGITA
      </h2>
      <p class="lead text-dark mb-3" style="font-size:1.4rem;">Votre partenaire en marketing digital innovant</p>
      <span class="badge rounded-pill shadow-lg" style="background:rgba(35,37,38,0.92);color:#FFD700;font-size:1.1rem;padding:0.7em 1.4em;box-shadow:0 2px 8px #23252644;">
        <i class="fas fa-star me-2"></i>Identité visuelle forte & créative
      </span>
    </div>
  </div>
</section>

<!-- SECTION VIDEOS -->
<section id="videos" class="scroll-offset py-5 position-relative bg-white parallax" style="background-image:url('/assets/images/hero-bg.svg'); background-position:center 80px;overflow:hidden;">
  <svg viewBox="0 0 1440 80" style="position:absolute;top:0;left:0;width:100%;height:80px;z-index:0;opacity:0.09;pointer-events:none;"><path fill="#2563eb" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,64C672,53,768,43,864,48C960,53,1056,75,1152,69.3C1248,64,1344,32,1392,16L1440,0L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path></svg>
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/services.php'; ?>
  </div>
</section>

<!-- SECTION TUNNEL DE VENTE -->
<section id="tunnel" class="scroll-offset py-5 position-relative bg-alt" style="background:linear-gradient(120deg, #f7f7f7 60%, #2563eb11 100%);overflow:hidden;">
  <svg viewBox="0 0 1440 80" style="position:absolute;top:0;left:0;width:100%;height:80px;z-index:0;opacity:0.08;pointer-events:none;"><path fill="#FFD700" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,64C672,53,768,43,864,48C960,53,1056,75,1152,69.3C1248,64,1344,32,1392,16L1440,0L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path></svg>
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/about.php'; ?>
  </div>
</section>

<!-- SECTION VITRINE -->
<section id="vitrine" class="scroll-offset py-5 position-relative bg-white parallax" style="background-image:url('/assets/images/hero-bg.svg'); background-position:center 180px;overflow:hidden;">
  <svg viewBox="0 0 1440 80" style="position:absolute;top:0;left:0;width:100%;height:80px;z-index:0;opacity:0.07;pointer-events:none;"><path fill="#2563eb" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,64C672,53,768,43,864,48C960,53,1056,75,1152,69.3C1248,64,1344,32,1392,16L1440,0L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path></svg>
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/portfolio.php'; ?>
  </div>
</section>

<!-- SECTION ECOMMERCE -->
<section id="ecommerce" class="scroll-offset py-5 position-relative bg-alt" style="background:linear-gradient(120deg, #f7f7f7 60%, #FFD70011 100%);overflow:hidden;">
  <svg viewBox="0 0 1440 80" style="position:absolute;top:0;left:0;width:100%;height:80px;z-index:0;opacity:0.08;pointer-events:none;"><path fill="#FFD700" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,64C672,53,768,43,864,48C960,53,1056,75,1152,69.3C1248,64,1344,32,1392,16L1440,0L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path></svg>
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/team.php'; ?>
  </div>
</section>

<!-- SECTION MANAGEMENT SOCIAL -->
<section id="management" class="scroll-offset py-5 position-relative bg-white parallax" style="background-image:url('/assets/images/hero-bg.svg'); background-position:center 280px;overflow:hidden;">
  <svg viewBox="0 0 1440 80" style="position:absolute;top:0;left:0;width:100%;height:80px;z-index:0;opacity:0.07;pointer-events:none;"><path fill="#2563eb" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,64C672,53,768,43,864,48C960,53,1056,75,1152,69.3C1248,64,1344,32,1392,16L1440,0L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path></svg>
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/partials/contact.php'; ?>
  </div>
</section>

<!-- SECTION SEO -->
<?php require_once __DIR__ . '/../includes/partials/seo.php'; ?>

<!-- SECTION PUBLICITE -->
<section id="publicite" class="scroll-offset py-5 position-relative bg-alt" style="background:linear-gradient(120deg, #f7f7f7 60%, #2563eb11 100%);overflow:hidden;">
  <svg viewBox="0 0 1440 80" style="position:absolute;top:0;left:0;width:100%;height:80px;z-index:0;opacity:0.08;pointer-events:none;"><path fill="#2563eb" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,64C672,53,768,43,864,48C960,53,1056,75,1152,69.3C1248,64,1344,32,1392,16L1440,0L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path></svg>
  <div class="container position-relative" style="z-index:1;">
    <!-- Suppression de l'inclusion du menu latéral dans la section principale -->
  </div>
</section>

<!-- SECTION PROJET PERSONNALISÉ -->
<?php require_once __DIR__ . '/../includes/partials/projet.php'; ?>

<!-- SECTION IA -->
<section id="ia" class="scroll-offset py-5 position-relative bg-white parallax" style="background-image:url('/assets/images/hero-bg.svg'); background-position:center 380px;overflow:hidden;">
  <svg viewBox="0 0 1440 80" style="position:absolute;top:0;left:0;width:100%;height:80px;z-index:0;opacity:0.07;pointer-events:none;"><path fill="#FFD700" fill-opacity="1" d="M0,32L48,42.7C96,53,192,75,288,80C384,85,480,75,576,64C672,53,768,43,864,48C960,53,1056,75,1152,69.3C1248,64,1344,32,1392,16L1440,0L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path></svg>
  <div class="container position-relative" style="z-index:1;">
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
  </div>
</section>

<!-- Initialisation AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 700, once: true });</script>

<!-- Force l'inclusion du JS animé en toute fin de page -->
<script src="/digita-marketing/assets/js/main.js"></script>
</body>
</html>
