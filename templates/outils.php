<?php
// Page Outils - Ressources et outils gratuits
$pageTitle = 'Outils Gratuits';
$extraCss = ['/assets/css/outils.css'];
ob_start();
?>

<!-- HERO SECTION -->
<section class="hero-section bg-primary bg-gradient text-white py-5">
  <div class="container py-5">
    <div class="row align-items-center">
      <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">Outils Gratuits</h1>
        <p class="lead mb-4">Découvrez notre collection d'outils gratuits pour booster votre présence digitale. Calculateurs, générateurs, templates et ressources pour vous aider à réussir en ligne.</p>
      </div>
    </div>
  </div>
</section>

<!-- SECTION OUTILS -->
<section class="py-5 bg-light">
  <div class="container">
    
    <!-- Catégorie : Calculateurs -->
    <div class="mb-5" data-aos="fade-up">
      <h2 class="mb-4"><i class="bi bi-calculator text-primary me-3"></i>Calculateurs</h2>
      <div class="row g-4">
        
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-calculator-fill fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Calculateur ROI</h5>
              </div>
              <p class="card-text text-muted mb-3">Calculez le retour sur investissement de vos campagnes marketing digitales.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>ROI publicitaire</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Coût par acquisition</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Rentabilité campagne</li>
              </ul>
              <a href="/outils/calculateur-roi" class="btn btn-outline-primary w-100">Utiliser l'outil</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-graph-up-arrow fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Calculateur SEO</h5>
              </div>
              <p class="card-text text-muted mb-3">Estimez le trafic potentiel et la valeur de votre référencement naturel.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>Trafic estimé</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Valeur du trafic</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Potentiel de mots-clés</li>
              </ul>
              <a href="/outils/calculateur-seo" class="btn btn-outline-primary w-100">Utiliser l'outil</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-envelope-check fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Calculateur Email</h5>
              </div>
              <p class="card-text text-muted mb-3">Calculez les performances de vos campagnes email marketing.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>Taux d'ouverture</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Taux de clic</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Taux de conversion</li>
              </ul>
              <a href="/outils/calculateur-email" class="btn btn-outline-primary w-100">Utiliser l'outil</a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Catégorie : Générateurs -->
    <div class="mb-5" data-aos="fade-up">
      <h2 class="mb-4"><i class="bi bi-magic text-primary me-3"></i>Générateurs</h2>
      <div class="row g-4">
        
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-palette-fill fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Générateur de Palette</h5>
              </div>
              <p class="card-text text-muted mb-3">Créez des palettes de couleurs harmonieuses pour votre marque.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>Palettes personnalisées</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Codes HEX/RGB</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Export facile</li>
              </ul>
              <a href="/outils/generateur-palette" class="btn btn-outline-primary w-100">Utiliser l'outil</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-hash fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Générateur de Hashtags</h5>
              </div>
              <p class="card-text text-muted mb-3">Trouvez les meilleurs hashtags pour vos publications sur les réseaux sociaux.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>Hashtags pertinents</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Analyse de popularité</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Multi-plateformes</li>
              </ul>
              <a href="/outils/generateur-hashtags" class="btn btn-outline-primary w-100">Utiliser l'outil</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-file-text fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Générateur de Meta Tags</h5>
              </div>
              <p class="card-text text-muted mb-3">Créez des meta tags optimisés pour le SEO de votre site web.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>Title & Description</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Open Graph</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Twitter Cards</li>
              </ul>
              <a href="/outils/generateur-meta-tags" class="btn btn-outline-primary w-100">Utiliser l'outil</a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Catégorie : Analyseurs -->
    <div class="mb-5" data-aos="fade-up">
      <h2 class="mb-4"><i class="bi bi-search text-primary me-3"></i>Analyseurs</h2>
      <div class="row g-4">
        
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-speedometer2 fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Analyseur de Vitesse</h5>
              </div>
              <p class="card-text text-muted mb-3">Testez la vitesse de chargement de votre site web et obtenez des recommandations.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>Temps de chargement</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Score de performance</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Recommandations</li>
              </ul>
              <a href="/outils/analyseur-vitesse" class="btn btn-outline-primary w-100">Utiliser l'outil</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-shield-check fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Analyseur SEO</h5>
              </div>
              <p class="card-text text-muted mb-3">Analysez le référencement de votre site et identifiez les points à améliorer.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>Audit SEO complet</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Erreurs détectées</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Plan d'action</li>
              </ul>
              <a href="/outils/analyseur-seo" class="btn btn-outline-primary w-100">Utiliser l'outil</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-phone fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Test Mobile-Friendly</h5>
              </div>
              <p class="card-text text-muted mb-3">Vérifiez si votre site est optimisé pour les appareils mobiles.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>Compatibilité mobile</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Responsive design</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Recommandations</li>
              </ul>
              <a href="/outils/test-mobile" class="btn btn-outline-primary w-100">Utiliser l'outil</a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Catégorie : Templates & Ressources -->
    <div class="mb-5" data-aos="fade-up">
      <h2 class="mb-4"><i class="bi bi-file-earmark-text text-primary me-3"></i>Templates & Ressources</h2>
      <div class="row g-4">
        
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-calendar-event fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Calendrier Editorial</h5>
              </div>
              <p class="card-text text-muted mb-3">Template Excel pour planifier votre contenu sur les réseaux sociaux.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>Planning mensuel</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Multi-plateformes</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Facile à utiliser</li>
              </ul>
              <a href="/outils/template-calendrier" class="btn btn-outline-primary w-100">Télécharger</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-clipboard-data fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Template Reporting</h5>
              </div>
              <p class="card-text text-muted mb-3">Modèle de rapport pour suivre vos performances marketing.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>KPIs essentiels</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Graphiques automatiques</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>Format professionnel</li>
              </ul>
              <a href="/outils/template-reporting" class="btn btn-outline-primary w-100">Télécharger</a>
            </div>
          </div>
        </div>

        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-lift">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                  <i class="bi bi-list-check fs-3 text-primary"></i>
                </div>
                <h5 class="card-title mb-0">Checklist SEO</h5>
              </div>
              <p class="card-text text-muted mb-3">Liste complète des éléments à vérifier pour optimiser votre SEO.</p>
              <ul class="list-unstyled small mb-3">
                <li><i class="bi bi-check-circle text-success me-2"></i>SEO On-Page</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>SEO Technique</li>
                <li><i class="bi bi-check-circle text-success me-2"></i>SEO Off-Page</li>
              </ul>
              <a href="/outils/checklist-seo" class="btn btn-outline-primary w-100">Télécharger</a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- CTA Section -->
    <div class="text-center py-5" data-aos="fade-up">
      <div class="bg-primary bg-opacity-10 rounded p-5">
        <h3 class="mb-3">Besoin d'outils personnalisés ?</h3>
        <p class="lead mb-4">Nous pouvons développer des outils sur-mesure adaptés à vos besoins spécifiques.</p>
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
