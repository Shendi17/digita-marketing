<!-- Formation Détail -->
<section class="formation-detail-page bg-light" style="padding-top: 120px !important; margin-top: 0 !important;">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white p-3 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/formations" class="text-decoration-none">Formations</a></li>
                <?php if (!empty($formation['category_slug'])): ?>
                    <li class="breadcrumb-item">
                        <a href="/formations/categorie/<?= htmlspecialchars($formation['category_slug']) ?>" class="text-decoration-none">
                            <?= htmlspecialchars($formation['category_name']) ?>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="breadcrumb-item active" aria-current="page">Formation</li>
            </ol>
        </nav>
        
        <div class="row">
            <!-- Contenu principal -->
            <div class="col-lg-8">
                <!-- En-tête formation (AVANT la card) -->
                <div class="mb-4">
                    <?php if (!empty($formation['category_name'])): ?>
                        <a href="/formations/categorie/<?= htmlspecialchars($formation['category_slug']) ?>" class="badge bg-primary text-decoration-none mb-2">
                            <?= $formation['category_icon'] ?> <?= htmlspecialchars($formation['category_name']) ?>
                        </a>
                    <?php endif; ?>
                    
                    <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($formation['title']) ?></h1>
                    
                    <p class="lead text-muted"><?= htmlspecialchars($formation['description']) ?></p>
                    
                    <?php if (!empty($formation['article_slug'])): ?>
                        <div class="mb-4">
                            <a href="/blog/<?= htmlspecialchars($formation['article_slug']) ?>" class="btn btn-outline-info">
                                <i class="bi bi-file-text"></i> Lire l'article associé
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="d-flex gap-4 mb-4 flex-wrap">
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
                    <div class="alert alert-success mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-check-circle-fill"></i> Vous êtes inscrit à cette formation
                                <?php if ($progress && $progress['progress'] > 0): ?>
                                    <div class="progress mt-2" style="height: 8px;">
                                        <div class="progress-bar" style="width: <?= $progress['progress'] ?>%"></div>
                                    </div>
                                    <small class="text-muted"><?= $progress['progress'] ?>% complété</small>
                                <?php endif; ?>
                            </div>
                            <a href="/formations/<?= htmlspecialchars($formation['slug']) ?>/learn" class="btn btn-primary">
                                <i class="bi bi-play-circle"></i> Continuer
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Programme de la formation -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-check"></i> Programme de la formation</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($formation['modules'])): ?>
                            <div class="accordion" id="modulesAccordion">
                                <?php foreach ($formation['modules'] as $index => $module): ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" type="button" 
                                                    data-bs-toggle="collapse" data-bs-target="#module<?= $module['id'] ?>">
                                                <strong>Module <?= $index + 1 ?> : <?= htmlspecialchars($module['title']) ?></strong>
                                                <?php if (!empty($module['duration'])): ?>
                                                    <span class="badge bg-secondary ms-2"><?= $module['duration'] ?> min</span>
                                                <?php endif; ?>
                                            </button>
                                        </h2>
                                        <div id="module<?= $module['id'] ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" 
                                             data-bs-parent="#modulesAccordion">
                                            <div class="accordion-body">
                                                <?php if (!empty($module['lessons'])): ?>
                                                    <ul class="list-group list-group-flush">
                                                        <?php foreach ($module['lessons'] as $lesson): ?>
                                                            <li class="list-group-item">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <i class="bi bi-play-circle text-primary"></i>
                                                                        <?= htmlspecialchars($lesson['title']) ?>
                                                                    </div>
                                                                    <?php if (!empty($lesson['duration'])): ?>
                                                                        <span class="text-muted small"><?= $lesson['duration'] ?> min</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                <?php else: ?>
                                                    <p class="text-muted mb-0">Aucune leçon disponible pour ce module.</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0">Le programme sera bientôt disponible.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Ce que vous allez apprendre -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-lightbulb"></i> Ce que vous allez apprendre</h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        $objectives = [];
                        if (!empty($formation['objectives'])) {
                            $objectives = json_decode($formation['objectives'], true);
                        }
                        
                        // Si pas d'objectifs définis, générer des objectifs génériques
                        if (empty($objectives)) {
                            $formationTitle = str_replace('Formation ', '', $formation['title']);
                            $objectives = [
                                "Maîtriser les fondamentaux de " . strtolower($formationTitle),
                                "Comprendre les meilleures pratiques et techniques avancées",
                                "Mettre en place des stratégies efficaces et mesurables",
                                "Éviter les erreurs courantes et optimiser vos résultats",
                                "Utiliser les outils professionnels recommandés",
                                "Appliquer vos connaissances sur des cas concrets"
                            ];
                        }
                        ?>
                        
                        <?php if (!empty($objectives)): ?>
                            <div class="row">
                                <?php foreach ($objectives as $index => $objective): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-shrink-0">
                                                <div class="icon-circle bg-success bg-opacity-10 p-2">
                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0"><?= htmlspecialchars($objective) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="alert alert-info mt-3 mb-0">
                                <i class="bi bi-info-circle"></i> 
                                <strong>Durée :</strong> <?= $formation['duration_hours'] ?> heures • 
                                <strong>Niveau :</strong> <?= ucfirst($formation['level']) ?> • 
                                <strong>Accès :</strong> Illimité à vie
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Formations liées -->
                <?php if (!empty($relatedFormations)): ?>
                    <section class="mb-4">
                        <h3 class="mb-4">Formations similaires</h3>
                        <div class="row g-3">
                            <?php foreach ($relatedFormations as $related): ?>
                                <div class="col-md-4">
                                    <div class="card shadow-sm hover-lift h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <a href="/formations/<?= htmlspecialchars($related['slug']) ?>" class="text-dark text-decoration-none">
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
                
                <!-- Avis et notation -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning bg-opacity-10">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-star-fill text-warning"></i> Avis des apprenants</h5>
                            <?php if (!empty($averageRating) && $averageRating['count'] > 0): ?>
                                <div>
                                    <span class="fw-bold fs-4"><?= number_format($averageRating['average'], 1) ?></span>
                                    <span class="text-muted">/5</span>
                                    <small class="text-muted d-block"><?= $averageRating['count'] ?> avis</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($reviews)): ?>
                            <?php foreach ($reviews as $review): ?>
                                <div class="border-bottom pb-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong><?= htmlspecialchars($review['username']) ?></strong>
                                            <div class="text-warning small">
                                                <?php for ($s = 1; $s <= 5; $s++): ?>
                                                    <i class="bi bi-star<?= $s <= $review['rating'] ? '-fill' : '' ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <small class="text-muted"><?= date('d/m/Y', strtotime($review['created_at'])) ?></small>
                                    </div>
                                    <?php if (!empty($review['title'])): ?>
                                        <h6 class="mt-2 mb-1"><?= htmlspecialchars($review['title']) ?></h6>
                                    <?php endif; ?>
                                    <?php if (!empty($review['comment'])): ?>
                                        <p class="text-muted mb-0 small"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center mb-0">Aucun avis pour le moment. Soyez le premier !</p>
                        <?php endif; ?>

                        <?php if ($isEnrolled && empty($userReview)): ?>
                            <hr>
                            <h6 class="fw-bold"><i class="bi bi-pencil-square"></i> Laisser un avis</h6>
                            <form method="POST" action="/formations/<?= $formation['id'] ?>/review">
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Note</label>
                                    <div class="d-flex gap-1" id="ratingStars">
                                        <?php for ($s = 1; $s <= 5; $s++): ?>
                                            <label style="cursor: pointer; font-size: 1.5rem;">
                                                <input type="radio" name="rating" value="<?= $s ?>" class="d-none" <?= $s === 5 ? 'checked' : '' ?>>
                                                <i class="bi bi-star<?= $s <= 5 ? '-fill' : '' ?> text-warning rating-star" data-value="<?= $s ?>"></i>
                                            </label>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="title" class="form-control form-control-sm" placeholder="Titre de votre avis" maxlength="100">
                                </div>
                                <div class="mb-3">
                                    <textarea name="comment" class="form-control form-control-sm" rows="3" placeholder="Votre commentaire..." maxlength="1000"></textarea>
                                </div>
                                <button type="submit" class="btn btn-warning btn-sm w-100">
                                    <i class="bi bi-send"></i> Publier mon avis
                                </button>
                            </form>
                            <script>
                            document.querySelectorAll('.rating-star').forEach(function(star) {
                                star.addEventListener('click', function() {
                                    var val = parseInt(this.dataset.value);
                                    document.querySelectorAll('.rating-star').forEach(function(s, i) {
                                        s.className = 'bi bi-star' + ((i + 1) <= val ? '-fill' : '') + ' text-warning rating-star';
                                    });
                                    this.closest('label').querySelector('input').checked = true;
                                });
                            });
                            </script>
                        <?php elseif (!empty($userReview)): ?>
                            <hr>
                            <div class="alert alert-info small mb-0">
                                <i class="bi bi-check-circle"></i> Vous avez déjà laissé un avis 
                                (<?= $userReview['rating'] ?>/5)
                                <?php if ($userReview['status'] === 'pending'): ?>
                                    — <em>En attente de modération</em>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Prix et inscription -->
                <div class="card shadow-sm mb-4 border-primary">
                    <div class="card-body text-center">
                        <h3 class="text-primary mb-3"><?= number_format($formation['price'], 2) ?> €</h3>
                        
                        <?php if (!$isEnrolled): ?>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <form action="/formations/enroll/<?= $formation['id'] ?>" method="POST">
                                    <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                                        <i class="bi bi-box-arrow-in-right"></i> S'inscrire maintenant
                                    </button>
                                </form>
                            <?php else: ?>
                                <a href="/connexion" class="btn btn-primary btn-lg w-100 mb-3">
                                    <i class="bi bi-box-arrow-in-right"></i> Se connecter pour s'inscrire
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="/formations/<?= htmlspecialchars($formation['slug']) ?>/learn" class="btn btn-success btn-lg w-100 mb-3">
                                <i class="bi bi-play-circle"></i> Accéder à la formation
                            </a>
                        <?php endif; ?>
                        
                        <p class="text-muted small mb-0">
                            <i class="bi bi-shield-check"></i> Accès illimité à vie
                        </p>
                    </div>
                </div>
                
                <!-- Cette formation inclut -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-gift"></i> Cette formation inclut</h6>
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <i class="bi bi-clock text-primary"></i> <?= $formation['duration_hours'] ?> heures de vidéo
                        </div>
                        <div class="list-group-item">
                            <i class="bi bi-file-earmark-text text-primary"></i> Ressources téléchargeables
                        </div>
                        <div class="list-group-item">
                            <i class="bi bi-infinity text-primary"></i> Accès illimité à vie
                        </div>
                        <div class="list-group-item">
                            <i class="bi bi-award text-primary"></i> Certificat de fin de formation
                        </div>
                        <div class="list-group-item">
                            <i class="bi bi-headset text-primary"></i> Support et assistance
                        </div>
                    </div>
                </div>
                
                <!-- Partage social -->
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="mb-3">Partager cette formation</h6>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://digita-marketing.local/formations/' . $formation['slug']) ?>"
                               target="_blank" class="btn btn-primary btn-sm" rel="noopener noreferrer">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?= urlencode('http://digita-marketing.local/formations/' . $formation['slug']) ?>&text=<?= urlencode($formation['title']) ?>"
                               target="_blank" class="btn btn-info btn-sm text-white" rel="noopener noreferrer">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode('http://digita-marketing.local/formations/' . $formation['slug']) ?>"
                               target="_blank" class="btn btn-primary btn-sm" rel="noopener noreferrer">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
