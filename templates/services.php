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
      <a href="#reseaux-sociaux" class="btn btn-sm btn-outline-primary scroll-link" data-target="#reseaux">Réseaux Sociaux</a>
      <a href="#identite-visuelle" class="btn btn-sm btn-outline-primary scroll-link" data-target="#identite">Identité Visuelle</a>
      <a href="#video-multimedia" class="btn btn-sm btn-outline-primary scroll-link" data-target="#video">Vidéo & Multimédia</a>
      <a href="#sites-web" class="btn btn-sm btn-outline-primary scroll-link" data-target="#sites">Sites Web</a>
      <a href="#seo" class="btn btn-sm btn-outline-primary scroll-link" data-target="#seo-collapse">SEO</a>
      <a href="#publicite" class="btn btn-sm btn-outline-primary scroll-link" data-target="#publicite-collapse">Publicité</a>
      <a href="#email-marketing" class="btn btn-sm btn-outline-primary scroll-link" data-target="#email">Email Marketing</a>
      <a href="#analytics" class="btn btn-sm btn-outline-primary scroll-link" data-target="#analytics-collapse">Analytics</a>
      <a href="#strategie" class="btn btn-sm btn-outline-primary scroll-link" data-target="#strategie-collapse">Stratégie</a>
      <a href="#redaction" class="btn btn-sm btn-outline-primary scroll-link" data-target="#redaction-collapse">Rédaction</a>
      <a href="#ia-automation" class="btn btn-sm btn-outline-primary scroll-link" data-target="#ia-collapse">IA & Automation</a>
      <a href="#ecommerce" class="btn btn-sm btn-outline-primary scroll-link" data-target="#ecommerce-collapse">E-commerce</a>
      <a href="#mobile" class="btn btn-sm btn-outline-primary scroll-link" data-target="#mobile-collapse">Mobile</a>
      <a href="#formation" class="btn btn-sm btn-outline-primary scroll-link" data-target="#formation-collapse">Formation</a>
    </div>
  </div>
</section>

<!-- Script pour gérer le scroll et l'ouverture des accordéons -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const scrollLinks = document.querySelectorAll('.scroll-link');
  
  scrollLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Récupérer l'ID de la section et de l'accordéon
      const sectionId = this.getAttribute('href');
      const accordionTarget = this.getAttribute('data-target');
      
      // Scroller vers la section
      const section = document.querySelector(sectionId);
      if (section) {
        const offset = 150; // Offset pour la barre sticky
        const elementPosition = section.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - offset;
        
        window.scrollTo({
          top: offsetPosition,
          behavior: 'smooth'
        });
        
        // Ouvrir l'accordéon après le scroll (sans fermer les autres)
        setTimeout(() => {
          const accordion = document.querySelector(accordionTarget);
          if (accordion && !accordion.classList.contains('show')) {
            // Utiliser show() au lieu de toggle pour ne pas fermer les autres
            const bsCollapse = new bootstrap.Collapse(accordion, {
              toggle: false
            });
            bsCollapse.show();
          }
        }, 600);
      }
    });
  });
});
</script>

<!-- Services par Catégories (Accordéons) -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="accordion" id="servicesAccordion">
      
      <!-- RÉSEAUX SOCIAUX -->
      <div id="reseaux-sociaux" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#reseaux">
            <i class="bi bi-people-fill text-primary me-3 fs-4"></i>
            <strong>Réseaux Sociaux & Community Management</strong>
          </button>
        </h2>
        <div id="reseaux" class="accordion-collapse collapse show">
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
                <span class="badge bg-primary">À partir de 399€/mois</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- IDENTITÉ VISUELLE -->
      <div id="identite-visuelle" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#identite">
            <i class="bi bi-palette-fill text-primary me-3 fs-4"></i>
            <strong>Identité Visuelle & Design Graphique</strong>
          </button>
        </h2>
        <div id="identite" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-4">
                <h6 class="text-primary">Identité de Marque</h6>
                <ul class="small list-unstyled">
                  <li>• Logo professionnel</li>
                  <li>• Charte graphique complète</li>
                  <li>• Brand Book</li>
                </ul>
                <span class="badge bg-primary">À partir de 499€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Design Print</h6>
                <ul class="small list-unstyled">
                  <li>• Cartes de visite</li>
                  <li>• Flyers et brochures</li>
                  <li>• Packaging produits</li>
                </ul>
                <span class="badge bg-primary">À partir de 99€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Design Digital</h6>
                <ul class="small list-unstyled">
                  <li>• Bannières publicitaires</li>
                  <li>• Templates réseaux sociaux</li>
                  <li>• Emailings HTML</li>
                </ul>
                <span class="badge bg-primary">À partir de 149€</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- VIDÉO & MULTIMÉDIA -->
      <div id="video-multimedia" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#video">
            <i class="bi bi-camera-video-fill text-primary me-3 fs-4"></i>
            <strong>Production Vidéo & Multimédia</strong>
          </button>
        </h2>
        <div id="video" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-4">
                <h6 class="text-primary">Vidéos Promotionnelles</h6>
                <ul class="small list-unstyled">
                  <li>• Vidéos d'entreprise</li>
                  <li>• Vidéos produits</li>
                  <li>• Témoignages clients</li>
                </ul>
                <span class="badge bg-primary">À partir de 799€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Contenu Vidéo Social</h6>
                <ul class="small list-unstyled">
                  <li>• Reels Instagram</li>
                  <li>• TikTok</li>
                  <li>• YouTube Shorts</li>
                </ul>
                <span class="badge bg-primary">À partir de 299€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Production Avancée</h6>
                <ul class="small list-unstyled">
                  <li>• Motion design 2D/3D</li>
                  <li>• Effets spéciaux (VFX)</li>
                  <li>• Photographie pro</li>
                </ul>
                <span class="badge bg-primary">À partir de 1499€</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- SITES WEB -->
      <div id="sites-web" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#sites">
            <i class="bi bi-window-desktop text-primary me-3 fs-4"></i>
            <strong>Création de Sites Web</strong>
          </button>
        </h2>
        <div id="sites" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-4">
                <h6 class="text-primary">Sites Vitrine</h6>
                <ul class="small list-unstyled">
                  <li>• Site responsive</li>
                  <li>• Site multilingue</li>
                  <li>• Portfolio en ligne</li>
                </ul>
                <span class="badge bg-primary">À partir de 1499€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Sites E-commerce</h6>
                <ul class="small list-unstyled">
                  <li>• Boutique en ligne</li>
                  <li>• Paiement sécurisé</li>
                  <li>• Gestion des stocks</li>
                </ul>
                <span class="badge bg-primary">À partir de 2999€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Applications Web</h6>
                <ul class="small list-unstyled">
                  <li>• PWA</li>
                  <li>• Plateforme SaaS</li>
                  <li>• CRM/ERP sur-mesure</li>
                </ul>
                <span class="badge bg-primary">Sur devis</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- SEO -->
      <div id="seo" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#seo-collapse">
            <i class="bi bi-search text-primary me-3 fs-4"></i>
            <strong>SEO & Référencement</strong>
          </button>
        </h2>
        <div id="seo-collapse" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-3">
                <h6 class="text-primary">SEO On-Page</h6>
                <ul class="small list-unstyled">
                  <li>• Audit SEO</li>
                  <li>• Optimisation balises</li>
                  <li>• Core Web Vitals</li>
                </ul>
                <span class="badge bg-primary">799€/mois</span>
              </div>
              <div class="col-md-3">
                <h6 class="text-primary">SEO Off-Page</h6>
                <ul class="small list-unstyled">
                  <li>• Netlinking</li>
                  <li>• Guest blogging</li>
                  <li>• Link building</li>
                </ul>
                <span class="badge bg-primary">599€/mois</span>
              </div>
              <div class="col-md-3">
                <h6 class="text-primary">SEO Local</h6>
                <ul class="small list-unstyled">
                  <li>• Google My Business</li>
                  <li>• Avis clients</li>
                </ul>
                <span class="badge bg-primary">399€/mois</span>
              </div>
              <div class="col-md-3">
                <h6 class="text-primary">SEO Technique</h6>
                <ul class="small list-unstyled">
                  <li>• Audit technique</li>
                  <li>• Sitemap XML</li>
                </ul>
                <span class="badge bg-primary">699€</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- PUBLICITÉ -->
      <div id="publicite" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#publicite-collapse">
            <i class="bi bi-megaphone-fill text-primary me-3 fs-4"></i>
            <strong>Publicité en Ligne</strong>
          </button>
        </h2>
        <div id="publicite-collapse" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-4">
                <h6 class="text-primary">Google Ads</h6>
                <ul class="small list-unstyled">
                  <li>• Campagnes Search</li>
                  <li>• Campagnes Shopping</li>
                  <li>• YouTube Ads</li>
                </ul>
                <span class="badge bg-primary">899€/mois</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Social Ads</h6>
                <ul class="small list-unstyled">
                  <li>• Facebook & Instagram Ads</li>
                  <li>• LinkedIn Ads</li>
                  <li>• TikTok Ads</li>
                </ul>
                <span class="badge bg-primary">699€/mois</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Display & Affiliation</h6>
                <ul class="small list-unstyled">
                  <li>• Publicité programmatique</li>
                  <li>• Retargeting</li>
                </ul>
                <span class="badge bg-primary">Sur devis</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- EMAIL MARKETING -->
      <div id="email-marketing" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#email">
            <i class="bi bi-envelope-fill text-primary me-3 fs-4"></i>
            <strong>Email Marketing</strong>
          </button>
        </h2>
        <div id="email" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-4">
                <h6 class="text-primary">Campagnes Email</h6>
                <ul class="small list-unstyled">
                  <li>• Newsletters</li>
                  <li>• Emails promotionnels</li>
                </ul>
                <span class="badge bg-primary">299€/mois</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Automation</h6>
                <ul class="small list-unstyled">
                  <li>• Scénarios automatisés</li>
                  <li>• Lead nurturing</li>
                </ul>
                <span class="badge bg-primary">599€/mois</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Design Email</h6>
                <ul class="small list-unstyled">
                  <li>• Templates HTML</li>
                  <li>• A/B testing</li>
                </ul>
                <span class="badge bg-primary">199€</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ANALYTICS -->
      <div id="analytics" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#analytics-collapse">
            <i class="bi bi-graph-up text-primary me-3 fs-4"></i>
            <strong>Analytics & Data</strong>
          </button>
        </h2>
        <div id="analytics-collapse" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-4">
                <h6 class="text-primary">Analyse de Données</h6>
                <ul class="small list-unstyled">
                  <li>• Google Analytics 4</li>
                  <li>• Tableaux de bord</li>
                </ul>
                <span class="badge bg-primary">499€/mois</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Tag Management</h6>
                <ul class="small list-unstyled">
                  <li>• Google Tag Manager</li>
                  <li>• Tracking événements</li>
                </ul>
                <span class="badge bg-primary">299€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Business Intelligence</h6>
                <ul class="small list-unstyled">
                  <li>• Tableaux de bord BI</li>
                  <li>• Reporting automatisé</li>
                </ul>
                <span class="badge bg-primary">Sur devis</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- STRATÉGIE -->
      <div id="strategie" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#strategie-collapse">
            <i class="bi bi-lightbulb-fill text-primary me-3 fs-4"></i>
            <strong>Stratégie Digitale</strong>
          </button>
        </h2>
        <div id="strategie-collapse" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-4">
                <h6 class="text-primary">Conseil & Audit</h6>
                <ul class="small list-unstyled">
                  <li>• Audit digital</li>
                  <li>• Plan marketing</li>
                </ul>
                <span class="badge bg-primary">999€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Stratégie de Contenu</h6>
                <ul class="small list-unstyled">
                  <li>• Content marketing</li>
                  <li>• Planning éditorial</li>
                </ul>
                <span class="badge bg-primary">699€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">CRO & Growth</h6>
                <ul class="small list-unstyled">
                  <li>• Optimisation conversion</li>
                  <li>• Growth hacking</li>
                </ul>
                <span class="badge bg-primary">799€/mois</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- RÉDACTION -->
      <div id="redaction" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#redaction-collapse">
            <i class="bi bi-pencil-fill text-primary me-3 fs-4"></i>
            <strong>Rédaction & Content</strong>
          </button>
        </h2>
        <div id="redaction-collapse" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-4">
                <h6 class="text-primary">Rédaction Web</h6>
                <ul class="small list-unstyled">
                  <li>• Articles de blog SEO</li>
                  <li>• Fiches produits</li>
                </ul>
                <span class="badge bg-primary">99€/article</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Copywriting</h6>
                <ul class="small list-unstyled">
                  <li>• Pages de vente</li>
                  <li>• Landing pages</li>
                </ul>
                <span class="badge bg-primary">299€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Traduction</h6>
                <ul class="small list-unstyled">
                  <li>• Traduction de contenu</li>
                  <li>• SEO multilingue</li>
                </ul>
                <span class="badge bg-primary">0.10€/mot</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- IA & AUTOMATION -->
      <div id="ia-automation" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#ia-collapse">
            <i class="bi bi-cpu-fill text-primary me-3 fs-4"></i>
            <strong>IA & Automatisation</strong>
          </button>
        </h2>
        <div id="ia-collapse" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-4">
                <h6 class="text-primary">Chatbots</h6>
                <ul class="small list-unstyled">
                  <li>• Chatbot site web</li>
                  <li>• Chatbot WhatsApp</li>
                </ul>
                <span class="badge bg-primary">1499€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Automation</h6>
                <ul class="small list-unstyled">
                  <li>• Marketing automation</li>
                  <li>• CRM automation</li>
                </ul>
                <span class="badge bg-primary">799€/mois</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">IA Générative</h6>
                <ul class="small list-unstyled">
                  <li>• Génération contenu IA</li>
                  <li>• Génération images IA</li>
                </ul>
                <span class="badge bg-primary">599€/mois</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- E-COMMERCE -->
      <div id="ecommerce" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#ecommerce-collapse">
            <i class="bi bi-cart-fill text-primary me-3 fs-4"></i>
            <strong>E-commerce</strong>
          </button>
        </h2>
        <div id="ecommerce-collapse" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-4">
                <h6 class="text-primary">Création E-commerce</h6>
                <ul class="small list-unstyled">
                  <li>• Boutique en ligne</li>
                  <li>• Programme fidélité</li>
                </ul>
                <span class="badge bg-primary">2999€</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Marketplaces</h6>
                <ul class="small list-unstyled">
                  <li>• Vente sur Amazon</li>
                  <li>• Vente sur eBay</li>
                </ul>
                <span class="badge bg-primary">499€/mois</span>
              </div>
              <div class="col-md-4">
                <h6 class="text-primary">Paiement</h6>
                <ul class="small list-unstyled">
                  <li>• Intégration paiement</li>
                  <li>• Solutions livraison</li>
                </ul>
                <span class="badge bg-primary">Sur devis</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- MOBILE -->
      <div id="mobile" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#mobile-collapse">
            <i class="bi bi-phone-fill text-primary me-3 fs-4"></i>
            <strong>Applications Mobiles</strong>
          </button>
        </h2>
        <div id="mobile-collapse" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-6">
                <h6 class="text-primary">Développement Mobile</h6>
                <ul class="small list-unstyled">
                  <li>• Application iOS</li>
                  <li>• Application Android</li>
                  <li>• PWA</li>
                </ul>
                <span class="badge bg-primary">4999€</span>
              </div>
              <div class="col-md-6">
                <h6 class="text-primary">Fonctionnalités</h6>
                <ul class="small list-unstyled">
                  <li>• Push notifications</li>
                  <li>• Géolocalisation</li>
                  <li>• Paiement in-app</li>
                </ul>
                <span class="badge bg-primary">Sur devis</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- FORMATION -->
      <div id="formation" class="accordion-item border-0 shadow-sm mb-3" data-aos="fade-up">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed bg-primary bg-opacity-10" type="button" data-bs-toggle="collapse" data-bs-target="#formation-collapse">
            <i class="bi bi-mortarboard-fill text-primary me-3 fs-4"></i>
            <strong>Formation</strong>
          </button>
        </h2>
        <div id="formation-collapse" class="accordion-collapse collapse">
          <div class="accordion-body">
            <div class="row g-3">
              <div class="col-md-6">
                <h6 class="text-primary">Formations Digitales</h6>
                <ul class="small list-unstyled">
                  <li>• Formation réseaux sociaux</li>
                  <li>• Formation SEO</li>
                  <li>• Formation Google Ads</li>
                </ul>
                <span class="badge bg-primary">499€/jour</span>
              </div>
              <div class="col-md-6">
                <h6 class="text-primary">Coaching</h6>
                <ul class="small list-unstyled">
                  <li>• Coaching individuel</li>
                  <li>• Consulting stratégique</li>
                </ul>
                <span class="badge bg-primary">150€/heure</span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Note informative -->
    <div class="alert alert-info mt-5 text-center" role="alert" data-aos="fade-up">
      <i class="bi bi-info-circle me-2"></i>
      <strong>Plus de 300 services disponibles !</strong> Consultez notre <a href="/catalogue" class="alert-link">catalogue complet</a> pour découvrir tous nos services en détail.
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
