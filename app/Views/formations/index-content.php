<!-- Hero Section Formations -->
<section class="formations-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">🎓 Formations Digita</h1>
                <p class="lead mb-4">
                    Développez vos compétences en marketing digital avec nos formations complètes.
                    Plus de <?= $totalFormations ?> formations pour devenir un expert !
                </p>
                
                <!-- Barre de recherche -->
                <form action="/formations/search" method="GET" class="search-form">
                    <div class="input-group input-group-lg">
                        <input type="text" name="q" class="form-control" placeholder="Rechercher une formation..." required>
                        <button class="btn btn-light" type="submit">
                            <i class="bi bi-search"></i> Rechercher
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <i class="bi bi-mortarboard-fill hero-icon"></i>
            </div>
        </div>
    </div>
</section>

<!-- Statistiques -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3">
                <h3 class="fw-bold text-primary"><?= $totalFormations ?>+</h3>
                <p class="mb-0">Formations</p>
            </div>
            <div class="col-md-3">
                <h3 class="fw-bold text-primary">3000+</h3>
                <p class="mb-0">Heures de contenu</p>
            </div>
            <div class="col-md-3">
                <h3 class="fw-bold text-primary">100%</h3>
                <p class="mb-0">En ligne</p>
            </div>
            <div class="col-md-3">
                <h3 class="fw-bold text-primary">24/7</h3>
                <p class="mb-0">Accès illimité</p>
            </div>
        </div>
    </div>
</section>

<!-- Catégories -->
<section class="py-4 bg-white border-bottom">
    <div class="container">
        <div class="categories-scroll d-flex gap-2 overflow-auto pb-2">
            <a href="/formations" class="btn btn-outline-primary">
                <i class="bi bi-grid-3x3"></i> Toutes
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="/formations/categorie/<?= $cat['slug'] ?>" class="btn btn-outline-primary">
                    <?= $cat['icon'] ?> <?= htmlspecialchars($cat['name']) ?>
                    <span class="badge bg-primary"><?= $cat['formation_count'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Formations populaires -->
<?php if (!empty($popularFormations)): ?>
<section class="py-4 bg-light">
    <div class="container">
        <h3 class="mb-4"><i class="bi bi-fire text-danger"></i> Formations Populaires</h3>
        <div class="row g-3">
            <?php foreach (array_slice($popularFormations, 0, 3) as $formation): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-danger">
                                    <i class="bi bi-fire"></i> Populaire
                                </span>
                                <span class="badge bg-<?= $formation['level'] === 'debutant' ? 'success' : ($formation['level'] === 'intermediaire' ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($formation['level']) ?>
                                </span>
                            </div>
                            <h5 class="card-title"><?= htmlspecialchars($formation['title']) ?></h5>
                            <p class="card-text text-muted small"><?= htmlspecialchars(substr($formation['description'], 0, 100)) ?>...</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i> <?= $formation['duration_hours'] ?>h
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-people"></i> <?= $formation['enrolled_count'] ?> inscrits
                                    </small>
                                </div>
                                <div class="text-end">
                                    <div class="h5 mb-0 text-primary"><?= number_format($formation['price'], 2) ?> €</div>
                                </div>
                            </div>
                            <a href="/formations/<?= $formation['slug'] ?>" class="btn btn-primary w-100 mt-3">
                                Voir la formation <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Toutes les formations -->
<section class="py-5">
    <div class="container">
        <h3 class="mb-4">Toutes les formations</h3>
        
        <div class="row g-4">
            <?php if (empty($formations)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Aucune formation trouvée.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($formations as $formation): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-lift">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <?php if ($formation['category_name']): ?>
                                        <a href="/formations/categorie/<?= $formation['category_slug'] ?>" class="badge bg-primary text-decoration-none">
                                            <?= $formation['category_icon'] ?> <?= htmlspecialchars($formation['category_name']) ?>
                                        </a>
                                    <?php endif; ?>
                                    <span class="badge bg-<?= $formation['level'] === 'debutant' ? 'success' : ($formation['level'] === 'intermediaire' ? 'warning' : 'danger') ?>">
                                        <?= ucfirst($formation['level']) ?>
                                    </span>
                                </div>
                                
                                <h5 class="card-title">
                                    <a href="/formations/<?= $formation['slug'] ?>" class="text-dark text-decoration-none">
                                        <?= htmlspecialchars($formation['title']) ?>
                                    </a>
                                </h5>
                                
                                <p class="card-text text-muted small">
                                    <?= htmlspecialchars(substr($formation['description'], 0, 120)) ?>...
                                </p>
                                
                                <div class="mb-3">
                                    <small class="text-muted me-3">
                                        <i class="bi bi-clock"></i> <?= $formation['duration_hours'] ?>h
                                    </small>
                                    <small class="text-muted">
                                        <i class="bi bi-people"></i> <?= $formation['enrolled_count'] ?> inscrits
                                    </small>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="h5 mb-0 text-primary"><?= number_format($formation['price'], 2) ?> €</div>
                                    <a href="/formations/<?= $formation['slug'] ?>" class="btn btn-sm btn-outline-primary">
                                        Voir <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav class="mt-5">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="/formations?page=<?= $page - 1 ?>">Précédent</a>
                        </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link" href="/formations?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="/formations?page=<?= $page + 1 ?>">Suivant</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<?php 
$ctaTitle = 'Vous ne trouvez pas la formation qu\'il vous faut ?';
$ctaText = 'Contactez-nous pour une formation sur-mesure adaptée à vos besoins';
$ctaLink = '/contact';
$ctaButton = 'Nous contacter';
$projectRoot = dirname(dirname(dirname(__DIR__)));
require_once $projectRoot . '/includes/partials/cta-section.php'; 
?>
