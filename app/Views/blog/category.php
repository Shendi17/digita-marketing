<?php require_once __DIR__ . '/../../../includes/partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../includes/partials/navbar.php'; ?>

<!-- Hero Section Catégorie -->
<section class="blog-hero bg-gradient text-white py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb bg-transparent">
                <li class="breadcrumb-item"><a href="/" class="text-white">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/blog" class="text-white">Blog</a></li>
                <li class="breadcrumb-item active text-white"><?= htmlspecialchars($category['name']) ?></li>
            </ol>
        </nav>
        
        <h1 class="display-4 fw-bold mb-3">
            <?= $category['icon'] ?> <?= htmlspecialchars($category['name']) ?>
        </h1>
        <p class="lead"><?= $totalArticles ?> article(s) dans cette catégorie</p>
    </div>
</section>

<!-- Articles -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <div class="row g-4">
                    <?php if (empty($articles)): ?>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Aucun article dans cette catégorie.
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($articles as $article): ?>
                            <div class="col-md-6">
                                <article class="card h-100 shadow-sm hover-lift">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="/blog/<?= $article['slug'] ?>" class="text-dark text-decoration-none">
                                                <?= htmlspecialchars($article['title']) ?>
                                            </a>
                                        </h5>
                                        <p class="card-text text-muted small">
                                            <?= htmlspecialchars(substr($article['excerpt'], 0, 150)) ?>...
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <small class="text-muted">
                                                <i class="bi bi-eye"></i> <?= number_format($article['views']) ?>
                                            </small>
                                            <a href="/blog/<?= $article['slug'] ?>" class="btn btn-sm btn-outline-primary">
                                                Lire <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </article>
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
                                    <a class="page-link" href="/blog/categorie/<?= $category['slug'] ?>?page=<?= $page - 1 ?>">Précédent</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="/blog/categorie/<?= $category['slug'] ?>?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="/blog/categorie/<?= $category['slug'] ?>?page=<?= $page + 1 ?>">Suivant</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Autres catégories -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-grid-3x3"></i> Autres Catégories</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($categories as $cat): ?>
                            <a href="/blog/categorie/<?= $cat['slug'] ?>" 
                               class="list-group-item list-group-item-action <?= $cat['slug'] === $category['slug'] ? 'active' : '' ?>">
                                <?= $cat['icon'] ?> <?= htmlspecialchars($cat['name']) ?>
                                <span class="badge bg-primary float-end"><?= $cat['article_count'] ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Articles populaires -->
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-fire"></i> Populaires</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($popularArticles as $popular): ?>
                            <a href="/blog/<?= $popular['slug'] ?>" class="list-group-item list-group-item-action">
                                <h6 class="mb-1 small"><?= htmlspecialchars($popular['title']) ?></h6>
                                <small class="text-muted">
                                    <i class="bi bi-eye"></i> <?= number_format($popular['views']) ?>
                                </small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/partials/footer.php'; ?>
