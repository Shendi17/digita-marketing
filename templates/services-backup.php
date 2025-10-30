<?php
$pageTitle = 'Services - Digita Marketing';
$extraCss = ['/assets/css/services.css'];
ob_start();
?>

<!-- Hero Section -->
<section class="py-5 bg-primary text-white">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">Nos Services Digitaux</h1>
        <p class="lead mb-0">Découvrir nos services</p>
      </div>
    </div>
  </div>
</section>

<!-- Introduction -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center" data-aos="fade-up">
        <h2 class="mb-4">Plus de 300 Services Digitaux à Votre Disposition</h2>
        <p class="lead text-muted">De la création d'identité visuelle à l'intelligence artificielle, découvrez notre gamme complète de services pour propulser votre présence digitale.</p>
      </div>
    </div>
  </div>
</section>

<!-- Navigation par Catégories -->
<section class="py-4 bg-white sticky-top shadow-sm" style="top: 80px; z-index: 100;">
  <div class="container">
    <div class="d-flex flex-wrap gap-2 justify-content-center">
      <a href="#reseaux-sociaux" class="btn btn-sm btn-outline-primary">Réseaux Sociaux</a>
      <a href="#identite-visuelle" class="btn btn-sm btn-outline-primary">Identité Visuelle</a>
      <a href="#video-multimedia" class="btn btn-sm btn-outline-primary">Vidéo & Multimédia</a>
      <a href="#sites-web" class="btn btn-sm btn-outline-primary">Sites Web</a>
      <a href="#seo" class="btn btn-sm btn-outline-primary">SEO</a>
      <a href="#publicite" class="btn btn-sm btn-outline-primary">Publicité</a>
      <a href="#email-marketing" class="btn btn-sm btn-outline-primary">Email Marketing</a>
      <a href="#analytics" class="btn btn-sm btn-outline-primary">Analytics</a>
      <a href="#strategie" class="btn btn-sm btn-outline-primary">Stratégie</a>
      <a href="#redaction" class="btn btn-sm btn-outline-primary">Rédaction</a>
      <a href="#ia-automation" class="btn btn-sm btn-outline-primary">IA & Automation</a>
      <a href="#ecommerce" class="btn btn-sm btn-outline-primary">E-commerce</a>
      <a href="#mobile" class="btn btn-sm btn-outline-primary">Mobile</a>
      <a href="#formation" class="btn btn-sm btn-outline-primary">Formation</a>
    </div>
  </div>
</section>

<!-- Services par Catégories (Accordéons) -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="accordion" id="servicesAccordion">
      
      <!-- RÉSEAUX SOCIAUX -->
      <div class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#reseaux">
            <i class="bi bi-people-fill text-primary me-3 fs-4"></i>
            <strong>Réseaux Sociaux & Community Management</strong>
          </button>
        </h2>
        <div id="reseaux" class="accordion-collapse collapse show" data-bs-parent="#servicesAccordion">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-4">
                <h6 class="text-primary">Community Management</h6>
                <ul class="small list-unstyled">
                  <li>• Gestion Facebook, Instagram, LinkedIn, TikTok</li>
                  <li>• Création et planification de contenu</li>
                  <li>• Calendrier éditorial</li>
                  <li>• Modération et gestion commentaires</li>
                  <li>• Veille concurrentielle</li>
                  <li>• Reporting mensuel</li>
                </ul>
                <span class="badge bg-primary">599€/mois</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Social Ads</h6>
                <ul class="small list-unstyled">
                  <li>• Facebook & Instagram Ads</li>
                  <li>• LinkedIn Ads (B2B)</li>
                  <li>• TikTok Ads</li>
                  <li>• A/B Testing</li>
                  <li>• Retargeting & remarketing</li>
                  <li>• Optimisation ROI</li>
                </ul>
                <span class="badge bg-primary">899€/mois</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Création Contenu</h6>
                <ul class="small list-unstyled">
                  <li>• Posts graphiques (carrousels, stories)</li>
                  <li>• Vidéos courtes (Reels, TikTok)</li>
                  <li>• Infographies</li>
                  <li>• GIFs et animations</li>
                  <li>• Lives et webinaires</li>
                </ul>
                <span class="badge bg-primary">399€/mois</span>
            <div class="d-flex align-items-start mb-3">
              <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-camera-video fs-2 text-primary"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Production Vidéo</h4>
                <p class="text-muted small">Contenu vidéo professionnel</p>
              </div>
            </div>
            <p class="card-text mb-3">Montage vidéo professionnel, teasers, interviews, motion design et animations 2D/3D. Captez l'attention de votre audience avec du contenu vidéo percutant et engageant.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Montage professionnel et effets spéciaux</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Motion design et animations</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Formats adaptés réseaux sociaux</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Sous-titrage et voix-off</li>
            </ul>
            <div class="d-flex justify-content-between align-items-center">
              <span class="h5 text-primary mb-0">À partir de 799€</span>
              <a href="/contact" class="btn btn-outline-primary">Demander un devis</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Sites Web Vitrine -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
        <div class="card h-100 border-0 shadow hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-window fs-2 text-primary"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Sites Web Vitrine</h4>
                <p class="text-muted small">Présence en ligne professionnelle</p>
              </div>
            </div>
            <p class="card-text mb-3">Création de sites vitrines modernes et élégants pour présenter votre activité. Design responsive, optimisé SEO et adapté à tous les appareils (mobile, tablette, desktop).</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Design moderne et responsive</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Optimisation SEO incluse</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Hébergement et nom de domaine</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Formation à la gestion du site</li>
            </ul>
            <div class="d-flex justify-content-between align-items-center">
              <span class="h5 text-primary mb-0">À partir de 1499€</span>
              <a href="/contact" class="btn btn-outline-primary">Demander un devis</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Sites E-commerce -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
        <div class="card h-100 border-0 shadow hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-bag fs-2 text-primary"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Sites E-commerce</h4>
                <p class="text-muted small">Boutique en ligne performante</p>
              </div>
            </div>
            <p class="card-text mb-3">Boutiques en ligne performantes avec gestion complète du catalogue, paiement sécurisé, gestion des stocks et suivi des commandes. Solution clé en main pour vendre en ligne.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Plateforme e-commerce complète</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Paiement sécurisé multi-devises</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Gestion catalogue et stocks</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Tableau de bord analytics</li>
            </ul>
            <div class="d-flex justify-content-between align-items-center">
              <span class="h5 text-primary mb-0">À partir de 2999€</span>
              <a href="/contact" class="btn btn-outline-primary">Demander un devis</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Tunnel de Vente -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="500">
        <div class="card h-100 border-0 shadow hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-funnel fs-2 text-primary"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Tunnel de Vente</h4>
                <p class="text-muted small">Automatisation marketing</p>
              </div>
            </div>
            <p class="card-text mb-3">Automatisation de votre prospection et suivi de vos leads. Optimisez votre taux de conversion avec des tunnels de vente performants et des landing pages optimisées.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Landing pages optimisées</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Automatisation marketing (emails)</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Suivi et analytics détaillés</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>A/B testing inclus</li>
            </ul>
            <div class="d-flex justify-content-between align-items-center">
              <span class="h5 text-primary mb-0">À partir de 1999€</span>
              <a href="/contact" class="btn btn-outline-primary">Demander un devis</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Management Social -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="600">
        <div class="card h-100 border-0 shadow hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-people fs-2 text-primary"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Management Social</h4>
                <p class="text-muted small">Gestion réseaux sociaux</p>
              </div>
            </div>
            <p class="card-text mb-3">Gestion complète de vos réseaux sociaux et animation de communautés. Développez votre présence en ligne et engagez votre audience avec du contenu pertinent et régulier.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Stratégie de contenu personnalisée</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Publication régulière (3-5x/semaine)</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Community management actif</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Reporting mensuel détaillé</li>
            </ul>
            <div class="d-flex justify-content-between align-items-center">
              <span class="h5 text-primary mb-0">À partir de 599€/mois</span>
              <a href="/contact" class="btn btn-outline-primary">Demander un devis</a>
            </div>
          </div>
        </div>
      </div>

      <!-- SEO & Référencement -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="700">
        <div class="card h-100 border-0 shadow hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-search fs-2 text-primary"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">SEO & Référencement</h4>
                <p class="text-muted small">Visibilité Google</p>
              </div>
            </div>
            <p class="card-text mb-3">Optimisation SEO complète pour améliorer votre positionnement sur Google. Audit technique, optimisation on-page, stratégie de contenu et netlinking pour booster votre trafic organique.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Audit SEO complet</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Optimisation technique et contenu</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Stratégie de mots-clés</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Suivi et reporting mensuel</li>
            </ul>
            <div class="d-flex justify-content-between align-items-center">
              <span class="h5 text-primary mb-0">À partir de 799€/mois</span>
              <a href="/contact" class="btn btn-outline-primary">Demander un devis</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Publicité en Ligne -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="800">
        <div class="card h-100 border-0 shadow hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-megaphone fs-2 text-primary"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Publicité en Ligne</h4>
                <p class="text-muted small">Google Ads & Social Ads</p>
              </div>
            </div>
            <p class="card-text mb-3">Campagnes publicitaires ciblées sur Google Ads, Facebook, Instagram et LinkedIn. Maximisez votre ROI avec des annonces optimisées et un suivi précis des performances.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Campagnes Google Ads & Social Ads</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Ciblage précis de votre audience</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Optimisation continue du ROI</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Reporting détaillé des résultats</li>
            </ul>
            <div class="d-flex justify-content-between align-items-center">
              <span class="h5 text-primary mb-0">À partir de 899€/mois</span>
              <a href="/contact" class="btn btn-outline-primary">Demander un devis</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Projets Personnalisés -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="900">
        <div class="card h-100 border-0 shadow hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-puzzle fs-2 text-primary"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Projets Personnalisés</h4>
                <p class="text-muted small">Solutions sur-mesure</p>
              </div>
            </div>
            <p class="card-text mb-3">Développement de solutions digitales sur-mesure adaptées à vos besoins spécifiques. Applications web, plateformes complexes, intégrations API et systèmes personnalisés.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Analyse approfondie de vos besoins</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Développement sur-mesure</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Intégrations et API</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Support et maintenance inclus</li>
            </ul>
            <div class="d-flex justify-content-between align-items-center">
              <span class="h5 text-primary mb-0">Sur devis</span>
              <a href="/contact" class="btn btn-outline-primary">Demander un devis</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Intelligence Artificielle -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="1000">
        <div class="card h-100 border-0 shadow hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-cpu fs-2 text-primary"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Intelligence Artificielle</h4>
                <p class="text-muted small">Solutions IA innovantes</p>
              </div>
            </div>
            <p class="card-text mb-3">Intégration de solutions d'intelligence artificielle pour automatiser vos processus. Chatbots intelligents, analyse prédictive, reconnaissance d'images et traitement du langage naturel.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Chatbots et assistants virtuels</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Analyse de données et prédictions</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Automatisation intelligente</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Formation et accompagnement</li>
            </ul>
            <div class="d-flex justify-content-between align-items-center">
              <span class="h5 text-primary mb-0">À partir de 1999€</span>
              <a href="/contact" class="btn btn-outline-primary">Demander un devis</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center" data-aos="fade-up">
        <h3 class="mb-4">Besoin d'une solution sur-mesure ?</h3>
        <p class="lead mb-4">Chaque projet est unique. Contactez-nous pour discuter de vos besoins spécifiques et obtenir un devis personnalisé.</p>
        <a href="/contact" class="btn btn-primary btn-lg px-5">Demander un devis gratuit</a>
      </div>
    </div>
  </div>
</section>

<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
