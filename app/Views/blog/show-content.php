<!-- Article Detail Premium -->
<article class="blog-article-page bg-premium-grid animated" style="padding-top: 100px !important; min-height: 100vh;">
    <div class="container py-5">
        <div class="row align-items-center mb-5" data-aos="fade-up">
            <div class="col-lg-10 mx-auto text-center">
                <?php if (!empty($article['category_name'])): ?>
                    <a href="/blog/categorie/<?= htmlspecialchars($article['category_slug']) ?>" class="badge rounded-pill bg-premium-gold-gradient px-3 py-2 mb-3 text-dark fw-bold text-decoration-none">
                        <?= $article['category_icon'] ?> <?= htmlspecialchars($article['category_name']) ?>
                    </a>
                <?php endif; ?>
                <h1 class="display-3 fw-bold mb-4 text-white" style="font-family: var(--font-heading); line-height: 1.2;">
                    <?= htmlspecialchars($article['title']) ?>
                </h1>
                <div class="d-flex justify-content-center gap-4 text-white-50 small">
                    <span><i class="bi bi-calendar text-gold me-2"></i> <?= !empty($article['published_at']) ? date('d/m/Y', strtotime($article['published_at'])) : 'Non publié' ?></span>
                    <span><i class="bi bi-eye text-gold me-2"></i> <?= number_format($article['views']) ?> vues</span>
                    <?php if (!empty($readingTime)): ?>
                        <span><i class="bi bi-clock text-gold me-2"></i> <?= $readingTime ?> min</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <!-- Contenu principal -->
            <div class="col-lg-8" data-aos="fade-right">
                
                <!-- Main Glass Card -->
                <div class="glass-card p-0 overflow-hidden mb-5 border-glass shadow-lg">
                    <!-- Image principale -->
                    <?php if (!empty($article['image_url'])): ?>
                        <div class="article-hero-image" style="height: 400px; overflow: hidden;">
                            <img src="<?= htmlspecialchars($article['image_url']) ?>" class="w-100 h-100 object-fit-cover transition-all" alt="<?= htmlspecialchars($article['title']) ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-4 p-md-5 content-premium">
                        <!-- Breadcrumb Glass -->
                        <nav aria-label="breadcrumb" class="mb-5 pb-3 border-bottom border-glass">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none hover-gold">Accueil</a></li>
                                <li class="breadcrumb-item"><a href="/blog" class="text-white-50 text-decoration-none hover-gold">Blog</a></li>
                                <li class="breadcrumb-item active text-gold" aria-current="page">Analyse</li>
                            </ol>
                        </nav>

                        <!-- Table des matières Premium -->
                        <?php if (!empty($tableOfContents)): ?>
                            <div class="glass-card p-4 mb-5 border-blue bg-premium-dark-blue opacity-90">
                                <h5 class="fw-bold mb-3 text-blue"><i class="bi bi-list-nested me-2"></i> Architecture de l'analyse</h5>
                                <ul class="list-unstyled mb-0">
                                    <?php foreach ($tableOfContents as $tocItem): ?>
                                        <li class="<?= $tocItem['level'] === 3 ? 'ms-4' : '' ?> mb-2">
                                            <a href="#<?= htmlspecialchars($tocItem['slug']) ?>" class="text-white-50 text-decoration-none small hover-gold transition-all d-flex align-items-center">
                                                <i class="bi bi-chevron-right me-2" style="font-size: 0.7rem; color: var(--gold);"></i>
                                                <?= htmlspecialchars($tocItem['text']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Corps de l'article -->
                        <div class="article-content text-white-50" style="font-size: 1.1rem; line-height: 1.8;">
                            <?php
                            $content = $article['content'];
                            $content = preg_replace('/^### (.+)$/m', '<h3 class="text-white mt-5 mb-3 fw-bold" id="$1">$1</h3>', $content);
                            $content = preg_replace('/^## (.+)$/m', '<h2 class="text-white mt-5 mb-4 fw-bold border-bottom border-glass pb-2" id="$1">$1</h2>', $content);
                            $content = preg_replace('/\*\*(.+?)\*\*/', '<strong class="text-gold">$1</strong>', $content);
                            $content = preg_replace('/^- (.+)$/m', '<li class="mb-2"><i class="bi bi-check2-circle text-gold me-2"></i>$1</li>', $content);
                            $content = preg_replace('/(<li>.*<\/li>)/s', '<ul class="list-unstyled my-4">$1</ul>', $content);
                            $content = preg_replace('/\n\n/', '</p><p class="mb-4">', $content);
                            echo '<p class="mb-4">' . $content . '</p>';
                            ?>
                        </div>
                    </div>
                </div>
                
                <!-- CTA Final Premium -->
                <div class="glass-card p-5 border-gold shadow-gold-glow text-center" data-aos="zoom-in">
                    <h3 class="text-white fw-bold mb-3">Prêt à implémenter ces stratégies ?</h3>
                    <p class="text-white-50 mb-4">Nos experts en automatisation et IA sont prêts à propulser votre entreprise au niveau supérieur.</p>
                    <a href="/contact" class="btn-premium btn-premium-gold px-5 py-3">Obtenir un Audit Personnalisé</a>
                </div>
            </div>
            
            <!-- Sidebar Premium -->
            <div class="col-lg-4" data-aos="fade-left">
                <!-- Partage Social Glass -->
                <div class="glass-card p-4 mb-4 border-glass text-center">
                    <h6 class="text-white mb-3 text-uppercase small fw-bold" style="letter-spacing: 2px;">Diffuser le savoir</h6>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="#" class="btn-premium btn-premium-blue p-0 rounded-circle d-flex align-items-center justify-content-center shadow-blue-glow" style="width: 40px; height: 40px;"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="btn-premium btn-premium-gold p-0 rounded-circle d-flex align-items-center justify-content-center shadow-gold-glow" style="width: 40px; height: 40px; color: var(--dark);"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="glass-card p-0 rounded-circle d-flex align-items-center justify-content-center border-glass" style="width: 40px; height: 40px; color: white;"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>

                <!-- Articles Populaires Glass -->
                <div class="glass-card p-4 mb-4 border-glass">
                    <h6 class="text-gold mb-4 text-uppercase small fw-bold" style="letter-spacing: 2px;"><i class="bi bi-fire me-2"></i> Analyses Tendances</h6>
                    <div class="list-group list-group-flush bg-transparent">
                        <?php foreach ($popularArticles as $popular): ?>
                            <a href="/blog/<?= htmlspecialchars($popular['slug']) ?>" class="list-group-item bg-transparent border-glass text-white px-0 py-3 hover-gold-text transition-all">
                                <h6 class="mb-2 small fw-bold" style="line-height: 1.4;"><?= htmlspecialchars($popular['title']) ?></h6>
                                <div class="d-flex justify-content-between align-items-center opacity-50 small">
                                    <span><?= number_format($popular['views']) ?> lectures</span>
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Newsletter Glass -->
                <div class="glass-card p-4 border-blue">
                    <h5 class="text-white fw-bold mb-3">Vision Stratégique</h5>
                    <p class="text-white-50 small mb-4">Recevez chaque semaine nos meilleures analyses sur l'IA et l'automatisation directement dans votre boîte.</p>
                    <div class="form-group mb-3">
                        <input type="email" class="form-control glass-card border-glass text-white bg-transparent p-3 shadow-none" placeholder="Votre email expert...">
                    </div>
                    <button class="btn-premium btn-premium-blue w-100 py-3 shadow-blue-glow">S'abonner à la veille</button>
                </div>
            </div>
        </div>

        <!-- Section Articles Liés & Formation -->
        <div class="row g-5 mt-5">
            <div class="col-lg-8" data-aos="fade-up">
                <?php if (!empty($relatedArticles)): ?>
                    <h3 class="text-white fw-bold mb-5"><i class="bi bi-plus-circle text-gold me-3"></i> Poursuivre la lecture</h3>
                    <div class="row g-4">
                        <?php foreach ($relatedArticles as $related): ?>
                            <div class="col-md-6">
                                <a href="/blog/<?= htmlspecialchars($related['slug']) ?>" class="text-decoration-none">
                                    <div class="glass-card p-4 h-100 border-glass hover-gold-border transition-all">
                                        <span class="badge text-gold border border-gold mb-3 px-2 py-1" style="font-size: 0.6rem;"><?= htmlspecialchars($related['category_name'] ?? 'Analyse') ?></span>
                                        <h5 class="text-white fw-bold mb-0" style="line-height: 1.4;"><?= htmlspecialchars($related['title']) ?></h5>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Widget Formation (Fidélisation demandée par l'user) -->
            <div class="col-lg-4" data-aos="fade-left">
                <?php if (!empty($relatedFormation)): ?>
                    <div class="glass-card p-4 border-gold h-100 d-flex flex-column" style="background: linear-gradient(135deg, rgba(212,175,55,0.05) 0%, rgba(5,5,5,0.8) 100%);">
                        <span class="text-gold uppercase small tracking-widest fw-bold mb-2">Recommandation du Cabinet</span>
                        <h4 class="text-white fw-bold mb-3"><?= htmlspecialchars($relatedFormation['title']) ?></h4>
                        <p class="text-white-50 small mb-4 flex-grow-1">
                            Maîtrisez les concepts abordés dans cet article grâce à notre programme intensif d'accompagnement.
                        </p>
                        <div class="mt-auto">
                            <a href="/formations/<?= $relatedFormation['slug'] ?>" class="btn btn-premium w-100 py-3 fw-bold tracking-wider">
                                DÉCOUVRIR LE PROGRAMME <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Fallback vers Audit Flash si pas de formation spécifique -->
                    <div class="glass-card p-4 border-glass h-100 d-flex flex-column bg-premium-dark-blue">
                        <h5 class="text-white fw-bold mb-3">Besoin d'un avis expert ?</h5>
                        <p class="text-white-50 small mb-4">Sollicitez un audit gratuit de 15 minutes pour discuter de votre stratégie digitale.</p>
                        <button class="btn-premium btn-premium-blue w-100 py-3 mt-auto" data-bs-toggle="modal" data-bs-target="#auditModal">
                            DEMANDER MON AUDIT
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>
