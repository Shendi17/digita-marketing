<?php
// Page d'accueil Digita Marketing - version refactorisée
$pageTitle = 'Accueil';
$extraCss = ['/assets/css/home.css'];
ob_start();
?>
<!-- HERO avec fond premium et effet particules/lignes -->
<section id="hero" class="d-flex flex-column justify-content-center align-items-center hero-bg position-relative scroll-offset p-0 m-0" style="width:100vw;max-width:100vw;">
  <?php require_once __DIR__ . '/../includes/partials/hero-template-particles.php'; ?>
</section>

<!-- SUPPRESSION du séparateur SVG, ajout simple d'espace -->
<div style="height: 48px; width: 100vw;"></div>

<!-- SECTION A PROPOS -->
<section id="a-propos" class="scroll-offset py-5 position-relative bg-white">
  <div class="container position-relative">
    <h2 class="text-center mb-4" data-aos="fade-up">À Propos de Digita Marketing</h2>
    <p class="text-center text-muted mb-5" data-aos="fade-up" data-aos-delay="100">Apprendre à nous connaître</p>
    
    <div class="row justify-content-center mb-5">
      <div class="col-lg-10" data-aos="fade-up" data-aos-delay="200">
        <p class="lead text-center mb-4">Digita Marketing est votre partenaire digital de confiance depuis plus de 5 ans. Nous accompagnons les entreprises dans leur transformation numérique avec des solutions innovantes et sur-mesure.</p>
      </div>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="text-center">
          <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
            <i class="bi bi-award fs-1 text-primary"></i>
          </div>
          <h4>Expertise</h4>
          <p class="text-muted">Plus de 200 projets réalisés avec succès pour des clients de tous secteurs</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
        <div class="text-center">
          <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
            <i class="bi bi-people fs-1 text-primary"></i>
          </div>
          <h4>Équipe dédiée</h4>
          <p class="text-muted">Une équipe de 15 experts passionnés à votre service</p>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
        <div class="text-center">
          <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
            <i class="bi bi-graph-up fs-1 text-primary"></i>
          </div>
          <h4>Résultats</h4>
          <p class="text-muted">95% de satisfaction client et une croissance moyenne de 150% pour nos clients</p>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8" data-aos="fade-up" data-aos-delay="600">
        <div class="bg-light rounded p-4">
          <h5 class="mb-3">Notre Mission</h5>
          <p class="mb-4">Nous croyons que chaque entreprise mérite une présence digitale exceptionnelle. Notre mission est de démocratiser l'accès aux technologies digitales en proposant des solutions performantes, accessibles et adaptées à chaque budget.</p>
          <div class="text-center">
            <a href="/a-propos" class="btn btn-primary">En savoir plus sur nous</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION SERVICES -->
<section id="services" class="scroll-offset py-5 position-relative bg-alt">
  <div class="container position-relative">
    <h2 class="text-center mb-4" data-aos="fade-up">Nos Services Digitaux</h2>
    <p class="text-center text-muted mb-5" data-aos="fade-up" data-aos-delay="100">Découvrir nos services</p>
    
    <div class="row g-4 mb-5">
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
              <i class="bi bi-images fs-2 text-primary"></i>
            </div>
            <h5 class="card-title mb-3">Création de Logos</h5>
            <p class="card-text text-muted">Conception de logos originaux et mémorables qui reflètent l'identité de votre marque. Plusieurs propositions, révisions illimitées jusqu'à satisfaction.</p>
            <ul class="list-unstyled mt-3">
              <li><i class="bi bi-check-circle text-success me-2"></i>Design unique et professionnel</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Fichiers vectoriels HD</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Charte graphique incluse</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
              <i class="bi bi-camera-video fs-2 text-primary"></i>
            </div>
            <h5 class="card-title mb-3">Production Vidéo</h5>
            <p class="card-text text-muted">Montage vidéo professionnel, teasers, interviews, motion design et animations. Captez l'attention de votre audience avec du contenu vidéo percutant.</p>
            <ul class="list-unstyled mt-3">
              <li><i class="bi bi-check-circle text-success me-2"></i>Montage professionnel</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Motion design & effets</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Formats adaptés réseaux sociaux</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
              <i class="bi bi-window fs-2 text-primary"></i>
            </div>
            <h5 class="card-title mb-3">Sites Web</h5>
            <p class="card-text text-muted">Création de sites vitrines modernes et sites e-commerce performants. Design responsive, optimisé SEO et adapté à tous les appareils.</p>
            <ul class="list-unstyled mt-3">
              <li><i class="bi bi-check-circle text-success me-2"></i>Design moderne et responsive</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Optimisation SEO incluse</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Hébergement et maintenance</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
              <i class="bi bi-funnel fs-2 text-primary"></i>
            </div>
            <h5 class="card-title mb-3">Tunnel de Vente</h5>
            <p class="card-text text-muted">Automatisation de votre prospection et suivi de vos leads. Optimisez votre taux de conversion avec des tunnels de vente performants.</p>
            <ul class="list-unstyled mt-3">
              <li><i class="bi bi-check-circle text-success me-2"></i>Landing pages optimisées</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Automatisation marketing</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Suivi et analytics</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
              <i class="bi bi-people fs-2 text-primary"></i>
            </div>
            <h5 class="card-title mb-3">Management Social</h5>
            <p class="card-text text-muted">Gestion complète de vos réseaux sociaux et animation de communautés. Développez votre présence en ligne et engagez votre audience.</p>
            <ul class="list-unstyled mt-3">
              <li><i class="bi bi-check-circle text-success me-2"></i>Stratégie de contenu</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Publication régulière</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Community management</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="700">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
              <i class="bi bi-bar-chart fs-2 text-primary"></i>
            </div>
            <h5 class="card-title mb-3">SEO & Référencement</h5>
            <p class="card-text text-muted">Optimisation du référencement naturel pour améliorer votre visibilité sur Google. Audit, stratégie et suivi des performances.</p>
            <ul class="list-unstyled mt-3">
              <li><i class="bi bi-check-circle text-success me-2"></i>Audit SEO complet</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Optimisation on-page</li>
              <li><i class="bi bi-check-circle text-success me-2"></i>Netlinking et backlinks</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center" data-aos="fade-up" data-aos-delay="800">
      <a href="/services" class="btn btn-primary btn-lg">Voir tous nos services</a>
    </div>
  </div>
</section>

<!-- SECTION CONTACT -->
<section id="contact" class="scroll-offset py-5 position-relative bg-white">
  <div class="container position-relative">
    <h2 class="text-center mb-4" data-aos="fade-up">Contactez-Nous</h2>
    <p class="text-center text-muted mb-5" data-aos="fade-up" data-aos-delay="100">Prendre contact</p>
    
    <div class="row justify-content-center mb-5">
      <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
        <p class="lead text-center">Vous avez un projet digital en tête ? Notre équipe est là pour vous accompagner de A à Z. Discutons ensemble de vos objectifs et trouvons la solution idéale pour votre entreprise.</p>
      </div>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="text-center p-4 bg-light rounded">
          <i class="bi bi-envelope fs-1 text-primary mb-3"></i>
          <h5>Email</h5>
          <p class="text-muted mb-0">contact@digita-marketing.com</p>
          <small class="text-muted">Réponse sous 24h</small>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
        <div class="text-center p-4 bg-light rounded">
          <i class="bi bi-telephone fs-1 text-primary mb-3"></i>
          <h5>Téléphone</h5>
          <p class="text-muted mb-0">+262 692 XX XX XX</p>
          <small class="text-muted">Lun-Ven 9h-18h</small>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
        <div class="text-center p-4 bg-light rounded">
          <i class="bi bi-geo-alt fs-1 text-primary mb-3"></i>
          <h5>Localisation</h5>
          <p class="text-muted mb-0">La Réunion, France</p>
          <small class="text-muted">Intervention à distance</small>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="600">
        <div class="text-center">
          <h4 class="mb-3">Prêt à démarrer votre projet ?</h4>
          <p class="mb-4">Obtenez un devis gratuit et personnalisé en moins de 48h</p>
          <a href="/contact" class="btn btn-primary btn-lg px-5">Demander un devis gratuit</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION SUPPORT -->
<section id="support" class="scroll-offset py-5 position-relative bg-alt">
  <div class="container position-relative">
    <h2 class="text-center mb-4" data-aos="fade-up">Support Client</h2>
    <p class="text-center text-muted mb-5" data-aos="fade-up" data-aos-delay="100">Nous pouvons vous aider</p>
    
    <div class="row justify-content-center mb-5">
      <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
        <p class="lead text-center">Notre équipe support est à votre disposition pour vous accompagner tout au long de votre projet et au-delà. Assistance technique, conseils stratégiques, formation : nous sommes là pour vous.</p>
      </div>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="card h-100 border-0 shadow-sm text-center p-4">
          <i class="bi bi-headset fs-1 text-primary mb-3"></i>
          <h5>Support Technique</h5>
          <p class="text-muted small">Assistance technique rapide et efficace pour tous vos problèmes</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="card h-100 border-0 shadow-sm text-center p-4">
          <i class="bi bi-book fs-1 text-primary mb-3"></i>
          <h5>Documentation</h5>
          <p class="text-muted small">Guides détaillés et tutoriels pour utiliser nos services</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="500">
        <div class="card h-100 border-0 shadow-sm text-center p-4">
          <i class="bi bi-chat-dots fs-1 text-primary mb-3"></i>
          <h5>Chat en Direct</h5>
          <p class="text-muted small">Discutez avec notre équipe en temps réel</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="600">
        <div class="card h-100 border-0 shadow-sm text-center p-4">
          <i class="bi bi-tools fs-1 text-primary mb-3"></i>
          <h5>Maintenance</h5>
          <p class="text-muted small">Maintenance préventive et corrective incluse</p>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8" data-aos="fade-up" data-aos-delay="700">
        <div class="bg-white rounded p-5 shadow-sm">
          <h4 class="text-center mb-4">Besoin d'aide ?</h4>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="d-flex align-items-start">
                <i class="bi bi-clock text-primary fs-4 me-3"></i>
                <div>
                  <h6>Disponibilité</h6>
                  <p class="text-muted small mb-0">Lundi - Vendredi : 9h - 18h<br>Samedi : 9h - 13h</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex align-items-start">
                <i class="bi bi-lightning text-primary fs-4 me-3"></i>
                <div>
                  <h6>Temps de réponse</h6>
                  <p class="text-muted small mb-0">Moins de 2h en moyenne<br>Support prioritaire disponible</p>
                </div>
              </div>
            </div>
          </div>
          <div class="text-center mt-4">
            <a href="/support" class="btn btn-primary btn-lg">Accéder au centre d'aide</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION TARIFS -->
<section id="tarifs" class="scroll-offset py-5 position-relative bg-white">
  <div class="container position-relative">
    <h2 class="text-center mb-4" data-aos="fade-up">Nos Tarifs</h2>
    <p class="text-center text-muted mb-5" data-aos="fade-up" data-aos-delay="100">Trouver une offre</p>
    
    <div class="row justify-content-center mb-5">
      <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
        <p class="lead text-center">Des tarifs transparents et adaptés à tous les budgets. Choisissez la formule qui correspond le mieux à vos besoins et bénéficiez d'un accompagnement personnalisé.</p>
      </div>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card h-100 border-0 shadow">
          <div class="card-body p-4 text-center">
            <h5 class="text-uppercase text-muted mb-3">Starter</h5>
            <div class="mb-4">
              <span class="h2">À partir de</span>
              <div class="display-4 fw-bold text-primary">499€</div>
              <span class="text-muted">par projet</span>
            </div>
            <ul class="list-unstyled text-start mb-4">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Logo professionnel</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Charte graphique basique</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>3 propositions</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Révisions illimitées</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Fichiers sources</li>
            </ul>
            <a href="/tarifs" class="btn btn-outline-primary w-100">En savoir plus</a>
          </div>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
        <div class="card h-100 border-primary border-2 shadow-lg">
          <div class="card-header bg-primary text-white text-center py-3">
            <span class="badge bg-white text-primary">Le plus populaire</span>
          </div>
          <div class="card-body p-4 text-center">
            <h5 class="text-uppercase text-muted mb-3">Business</h5>
            <div class="mb-4">
              <span class="h2">À partir de</span>
              <div class="display-4 fw-bold text-primary">1499€</div>
              <span class="text-muted">par projet</span>
            </div>
            <ul class="list-unstyled text-start mb-4">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Site web complet</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Design responsive</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Optimisation SEO</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Hébergement 1 an</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Formation incluse</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Support prioritaire</li>
            </ul>
            <a href="/tarifs" class="btn btn-primary w-100">En savoir plus</a>
          </div>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="500">
        <div class="card h-100 border-0 shadow">
          <div class="card-body p-4 text-center">
            <h5 class="text-uppercase text-muted mb-3">Premium</h5>
            <div class="mb-4">
              <span class="h2">À partir de</span>
              <div class="display-4 fw-bold text-primary">3999€</div>
              <span class="text-muted">par projet</span>
            </div>
            <ul class="list-unstyled text-start mb-4">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Solution complète</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>E-commerce avancé</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Tunnel de vente</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Automatisation marketing</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Stratégie digitale</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Support dédié 24/7</li>
            </ul>
            <a href="/tarifs" class="btn btn-outline-primary w-100">En savoir plus</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8" data-aos="fade-up" data-aos-delay="600">
        <div class="bg-light rounded p-4 text-center">
          <h5 class="mb-3">Besoin d'une solution sur-mesure ?</h5>
          <p class="mb-3">Contactez-nous pour obtenir un devis personnalisé adapté à vos besoins spécifiques</p>
          <a href="/contact" class="btn btn-primary">Demander un devis personnalisé</a>
        </div>
      </div>
    </div>
  </div>
</section>


<?php // JS Spécifique home (sera injecté dynamiquement si besoin)
$extraJs = [
    'https://unpkg.com/aos@2.3.1/dist/aos.js',
    '/assets/js/main.js'
];
?>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
