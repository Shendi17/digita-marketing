<?php
// Page Formation - Formations et accompagnement
$pageTitle = 'Formation';
$extraCss = [];
ob_start();
?>

<!-- HERO SECTION -->
<section class="hero-section bg-primary bg-gradient text-white py-5">
  <div class="container py-5">
    <div class="row align-items-center">
      <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">Formation & Accompagnement</h1>
        <p class="lead mb-4">Développez vos compétences digitales avec nos formations professionnelles.</p>
        <a href="#formations" class="btn btn-light btn-lg me-2">Voir les formations</a>
        <a href="/contact" class="btn btn-outline-light btn-lg">Demander un devis</a>
      </div>
    </div>
  </div>
</section>

<!-- SECTION AVANTAGES -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-4 mb-5">
      <div class="col-md-3" data-aos="fade-up">
        <div class="text-center">
          <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
            <i class="bi bi-award fs-1 text-primary"></i>
          </div>
          <h5>Formateurs Experts</h5>
          <p class="text-muted small">+10 ans d'expérience</p>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up">
        <div class="text-center">
          <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
            <i class="bi bi-laptop fs-1 text-primary"></i>
          </div>
          <h5>100% Pratique</h5>
          <p class="text-muted small">Exercices concrets</p>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up">
        <div class="text-center">
          <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
            <i class="bi bi-patch-check fs-1 text-primary"></i>
          </div>
          <h5>Certification</h5>
          <p class="text-muted small">Certificat inclus</p>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up">
        <div class="text-center">
          <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
            <i class="bi bi-headset fs-1 text-primary"></i>
          </div>
          <h5>Support Continu</h5>
          <p class="text-muted small">Accompagnement après</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION FORMATIONS -->
<section id="formations" class="py-5">
  <div class="container">
    <h2 class="text-center mb-5" data-aos="fade-up">Nos Formations</h2>

    <!-- Réseaux Sociaux -->
    <div class="mb-5" data-aos="fade-up">
      <h3 class="mb-4"><i class="bi bi-people-fill text-primary me-3"></i>Réseaux Sociaux</h3>
      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <span class="badge bg-success">Débutant</span>
                <span class="badge bg-primary">1 jour</span>
              </div>
              <h5>Community Management</h5>
              <p class="text-muted small mb-3">Gérez efficacement vos réseaux sociaux.</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="h5 text-primary mb-0">499€</span>
                <a href="/contact?formation=community" class="btn btn-outline-primary btn-sm">S'inscrire</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <span class="badge bg-warning text-dark">Intermédiaire</span>
                <span class="badge bg-primary">1 jour</span>
              </div>
              <h5>Social Media Ads</h5>
              <p class="text-muted small mb-3">Publicité sur Facebook, Instagram, LinkedIn.</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="h5 text-primary mb-0">599€</span>
                <a href="/contact?formation=social-ads" class="btn btn-outline-primary btn-sm">S'inscrire</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <span class="badge bg-success">Débutant</span>
                <span class="badge bg-primary">0.5 jour</span>
              </div>
              <h5>Création de Contenu</h5>
              <p class="text-muted small mb-3">Créez du contenu engageant.</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="h5 text-primary mb-0">299€</span>
                <a href="/contact?formation=contenu" class="btn btn-outline-primary btn-sm">S'inscrire</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SEO & Marketing -->
    <div class="mb-5" data-aos="fade-up">
      <h3 class="mb-4"><i class="bi bi-search text-primary me-3"></i>SEO & Marketing Digital</h3>
      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <span class="badge bg-success">Débutant</span>
                <span class="badge bg-primary">2 jours</span>
              </div>
              <h5>SEO Fondamentaux</h5>
              <p class="text-muted small mb-3">Maîtrisez le référencement naturel.</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="h5 text-primary mb-0">799€</span>
                <a href="/contact?formation=seo" class="btn btn-outline-primary btn-sm">S'inscrire</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <span class="badge bg-warning text-dark">Intermédiaire</span>
                <span class="badge bg-primary">1 jour</span>
              </div>
              <h5>Google Ads</h5>
              <p class="text-muted small mb-3">Créez des campagnes Google performantes.</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="h5 text-primary mb-0">599€</span>
                <a href="/contact?formation=google-ads" class="btn btn-outline-primary btn-sm">S'inscrire</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <span class="badge bg-success">Débutant</span>
                <span class="badge bg-primary">1 jour</span>
              </div>
              <h5>Email Marketing</h5>
              <p class="text-muted small mb-3">Campagnes email performantes.</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="h5 text-primary mb-0">499€</span>
                <a href="/contact?formation=email" class="btn btn-outline-primary btn-sm">S'inscrire</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Analytics -->
    <div class="mb-5" data-aos="fade-up">
      <h3 class="mb-4"><i class="bi bi-graph-up text-primary me-3"></i>Analytics & Data</h3>
      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <span class="badge bg-success">Débutant</span>
                <span class="badge bg-primary">1 jour</span>
              </div>
              <h5>Google Analytics 4</h5>
              <p class="text-muted small mb-3">Analysez vos performances web.</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="h5 text-primary mb-0">499€</span>
                <a href="/contact?formation=analytics" class="btn btn-outline-primary btn-sm">S'inscrire</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <span class="badge bg-danger">Expert</span>
                <span class="badge bg-primary">2 jours</span>
              </div>
              <h5>Marketing Analytics</h5>
              <p class="text-muted small mb-3">Optimisez vos performances marketing.</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="h5 text-primary mb-0">999€</span>
                <a href="/contact?formation=marketing-analytics" class="btn btn-outline-primary btn-sm">S'inscrire</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-3">
                <span class="badge bg-success">Débutant</span>
                <span class="badge bg-primary">0.5 jour</span>
              </div>
              <h5>Canva Pro</h5>
              <p class="text-muted small mb-3">Créez des visuels professionnels.</p>
              <div class="d-flex justify-content-between align-items-center">
                <span class="h5 text-primary mb-0">199€</span>
                <a href="/contact?formation=canva" class="btn btn-outline-primary btn-sm">S'inscrire</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA -->
    <div class="text-center py-5" data-aos="fade-up">
      <div class="bg-primary bg-opacity-10 rounded p-5">
        <h3 class="mb-3">Formation sur-mesure ?</h3>
        <p class="lead mb-4">Nous créons des programmes adaptés à vos besoins.</p>
        <a href="/contact" class="btn btn-primary btn-lg">Contactez-nous</a>
      </div>
    </div>

  </div>
</section>

<?php
$extraJs = [
    'https://unpkg.com/aos@2.3.1/dist/aos.js',
    '/assets/js/main.js'
];
?>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
