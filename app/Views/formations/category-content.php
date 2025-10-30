<!-- Hero Section Catégorie -->
<section class="hero-section text-white">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent mb-0">
                <li class="breadcrumb-item"><a href="/" class="text-white text-decoration-none">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/formations" class="text-white text-decoration-none">Formations</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page"><?= htmlspecialchars($category['name']) ?></li>
            </ol>
        </nav>
        
        <h1 class="display-4 fw-bold mb-3">
            <?= $category['icon'] ?> <?= htmlspecialchars($category['name']) ?>
        </h1>
        <p class="lead mb-0"><?= $totalFormations ?> formation(s) dans cette catégorie</p>
    </div>
</section>

<!-- Catégorie Formations -->
<section class="formations-category-page bg-light py-5">
    <div class="container">
        
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <?php if (empty($formations)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Aucune formation dans cette catégorie pour le moment.
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($formations as $formation): ?>
                            <div class="col-md-6">
                                <div class="card h-100 shadow-sm hover-lift">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <span class="badge bg-<?= $formation['level'] === 'debutant' ? 'success' : ($formation['level'] === 'intermediaire' ? 'warning' : 'danger') ?>">
                                                <?= ucfirst($formation['level']) ?>
                                            </span>
                                            <span class="text-muted small">
                                                <i class="bi bi-clock"></i> <?= $formation['duration_hours'] ?>h
                                            </span>
                                        </div>
                                        
                                        <h5 class="card-title mb-3">
                                            <a href="/formations/<?= htmlspecialchars($formation['slug']) ?>" class="text-dark text-decoration-none">
                                                <?= htmlspecialchars($formation['title']) ?>
                                            </a>
                                        </h5>
                                        
                                        <p class="card-text text-muted small mb-3">
                                            <?= htmlspecialchars(mb_substr($formation['description'], 0, 100)) ?>...
                                        </p>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-primary fw-bold"><?= number_format($formation['price'], 2) ?> €</span>
                                            <div class="d-flex gap-2">
                                                <?php if (!empty($formation['article_slug'])): ?>
                                                    <a href="/blog/<?= htmlspecialchars($formation['article_slug']) ?>" class="btn btn-sm btn-outline-secondary" title="Lire l'article associé">
                                                        <i class="bi bi-file-text"></i> Article
                                                    </a>
                                                <?php endif; ?>
                                                <a href="/formations/<?= htmlspecialchars($formation['slug']) ?>" class="btn btn-sm btn-outline-primary">
                                                    Voir détails <i class="bi bi-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <nav aria-label="Navigation pagination" class="mt-5">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Catégories -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-grid-3x3"></i> Autres Catégories</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($categories as $cat): ?>
                            <a href="/formations/categorie/<?= $cat['slug'] ?>" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center <?= $cat['slug'] === $category['slug'] ? 'active' : '' ?>">
                                <span class="category-name">
                                    <?= $cat['icon'] ?> <?= htmlspecialchars($cat['name']) ?>
                                </span>
                                <span class="badge bg-primary rounded-pill"><?= $cat['formation_count'] ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Retour aux formations -->
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <a href="/formations" class="btn btn-outline-primary w-100">
                            <i class="bi bi-arrow-left"></i> Toutes les formations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
