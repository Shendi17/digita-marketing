<?php require_once __DIR__ . '/../../../includes/partials/header.php'; ?>
<?php require_once __DIR__ . '/../../../includes/partials/navbar.php'; ?>

<!-- Formation Détail -->
<section class="formation-detail-page py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/formations">Formations</a></li>
                <?php if ($formation['category_slug']): ?>
                    <li class="breadcrumb-item">
                        <a href="/formations/categorie/<?= $formation['category_slug'] ?>">
                            <?= htmlspecialchars($formation['category_name']) ?>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="breadcrumb-item active"><?= htmlspecialchars($formation['service_name']) ?></li>
            </ol>
        </nav>
        
        <div class="row">
            <!-- Contenu principal -->
            <div class="col-lg-8">
                <!-- En-tête -->
                <div class="mb-4">
                    <?php if ($formation['category_name']): ?>
                        <a href="/formations/categorie/<?= $formation['category_slug'] ?>" class="badge bg-primary text-decoration-none mb-2">
                            <?= $formation['category_icon'] ?> <?= htmlspecialchars($formation['category_name']) ?>
                        </a>
                    <?php endif; ?>
                    
                    <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($formation['title']) ?></h1>
                    
                    <p class="lead text-muted"><?= htmlspecialchars($formation['description']) ?></p>
                    
                    <div class="d-flex gap-4 mb-4">
                        <div>
                            <i class="bi bi-clock text-primary"></i>
                            <strong><?= $formation['duration_hours'] ?> heures</strong>
                        </div>
                        <div>
                            <i class="bi bi-bar-chart text-primary"></i>
                            <strong><?= ucfirst($formation['level']) ?></strong>
                        </div>
                        <div>
                            <i class="bi bi-people text-primary"></i>
                            <strong><?= $formation['enrolled_count'] ?> inscrits</strong>
                        </div>
                        <?php if ($formation['rating'] > 0): ?>
                        <div>
                            <i class="bi bi-star-fill text-warning"></i>
                            <strong><?= number_format($formation['rating'], 1) ?>/5</strong>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Messages -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle"></i> <?= $_SESSION['success_message'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-circle"></i> <?= $_SESSION['error_message'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
                
                <!-- Statut inscription -->
                <?php if ($isEnrolled): ?>
                    <div class="alert alert-success">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-check-circle"></i> <strong>Vous êtes inscrit à cette formation</strong>
                                <div class="progress progress-medium mt-2">
                                    <div class="progress-bar" style="width: <?= $progress['progress'] ?>%">
                                        <?= $progress['progress'] ?>%
                                    </div>
                                </div>
                            </div>
                            <a href="/formations/<?= $formation['slug'] ?>/learn" class="btn btn-success">
                                <i class="bi bi-play-circle"></i> Commencer / Continuer
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Programme de la formation -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-list-check"></i> Programme de la formation</h4>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="modulesAccordion">
                            <?php foreach ($formation['modules'] as $index => $module): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" type="button" 
                                                data-bs-toggle="collapse" data-bs-target="#module<?= $module['id'] ?>">
                                            <strong>Module <?= $index + 1 ?> :</strong>&nbsp;<?= htmlspecialchars($module['title']) ?>
                                            <span class="badge bg-primary ms-2"><?= count($module['lessons']) ?> leçons</span>
                                        </button>
                                    </h2>
                                    <div id="module<?= $module['id'] ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" 
                                         data-bs-parent="#modulesAccordion">
                                        <div class="accordion-body">
                                            <p class="text-muted"><?= htmlspecialchars($module['description']) ?></p>
                                            <ul class="list-group">
                                                <?php foreach ($module['lessons'] as $lesson): ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <i class="bi bi-play-circle text-primary"></i>
                                                            <?= htmlspecialchars($lesson['title']) ?>
                                                            <?php if ($lesson['is_free']): ?>
                                                                <span class="badge bg-success ms-2">Gratuit</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <span class="text-muted"><?= $lesson['duration_minutes'] ?> min</span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Ce que vous allez apprendre -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="bi bi-lightbulb"></i> Ce que vous allez apprendre</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Maîtriser les fondamentaux</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Créer des stratégies efficaces</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Utiliser les outils professionnels</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Analyser les performances</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Optimiser vos campagnes</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Obtenir des résultats mesurables</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Formations liées -->
                <?php if (!empty($relatedFormations)): ?>
                    <section class="mt-5">
                        <h3 class="mb-4">Formations similaires</h3>
                        <div class="row g-3">
                            <?php foreach ($relatedFormations as $related): ?>
                                <div class="col-md-4">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <a href="/formations/<?= $related['slug'] ?>" class="text-dark text-decoration-none">
                                                    <?= htmlspecialchars($related['title']) ?>
                                                </a>
                                            </h6>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <small class="text-muted"><?= $related['duration_hours'] ?>h</small>
                                                <strong class="text-primary"><?= number_format($related['price'], 2) ?> €</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
            
            <!-- Sidebar - Inscription -->
            <div class="col-lg-4">
                <div class="card shadow-lg sticky-sidebar">
                    <div class="card-body text-center">
                        <div class="display-4 fw-bold text-primary mb-3">
                            <?= number_format($formation['price'], 2) ?> €
                        </div>
                        
                        <?php if (!$isEnrolled): ?>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <form action="/formations/<?= $formation['slug'] ?>/inscription" method="POST">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                        <i class="bi bi-cart-plus"></i> S'inscrire maintenant
                                    </button>
                                </form>
                            <?php else: ?>
                                <a href="/connexion" class="btn btn-primary btn-lg w-100 mb-3">
                                    <i class="bi bi-box-arrow-in-right"></i> Se connecter pour s'inscrire
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="/formations/<?= $formation['slug'] ?>/learn" class="btn btn-success btn-lg w-100 mb-3">
                                <i class="bi bi-play-circle"></i> Accéder à la formation
                            </a>
                        <?php endif; ?>
                        
                        <hr>
                        
                        <div class="text-start">
                            <h6 class="mb-3">Cette formation inclut :</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> <?= $formation['duration_hours'] ?> heures de vidéo</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> <?= count($formation['modules']) ?> modules complets</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Accès illimité à vie</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Certificat de fin de formation</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Support et assistance</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success"></i> Exercices pratiques</li>
                            </ul>
                        </div>
                        
                        <hr>
                        
                        <div class="text-start">
                            <h6 class="mb-3">Partager :</h6>
                            <div class="d-flex gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                                   target="_blank" class="btn btn-primary btn-sm flex-fill">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>&text=<?= urlencode($formation['title']) ?>" 
                                   target="_blank" class="btn btn-info btn-sm flex-fill text-white">
                                    <i class="bi bi-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']) ?>" 
                                   target="_blank" class="btn btn-primary btn-sm flex-fill">
                                    <i class="bi bi-linkedin"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Article de blog associé -->
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h6><i class="bi bi-journal-text"></i> Article de blog associé</h6>
                        <p class="small text-muted">Découvrez notre guide complet sur ce sujet</p>
                        <a href="/blog/<?= str_replace('formation-', '', $formation['slug']) ?>" class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-arrow-right"></i> Lire l'article
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../../../includes/partials/footer.php'; ?>
