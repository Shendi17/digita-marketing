<?php
$pageTitle = 'Solutions - Digita Marketing';
$extraCss = ['/assets/css/solution.css'];
ob_start();
?>

<!-- Hero Section -->
<section class="py-5 bg-primary text-white">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">Nos Solutions Digitales</h1>
        <p class="lead mb-0">Outils & solutions</p>
      </div>
    </div>
  </div>
</section>

<!-- Solutions Grid -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-lg-8 text-center" data-aos="fade-up">
        <h2 class="mb-4">Outils & Solutions Professionnels</h2>
        <p class="text-muted">Des solutions complètes pour optimiser votre présence digitale et booster votre croissance</p>
      </div>
    </div>

    <div class="row g-4">
      <!-- Solution 1 -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-graph-up-arrow fs-2 text-primary"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Analytics & Reporting</h4>
                <p class="text-muted small">Analyse de performance</p>
              </div>
            </div>
            <p class="card-text mb-3">Tableau de bord complet pour suivre vos performances digitales en temps réel. KPIs, ROI, trafic, conversions et bien plus.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Dashboard personnalisable</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Rapports automatisés</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Alertes en temps réel</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Export PDF/Excel</li>
            </ul>
            <a href="/contact" class="btn btn-outline-primary">En savoir plus</a>
          </div>
        </div>
      </div>

      <!-- Solution 2 -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-calendar-check fs-2 text-success"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Planificateur de Contenu</h4>
                <p class="text-muted small">Gestion éditoriale</p>
              </div>
            </div>
            <p class="card-text mb-3">Planifiez, organisez et publiez votre contenu sur tous vos canaux depuis une seule plateforme. Calendrier éditorial intégré.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Calendrier multi-canaux</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Publication automatique</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Bibliothèque de médias</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Collaboration d'équipe</li>
            </ul>
            <a href="/contact" class="btn btn-outline-success">En savoir plus</a>
          </div>
        </div>
      </div>

      <!-- Solution 3 -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-envelope-paper fs-2 text-warning"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Email Marketing Automation</h4>
                <p class="text-muted small">Campagnes automatisées</p>
              </div>
            </div>
            <p class="card-text mb-3">Créez des campagnes email performantes avec notre outil d'automatisation. Segmentation, A/B testing et analytics intégrés.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Éditeur drag & drop</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Scénarios automatisés</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Segmentation avancée</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>A/B testing</li>
            </ul>
            <a href="/contact" class="btn btn-outline-warning">En savoir plus</a>
          </div>
        </div>
      </div>

      <!-- Solution 4 -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-bullseye fs-2 text-danger"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">CRM Marketing</h4>
                <p class="text-muted small">Gestion de la relation client</p>
              </div>
            </div>
            <p class="card-text mb-3">Centralisez toutes vos interactions clients. Suivi des leads, pipeline de vente, historique complet et automatisation des tâches.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Gestion des contacts</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Pipeline de vente visuel</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Automatisation des tâches</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Intégrations multiples</li>
            </ul>
            <a href="/contact" class="btn btn-outline-danger">En savoir plus</a>
          </div>
        </div>
      </div>

      <!-- Solution 5 -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="500">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-chat-square-text fs-2 text-info"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Chatbot Builder</h4>
                <p class="text-muted small">Assistant virtuel intelligent</p>
              </div>
            </div>
            <p class="card-text mb-3">Créez votre propre chatbot IA sans code. Interface intuitive, scénarios personnalisables et intégration facile sur votre site.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Builder no-code</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>IA conversationnelle</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Multi-langues</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Analytics intégré</li>
            </ul>
            <a href="/contact" class="btn btn-outline-info">En savoir plus</a>
          </div>
        </div>
      </div>

      <!-- Solution 6 -->
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="600">
        <div class="card h-100 border-0 shadow-sm hover-lift">
          <div class="card-body p-4">
            <div class="d-flex align-items-start mb-3">
              <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; flex-shrink: 0;">
                <i class="bi bi-shield-check fs-2 text-secondary"></i>
              </div>
              <div>
                <h4 class="card-title mb-2">Monitoring & Sécurité</h4>
                <p class="text-muted small">Protection et surveillance</p>
              </div>
            </div>
            <p class="card-text mb-3">Surveillez la santé de votre site 24/7. Détection des pannes, monitoring de performance et protection contre les menaces.</p>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Surveillance 24/7</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Alertes instantanées</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Sauvegardes automatiques</li>
              <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Protection DDoS</li>
            </ul>
            <a href="/contact" class="btn btn-outline-secondary">En savoir plus</a>
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
        <h3 class="mb-4">Besoin d'une Solution Personnalisée ?</h3>
        <p class="lead mb-4">Nous développons des outils sur-mesure adaptés à vos processus et besoins spécifiques.</p>
        <a href="/contact" class="btn btn-primary btn-lg px-5">Discutons de votre projet</a>
      </div>
    </div>
  </div>
</section>

<?php $content = ob_get_clean(); require __DIR__ . '/layout.php'; ?>
