<?php require_once __DIR__ . '/../../../includes/partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../includes/partials/navbar.php'; ?>

<!-- Hero Section Recherche -->
<section class="blog-hero bg-gradient text-white py-5">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3">
            <i class="bi bi-search"></i> Résultats de recherche
        </h1>
        <p class="lead">
            <?= count($articles) ?> résultat(s) pour "<?= htmlspecialchars($query) ?>"
        </p>
        
        <!-- Barre de recherche -->
        <form action="/blog/search" method="GET" class="search-form mt-4">
            <div class="input-group input-group-lg">
                <input type="text" name="q" class="form-control" placeholder="Rechercher..." 
                       value="<?= htmlspecialchars($query) ?>" required>
                <button class="btn btn-light" type="submit">
                    <i class="bi bi-search"></i> Rechercher
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Résultats -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <?php if (empty($articles)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-inbox empty-icon"></i>
                        <h3 class="mt-4 mb-3">Aucun résultat trouvé</h3>
                        <p class="text-muted mb-4">Essayez avec d'autres mots-clés</p>
                        <a href="/blog" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> Retour au blog
                        </a>
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($articles as $article): ?>
                            <div class="col-md-6">
                                <article class="card h-100 shadow-sm hover-lift">
                                    <div class="card-body">
                                        <?php if ($article['category_name']): ?>
                                            <div class="mb-2">
                                                <a href="/blog/categorie/<?= $article['category_slug'] ?>" 
                                                   class="badge bg-primary text-decoration-none">
                                                    <?= htmlspecialchars($article['category_name']) ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        
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
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Catégories -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-grid-3x3"></i> Catégories</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($categories as $cat): ?>
                            <a href="/blog/categorie/<?= $cat['slug'] ?>" class="list-group-item list-group-item-action">
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
