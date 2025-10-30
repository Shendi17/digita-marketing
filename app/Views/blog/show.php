<?php
/**
 * FICHIER OBSOLÈTE - NE PLUS UTILISER
 * Utiliser show-content.php à la place
 * Ce fichier est conservé pour référence uniquement
 */
die('Cette vue est obsolète. Utilisez show-content.php à la place.');
?>

<!-- ANCIEN CODE - NE PLUS UTILISER -->
<?php /*
<?php require_once __DIR__ . '/../../../includes/partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../includes/partials/navbar.php'; ?>

<!-- Article -->
<article class="blog-article-page py-5">
    <div class="container">
        <div class="row">
            <!-- Contenu principal -->
            <div class="col-lg-8">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="/blog">Blog</a></li>
                        <?php if ($article['category_slug']): ?>
                            <li class="breadcrumb-item">
                                <a href="/blog/categorie/<?= $article['category_slug'] ?>">
                                    <?= htmlspecialchars($article['category_name']) ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="breadcrumb-item active"><?= htmlspecialchars($article['service_name']) ?></li>
                    </ol>
                </nav>
                
                <!-- En-tête article -->
                <header class="mb-4">
                    <?php if ($article['category_name']): ?>
                        <a href="/blog/categorie/<?= $article['category_slug'] ?>" class="badge bg-primary text-decoration-none mb-3">
                            <?= $article['category_icon'] ?> <?= htmlspecialchars($article['category_name']) ?>
                        </a>
                    <?php endif; ?>
                    
                    <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($article['title']) ?></h1>
                    
                    <div class="d-flex gap-3 text-muted mb-4">
                        <span><i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($article['published_at'])) ?></span>
                        <span><i class="bi bi-eye"></i> <?= number_format($article['views']) ?> vues</span>
                    </div>
                </header>
                
                <!-- Image principale -->
                <?php if ($article['image_url']): ?>
                    <img src="<?= htmlspecialchars($article['image_url']) ?>" class="img-fluid rounded mb-4" alt="<?= htmlspecialchars($article['title']) ?>">
                <?php endif; ?>
                
                <!-- Contenu de l'article -->
                <div class="article-content">
                    <?php
                    // Convertir le markdown en HTML (simple)
                    $content = $article['content'];
                    
                    // Titres
                    $content = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $content);
                    $content = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $content);
                    $content = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $content);
                    
                    // Gras
                    $content = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $content);
                    
                    // Listes
                    $content = preg_replace('/^- (.+)$/m', '<li>$1</li>', $content);
                    $content = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $content);
                    
                    // Liens
                    $content = preg_replace('/\[(.+?)\]\((.+?)\)/', '<a href="$2">$1</a>', $content);
                    
                    // Paragraphes
                    $content = preg_replace('/\n\n/', '</p><p>', $content);
                    $content = '<p>' . $content . '</p>';
                    
                    echo $content;
                    ?>
                </div>
                
                <!-- CTA -->
                <div class="alert alert-primary mt-5">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5><i class="bi bi-rocket"></i> Prêt à passer à l'action ?</h5>
                            <p class="mb-0">Contactez-nous pour discuter de votre projet <?= htmlspecialchars($article['service_name']) ?></p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="/contact" class="btn btn-primary">
                                <i class="bi bi-envelope"></i> Nous contacter
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Articles liés -->
                <?php if (!empty($relatedArticles)): ?>
                    <section class="mt-5">
                        <h3 class="mb-4">Articles liés</h3>
                        <div class="row g-3">
                            <?php foreach ($relatedArticles as $related): ?>
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <a href="/blog/<?= $related['slug'] ?>" class="text-dark text-decoration-none">
                                                    <?= htmlspecialchars($related['title']) ?>
                                                </a>
                                            </h6>
                                            <small class="text-muted"><?= $related['category_name'] ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Formation associée -->
                <div class="card shadow-sm mb-4 bg-gradient text-white">
                    <div class="card-body">
                        <h5><i class="bi bi-mortarboard"></i> Formation disponible</h5>
                        <p>Maîtrisez <?= htmlspecialchars($article['service_name']) ?> avec notre formation complète !</p>
                        <a href="/formations/formation-<?= $article['slug'] ?>" class="btn btn-light">
                            <i class="bi bi-play-circle"></i> Voir la formation
                        </a>
                    </div>
                </div>
                
                <!-- Articles populaires -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-fire"></i> Articles Populaires</h6>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php foreach ($popularArticles as $popular): ?>
                            <a href="/blog/<?= $popular['slug'] ?>" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 small"><?= htmlspecialchars($popular['title']) ?></h6>
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-eye"></i> <?= number_format($popular['views']) ?>
                                </small>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Partage social -->
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="mb-3">Partager cet article</h6>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                               target="_blank" class="btn btn-primary btn-sm">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($article['title']) ?>" 
                               target="_blank" class="btn btn-info btn-sm text-white">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                               target="_blank" class="btn btn-primary btn-sm">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

<?php require_once __DIR__ . '/../../../includes/partials/footer.php'; ?>
