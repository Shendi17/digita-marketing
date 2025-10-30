<!-- Article -->
<article class="blog-article-page bg-light" style="padding-top: 120px !important; margin-top: 0 !important;">
    <div class="container">
        <div class="row">
            <!-- Contenu principal -->
            <div class="col-lg-8">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-white p-3 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="/blog" class="text-decoration-none">Blog</a></li>
                        <?php if (!empty($article['category_slug'])): ?>
                            <li class="breadcrumb-item">
                                <a href="/blog/categorie/<?= htmlspecialchars($article['category_slug']) ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($article['category_name']) ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="breadcrumb-item active" aria-current="page">Article</li>
                    </ol>
                </nav>
                
                <!-- En-tête article (AVANT la card) -->
                <div class="mb-4">
                    <?php if (!empty($article['category_name'])): ?>
                        <a href="/blog/categorie/<?= htmlspecialchars($article['category_slug']) ?>" class="badge bg-primary text-decoration-none mb-2">
                            <?= $article['category_icon'] ?> <?= htmlspecialchars($article['category_name']) ?>
                        </a>
                    <?php endif; ?>
                    
                    <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($article['title']) ?></h1>
                    
                    <div class="d-flex gap-3 text-muted mb-4">
                        <span><i class="bi bi-calendar"></i> <?= date('d/m/Y', strtotime($article['published_at'])) ?></span>
                        <span><i class="bi bi-eye"></i> <?= number_format($article['views']) ?> vues</span>
                    </div>
                </div>
                
                <!-- Contenu article -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        
                        <!-- Image principale -->
                        <?php if (!empty($article['image_url'])): ?>
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
                    </div>
                </div>
                
                <!-- CTA -->
                <div class="card shadow-sm mb-4 border-primary">
                    <div class="card-body bg-primary bg-opacity-10">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="text-primary"><i class="bi bi-rocket"></i> Prêt à passer à l'action ?</h5>
                                <p class="mb-0">Contactez-nous pour discuter de votre projet</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="/contact" class="btn btn-primary">
                                    <i class="bi bi-envelope"></i> Nous contacter
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Articles liés -->
                <?php if (!empty($relatedArticles)): ?>
                    <section class="mb-4">
                        <h3 class="mb-4">Articles liés</h3>
                        <div class="row g-3">
                            <?php foreach ($relatedArticles as $related): ?>
                                <div class="col-md-4">
                                    <div class="card shadow-sm hover-lift">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <a href="/blog/<?= htmlspecialchars($related['slug']) ?>" class="text-dark text-decoration-none">
                                                    <?= htmlspecialchars($related['title']) ?>
                                                </a>
                                            </h6>
                                            <small class="text-muted"><?= htmlspecialchars($related['category_name']) ?></small>
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
                <div class="card shadow-sm mb-4 bg-primary text-white">
                    <div class="card-body">
                        <h5 class="text-white"><i class="bi bi-mortarboard"></i> Formation disponible</h5>
                        <p class="text-white">Maîtrisez ce sujet avec notre formation complète !</p>
                        <a href="/formations" class="btn btn-light">
                            <i class="bi bi-play-circle"></i> Voir les formations
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
                            <a href="/blog/<?= htmlspecialchars($popular['slug']) ?>" class="list-group-item list-group-item-action">
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
                               target="_blank" class="btn btn-primary btn-sm" rel="noopener noreferrer">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($article['title']) ?>" 
                               target="_blank" class="btn btn-info btn-sm text-white" rel="noopener noreferrer">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                               target="_blank" class="btn btn-primary btn-sm" rel="noopener noreferrer">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Retour au blog -->
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <a href="/blog" class="btn btn-outline-primary w-100">
                            <i class="bi bi-arrow-left"></i> Retour au blog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
