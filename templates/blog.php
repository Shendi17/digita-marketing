<?php
$pageTitle = 'Blog - Digita Marketing';
$extraCss = ['/assets/css/blog.css'];
ob_start();
?>

<!-- Hero Section -->
<section class="py-5 bg-primary text-white">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">Blog Digita Marketing</h1>
        <p class="lead mb-0">Actualités & conseils</p>
      </div>
    </div>
  </div>
</section>

<!-- Blog Grid -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-8 text-center" data-aos="fade-up">
        <h2 class="mb-4">Nos Derniers Articles</h2>
        <p class="text-muted">Découvrez nos conseils, actualités et tendances du marketing digital</p>
      </div>
    </div>

    <div class="row g-4">
      <!-- Article 1 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <article class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-lightbulb fs-1 text-primary"></i>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <span class="badge bg-primary me-2">Marketing Digital</span>
              <small class="text-muted">15 Oct 2025</small>
            </div>
            <h5 class="card-title">10 Tendances du Marketing Digital en 2025</h5>
            <p class="card-text text-muted">Découvrez les tendances incontournables qui vont façonner le marketing digital cette année : IA, personnalisation, vidéo courte...</p>
            <a href="#" class="btn btn-outline-primary btn-sm">Lire la suite <i class="bi bi-arrow-right"></i></a>
          </div>
        </article>
      </div>

      <!-- Article 2 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <article class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-search fs-1 text-success"></i>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <span class="badge bg-success me-2">SEO</span>
              <small class="text-muted">10 Oct 2025</small>
            </div>
            <h5 class="card-title">Comment Optimiser Votre SEO en 2025</h5>
            <p class="card-text text-muted">Guide complet pour améliorer votre référencement naturel : techniques on-page, netlinking, contenu de qualité et Core Web Vitals...</p>
            <a href="#" class="btn btn-outline-success btn-sm">Lire la suite <i class="bi bi-arrow-right"></i></a>
          </div>
        </article>
      </div>

      <!-- Article 3 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <article class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-people fs-1 text-warning"></i>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <span class="badge bg-warning me-2">Réseaux Sociaux</span>
              <small class="text-muted">5 Oct 2025</small>
            </div>
            <h5 class="card-title">Stratégie Social Media : Les Clés du Succès</h5>
            <p class="card-text text-muted">Apprenez à créer une stratégie social media efficace : choix des plateformes, calendrier éditorial, engagement communautaire...</p>
            <a href="#" class="btn btn-outline-warning btn-sm">Lire la suite <i class="bi bi-arrow-right"></i></a>
          </div>
        </article>
      </div>

      <!-- Article 4 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <article class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-megaphone fs-1 text-danger"></i>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <span class="badge bg-danger me-2">Publicité</span>
              <small class="text-muted">1 Oct 2025</small>
            </div>
            <h5 class="card-title">Google Ads : Maximiser Votre ROI</h5>
            <p class="card-text text-muted">Conseils pratiques pour optimiser vos campagnes Google Ads : ciblage, enchères, quality score et conversion tracking...</p>
            <a href="#" class="btn btn-outline-danger btn-sm">Lire la suite <i class="bi bi-arrow-right"></i></a>
          </div>
        </article>
      </div>

      <!-- Article 5 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
        <article class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-brush fs-1 text-info"></i>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <span class="badge bg-info me-2">Design</span>
              <small class="text-muted">25 Sep 2025</small>
            </div>
            <h5 class="card-title">Créer une Identité Visuelle Forte</h5>
            <p class="card-text text-muted">Les étapes essentielles pour développer une identité visuelle cohérente et mémorable pour votre marque...</p>
            <a href="#" class="btn btn-outline-info btn-sm">Lire la suite <i class="bi bi-arrow-right"></i></a>
          </div>
        </article>
      </div>

      <!-- Article 6 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
        <article class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-img-top bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
            <i class="bi bi-cpu fs-1 text-secondary"></i>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <span class="badge bg-secondary me-2">IA</span>
              <small class="text-muted">20 Sep 2025</small>
            </div>
            <h5 class="card-title">L'IA au Service du Marketing Digital</h5>
            <p class="card-text text-muted">Comment l'intelligence artificielle révolutionne le marketing : chatbots, personnalisation, analyse prédictive...</p>
            <a href="#" class="btn btn-outline-secondary btn-sm">Lire la suite <i class="bi bi-arrow-right"></i></a>
          </div>
        </article>
      </div>
    </div>

    <!-- Pagination -->
    <div class="row mt-5">
      <div class="col-12">
        <nav aria-label="Blog pagination">
          <ul class="pagination justify-content-center">
            <li class="page-item disabled">
              <a class="page-link" href="#" tabindex="-1">Précédent</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Suivant</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</section>

<!-- Newsletter -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 text-center" data-aos="fade-up">
        <i class="bi bi-envelope fs-1 text-primary mb-3"></i>
        <h3 class="mb-3">Restez Informé</h3>
        <p class="text-muted mb-4">Inscrivez-vous à notre newsletter pour recevoir nos derniers articles et conseils directement dans votre boîte mail.</p>
        <form class="row g-2">
          <div class="col-md-8">
            <input type="email" class="form-control" placeholder="Votre adresse email" required>
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
