<?php require_once __DIR__ . '/../../../includes/partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../includes/partials/navbar.php'; ?>

<!-- Hero Section Blog -->
<section class="blog-hero bg-gradient text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">📝 Blog Digita</h1>
                <p class="lead mb-4">
                    Découvrez nos guides complets, conseils d'experts et actualités du marketing digital.
                    Plus de <?= $totalArticles ?> articles pour booster votre présence en ligne !
                </p>
                
                <!-- Barre de recherche -->
                <form action="/blog/search" method="GET" class="search-form">
                    <div class="input-group input-group-lg">
                        <input type="text" name="q" class="form-control" placeholder="Rechercher un article..." required>
                        <button class="btn btn-light" type="submit">
                            <i class="bi bi-search"></i> Rechercher
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <i class="bi bi-journal-text hero-icon"></i>
            </div>
        </div>
    </div>
</section>

<!-- Catégories -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="categories-scroll d-flex gap-2 overflow-auto pb-2">
            <a href="/blog" class="btn btn-outline-primary">
                <i class="bi bi-grid-3x3"></i> Tous
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="/blog/categorie/<?= $cat['slug'] ?>" class="btn btn-outline-primary">
                    <?= $cat['icon'] ?> <?= htmlspecialchars($cat['name']) ?>
                    <span class="badge bg-primary"><?= $cat['article_count'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Articles -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Colonne principale - Articles -->
            <div class="col-lg-8">
                <div class="row g-4">
                    <?php if (empty($articles)): ?>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Aucun article trouvé.
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($articles as $article): ?>
                            <div class="col-md-6">
                                <article class="card h-100 shadow-sm hover-lift">
                                    <?php if ($article['image_url']): ?>
                                        <img src="<?= htmlspecialchars($article['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($article['title']) ?>">
                                    <?php else: ?>
                                        <div class="card-img-top card-img-placeholder bg-gradient text-white d-flex align-items-center justify-content-center">
                                            <i class="bi bi-file-text"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-body">
                                        <?php if ($article['category_name']): ?>
                                            <div class="mb-2">
                                                <a href="/blog/categorie/<?= $article['category_slug'] ?>" class="badge bg-primary text-decoration-none">
                                                    <?= $article['category_icon'] ?> <?= htmlspecialchars($article['category_name']) ?>
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
                                                <i class="bi bi-eye"></i> <?= number_format($article['views']) ?> vues
                                            </small>
                                            <a href="/blog/<?= $article['slug'] ?>" class="btn btn-sm btn-outline-primary">
                                                Lire la suite <i class="bi bi-arrow-right"></i>
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
                                    <a class="page-link" href="/blog?page=<?= $page - 1 ?>">Précédent</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="/blog?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="/blog?page=<?= $page + 1 ?>">Suivant</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Articles populaires -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-fire"></i> Articles Populaires</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($popularArticles as $popular): ?>
                            <a href="/blog/<?= $popular['slug'] ?>" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?= htmlspecialchars($popular['title']) ?></h6>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-eye"></i> <?= number_format($popular['views']) ?> vues
                                </small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Articles récents -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Articles Récents</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($recentArticles as $recent): ?>
                            <a href="/blog/<?= $recent['slug'] ?>" class="list-group-item list-group-item-action">
                                <h6 class="mb-1"><?= htmlspecialchars($recent['title']) ?></h6>
                                <small class="text-muted">
                                    <?= $recent['category_name'] ?>
                                </small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- CTA Formations -->
                <div class="card shadow-sm bg-gradient text-white">
                    <div class="card-body text-center">
                        <i class="bi bi-mortarboard medium-icon"></i>
                        <h5 class="mt-3">Passez à la pratique !</h5>
                        <p>Découvrez nos formations complètes pour maîtriser le marketing digital.</p>
                        <a href="/formations" class="btn btn-light">
                            <i class="bi bi-arrow-right"></i> Voir les formations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/partials/footer.php'; ?>
