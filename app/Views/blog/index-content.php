<!-- Hero Section Blog -->
<section class="page-hero hero-blog">
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
                <i class="bi bi-file-text-fill hero-icon"></i>
            </div>
        </div>
    </div>
</section>

<!-- Catégories -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="/blog" class="btn btn-primary">
                <i class="bi bi-grid-fill"></i> Toutes
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="/blog/categorie/<?= htmlspecialchars($cat['slug']) ?>" class="btn btn-outline-primary">
                    <?php if (!empty($cat['icon'])): ?>
                        <span class="category-icon"><?= $cat['icon'] ?></span>
                    <?php endif; ?>
                    <?= htmlspecialchars($cat['name']) ?>
                    <?php if (isset($cat['article_count']) && $cat['article_count'] > 0): ?>
                        <span class="badge bg-primary"><?= $cat['article_count'] ?></span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Articles -->
<section class="main-content py-5">
    <div class="container">
        <h2 class="mb-4">📰 Articles Populaires</h2>
        
        <div class="row g-4">
            <?php foreach ($popularArticles as $article): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <?php if (!empty($article['image_url'])): ?>
                            <img src="<?= htmlspecialchars($article['image_url']) ?>" class="card-img-top card-img-article" alt="<?= htmlspecialchars($article['title']) ?>">
                        <?php else: ?>
                            <div class="card-img-top card-img-placeholder bg-primary d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text text-white"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="badge bg-primary">
                                    <?php if (!empty($article['category_icon'])): ?>
                                        <i class="bi bi-<?= htmlspecialchars($article['category_icon']) ?>"></i>
                                    <?php endif; ?>
                                    <?= htmlspecialchars($article['category_name'] ?? 'Non catégorisé') ?>
                                </span>
                            </div>
                            <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                            <p class="card-text text-muted small">
                                <i class="bi bi-eye"></i> <?= number_format($article['views'] ?? 0) ?> vues
                                <?php if (!empty($article['published_at'])): ?>
                                    <i class="bi bi-calendar ms-2"></i> <?= date('d/m/Y', strtotime($article['published_at'])) ?>
                                <?php endif; ?>
                            </p>
                            <p class="card-text"><?= htmlspecialchars(substr($article['excerpt'] ?? '', 0, 100)) ?>...</p>
                            <a href="/blog/<?= htmlspecialchars($article['slug']) ?>" class="btn btn-primary btn-sm">
                                Lire la suite <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <h2 class="mt-5 mb-4">🆕 Articles Récents</h2>
        
        <div class="row g-4">
            <?php foreach ($recentArticles as $article): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <?php if (!empty($article['image_url'])): ?>
                            <img src="<?= htmlspecialchars($article['image_url']) ?>" class="card-img-top card-img-article" alt="<?= htmlspecialchars($article['title']) ?>">
                        <?php else: ?>
                            <div class="card-img-top card-img-placeholder bg-success d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-text text-white"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="mb-2">
                                <span class="badge bg-success">Nouveau</span>
                                <?php if (!empty($article['category_name'])): ?>
                                    <span class="badge bg-secondary ms-1">
                                        <?php if (!empty($article['category_icon'])): ?>
                                            <i class="bi bi-<?= htmlspecialchars($article['category_icon']) ?>"></i>
                                        <?php endif; ?>
                                        <?= htmlspecialchars($article['category_name']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                            <p class="card-text text-muted small">
                                <i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($article['created_at'])) ?>
                                <i class="bi bi-eye ms-2"></i> <?= number_format($article['views'] ?? 0) ?> vues
                            </p>
                            <p class="card-text"><?= htmlspecialchars(substr($article['excerpt'] ?? '', 0, 100)) ?>...</p>
                            <a href="/blog/<?= htmlspecialchars($article['slug']) ?>" class="btn btn-primary btn-sm">
                                Lire la suite <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA Section -->
<?php 
$ctaTitle = 'Vous ne trouvez pas ce que vous cherchez ?';
$ctaText = 'Contactez-nous pour des conseils personnalisés en marketing digital';
$ctaLink = '/contact';
$ctaButton = 'Nous contacter';
$projectRoot = dirname(dirname(dirname(__DIR__)));
require_once $projectRoot . '/includes/partials/cta-section.php'; 
?>
