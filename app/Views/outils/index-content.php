<!-- Hero Section Outils -->
<section class="outils-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">🛠️ Outils Digita</h1>
                <p class="lead mb-4">
                    Des outils puissants et faciles à utiliser pour optimiser votre marketing digital.
                    Gagnez du temps et boostez vos performances avec notre suite d'outils professionnels.
                </p>
                
                <!-- Barre de recherche -->
                <form action="/outils/search" method="GET" class="search-form">
                    <div class="input-group input-group-lg">
                        <input type="text" name="q" class="form-control" placeholder="Rechercher un outil..." required>
                        <button class="btn btn-light" type="submit">
                            <i class="bi bi-search"></i> Rechercher
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <i class="bi bi-tools hero-icon"></i>
            </div>
        </div>
    </div>
</section>

<!-- Catégories d'Outils -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="categories-scroll d-flex gap-2 overflow-auto pb-2">
            <a href="/outils" class="btn btn-outline-primary">
                <i class="bi bi-grid-3x3"></i> Tous
            </a>
            <a href="/outils/categorie/seo" class="btn btn-outline-primary">
                <i class="bi bi-search"></i> SEO
            </a>
            <a href="/outils/categorie/reseaux-sociaux" class="btn btn-outline-primary">
                <i class="bi bi-share"></i> Réseaux Sociaux
            </a>
            <a href="/outils/categorie/analytics" class="btn btn-outline-primary">
                <i class="bi bi-graph-up"></i> Analytics
            </a>
            <a href="/outils/categorie/automation" class="btn btn-outline-primary">
                <i class="bi bi-robot"></i> Automation
            </a>
        </div>
    </div>
</section>

<!-- Outils Populaires -->
<section class="py-5">
    <div class="container">
        <h3 class="mb-4"><i class="bi bi-fire text-danger"></i> Outils Populaires</h3>
        <div class="row g-4">
            <!-- Outil 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <i class="bi bi-search large-icon text-primary"></i>
                            </div>
                            <span class="badge bg-danger">
                                <i class="bi bi-fire"></i> Populaire
                            </span>
                        </div>
                        <h5 class="card-title">Analyseur SEO</h5>
                        <p class="card-text text-muted">Analysez et optimisez le référencement de votre site web en quelques clics.</p>
                        <ul class="list-unstyled small mb-3">
                            <li><i class="bi bi-check-circle text-success"></i> Audit SEO complet</li>
                            <li><i class="bi bi-check-circle text-success"></i> Suggestions d'amélioration</li>
                            <li><i class="bi bi-check-circle text-success"></i> Suivi des positions</li>
                            <li><i class="bi bi-check-circle text-success"></i> Analyse des concurrents</li>
                        </ul>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">Gratuit</span>
                            <a href="/outils/analyseur-seo" class="btn btn-sm btn-primary">
                                Essayer <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Outil 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <i class="bi bi-share large-icon text-success"></i>
                            </div>
                            <span class="badge bg-danger">
                                <i class="bi bi-fire"></i> Populaire
                            </span>
                        </div>
                        <h5 class="card-title">Planificateur Réseaux Sociaux</h5>
                        <p class="card-text text-muted">Planifiez et publiez vos contenus sur tous vos réseaux sociaux depuis une seule interface.</p>
                        <ul class="list-unstyled small mb-3">
                            <li><i class="bi bi-check-circle text-success"></i> Multi-plateformes</li>
                            <li><i class="bi bi-check-circle text-success"></i> Calendrier éditorial</li>
                            <li><i class="bi bi-check-circle text-success"></i> Publication automatique</li>
                            <li><i class="bi bi-check-circle text-success"></i> Statistiques détaillées</li>
                        </ul>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-success fw-bold">29€/mois</span>
                            <a href="/outils/planificateur-reseaux" class="btn btn-sm btn-success">
                                Essayer <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Outil 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-lift">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <i class="bi bi-graph-up large-icon text-warning"></i>
                            </div>
                            <span class="badge bg-danger">
                                <i class="bi bi-fire"></i> Populaire
                            </span>
                        </div>
                        <h5 class="card-title">Dashboard Analytics</h5>
                        <p class="card-text text-muted">Centralisez toutes vos données marketing dans un tableau de bord unique et intuitif.</p>
                        <ul class="list-unstyled small mb-3">
                            <li><i class="bi bi-check-circle text-success"></i> Données en temps réel</li>
                            <li><i class="bi bi-check-circle text-success"></i> Rapports personnalisés</li>
                            <li><i class="bi bi-check-circle text-success"></i> Intégrations multiples</li>
                            <li><i class="bi bi-check-circle text-success"></i> Export des données</li>
                        </ul>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-warning fw-bold">49€/mois</span>
                            <a href="/outils/dashboard-analytics" class="btn btn-sm btn-warning">
                                Essayer <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tous les Outils -->
<section class="py-5 bg-light">
    <div class="container">
        <h3 class="mb-4">Tous nos outils</h3>
        <div class="row g-4">
            <!-- Outil SEO -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-search medium-icon text-primary mb-3"></i>
                        <h6 class="card-title">Générateur de Mots-Clés</h6>
                        <p class="card-text small text-muted">Trouvez les meilleurs mots-clés pour votre SEO</p>
                        <a href="/outils/generateur-mots-cles" class="btn btn-sm btn-outline-primary">Accéder</a>
                    </div>
                </div>
            </div>

            <!-- Outil Email -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-envelope medium-icon text-success mb-3"></i>
                        <h6 class="card-title">Email Marketing</h6>
                        <p class="card-text small text-muted">Créez et envoyez des campagnes email efficaces</p>
                        <a href="/outils/email-marketing" class="btn btn-sm btn-outline-success">Accéder</a>
                    </div>
                </div>
            </div>

            <!-- Outil Design -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-palette medium-icon text-warning mb-3"></i>
                        <h6 class="card-title">Créateur de Visuels</h6>
                        <p class="card-text small text-muted">Créez des visuels professionnels facilement</p>
                        <a href="/outils/createur-visuels" class="btn btn-sm btn-outline-warning">Accéder</a>
                    </div>
                </div>
            </div>

            <!-- Outil Automation -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-robot medium-icon text-danger mb-3"></i>
                        <h6 class="card-title">Automation Marketing</h6>
                        <p class="card-text small text-muted">Automatisez vos tâches marketing répétitives</p>
                        <a href="/outils/automation" class="btn btn-sm btn-outline-danger">Accéder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<?php 
$ctaTitle = 'Besoin d\'un Outil Personnalisé ?';
$ctaText = 'Nous développons des outils sur-mesure adaptés à vos besoins spécifiques.';
$ctaLink = '/contact';
$ctaButton = 'Demander un devis';
$projectRoot = dirname(dirname(dirname(__DIR__)));
require_once $projectRoot . '/includes/partials/cta-section.php'; 
?>
