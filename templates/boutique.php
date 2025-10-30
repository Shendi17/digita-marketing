<?php
$pageTitle = 'Boutique - Digita Marketing';
$extraCss = ['/assets/css/boutique.css'];
ob_start();
?>

<!-- Hero Section -->
<section class="py-5 bg-primary text-white">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">Boutique Digita</h1>
        <p class="lead mb-0">Produits & services</p>
      </div>
    </div>
  </div>
</section>

<!-- Products Grid -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-8 text-center" data-aos="fade-up">
        <h2 class="mb-4">Nos Produits & Services</h2>
        <p class="text-muted">Découvrez notre sélection de produits et services digitaux prêts à l'emploi</p>
      </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="d-flex flex-wrap gap-2 justify-content-center" data-aos="fade-up">
          <button class="btn btn-primary">Tous</button>
          <button class="btn btn-outline-primary">Templates</button>
          <button class="btn btn-outline-primary">Formations</button>
          <button class="btn btn-outline-primary">Outils</button>
          <button class="btn btn-outline-primary">Services</button>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Product 1 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-file-earmark-code fs-1 text-primary"></i>
          </div>
          <div class="card-body">
            <span class="badge bg-primary mb-2">Template</span>
            <h5 class="card-title">Template Site Vitrine Pro</h5>
            <p class="card-text text-muted">Template WordPress professionnel prêt à l'emploi pour site vitrine. Design moderne et responsive.</p>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <span class="h5 text-primary mb-0">299€</span>
              <button class="btn btn-outline-primary btn-sm">Acheter</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Product 2 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-book fs-1 text-success"></i>
          </div>
          <div class="card-body">
            <span class="badge bg-success mb-2">Formation</span>
            <h5 class="card-title">Formation SEO Complète</h5>
            <p class="card-text text-muted">Apprenez le référencement naturel de A à Z. 20h de vidéos + exercices pratiques + certificat.</p>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <span class="h5 text-success mb-0">499€</span>
              <button class="btn btn-outline-success btn-sm">Acheter</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Product 3 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-tools fs-1 text-warning"></i>
          </div>
          <div class="card-body">
            <span class="badge bg-warning mb-2">Outil</span>
            <h5 class="card-title">Pack Outils Marketing</h5>
            <p class="card-text text-muted">Suite complète d'outils marketing : planificateur, analytics, générateur de contenu, etc.</p>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <span class="h5 text-warning mb-0">99€/mois</span>
              <button class="btn btn-outline-warning btn-sm">Essayer</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Product 4 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-palette fs-1 text-danger"></i>
          </div>
          <div class="card-body">
            <span class="badge bg-danger mb-2">Template</span>
            <h5 class="card-title">Pack Templates Réseaux Sociaux</h5>
            <p class="card-text text-muted">100+ templates Canva pour Instagram, Facebook, LinkedIn. Formats stories, posts, carrousels.</p>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <span class="h5 text-danger mb-0">79€</span>
              <button class="btn btn-outline-danger btn-sm">Acheter</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Product 5 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-mortarboard fs-1 text-info"></i>
          </div>
          <div class="card-body">
            <span class="badge bg-info mb-2">Formation</span>
            <h5 class="card-title">Masterclass Google Ads</h5>
            <p class="card-text text-muted">Maîtrisez Google Ads et maximisez votre ROI. Cas pratiques + stratégies avancées.</p>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <span class="h5 text-info mb-0">399€</span>
              <button class="btn btn-outline-info btn-sm">Acheter</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Product 6 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-robot fs-1 text-secondary"></i>
          </div>
          <div class="card-body">
            <span class="badge bg-secondary mb-2">Service</span>
            <h5 class="card-title">Chatbot IA Personnalisé</h5>
            <p class="card-text text-muted">Chatbot intelligent sur-mesure pour votre site. Installation et configuration incluses.</p>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <span class="h5 text-secondary mb-0">1499€</span>
              <button class="btn btn-outline-secondary btn-sm">Commander</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center" data-aos="fade-up">
        <h3 class="mb-4">Besoin d'un Produit Sur-Mesure ?</h3>
        <p class="lead mb-4">Nous créons des solutions personnalisées adaptées à vos besoins spécifiques.</p>
        <a href="/contact" class="btn btn-primary btn-lg px-5">Nous contacter</a>
      </div>
    </div>
  </div>
</section>

<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
