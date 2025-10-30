<?php require_once __DIR__ . '/../../../includes/partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../includes/partials/navbar.php'; ?>

<!-- Hero Section Catégorie -->
<section class="formations-hero bg-gradient text-white py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="/" class="text-white">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/formations" class="text-white">Formations</a></li>
                <li class="breadcrumb-item active text-white"><?= htmlspecialchars($category['name']) ?></li>
            </ol>
        </nav>
        
        <h1 class="display-4 fw-bold mb-3">
            <?= $category['icon'] ?> <?= htmlspecialchars($category['name']) ?>
        </h1>
        <p class="lead"><?= $totalFormations ?> formation(s) dans cette catégorie</p>
    </div>
</section>

<!-- Formations -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-9">
                <div class="row g-4">
                    <?php if (empty($formations)): ?>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Aucune formation dans cette catégorie.
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($formations as $formation): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm hover-lift">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
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
                                                <i class="bi bi-people"></i> <?= $formation['enrolled_count'] ?>
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
                                    <a class="page-link" href="/formations/categorie/<?= $category['slug'] ?>?page=<?= $page - 1 ?>">Précédent</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="/formations/categorie/<?= $category['slug'] ?>?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="/formations/categorie/<?= $category['slug'] ?>?page=<?= $page + 1 ?>">Suivant</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-3">
                <!-- Autres catégories -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-grid-3x3"></i> Catégories</h6>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($categories as $cat): ?>
                            <a href="/formations/categorie/<?= $cat['slug'] ?>" 
                               class="list-group-item list-group-item-action <?= $cat['slug'] === $category['slug'] ? 'active' : '' ?>">
                                <small><?= $cat['icon'] ?> <?= htmlspecialchars($cat['name']) ?></small>
                                <span class="badge bg-primary float-end"><?= $cat['formation_count'] ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/partials/footer.php'; ?>
